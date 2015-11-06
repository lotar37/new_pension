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
		<td colspan=1 class="cTextAlignCenter cTextVAlignTop">Военный коммисариат</td>
		<td colspan=2 rowspan=4 class="cTextAlignCenter cTextVAlignMiddle">С П Р А В К А</td>
	</tr>
	<tr>
		<td colspan=1 class="cTextAlignCenter cTextVAlignTop"><nobr><div class="cGeoRegionDash">&nbsp;</div> области</nobr></td>
	</tr>
	<tr>
		<td colspan=1 class="cTextAlignCenter cTextVAlignTop"><?=$this->model_params[ 'data' ][ 'case_nom' ][ 'nom_dash' ]?></td>
	</tr>
	<tr>
		<td colspan=1 class="cTextAlignCenter cTextVAlignTop cBorderBottomSolid"><?=$this->model_params[ 'data' ][ 'todayDate' ][ 'analogRus' ]?> г.</td>
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
			Гражданин(ка) <?=$this->model_params[ 'data' ][ 'FIO' ]?> 
<?=Helper::HelperDateToGerman($this->model_params[ 'data' ][ 'model_person' ]->pension_date)?> г. уволен(а) с действительной военной службы
"<?=$this->model_params[ 'data' ][ 'model_dissmiss' ]->name?>" 
с действительной военной службы по достижению
предельного  возраста  с правом на пенсию и в соответствии со ст.17  п.5
Закона Российской Федерации "О статусе военнослужащих"  от 22.01.1993 г.
  освобождается  от  уплаты  земельного налога  и  налога  на  имущество
физических лиц.
			</p>
		</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignCenter cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignCenter cTextVAlignTop">
			<?=$this->model_params[ 'data' ][ 'sign' ][ 'assistant' ][ 'office' ]?><br><?=$this->model_params[ 'data' ][ 'sign' ][ 'assistant' ][ 'rank' ]?>, <?=$this->model_params[ 'data' ][ 'sign' ][ 'assistant' ][ 'fio' ]?>
		</td>
	</tr>
</table>

</div><!--DivReportMain-->
