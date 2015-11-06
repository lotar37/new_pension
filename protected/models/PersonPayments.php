<?php
/**
 * Класс Payments.
 * Класс предназначен для печатных отчетов (пункт "Печать" в форме редактирования персоны)
 */
class PersonPayments extends CFormModel{
	public $person_id = 0;

	/**
	 * Функция PersonPayments инициализирует модуль-класс PersonPayments
	 * @param integer $pnPersonId - id выбранной персоны
	 * @return null
	 */
	public function PersonPayments( $pnPersonId = 0 ){
		//echo '<script>alert(' . $psPersonId . ');</script>';
		$this->person_id = $pnPersonId;
	}

	/**
	 * Функция printPersonPaymentsTable инициализирует HTML-структуру для вставки в форму редактирования персоны и формирования меню печатных форм отчетов
	 * @return string - HTML выставка в форму редактирования персоны
	 */
	public function printPersonPaymentsTable(){
		if ( $this->person_id == 0 ) return '';
		$lsReturn = '';
		return $lsReturn;
	}

	/**
	 * Функция printPersonPaymentsTableJS инициализирует JavaScript-структуру для вставки в форму редактирования персоны и управлением меню печатных форм отчетов . Вызывается после формирования таблиц ( printPersonPaymentsTable ) .
	 * @param string $psButtonId - id кнопки, на которую вешается обработчик работы с меню ( jQuery )
	 * @return string - JavaScript выставка в форму редактирования персоны, обработка меню печати
	 */
	public function printPersonPaymentsTableJS( $psButtonId ){
		if ( $this->person_id == 0 ) return '';
		$lsUrl = Yii::app()->createUrl( '/personPayments/index', array( 'idp' => $this->person_id ) );
		$lsReturn = '';
		$lsReturn .= '
			/* Обработка справок для персоны */
			$("' . $psButtonId . '")
			.html( $("' . $psButtonId . '").html() + " <span style=\"color: #FFFFFF;\">F3</span>" )
			.css({ "cursor": "pointer" })
			.on( "click", function(){
				lfOpenPaymentsShowLayer()
			});
			function lfOpenPaymentsShowLayer(){
				window.open( "' . $lsUrl . '", "payments" );
			}
			$(document).keypress(function(eventObject){
				//if ( typeof( console ) != "undefined" && console ) console.log( "keyCode=" + eventObject.keyCode );
				if ( eventObject.keyCode == 114 ){ // F3
					eventObject.stopPropagation();
					eventObject.preventDefault();
					lfOpenPaymentsShowLayer();
				}
			});
		';
		return $lsReturn;
	}

