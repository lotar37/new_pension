<?php
function pp($var, $die = false) {
    echo "<pre>"; print_r($var); echo "</pre>";
    if ($die) {
        die();
    }
}
class Calculator {
    /**
     * Преобразовать дату из формата ISO в русский вариант
     * @param string $iso YYYY-MM-DD HH:II:SS
     * @return string без времени DD.MM.YYYY 
     */
    public static function date($iso) {
        $iso = trim($iso);
        if (!$iso) {
            return null;
        }
        list($date_ISO) = explode(' ', $iso);
        return implode('.', array_reverse(explode('-', $date_ISO)));
    }
    /**
     * Преобразовать дату из русского формата в ISO-формат
     * @param string $rusDate DD.MM.YYYY
     * @return string $iso YYYY-MM-DD
     */
    public static function convertDateToISO($rusDate) {
        $rusDate = trim($rusDate);
        if (!$rusDate) {
            return null;
        }
        return implode('-', array_reverse(explode('.', $rusDate)));
    }
    /**
     * Получить полную матрицу данных
     * @param string $sql
     * @return array [<index>][<field>] => <value>
     */
    public static function getAll($sql) {
        return Yii::app()->db->createCommand($sql)->query()->readAll();
    }
    /**
     * Выполнить произвольный запрос
     * @param string $query
     * @return mixed
     */
    public static function runQuery($query) {
        $connection=Yii::app()->db;
        $command = $connection->createCommand($query);
        return $command->query();
    }
    /**
     * Получить строку таблицы
     * @param string $sql
     * @return array [<field>] => <value>
     */
    public static final function getRow($sql) {
        $data = self::getAll($sql);
        return $data[0]; 
    }
    /**
     * Получить значение поля таблицы
     * @param string $sql
     * @return mixed
     */
    public static final function getOne($sql) {
        return current(self::getRow($sql)); 
    }
    /**
     * Получить значения столбца таблицы
     * @param string $sql
     * @return array
     */
    public static final function getCol($sql) {
        $result = array();
        foreach (self::getAll($sql) as $row) {
            $result[] = current($row);
        }
        return $result; 
    }
    /**
     * Получить ассоциативную матрицу таблицы
     * @param string $sql
     * @return array для кол-ва полей > 2 array[<first-field-value>][<field>] => <value> 
     *               для кол-ва полей = 2 array[<first-field-value>] => <second-field-value>
     */
    public static final function getAssoc($sql) {
        $result = array();
        $data = self::getAll($sql); //print_r($sql); die();
        $row = current($data);
        if (!$row) {
            return array();
        }
        $fields = array_keys($row);
        if (count($fields) == 2) {
            foreach ($data as $v) {
                $result[$v[$fields[0]]] = $v[$fields[1]];
            }
        } else {
            $fkey = $fields[0];
            unset($fields[0]);
            foreach ($data as $v) {
                $key = $v[$fkey]; 
                unset($v[$fkey]);
                $result[$key] = $v; 
            }
        }
        return $result; 
    }
    
