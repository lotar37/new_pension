<script>
$( "#chaes_save" ).click(function(event) {
	event.stopPropagation();
	var arr = $('.chaes tr[act=true]');
	var str = "";
	for(var i=0; i<arr.length; i++){
		if($(arr[i]).attr("name") == undefined)continue;
		str += " " + $(arr[i]).attr("name");
	}
   $( "#chaes_inp" ).val(str.trim());
   $( "div.chaes" ).hide( "slow" );
	
});

 $(".chaes tr").mousedown(function () {
		a = $(this).attr("num");
		if($(this).attr("act")){
			$(".chaes tr[num='"+a+"']").css("color","#000");
			$(this).attr("act","");
		}
		else{
			$(this).css("color","#ff0");
			$(this).attr("act",true);
		}
	});	
	//должности
	var s_chaes = $( "#chaes_inp" ).val();
	//alert(s_post);
	var a_chaes = s_chaes.split(" ");
	for(var i=0;i<a_chaes.length;i++){
		tr = $(".chaes tr[name='"+a_chaes[i]+"']");
		a = $(tr).attr("num");
		$(tr).css("color","#ff0");
		$(tr).attr("act",true);
	}
$( "#chaes_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.chaes" ).hide();
});
</script>
<table><tr><td colspan='5' style='padding-top:3px'><font id='chaes_save' class='button'>Сохранить</font>&nbsp;<font id='chaes_close' class='button'>Отмена</font>
<td><font color='white'>Ликвидация последствий</font></td>
</table>
		<div class=' row' style="border:3px double white;padding:10px;overflow-y:scroll;overflow-x:hidden;position:absolute;background:#aaa;top:50px;left:50px;height:500px;width:1100px;">
<table>
<?php 	
$chaes = Chaes::all();
foreach($chaes as $k=>$v){
	echo "<tr class='' num='".$v->id."' act='' name='".$v->shot_name."'><td>".$v->id."</td><td>".$v->name."</td></tr>";
}
	
?>
</table>

</div>