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
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop"></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop"></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			Выдана <?=$this->model_params[ 'data' ][ 'FIO_Dative' ]?> 
проживающему по адресу: <?=( $this->model_params[ 'data' ][ 'model_addrs' ]->post_index . ', ' . $this->model_params[ 'data' ][ 'model_addrs' ]->town . ', ' . $this->model_params[ 'data' ][ 'model_addrs' ]->street . ', ' . $this->model_params[ 'data' ][ 'model_addrs' ]->house . '-' . $this->model_params[ 'data' ][ 'model_addrs' ]->apartment . '; тел. ' . $this->model_params[ 'data' ][ 'model_person' ]->phone )?> 
в том, что в соответствии с Федеральным законом от 27 мая 1998
года  N76-ФЗ  "О  статусе военнослужащих" он имеет право  на  льготы по
оплате  занимаемой им и проживающими с ним членами семьи жилой  площади,
независимо  от  ее  размера, в  доме  государственного  (муниципального)
жилищного  фонда, в том числе переданного в полное хозяйственное ведение
предприятий  или  в  оперативное  управление  учреждений,  за  установку
квартирного  телефона, а также внесение абонентной платы за  пользование
им, за пользование радио и коллективной телевизионной антенной в размере
50 процентов, если она не вступила в повторный брак.
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
