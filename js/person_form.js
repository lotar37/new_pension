function closeAllWindow(exeption){
	//alert(1111111111111111111111);
    arr = new Array("adress","war","post","sber","snils","doc","chaes","resolution","seniorities","pererast","dismiss","dependants");
	ext = 0;
    for(var i=0;i<arr.length;i++){
	    if($("div."+arr[i]).is(':visible'))ext  = 1;
	    if(arr[i] != exeption)$("div."+arr[i]).hide();
    } 
		//alert(ext + " - " + (exeption==""));

	if(!ext && (exeption=="")){
		//alert("йесс:" + $(document.location).attr("href"));
		//$(document.location).attr("href",'http://ya.ru')
		//$(document.location).attr("href",'../../persons/persearch/');
		//document.forms[0].submit();
		//alert("йесс:" + $(document.location).attr("href"));
		//$("html").load('../../dismisses/admin');
	    //document.location.href ='http://ya.ru';	
		//document.location.replace("http://yandex.ru");
		//$(document).load('../../persons/persearch');
	   // window.location.href='../../persons/persearch';	
	}
}
$('input, textarea').focus(function(){hotkeysDisabled=true;}).blur(function(){hotkeysDisabled=false});
$("#stash").click(function(){
	if($(this).prop("val") == 1){ 
		$(this).prop("val",0);
	    $(this).text("ВЫСЛУГА ЛЕТ на пенсию");
		$("#include_seniority").prop('checked', '');
	}else{
		$(this).prop("val",1);
	    $(this).text("ТРУДОВОЙ СТАЖ на пенсию");
		$("#include_seniority").prop('checked', 'checked');
	}
});
function clearSenContainer(){
	$("#sen_cal_date1").val("");
	$("#sen_cal_date2").val("");
	$("#sen_cal_name").val("");
	$("#sen_cal_y").html("");
	$("#sen_cal_m").html("");
	$("#sen_cal_d").html("");
	$("#seniorities_calendar").css("display","");
	$("#sen_cal_add").css("display","none");
	$("#sen_cal_date1").focus();
}
$("#save_form").click(function(){
	document.forms[0].submit();
	//location.href = "/persons/persearch/";
});
$(document).keypress(function (e) { 
//alert(" which:" + e.which + " - keyCode:" + e.keyCode );
	kostil = true;
	if(e.which == 13)e.stopPropagation();

	if((e.which == 43 || e.keyCode == 27) && ($("#person").attr("seniority") == "seniority" || $("#person").attr("seniority") == "senioritiesCount"))kostil = false;
	if((e.keyCode == 40 || e.keyCode == 39) && $("#person").attr("seniority") == "senioritiesCount")kostil = false;
//alert(kostil + );
    if(hotkeysDisabled && kostil)return true;    
    switch(e.which){
		case 1051:  
			closeAllWindow("sber");  
            $( "div.sber" ).toggle( "fast" );
			break;
		case 1040:
            closeAllWindow("adress");  
            $( "div.adress" ).toggle( "fast" );
			break;
		case 1042:
            closeAllWindow("war");  
            $( "div.war" ).toggle( "fast" );
			break;
		case 1063:
            closeAllWindow("chaes");  
            $( "div.chaes" ).toggle( "fast" );
			break;
 		case 1060:
            closeAllWindow("snils");  
            $( "div.snils" ).toggle( "fast" );
			break;
 		case 1086:
            closeAllWindow("doc");  
            $( "div.doc" ).toggle( "fast" );
			break;
		case  96, 90, 1071: 
	        closeAllWindow("");
			break;
		case 43:
			var sen = $("#person").attr("seniority");
			//alert(sen);
			if(sen == ""){
				closeAllWindow("seniorities");  
				if($( "div.seniorities").html() == "") $("div.seniorities").load("../seniorities/"+$("#person").attr("number"));
				$( "div.seniorities" ).show( "fast" );
				hotkeysDisabled=true;
				$("#person").attr("seniority","seniority");
			}
			if(sen == "seniority"){
				senioritiesCount();
				$("#person").attr("seniority","senioritiesCount");
			}
			if(sen == "senioritiesCount"){
				$("#seniorities_calendar").appendTo($("#new_calendar_container"));
				$("#sen_cal_date1").val("");
				$("#sen_cal_date2").val("");
				$("#sen_cal_name").val("");
				$("#sen_cal_y").html("");
				$("#sen_cal_m").html("");
				$("#sen_cal_d").html("");

				$("#seniorities_calendar").css("display","");
				$("#sen_cal_date1").focus();
			}
			break;
		case 13:
			e.stopPropagation();
		break;
        //default:alert(" which:" + e.which + " - keyCode:" + e.keyCode );
	}
	var a_sk = new Array();        
    switch(e.keyCode){
		case 120:  
	        window.open('../../persons/raschet/'+$("#person").attr("number"), "raschet");
			break;
		case 39:
		case 40:
			var parent_id = $("#seniorities_calendar").parent().attr("id");
			if(parent_id == "calendar_container"){
				$("#seniorities_calendar").appendTo($("#new_study_container"));
				clearSenContainer();				
			}
			if(parent_id == "study_container"){
				$("#seniorities_calendar").appendTo($("#new_lp_container"));
				clearSenContainer();			
				$("th.lp").css("display","");
			}
			if(parent_id == "lp_container"){
				$("#seniorities_calendar").appendTo($("#new_calendar_container"));
				clearSenContainer();
			}
		break;
		case 27:  
			var sen = $("#person").attr("seniority");
			//alert(sen);
			if(sen=="seniority"){
				$( "div.seniorities" ).hide();
				$("#person").attr("seniority","");
				hotkeysDisabled = false;
				////alert($("#persons-form"));
			}
			else if(sen=="senioritiesCount"){
				$("div.seniorities").html("");
				$( "div.seniorities" ).css("left","150px");
				$( "div.seniorities" ).css("top","250px");
				$( "div.seniorities" ).css("width","600px");
				$( "div.seniorities" ).css("height","310px");
				$("#person").attr("seniority","seniority");
				$("div.seniorities").load("../seniorities/"+$("#person").attr("number"));			
			}else closeAllWindow("");
			break;
	}
            
});
function senioritiesCount(){
 // $( "#seniorities_card" ).hide();
  $( "div.seniorities" ).html("");
  $( "div.seniorities" ).css("width","1000px");
  $( "div.seniorities" ).css("top","80px");
  $( "div.seniorities" ).css("left","80px");
  $( "div.seniorities" ).css("height","600px");
   $("div.seniorities").load("../senioritiesCount/"+$("#person").attr("number"));  
	
}
hotkeysDisabled = false;
  $prop = {
      showOn: "button",
      buttonImage: "../../../images/calendar.gif",
      buttonImageOnly: true,
      buttonText: "Выбор даты"
    };

