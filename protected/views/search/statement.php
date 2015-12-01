
<h3>Создание пользовательского фильтра</h3>
Название:<input type="text" size='20' name='filter_name' id='filter_name'><br />
<?php

$strn = "";


foreach($_GET as $k=>$v){
	if($v == "")continue;
	if(isset(Cases::$conditionNames[$k])){
		$strn .=($strn =="") ? "$k=$v" : "|$k=$v";
		echo Cases::$conditionNames[$k]."-".getValues($k, $v)."<br />";
	}
}
?>
Для всех пользователей <input type='checkbox' id='for_all'><br />
<button  id='create'> Создать</button><button  id='cancel'>Отменить</button>
<br /><br />
<?php
function getValues($k, $v){
	//if($v == "")return "не установлен";
	$str = "";
	switch($k){
	case "paystop":
	break;
	case "type":
		$a_val = explode("_",$v);
		foreach($a_val as $one){
			$str .= Cases::$a_types_ret[$one].", ";
		}
	break;
	case "age":
		if($v == "0-120")$str = "любой";
		else {
			$a_age = explode("-",$v);
			$str  = "от ".$a_age[0]." до ".$a_age[1]." лет";
		}
	break;
	case "chaes":$str = "Участник";
	break;
	case "gender":
		if($v == "female")$str = "Ж";
		else $str = "M";
	break;
	case "war":
	break;
	}
	return $str;
}

?>
<script>

  function collechSearchCondition(){
	  if(!$('#filter').is(':visible'))return "";
	  //pension types
      $("#h1_title").text("Пенсионные дела");
	  var s_types   = "";
	  var s_age     = "";
	  var s_war     = "";
	  var s_chaes   = "";
	  var s_showall = "";
	  var s_paystop = "";
	  var s_gender  = "";
	  var filter_empty = "";
	  var i = 0; 
      $("#format input:checkbox:checked").each(function(index, elem){
		s_types +=  (s_types ? "_" : "") + $(elem).prop("id");  
		i++;
      }); 
	  //if everyone or no one is selected
	  if(i==0 || i==6){
		  s_types = "";
	  }
	  var i = 0; 
      $("#gender input:checkbox:checked").each(function(index, elem){
		s_gender +=  (s_gender ? "_" : "") + $(elem).prop("id");  
		i++;
      }); 
	  //if everyone or no one is selected
	  if(i==0 || i==2){
		  s_gender = "";
	  }
	  
	  if($("#checkwar").is(":checked"))s_war = 1;
	  if($("#checkchaes").is(":checked"))s_chaes = 1;
	  if($("#showall").is(":checked"))s_showall = 1;
	  if($("#paystop").is(":checked"))s_paystop = 1;
	  
	  s_age =  $( "#slider-range" ).slider( "values", 0 ) + "-" + $( "#slider-range" ).slider( "values", 1 );
	  //alert("&type="+ s_types.trim()+"&age="+s_age.trim()+"&war="+s_war+"&chaes="+s_chaes+"&showall="+s_showall+"&paystop="+s_paystop+"&gender="+s_gender);
	 if(
	  (s_types   == "") &&
	  (s_age     == "0-120") &&
	  (s_war     == "") &&
	  (s_chaes   == "") &&
	  (s_showall == "") &&
	  (s_paystop == "") &&
	  (s_gender  == "") 
	)
	{
	    filter_empty = 1;
    }
	 return "&type="+ s_types.trim()+"&age="+s_age.trim()+"&war="+s_war+"&chaes="+s_chaes+"&showall="+s_showall+"&paystop="+s_paystop+"&gender="+s_gender+"&filter_empty="+filter_empty + "&filter_change=1";
  }

$("#cancel").click(function(){
	$("#statement").hide();
});
$("#create").click(function(){
	if($("#filter_name").val() == ""){alert("Пустое поле имени фильтра.");$("#filter_name").focus()}
    else{
		$.ajax({
		url : './search/saveFilter',
		async : true,
		type : 'GET',
		data : {
			  	filter:'<?php echo $strn;?>',
				filter_name:$("#filter_name").val(),
				prefix:$("#for_all").is(":checked") ? 'global' : '<?php echo Yii::app()->user->name;?>',
		    },
		processData : true,
		contentType : 'application/x-www-form-urlencoded',
		dataType : 'json',
        success: function (data, textStatus) { 
		    if(data == 1){
				$("#client_filter_div").load("./search/clientFilters");
				if(confirm("Фильтр успешно сохранен."))$("#statement").hide();
			}    
		    if(data == 0)
				if(confirm("Такой фильтр уже существует."))$("#statement").hide();
            }
        }); 
    }		
});
</script>
