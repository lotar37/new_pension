<?php
/* @var $this PersonReferencesController */
$this->breadcrumbs=array(
	'Person References',
);
?>
<div id="DivReportMain">

<table class="cTableReferences" style="border: 1px solid transparent;width: 100%;">
	<col style="width:30%;">
	<col style="width:50%;">
	<col style="width:20%;">
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
			Выдана гражданину <?=$this->model_params[ 'data' ][ 'FIO_Dative' ]?>
			в том, что он  является пенсионером  Министерства обороны Российской Федерации и получает пенсию 
			<?=Helper::HelperModuleList( 'pension_type', $this->model_params[ 'data' ][ 'model_case' ][ 'type' ] )?>
			, размер которой с <?=Helper::HelperDateRusCreate( $this->model_params[ 'data' ][ 'model_case' ][ 'calc_date' ] )?> г.
			составляет <?=Helper::HelperFormatMoneyShort( Helper::HelperNumberFormatMoney( $this->model_params[ 'data' ][ 'model_case' ][ 'saved_summa' ] ) )?>
			( <?=Helper::HelperMbUCFirst( Helper::HelperSumInWords( $this->model_params[ 'data' ][ 'model_case' ][ 'saved_summa' ] ) )?> ).
			</p>
		</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">&nbsp;</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">
			<p class="cTextAlignJustify cTextIndent cZeroRegion">
			Исчисление размера пенсии:
			</p>
		</td>
	</tr>

	<tr>
		<td colspan=2>
			<p class="cTextIndentList cZeroRegion">
			- должностной оклад (код <?=$this->model_params[ 'data' ][ 'model_case' ][ 'code_tr' ]?>)
			<!-- должностное увеличение -->
			</p>
		</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><span style="float:left;">:</span> <?=Helper::HelperNumberFormatMoney( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] )?></td>
	</tr>
	<!--tr>
		<td colspan=3>
			<p class="cTextIndentList cZeroRegion">
			</p>
		</td>
	</tr-->
	<tr>
		<td colspan=2>
			<p class="cTextIndentList cZeroRegion">
			- оклад по в/званию (<?=$this->model_params[ 'data' ][ 'rank_name' ]?>)
			</p>
		</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><span style="float:left;">:</span> <?=Helper::HelperNumberFormatMoney( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] )?></td>
	</tr>
	<tr>
		<td colspan=2>
			<p class="cTextIndentList cZeroRegion">
			- процентная надбавка за в/лет <?=$this->model_params[ 'data' ][ 'model_case' ][ 'year_inc_percent' ]?>%
			</p>
		</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><span style="float:left;">:</span> <?=Helper::HelperNumberFormatMoney( $this->model_params[ 'data' ][ 'model_case' ][ 'year_inc_percent' ] * ( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] ) / 100 )?></td>
	</tr>
	<tr>
		<td colspan=2>
			<p class="cTextIndentList cZeroRegion">
			- всего
			</p>
		</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><span style="float:left;">=</span> <?=Helper::HelperNumberFormatMoney( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] + ( $this->model_params[ 'data' ][ 'model_case' ][ 'year_inc_percent' ] * ( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] ) / 100 ) )?></td>
	</tr>
	<tr>
		<td colspan=2>
			<p class="cTextIndentList cZeroRegion">
			- учитывается при исчислении пенсии <?=($this->model_params[ 'data' ][ 'model_calc' ][ 'OODS' ]*100)?>%
			</p>
		</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><?=Helper::HelperNumberFormatMoney( ($this->model_params[ 'data' ][ 'model_calc' ][ 'OODS' ]) * ( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] + ( $this->model_params[ 'data' ][ 'model_case' ][ 'year_inc_percent' ] * ( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] ) / 100 ) ) )?></td>
	</tr>
	<tr>
		<td colspan=2>
			<p class="cTextIndentList cZeroRegion">
			ОСНОВНОЙ РАЗМЕР ПЕНСИИ <?=$this->model_params[ 'data' ][ 'model_case' ][ 'pension_percent' ]?>%
			</p>
		</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><span style="float:left;">=</span> <?=Helper::HelperNumberFormatMoney( ($this->model_params[ 'data' ][ 'model_calc' ][ 'OODS' ]) * ( $this->model_params[ 'data' ][ 'model_case' ][ 'pension_percent' ] / 100 ) * ( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] + ( $this->model_params[ 'data' ][ 'model_case' ][ 'year_inc_percent' ] * ( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] ) / 100 ) ) )?></td>
	</tr>
	<!-- ИНВАЛИДНОСТЬ -->
	<? if ( $this->model_params[ 'data' ][ 'model_person' ]->invalid_group ){ ?>
	<tr>
		<td colspan=2>
			<p class="cTextIndentList cZeroRegion">
			- надбавка инвалиду <?=($this->model_params[ 'data' ][ 'model_person' ]->invalid_group)?> гр.
			</p>
		</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><span style="float:left;">+</span> __СУММА__</td>
	</tr>
	<? } ?>
	<!-- ЧАЭС -->
	<? if ( count( $this->model_params[ 'data' ][ 'data_chaes' ] ) > 0 ){ ?>
	<tr>
		<td colspan=2>
			<p class="cTextIndentList cZeroRegion">
			- надбавка за работу в Зоне
			</p>
		</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><span style="float:left;">+</span> __СУММА__</td>
	</tr>
	<? } ?>
	<tr>
		<td colspan=2>
			<p class="cTextIndentList cZeroRegion">
			СУММА ПЕНСИИ В МЕСЯЦ
			</p>
		</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><span style="float:left;">=</span> <?=Helper::HelperNumberFormatMoney( $this->model_params[ 'data' ][ 'model_case' ][ 'saved_summa' ] )?></td>
	</tr>
	<tr>
		<td colspan=3><p class="cTextAlignJustify cTextIndent cZeroRegion">( <?=Helper::HelperMbUCFirst( Helper::HelperSumInWords( $this->model_params[ 'data' ][ 'model_case' ][ 'saved_summa' ] ) )?> )</p></td>
	</tr>

	<!-- Ежемесячные компенсации и доплаты -->

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
</table>

</div><!--DivReportMain-->
