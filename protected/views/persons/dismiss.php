<script>
$( "#dismiss_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.dismiss" ).hide( "fast" );
});

  $("._dismiss tr").mousedown(function () {
		name = $(this).attr("name");
		code = $(this).attr("code");
		$("input[name='dismiss']").val(code);
		$("#dismiss_name").text(name);
		$( "div.dismiss" ).hide( "slow" );
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
<table><tr><td><font id='dismiss_close' class='button'>Отмена</font></td>
<td ><font color='white'>Причины увольнения</font></td>
</table>
		<div class='_dismiss row' style="border:3px double white;padding:10px;overflow-y:scroll;overflow-x:hidden;position:absolute;background:#aaa;top:50px;left:50px;height:500px;width:1100px;">
<table>
<?php 	
$dismisses = Dismisses::all();
foreach($dismisses as $one){
//	if (is_numeric ($one->code))$class = 'war_head';
	//else 
	$class = "";
	if(is_numeric($one->code[0])){
		//$num = $one->code[0];
		echo "<tr class='".$class."' code='".$one->code."' name='".$one->name."'><td>".$one->code."</td><td>".$one->name."</td></tr>";
	}
}

?>
</table>
</div>