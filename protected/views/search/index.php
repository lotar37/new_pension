<head>
    <style>
    #feedback { font-size: 1.4em; }
    #selectable .ui-selecting { background: #FECA40; }
    #selectable .ui-selected { background: #F39814; color: white; }
    #selectable { list-style-type: none; margin: 0; padding: 0; width: 40%; display:block; width:450px;height:300px;overflow-y: scroll;}
    #selectable li { margin: 3px; padding: 0.4em; font-size: 1em; height: 18px; }
    #added .ui-selecting { background: #FECA40; }
    #added .ui-selected { background: #F39814; color: white; }
    #added { list-style-type: none; margin: 0; padding: 0; width: 40%; display:block;width:450px;height:300px;overflow-y: scroll;}
    #added li { margin: 3px; padding: 0.4em; font-size: 1em; height: 18px; }
</style>

<script>
$(function() {
    var tbl = new window.App.Models.Table();
    $.ajax({
        url: './search/getModelAttributes',
        async: false,
        type: 'GET',
        contentType: 'application/x-www-form-urlencoded',
        dataType: 'json',
        success: function (data) {
            _.each(data, function(num, key){tbl.set(key,num); });
        }
     });

    var viewTbl = new window.App.Views.Table({model:tbl});

    $("#selectable li").on("click",function (){
        $("#added").append($(this));
    });
    $("#added").on("click","li", function (){
        $("#selectable").append($(this));
    });
    var controller = new window.App.Routers.Controller(); // Создаём контроллер
    Backbone.history.start();// Запускаем HTML5 History push
    controller.navigate("select", true);

});
</script>
    <script  type="text/template" class="li">
        <li class="ui-widget-content" field="<%= table %>" title="<%= tableAttr %>"><b><%= tableAttr %></b>(<%= table %>)</li>
    </script>
    <script  type="text/template" class="addedIntegerField">
        <tr> <td class="" field="<%= field %>"><%= title %>:</td><td><input type="text" class="inputinteger"/> </td></tr>
    </script>
    <script  type="text/template" class="addedStringField">
        <tr> <td class="" field="<%= field %>"><%= title %>:</td><td><input type="text" /> </td></tr>
    </script>
    <script  type="text/template" class="addedBooleanField">
        <tr> <td class="" field="<%= field %>"><%= title %>:</td><td><input type="checkbox" /> </td></tr>
    </script>
    <script  type="text/template" class="addedDateField">
        <tr>  <td class="" field="<%= field %>"><%= title %></td><td> от:<input type="text" class="inputdate"/> до:<input type="text"  class="inputdate"/> </td></tr>
    </script>



</head>
<body>
<h1>Построитель запросов</h1>

<div id="select" class="block">

<table>
    <th>Таблица:Person</th>
    <th>Выбранные поля</th>
    <tr><td>
<ol id="selectable" style="background:#bbbbbb">

</ol>
</td><td>
<ol id="added"  style="background:#bbbbbb">

</ol>
</td>
    </tr>
</table>
    <a href="#!/findForm">Далее</a>
</div>
<div id="findForm" class="block">
    <h3> Выбраны поля</h3>
    <table class="addedFields"></table>
    <a href="#!/">Назад</a>

</div>

<?php

/**
 * Created by PhpStorm.
 * Date: 09.11.2015
 * Time: 17:39
 */
