<head>
    <style>
    a{color:white}
    #feedback { font-size: 1.4em; }
    #selectable .ui-selecting { background: #FECA40;  }
    #selectable .ui-selected { background: #F39814; color: white; }
    .list { list-style-type: none; margin: 0; padding: 0; width: 40%; display:block; width:350px;height:200px;overflow-y: scroll;}
    .list li { margin: 3px; padding: 0.4em; font-size: 1em; height: 18px; }
    #added .ui-selecting { background: #FECA40; }
    #added .ui-selected { background: #F39814; color: white; }
    #added { list-style-type: none; margin: 0; padding: 0; width: 40%; display:block;width:450px;height:200px;overflow-y: scroll;}
    #added li { margin: 3px; padding: 0.4em; font-size: 1em; height: 18px; }
    p.head {width:350px; color:white;background:black;padding:4px;text-align:center;display:block;}
    div.tableView{background:#C5FBBD;width:350px;height: 290px;overflow:hidden;}
</style>

<script>
$(function() {
    window.App.tbl = new window.App.Models.Table();
    window.App.tbl.setModel("Persons");
    window.App.tbl.fetch({async: false});
    var coll = new window.App.Collections.TableAdd();
    window.App.tblAdd = new window.App.Views.TableAdd({collection:coll});
    var newTable = new window.App.Collections.Table({tableName:"Persons"});
    var c = new window.App.Views.Table2({collection:newTable});
    c.render();
    var controller = new window.App.Routers.Controller(); // Создаём контроллер

    Backbone.history.start();// Запускаем HTML5 History push
    controller.navigate("select", true);

});
</script>


    <script  type="text/template" class="li">
        <li class="ui-widget-content" type="<%= type %>"  field="<%= field %>" table="<%= table %>" title="<%= tableAttr %>"><b><%= tableAttr %></b></li>
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
    <script  type="text/template" class="tableView">
    <div id="view_<%= tableName %>" class="tableView">
        <p class="head"><%= tableName %></p>
        <ol  class="list"></ol>

    </div>
    </script>



</head>
<body>
<h1>Построитель запросов</h1>

<div id="select" class="block">

<table>
<tr><td>
        <ol id="added"  style="background:#bbbbbb">

        </ol>
    </td></tr>
    <tr><td class="tables">

</td><td>

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
