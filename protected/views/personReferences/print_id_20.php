<?php
/* @var $this PersonReferencesController */
$this->breadcrumbs=array(
	'Person References',
);
?>
<div id="DivReportMain">

<table class="cTableReferences" style="border: 1px solid transparent;width: 100%;">
	<col style="width:30%;">
	<col style="width:30%;">
	<col style="width:30%;">
	<tr>
		<td colspan=1 class="cTextAlignCenter cTextVAlignTop"><?=$this->model_params[ 'data' ][ 'data_comm' ][ 'name' ]?></td>
		<td colspan=2 rowspan=5 class="cTextAlignCenter cTextVAlignMiddle">С П Р А В К А</td>
	</tr>
	<tr>
		<td colspan=1 class="cTextAlignCenter cTextVAlignTop">военный комиссариат</td>
	</tr>
	<tr>
		<td colspan=1 class="cTextAlignCenter cTextVAlignTop"><?=$this->model_params[ 'data' ][ 'case_nom' ][ 'nom_dash' ]?></td>
	</tr>
	<tr>
		<td colspan=1 class="cTextAlignCenter cTextVAlignTop cBorderBottomSolid"><?=$this->model_params[ 'data' ][ 'todayDate' ][ 'analogRus' ]?> г.</td>
	</tr>
	<tr>
		<td colspan=1 class="cTextAlignCenter cTextVAlignTop"><?=$this->model_params[ 'data' ][ 'data_comm' ][ 'address' ]?></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			Выдана <?=$this->model_params[ 'data' ][ 'rank_Dative' ]?> запаса <?=$this->model_params[ 'data' ][ 'FIO_Dative' ]?> в том, 
			что он <?=Helper::HelperDateRusCreate( Helper::HelperDateToGerman( $this->model_params[ 'data' ][ 'model_person' ][ 'dismiss_date' ] ) )?> г. 
			уволен с военной службы по <?=Helper::HelperDissmissCodeValue( $this->model_params[ 'data' ][ 'model_dissmiss' ]->code, true )?> "<?=$this->model_params[ 'data' ][ 'model_dissmiss' ]->name?>" 
			и его общая продолжительность службы в льготном исчислении составляет <?=Helper::HelperZeroValue( $this->model_params[ 'data' ][ 'seniorities' ][ 'common' ][ 'y' ] )?> лет, а в календарном - <?=Helper::HelperZeroValue( $this->model_params[ 'data' ][ 'seniorities' ][ 'calendar' ][ 'y' ] )?> лет.
			</p>
		</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			Справка дана для предоставления по месту требования.
			</p>
		</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			ОСНОВАНИЕ: пенсионное дело № <?=$this->model_params[ 'data' ][ 'case_nom' ][ 'nom_dash' ]?>
			</p>
		</td>
	</tr>
</table>

</div><!--DivReportMain-->
