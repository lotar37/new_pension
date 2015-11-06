<?php
/* @var $this ReferencesController */
$this->breadcrumbs=array(
	'References',
);
mb_internal_encoding( 'UTF-8' );
?>
<script>
	// Задаём ширину страницы portrait
	var lnA4Width = 720;
	var lnA4Height = 1300;
	jQuery(function($){
		$( "#banks" ).val( "<?=( isset( $_GET[ 'banks' ] ) ? $_GET[ 'banks' ] : '' )?>" );
		//$( "#calcs" ).val( "<?=( isset( $_GET[ 'calcs' ] ) ? $_GET[ 'calcs' ] : '' )?>" );
		$( '#pay_begin_day' ).datepicker({
			dateFormat: "dd.mm.yy"
			, currentText: "Now"
			, prevText: "Предыдущий"
			, nextText: "Следующий"
			, firstDay: 1
			, monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ]
			, monthNamesShort: [ "Янв", "Фев", "Март", "Апр", "Май", "Июнь", "Июль", "Авг", "Сент", "Окт", "Нояб", "Дек" ]
			, dayNames: [ 'Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота' ]
			, dayNamesShort: [ 'Вос', 'Пон', 'Вто', 'Сре', 'Чет', 'Пят', 'Суб' ]
			, dayNamesMin: [ 'Bс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб' ]
			, changeMonth: true
			, changeYear: true
			, showOn: 'both'
			//, buttonImage: "../../lib/images/contextmenu/button_calendar.png"
			//, buttonImageOnly: true
			, showOtherMonths: true
			, selectOtherMonths: true
			//, disabled: true
		});
		$( '#pay_end_day' ).datepicker({
			dateFormat: "dd.mm.yy"
			, currentText: "Now"
			, prevText: "Предыдущий"
			, nextText: "Следующий"
			, firstDay: 1
			, monthNames: [ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ]
			, monthNamesShort: [ "Янв", "Фев", "Март", "Апр", "Май", "Июнь", "Июль", "Авг", "Сент", "Окт", "Нояб", "Дек" ]
			, dayNames: [ 'Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота' ]
			, dayNamesShort: [ 'Вос', 'Пон', 'Вто', 'Сре', 'Чет', 'Пят', 'Суб' ]
			, dayNamesMin: [ 'Bс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб' ]
			, changeMonth: true
			, changeYear: true
			, showOn: 'both'
			//, buttonImage: "../../lib/images/contextmenu/button_calendar.png"
			//, buttonImageOnly: true
			, showOtherMonths: true
			, selectOtherMonths: true
			//, disabled: true
		});
	});
</script>

<span id="span_search_toggle" class="cSpanSearch IsPrintHidden" title="Фильтр">&nbsp;</span>
<div id="div_search" class="cDivSearch IsPrintHidden">
	<? echo CHtml::beginForm( array( 'references/index' ), 'GET', array( 'class' => 'cForm', 'id' => 'FormSearch' ) );?>
	<table id="TableSearch" class="cTableReferences" style="border: 1px solid transparent;">
		<col style="width:20%;">
		<col style="width:30%;">
		<col style="width:20%;">
		<col style="width:30%;">
		<tr>
			<td>Банк</td>
			<td><? echo CHtml::dropDownList( 'banks', $_GET[ 'banks' ], $this->model_params[ 'html' ][ 'banks' ], array( 'empty' => 'Выберите банк' ) );?></td>
			<td>Дата</td>
			<td>
				<nobr>с&nbsp;<input type="text" name="pay_begin_day" id='pay_begin_day' onChange="" value="<?=date('d.m.Y', strtotime( '-1 year', strtotime( date( 'd.m.Y' ) )) )?>" style="width: 100px" maxlength="10">
				по &nbsp;<input type="text" name="pay_end_day" id='pay_end_day' onChange="" value="<?=date('d.m.Y')?>" style="width: 100px" maxlength="10"></nobr>
			</td>
			<!--td>Параметры пересчета</td>
			<td><? echo CHtml::dropDownList( 'calcs', $_GET[ 'calcs' ], $this->model_params[ 'html' ][ 'calcs' ], array( 'empty' => 'Выберите основание' ) );?> 
			</td-->
		</tr>
		<tr>
			<td colspan=4><? echo CHtml::button( 'Выгрузить', array( 'type' => 'button', 'id' => 'ButtonSearchSubmit', 'name' => 'ButtonSearchSubmit', 'onClick' => 'lfCheckParams( this )' ) );?></td>
		</tr>
	</table>
	<? echo CHtml::endForm();?>
</div><!--/div_search-->

<script>
	if ( '<?=$_GET[ 'search_start' ]?>' == '1' ){
		$( "#div_search" ).hide();
		showWaitScreen();
	} else {
		$( "#span_search_toggle" ).css({ 'top': $( "#div_search" ).outerHeight() });
	}
	function lfCheckParams( poButton ){
		var lsAlert = "";
		if ( !$( "#banks" ).val() ) lsAlert += "Выберите банк!";
		//if ( !$( "#calcs" ).val() ) lsAlert += ( lsAlert != "" ? "\r\n" : "" ) + "Выберите основание!";
		if ( lsAlert != "" ) alert( lsAlert );
		else {
			var lsUrl = "<?=Yii::app()->request->scriptUrl?>/references/export?id0=2";
			lsUrl += "&banks=" + $( "#banks" ).val();
			lsUrl += "&calcs=" + $( "#calcs" ).val();
			lsUrl += "&pay_begin_day=" + $( "#pay_begin_day" ).val();
			lsUrl += "&pay_end_day=" + $( "#pay_end_day" ).val();
			$( "#iframe_export" )[0].src = lsUrl;
		}
	}
	jQuery(function($){
		$( "#span_search_toggle" ).on( 'click', function(){
			$( "#div_search" ).toggle();
			if ( $( "#div_search" ).css( 'display' ) == 'none' ) $(this).css({ 'top': 2 });
			else $(this).css({ 'top': $( "#div_search" ).outerHeight() });
		});
	});
</script>

<div id="div_search_result" class="cDivSearchResult" style="display: none; border: 1px solid #FF0000;">
	<iframe id="iframe_export"></iframe>
</div><!--/div_search_result-->

<script>
	jQuery(function($){
		hideWaitScreen();
	});
</script>