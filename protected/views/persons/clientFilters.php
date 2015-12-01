

<?php
$sql = "SELECT * FROM configs  WHERE name ILIKE 'filter|".Yii::app()->user->name."%' OR name ILIKE 'filter|global%';";
$Result = Cases::dbRequest($sql);
$a = array();
foreach($Result as $one){
	$a_name = explode("|",$one["name"]);
	$a[$one["value"]]=$a_name[2];
}
?> 

 <select id="client_filter" style='font-size:14px;color:#555;margin-top:0em;'>
    <option id="" style='font-size:14px;' value="0"></option>
	 <option value="" style='font-size:14px;'>Показать всех</option>
	<?php
	foreach($a as $k=>$one){
        echo "<option value='$k' style='font-size:14px;'>$one</option>";
	}
	?>
  </select>
