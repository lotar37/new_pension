

<script>
$(function() {
    var tbl = new window.App.Models.Table();
    $.ajax({
        url: './search/getModelAttributes',
        async: true,
        type: 'GET',
        contentType: 'application/x-www-form-urlencoded',
        dataType: 'json',
        success: function (data) {
            _.each(data, function(num, key){ k = key+"";tbl.set(key,num); });
        }
     });
   // var tbl = Backbone.Model.extend();
   // _.each(table, function(num, key){ tbl.set({key:num}); console.log(key + " - " + num);});
    //console.log(tbl);
    console.log(tbl);


});
</script>

<style>
    #feedback { font-size: 1.4em; }
    #selectable .ui-selecting { background: #FECA40; }
    #selectable .ui-selected { background: #F39814; color: white; }
    #selectable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #selectable li { margin: 3px; padding: 0.4em; font-size: 1.4em; height: 18px; }
</style>
<script>
    $(function() {
        $( "#selectable" ).selectable({
            stop: function() {
                var result = $( "#select-result" ).empty();
                $( ".ui-selected", this ).each(function() {
                    var index = $( "#selectable li" ).index( this );
                    result.append( " #" + ( index + 1 ) );
                });
            }
        });
    });
</script>
</head>
<body>

<p id="feedback">
    <span>Вы выбрали:</span> <span id="select-result">none</span>.
</p>

<ol id="selectable">
    <li class="ui-widget-content">Item 1</li>
    <li class="ui-widget-content">Item 2</li>
    <li class="ui-widget-content">Item 3</li>
    <li class="ui-widget-content">Item 4</li>
    <li class="ui-widget-content">Item 5</li>
    <li class="ui-widget-content">Item 6</li>
</ol>


<?php

/**
 * Created by PhpStorm.
 * Date: 09.11.2015
 * Time: 17:39
 */
