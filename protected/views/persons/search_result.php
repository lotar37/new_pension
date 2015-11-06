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
$("#sel").change(function(event){
		event.stopPropagation();
	//alert($(this).val());
    $.ajax({
		url : '../persons/showNumber',
		async : true,
		type : 'GET',
		data : {
			  	show_number:$(this).val(),
		    },
		processData : true,
		contentType : 'application/x-www-form-urlencoded',
		dataType : 'json',
        complete : function (data) { 
			ajaxRequest = $("#string").serialize();
			$('div#result2').load('loadSearchResult?'+ajaxRequest+"&noCache=" + (new Date().getTime()) + Math.random()+collechSearchCondition()+"&anch=1");
        }
    });        
	ajaxRequest = $("#string").serialize();
	$('div#result2').load('loadSearchResult?'+ajaxRequest+"&noCache=" + (new Date().getTime()) + Math.random()+collechSearchCondition()+"&anch=1");
});
$(".paging td").click(function(event){
	//alert($(this).attr("num"));
	if($(this).hasClass("nopaging"))return false;
     ajaxRequest = $("#string").serialize();
     $('div#result2').load('loadSearchResult?'+ajaxRequest+"&noCache=" + (new Date().getTime()) + Math.random()+collechSearchCondition()+"&anch="+$(this).attr("num"));
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
$(".search_form input:checkbox").click(function(event){
	var len= $(".search_form input:checkbox:checked").length;
	if(len>0)$("#sol").css("display","");
	else $("#sol").css("display","none");
	$("#selected").html("("+ len+")");
	
});
$(".checkbox").click(function(event){
	event.stopPropagation();
});
   // $( "#files" ).selectmenu();

</script>
<style>
    xfieldset {
      border: 0;
    }
    label {
      display: block;
      margin: 30px 0 0 0;
 	  font-size:12px;
   }
    select {
      width: 200px;
	  height:20px;
	  font-size:12px;
    }
	option{
	  !font-size:6pt;
		
	}
    .overflow {
      height: 200px;
    }
	.paging{
	border-spacing: 7px;
	width:200px;
}
.paging td{
	padding:5px;
	margin:5px;
	!background:#ddd;
	cursor:pointer;
	vertical-align:center;
	color:#fff;
}
.paging td.active{
	padding:5px;
	margin:5px;
	cursor:pointer;
	font-weight:bold;
	font-size: 24px;
}
</style>
<table>
<tr>
<td><nobr><font color='#fff'>Всего:<?php echo $count[0]["count"];?></font>
<font color='#fff' style='text-align:right' id='selected'>(0)</font></nobr></td>
<td> <div id="sol" style="display:none"> 
 <select name="files" id="files" >
      <optgroup label="Отчеты">
        <option value="jquery">Награждения</option>
        <option value="jqueryui">Созидание</option>
      </optgroup>
      <optgroup label="Справки">
        <option value="somefile">Ослабление</option>
        <option value="someotherfile">Некоторое ожидание</option>
      </optgroup>
    </select></div>
</td>
</tr></table>
<table class='search_form'>
<?php

$show_number = isset(Yii::app()->request->cookies['show_number']->value)  ? Yii::app()->request->cookies['show_number']->value : Cases::$how_many;

$class_arr = Cases::$a_types;
if(!isset($conditions))$conditions=array("anch"=>1,"showall"=>0);
if(count($data)){
	
	echo "<th><input type='checkbox' id='check_all'></th><th>№</th><th></th><th>ВП</th><th>П/дело</th><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Дата рождения</th>";
	$i = 0;
	$b = ($conditions["anch"] ? $conditions["anch"]-1 : 0)*$show_number+1;
    foreach($data as $one){
	    echo "<tr num='".$one['id']."'><td class='checkbox'><input type='checkbox' name='n".$one['id']."'></td><td>".$b++."</td><td class='".$class_arr[$one['type']]."'>&nbsp;&nbsp;&nbsp;</td><td>".$one['type']."</td><td>".$one['number']."</td><td> ".$one['second_name']."</td><td> ".$one['first_name']."</td><td> ".$one['third_name']."</td><td> ".Yii::app()->dateFormatter->format("dd.MM.y",$one['birth_date'])." </td></tr>";
		
		if(++$i>1500)break;
    }
	echo "</table>";
	$page_count =  intval($count[0]["count"]/$show_number) +1;
	 
	if($page_count>=2 && ($conditions["showall"] !== 1)){
		$i_begin = $conditions["anch"]>6 ? $conditions["anch"] - 5 : 1;
		$i_end = $i_begin + 9;
	    echo "<table  class='paging' style=''><tr>";
		if($conditions["anch"]>1)echo "<td num='".($conditions["anch"]-1)."'>      <<Предыдущие</td>";
		
	    for($i=$i_begin;$i<=$page_count;$i++){
			$class = $conditions["anch"] == $i ? "active" : "";
		    echo "<td num='".$i."' class='".$class."'> ".$i."</td>";

			if($i==$i_end){
				break;
			}
	    }
			?>
			<td class='nopaging'>
				<select name="sel" id="sel" style='width:60px;'>
					<option value="20">20</option>
					<option value="25">25</option>
					<option value="30">30</option>
					<option value="50">50</option>
					<option value="100">100</option>
					<option value="200">200</option>
				</select>
			</td>
			
			
			<?php				echo "<td num='".($conditions["anch"]+1)."'>      Следующие>></td>";
	    echo "</tr></table>";
	}else if($page_count==1){
			?>
			<tr><td>Выводить найденные записи по </td>
			<td class='nopaging'>
				<select name="sel" id="sel" style='width:60px;'>
					<option value="20">20</option>
					<option value="25">25</option>
					<option value="30">30</option>
					<option value="50">50</option>
					<option value="100">100</option>
					<option value="200">200</option>
				</select>
			</td>
			</tr>
			
			<?php
	}
}else{
		echo "<tr><td>результатов нет</td></tr>";
	}
	echo "</table>";

?>
<script>
$("#sel").val('<?php echo $show_number;?>');
</script>

