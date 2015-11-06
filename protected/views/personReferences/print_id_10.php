<?php
/* @var $this PersonReferencesController */
$this->breadcrumbs=array(
	'Person References',
);
mb_internal_encoding( 'UTF-8' );
?>
<div id="DivReportMain">

<table class="cTableReferences" style="border: 1px solid transparent;width: 100%;">
	<col style="width:10%;">
	<col style="width:10%;">
	<col style="width:10%;">
	<col style="width:10%;">
	<col style="width:10%;">
	<col style="width:10%;">
	<col style="width:10%;">
	<col style="width:10%;">
	<col style="width:10%;">
	<col style="width:10%;">
	<tr>
		<td colspan=3 class="cTextAlignCenter cTextVAlignTop"><?=$this->model_params[ 'data' ][ 'case_nom' ][ 'nom_dash' ]?>/<?=$this->model_params[ 'data' ][ 'model_case' ]->type?></td>
		<td colspan=4 class="cTextAlignCenter cTextVAlignTop">К А Р Т О Ч К А</td>
		<td colspan=3 class="cTextAlignCenter cTextVAlignTop">РГВК: <?=mb_strtoupper( $this->model_params[ 'data' ][ 'data_comm' ][ 'name' ] )?></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter cTextVAlignTop">учета пенсионера МО РФ</td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter cTextVAlignTop"><br></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignLeft cTextVAlignTop">ФИО получателя пенсии: <?=$this->model_params[ 'data' ][ 'FIO' ]?></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter cTextVAlignTop"><br></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter cTextVAlignTop">Сведения о военнослужащем</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">ФИО</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">: <?=$this->model_params[ 'data' ][ 'FIO' ]?> &nbsp; <?=Helper::HelperDateToGerman($this->model_params[ 'data' ][ 'model_person' ]->birth_date)?> г.р.</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">Уволен</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">: <?=Helper::HelperDateToGerman($this->model_params[ 'data' ][ 'model_person' ]->dismiss_date)?> по <?=Helper::HelperDissmissCodeValue( $this->model_params[ 'data' ][ 'model_dissmiss' ]->code, true )?><br><?=$this->model_params[ 'data' ][ 'model_dissmiss' ]->name?></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">Умер</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">: <?=Helper::HelperDateToGerman($this->model_params[ 'data' ][ 'model_person' ]->death_date)?> <?=( ( $this->model_params[ 'data' ][ 'model_person' ]->death_date ? Helper::HelperModuleList( 'death_type', $this->model_params[ 'data' ][ 'model_person' ]->is_duty_death ) : '' ) )?></td>
	</tr>
	<!-- ВОЙНА -->
	<? if ( count( $this->model_params[ 'data' ][ 'data_wars' ] ) > 0 ){ ?>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- Война</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">: 
			<?php
				for ( $i=0; $i < count( $this->model_params[ 'data' ][ 'data_wars' ] ); $i++ ){
					echo ( $i > 0 ? '<br>' : '' ) . $this->model_params[ 'data' ][ 'data_wars' ][ $i ][ 'name' ] . ' ';
				}
			?>
		</td>
	</tr>
	<? } ?>
	<!-- ЧАЭС -->
	<? if ( count( $this->model_params[ 'data' ][ 'data_chaes' ] ) > 0 ){ ?>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- ЧАЭС (ПОР)</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">: 
			<?php
				for ( $i=0; $i < count( $this->model_params[ 'data' ][ 'data_chaes' ] ); $i++ ){
					echo ( $i > 0 ? '<br>' : '' ) . $this->model_params[ 'data' ][ 'data_chaes' ][ $i ][ 'prepared_name' ] . ' ';
				}
			?>
			<!--<?=$this->model_params[ 'data' ][ 'chaes_name' ]?>-->
		</td>
	</tr>
	<? } ?>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- Трудовая деятельность</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">: <?=$this->model_params[ 'data' ][ 'working_name' ]?></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">Адрес пенсионера</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">: <?=( $this->model_params[ 'data' ][ 'model_addrs' ]->post_index . ', ' . $this->model_params[ 'data' ][ 'model_addrs' ]->town . ', ' . $this->model_params[ 'data' ][ 'model_addrs' ]->street . ', ' . $this->model_params[ 'data' ][ 'model_addrs' ]->house . '-' . $this->model_params[ 'data' ][ 'model_addrs' ]->apartment . '; тел. ' . $this->model_params[ 'data' ][ 'model_person' ]->phone )?></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">Место работы, должность, размер заработка</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop cBorderBottomSolid">: </td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">Должность</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">: <?=$this->model_params[ 'data' ][ 'model_person' ]->post_full_name?></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter cTextVAlignTop"><br></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignLeft cTextVAlignTop">
			Пенсия назначена с <?=Helper::HelperDateToGerman($this->model_params[ 'data' ][ 'model_person' ]->pension_date)?> пожизненно 
			в сбербанке: "<?=( $this->model_params[ 'data' ][ 'data_bank' ] ? $this->model_params[ 'data' ][ 'data_bank' ][0][ 'name' ] : '' )?>"
			за в/лет <?=Helper::HelperZeroValue( $this->model_params[ 'data' ][ 'seniorities' ][ 'common' ][ 'y' ] )?>/<?=Helper::HelperZeroValue( $this->model_params[ 'data' ][ 'seniorities' ][ 'calendar' ][ 'y' ] )?> в размере  <?=$this->model_params[ 'data' ][ 'model_case' ][ 'pension_percent' ]?>%
		</td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter cTextVAlignTop"><br></td>
	</tr>
	<tr>
		<td colspan=7>
		- должностной оклад (код <?=$this->model_params[ 'data' ][ 'model_case' ][ 'code_tr' ]?>)
		<!-- должностное увеличение -->
		</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop">:</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><?=Helper::HelperNumberFormatMoney( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] )?></td>
		<td colspan=1></td>
	</tr>
	<!--tr>
		<td colspan=1></td>
		<td colspan=6>
		</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop">:</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><?=Helper::HelperNumberFormatMoney( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] )?></td>
		<td colspan=1></td>
	</tr-->
	<tr>
		<td colspan=7>- оклад по в/званию (<?=$this->model_params[ 'data' ][ 'rank_name' ]?>)</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop">:</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><?=Helper::HelperNumberFormatMoney( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] )?></td>
		<td colspan=1></td>
	</tr>
	<tr>
		<td colspan=7>- процентная надбавка за в/лет <?=$this->model_params[ 'data' ][ 'model_case' ][ 'year_inc_percent' ]?>%</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop">:</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><?=Helper::HelperNumberFormatMoney( $this->model_params[ 'data' ][ 'model_case' ][ 'year_inc_percent' ] * ( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] ) / 100 )?></td>
		<td colspan=1></td>
	</tr>
	<tr>
		<td colspan=7>- всего</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop">=</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><?=Helper::HelperNumberFormatMoney( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] + ( $this->model_params[ 'data' ][ 'model_case' ][ 'year_inc_percent' ] * ( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] ) / 100 ) )?></td>
		<td colspan=1></td>
	</tr>
	<tr>
		<td colspan=7>- учитывается при исчислении пенсии <?=($this->model_params[ 'data' ][ 'model_calc' ][ 'OODS' ]*100)?>%</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"></td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><?=Helper::HelperNumberFormatMoney( ($this->model_params[ 'data' ][ 'model_calc' ][ 'OODS' ]) * ( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] + ( $this->model_params[ 'data' ][ 'model_case' ][ 'year_inc_percent' ] * ( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] ) / 100 ) ) )?></td>
		<td colspan=1></td>
	</tr>
	<tr>
		<td colspan=7>ОСНОВНОЙ РАЗМЕР ПЕНСИИ <?=$this->model_params[ 'data' ][ 'model_case' ][ 'pension_percent' ]?>%</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop">=</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><?=Helper::HelperNumberFormatMoney( ($this->model_params[ 'data' ][ 'model_calc' ][ 'OODS' ]) * ( $this->model_params[ 'data' ][ 'model_case' ][ 'pension_percent' ] / 100 ) * ( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] + ( $this->model_params[ 'data' ][ 'model_case' ][ 'year_inc_percent' ] * ( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] ) / 100 ) ) )?></td>
		<td colspan=1></td>
	</tr>
	<!-- ИНВАЛИДНОСТЬ -->
	<? if ( $this->model_params[ 'data' ][ 'model_person' ]->invalid_group ){ ?>
	<tr>
		<td colspan=7>- надбавка инвалиду <?=($this->model_params[ 'data' ][ 'model_person' ]->invalid_group)?> гр.</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop">+</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop">__СУММА__</td>
		<td colspan=1></td>
	</tr>
	<? } ?>
	<!-- ЧАЭС -->
	<? if ( count( $this->model_params[ 'data' ][ 'data_chaes' ] ) > 0 ){ ?>
	<tr>
		<td colspan=7>- надбавка за работу в Зоне</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop">+</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop">__СУММА__</td>
		<td colspan=1></td>
	</tr>
	<? } ?>
	<!-- ВОЙНА -->
	<? if ( count( $this->model_params[ 'data' ][ 'data_wars' ] ) > 0 ){ ?>
	<? } ?>
	<tr>
		<td colspan=7>СУММА ПЕНСИИ В МЕСЯЦ</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop">=</td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><?=Helper::HelperNumberFormatMoney( $this->model_params[ 'data' ][ 'model_case' ][ 'saved_summa' ] )?></td>
		<td colspan=1></td>
	</tr>
	<tr>
		<td colspan=10>&nbsp;&nbsp;( <?=Helper::HelperMbUCFirst( Helper::HelperSumInWords( $this->model_params[ 'data' ][ 'model_case' ][ 'saved_summa' ] ) )?> )</td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter"><br></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter"><br></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter">Подлежит периодической проверке (инвалидность, иждивенцы,возраст,устройство на работу и т.п.)</td>
	</tr>
</table>

</div><!--DivReportMain-->
