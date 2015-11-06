<?php
/* @var $this CalcParamsController */
/* @var $model CalcParams */
/* @var $form CActiveForm */
?>

<div class="form">

<style>
td{
	border:1px solid white;
}
</style>
<script>
$(document).keypress(function (e) { 
    //if(hotkeysDisabled)return true;    
     switch(e.which){
 		case 1086:
          //  closeAllWindow("doc");  
 			break;
        //default:alert(" which:" + e.which + " - keyCode:" + e.keyCode );
	}
    switch(e.keyCode){
		case 13:  
			e.stopPropagation();
	        save();
	        $("#inp").hide();
	        //closeAllWindow("");
			break;
	}
            
});
//сохранение по Enter
function save(){
	//
	obj = $("#inp").parent();
	obj.removeClass("active");
	$("#ww2").append($("#inp"));
	val = $("#inp").val();
//if(mouse)$("#inp").val($(curent_obj).text());
	obj.text(val);
	if($("#ww").text() != val){
	    obj.css({"color":"black","background":"#a83"});
	    $.ajax({
		    url : './CalcParams/changeValue',
		    async : true,
		    type : 'POST',
		    data : {
			  	param_id:$(obj).attr("param"),
				group_id:$(obj).attr("group"),
				value:val,
		    },
		    processData : true,
		    contentType : 'application/x-www-form-urlencoded',
		    dataType : 'json'
			
        });

    }	
	
}
$(document).ready(function(){
    $( "#inp" ).hide();
	
    $( "#inp" ).click(function(event) {
	    event.stopPropagation();
    });
    $("#show_input").click(function(event) {
	    $( "#inp" ).show();
    });
	//клик в ячейку со значением параметра
    $("td.param").click(function() {
	  //сохранение при переходе на другую ячейку
	    if(!$(this).hasClass("active")){
	  //
	        $(this).addClass("active");
	        obj = $("#inp").parent();
	        val = $("#inp").val();
	        $("#inp").val($(this).text());
	        if($('#inp').is(':visible'))ex  = 1;
	        else ex = 0;
	        if (ex && ($("#ww").text() != val)){ 
		        $("#inp").parent().css({"color":"black","background":"#a83"});
		        $.ajax({
			        url : './CalcParams/changeValue',
			        async : true,
			        type : 'POST',
			        data : {
				        param_id:$(obj).attr("param"),
				        group_id:$(obj).attr("group"),
				        value:val,
			       },
			       processData : true,
			       contentType : 'application/x-www-form-urlencoded',
			       dataType : 'json'
			
		        });
	     
	        }
	  //сохраняем старое значение в ячейке
	        $("#ww").text($(this).text());
	  //очищаем td
	        $(this).text("");
	  // премещаем input в td
	        $(this).append($("#inp"));
//	  alert($(this).attr("param"));
            $("#inp").show();
            $("#inp").focus();
	        if (ex){ 
	            obj.text(val);
	            obj.removeClass("active");
	        }
	    }
    });
});
</script>
<table style='display:none;'><tr>
<td id='ww'></td>
<td id='ww2'></td>
<td>
<input type='text' size='10' id='inp' style='display:none;'>
</td></tr>
</table>
<br>
<?php 
$arr = CalcParams::getParamsYearArray();
$years = CalcParams::getYearArray();

//var_dump($arr);die();
echo "<table><tr><th></th>";

foreach($years as $year=>$a){
	echo "<th>".$year."</th>";
}
echo "</tr>";
foreach ($arr as $k=>$one){
	echo "<tr><td>".$one["name"]."</td>";
	
	foreach($years as $year=>$a){
		echo "<td year='".$year."' group='".(isset($one["year"][$year]["two"]) ? $one["year"][$year]["two"] : "")."' param='".$k."' class='param'>".(isset($one["year"][$year]["val"]) ? $one["year"][$year]["val"] : "-")."</td>";
	}
	echo "</tr>";
}
echo "</table>";
?>

</div><!-- form -->