$( "#res_end_action_date" ).datepicker( $prop  );
$( "#res_sent_date" ).datepicker( $prop  );
$( "#res_begin_action_date" ).datepicker( $prop  );
$( "#doc_give_date" ).datepicker( $prop  );
$( "#birth_date" ).datepicker($prop );
$( "#death_date" ).datepicker(  $prop );
$( "#dismiss_date" ).datepicker( $prop  );
$( "#pension_date" ).datepicker( $prop  );
$( "#invalid_date" ).datepicker( $prop  );
$( "#invalid_date2" ).datepicker( $prop  );
//$( "#invalid_date2" ).datepicker( $.datepicker.regional[ "ru" ] );

$("#pereraschet_div").load("../pereraschet/"+$("#person").attr("number"));


var arr_id = {"f":"adress", "fwar":"war", "pereraschet":"pererast", "fdependants":"dependants", "fdismiss":"dismiss", "fpost":"post", "fchaes":"chaes", "fsber":"sber", "fsnils":"snils", "fdoc":"doc", "fresolution":"resolution", "fseniorities":"seniorities"};
$( "#f, #fwar,#fdependants,#pereraschet,#fdismiss,#fpost,#fchaes,#fsber,#fsnils,#doc, #fresolution,#fseniorities" ).click(function() {
  var window_id = arr_id[$(this).attr("id")];
  closeAllWindow(window_id);  
  //загрузка, если еще не открывали
  if($( "div."+window_id ).html() == "") $("."+window_id).load("../"+window_id+"/"+$("#person").attr("number"));
  $( "div." + window_id ).toggle( "fast" );
});

$( "#stash" ).click(function(event) {
	event.stopPropagation();
  $( "div.adress" ).hide( "fast" );
});


$( "#pererast_save, #pererast_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.pererast" ).hide( "fast" );
});

$( "#doc_save,#doc_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.doc" ).hide( "fast" );
});

