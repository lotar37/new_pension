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
	  var s_terminated  = "";
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
	  if($("#terminated").is(":checked"))s_terminated = 1;
	  s_age =  $( "#slider-range" ).slider( "values", 0 ) + "-" + $( "#slider-range" ).slider( "values", 1 );
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
	 return "&type="+ s_types+"&age="+s_age+"&war="+s_war+"&chaes="+s_chaes+"&showall="+s_showall+"&paystop="+s_paystop+"&gender="+s_gender+"&terminated="+s_terminated+"&filter_empty="+filter_empty + "&filter_change=1";
  }
  var ajaxRequest;
$.ajaxSetup ({
    // Отменить кеширование AJAX запросов
    cache: false
});
$(".paging td").click(function(event){
    ajaxRequest = $("#string").serialize();
    $('div#result2').load('loadSearchResult?'+ajaxRequest+"&noCache=" + (new Date().getTime()) + Math.random()+collechSearchCondition()+"&anch="+$(this).attr("num"));
});

$(".search_form input:checkbox").click(function(event){
	var len= $(".search_form input:checkbox:checked").length;
	if(len>0)$("#sol").css("display","");
	else $("#sol").css("display","none");
	$("#selected").html("Выбрано:"+ len);
	
});
$('#string').keyup(function(){
    $("#h1_title").text("Пенсионные дела");
    ajaxRequest = $(this).serialize();
    $('div#result2').load('loadSearchResult?'+ajaxRequest+"&noCache=" + (new Date().getTime()) + Math.random()+collechSearchCondition());
})
$("table.search_form tr").mouseover(function(){
	$(this).addClass("actform");
});
$("table.search_form tr").mouseout(function(){
	$(this).removeClass("actform");
});
$("table.search_form tr").click(function(event){
		event.stopPropagation();
	    window.document.location.href='update/'+$(this).attr("num");	
});
$("#shift").click(function(event){
	if($('#filter').is(':visible')){
		$("#shiftcontent").text(">>");
		$(".filter td.filterform").css("padding","0px");
	}else{
		$("#shiftcontent").text("<<");
		$(".filter td.filterform").css("padding","5px");
	}
	$("#filter" ).toggle( "fast" );
    }
);
$(".eighty td").click(function(event){
	$("#h1_title").text("Пересчет восьмидесятилетних");
    $('div#result2').load('loadSearch80?shift='+$(this).attr("num"));
	$(".eighty td").css("border","0px solid red");
	$(this).css("border","1px solid red");
    
});
$(function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 120,
      //values: [ <?php echo $a_age[0];?>, <?php echo $a_age[1];?> ],
      slide: function( event, ui ) {
        $( "#amount" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
      },
	  
      change: function( event, ui ) {
		  if($("#statement").attr("client_filter_change") == 1){$("#statement").attr("client_filter_change",0);return false;}
          ajaxRequest = $("#string").serialize();
          $('div#result2').load('loadSearchResult?'+ajaxRequest+"&noCache=" + (new Date().getTime()) + Math.random()+collechSearchCondition());
	  }

    });
	
    $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +
      " - " + $( "#slider-range" ).slider( "values", 1 ) );
});
$(function() {
    $("#terminated").button();
    $("#paystop").button();
    $("#checkwar").button();
	$("#checkchaes").button();

	$("#showall").button();
    $("#format").buttonset();
    $("#gender").buttonset();
});
$("#format input:checkbox, #gender input:checkbox, #showall, #paystop, #checkchaes, #terminated, #checkwar").click(  function(event){
	if($("#statement").attr("client_filter_change") == 1){return false;}
    ajaxRequest = $("#string").serialize();
    $('div#result2').load('loadSearchResult?'+ajaxRequest+"&noCache=" + (new Date().getTime()) + Math.random()+collechSearchCondition());
});

  $("#slider-range").change(function(event){
 	if($("#statement").attr("client_filter_change") == 1){return false;}
    ajaxRequest = $("#string").serialize();
     $('div#result2').load('loadSearchResult?'+ajaxRequest+"&noCache=" + (new Date().getTime()) + Math.random()+collechSearchCondition());
  });
  
  //  collechSearchConditions in /js/search.js
  $("#check_all").click(function(event){
	event.stopPropagation();
	if($("#check_all").is(":checked")){
		$("input:checkbox").prop('checked', 'checked');
	}else{
		$("input:checkbox").prop('checked',false); 
	}
});
$("input:checkbox").click(function(event){
	event.stopPropagation();
});
$(".search_form input:checkbox").click(function(event){
	var len= $(".search_form input:checkbox:checked").length;
	if(len>0)$("#sol").css("display","");
	else $("#sol").css("display","none");
	$("#selected").html("("+ len+")");
	
});
$(".checkbox").click(function(event){
	event.stopPropagation();
});
$("#statement_button").click(function(event){
	var str= collechSearchCondition();
	if(str.indexOf("&filter_empty=1")>0)alert("\t Фильтр пуст.\n Измените значения параметров.")
	else{
        $("#statement").load("./statement?" + str);
	    $("#statement" ).toggle( "fast" );
    }
});
$("#client_filter_div").load("./clientFilters");
