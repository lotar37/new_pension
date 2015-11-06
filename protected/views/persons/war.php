<script>
	$( "#war_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.war" ).hide( "fast" );
});
$( "#war_save" ).click(function(event) {
	event.stopPropagation();
	var arr = $('.war tr[act=true]');
	var str = "";
	for(var i=1; i<arr.length; i++){
		str += " " + $(arr[i]).attr("name");
	}
   $( "#waraction_inp" ).val(str.trim());
   $( "div.war" ).hide( "slow" );
	
});
  $(".war tr").mousedown(function () {
		a = $(this).attr("num");
		if($(this).attr("act")){
			
			if(a<=4){
				$("tr[num='"+a+"']").css("color","#000");
			    $("tr[num='"+a+"']").attr("act","");
			}else{
				$(this).css("color","#000");
				$(this).attr("act","");
			}
		}
		else{
			if(a<=4){
				$("tr[num='"+a+"']").attr("act","");
				$("tr[num='"+a+"']").css("color","#088");
			}
			$(this).css("color","#ff0");
			$(this).attr("act",true);
		}
	});	
	// маркировка активных позиций
	// военные действия
	var s_war = $( "#waraction_inp" ).val();
	var a_war = s_war.split(" ");
	for(var i=0;i<a_war.length;i++){
		if(!a_war[i])continue;
		tr = $(".war tr[name='"+a_war[i]+"']");
		a = $(tr).attr("num");
		if(a<4){
				$(".war tr[num='"+a+"']").attr("act","");
				$(".war tr[num='"+a+"']").css("color","#088");
		}
		$(tr).css("color","#ff0");
		$(tr).attr("act",true);
	}
	
	</script>
<table><tr><td colspan='5' style='padding-top:3px'><font id='war_save' class='button'>Сохранить</font>&nbsp;<font id='war_close' class='button'>Отмена</font>
<td><font color='white'>Код категории пенсионера по Закону "О ветеранах"</font></td>
</table>
		<div class=' row' style="border:3px double white;padding:10px;overflow-y:scroll;overflow-x:hidden;position:absolute;background:#aaa;top:50px;left:50px;height:500px;width:1100px;">
<table>
<?php 	
$actions = WarActions::all();
foreach($actions as $k=>$v){
	if (is_numeric ($v->code))$class = 'war_head';
	else $class = "";
	if(is_numeric($v->code[0])){
		$num = $v->code[0];
		echo "<tr class='".$class."' num='".$num."' act='' name='".$v->shot_name."'><td>".$v->code."</td><td>".$v->name."</td></tr>";
	}
}
	
?>
</table>
</div>