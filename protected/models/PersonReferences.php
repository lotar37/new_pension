<?php
/**
 * Класс References.
 * Класс предназначен для печатных отчетов (пункт "Печать" в форме редактирования персоны)
 */
class PersonReferences extends CFormModel{
	public $person_id = 0;
	public $layer_id = '';
	public $list_person_references = array();

	/**
	 * Функция PersonReferences инициализирует модуль-класс PersonReferences
	 * @param integer $pnPersonId - id выбранной персоны
	 * @return null
	 */
	public function PersonReferences( $pnPersonId = 0 ){
		//echo '<script>alert(' . $psPersonId . ');</script>';
		$this->person_id = $pnPersonId;
		$this->layer_id = 'div.references';
		$this->list_person_references = array(
			//array( 'id0'=>1		, 'name'=>'Пенсионный лист (РАЗРЕШЕНИЕ на выплату пенсии) на бланке'			, 'url'=>'/personReferences/index' )
			array( 'id0'=>2	, 'name'=>'СПРАВКА В ПЕНСИОННЫЙ ФОНД'											, 'url'=>'/personReferences/index' )
			//, array( 'id0'=>3	, 'name'=>'Исчисление пенсии и карточка пенсионера'								, 'url'=>'/personReferences/index' )
			//, array( 'id0'=>4	, 'name'=>'КАРТОЧКА'															, 'url'=>'/personReferences/index' )
			, array( 'id0'=>5	, 'name'=>'ТИТУЛЬНЫЙ ЛИСТ'														, 'url'=>'/personReferences/index' )
			//, array( 'id0'=>6	, 'name'=>'РАСПОРЯЖЕНИЕ на выплату пенсии'										, 'url'=>'/personReferences/index' )
			//, array( 'id0'=>7	, 'name'=>'Учетная карточка пенсионера получающего пенсию за выслугу лет'		, 'url'=>'/personReferences/index' )
			, array( 'id0'=>8	, 'name'=>'УВЕДОМЛЕНИЕ о назначении пенсии (пособия, оклада)'					, 'url'=>'/personReferences/index' )
			//, array( 'id0'=>9	, 'name'=>'Карточка учета пенсионера МО РФ'										, 'url'=>'/personReferences/index' )
			, array( 'id0'=>10	, 'name'=>'Карточка учета пенсионера (короткая)'								, 'url'=>'/personReferences/index' )
			//, array( 'id0'=>11	, 'name'=>'СПРАВКА о размере пенсии за выслугу лет'								, 'url'=>'/personReferences/index' )
			, array( 'id0'=>12	, 'name'=>'СПРАВКА взамен пенсионного удостоверения'							, 'url'=>'/personReferences/index' )
			, array( 'id0'=>13	, 'name'=>'СПРАВКА по оплате жилплощади'										, 'url'=>'/personReferences/index' )
			, array( 'id0'=>14	, 'name'=>'СПРАВКА по оплате жилплощади и коммунальных услуг'					, 'url'=>'/personReferences/index' )
			, array( 'id0'=>15	, 'name'=>'СПРАВКА по приватизации жилья'										, 'url'=>'/personReferences/index' )
			, array( 'id0'=>16	, 'name'=>'СПРАВКА на освобождение от уплаты земельного налога'					, 'url'=>'/personReferences/index' )
			, array( 'id0'=>17	, 'name'=>'СПРАВКА на медобслуживание и санаторно-курортное лечение'			, 'url'=>'/personReferences/index' )
			, array( 'id0'=>18	, 'name'=>'РАСПОРЯЖЕНИЕ на выплату доплаты (из разницы новой и старой сумм)'	, 'url'=>'/personReferences/index' )
			, array( 'id0'=>19	, 'name'=>'Справка пенсионеру о размере пенсии'									, 'url'=>'/personReferences/index' )
			, array( 'id0'=>20	, 'name'=>'Справка'																, 'url'=>'/personReferences/index' )
			//, array( 'id0'=>21	, 'name'=>'Справка о доходах'													, 'url'=>'/personReferences/index' )
			//, array( 'id0'=>22	, 'name'=>'Справка о доходах (помесячно)'										, 'url'=>'/personReferences/index' )
			//, array( 'id0'=>23	, 'name'=>'СПРАВКА по приватизации жилья воинам-интернационалистам'										, 'url'=>'/personReferences/index' )
		);

		$laSqlIsRecipient = Yii::app()->db->createCommand( 'SELECT cs.id FROM persons ps JOIN cases cs ON ( cs.person = ps.id ) WHERE TRUE AND ps.id = ' . $this->person_id . ' ' )->queryAll();

		//echo '<pre>+++++';
		//print_r( $laSqlIsRecipient );
		//echo '</pre>';
		if ( count( $laSqlIsRecipient ) <= 0 ){
			$this->list_person_references = array();
		}
	}

