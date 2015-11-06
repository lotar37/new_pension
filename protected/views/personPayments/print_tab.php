<?php
/* @var $this PersonPaymentsController */
$this->breadcrumbs=array(
	'Person Payments',
);
?>

<div id="DivReportMain">

<table class="cTablePayments">
	<col style="width:7%;">
	<col style="width:3%;">
	<col style="width:10%;">
	<col style="width:7%;">
	<col style="width:10%;">
	<col style="width:13%;">
	<col style="width:11%;">
	<col style="width:11%;">
	<col style="width:11%;">
	<col style="width:11%;">
	<col style="width:5%;">
	<tr>
		<th colspan=1 class="cTextAlignCenter cTextVAlignTop">Код выпл.</td>
		<th colspan=1 class="cTextAlignCenter cTextVAlignTop">Д</td>
		<th colspan=1 class="cTextAlignCenter cTextVAlignTop">Номер реестра</td>
		<th colspan=1 class="cTextAlignCenter cTextVAlignTop">Сер док</td>
		<th colspan=1 class="cTextAlignCenter cTextVAlignTop">№ док-та<br>Имя файла</td>
		<th colspan=1 class="cTextAlignCenter cTextVAlignTop">Размер (сумма)</td>
		<th colspan=1 class="cTextAlignCenter cTextVAlignTop">Дата высылки</td>
		<th colspan=1 class="cTextAlignCenter cTextVAlignTop">Начало периода</td>
		<th colspan=1 class="cTextAlignCenter cTextVAlignTop">Конец периода</td>
		<th colspan=1 class="cTextAlignCenter cTextVAlignTop">Дата изв с/банка</td>
		<th colspan=1 class="cTextAlignCenter cTextVAlignTop">ТипД</td>
	</tr>
	<?php
		for ( $i = 0; $i < count( $this->model_params[ 'data' ][ 'data_pays' ] ); $i++ ){ 
			$loRow = $this->model_params[ 'data' ][ 'data_pays' ][ $i ];
	?>
	<tr>
		<td class="cTextAlignRight cTextVAlignTop cBorderRightSolid"><?=$loRow[ 'code' ]?></td>
		<td class="cTextAlignLeft cTextVAlignTop cBorderLeftSolid cBorderRightSolid"></td>
		<td class="cTextAlignRight cTextVAlignTop cBorderLeftSolid cBorderRightSolid"></td>
		<td class="cTextAlignLeft cTextVAlignTop cBorderLeftSolid cBorderRightSolid"></td>
		<td class="cTextAlignLeft cTextVAlignTop cBorderLeftSolid cBorderRightSolid"></td>
		<td class="cTextAlignRight cTextVAlignTop cBorderLeftSolid cBorderRightSolid"><?=$loRow[ 'summa' ]?></td>
		<td class="cTextAlignLeft cTextVAlignTop cBorderLeftSolid cBorderRightSolid"><?=$loRow[ 'date' ]?></td>
		<td class="cTextAlignLeft cTextVAlignTop cBorderLeftSolid cBorderRightSolid"><?=$loRow[ 'begin_date' ]?></td>
		<td class="cTextAlignLeft cTextVAlignTop cBorderLeftSolid cBorderRightSolid"><?=$loRow[ 'end_date' ]?></td>
		<td class="cTextAlignLeft cTextVAlignTop cBorderLeftSolid cBorderRightSolid"></td>
		<td class="cTextAlignLeft cTextVAlignTop cBorderLeftSolid"></td>
	</tr>
	<?php } ?>
</table>

</div><!--DivReportMain-->