	/**
	 * Функция PersonPaymentsGetSearchData производит отбор по параметрам фильтра и отдаёт результаты поиска
	 * @param array $paSearchConditions - массив выбранных условий
	 * @return array - массив данных подходящих под выбранные условия
	 */
	public function PersonPaymentsGetPersonData( $paSearchConditions ){
		mb_internal_encoding( 'UTF-8' );
		$laReturn = array();
		$loModelPerson = Persons::model()->findByPk( $paSearchConditions[ 'idp' ] );
		$loModelCase = Cases::model()->findByPk( $loModelPerson->cases3->id );

		$laSqlComm = Yii::app()->db->createCommand()->select( '*' )->from( 'comms' )->where( 'id=:id', array( ':id'=>$loModelCase->comm ) )->queryAll();
		$loDataComm = $laSqlComm[0];
		$laSqlChaes = Yii::app()->db->createCommand( 'SELECT c.* FROM chaes c JOIN person_chaes pc ON ( pc.chae = c.id AND pc.person = ' . $this->person_id . ' ) WHERE TRUE ORDER BY pc.oid' )->queryAll();
		for ( $i = 0; $i < count( $laSqlChaes ); $i++ ){
			$lsTmp = $laSqlChaes[ $i ][ 'name' ];
			//$lsTmp = 'ПОГИБ в Зоне отчуждения (ПОР)';
			$laSqlChaes[ $i ][ 'prepared_name' ] = trim( mb_substr( $lsTmp, 0, 55 ) );
		}
		$laSqlSeniorities = Yii::app()->db->createCommand( 'SELECT * FROM seniorities WHERE TRUE AND person = ' . $this->person_id . '' )->queryAll();
		$laSeniorities = array();
		for ( $i = 0; $i < count( $laSqlSeniorities ); $i++ ){
			$laSeniorities[ $laSqlSeniorities[ $i ][ 'class' ] ][ $laSqlSeniorities[ $i ][ 'type' ] ] = $laSqlSeniorities[ $i ][ 'value' ];
		}

		$laSqlBanks = Yii::app()->db->createCommand( 'SELECT ba."number" AS bank_accountnumber, bs.* FROM bank_accounts ba JOIN banks bs ON ( bs.id = ba.bank ) WHERE TRUE AND ba.is_actual = 1 AND person = ' . $this->person_id . ' ORDER BY ba.oid DESC' )->queryAll();

		$laSqlRankDative = Yii::app()->db->createCommand( 'SELECT lower( get_dative_fio( \'\', \'' . Ranks::model()->findByPk( $loModelPerson->rank )->print_name . '\', \'в\' ) ) AS rank' )->queryAll();

		$loModelDismisses = Dismisses::model()->findByPk( $loModelPerson->dismiss );
		$loModelAddress = Addrs::model()->findByAttributes( array( 'person' => $this->person_id ) );
		$loModelCalc = Calculator::calcPension( $loModelCase->id );

		$laSqlWars = Yii::app()->db->createCommand( 'SELECT wa.* FROM person_war_actions pw JOIN war_actions wa ON ( wa.id = pw.war_action) WHERE TRUE AND pw.person = ' . $this->person_id . ' ORDER BY pw.oid' )->queryAll();
		$loModelRecipientPerson = Persons::model()->findByPk( ( $loModelCase->recipient ? $loModelCase->recipient : $loModelCase->person ) );

		$laSqlPays = Yii::app()->db->createCommand( '
			SELECT "case", summa, "date", begin_date, end_date, code, code_sb, period, "name", "sname" 
			FROM payments p JOIN payments_type pt ON (pt.id = p."type") 
			WHERE TRUE AND "case" = ' . $loModelCase->id . '
			ORDER BY 3
		' )->queryAll();

		$laReturn = array(
			'FIO' => $loModelPerson->second_name . ' ' . $loModelPerson->first_name . ' ' . $loModelPerson->third_name 
			, 'FIO_Dative' => Helper::HelperFIORusCreateDative( $loModelPerson )
			, 'rank_Dative' => $laSqlRankDative[ 0 ][ 'rank' ]
			, 'rank_name' => Ranks::model()->findByPk( $loModelPerson->rank )->print_name
			, 'working_name' => ( $loModelPerson->is_working ? 'работает' : 'не работает' )
			, 'seniorities' => $laSeniorities
			, 'todayDate' => array( 'digital' => date( 'd.m.Y' ), 'analogRus' => Helper::HelperDateRusCreate( date( 'd.m.Y' ) ) )
			, 'case_nom' => array( 'nom_slash' => $loDataComm[ 'code' ] . '/' . $loModelCase[ 'number' ], 'nom_dash' => $loDataComm[ 'code' ] . '-' . $loModelCase[ 'number' ] )
			, 'model_person' => $loModelPerson
			, 'model_case' => $loModelCase
			, 'model_dissmiss' => $loModelDismisses
			, 'data_comm' => $loDataComm
			, 'model_addrs' => $loModelAddress
			, 'data_bank' => $laSqlBanks
			, 'model_calc' => $loModelCalc
			, 'data_chaes' => $laSqlChaes
			, 'data_wars' => $laSqlWars
			, 'model_recipient' => $loModelRecipientPerson
			, 'data_pays' => $laSqlPays
			, 'sign' => array(
				'chief' => array( 'fio' => 'ФИО', 'rank' => 'воинское звание', 'office' => 'Начальник отдела социального и финансового обеспечения' )
				, 'deputy' => array( 'fio' => 'ФИО', 'rank' => 'воинское звание', 'office' => 'Заместитель начальника отдела С и Ф О' )
				, 'assistant' => array( 'fio' => 'ФИО', 'rank' => 'воинское звание', 'office' => 'Помощник начальника отдела С и Ф О' )
				, 'office' => array( 'name' => 'Отдел С и Ф О' )
			)
		);

		return $laReturn;
	}
}
