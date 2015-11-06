<?php
$a_age = explode("-",$conditions["age"]);
if(count($a_age)!==2){
	$a_age = array(0,120);
}
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/search_form.css');

?>

<h1 id='h1_title'>
Пенсионные дела
</h1>

<script>
$(document).ready(function(){
    $(function() {
        $("#statement").attr("client_filter_change",1);
        $( "#slider-range" ).slider({
            values: [ <?php echo $a_age[0];?>, <?php echo $a_age[1];?> ],
 	    });
        //console.log(2);

        $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) + " - " + $( "#slider-range" ).slider( "values", 1 ));
        //console.log(3);
    });
});
</script>
<?php
$month = array("январь","февраль","март","апрель","май","июнь","июль","август","сентябрь","октябрь","ноябрь","декабрь","январь","февраль");
$monthnow = date("n");
$class_arr = Cases::$a_types;
$show_number = isset(Yii::app()->request->cookies['show_number']->value)  ? Yii::app()->request->cookies['show_number']->value : Cases::$how_many;

?>
<div class='row type3' id='statement' style='z-index:100;padding-left:10px;' client_filter_change='0'></div>
<table><tr><td class='filter'>
<table
<tr>
<td id='shift'><div id='shiftcontent' style='height:950px;'>>></div></td>
<td class='filterform'>
<div id='filter' style='display:;width:350px;'>
<h4 width='100%' style='background:black;color:white;'>&nbsp;фильтр</h4>
<center>
<h6>Клиентские фильтры <b id='statement_button'>+</b>
</h6>
</center>
<div id='client_filter_div'>
<select style='font-size:14px;color:#555;margin-top:0em;'>
    <option value="" style='font-size:14px;'></option>
    <option value="" style='font-size:14px;'>Показать всех</option>
  </select>
</div>
<h6 width='100%' style='margin-top:1em;'>&nbsp;&nbsp;80 лет</h6>
<table class='eighty'>
<tr><td num='0' style='background:#fdd;'><?php echo $month[$monthnow-1];?>
</td>
<td num='1' style='background:#ffd;'><?php echo $month[$monthnow];?>
</td>
<td num='2' style='background:#dfd;'><?php echo $month[$monthnow+1];?>
</td>
</tr>
</table>
  <label for="amount" style='margin-top: 0em;font-size:18px;'>Возраст:</label>
  <nobr>&nbsp;<input type="text" id="amount" readonly style="border:0; color:#555; font-weight:bold;"></nobr>
<div id="slider-range" width='90%' style='margin:0.5em 1em 0em 1em;'></div>
<div id="format">
<nobr>
<?php 
$typestr = $conditions["type"];
foreach($class_arr as $k=>$one){
	$s = strpos($conditions["type"],$one) !== false ? " checked" : "";
	//echo $one.$s;
	echo '<input type="checkbox" id="'.$one.'" '.$s.'><label style="font-size:12px;width:40px;" for="'.$one.'">'.$k.'</label>';
}
?>
</nobr>
 </div>


<div id='gender'>
<input type="checkbox" id="male" <?php echo $conditions["gender"] == "male"?" checked":""?>><label style="font-size:12px;width:40px;" for="male">Муж</label>
<input type="checkbox" id="female"  <?php echo $conditions["gender"] == "female"?" checked":""?>><label style="font-size:12px;width:40px;" for="female">Жен</label>
</div>

<div id='warchaes'>
 <input type="checkbox" id="checkwar" <?php echo $conditions["war"]?" checked":""?>><label style="font-size:12px;" for="checkwar">Участник БД 
</label>
<input type="checkbox" id="checkchaes" <?php echo $conditions["chaes"]?" checked":""?>><label style="font-size:12px;" for="checkchaes">ЧАЭС 
</label>
</div>
<div id='term' style='display:<?php echo Yii::app()->user->checkAccess('terminatedCases') ? "": "none";?>'>
 <input type="checkbox" id="terminated" <?php echo $conditions["terminated"]?" checked":""?> ><label style="font-size:12px;" for="terminated">Прекращенные ПД
