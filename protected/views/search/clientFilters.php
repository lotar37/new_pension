<script>
function clearFilter(){
    $( "input:checkbox" ).prop('checked', '');
}
$("#client_filter").change(function(){
	$("#statement").attr("client_filter_change",1);
    clearFilter();
	var arr = $(this).val().split("|");
	for(var i=0;i<arr.length;i++){
		var arr_stat = arr[i].split("=");
		//alert(arr_stat[0]);
		switch(arr_stat[0]){
		case "war":
		$( "#checkwar" ).prop('checked', 'checked');
        break;		
		case "chaes":
		$( "#checkchaes" ).prop('checked', 'checked');
        break;		
		case "gender":
		$( "#"+arr_stat[1] ).prop('checked', 'checked');
        break;		
		case "age":
		$( "#amount" ).val( arr_stat[1] );
		var arr_age = arr_stat[1].split("-");
		$( "#slider-range" ).slider( "values", 0 ,arr_age[0]);
		$( "#slider-range" ).slider( "values", 1 ,arr_age[1]);
        break;		
		case "type":
		var arr_type = arr_stat[1].split("_");
		for(var j=0;j<arr_type.length;j++){
		    $( "#"+arr_type[j] ).prop('checked', 'checked');
		}
        break;		
		}
	}
	//запретить обрабатывать change в slider'e
	
	$("#paystop").button("refresh");
    $("#checkwar").button("refresh");
	$("#checkchaes").button("refresh");
	$("#showall").button("refresh");
	$("#format").buttonset("refresh");
	$("#gender").buttonset("refresh");
	$("#statement").attr("client_filter_change",0);
	
    ajaxRequest = $("#string").serialize();
    $('div#result2').load('loadSearchResult?'+ajaxRequest+"&noCache=" + (new Date().getTime()) + Math.random()+collechSearchCondition());
});
</script>

<?php
$sql = "SELECT * FROM configs  WHERE name ILIKE 'search|".Yii::app()->user->name."%' OR name ILIKE 'search|global%';";
$Result = Cases::dbRequest($sql);
$a = array();

if($_GET["type"]== "select") {
    foreach($Result as $one){
        $a_name = explode("|",$one["name"]);
        $a[$one["value"]]=$a_name[2];
    }
    ?>

	<select id="client_filter" style='font-size:14px;color:#555;margin-top:0em;'>
		<option value="0" style='font-size:14px;'></option>
		<?php
		foreach ($a as $k => $one) {
			echo "<option value='$k' style='font-size:14px;'>$one</option>";
		}
		?>
	</select>
	<?php

}else{
    foreach($Result as $one){
        $a_name = explode("|",$one["name"]);
        $a[$one["name"]]=$a_name[2];
    }

    ?>

	<ol>

		<?php
		foreach ($a as $k => $one) {
			echo "<li value='$k' style='font-size:14px;'><input type='checkbox' />$one</li>";
		}
		?>
	</ol>
	<?php

}

	?>