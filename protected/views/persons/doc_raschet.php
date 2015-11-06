<?php 
/* @var $this PersonsController */
/* @var $data Persons */
require_once('Numbers/Words/Locale/ru.php');

/*
 * Подготовка данных
 */
$case = $data->cases3;
$person = $case->person0;
$calc = Calculator::calcPension($case->id, false); //print_r($calc);

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
$caption = 'Р А С Ч Е Т<br/>на пенсию';

if ($case->type == 'ВЛ') {
    $caption .= " ЗА ВЫСЛУГУ ЛЕТ";
}

$seniorities_a = array('общая', (int)$seniorities_y['common'], 'календарная', (int)$seniorities_y['calendar'], 'льготная', (int)$seniorities_y['privilege'], 'в МВД', (int)$seniorities_y['mia']);

function money($value) {
    return number_format($value, 2, '.', ''); 
}

function moneyInRussianWords($money) { //die();
    //require_once('Numbers/Words/lang.ru.php');
    require_once('Numbers/Words/Locale/ru.php');        

    list($decimal, $fractional) = explode('.', (string) $money, 2); 
    $fractional = str_pad($fractional, 2, '0', STR_PAD_RIGHT); // NOTE: Без этого нельзя использовать $fractional, поскольку для копеек делящихся на 10 отбрасывается ноль.

    $numStr = new Numbers_Words_Locale_ru;
    return ($numStr->toCurrencyWords($numStr->def_currency, $decimal, $fractional));// . " ($money-$decimal-$fractional)";
}

