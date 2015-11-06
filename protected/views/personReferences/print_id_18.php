<?php
/* @var $this PersonReferencesController */
$this->breadcrumbs=array(
	'Person References',
);
?>

<div id="DivReportMain">

<table class="cTableReferences" style="border: 1px solid transparent;width: 100%;">
	<col style="width:20%;">
	<col style="width:10%;">
	<col style="width:10%;">
	<col style="width:10%;">
	<col style="width:20%;">
	<col style="width:30%;">
	<tr>
		<td colspan=2 class="cTextAlignCenter cTextVAlignTop">Военный коммисариат</td>
		<td colspan=4 rowspan=4 class="cTextAlignCenter cTextVAlignMiddle">Р А С П О Р Я Ж Е Н И Е</td>
	</tr>
	<tr>
		<td colspan=2 class="cTextAlignCenter cTextVAlignTop"><nobr><div class="cGeoRegionDash">&nbsp;</div> области</nobr></td>
	</tr>
	<tr>
		<td colspan=2 class="cTextAlignCenter cTextVAlignTop"><?=$this->model_params[ 'data' ][ 'todayDate' ][ 'analogRus' ]?> г.</td>
	</tr>
	<tr>
		<td colspan=2 class="cTextAlignCenter cTextVAlignTop"><?=$this->model_params[ 'data' ][ 'case_nom' ][ 'nom_dash' ]?></td>
	</tr>
	<tr>
		<td colspan=6 class="cTextAlignLeft cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=4 class="cTextAlignLeft cTextVAlignTop">
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			Отделение сбербанка <span style="float:right;">:</span>
			</p>
		</td>
		<td colspan=2 class="cTextAlignLeft cTextVAlignTop">
			<?=$this->model_params[ 'data' ][ 'data_bank' ][0][ 'name' ]?> <?=$this->model_params[ 'data' ][ 'data_bank' ][0][ 'addr' ]?>
		</td>
	</tr>
	<tr>
		<td colspan=4 class="cTextAlignLeft cTextVAlignTop">
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			Военкомат <span style="float:right;">:</span>
			</p>
		</td>
		<td colspan=2 class="cTextAlignLeft cTextVAlignTop">
			<?=$this->model_params[ 'data' ][ 'data_comm' ][ 'name' ]?>
		</td>
	</tr>
	<tr>
		<td colspan=4 class="cTextAlignLeft cTextVAlignTop">
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			Пенсионер (получатель пенсии) <span style="float:right;">:</span>
			</p>
		</td>
		<td colspan=2 class="cTextAlignLeft cTextVAlignTop">
			<!-- <?=$this->model_params[ 'data' ][ 'FIO' ]?> -->
			<?=$this->model_params[ 'data' ][ 'model_recipient' ]->second_name . ' ' . $this->model_params[ 'data' ][ 'model_recipient' ]->first_name . ' ' . $this->model_params[ 'data' ][ 'model_recipient' ]->third_name ?>
		</td>
	</tr>
	<tr>
		<td colspan=4 class="cTextAlignLeft cTextVAlignTop">
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			Пенсионный лист <span style="float:right;">:</span>
			</p>
		</td>
		<td colspan=2 class="cTextAlignLeft cTextVAlignTop">
			<?=$this->model_params[ 'data' ][ 'model_case' ]->list_number?>
		</td>
	</tr>
	<tr>
		<td colspan=6 class="cTextAlignLeft cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=4 class="cTextAlignLeft cTextVAlignTop">
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			Основание <span style="float:right;">:</span>
			</p>
		</td>
		<td colspan=2 class="cTextAlignLeft cTextVAlignTop">
			Перерасчет с <?=Helper::HelperDateToGerman($this->model_params[ 'data' ][ 'model_case' ]->calc_date)?> г.
		</td>
	</tr>
	<tr>
		<td colspan=6 class="cTextAlignLeft cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=6 class="cTextAlignLeft cTextVAlignTop">
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
				Прошу произвести доплату разницы в пенсии за предыдущий период в сумме
				__СУММА__ руб. __СУММА__ коп. ( __СУММА_СЛОВАМИ__ <!-- <?=Helper::HelperMbUCFirst( Helper::HelperSumInWords( $this->model_params[ 'data' ][ 'model_case' ][ 'saved_summa' ] ) )?> --> )
			</p>
		</td>
	</tr>
	<tr>
		<td colspan=6 class="cTextAlignCenter cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=6 class="cTextAlignCenter cTextVAlignTop">
			<?=$this->model_params[ 'data' ][ 'sign' ][ 'chief' ][ 'office' ]?>
		</td>
	</tr>
	<tr>
		<td colspan=2 class="cTextAlignCenter cTextVAlignTop">М.П.</td>
		<td colspan=4 class="cTextAlignCenter cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=6 class="cTextAlignCenter cTextVAlignTop">
			<?=$this->model_params[ 'data' ][ 'sign' ][ 'assistant' ][ 'office' ]?>
		</td>
	</tr>
	<tr>
		<td colspan=6 class="cTextAlignLeft cTextVAlignTop cBorderBottomSolid">&nbsp;</td>
	</tr>
</table>

</div><!--DivReportMain-->
