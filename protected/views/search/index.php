<head>
    <style>
    a{color:white}
    #feedback { font-size: 1.4em; }
    #selectable .ui-selecting { background: #FECA40;  }
    #selectable .ui-selected { background: #F39814; color: white; }
    #selectable { list-style-type: none; margin: 0; padding: 0; width: 40%; display:block; width:350px;height:200px;overflow-y: scroll;}
    #selectable li { margin: 3px; padding: 0.4em; font-size: 1em; height: 18px; }
    #added .ui-selecting { background: #FECA40; }
    #added .ui-selected { background: #F39814; color: white; }
    #added { list-style-type: none; margin: 0; padding: 0; width: 40%; display:block;width:450px;height:200px;overflow-y: scroll;}
    #added li { margin: 3px; padding: 0.4em; font-size: 1em; height: 18px; }
</style>

<script>
$(function() {
    $("#selectable").draggable();
    window.App.tbl = new window.App.Models.Table();
    //window.App.tbl.url = window.App.tbl.url + "/tableName=" + window.App.tbl.tableName;
    window.App.tbl.urlshift("Persons");
    window.App.tbl.fetch({async: false});
    var tbl = new window.App.Models.Table();
    tbl.urlshift("Persons");
    tbl.fetch({async: false});

    var viewTbl = new window.App.Views.Table({model:tbl});

    $("#selectable li").on("click",function (){
        $("#added").append($(this));
        window.App.temp.newAdd = true;
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
        <li class="ui-widget-content" field="<%= field %>" table="<%= table %>" title="<%= tableAttr %>"><b><%= tableAttr %></b></li>
    </script>
    <script  type="text/template" class="addedIntegerField">
        <tr> <td class="data" field="<%= field %>"  table="<%= table %>" type="<%= type %>"><%= title %>:</td><td><input type="text" class="inputinteger"/> </td></tr>
    </script>
    <script  type="text/template" class="addedStringField">
        <tr> <td class="data" field="<%= field %>"  table="<%= table %>" type="<%= type %>"><%= title %>:</td><td><input type="text" /> </td></tr>
    </script>
    <script  type="text/template" class="addedBooleanField">
        <tr> <td class="data" field="<%= field %>"  table="<%= table %>" type="<%= type %>"><%= title %>:</td><td><input type="checkbox" checked/> </td></tr>
    </script>
    <script  type="text/template" class="addedDateField">
        <tr>  <td class="data" field="<%= field %>"  table="<%= table %>" type="<%= type %>"><%= title %></td>
            <td> от:<input type="text" class="inputdate begin"/> до:<input type="text"  class="inputdate end"/> </td>
        </tr>
    </script>
    <script  type="text/template" class="person">
        <tr person="<%= id %>">  <td class="" >ФИО:<%= second_name %> <%= first_name %> <%= third_name %> <%= birth_date %> </td>
        </tr>
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
    <a href="#!/result">Искать!</a>

</div>
<div id="result" class="block">
    <h3>Результат поиска</h3>
    <a href="#!/findForm">Назад</a>
    <table class="resultTable"></table>

</div>

<?php

/**
 * Created by PhpStorm.
 * Date: 09.11.2015
 * Time: 17:39
 */