</label>
</div>

<div id='paystop_div'>
<input type="checkbox" id="paystop" <?php echo $conditions["paystop"]?" checked":""?>><label style="font-size:12px;margin:0em 1em 1em 1em;" for="paystop">Заканчиваются выплаты в следующем месяце 
</label>
</div>

<div id='showall_div' >
<input type="checkbox" id="showall"><label style="font-size:12px;" for="showall" style='margin:0em 1em 1em 1em;'>Отобразить все страницы
</label>
</div>
</center>
</div>
</td>
</tr>
</table>
</td>
<td>
<div id='result' style='border:3px double white;padding:10px;display:none;position:absolute;background:#ffd;top:112px;left:10px;width:700px;'></div>
<nobr>
<?php 
//var_dump($conditions);
$_string  = "";
if(isset($_GET['string'])) $_string = $_GET['string'];
if(isset($conditions["string"])) $_string = $conditions["search"];
$class_arr = Cases::$a_types;
echo CHtml::beginForm("",'get', array('id'=>'filter-form'))
. CHtml::textField('string', $_string, array('id'=>'string','size'=>'50','AUTOCOMPLETE'=>"off"))
. CHtml::button('Новое пенсионное дело', array('submit' => array('create')))
. CHtml::endForm();
?>
</nobr>
<div id='result2'>
<table>
<tr>
<td><font color='#fff'>Всего:<?php echo $count[0]["count"];?></font><font color='#fff' style='text-align:right' id='selected'>(0)</font></td>
<td> <div id="sol" style="display:none"> 
 <select name="files" id="files" >
      <optgroup label="Отчеты">
        <option value="jquery" style="10px">Награждения</option>
        <option value="jqueryui"  style="10px">Созидание</option>
      </optgroup>
      <optgroup label="Справки">
        <option value="somefile"  style="10px">Ослабление</option>
        <option value="someotherfile"  style="10px">Нарастание</option>
      </optgroup>
    </select></div>
</td>

</tr></table>
<table class='search_form'>
<?php
if(count($data)){
	$b = ($conditions["anch"] ? $conditions["anch"]-1 : 0)*$show_number +1;
	$i = 0;
	echo "<th><input type='checkbox' id='check_all'></th><th></th><th></th><th>ВП</th><th>П/дело</th><th>Фамилия</th><th>Имя</th><th>Отчество</th><th><nobr>Дата рождения</nobr></th>";
    foreach($data as $one){
	    echo "<tr num='".$one['id']."'><td class='checkbox'><input type='checkbox' name='n".$one['id']."'></td><td>".$b++."</td><td class='".$class_arr[$one['type']]."'>&nbsp;&nbsp;&nbsp;</td><td>".$one['type']."</td><td>".$one['number']."</td><td> ".$one['second_name']."</td><td> ".$one['first_name']."</td><td> ".$one['third_name']."</td><td>".Yii::app()->dateFormatter->format("dd.MM.y",$one['birth_date'])."</td></tr>";
	
    }
	if($i==10)echo "<tr><td>Всего:". $count[0]["count"]."</td></tr>";
	echo "</table>";
	$page_count =  intval($count[0]["count"]/$show_number);
	if($page_count>2  && ($conditions["showall"] !== 1)){
	    echo "<table  class='paging' style=''><tr>";
	    for($i=1;$i<=$page_count;$i++){
			$class = $conditions["anch"] == $i ? "active" : "";
		    echo "<td num='".$i."' class='".$class."'> ".$i."</td>";
			if($i==10){
				echo "<td num='2'>      Следующие>></td>";
				break;
			}
	    }
	    echo "</tr></table>";
	}
}else{
	echo "<tr><td>результатов нет</td></tr></table>
";
}

?>
</div>
</td></tr>
</table>
