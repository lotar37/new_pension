<?php
/* @var $this PersonsController */
/* @var $data Persons */

/*
 * Подготовка данных
 */
$case = $data->cases3;
$person = $case->person0;
$calculator = Calculator::calcPension($case->id, false); //print_r($calc);

$seniorities_y = array();
if (isset($person->seniorities)) {
    foreach($person->seniorities as $seniority) {
        if ($seniority->type == "y") {
            $seniorities_y[$seniority->class] = $seniority->value;
        }
    }
} //print_r($seniorities_y);

/*
 * Подготовка представлений данных
 */
function money($value) {
    return number_format($value, 2, '.', ''); 
}

$params = Calculator::getAssoc("SELECT id, description FROM calc_params ORDER BY id");
?>
<div class="pereraschet">
<table>
 <thead>
  <tr>
   <th>Дата перерасчета</th>
   <th>Осн.<br/>пер</th>
  <?php foreach ($params as $paramID => $capt) {?>
  <th><?php echo $capt;?></th>
  <?php }?>
  </tr>
 </thead>
 <tbody>
<?php foreach ($case->calcs as $calc) {
    $values = Calculator::getAssoc("SELECT param, value FROM calc_group_params WHERE \"group\" = {$calc->calc_group}");
    ?>
  <tr>
   <td><?php echo Calculator::date($calc->calcGroup->date);?></td>
   <td><?php echo $calc->basisDoc->code;?></td>
  <?php foreach ($params as $paramID => $capt) {?>
   <td><?php echo isset($values[$paramID]) ? $values[$paramID] : "---";?></td>
  <?php }?>
  </tr>
<?php } ?>
 </tbody>
</table>
</div>
