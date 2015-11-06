<?php

/**
 * Класс Helper.
 * Класс предназначен для облегчения преобразования/трансляции данных в нужный формат . Возможно увеличение его области применения .
 */
class Helper{
	public static $helper_id = 0;
	private static $month_rus_genitive = array( 1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля', 5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа', 9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря' );

	/**
	 * Функция HelperPrintR выводит данные переменной на html страничку в форматированном виде
	 * @param var $poValue произвольная переменная
	 * @param string $psValueName наименование, отличительная черта данного вывода
	 * @return null
	 */
	public static function HelperPrintR( $poValue, $psValueName = '' ){
		mb_internal_encoding( 'UTF-8' );
		echo '<pre>HelperPrintR ---===' . $psValueName . '===---';
		print_r( $poValue );
		echo '</pre>';
	}

	/**
	 * Функция HelperDateToGerman преобразует стандартную цифровую дату в дату German образца, например 22-04-2014 => 22.04.2014
	 * @param string $psDataDigital цифровая дата с разделителями "."
	 * @return string дата
	 */
	public static function HelperDateToGerman( $psDataDigital ){
		mb_internal_encoding( 'UTF-8' );
		$lsReturn = $psDataDigital;
		$lsReturn = mb_ereg_replace('^[\ ]+', '', $lsReturn );
		if ( isset( $laMatches ) ) unset( $laMatches );
		preg_match( "/([0-9]{1,2})[^0-9]+([0-9]{1,2})[^0-9]+([0-9]{4})/", $lsReturn, $laMatches);
		if ( $laMatches && count( $laMatches ) > 3 ){
			$lsReturn = $laMatches[ 1 ] . '.' . $laMatches[ 2 ] . '.' . $laMatches[ 3 ];
		}
		preg_match( "/([0-9]{4})[^0-9]+([0-9]{1,2})[^0-9]+([0-9]{1,2})/", $lsReturn, $laMatches);
		if ( $laMatches && count( $laMatches ) > 3 ){
			$lsReturn = $laMatches[ 3 ] . '.' . $laMatches[ 2 ] . '.' . $laMatches[ 1 ];
		}
		return $lsReturn;
	}

	/**
	 * Функция HelperDateRusCreate преобразует стандартную цифровую дату в дату русского образца, например 22.04.2014 => 22 апреля 2014
	 * @param string $psDataDigital цифровая дата с произвольными разделителями
	 * @return string дата
	 */
	public static function HelperDateRusCreate( $psDataDigital ){
		mb_internal_encoding( 'UTF-8' );
		$lsReturn = trim( $psDataDigital );
		$lsReturn = Helper::HelperDateToGerman( $psDataDigital );
		$laTmp = explode( '.', $lsReturn );
		$lsReturn = $laTmp[0] . ' ' . Helper::$month_rus_genitive[ intval( $laTmp[1] ) ] . ' ' . $laTmp[2];
		return $lsReturn;
	}

	/**
	 * Функция HelperModuleList возвращает полное наименование выпадающих списков для определённого модуля
	 * @param string $psModuleName - наименование модуля
	 * @param string $psListShortName - сокращённое наименование списка/код
	 * @return string name
	 */
	public static function HelperModuleList( $psModuleName, $psListShortName ){
		mb_internal_encoding( 'UTF-8' );
		$lsReturn = '';
		$laTableSootv = array(
			'pension_type' => array(
				'' => 'за ""', 'ВЛ' => 'за выслугу лет', 'ПК' => 'по случаю потере кормильца', 'СП' => 'по социальному пособию', 'ИН' => 'по инвалидности', 'ВЗ' => 'по воинскому званию', 'ВВ' => 'по возмещению вреда здоровью'
			)
			, 'seniorities_class' => array(
				'' => 'хз', 'common' => 'общая', 'study' => 'период обучения', 'calendar' => 'календарная', 'privilege' => 'льготная', 'pension' => '', 'mia' => 'МВД'
			)
			, 'death_type' => array(
				'' => '', '0' => 'не связана с исполнением обязанностей в/службы', '1' => 'связана с исполнением обязанностей в/службы'
			)
		);
		$lsReturn = $laTableSootv[ $psModuleName ][ $psListShortName ];
		return $lsReturn;
	}

	/**
	 * Функция HelperZeroValue возвращает 0 во всяких разных не числовых случаях
	 * @param string $psValue - наименование модуля
	 * @return integer
	 */
	public static function HelperZeroValue( $psValue = 0 ){
		$lsReturn = '';
		$lsReturn = trim( $psValue );
		if ( !$lsReturn ) $lsReturn = 0;
		return $lsReturn;
	}

	/**
	 * Функция HelperDissmissCodeValue возвращает разбор сокращённого написания ссылки на закон
	 * @param string $psCode - сокращённое написание ссылки на закон
	 * @return string строка расшифровка, например "статья 48 пункт  A подпункт   абзац "
	 */
	public static function HelperDissmissCodeValue( $psCode, $pbDative = false ){
		mb_internal_encoding( 'UTF-8' );
		$lsReturn = '';
		$psCode = trim( $psCode );
		$psCode = mb_ereg_replace('^[\ ]+', '', $psCode );
		//echo '+++' . $psCode . '+++<br>';

		$lsReturn .= ( $pbDative ? Helper::HelperWordRusCreateDative( 'статья', false ) : 'статья' ) . ' ' . trim( mb_substr( $psCode, 0, 2 ) );
		$lsReturn .= ' ' . ( $pbDative ? Helper::HelperWordRusCreateDative( 'пункт', true ) : 'пункт ' ) . ' ' . ( mb_substr( $psCode, 2, 1 ) ? trim( mb_substr( $psCode, 2, 1 ) ) : '&nbsp;&nbsp;' );
		$lsReturn .= ' ' . ( $pbDative ? Helper::HelperWordRusCreateDative( 'подпункт', true ) : 'подпункт' ) . ' ' . ( mb_substr( $psCode, 3, 1 ) ? trim( mb_substr( $psCode, 3, 1 ) ) : '&nbsp;&nbsp;' );
		$lsReturn .= ' ' . ( $pbDative ? Helper::HelperWordRusCreateDative( 'абзац', true ) : 'абзац' ) . ' ' . ( mb_substr( $psCode, 4, 2 ) ? trim( mb_substr( $psCode, 4, 2 ) ) : '&nbsp;&nbsp;' );
		return $lsReturn;
	}

	public static function HelperMorphSum($n, $f1, $f2, $f5){
		mb_internal_encoding( 'UTF-8' );
		$n = abs(intval($n)) % 100;
		if ($n>10 && $n<20) return $f5;
		$n = $n % 10;
		if ($n>1 && $n<5) return $f2;
		if ($n==1) return $f1;
		return $f5;
	}

	/**
	 * Функция HelperSumInWords возвращает сумму прописью
	 * @param string $pnSum - наименование модуля
	 * @param boolean $pbIsCash - добавление рублей и копеек
	 * @return string
	 */
	public static function HelperSumInWords( $pnSum, $pbIsCash = true ){
		mb_internal_encoding( 'UTF-8' );
		$lsReturn = '';
		$nul='ноль';
		$ten=array(
			array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
			array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
		);
		$a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
		$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
		$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
		$unit=array( // Units
			array('копейка' ,'копейки' ,'копеек',	 1),
			array('рубль'   ,'рубля'   ,'рублей'    ,0),
			array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
			array('миллион' ,'миллиона','миллионов' ,0),
			array('миллиард','милиарда','миллиардов',0),
		);

		list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($pnSum)));
		$out = array();
		if (intval($rub)>0) {
			foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
				if (!intval($v)) continue;
				$uk = sizeof($unit)-$uk-1; // unit key
				$gender = $unit[$uk][3];
				list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
				// mega-logic
				$out[] = $hundred[$i1]; # 1xx-9xx
				if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
				else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
				// units without rub & kop
				if ($uk>1) $out[]= Helper::HelperMorphSum($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
			} //foreach
		}
		else $out[] = $nul;
		$out[] = Helper::HelperMorphSum(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
		$out[] = $kop.' '.Helper::HelperMorphSum($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
		$lsReturn = trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
		return $lsReturn;
	}

	/**
	 * Функция HelperSetBooleanVal преобразует произвольное текстовое значение в булево значение
	 * @param string $psVar произвольное текстовое значение
	 * @return boolean
	 */
	public static function HelperSetBooleanVal( $psVar = '' ){
		mb_internal_encoding( 'UTF-8' );
		$psVar = trim( strtolower( $psVar ) );
		switch ($psVar){
			case 't':
			case 'true':
			case '1':
			case 'on':
			case 'checked':
			case 'selected':
			case 'истина':
				return true;
			default:
				return false;
		}
		return false;
	}

	/**
	 * Функция HelperSetBooleanVal преобразует произвольное текстовое значение в булево значение
	 * @param string $psVar произвольное текстовое значение
	 * @return string
	 */
	public static function HelperNumberFormatMoney( $pnVar ){
		return number_format( $pnVar, 2, '.', '' );
	}


	/**
	 * Функция HelperFIORusCreateDative преобразует стандартное ФИО в дательный падеж, например Акимов Евгений Вячеславович => Акимову Евгению Вячеславовичу
	 * @param string $psFIO ФИО с разделителями пробелами
	 * @return string ФИО в дательном падеже
	 */
	public static function HelperFIORusCreateDative( $poModelPerson ){
		mb_internal_encoding( 'UTF-8' );
		// Разделение мужчины и женщины происходит по окончанию на букву "а" в отчестве . У женщин считем всегда окончание на "а".
		$lsReturn = $poModelPerson->second_name . ' ' . $poModelPerson->first_name . ' ' . $poModelPerson->third_name;
		//echo '===' . $lsReturn . '===<br>';
		$laSqlResultDative = Yii::app()->db->createCommand( 'SELECT get_dative_fio( \'' . $poModelPerson->second_name . '\', \'' . $poModelPerson->first_name . '\', \'' . $poModelPerson->third_name . '\' ) AS fio' )->queryAll();
		if ( $laSqlResultDative && count( $laSqlResultDative ) > 0 ) $lsReturn = $laSqlResultDative[0][ 'fio' ];
		return $lsReturn;
	}

	/**
	 * Функция HelperWordRusCreateDative преобразует стандартное Слово в дательный падеж
	 * @param string $psWord Слово
	 * @return string Слово в дательном падеже
	 */
	public static function HelperWordRusCreateDative( $psWord, $pbMan = true ){
		mb_internal_encoding( 'UTF-8' );
		// Разделение мужчины и женщины происходит по окончанию на букву "а" в отчестве . У женщин считем всегда окончание на "а".
		$lsReturn = trim( $psWord );
		$laSqlResultDative = Yii::app()->db->createCommand( 'SELECT LOWER( get_dative_word( \'' . $lsReturn . '\', \'' . ( $pbMan ? 'TRUE' : 'FALSE' ) . '\' ) ) AS word' )->queryAll();
		if ( $laSqlResultDative && count( $laSqlResultDative ) > 0 ) $lsReturn = $laSqlResultDative[0][ 'word' ];
		return $lsReturn;
	}

	/**
	 * Функция HelperMbUCFirst преобразует первый символ в верхний регистр
	 * @param string $psVar произвольное текстовое значение
	 * @param string $psEncoding кодировка текста
	 * @return string
	 */
	public static function HelperMbUCFirst( $psVar, $psEncoding='UTF-8' ){
		$lsReturn = trim( $psVar );
		$lsReturn = mb_ereg_replace('^[\ ]+', '', $lsReturn );
		$lsReturn = mb_strtoupper( mb_substr( $lsReturn, 0, 1, $psEncoding ), $psEncoding ) . mb_substr( $lsReturn, 1, mb_strlen( $lsReturn ), $psEncoding );
		return $lsReturn;
	}

	/**
	 * Функция HelperFormatMoneyShort разбивает сумму на рубли и копейки, делает вывод в формате 26106,95 => 26106 руб. 95 коп.
	 * @param string $pnVar сумма , числовое значений
	 * @return string
	 */
	public static function HelperFormatMoneyShort( $pnVar ){
		$lsReturn = trim( $pnVar );
		$lsReturn = mb_ereg_replace('^[\ ]+', '', $lsReturn );
		$lsReturn = mb_ereg_replace('[\.,]+', ' руб. ', $lsReturn ) . ' коп.';
		return $lsReturn;
	}

}

if ( $_POST && $_POST[ 'helper_exec_func' ] ){
	echo Helper::$_POST[ 'helper_exec_func' ]( $_POST[ 'helper_func_param1' ] );
}