    /**
     * Расчитать размер пенсии
     * @param int $caseID Идентификатор карточки
     * @param bool $now Признак пересчета на текущую дату
     * @return array Параметры расчета
     */
    public static function calcPension($caseID, $now = false) {
        $date = self::getOne("select now()::date");
        if (!$now) {
            $tmp = self::getOne("select calc_date::date FROM cases WHERE id = {$caseID}");
            if ($tmp) {
                $date = $tmp;
            }
        } //print_r($date);
        return self::_calcPension($caseID, $date);
    }
    /**
     * Пересчитать пенсию
     * @param unknown $caseID
     * @param unknown $params array(date)
     */
    public static function recalcPension($caseID, $params) { //print_r($params); die();
        //print_r($caseID); die();
        $result = self::_calcPension($caseID, $params['date']); //print_r($result);
        $value = $result['RESULT'];

        self::runQuery("UPDATE cases SET saved_summa = '$value' WHERE id = {$caseID}");
        self::runQuery("INSERT INTO calcs (
            \"case\", basis_doc, time, value, calc_group) 
            VALUES (
            {$caseID}, 
            {$params['basicDocID']}, 
            '{$params['date']}', 
            '$value',
            {$params['calcGroupID']}
            )");
    }
    /**
     * Эмулятор работы функции клиппера FindChr
     * @param string $where Где ищем вхождение
     * @param string $what Что ищем (частями)
     * @param number $step Шаг частей поиска
     * @return boolean
     */
    private static function _FindChr($where, $what, $step = 2) {
    //pravopen.and.('6'$nachWAR.or.FindChr('1а1б1г1д1е1ж2в',nachWAR,2)).and.(!Bit(APP,12).or.Bit(APP,8))
        for ($i = 0; $i < mb_strlen($what, 'UTF-8'); $i += $step) {
            $part = mb_substr($what, $i, $step, 'UTF-8');
            if (mb_stripos(" $where", $part, null, 'UTF-8')) {
                return true;
            }
        }
        return false;
    }
    /**
     * Эмулятор работы оператора обнаружения подстроки клиппера  типа ( '6'$nachWAR )
     * @param string $where Где ищем вхождение
     * @param string $what Что ищем
     * @return boolean
     */
    private static function _inStr($where, $what) {
        return mb_strpos(" $where", "$what", null, 'UTF-8') ? true : false;
    }
    /**
     * Получить количество лет разницы между 2-мя датами
     * @param string $date1 ISO
     * @param string $date2 ISO
     * @return int
     */
    private static function SrYear($date1, $date2) {
        return self::getOne("SELECT extract (year from age('{$date1}'::date, '{$date2}'::date))");
    }
    /**
     * @ignore
     */
    private static function _calcPension($caseID, $date, $recalc = false) {
        // Данные карточки
        $case_Row = self::getRow("SELECT * FROM cases WHERE id = {$caseID}"); //print_r($case_Row); echo "<hr>";
        // Данные человека
        $person_Row = self::getRow("SELECT * FROM persons WHERE id = {$case_Row['person']}"); // print_r($person_Row); //echo "<hr>"; die();
        // Коды участия в боевых действиях человека        
        $war_Actions = self::getCol("SELECT code FROM war_actions, person_war_actions AS pwa WHERE pwa.war_action = war_actions.id AND pwa.person = {$person_Row['id']}");
        // Коды участия в ликвидации последствий ЧАЭС у человека        
        $chaes = self::getCol("SELECT code FROM chaes, person_chaes AS pc WHERE pc.chae = chaes.id AND pc.person = {$person_Row['id']}");
//pp($chaes); die();        
        // Выслуги (лет)
        $seniorities_y = self::getAssoc("SELECT class, value FROM seniorities WHERE type = 'y' AND person = {$case_Row['person']}");

        // Определить SQL-дату перерасчета
        $dateSQL = $date ? ("'" . $date . "'") : ("'" . $case_Row['calc_date'] . "'");
        
        $CHAES = implode('', $chaes);
        $nachCHAES = $CHAES;
        
        $DUWOL = $person_Row['dismiss_date'];
        
        $R = array();
        $R['calc_date'] = $case_Row['calc_date'];
        
        // Считать актуальные параметры перерасчета
        // Ограничение окладов денежного содержания (на текущее время)
        $R['OODS'] = self::getOne("SELECT get_actual_param_value('OODS', $dateSQL)");
        $R['OODS'] = $R['OODS'] ? $R['OODS'] : 1; //$OODS = 0.56;
        
        // Базовая часть трудовой пенсии по старости
        $R['TPS'] = self::getOne("SELECT get_actual_param_value('U_TPS', $dateSQL)");
//echo "<pre>" . print_r($case_Row) . "</pre>"; //pp()
        // Для удобства понимания алгоритма действующей программы имена переменых названы в соответствии с названиями в программе
        // PENS->...
        $PENS = array(
            'VP' => $case_Row['type'], // Вид карточки
            'TRS' => $case_Row['include_seniority'] ? true : false, // Признак учета трудового стажа в выслуге лет
            'BISLOB' => $seniorities_y['common'], // Выслуга общая
        ); 
        // Дата перерасчета
        $R['DPER'] = $case_Row['calc_date'] ? $case_Row['calc_date'] : date('Y-m-d');
        // Дата рождения
        $R['DROD'] = $person_Row['birth_date'];
        // Оклад по должности
        $R['OKLD'] = $case_Row['salary_post']; //echo($OKLD); die();
        // Оклад по званию
        $R['OKLR'] = $case_Row['salary_rank']; //echo($OKLR); die();
        // Процент надбавки за выслугу лет        
        $R['NADBPR'] = $case_Row['year_inc_percent'];
        // Размер надбавки за выслугу лет
        $R['NADB'] = ($R['OKLD'] + $R['OKLR']) * $R['NADBPR'] / 100; //echo($NADB);  //"IF(VP$'СПВЗ',0.001,(OKLD+OKLR)*nachNADB/100)"
        // Всего
        $R['COMMON'] = $R['OKLD'] + $R['OKLR'] + $R['NADB'];
        // оклады из которых исчислена пенсия
        $R['nachODS'] = $R['COMMON'] * $R['OODS'];
        
        // Процент от размера пенсии ($OKLD + $OKLR + $NADB)
        $R['RAZPEN'] = null;
        if (!$PENS['TRS'] && $PENS['BISLOB'] >= 20) { // "!PENS->TRS.and.PENS->BISLOB>=20"   "Min(85,50+3*(BISLOB-20))"
            $R['RAZPEN'] = 50 + 3 * ($PENS['BISLOB'] - 20);
        }
        if ($PENS['TRS'] && $PENS['BISLOB'] >= 20) { // "PENS->TRS.and.PENS->BISLOB>=20"    "Min(85,50+BISLOB-25)"
            $R['RAZPEN'] = 50 + $PENS['BISLOB'] - 25;
        }
        if ($R['RAZPEN'] && $R['RAZPEN'] > 85) {
            $R['RAZPEN'] = 85;
        } 
        // Основной размер пенсии //"Many(RAZPEN*nachODS/100)"
        $R['OSNPR'] = $R['RAZPEN'] * $R['nachODS'] / 100; 
        
        // Право на пенсию иждивенца //IF(PENS->VP='ПК',Pravo_Igd(),IF(PENS->VP='ВЛ'.and.BISLOB<20,.F.,.t.))        
        $pravopen = false;
        if ($PENS['VP'] == 'ПК') {
            $pravopen = self::Pravo_Igd($case_Row);
        } 
        if ($PENS['VP'] == 'ВЛ') {
            $pravopen = $PENS['BISLOB'] >= 20;
        }

        // Переменная $STAT в поле NACH.STAT
        //1-ВЛ, 2-ИВ, 3-ПК, 4-ПК (для членов семьи)?, 5-Соц.пособия, 6-ОВЗ, ВОзмещение вреда здоровью?, 9-общее
        $tmp = array(
            'ВЛ' => 1,
            'ИВ' => 2,
            'ПК' => 3,
            //'ПК' => 4, //(для членов семьи)?
            //'Соц.пособия' => 5, 
            'ОВЗ' => 6,
            //'Общее' => 9,
        );
        $STAT = isset($tmp[$PENS['VP']]) ? $tmp[$PENS['VP']] : 0;

        // Надбавки
        $markups = array();
        
        $nachWAR = '';
        if (in_array($STAT, array(1,2,3))) {
            $nachWAR = implode('', $war_Actions);
        } 
        $WAR = $nachWAR;
        
        // Надбавка на уход достигшему 80 лет //"pravopen.and.SrYear(DPER,DROD)>=80"    "Many(TPS)"
        if ($pravopen && (self::SrYear($R['DPER'], $R['DROD']) >= 80)) {
            if ($R['TPS'] > $markups['r_uhod']) {
                $markups['r_uhod'] = $R['TPS'];
                $R['markups_names']['r_uhod'] = "надбавка на уход достигшему 80 лет";
            }
        } 
        
        // назначение инвалидности
        $R['NSINV'] = $person_Row['invalid_date'];
        // срок инвалидности
        $R['SRINV'] = $person_Row['invalid_date2'];
        // группа инвалидности
        $R['GRI'] = $person_Row['invalid_group'];
        // степень ограничения трудовой деятельности
        $R['SOTD'] = $person_Row['invalid_limit'];
        // код причины инвалидности
        if ($person_Row['invalid_reason']) {
    	    $R['PRINV'] = self::getOne("SELECT code FROM invalid_reasons WHERE id = {$person_Row['invalid_reason']}"); // print_r($person_Row); //echo "<hr>"; die();
        }
        
        
        // группа инвалидности с учетом с учетом ст.37 №213-ФЗ от 24.07.2009
        if (in_array($STAT, array(1, 2, 4))) {
             // IF(DateBef(PENS->DPER,SROKI),IF(GRI=1.or.((GRI=2.or.GRI=3).and.SOTD=3),1,IF(GRI=2.or.(GRI=3.and.SOTD=2),2,IF(GRI=3,3,0))),0)
             /*$R['nachGRI'] = (
                (!$R['SRINV'] || $R['DPER'] < $R['SRINV']) ? (
                    ($R['GRI'] == 1 || ($R['GRI'] == 2 || $R['GRI'] == 3)) ? 1 : (
                        ($R['GRI'] == 2 || ($R['GRI'] == 3 && $R['SOTD'] == 2)) ? 2 : (
                            ($R['GRI'] == 3) ? 3 : 0 
                            )
                        )
                    ) : 0  
                );*/
            if ($R['GRI'] == 1 || (($R['GRI'] == 2 || $R['GRI'] == 3) && $R['SOTD'] == 3)) {
                $R['nachGRI'] = 1;
            } elseif ($R['GRI'] == 2 || ($R['GRI'] == 3 && $R['SOTD'] == 3)) {
                $R['nachGRI'] = 2;
            } elseif ($R['GRI'] == 3) {
                $R['nachGRI'] = 3;
            } else {
                $R['nachGRI'] = 0;
            }
        }
        
        // увеличения инвалидам (участникам) войны (статья 16 Закона)
        $r_invw = array();
        // &" увеличение инвалиду ЧАЭС "+Str(GRI,1)+" группы"
        // PRINV='А'.and.(nachGRI=1.or.nachGRI=2.or.nachGRI=3).and.'2'$CHAES.and.(FindChr('34ПР',nachCHAES).or.DUWOL>ctod('26.04.1986'))
        // Many(TPS*IF(nachGRI=1,3,IF(nachGRI=2,2.5,1.75)) )
        if (in_array($STAT, array(1))) {
            $name = "увеличение инвалиду ЧАЭС {$R['GRI']} группы";
            if ($R['PRINV'] == 'А' && ($R['nachGRI'] == 1 || $R['nachGRI'] == 3) && self::_inStr($CHAES, '2') && (self::_FindChr('34ПР', $nachCHAES) || $DUWOL > '1986-04-26')) {
                $r_invw[$name] = $R['TPS'] * ($R['nachGRI'] == 1 ? 3 : ($R['nachGRI'] == 2 ? 2.5 : 1.75));
            }
        }
        
        // &" увеличение инвалиду войны "+Str(GRI,1)+" группы "+IF(GRI=nachGRI,'',Str(SOTD)+' СОТД')
        // !COURT->(dbFind(PENS->DELO,{|| EV421<>0 })).and.PRINV='А'.and.(nachGRI=1.or.nachGRI=2.or.nachGRI=3)        
        //Many(TPS*IF(nachGRI=1,3,IF(nachGRI=2,2.5,1.75)) )
        if (in_array($STAT, array(1))) {
            $name = "увеличение инвалиду войны {$R['GRI']} группы " . (($R['GRI'] == $R['nachGRI']) ? "" : ($R['SOTD'] ? ("(" . $R['SOTD'] . " СОТД)") : ""));
            if ($R['PRINV'] == 'А' && ($R['nachGRI'] == 1 || $R['nachGRI'] == 2 || $R['nachGRI'] == 3)) {
                $r_invw[$name] = $R['TPS'] * ($R['nachGRI'] == 1 ? 3 : ($R['nachGRI'] == 2 ? 2.5 : 1.75));
            }
        }
        
        // &" увеличение инв."+Str(GRI,1)+" гр."+IF(GRI=nachGRI,"","("+Str(SOTD)+" СОТД)")+"-участ.войны"
        // !COURT->(dbFind(PENS->DELO,{|| EV421<>0 })).and.!Empty(nachGRI).and.PRINV<>'А'.and.('6'$nachWAR.or.FindChr('1а1б1в1г1д1е1ж1и',nachWAR,2))
        // Many(TPS*IF(nachGRI=1,2.5,IF(nachGRI=2,2,1.5)) )
        if (in_array($STAT, array(1))) {
            $name = "увеличение инв. {$R['GRI']} гр." . (($R['GRI'] == $R['nachGRI']) ? "" : "(" . $R['SOTD'] . " СОТД)") . "-участ.войны";
            if (!$R['nachGRI'] && $R['PRINV'] <> 'А' && (self::_inStr($nachWAR, '6') || self::_FindChr('1а1б1в1г1д1е1ж1и', $nachWAR, 2))) {
                $r_invw[$name] = $R['TPS'] * ($R['GRI'] == 1 ? 2.5 : ($R['GRI'] == 2 ? 2 : 1.5));
            }
        }
               
        // &" увеличение инв."+Str(GRI,1)+" гр."+IF(GRI=nachGRI,"","("+Str(SOTD)+"СОТД)")+"-блокаднику"
        // !COURT->(dbFind(PENS->DELO,{|| EV421<>0 })).and.!Empty(nachGRI).and.PRINV<>'А'.and.!('6'$nachWAR.or.FindChr('1а1б1в1г1д1е1ж1и',nachWAR,2)).and.FindChr('3б',WAR,2).and.USTAN->U_DATAPER>=ctod('01.03.2008')
        // Many(TPS*IF(nachGRI=1,2,IF(nachGRI=2,1.5,1)))
        if (in_array($STAT, array(1))) {
            $name = "увеличение инв. {$R['GRI']} гр." . (($R['GRI'] == $R['nachGRI']) ? "" : "(" . $R['SOTD'] . " СОТД)") . "-блокаднику";
            if (!$R['nachGRI'] && $R['PRINV'] <> 'А' && !(self::_inStr($nachWAR, '6') || self::_FindChr('1а1б1в1г1д1е1ж1и', $nachWAR, 2)) && self::_FindChr('3б', $WAR, 2) && $date > '2008-03-01') {
                $r_invw[$name] = $R['TPS'] * ($R['GRI'] == 1 ? 2 : ($R['GRI'] == 2 ? 1.5 : 1));
            }
        }
        
        // Выбрать максимальное значение
        $value = 0;
        foreach ($r_invw as $name => $v) {
            if ($v > $value) {
                $value = $v;
                $markups['r_invw'] = $value;
                $R['markups_names']['r_invw'] = $name;
            }
        }
        
        
        // TODO: надбавки за работу в Зоне (службу в ПОР) (ст.30 "ЧАЭС")
        // NAME = &' '+arr_pev[1,1]
        // LOG = pravopen.and.!Empty(Arr_PEV(100)).and.Len(arr_pev)>=1.and.!Bit(APP,12)
        // RAZM = arr_pev[1,2]
        if (in_array($STAT, array(1,2,4))) {
            $name = '';
            if ($pravopen) {
                //$r_chaes[$name] = $R['TPS'] * ($R['GRI'] == 1 ? 2 : ($R['GRI'] == 2 ? 1.5 : 1));
            }
        }
        
        
        // ПОВЫШЕНИЯ ПЕНСИИ (ст.45 Закона)
        $r_puws = array();
        
        $name = " повышение ст.45 Закона (по суду)";
        //COURT->(dbFind(IGDIV->DELO,'RPUW<>0')) 
        //COURT->RPUW
        
        if (in_array($STAT, array(1, 2, 4))) {
            $name = "повышение участнику войны - ДА";
            //pravopen.and.('6'$nachWAR.or.FindChr('1а1б1г1д1е1ж2в',nachWAR,2)).and.(!Bit(APP,12).or.Bit(APP,8))
            //Many(TPS*0.32)
            if ($pravopen && (self::_inStr($nachWAR, '6') || self::_FindChr('1а1б1г1д1е1ж2в', $nachWAR)) ) {
                $r_puws[$name] = $R['TPS'] * 0.32;
            }
        }
        
        if (in_array($STAT, array(1, 2, 4))) {
            $name = "повышение в/наёмный состав ДА";
            //pravopen.and.FindChr('1в',nachWAR,2).and.(!Bit(APP,12).or.Bit(APP,8))
            //Many(TPS*0.32)
            if ($pravopen && self::_FindChr('1в', $nachWAR)) {
                $r_puws[$name] = $R['TPS'] * 0.32;
            }
        }
        
        if (in_array($STAT, array(1, 2, 4))) {
            $name = "повышение участнику обороны Ленинграда";
            //pravopen.and.FindChr('1и3а',nachWAR,2).and.PENS->DPER>=ctod('01.01.2002').and.(!Bit(APP,12).or.Bit(APP,8))
            //Many(TPS*0.32)
            if ($pravopen && self::_FindChr('1и3а', $nachWAR) && $R['DPER'] >= '2002-01-01') {
                $r_puws[$name] = $R['TPS'] * 0.32;
            }
        }
        
        if (in_array($STAT, array(2, 4))) {
            $name = "повышение блокаднику Ленинграда";
            //pravopen.and.'3'$nachWAR.and.(!Bit(APP,12).or.Bit(APP,8))
            //Many(TPS*0.32)
            if ($pravopen && self::_inStr($nachWAR, '3')) {
                $r_puws[$name] = $R['TPS'] * 0.32;
            }
        }
        
        if (in_array($STAT, array(1))) {
            $name = "повышение блокаднику Ленинграда";
            //pravopen.and.'3'$nachWAR.and.(!Bit(APP,12).and.!(!Empty(nachGRI).and.PRINV<>'А'))
            //Many(TPS*0.32)
            if ($pravopen && self::_inStr($nachWAR, '3') && (!empty($R['nachGRI']) && $R['PRINV'] <> 'А')) {
                $r_puws[$name] = $R['TPS'] * 0.32;
            }
        }
        
        if (in_array($STAT, array(1, 2, 4))) {
            $name = "повышение вып.задачи на СК с авг.1999 г.";
            //pravopen.and.'СК'$nachWAR.and.(!Bit(APP,12).or.Bit(APP,8))
            //Many(TPS*0.32)
            if ($pravopen && self::_inStr($nachWAR, 'СК')) {
                $r_puws[$name] = $R['TPS'] * 0.32;
            }
        }
        
        if (in_array($STAT, array(1, 2, 4))) {
            $name = "повышение прин.участие в ВК в Чечне";
            //pravopen.and.'Ч'$nachWAR.and.(!Bit(APP,12).or.Bit(APP,8))
            //Many(TPS*0.32)
            if ($pravopen && self::_inStr($nachWAR, 'Ч')) {
                $r_puws[$name] = $R['TPS'] * 0.32;
            }
        }
        
        if (in_array($STAT, array(1, 2, 4))) {
            $name = "повышение прин.участие в ВК в Чечне";
            //pravopen.and.'Ч'$nachWAR.and.(!Bit(APP,12).or.Bit(APP,8))
            //Many(TPS*0.32)
            if ($pravopen && self::_inStr($nachWAR, 'Ч')) {
                $r_puws[$name] = $R['TPS'] * 0.32;
            }
        }
        
        if (in_array($STAT, array(1, 2, 4))) {
            $name = "повышение вып.задачи в Южной Осетии";
            //pravopen.and.'8о'$nachWAR.and.(!Bit(APP,12).or.Bit(APP,8))
            //Many(TPS*0.32)
            if ($pravopen && self::_inStr($nachWAR, '8о')) {
                $r_puws[$name] = $R['TPS'] * 0.32;
            }
        }
        
        if (in_array($STAT, array(1, 2, 4))) {
            $name = "повышение вып.задачи в Абхазии";
            //pravopen.and.'8а'$nachWAR.and.(!Bit(APP,12).or.Bit(APP,8))
            //Many(TPS*0.32)
            if ($pravopen && self::_inStr($nachWAR, '8а')) {
                $r_puws[$name] = $R['TPS'] * 0.32;
            }
        }
        
        if (in_array($STAT, array(1, 2, 4))) {
            $name = "повышение участнику войны - не ДА";
            //pravopen.and.'1з'$nachWAR.and.(!Bit(APP,12).or.Bit(APP,8))
            //Many(TPS*0.16)
            if ($pravopen && self::_inStr($nachWAR, '1з')) {
                $r_puws[$name] = $R['TPS'] * 0.16;
            }
        }
        
        if (in_array($STAT, array(1, 2, 4))) {
            $name = "повышение за службу (работу) в тылу";
            //pravopen.and.('2'$nachWAR.or.'4'$WAR).and.(!Bit(APP,12).or.Bit(APP,8))
            //Many(TPS*0.16)
            if ($pravopen && (self::_inStr($nachWAR, '2') || self::_inStr($WAR, 4))) {
                $r_puws[$name] = $R['TPS'] * 0.16;
            }
        }
        
        if (in_array($STAT, array(1, 2, 4))) {
            $name = "повышение родившемуся до 31.12.1931 года";
            //pravopen.and.IF(Alias()='IGDIV',(!Empty(DRI).and.DRI<=CtoD('31.12.1931')),DROD<=CtoD('31.12.1931')).and.!Bit(APP,12)
            //Many(TPS*0.16)
            if ($pravopen && $person_Row['birth_date'] && $person_Row['birth_date'] <= '1931-12-31') {
                $r_puws[$name] = $R['TPS'] * 0.16;
            }
        }
        
        if (in_array($STAT, array(1, 2, 4))) {
            $name = "повышение участнику БД за границей";
            //pravopen.and.'5'$nachWAR.and.(!Bit(APP,12).or.Bit(APP,8))
            //Many(TPS*0.32)
            if ($pravopen && self::_inStr($nachWAR, '5')) {
                $r_puws[$name] = $R['TPS'] * 0.32;
            }
        }
        
        // Выбрать максимальное значение
        $value = 0;
        foreach ($r_puws as $name => $v) {
            if ($v > $value) {
                $value = $v;
                $markups['r_puw'] = $value;
                $R['markups_names']['r_puw'] = $name;
            }
        }
        
        
        //ПОВЫШЕНИЯ неработающим, проживающим в Зоне (ст18п6,19п3,20п4 "ЧАЭС")
        //$r_life1
        //$name = &' '+arr_pev[1,1]
        // log: pravopen.and.!Empty(Arr_PEV(101)).and.Len(arr_pev)>=1.and.!Bit(APP,12)
        // val: arr_pev[1,2]
        
        
        $R['RESULT'] = $R['OSNPR'];
        
        // Прибавление надбавок
        $R['markups_SUMMA'] = 0;
        foreach ($markups as $k => $v) {
            $R['markups_SUMMA'] += $v;
        }
        $R['RESULT'] += $R['markups_SUMMA'];
        
        $R['markups'] = $markups;
        $R['PENS'] = $PENS;
        //pp($R, 1);
        return $R;
    }
    
    /**
     * Получить список пенсионеров для которых в следующем месяце заканчиваются те или иные выплаты
     * @return array[$caseID][<field>] = <value>
     */
    public static function getCases_WithOverduePaymentsInNextMonth() {
        // Последние актуальные платежи (актуальный график платежей)
        $actualPayments_SQL = "
        SELECT p.* FROM payments AS p, payments_type AS t WHERE t.id = p.type
        AND p.id = (SELECT p2.id FROM payments AS p2 WHERE p2.case = p.case AND p2.type = p.type AND p.end_date IS NOT NULL AND t.period = 12 AND summa > 0 ORDER BY begin_date DESC LIMIT 1)
        AND ((p.end_date >= date_trunc('month', now()) + interval '1 month') AND (p.end_date < date_trunc('month', now()) + interval '2 month'))
        ";
        
        $query = "SELECT DISTINCT \"case\" FROM ({$actualPayments_SQL}) AS q";
        
        $data = array();
        foreach (self::getCol($query) as $caseID) {
            $row = self::getRow("SELECT persons.*, cases.type, cases.number FROM persons, cases WHERE cases.person = persons.id AND cases.id = {$caseID}");
            $data[$caseID] = $row;
        }

        return $data;
    }
    
    
    private static function Pravo_Igd($case_Row) {
    
    }
}