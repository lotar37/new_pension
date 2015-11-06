<script>	
$( "#dependants_save" ).click(function(event) {
	event.stopPropagation();
  $( "div.dependants" ).hide( "fast" );
});
$( "#dependants_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.dependants" ).hide();
});</script>

<font id='dependants_save' class='button'>Сохранить</font>&nbsp;<font id='dependants_close' class='button'>Отмена</font>
<hr>
<table>

<?php 
foreach($data as $one){
	echo "<tr><td>".$one["second_name"]." ".$one["first_name"]." ".$one["third_name"]."</td><td>| ".$one["birth_date"]."</td></tr>";
}
?>
</table>