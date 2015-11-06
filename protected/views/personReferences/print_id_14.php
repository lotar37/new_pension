<?php
/* @var $this PersonReferencesController */
$this->breadcrumbs=array(
	'Person References',
);
?>

<div id="DivReportMain">

<table class="cTableReferences" style="border: 1px solid transparent;width: 100%;">
	<col style="width:33%;">
	<col style="width:33%;">
	<col style="width:33%;">
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
			Дана <?=$this->model_params[ 'data' ][ 'FIO_Dative' ]?> 
в том, что он(а) безупречно прослужил на военной службе <?=Helper::HelperZeroValue( $this->model_params[ 'data' ][ 'seniorities' ][ 'calendar' ][ 'y' ] )?> календарных
лет, <?=Helper::HelperDateRusCreate( Helper::HelperDateToGerman( $this->model_params[ 'data' ][ 'model_person' ][ 'dismiss_date' ] ) )?> г. уволен(а) с действительной  военной  службы 
"<?=$this->model_params[ 'data' ][ 'model_dissmiss' ]->name?>" 
и  в соответствии с пунктом 10 статьи 15 Федерального закона  от  27 мая
1998  года  N76-ФЗ   "О статусе военнослужащих" он(а) и проживающие  с  ним
члены семьи имеют право на оплату в размере 50 процентов:
<ul class="cListStyle">
<li class="cTextAlignJustify cZeroRegion">общей  площади занимаемых ими жилых помещений   (в  коммунальных
помещениях - жилой площади)
</li>
<li class="cTextAlignJustify cZeroRegion">содержания,  ремонта и найма жилых помещений,  а  собственниками
жилых     помещений    и    членами    жилищностроительных    (жилищных)
кооперативов
</li>
<li class="cTextAlignJustify cZeroRegion">содержания и ремонта объектов общего пользования в многоквартирных
жилых домах
</li>
<li class="cTextAlignJustify cZeroRegion">коммунальных услуг (водоснабжение, водоотведение, вывоз бытовых и
других  отходов,  газ, электрическая и тепловая энергия)  независимо  от
вида жилищного фонда
</li>
<li class="cTextAlignJustify cZeroRegion">абонентской платы за пользование  радиотрансляционными  точками,
коллективными телевизионными антеннами.
</li>
</ul>
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