// Получение даты формата xx месяца yyyy г.
$months = array('января', 'декабря', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'); 
$a = explode('-', date('Y-m-d'));
$rusLongDate = $a[2] . ' ' . $months[(int)$a[1] - 1] . ' ' . $a[0] . ' г.';

// Получение адресной строки
$a0 = array();
if ($person->addrs->house) {
    $a0[] = $person->addrs->house;
}
if ($person->addrs->body) {
    $a0[] = $person->addrs->body;
}
if ($person->addrs->apartment) {
    $a0[] = $person->addrs->apartment;
}
$houseStr = implode('-', $a0);
$a = array();
if ($person->addrs->post_index) {
    $a[] = $person->addrs->post_index;
}
if ($person->addrs->town) {
    $a[] = $person->addrs->town;
}
if ($person->addrs->street) {
    $a[] = $person->addrs->street;
}
if ($houseStr) {
    $a[] = $houseStr;
}
$addrStr = implode(', ', $a); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">

	<!--link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"  -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/_view.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<div class="raschet">
<table>
 <thead>
  <tr>
   <td colspan="2">
        Пенсионное дело <?php echo $case->comm0->code;?> <?php echo $case->number;?>
        ГРВК:<?php echo $case->comm0->name;?>
   </td>
  </tr>
  <tr>
   <td colspan="2" style="text-align: center; padding-bottom: 10px;">
    <?php echo $caption;?>
   </td>
  </tr>
 </thead>
 <tbody>
  <tr>
   <td class="label">Ф И О военнослужащего :</td>
   <td><?php echo $person->second_name . ' ' . $person->first_name . ' ' . $person->third_name;?></td>   
  </tr>
  <tr>
   <td class="label">Воинское звание :</td>
   <td><?php echo $person->rank0->name;?></td>   
  </tr>
  <tr>
   <td class="label">Должность :</td>
   <td><?php echo $person->post_full_name;?></td>   
  </tr>
  <tr>
   <td class="label">Дата и место рождения :</td>
   <td><?php echo $person->birth_date . ' ' . $person->birth_place;?></td>   
  </tr>
  <tr>
   <td class="label">Дата увольнения :</td>
   <td><?php echo $person->dismiss_date;?></td>   
  </tr>
  <tr>
   <td class="label sub"> причина :</td>
   <td><?php echo $person->dismiss0->name;?></td>   
  </tr>
  <tr>
   <td class="label">Пенсия назначена с :</td>
   <td><?php echo $person->pension_date;?></td>   
  </tr>
  <tr>
   <td class="label">Выслуга лет :</td>
   <td style="white-space: nowrap;"><?php echo implode(' ', $seniorities_a);?></td>   
  </tr>
  <tr>
   <td class="label">Трудовая деятельность :</td>
   <td><?php echo $person->is_working ? 'работает' : 'не работает';?></td>   
  </tr>
 </tbody>
</table>

<table>
<tbody>
  <tr>
   <td class="label money">должностной оклад (код <?php echo $case->code_tr;?>)</td>
   <td>: <?php echo money($case->salary_post);?></td>   
  </tr>
  <tr>
   <td class="label money">оклад по в/званию (<?php echo $person->rank0->name?>)</td>
   <td>: <?php echo money($case->salary_rank);?></td>   
  </tr>
  <tr>
   <td class="label money">процентная надбавка за в/лет (<?php echo $case->year_inc_percent;?>%)</td>
   <td>: <?php echo money($calc['NADB']);?></td>   
  </tr>
  <tr>
   <td class="label money">всего</td>
   <td>= <?php echo money($calc['COMMON']);?></td>   
  </tr>
  <tr>
   <td class="label money">учитывается при исчислении пенсии <?php echo $calc['OODS'] * 100;?>%</td>
   <td>= <?php echo money($calc['nachODS']);?></td>   
  </tr>
  <tr>
   <td class="label money">ОСНОВНОЙ РАЗМЕР ПЕНСИИ <?php echo $calc['RAZPEN'];?>%</td>
   <td>= <?php echo money($calc['OSNPR']);?></td>   
  </tr>
  <?php
   $val = $calc['OSNPR'];
   foreach ($calc['markups'] as $k => $v) { 
       if (!$v) {
           continue;
       }
       $val += $v;
       ?>
  <tr>
   <td class="label money">- <?php echo ($calc['markups_names'][$k]); ?></td>
   <td>+ <?php echo money($v);?></td>   
  </tr>
  <?php }?>
  <tr>
   <td class="label money">СУММА ПЕНСИИ В МЕСЯЦ</td>
   <td>= <?php echo money($calc['RESULT']);?></td>   
  </tr>
  <tr>
   <td colspan="2" style="text-align: center;">(<?php echo moneyInRussianWords($calc['RESULT']);?>)</td>
  </tr>
 </tbody>
</table>
 
<div style="text-align: center; padding-left: 150px; line-height:12px;">
Начальник отдела социального и финансового обеспечения
<br>воинское звание и ФИО
<br>Помощник начальника отдела  С И Ф О
<br>воинское звание и ФИО
</div>

<div>
    <?php echo $rusLongDate;?>
</div>

<table>
 <tr>
  <td style="white-space: nowrap;">
    Домашний адрес получателя пенсии:
  </td>
  <td> 
    <?php echo $addrStr;?> <?php echo $person->phone;?>
  </td>
 </tr>
 <tr>
  <td style="white-space: nowrap;">
    Особые условия выплаты пенсии:
    <br>
    Пособие на погребение исчислять из суммы: <?php echo money($calc['RESULT'] * 3);?>.
  </td>
  <td>
  </td>
 </tr>
 <tr>
  <td style="white-space: nowrap;">
    Дата заведения пенсионного дела:
  </td>
  <td>
   <?php echo $case->date;?>
  </td>
 </tr>
 <tr>
  <td style="white-space: nowrap;">
    Удостоверения выданы:
  </td>
  <td>
    <table>
     <tr>
      <td> . . </td>
      <td>пенсионное - </td>
      <td>серия ... </td>
      <td>№ ........ </td>
     </tr>
     <tr>
      <td> . . </td>
      <td>на льготы - </td>
      <td>серия ... </td>
      <td>№ ........ </td>
     </tr>
    </table>
  </td>
 </tr>
</table>

<div style="padding: 10px;">
 <div>Высылка в учрежения Сбербанка разрешений и поручений</div>
 <table class="dispatch">
  <thead>
   <tr>
    <th rowspan="2">№<br/>пп</th>
    <th rowspan="2">Дата высылки</th>
    <th rowspan="2"><span style="white-space: nowrap;">Серия и № разрешения</span> <span style="white-space: nowrap;">№ реестра</span></th>
    <th colspan="2"><nobr>Срок действия</nobr></th>
    <th rowspan="2">Сумма (руб.)</th>
    <th rowspan="2">Учреждение сбербанка</th>
    <th rowspan="2">Дата возврата</th>
   </tr>
   <tr>
    <th>начало</th>
    <th>конец</th>
   </tr>
  </thead>
 </table>   
</div>


</div>
</body>
</html>