	/**
	 * Функция printPersonReferencesTable инициализирует HTML-структуру для вставки в форму редактирования персоны и формирования меню печатных форм отчетов
	 * @return string - HTML выставка в форму редактирования персоны
	 */
	public function printPersonReferencesTable(){
		if ( $this->person_id == 0 ) return '';
		$lsReturn = '';
		$lsReturn .= '
<div class="references row" style="border:3px double white;display:none;position:absolute;background:#008;color:#FF0;top:100px;left:100px;">
	<div style="background:#FFF;color:#008;padding-left:5px;">СПРАВКИ для действующий п/дел</div>
	<table id="referencesTab" style="width:100%;padding-left:10px;">
		';
		for ( $i = 0; $i < count( $this->list_person_references ); $i++ ){
			$lsUrl = Yii::app()->urlManager->createUrl( $this->list_person_references[ $i ][ 'url' ], array( 'id0' => $this->list_person_references[ $i ][ 'id0' ], 'idp' => $this->person_id ));
			$lsReturn .= '<tr rowcount="' . ( $i + 1 ) . '" id0="' . $this->list_person_references[ $i ][ 'id0' ] . '" url="' . $lsUrl . '"><td>' . $this->list_person_references[ $i ][ 'name' ] . '</td></tr>';
		}

		$lsReturn .= '
		</table>
	<div style="background:#FFF;color:#008;padding-left:5px;padding-right:5px;">
		<table style="width:100%;">
			<tr>
				<td>' . CHtml::button( 'Закрыть', array( 'type' => 'button', 'id' => 'ButtonPersonReferencesClose', 'name' => 'ButtonPersonReferencesClose', 'onClick' => '$("' . $this->layer_id . '").hide( "fast" );' ) ). '</td>
				<td></td>
				<td id="referencesTdActionView" style="text-align:right;">X/N</td>
			</tr>
		</table>
	</div>
</div>
		';
		return $lsReturn;
	}

	/**
	 * Функция printPersonReferencesTableJS инициализирует JavaScript-структуру для вставки в форму редактирования персоны и управлением меню печатных форм отчетов . Вызывается после формирования таблиц ( printPersonReferencesTable ) .
	 * @param string $psButtonId - id кнопки, на которую вешается обработчик работы с меню ( jQuery )
	 * @return string - JavaScript выставка в форму редактирования персоны, обработка меню печати
	 */
	public function printPersonReferencesTableJS( $psButtonId ){
		if ( $this->person_id == 0 ) return '';
		//$lsUrl = Yii::app()->createUrl( '/personReferences/index', array('id'=>1) );
		$lsReturn = '';
		$lsReturn .= '
			$("' . $this->layer_id . '").attr( "is_shown", 0 );
			/* Обработка справок для персоны */
			var loReferencesTimer = null;
			function lfReferencesShowLayer(){
				clearTimeout( loReferencesTimer );
				if ( $("' . $this->layer_id . '").attr( "is_shown" ) == 0 ){
					$("' . $this->layer_id . '").attr( "is_shown", 1 );
					if ( $("' . $this->layer_id . '").outerWidth() > 0 ){
						$("' . $this->layer_id . '").css({ "left": parseInt( $("' . $psButtonId . '").position().left + $("' . $psButtonId . '").outerWidth() - $("' . $this->layer_id . '").outerWidth() ) });
					}
					if ( $("' . $this->layer_id . '").outerHeight() > 0 ){
						$("' . $this->layer_id . '").css({ "top": parseInt( $("' . $psButtonId . '").position().top - $("' . $this->layer_id . '").outerHeight() - 1 ) });
					}
				}
				$("' . $this->layer_id . '").show( "fast" );
			}
			function lfReferencesHideLayer(){
				//clearTimeout( loReferencesTimer );
				$("' . $this->layer_id . '").hide( "fast" );
			}
			$("' . $psButtonId . '")
			.html( $("' . $psButtonId . '").html() + " <span style=\"color: #FFFFFF;\">F7</span>" )
			.css({ "cursor": "pointer" })
			/*
			.on( "mousedown", function(){
				$(this).css({ "border-bottom": "1px solid #000099", "border-right": "1px solid #000099" });
			})
			.on( "mouseup", function(){
				$(this).css({ "border-bottom": "0px", "border-right": "0px" });
			})
			.on( "mouseout", function(){
				$(this).css({ "border-bottom": "0px", "border-right": "0px" });
			})
			*/
			.on( "click", function(){
				lfReferencesShowLayer()
			});
			$(document).keypress(function(eventObject){
				if ( eventObject.keyCode == 118 ){ // F7
					eventObject.stopPropagation();
					eventObject.preventDefault();
					lfReferencesShowLayer();
				}
			});

			$("' . $this->layer_id . '").on( "mousemove", function(){
				lfReferencesShowLayer();
			})
			.on( "mouseout", function(){
				loReferencesTimer = setTimeout(lfReferencesHideLayer, 1500);
			})
			.on( "mouseenter", function(){
				lfReferencesShowLayer();
			});

			var lsReferencesUrl = "";
			function lfReferencesTdSelectedClass( poObj ){
			}
			$( "#referencesTab tr" ).on( "mouseenter", function(){
				clearTimeout( loReferencesTimer );
				$(this).css({ "background": "#FF0", "color": "#008", "cursor": "pointer" });
				$("#referencesTdActionView").html( $(this).attr( "rowcount" ) + "/" + $("#referencesTab tr").length );
			})
			.on( "mouseout", function(){
				$(this).css({ "background": "", "color": "" });
			})
			.on( "click", function(){
				window.open( $(this).attr( "url" ), "personReferences_" + $(this).attr( "id0" ) );
			});
		';
		return $lsReturn;
	}