$( "#resolution_save" ).click(function(event) {
	event.stopPropagation();
	$("input[name='_form_ser_res']").attr("value",$("input[name='res_ser']").val());
	$("input[name='_form_res_number']").attr("value",$("input[name='res_number']").val());
	$("input[name='_form_sent_date']").attr("value",$("input[name='res_sent_date']").val());
	$("input[name='_form_begin_action_date']").attr("value",$("input[name='res_begin_action_date']").val());
	$("input[name='_form_end_action_date']").attr("value",$("input[name='res_end_action_date']").val());
  $( "div.resolution" ).hide( "fast" );
});
$( "#resolution_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.resolution" ).hide();
});

$( "#snils_save" ).click(function(event) {
	event.stopPropagation();
  $( "div.snils" ).hide( "fast" );
});
$( "#snils_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.snils" ).hide();
});

$( "#sber_save" ).click(function(event) {
	event.stopPropagation();
  $( "div.sber" ).hide( "fast" );
});
$( "#sber_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.sber" ).hide();
});
$( "#f_close" ).click(function(event) {
	event.stopPropagation();
});
$( "#raschet" ).click(function(event) {
	window.open('../../persons/raschet/'+$("#person").attr("number"), "raschet");
});
$( "#isch" ).click(function(event) {
	window.open('../../persons/isch/'+$("#person").attr("number"), "isch");
});
$( "#f_close" ).click(function(event) {
	event.stopPropagation();
  $( "div.adress" ).hide( );
});
$("#post_full_name").blur(function(event){
	$(this).val($(this).val().toUpperCase());
});
$("#pdelo").blur(function(event){
    $.ajax({
		url : '../casesNumberCheck',
		async : true,
		type : 'GET',
		data : {
			  	number:$("#pdelo").val(),
				id:$("#person").attr("number"),
		    },
		processData : true,
		contentType : 'application/x-www-form-urlencoded',
		dataType : 'json',
        success: function (data, textStatus) { 
		    if(data == 1)
				if(confirm("Такой номер пенсионного дела уже есть в базе.\n Введите другой номер."))$("#pdelo").focus();
         }
    });        
});

function collectAddrInfo(){
	var index = $( "#index" ).val();
	var city = ($( "#city" ).val() ? " г." + $( "#city" ).val() : "" );
	var street = ( $( "#street" ).val() ?  " ул." + $( "#street" ).val() : "" );
	var home = ($( "#home" ).val() ? "д." + $( "#home" ).val() : "");
	var body = $( "#body" ).val() ?  "кор." + $( "#body" ).val() : "" ;
 	var apartment = ($( "#apartment" ).val() ?  "кв." + $( "#apartment" ).val() : "");
	return index + " " + city + " " + street + " " + home + " " + body + " " + apartment;	
}
$( "#f_save" ).click(function(event) {
	event.stopPropagation();
  $( "#adress" ).val(collectAddrInfo());
  $( "div.adress" ).hide( "slow" );
});
function checkCardType(){
	var type = $("#_types").val();
	if(type == "ПК"){
		$("#dismiss").css("display","none");
		$("#death").css("display","");
	}else{
		$("#dismiss").css("display","");
		$("#death").css("display","none");
	}
	switch(type){
	case "ИН":$("#carthead").css("background","#00f");
		$("#carthead").css("color","yellow");
		$("#type_text").text("по инвалидности");
	break;
	case "ПК":$("#carthead").css("background","yellow");;
		$("#carthead").css("color","black");
		$("#type_text").text("по потере кормильца");
	break;
	case "ВЛ":$("#carthead").css("background","#800");
		$("#carthead").css("color","#fff");
		$("#type_text").text("за выслугу лет");
	break;
	case "ВВ":$("#carthead").css("background","#f50");
		$("#carthead").css("color","black");
		$("#type_text").text("возмещение вреда здоровью");
	break;
	case "СП":$("#carthead").css("background","#fff");
		$("#carthead").css("color","black");
		$("#type_text").text("социальное пособие");
	break;
	default:$("#carthead").css("background","#0f0");
		$$("#carthead").css("color","black");
		$("#type_text").text("");
	}	

}

$("#_types").change(function(event) {
    checkCardType();
});
checkCardType();	
/*	var type = $("#type").attr("val");
	if(type != "ПК")$("#death").css("display","none");
	if(type == "ПК")$("#dismiss").css("display","none");*/
$( "#adress" ).val(collectAddrInfo());
$(".input_disable input").attr("disabled","disabled");