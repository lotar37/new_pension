<?php
/* @var $this ReferencesController */
$this->breadcrumbs=array(
	'References',
);
mb_internal_encoding( 'UTF-8' );
?>
<script>
	// Задаём ширину страницы portrait
	//var lnA4Width = Number( '<?=floor( ( 210 / Yii::app()->params[ 'MFD_ATTR_SIZE_CONVERT_CM_TO_MM_MULTIPLIER' ] ) * Yii::app()->params[ 'MFD_ATTR_SIZE_CONVERT_CM_TO_PIXEL_MULTIPLIER' ] )?>' );
	//var lnA4Width = Number( '<?=floor( ( 210 / Yii::app()->params[ 'MFD_ATTR_SIZE_CONVERT_CM_TO_MM_MULTIPLIER' ] ) * Yii::app()->params[ 'MFD_ATTR_SIZE_CONVERT_CM_TO_POINT_MULTIPLIER' ] )?>' );
	var lnA4Width = 720;
	//var lnA4Height = Number( '<?=floor( ( 297 / Yii::app()->params[ 'MFD_ATTR_SIZE_CONVERT_CM_TO_MM_MULTIPLIER' ] ) * Yii::app()->params[ 'MFD_ATTR_SIZE_CONVERT_CM_TO_PIXEL_MULTIPLIER' ] )?>' );
	//var lnA4Height = Number( '<?=floor( ( 297 / Yii::app()->params[ 'MFD_ATTR_SIZE_CONVERT_CM_TO_MM_MULTIPLIER' ] ) * Yii::app()->params[ 'MFD_ATTR_SIZE_CONVERT_CM_TO_POINT_MULTIPLIER' ] )?>' );
	//var lnA4Height = parseInt( lnA4Width * Math.pow( 2, 1/2 ), 10 );
	var lnA4Height = 1300;
	jQuery(function($){
		$( "#banks" ).val( "<?=( isset( $_GET[ 'banks' ] ) ? $_GET[ 'banks' ] : '' )?>" );
		$( "#calcs" ).val( "<?=( isset( $_GET[ 'calcs' ] ) ? $_GET[ 'calcs' ] : '' )?>" );
		$( "#compensation" ).prop( "checked", <?=( Helper::HelperSetBooleanVal( $_GET[ 'compensation' ] ) ? 'true' : 'false' )?> );
		$( "#interment" ).prop( "checked", <?=( Helper::HelperSetBooleanVal( $_GET[ 'interment' ] ) ? 'true' : 'false' )?> );
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
			<td>Параметры пересчета</td>
			<td><? echo CHtml::dropDownList( 'calcs', $_GET[ 'calcs' ], $this->model_params[ 'html' ][ 'calcs' ], array( 'empty' => 'Выберите основание' ) );?> 
			</td>
		</tr>
		<tr>
			<td>С пособием на погребение</td>
			<td>
				<span class="cNiceCheckboxWrapper">
					<input id="interment" name="interment" class="" checked="" type="checkbox">
					<label for="interment" id="interment-label">
						<span class="checked">&nbsp;</span>
						<span class="unchecked"></span>
						<span class="toggle">&nbsp;</span>
					</label>
				</span>
			</td>
			<td colspan=2></td>
			<!--td>С компенсацией</td>
			<td>
				<span class="cNiceCheckboxWrapper">
					<input id="compensation" name="compensation" class="" checked="" type="checkbox">
					<label for="compensation" id="compensation-label">
						<span class="checked">&nbsp;</span>
						<span class="unchecked"></span>
						<span class="toggle">&nbsp;</span>
					</label>
				</span>
			</td-->
		</tr>
		<tr>
			<td colspan=4><? echo CHtml::button( 'Найти', array( 'type' => 'button', 'id' => 'ButtonSearchSubmit', 'name' => 'ButtonSearchSubmit', 'onClick' => 'lfCheckParams( this )' ) );?></td>
		</tr>
	</table>
	<input type="hidden" name="id0" value="<?=$_GET[ 'id0' ]?>">
	<input type="hidden" name="search_start" value="1">
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
		if ( !$( "#calcs" ).val() ) lsAlert += ( lsAlert != "" ? "\r\n" : "" ) + "Выберите основание!";
		if ( lsAlert != "" ) alert( lsAlert );
		else $( "#FormSearch" ).submit();
	}
	jQuery(function($){
		$( "#banks" ).val( "<?=( isset( $_GET[ 'banks' ] ) ? $_GET[ 'banks' ] : '' )?>" );
		$( "#calcs" ).val( "<?=( isset( $_GET[ 'calcs' ] ) ? $_GET[ 'calcs' ] : '' )?>" );
		$( "#compensation" ).prop( "checked", <?=( Helper::HelperSetBooleanVal( $_GET[ 'compensation' ] ) ? 'true' : 'false' )?> );
		$( "#interment" ).prop( "checked", <?=( Helper::HelperSetBooleanVal( $_GET[ 'interment' ] ) ? 'true' : 'false' )?> );
		$( "#span_search_toggle" ).on( 'click', function(){
			$( "#div_search" ).toggle();
			//alert( $( "#div_search" ).css( 'display' ) );
			if ( $( "#div_search" ).css( 'display' ) == 'none' ) $(this).css({ 'top': 2 });
			else $(this).css({ 'top': $( "#div_search" ).outerHeight() });
		});
		// Задаём ширину страницы portrait
		//$( "#div_search_result" ).width( '<?=floor( ( 210 / Yii::app()->params[ 'MFD_ATTR_SIZE_CONVERT_CM_TO_MM_MULTIPLIER' ] ) * Yii::app()->params[ 'MFD_ATTR_SIZE_CONVERT_CM_TO_PIXEL_MULTIPLIER' ] )?>' );
	});

	function lfAddFooter( poRow, pnListSumm, psCellSumm ){
		if ( !psCellSumm ) psCellSumm = 'td:last';
		pnListSumm = ( pnListSumm / 100 ).toFixed(2);
		var loFooter2 = $( "#TableRowFooter2" ).clone();
		loFooter2.removeClass( "cTableRowFooter" ).addClass( "cPageBreakAfter" ).insertAfter( poRow );
		var loFooter1 = $( "#TableRowFooter1" ).clone();
		loFooter1.removeClass( "cTableRowFooter" ).insertAfter( poRow );
		loFooter1.find( psCellSumm ).html( pnListSumm );

		$.ajax({
			type: "POST",
			url: "<?php echo Yii::app()->request->baseUrl . '/protected/models/Helper.php'; ?>",
			data: { 'helper_exec_func': 'HelperSumInWords', 'helper_func_param1': pnListSumm },
		}).done(function(html) {
			loFooter2.find( 'td:last' ).html( "ИТОГО на листе: " + html );
		});
	}
	function lfAddHeader( poRow, pnListNumber ){
		$( "#TableRowHeader" ).clone().insertAfter( poRow );
		var loFooter3 = $( "#TableRowFooter3" ).clone();
		loFooter3.removeClass( "cTableRowFooter" ).insertAfter( poRow );
		loFooter3.find( 'td:last' ).html( 'Лист № ' + pnListNumber );
	}	
</script>

<div id="div_search_result" class="cDivSearchResult">
<?
	if ( $_GET[ 'search_start' ] ){
		if ( $_GET[ 'compensation' ] && Helper::HelperSetBooleanVal( $_GET[ 'compensation' ] ) ){
		} else {
				if ( $_GET[ 'interment' ] && Helper::HelperSetBooleanVal( $_GET[ 'interment' ] ) ){// С погребением
?>
<table id="TableReferences" class="cTableReferences">
	<col style="width:5%;">
	<col style="width:10%;">
	<col style="width:40%;">
	<col style="width:15%;">
	<col style="width:15%;">
	<col style="width:15%;">
	<tr id="TableRowFooter1" class="cTableRowFooter">
		<td colspan=5 class="cTextAlignRight">Сумма</td>
		<td colspan=1 class="cTextAlignRight"></td>
	</tr>
	<tr id="TableRowFooter2" class="cTableRowFooter">
		<td colspan=6 class="cTextAlignRight cTextVAlignTop">Сумма прописью</td>
	</tr>
	<tr id="TableRowFooter3" class="cTableRowFooter">
		<td colspan=6 class="cTextAlignRight">Лист N</td>
	</tr>
	<tr id="TableRowHeaderName" class="cTableRowHeaderName">
		<td colspan=6 class="cTextAlignCenter">С П И С О К</td>
	</tr>
	<tr>
		<td colspan=6 class="cTextAlignCenter">на выплату пенсий пенсионерам МО РФ</td>
	</tr>
	<tr>
		<td colspan=6 class="cTextAlignCenter">с <?=( Helper::HelperDateRusCreate( preg_replace( "/.*([\d]{2}\.[\d]{2}\.[\d]{4})/msi", "$1", $this->model_params[ 'html' ][ 'calcs' ][ $_GET[ 'calcs' ] ] ) ) )?> г.</td>
	</tr>
	<tr>
		<td colspan=6>Сбербанк: <?=( $this->model_params[ 'search_params' ][ 'banks' ][ 'name' ] . ', ' . $this->model_params[ 'search_params' ][ 'banks' ][ 'addr' ] )?></td>
	</tr>
	<tr id="TableRowHeader" class="cTableRowHeader">
		<td><nobr>№№</nobr> пп</td>
		<td>Пенс. дело</td>
		<td>Фамилия, имя, отчество</td>
		<td>Пенс. лист</td>
		<td>Сумма выплат</td>
		<td>Пособие на погребение</td>
	</tr>
<?
			$lnAllSumm = 0;
			for ( $i = 0; $i < count( $this->model_params[ 'data' ] ); $i++ ){
				$lnAllSumm += $this->model_params[ 'data' ][ $i ][ 'value' ];
				$lsRow = '<tr class="cTableDataRow">';
				$lsRow .= '<td class="cTextAlignRight cTextVAlignTop">' . $this->model_params[ 'data' ][ $i ][ 'count' ] . '</td>';
				$lsRow .= '<td class="cTextAlignRight cTextVAlignTop">' . $this->model_params[ 'data' ][ $i ][ 'number' ] . '</td>';
				$lsRow .= '<td class="cTextVAlignTop">' . $this->model_params[ 'data' ][ $i ][ 'fio' ] . '</td>';
				$lsRow .= '<td class="cTextVAlignTop">' . $this->model_params[ 'data' ][ $i ][ 'list_number' ] . '</td>';
				$lsRow .= '<td class="cTextAlignRight cTextVAlignTop">' . $this->model_params[ 'data' ][ $i ][ 'value' ] . '</td>';
				$lsRow .= '<td class="cTextAlignRight cTextVAlignTop">' . ( $this->model_params[ 'data' ][ $i ][ 'value_death' ] ) . '</td>';
				$lsRow .= '</tr>' . "\r\n";
				echo $lsRow;
			}
?>
</table>
<script>
	jQuery(function($){
		$( "#div_search_result" ).width( lnA4Width );
		// Отчет разделён постранично, надо посчитать сколько строк и разделить
		if ( false ){ // demon
			//lnA4Height = 1300;
			var lnListNumber = 2;
			var lnRowHeight = Math.round( $( "#TableRowHeaderName" ).outerHeight() );
			var lnFooterRowsHeight = Math.round( $( "#TableRowHeaderName" ).outerHeight() * 2 );
			var lnHeaderRowsHeight = Math.round( $( "#TableRowHeader" ).outerHeight() * 2 );
			var lnListSumm = 0;

			$( "#TableReferences .cTableDataRow[is_edit!=1]" ).each(function(){
				$(this).attr( "is_edit", 1 );
				lnListSumm += Number( 100 * $(this).find( 'td:eq(-2)' ).html() );
				//if ( typeof( console ) != "undefined" && console ) console.log( $(this).find( 'td:eq(-2)' ) );

				//lnListSumm += Number( $(this).find( 'td:last' ).html() );
				var laTmpPosition = $(this).position();

				var lnDopAppend = ( ( lnListNumber - 2 ) * lnHeaderRowsHeight ) % lnA4Height;
				var lnRelativePositionTop = lnDopAppend + parseInt( parseInt( laTmpPosition.top ) % lnA4Height );

				if ( lnRelativePositionTop > lnA4Height ) lnRelativePositionTop = lnRelativePositionTop - lnA4Height;

				var lnRowBottomPosition = lnRelativePositionTop + $(this).outerHeight();
				var lnBottomPositionFooter = lnRowBottomPosition + lnFooterRowsHeight + ( 2*lnRowHeight - 1 );

				if ( ( ( lnRowBottomPosition < lnA4Height ) && ( lnBottomPositionFooter >= lnA4Height ) ) ){
					//if ( typeof( console ) != "undefined" && console ) console.log( $(this), lnListNumber, lnRowHeight, $(this).outerHeight() );
					//if ( typeof( console ) != "undefined" && console ) console.log( lnA4Height, lnRowBottomPosition, lnBottomPositionFooter );
					lfAddHeader( $(this), lnListNumber++ );
					lfAddFooter( $(this), lnListSumm, 'td:eq(-2)' );
					lnListSumm = 0;
				}
			});
			lfAddFooter( $( "#TableReferences tr:last" ), lnListSumm, 'td:eq(-2)' );
		}
		var lsFooterHtml = '<tr class="cTableDataRow"> \
			<td colspan=6 class="cTextAlignRight cTextVAlignTop" style="border-top: 1px solid #000000;"><?=number_format( $lnAllSumm, 2, '.', '' )?></td> \
			</tr>\r\n \
			<tr class="cTableDataRow" id="TableTrSummItog"> \
			<td colspan=6 class="cTextAlignCenter cTextVAlignTop">ИТОГО</td> \
			</tr>\r\n \
			<tr class="cTableDataRow"> \
			<td colspan=6 class="cTextAlignCenter cTextVAlignTop">Начальник отдела социального и финансового обеспечения</td> \
			</tr>\r\n \
			<tr class="cTableDataRow"> \
			<td colspan=6 class="cTextAlignCenter cTextVAlignTop">воинское звание и ФИО</td> \
			</tr>\r\n \
			<tr class="cTableDataRow"> \
			<td colspan=6 class="cTextAlignCenter cTextVAlignTop">Помощник начальника отдела С и Ф О</td> \
			</tr>\r\n \
			<tr class="cTableDataRow"> \
			<td colspan=6 class="cTextAlignCenter cTextVAlignTop">воинское звание и ФИО</td> \
			</tr>\r\n \
			<tr class="cTableDataRow"> \
			<td colspan=6 class="cTextAlignLeft cTextVAlignTop"><?=( Helper::HelperDateRusCreate( date( 'd.m.Y' ) ) )?> г.</td> \
			</tr>\r\n';
		$( '#TableReferences tbody' ).append( lsFooterHtml );
		$.ajax({
			type: "POST",
			url: "<?php echo Yii::app()->request->baseUrl . '/protected/models/Helper.php'; ?>",
			data: { 'helper_exec_func': 'HelperSumInWords', 'helper_func_param1': '<?=(number_format( $lnAllSumm, 2, '.', '' ))?>' },
		}).done(function(html) {
			$( '#TableTrSummItog' ).find( 'td:last' ).html( "ИТОГО: " + html );
		});
		hideWaitScreen();
	});
</script>
<?
				} else {
?>
<table id="TableReferences" class="cTableReferences">
	<col style="width:5%;">
	<col style="width:10%;">
	<col style="width:40%;">
	<col style="width:15%;">
	<col style="width:13%;">
	<col style="width:17%;">
	<tr id="TableRowFooter1" class="cTableRowFooter">
		<td colspan=6 class="cTextAlignRight">Сумма</td>
	</tr>
	<tr id="TableRowFooter2" class="cTableRowFooter">
		<td colspan=6 class="cTextAlignRight cTextVAlignTop">Сумма прописью</td>
	</tr>
	<tr id="TableRowFooter3" class="cTableRowFooter">
		<td colspan=6 class="cTextAlignRight">Лист N</td>
	</tr>
	<tr id="TableRowHeaderName" class="cTableRowHeaderName">
		<td colspan=6 class="cTextAlignCenter">С П И С О К</td>
	</tr>
	<tr>
		<td colspan=6 class="cTextAlignCenter">на выплату пенсий пенсионерам МО РФ</td>
	</tr>
	<tr>
		<td colspan=6 class="cTextAlignCenter">с <?=( Helper::HelperDateRusCreate( preg_replace( "/.*([\d]{2}\.[\d]{2}\.[\d]{4})/msi", "$1", $this->model_params[ 'html' ][ 'calcs' ][ $_GET[ 'calcs' ] ] ) ) )?> г.</td>
	</tr>
	<tr>
		<td colspan=6>Сбербанк: <?=$this->model_params[ 'html' ][ 'banks' ][ $_GET[ 'banks' ] ]?></td>
	</tr>
	<tr id="TableRowHeader" class="cTableRowHeader">
		<td><nobr>№№</nobr> пп</td>
		<td>Пенс. дело</td>
		<td>Фамилия, имя, отчество получателя пенсии</td>
		<td>Пенс. лист</td>
		<td>Начало выплаты</td>
		<td>Сумма пенсии</td>
	</tr>
<?
			$lnAllSumm = 0;
			for ( $i = 0; $i < count( $this->model_params[ 'data' ] ); $i++ ){
				$lnAllSumm += $this->model_params[ 'data' ][ $i ][ 'value' ];
				$lsRow = '<tr class="cTableDataRow">';
				$lsRow .= '<td class="cTextAlignRight cTextVAlignTop">' . $this->model_params[ 'data' ][ $i ][ 'count' ] . '</td>';
				$lsRow .= '<td class="cTextAlignRight cTextVAlignTop">' . $this->model_params[ 'data' ][ $i ][ 'number' ] . '</td>';
				$lsRow .= '<td class="cTextVAlignTop">' . $this->model_params[ 'data' ][ $i ][ 'fio' ] . '</td>';
				$lsRow .= '<td class="cTextVAlignTop">' . $this->model_params[ 'data' ][ $i ][ 'list_number' ] . '</td>';
				$lsRow .= '<td class="cTextVAlignTop">' . $this->model_params[ 'data' ][ $i ][ 'date' ] . '</td>';
				$lsRow .= '<td class="cTextAlignRight cTextVAlignTop">' . $this->model_params[ 'data' ][ $i ][ 'value' ] . '</td>';
				$lsRow .= '</tr>' . "\r\n";
				echo $lsRow;
			}
?>
</table>
<script>
	jQuery(function($){
		$( "#div_search_result" ).width( lnA4Width );
		// Отчет разделён постранично, надо посчитать сколько строк и разделить
		if ( true ){
			//lnA4Height = 1300;
			var lnListNumber = 2;
			var lnRowHeight = Math.round( $( "#TableRowHeaderName" ).outerHeight() );
			var lnFooterRowsHeight = Math.round( $( "#TableRowHeaderName" ).outerHeight() * 2 );
			var lnHeaderRowsHeight = Math.round( $( "#TableRowHeader" ).outerHeight() * 2 );
			var lnListSumm = 0;

			$( "#TableReferences .cTableDataRow[is_edit!=1]" ).each(function(){
				$(this).attr( "is_edit", 1 );
				lnListSumm += Number( 100 * $(this).find( 'td:last' ).html() );
				//lnListSumm += Number( $(this).find( 'td:last' ).html() );
				var laTmpPosition = $(this).position();

				var lnDopAppend = ( ( lnListNumber - 2 ) * lnHeaderRowsHeight ) % lnA4Height;
				var lnRelativePositionTop = lnDopAppend + parseInt( parseInt( laTmpPosition.top ) % lnA4Height );

				if ( lnRelativePositionTop > lnA4Height ) lnRelativePositionTop = lnRelativePositionTop - lnA4Height;

				var lnRowBottomPosition = lnRelativePositionTop + $(this).outerHeight();
				var lnBottomPositionFooter = lnRowBottomPosition + lnFooterRowsHeight + ( 2*lnRowHeight - 1 );

				if ( ( ( lnRowBottomPosition < lnA4Height ) && ( lnBottomPositionFooter >= lnA4Height ) ) ){
					//if ( typeof( console ) != "undefined" && console ) console.log( $(this), lnListNumber, lnRowHeight, $(this).outerHeight() );
					//if ( typeof( console ) != "undefined" && console ) console.log( lnA4Height, lnRowBottomPosition, lnBottomPositionFooter );
					lfAddHeader( $(this), lnListNumber++ );
					lfAddFooter( $(this), lnListSumm );
					lnListSumm = 0;
				}
			});
			lfAddFooter( $( "#TableReferences tr:last" ), lnListSumm );
		}
		var lsFooterHtml = '<tr class="cTableDataRow"> \
			<td colspan=6 class="cTextAlignRight cTextVAlignTop" style="border-top: 1px solid #000000;"><?=number_format( $lnAllSumm, 2, '.', '' )?></td> \
			</tr>\r\n \
			<tr class="cTableDataRow" id="TableTrSummItog"> \
			<td colspan=6 class="cTextAlignCenter cTextVAlignTop">ИТОГО</td> \
			</tr>\r\n \
			<tr class="cTableDataRow"> \
			<td colspan=6 class="cTextAlignCenter cTextVAlignTop">Начальник отдела социального и финансового обеспечения</td> \
			</tr>\r\n \
			<tr class="cTableDataRow"> \
			<td colspan=6 class="cTextAlignCenter cTextVAlignTop">воинское звание и ФИО</td> \
			</tr>\r\n \
			<tr class="cTableDataRow"> \
			<td colspan=6 class="cTextAlignCenter cTextVAlignTop">Помощник начальника отдела С и Ф О</td> \
			</tr>\r\n \
			<tr class="cTableDataRow"> \
			<td colspan=6 class="cTextAlignCenter cTextVAlignTop">воинское звание и ФИО</td> \
			</tr>\r\n \
			<tr class="cTableDataRow"> \
			<td colspan=6 class="cTextAlignLeft cTextVAlignTop"><?=( Helper::HelperDateRusCreate( date( 'd.m.Y' ) ) )?> г.</td> \
			</tr>\r\n';
		$( '#TableReferences tbody' ).append( lsFooterHtml );
		$.ajax({
			type: "POST",
			url: "<?php echo Yii::app()->request->baseUrl . '/protected/models/Helper.php'; ?>",
			data: { 'helper_exec_func': 'HelperSumInWords', 'helper_func_param1': '<?=(number_format( $lnAllSumm, 2, '.', '' ))?>' },
		}).done(function(html) {
			$( '#TableTrSummItog' ).find( 'td:last' ).html( "ИТОГО: " + html );
		});
		hideWaitScreen();
	});
</script>
<?
			}
		}
	}
?>
</div><!--/div_search_result-->
<script>
	jQuery(function($){
		hideWaitScreen();
	});
</script>