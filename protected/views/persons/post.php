<script>
$( "#post_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.post" ).hide( "fast" );
});
$("#post_save" ).click(function(event) {
	event.stopPropagation();
	var arr = $('.post tr[act=1]');
	var str = "";
	for(var i=0; i<arr.length; i++){
		if($(arr[i]).attr("name") == undefined)continue;
		str += " " + $(arr[i]).attr("name");
	}
   $( "#post_inp" ).val(str.trim());
   $( "div.post" ).hide( "slow" );
	
});
  $(".post tr").mousedown(function () {
		//a = $(this).attr("num");
		if($(this).attr("act")){
			//$(".post tr[num='"+a+"']").css("color","#000");
			$(this).css("color","#000");
			$(this).attr("act",0);
		}
		else{
			$(this).css("color","#ff0");
			$(this).attr("act",1);
		}
	});	
	var s_post = $( "#post_inp" ).val();
	//alert(s_post);
	var a_post = s_post.split(" ");
	for(var i=0;i<a_post.length;i++){
		if(!a_post[i])continue;
		tr = $(".post tr[name='"+a_post[i]+"']");
		a = $(tr).attr("num");
		$(tr).css("color","#ff0");
		$(tr).attr("act",1);
	}

</script>
<table><tr><td colspan='5' style='padding-top:3px'><font id='post_save' class='button'>Сохранить</font>&nbsp;<font id='post_close' class='button'>Отмена</font>
<td><font color='white'>Категории должностей</font></td>
</table>
<div class=' row' style="border:3px double white;padding:10px;overflow-y:scroll;overflow-x:hidden;position:absolute;background:#aaa;top:50px;left:50px;height:500px;width:1100px;">
<table>
<?php 	
$posts = Posts::all();
foreach($posts as $k=>$v){
	//if(is_numeric($v->code[0])){
		//$num = $v->code[0];
		echo "<tr class='' num='".$v->id."' act='' name='".$v->shot_name."'><td>".$v->id."</td><td>".$v->name."</td></tr>";
	//}
}
	
?>
</table>

</div>
