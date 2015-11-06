<?php
/**
 * Класс References.
 * Класс предназначен для печатных отчетов (пункт "Печать" в меню)
 */
class References extends CFormModel{
	public $references_id = 0;
	public $list_references = array();
	public $model_params;

	/**
	 * Функция References инициализирует модуль-класс References
	 * @param integer $pnReferencesId - id0 выбранного отчета
	 * @return null
	 */
	public function References( $pnReferencesId = 0 ){
		$this->references_id = $pnReferencesId;
		$this->list_references = array(
			array( 'id0'=>1		, 'name'=>'Списки в сбербанк'				, 'url'=>'/references/index'	)
			, array( 'id0'=>2		, 'name'=>'Выгрузка в сбербанк'			, 'url'=>'/references/index'	)
			//, array( 'id0'=>2	, 'name'=>'Списки 2'						, 'url'=>'/references/index'	)
			//, array( 'id0'=>3	, 'name'=>'Списки 3'						, 'url'=>'/references/index'	)
		);
		$this->model_params = array(
			'banks' => array()
			, 'salar' => array()
		);
	}

	/**
	 * Функция ReferencesMenu возвращает массив возможных отчетов подчинённых пункту "Печать" . Вызывается в latout/main.php
	 * @return array menuparams
	 */
	public function ReferencesMenu(){
		$laReturn = null;
		$loReferences = new References();
		for ( $i=0; $i < count( $loReferences->list_references ); $i++ ){
			//$laReturn[] = array( 'label' => $loReferences->list_references[ $i ][ 'name' ], 'url' => $loReferences->list_references[ $i ][ 'url' ] . '?id0=' . $loReferences->list_references[ $i ][ 'id0' ], 'itemOptions' => array( 'target' => 'reference_' . $loReferences->list_references[ $i ][ 'id0' ] ) );
			$laReturn[] = array( 'label' => $loReferences->list_references[ $i ][ 'name' ], 'url'=>array( $loReferences->list_references[ $i ][ 'url' ] . '?id0=' . $loReferences->list_references[ $i ][ 'id0' ] )
				, 'itemOptions' => array( 'id'=>'li_references', 'id0' => 'references_id'. $loReferences->list_references[ $i ][ 'id0' ] ), 'linkOptions' => array( 'id'=>'a_references', 'class' => 'submenuHrefItem', 'target' => 'reference_' . $loReferences->list_references[ $i ][ 'id0' ] ) );
			
		}
		return $laReturn;
	}

	/**
	 * Функция ReferencesGetHtmlSearch возвращает массив возможных значений фильтра
	 * @return array filterparams
	 */
	public function ReferencesGetHtmlSearch(){
		$laReturn = array();
		//$laSqlBanks = Yii::app()->db->createCommand( 'SELECT * FROM banks WHERE TRUE' )->queryAll();
		$loModelBanks = Banks::model()->findAll( array( 'order' => 'name' ) );
		$laReturn[ 'banks' ] = $loListBanks = CHtml::listData( $loModelBanks, 'id', 'name' );

		$laSqlCalcs = Yii::app()->db->createCommand( 'SELECT DISTINCT cg.id, cg.date, cgi.value FROM calc_groups AS cg JOIN calc_group_items cgi ON ( cgi."group" = cg.id ) JOIN calc_params cp ON ( cp.id = cgi.param ) WHERE TRUE AND cp.name=\'OSNP\' ORDER BY cg.date' )->queryAll(); //LIMIT 5 OFFSET 86
		$laListCalcs = array();
		for ( $i=0; $i < count( $laSqlCalcs ); $i++ ){
			$laListCalcs[ $laSqlCalcs[ $i ][ 'id' ] ] = $laSqlCalcs[ $i ][ 'value' ] . ' от ' . Helper::HelperDateToGerman( $laSqlCalcs[ $i ][ 'date' ] );
		}
		$laReturn[ 'calcs' ] = $laListCalcs;
		return $laReturn;
	}

