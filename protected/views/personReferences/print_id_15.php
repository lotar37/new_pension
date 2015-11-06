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
			Выдана гражданину(ке) <?=$this->model_params[ 'data' ][ 'FIO_Dative' ]?> 
в том, что он(а) безупречно прослужил на военной службе <?=Helper::HelperZeroValue( $this->model_params[ 'data' ][ 'seniorities' ][ 'calendar' ][ 'y' ] )?> календарных
лет, <?=Helper::HelperDateRusCreate( Helper::HelperDateToGerman( $this->model_params[ 'data' ][ 'model_person' ][ 'dismiss_date' ] ) )?> г. уволен(а) с действительной  военной  службы 
"<?=$this->model_params[ 'data' ][ 'model_dissmiss' ]->name?>" и в соответствии со статьей  4 Указа
Президента  Российской  Федерации от 19 февраля 1992 года  №  154  имеет
право  на  получение  безвозмездно в  собственность  занимаемого  жилого
помещения,   независимо  от  его  размера, в  домах  государственного  и
муниципального   жилого  фонда,  в  том  числе  переданного   в   полное
хозяйственное   ведение   предприятий  или  в   оперативное   управление
учреждений.
			</p>
		</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignCenter cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			Справка выдана для представления по месту требования.
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