	/**
	 * Функция PersonReferencesGetSearchData производит отбор по параметрам фильтра и отдаёт результаты поиска
	 * @param array $paSearchConditions - массив выбранных условий
	 * @return array - массив данных подходящих под выбранные условия
	 */
	public function PersonReferencesGetPersonData( $paSearchConditions ){
		mb_internal_encoding( 'UTF-8' );
		$laReturn = array();
		//$loModelPersonReferences = new PersonReferences();
		//$loModelPersonReferences->PersonReferences( $paSearchConditions[ 'id0' ] );
		//echo $paSearchConditions[ 'idp' ]."111111111111111111111111";die();
		$loModelPerson = Persons::model()->findByPk( $paSearchConditions[ 'idp' ] );
		//$loModelPerson = Persons::model()->findByPk(9495);


		$loModelCase = Cases::model()->findByPk( $loModelPerson->cases3->id );

		$laSqlComm = Yii::app()->db->createCommand()->select( '*' )->from( 'comms' )->where( 'id=:id', array( ':id'=>$loModelCase->comm ) )->queryAll();
		$loDataComm = $laSqlComm[0];
		//$laSqlChaes = Yii::app()->db->createCommand( 'SELECT c.* FROM chaes c JOIN person_chaes pc ON ( pc.chae = c.id AND pc.person = ' . $this->person_id . ' ) WHERE TRUE ORDER BY c.code, c.oid' )->queryAll();
		$laSqlChaes = Yii::app()->db->createCommand( 'SELECT c.* FROM chaes c JOIN person_chaes pc ON ( pc.chae = c.id AND pc.person = ' . $this->person_id . ' ) WHERE TRUE ORDER BY pc.oid' )->queryAll();
		$lsChaesName = '';
		for ( $i = 0; $i < count( $laSqlChaes ); $i++ ){
			$lsTmp = $laSqlChaes[ $i ][ 'name' ];
			//$lsTmp = 'ПОГИБ в Зоне отчуждения (ПОР)';
			$laSqlChaes[ $i ][ 'prepared_name' ] = trim( mb_substr( $lsTmp, 0, 55 ) );
			$lsTmp = trim( mb_substr( $lsTmp, 0, 55 ) );
			$lsChaesName .= ( $i == 0 ? '' : '; ' ) . $lsTmp;
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

		//$laSqlWars = Yii::app()->db->createCommand( 'SELECT wa.* FROM person_war_actions pw JOIN war_actions wa ON ( wa.id = pw.war_action) WHERE TRUE AND pw.person = ' . $this->person_id . ' ORDER BY wa.code, wa.oid DESC' )->queryAll();
		$laSqlWars = Yii::app()->db->createCommand( 'SELECT wa.* FROM person_war_actions pw JOIN war_actions wa ON ( wa.id = pw.war_action) WHERE TRUE AND pw.person = ' . $this->person_id . ' ORDER BY pw.oid' )->queryAll();
		$loModelRecipientPerson = Persons::model()->findByPk( ( $loModelCase->recipient ? $loModelCase->recipient : $loModelCase->person ) );

		$laSqlPays = Yii::app()->db->createCommand( '
			SELECT "case", summa, "date", begin_date, end_date, code, code_sb, period, "name", "sname" 
			FROM payments p JOIN payments_type pt ON (pt.id = p."type") 
			WHERE TRUE AND "case" = ' . $loModelCase->id . ' /*AND ( end_date IS NULL OR date_part( \'year\', end_date ) >= date_part( \'year\', ' . ( $loModelCase->calc_date ? '\'' . $loModelCase->calc_date . '\'::date' : 'now()' ) . ' ) )*/ 
			ORDER BY "begin_date" DESC
		' )->queryAll();

		$laReturn = array(
			'FIO' => $loModelPerson->second_name . ' ' . $loModelPerson->first_name . ' ' . $loModelPerson->third_name 
			, 'FIO_Dative' => Helper::HelperFIORusCreateDative( $loModelPerson )
			, 'rank_Dative' => $laSqlRankDative[ 0 ][ 'rank' ]
			, 'rank_name' => Ranks::model()->findByPk( $loModelPerson->rank )->print_name
			, 'working_name' => ( $loModelPerson->is_working ? 'работает' : 'не работает' )
			, 'chaes_name' => $lsChaesName
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
