<?php
/* @var $this PersonReferencesController */
$this->breadcrumbs=array(
	'Person References',
);
?>

<div id="DivReportMain">

<table class="cTableReferences" style="border: 1px solid transparent;width: 100%;">
	<tr>
		<td class="cTextAlignCenter" style="width: 35%;">МИНИСТЕРСТВО ОБОРОНЫ</td>
		<td colspan=3 rowspan=8></td>
	</tr>
	<tr>
		<td class="cTextAlignCenter">РОССИЙСКОЙ ФЕДЕРАЦИИ</td>
	</tr>
	<!--tr>
		<td class="cTextAlignCenter">__ИМЯ_КОМИССАРИАТА__</td>
	</tr-->
	<tr>
		<td class="cTextAlignCenter">Военный комиссариат</td>
	</tr>
	<!--tr>
		<td class="cTextAlignCenter"><?=$this->model_params[ 'data' ][ 'data_comm' ][ 'name' ]?></td> 
	</tr-->
	<tr>
		<td class="cTextAlignCenter"><nobr><div class="cGeoRegionDash">&nbsp;</div> области</nobr></td> 
	</tr>
	<tr>
		<td class="cTextAlignCenter">Отдел С и Ф О</td>
	</tr>
	<tr>
		<td class="cTextAlignCenter"><?=$this->model_params[ 'data' ][ 'case_nom' ][ 'nom_slash' ]?></td>
	</tr>
	<tr>
		<td class="cTextAlignCenter" style="border-bottom: 1px solid #000000;"><?=$this->model_params[ 'data' ][ 'todayDate' ][ 'analogRus' ]?> г.</td>
	</tr>
	<!--tr>
		<td class="cTextAlignCenter"><?=$this->model_params[ 'data' ][ 'data_comm' ][ 'address' ]?></td>
	</tr-->
	<tr>
		<td class="cTextAlignCenter" colspan=4><br></td>
	</tr>
	<tr>
		<td class="cTextAlignCenter" colspan=4>С П Р А В К А</td>
	</tr>
	<tr>
		<td colspan=4>
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			Выдана гражданину <?=$this->model_params[ 'data' ][ 'FIO_Dative' ]?>  <?=Helper::HelperDateToGerman($this->model_params[ 'data' ][ 'model_person' ]->birth_date)?> года рождения в том, что он является получателем пенсии <?=Helper::HelperModuleList( 'pension_type', $this->model_params[ 'data' ][ 'model_case' ][ 'type' ] )?>, назначенной в соответствии с Законом Российской Федерации от 12.02.1993 г. №4468-1 "О пенсионном обеспечении лиц, проходивших военную службу, службу в органах внутренних дел, Государственной противопожарной службе, органах по контролю за оборотом наркотических средств и психотропных веществ, учреждениях и органах уголовно-исправительной системы, и их семей" с <?=Helper::HelperDateToGerman($this->model_params[ 'data' ][ 'model_person' ]->pension_date)?> г. пожизненно.
			</p>
		</td>
	</tr>
	<tr>
		<td colspan=4>&nbsp;</td>
	</tr>
	<tr>
		<td colspan=4>
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			При назначении пенсии включены периоды:
			</p>
			<p class="cZeroRegion">
			военной службы: ____
			</p>
			<p class="cZeroRegion">
			работы и иной деятельности: ____.
			</p>
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			Справка выдана для решения вопроса об установлении страховой части трудовой пенсии в соответствии с пунктом 6 статьи 3 Федерального закона от 15.12.2001 г. №166-ФЗ "О государственном пенсионном обеспечении в Российской Федерации" (в ред. Федерального закона от 22.07.2008 г. №156-ФЗ "О внесении изменений в отдельные законодательные акты Российской Федерации по вопросам пенсионного обеспечения") территориальными органами ПФР.
			</p>
		</td>
	</tr>
	<tr>
		<td colspan=4>&nbsp;</td>
	</tr>
	<tr>
		<td colspan=4>
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			Основание: пенсионное дело № <?=$this->model_params[ 'data' ][ 'case_nom' ][ 'nom_dash' ]?>
			</p>
		</td>
	</tr>
	<tr>
		<td colspan=4>&nbsp;</td>
	</tr>
	<tr>
		<td class="cTextAlignCenter" colspan=4>
			<?=$this->model_params[ 'data' ][ 'sign' ][ 'chief' ][ 'office' ]?><br><?=$this->model_params[ 'data' ][ 'sign' ][ 'chief' ][ 'rank' ]?>, <?=$this->model_params[ 'data' ][ 'sign' ][ 'chief' ][ 'fio' ]?>
		</td>
	</tr>
</table>

</div><!--DivReportMain-->
