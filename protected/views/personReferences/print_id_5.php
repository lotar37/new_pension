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
		<td colspan=5 class="cTextAlignCenter cTextVAlignTop">Пенсионное дело <?=$this->model_params[ 'data' ][ 'case_nom' ][ 'nom_dash' ]?></td>
		<td colspan=5 class="cTextAlignCenter cTextVAlignTop">ГРВК: <?=mb_strtoupper( $this->model_params[ 'data' ][ 'data_comm' ][ 'name' ] )?></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter cTextVAlignTop"><br></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter cTextVAlignTop">РАСЧЕТ</td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter cTextVAlignTop">на пенсию <span class='cUpperCase'><?=mb_strtoupper( Helper::HelperModuleList( 'pension_type', $this->model_params[ 'data' ][ 'model_case' ][ 'type' ] ) )?></span></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter cTextVAlignTop"><br></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- Ф И О военносужащего</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;<?=$this->model_params[ 'data' ][ 'FIO' ]?></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- воинское звание</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;<?=$this->model_params[ 'data' ][ 'rank_name' ]?></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- должность</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;<?=$this->model_params[ 'data' ][ 'model_person' ]->post_full_name?></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- дата и место рождения</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;<?=Helper::HelperDateToGerman($this->model_params[ 'data' ][ 'model_person' ]->birth_date)?> <?=$this->model_params[ 'data' ][ 'model_person' ]->birth_place?></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- дата увольнения</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;<?=Helper::HelperDateToGerman($this->model_params[ 'data' ][ 'model_person' ]->dismiss_date)?></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignRight cTextVAlignTop">причина</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;<?=Helper::HelperDissmissCodeValue( $this->model_params[ 'data' ][ 'model_dissmiss' ]->code )?> <br><?=$this->model_params[ 'data' ][ 'model_dissmiss' ]->name?></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter"><br></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- пенсия назначена с</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;<?=Helper::HelperDateToGerman($this->model_params[ 'data' ][ 'model_person' ]->pension_date)?></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- выслуга лет</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;общая <?=Helper::HelperZeroValue( $this->model_params[ 'data' ][ 'seniorities' ][ 'common' ][ 'y' ] )?> календарная <?=Helper::HelperZeroValue( $this->model_params[ 'data' ][ 'seniorities' ][ 'calendar' ][ 'y' ] )?> льготная <?=Helper::HelperZeroValue( $this->model_params[ 'data' ][ 'seniorities' ][ 'privilege' ][ 'y' ] )?> в МВД <?=Helper::HelperZeroValue( $this->model_params[ 'data' ][ 'seniorities' ][ 'mia' ][ 'y' ] )?></td>
	</tr>
	<!-- ИНВАЛИДНОСТЬ -->
	<? if ( $this->model_params[ 'data' ][ 'model_person' ]->invalid_group ){ ?>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- инвалидность</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;группа <?=$this->model_params[ 'data' ][ 'model_person' ]->invalid_group?>, причина <?=$this->model_params[ 'data' ][ 'model_person' ]->invalid_reason?>. Срок с <?=Helper::HelperDateToGerman($this->model_params[ 'data' ][ 'model_person' ]->invalid_date)?> по с <?=Helper::HelperDateToGerman($this->model_params[ 'data' ][ 'model_person' ]->invalid_date2)?>.</td>
	</tr>
	<? } ?>
	<!-- ВОЙНА -->
	<? if ( count( $this->model_params[ 'data' ][ 'data_wars' ] ) > 0 ){ ?>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- война</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;
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
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;
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
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- трудовая деятельность</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;<?=$this->model_params[ 'data' ][ 'working_name' ]?></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter"><br></td>
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
		<td colspan=6></td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"></td>
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"></td>
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
		<td colspan=1 class="cTextAlignRight cTextVAlignTop"><?=Helper::HelperNumberFormatMoney( ($this->model_params[ 'data' ][ 'model_calc' ][ 'OODS' ])*( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] + ( $this->model_params[ 'data' ][ 'model_case' ][ 'year_inc_percent' ] * ( $this->model_params[ 'data' ][ 'model_case' ][ 'salary_post' ] + $this->model_params[ 'data' ][ 'model_case' ][ 'salary_rank' ] ) / 100 ) ) )?></td>
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
		<td colspan=10> ( <?=Helper::HelperSumInWords( $this->model_params[ 'data' ][ 'model_case' ][ 'saved_summa' ] )?> )</td>
	</tr>
	
	<!-- Ежемесячные компенсации и доплаты -->
	
	
	<tr>
		<td colspan=10 class="cTextAlignCenter"><br></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter"><br></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter cTextVAlignTop"><?=$this->model_params[ 'data' ][ 'sign' ][ 'chief' ][ 'office' ]?></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter cTextVAlignTop"><?=$this->model_params[ 'data' ][ 'sign' ][ 'chief' ][ 'rank' ]?>, <?=$this->model_params[ 'data' ][ 'sign' ][ 'chief' ][ 'fio' ]?></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter cTextVAlignTop"><?=$this->model_params[ 'data' ][ 'sign' ][ 'assistant' ][ 'office' ]?></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter cTextVAlignTop"><?=$this->model_params[ 'data' ][ 'sign' ][ 'assistant' ][ 'rank' ]?>, <?=$this->model_params[ 'data' ][ 'sign' ][ 'assistant' ][ 'fio' ]?></td>
	</tr>
	<tr class="PageBreakAfter">
		<td colspan=10 class="cTextAlignLeft cTextVAlignTop"><?=$this->model_params[ 'data' ][ 'todayDate' ][ 'analogRus' ]?> г.</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- Домашний адрес получателя пенсии</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;<?=( $this->model_params[ 'data' ][ 'model_addrs' ]->post_index . ', ' . $this->model_params[ 'data' ][ 'model_addrs' ]->town . ', ' . $this->model_params[ 'data' ][ 'model_addrs' ]->street . ', ' . $this->model_params[ 'data' ][ 'model_addrs' ]->house . '-' . $this->model_params[ 'data' ][ 'model_addrs' ]->apartment . '; тел. ' . $this->model_params[ 'data' ][ 'model_person' ]->phone )?></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- Особые условия выплаты пенсии</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;__УСЛОВИЯ__</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- Дата заведения пенсионного дела</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;<?=Helper::HelperDateToGerman( $this->model_params[ 'data' ][ 'model_case' ][ 'date' ] )?></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter"><br></td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop">- Удостоверения выданы</td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;пенсионное - серия ... № ........</td>
	</tr>
	<tr>
		<td colspan=3 class="cTextAlignLeft cTextVAlignTop"></td>
		<td colspan=7 class="cTextAlignLeft cTextVAlignTop">:&nbsp;&nbsp;на льготы - серия ... № ........</td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignCenter"><br></td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignLeft cTextVAlignTop"><br>- Высылка в учреждения Сбербанка разрешений и поручений</td>
	</tr>
	<tr>
		<td colspan=10 class="cTextAlignLeft cTextVAlignTop cZeroSpace">
			<table class="cTableInheritReferences">
				<col style="width:3%;">
				<col style="width:10%;">
				<col style="width:17%;">
				<col style="width:10%;">
				<col style="width:10%;">
				<col style="width:10%;">
				<col style="width:30%;">
				<col style="width:10%;">
				<tr>
					<td colspan=1 rowspan=2 class="cTextAlignCenter cTextVAlignMiddle cBorderTopDouble">№ пп</td>
					<td colspan=1 rowspan=2 class="cTextAlignCenter cTextVAlignMiddle cBorderTopDouble">Дата высылки</td>
					<td colspan=1 rowspan=2 class="cTextAlignCenter cTextVAlignMiddle cBorderTopDouble">Серия и № разрешения<br>№ реестра</td>
					<td colspan=2 rowspan=1 class="cTextAlignCenter cTextVAlignMiddle cBorderTopDouble">Срок действия</td>
					<td colspan=1 rowspan=2 class="cTextAlignCenter cTextVAlignMiddle cBorderTopDouble">Сумма (руб.)</td>
					<td colspan=1 rowspan=2 class="cTextAlignCenter cTextVAlignMiddle cBorderTopDouble">Учреждение сбербанка</td>
					<td colspan=1 rowspan=2 class="cTextAlignCenter cTextVAlignMiddle cBorderTopDouble">Дата возврата</td>
				</tr>
				<tr>
					<td colspan=1 rowspan=1 class="cTextAlignCenter cTextVAlignMiddle">начало</td>
					<td colspan=1 rowspan=1 class="cTextAlignCenter cTextVAlignMiddle">конец</td>
				</tr>
				</table>
		</td>
	</tr>
</table>

</div><!--DivReportMain-->