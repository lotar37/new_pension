
<script>
$("#lp_selector").change(function(){
	var parent = $(this).val();
	if(parent >= 4)$("#lp_select").load("../loadServicePeriodSelect?parent=" + parent);
	
});
</script>


<?php
//var_dump($_GET);die();
if(!$_GET["parent"] ){
?>
<select size='1' width='10' id="lp_selector" style='font-size:14px;color:#fff;margin-top:0em;width:150px;'>
<?php
	$sql = "SELECT * FROM klg  WHERE id >=4 and id<=9;";
	$Result = Cases::dbRequest($sql);
	$a = array();
	foreach($Result as $one){
		$a[$one["id"]]=$one["name"];
	}
?> 

	<?php
	echo "<option value='0' style='font-size:12px;'></option>";
	foreach($a as $k=>$one){
        echo "<option value='$k' style='font-size:12px;'>$one</option>";
	}
	?>
	</select>

	<?php
}else if($_GET["parent"]>=4 && $_GET["parent"]<=9){
?>
<select  size='1'   id="lp_selector" style='font-size:14px;color:#fff;margin-top:0em;width:150px;'>
<?php
	$sql = "SELECT * FROM klg  WHERE parent ='".$_GET["parent"]."';";
	$Result = Cases::dbRequest($sql);
	$a = array();
	foreach($Result as $one){
		$a[$one["id"]]=$one["name"];
	}
	if(!count($a))echo "<option value='0' style='font-size:14px;'>подпункты отсутствуют</option>";
	else echo "<option value='0' style='font-size:12px;'></option>";
	foreach($a as $k=>$one){
        echo "<option value='$k' style='font-size:12px;'>$one</option>";
	}
	?>
	</select>
	<?php
	
}else{
	$sql = "SELECT * FROM klg  WHERE id ='".$_GET["parent"]."';";
	$Result = Cases::dbRequest($sql);
	foreach($Result as $one){
		echo "<font nvl='".$one["nvl"]."' id='".$one["id"]."'>".$one["code"]."</font>";
	}
	
}
?>

