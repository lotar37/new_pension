<?php
/* @var $this PersonReferencesController */
$this->breadcrumbs=array(
	'Person References',
);
?>

<div id="DivReportMain">

<table class="cTableReferences" style="border: 1px solid transparent;width: 100%;">
	<col style="width:33%;">
	<col style="width:20%;">
	<col style="width:47%;">
	<tr>
		<td colspan=1 class="cTextAlignCenter cTextVAlignTop">Военный коммисариат</td>
		<td colspan=1 rowspan=5 class="cTextAlignCenter cTextVAlignMiddle"></td>
		<td colspan=1 rowspan=2 class="cTextAlignLeft cTextVAlignTop">При всех обращениях ссылаться на пенсионное дело <?=$this->model_params[ 'data' ][ 'case_nom' ][ 'nom_dash' ]?></td>
	</tr>
	<tr>
		<td colspan=1 class="cTextAlignCenter cTextVAlignTop"><nobr><div class="cGeoRegionDash">&nbsp;</div> области</nobr></td>
	</tr>
	<tr>
		<td colspan=1 class="cTextAlignCenter cTextVAlignTop"><?=$this->model_params[ 'data' ][ 'sign' ][ 'office' ][ 'name' ]?></td>
		<td colspan=1 class="cTextAlignLeft cTextVAlignTop">Гр. <?=$this->model_params[ 'data' ][ 'FIO_Dative' ]?></td>
	</tr>
	<tr>
		<td colspan=1 class="cTextAlignCenter cTextVAlignTop"><?=$this->model_params[ 'data' ][ 'todayDate' ][ 'analogRus' ]?> г.</td>
		<td colspan=1 rowspan=2 class="cTextAlignLeft cTextVAlignTop">Адрес: <?=( $this->model_params[ 'data' ][ 'model_addrs' ]->post_index . ', ' . $this->model_params[ 'data' ][ 'model_addrs' ]->town . ', ' . $this->model_params[ 'data' ][ 'model_addrs' ]->street . ', ' . $this->model_params[ 'data' ][ 'model_addrs' ]->house . '-' . $this->model_params[ 'data' ][ 'model_addrs' ]->apartment . '; тел. ' . $this->model_params[ 'data' ][ 'model_person' ]->phone )?></td>
	</tr>
	<tr>
		<td colspan=1 class="cTextAlignCenter cTextVAlignTop">№<?=$this->model_params[ 'data' ][ 'case_nom' ][ 'nom_dash' ]?>/<?=$this->model_params[ 'data' ][ 'model_case' ]->type?></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignCenter cTextVAlignTop">У В Е Д О М Л Е Н И Е</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignCenter cTextVAlignTop">О &nbsp;&nbsp; Н А З Н А Ч Е Н И И &nbsp;&nbsp; П Е Н С И И</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			Сообщаю, что Вам назначена пенсия за <?=mb_strtoupper( Helper::HelperModuleList( 'pension_type', $this->model_params[ 'data' ][ 'model_case' ][ 'type' ] ) )?> в размере <?=$this->model_params[ 'data' ][ 'model_case' ]->saved_summa?>
			рублей в месяц с <?=Helper::HelperDateRusCreate( $this->model_params[ 'data' ][ 'model_person' ]->pension_date )?> г.
			</p>
		</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">&nbsp;</td>
	</tr>

	<!-- ИНВАЛИДНОСТЬ -->
	<? if ( $this->model_params[ 'data' ][ 'model_person' ]->invalid_group ){ ?>
	<? } ?>
	<!-- ВОЙНА -->
	<? if ( count( $this->model_params[ 'data' ][ 'data_wars' ] ) > 0 ){ ?>
	<? } ?>
	<!-- ЧАЭС -->
	<? if ( count( $this->model_params[ 'data' ][ 'data_chaes' ] ) > 0 ){ ?>
	<? } ?>

	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			За  получением  пенсионного  удостоверения  Вам  надлежит прибыть в
			<?=$this->model_params[ 'data' ][ 'data_comm' ][ 'name' ]?> рай(гор)военкомат.
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
