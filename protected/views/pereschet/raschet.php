<h1>Результаты расчета</h1>

<table style="width: auto;">
  <tr>
    <td>Расчетная дата:</td>
    <td><?php echo Calculator::date($date);?></td>
  </tr>
  <tr>
    <td>Основание:</td>
    <td><?php echo $basisDocName;?></td>
  </tr>
<tr>
    <td>Обработано дел:</td>
    <td><?php echo $count?> шт.</td>
  </tr>
  <tr>
    <td>Время обработки:</td>
    <td><?php echo round(($time2 - $time1) / 60, 1); ?> мин.</td>
  </tr>
</table>

