<script>
$("table.search_form tr").mouseover(function(){
	$(this).addClass("actform");
});
$("table.search_form tr").mouseout(function(){
	$(this).removeClass("actform");
});
$("table.search_form tr").click(function(event){
		event.stopPropagation();
	    window.document.location.href='update/'+$(this).attr("num");	
});
$("#check_all").click(function(event){
	event.stopPropagation();
	if($("#check_all").is(":checked")){
		$("input:checkbox").prop('checked', 'checked');
	}else{
		$("input:checkbox").prop('checked',false); 
	}
});
$("input:checkbox").click(function(event){
	event.stopPropagation();
});
$(".checkbox").click(function(event){
	event.stopPropagation();
});

</script>
	<font color='#fff'>Всего:<?php echo $count;?></font>
<table class='search_form'>
<?php

$class_arr = Cases::$a_types;
if(count($data)){
	
	echo "<th><input type='checkbox' id='check_all'></th><th></th><th>ВП</th><th>П/дело</th><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Дата рождения</th>";
	
    foreach($data as $one){
	    echo "<tr num='".$one['id']."'><td class='checkbox'><input type='checkbox' name='n".$one['id']."'></td><td class='".$class_arr[$one['type']]."'>&nbsp;&nbsp;&nbsp;</td><td>".$one['type']."</td><td>".$one['number']."</td><td> ".$one['second_name']."</td><td> ".$one['first_name']."</td><td> ".$one['third_name']."</td><td> ".Yii::app()->dateFormatter->format("dd.MM.y",$one['birth_date'])." </td></tr>";
	
    }
	echo "</table>";
/*	 $page_count =  intval($count[0]["count"]/30) +1;
	if($page_count>2){
	    echo "<table><tr class='paging'>";
	    for($i=1;$i<=$page_count;$i++){
		    echo "<td> ".$i."</td>";
			if($i==10){
				echo "<td>      Следующие</td>";
				break;
			}
	    }
	    echo "</tr></table>";
	}*/
}else{
	echo "<tr><td>результатов нет</td></tr>";
}
	echo "</table>";

?>

