<?php
/* @var $this PersonsController */
/* @var $data Persons */
require_once('Numbers/Words/Locale/ru.php');

/*
 * Подготовка данных
 */
$case = $data->cases3;
$person = $case->person0;
$calc = Calculator::calcPension($case->id, false); //pp($calc);

$seniorities_y = array();
if (isset($person->seniorities)) {
    foreach($person->seniorities as $seniority) {
        if ($seniority->type == "y") {
            $seniorities_y[$seniority->class] = $seniority->value;
        }
    }
} //print_r($seniorities_y);

/*
 * Подготовка представлений данных
 */
$caption = 'ИСЧИСЛЕНИЕ ПЕНСИИ';
if ($case->type == 'ВЛ') {
    $caption .= " <br/>за выслугу лет";
}

$seniorities_a = array('общая', (int)$seniorities_y['common'], 'календарная', (int)$seniorities_y['calendar'], 'льготная', (int)$seniorities_y['privilege'], 'в МВД', (int)$seniorities_y['mia']);

function money($value) {
    return number_format($value, 2, '.', ''); 
}

function moneyInRussianWords($money) { //die();
    //require_once('Numbers/Words/lang.ru.php');
    require_once('Numbers/Words/Locale/ru.php');        

    list($decimal, $fractional) = explode('.', (string) $money, 2); 
    $fractional = str_pad($fractional, 2, '0', STR_PAD_RIGHT); // NOTE: Без этого нельзя использовать $fractional, поскольку для копеек делящихся на 10 отбрасывается ноль.

    $numStr = new Numbers_Words_Locale_ru;
    return ($numStr->toCurrencyWords($numStr->def_currency, $decimal, $fractional));// . " ($money-$decimal-$fractional)";
}

// Получение даты формата xx месяца yyyy г.
$months = array('января', 'декабря', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'); 
$a = explode('-', date('Y-m-d'));
$rusLongDate = $a[2] . ' ' . $months[(int)$a[1] - 1] . ' ' . $a[0] . ' г.';

// Получение адресной строки
$a0 = array();
if ($person->addrs->house) {
    $a0[] = $person->addrs->house;
}
if ($person->addrs->body) {
    $a0[] = $person->addrs->body;
}
if ($person->addrs->apartment) {
    $a0[] = $person->addrs->apartment;
}
$houseStr = implode('-', $a0);
$a = array();
if ($person->addrs->post_index) {
    $a[] = $person->addrs->post_index;
}
if ($person->addrs->town) {
    $a[] = $person->addrs->town;
}
if ($person->addrs->street) {
    $a[] = $person->addrs->street;
}
if ($houseStr) {
    $a[] = $houseStr;
}
$addrStr = implode(', ', $a); 

// Год перерасчета
$loTmp = explode('-', $calc['calc_date']);
$calc_year =$calc['calc_date'] ? $loTmp[0] : date('Y');
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">

	<!--link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"  -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/_view.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<div class="isch">
<table>
 <thead>
  <tr>
   <td colspan="2">
        Пенсионное дело <?php echo $case->comm0->code;?> <?php echo $case->number;?>
        ГРВК:<?php echo $case->comm0->name;?>
        <br/><?php echo $person->second_name . ' ' . $person->first_name . ' ' . $person->third_name;?>
   </td>
  </tr>
  <tr>
   <td colspan="2" style="text-align: center; padding-bottom: 10px;">
    <?php echo $caption;?>
   </td>
  </tr>
  <tr>
   <td colspan="2" style="text-align: center; padding-bottom: 10px;">
    Перерасчет с <?php echo Calculator::date($case->calc_date);?>
   </td>
  </tr>
  <tr>
   <td colspan="2" style="text-align: center;">
    <table style="width:100%; xborder: solid 1px red;">
     <tr>
      <td style=""><div style="border-bottom: 1px black dashed; margin-top:-8px;">&nbsp;</div></td>
      <td width="1px"><nobr>основание перерасчета</nobr></td>
      <td style=""><div style="border-bottom: 1px black dashed; margin-top:-8px;">&nbsp;</div></td>
     </tr>
    </table>
   </td>
  </tr>
 </thead>
 <tbody>
  <tr>
   <td colspan="2">Пенсия переназначена с <?php echo $case->calc_date;?> (бессрочно) из окладов ДС: 
    <br> (размер социальной пенсии: <?php echo $calc['TPS'];?>)
   </td>
  </tr>
  <tr>
   <td class="label money">- должностной оклад (код <?php echo $case->code_tr;?>)</td>
   <td>: <?php echo money($case->salary_post);?></td>   
  </tr>
  <tr>
   <td class="label money">- оклад по в/званию (<?php echo $person->rank0->name?>)</td>
   <td>: <?php echo money($case->salary_rank);?></td>   
  </tr>
  <tr>
   <td class="label money">- процентная надбавка за в/лет (<?php echo $case->year_inc_percent;?>%)</td>
   <td>: <?php echo money($calc['NADB']);?></td>   
  </tr>
  <tr>
   <td class="label money">- ВСЕГО</td>
   <td>= <?php echo money($calc['COMMON']);?></td>   
  </tr>
  <tr>
   <td class="label money">учитывается при исчислении пенсии в <?php echo $calc_year;?> году (<?php echo $calc['OODS'] * 100;?>%)</td>
   <td>= <?php echo money($calc['nachODS']);?></td>   
  </tr>
  <tr>
   <td class="label money">Основной размер пенсии <?php echo $calc['RAZPEN'];?>% (выслуга <?php echo $seniorities_y['common'];?> лет)</td>
   <td>= <?php echo money($calc['OSNPR']);?></td>   
  </tr>
  <?php
   $val = $calc['OSNPR'];
   foreach ($calc['markups'] as $k => $v) { 
       if (!$v) {
           continue;
       }
       $val += $v;
       ?>
  <tr>
   <td class="label money"><?php echo ($calc['markups_names'][$k] . " + " . money($v)); ?></td>
   <td><?php echo money($val);?></td>   
  </tr>
  <?php }?>
  <tr>
   <td colspan="2" style="text-align: center;">Размер пособия на погребение <?php echo money($calc['RESULT'] * 3);?></td>
  </tr>
  
 </tbody>
</table>

<div style="text-align: center; line-height:12px; padding-top: 10px;">
Начальник отдела социального и финансового обеспечения
<br>Помощник начальника отдела  С И Ф О
</div>

<div>
    <?php echo $rusLongDate;?>
</div>

<table style="width:100%; xborder: solid 1px red;">
 <tr>
  <td style="" colspan="3"><br/><div style="border-top: 1px black dashed; margin-top:-8px;">&nbsp;</div><br/></td>
 </tr>
</table>


</div>
</body>
</html>