	/**
	 * Функция ReferencesGetSearchData производит поиск по параметрам фильтра и отдаёт результаты поиска
	 * @param array $paSearchConditions - массив выбранных условий
	 * @return array - массив данных подходящих под выбранные условия
	 */
	public function ReferencesGetSearchData( $paSearchConditions ){
		$laReturn = array();
		if ( $paSearchConditions[ 'compensation' ] && Helper::HelperSetBooleanVal( $paSearchConditions[ 'compensation' ] ) ){
		} else {
			if ( $paSearchConditions[ 'interment' ] && Helper::HelperSetBooleanVal( $paSearchConditions[ 'interment' ] ) ){
				$laSqlCalcs = Yii::app()->db->createCommand( '
					SELECT 1 AS count, cs.number
						, ( CASE WHEN cs.recipient IS NOT NULL THEN
								rps.second_name || \' \' || rps.first_name || \' \' || rps.third_name
							ELSE
								ps.second_name || \' \' || ps.first_name || \' \' || ps.third_name
							END 
						) AS fio
						, ps.death_date, cs.list_number, cgs.date, c.value 
					FROM calcs AS c 
						JOIN calc_groups cgs ON ( cgs.id = c.calc_group ) 
						JOIN cases AS cs ON ( cs.id = c."case" ) 

						JOIN persons AS ps ON ( ps.id = cs.person )
						LEFT JOIN bank_accounts AS bas ON ( bas.person = ps.id AND bas.bank = ' . $paSearchConditions[ 'banks' ] . ' ) 

						LEFT JOIN persons AS rps ON ( rps.id = cs.recipient )
						LEFT JOIN bank_accounts AS rbas ON ( rbas.person = rps.id AND rbas.bank = ' . $paSearchConditions[ 'banks' ] . ' ) 
					WHERE TRUE AND c.calc_group = ' . $paSearchConditions[ 'calcs' ] . '
						--AND c.value > 0
						AND ( bas.id IS NOT NULL OR rbas.id IS NOT NULL )
					ORDER BY cs.number
					--LIMIT 50
				' )->queryAll();
				for ( $i=0; $i < count( $laSqlCalcs ); $i++ ){
					$laSqlCalcs[ $i ][ 'count' ] = $i + 1;
					$laSqlCalcs[ $i ][ 'date' ] = Helper::HelperDateToGerman( $laSqlCalcs[ $i ][ 'date' ] );
					//$laSqlCalcs[ $i ][ 'death_date' ] = Helper::HelperDateToGerman( $laSqlCalcs[ $i ][ 'death_date' ] );
					$laSqlCalcs[ $i ][ 'value' ] = number_format( $laSqlCalcs[ $i ][ 'value' ], 2, '.', '' );
					$laSqlCalcs[ $i ][ 'value_death' ] = number_format( 3 * $laSqlCalcs[ $i ][ 'value' ], 2, '.', '' );
					if ( $laSqlCalcs[ $i ][ 'death_date' ] ) $laSqlCalcs[ $i ][ 'value_death' ] = '';
					$laReturn[] = $laSqlCalcs[ $i ];
				}
			} else {
				$laSqlCalcs = Yii::app()->db->createCommand( '
					SELECT 1 AS count, cs.number
						, ( CASE WHEN cs.recipient IS NOT NULL THEN
								rps.second_name || \' \' || rps.first_name || \' \' || rps.third_name
							ELSE
								ps.second_name || \' \' || ps.first_name || \' \' || ps.third_name
							END 
						) AS fio
						, cs.list_number, cgs.date, c.value 
					FROM calcs AS c 
						JOIN calc_groups cgs ON ( cgs.id = c.calc_group ) 
						JOIN cases AS cs ON ( cs.id = c."case" ) 

						JOIN persons AS ps ON ( ps.id = cs.person )
						LEFT JOIN bank_accounts AS bas ON ( bas.person = ps.id AND bas.bank = ' . $paSearchConditions[ 'banks' ] . ' ) 

						LEFT JOIN persons AS rps ON ( rps.id = cs.recipient )
						LEFT JOIN bank_accounts AS rbas ON ( rbas.person = rps.id AND rbas.bank = ' . $paSearchConditions[ 'banks' ] . ' ) 
					WHERE TRUE AND c.calc_group = ' . $paSearchConditions[ 'calcs' ] . '
						AND c.value > 0
						AND ( bas.id IS NOT NULL OR rbas.id IS NOT NULL )
					ORDER BY cs.number
					--LIMIT 500
				' )->queryAll();
				for ( $i=0; $i < count( $laSqlCalcs ); $i++ ){
					$laSqlCalcs[ $i ][ 'count' ] = $i + 1;
					$laSqlCalcs[ $i ][ 'date' ] = Helper::HelperDateToGerman( $laSqlCalcs[ $i ][ 'date' ] );
					$laSqlCalcs[ $i ][ 'value' ] = number_format( $laSqlCalcs[ $i ][ 'value' ], 2, '.', '' );
					$laReturn[] = $laSqlCalcs[ $i ];
				}
			}
		}
		return $laReturn;
	}

	/**
	 * Функция ReferencesGetSbExport производит поиск по параметрам фильтра и отдаёт результаты поиска, готовит данные для выгрузки в файл
	 * @param array $paSearchConditions - массив выбранных условий
	 * @return string
	 */
	public function ReferencesGetSbExport( $paSearchConditions ){
		$lsReturn = '';
		$lsDataCondition = '';
		
		$paSearchConditions[ 'pay_begin_day' ] = implode('-', array_reverse(explode('.', $paSearchConditions[ 'pay_begin_day' ])));
		$paSearchConditions[ 'pay_end_day' ] = implode('-', array_reverse(explode('.', $paSearchConditions[ 'pay_end_day' ])));
		//print_r($paSearchConditions); die();
		
		if ( $paSearchConditions[ 'pay_begin_day' ] ) $lsDataCondition .= ' AND pm.date >= \'' . $paSearchConditions[ 'pay_begin_day' ] . '\'::date';
		if ( $paSearchConditions[ 'pay_end_day' ] ) $lsDataCondition .= ' AND pm.date <= \'' . $paSearchConditions[ 'pay_end_day' ] . '\'::date';
		

		$laSqlResult = Yii::app()->db->createCommand( '
			SELECT 
				cm.code || \'/\' || c."number" as case_number
				, r.ser as res_seria
				, r."number" as res_number
				, p.second_name
				, p.first_name
				, p.third_name
				, pm.summa
				, r.begin_action_date AS begin_date
				, r.end_action_date AS end_date
				, \'\' reserve
				, b.department AS sbrf
				, \'\' AS kbk
				, pmt.code_sb
				, 0 AS upd
				, COALESCE( pmt.period, 0 ) AS period
			FROM
				cases c
				JOIN comms cm ON ( cm.id = c.comm )
				JOIN persons p ON ( c.person = p.id )
				JOIN resolutions r ON ( p.id = r.person )
				JOIN bank_accounts a ON ( p.id = a.person )
				JOIN banks b ON ( a.bank = b.id )
				LEFT JOIN payments pm ON ( pm.case = c."number" )
				LEFT JOIN payments_type pmt ON ( pmt.id = pm.type )
			WHERE TRUE
				AND pm.summa > 0
				AND b.id = ' . $paSearchConditions[ 'banks' ] . '
				' . $lsDataCondition . '
				--AND c."number" = 53017
			ORDER BY 1, 15, 13
		' )->queryAll(); //print_r($laSqlResult); die();
		for ( $i=0; $i < count( $laSqlResult ); $i++ ){
			//$laSqlResult[ $i ][ 'date' ] = Helper::HelperDateToGerman( $laSqlResult[ $i ][ 'date' ] );
			//$laSqlResult[ $i ][ 'value' ] = number_format( $laSqlResult[ $i ][ 'value' ], 2, '.', '' );
			$lsReturn .= $laSqlResult[ $i ][ 'case_number' ] . '|';
			$lsReturn .= $laSqlResult[ $i ][ 'res_seria' ] . '|';
			$lsReturn .= $laSqlResult[ $i ][ 'res_number' ] . '|';
			$lsReturn .= $laSqlResult[ $i ][ 'second_name' ] . '|';
			$lsReturn .= $laSqlResult[ $i ][ 'first_name' ] . '|';
			$lsReturn .= $laSqlResult[ $i ][ 'third_name' ] . '|';
			$lsReturn .= $laSqlResult[ $i ][ 'summa' ] . '|';
			$lsReturn .= Helper::HelperDateToGerman( $laSqlResult[ $i ][ 'begin_date' ] ) . '|';
			$lsReturn .= Helper::HelperDateToGerman( $laSqlResult[ $i ][ 'end_date' ] ) . '|';
			$lsReturn .= $laSqlResult[ $i ][ 'reserve' ] . '|';
			$lsReturn .= $laSqlResult[ $i ][ 'sbrf' ] . '|';
			$lsReturn .= $laSqlResult[ $i ][ 'kbk' ] . '|';
			$lsReturn .= $laSqlResult[ $i ][ 'code_sb' ] . '|';
			$lsReturn .= $laSqlResult[ $i ][ 'upd' ] . '|';
			$lsReturn .= $laSqlResult[ $i ][ 'period' ] . "\n";
		}
		//echo $lsReturn;
		return $lsReturn;
	}
}
