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
    var newTable = new window.App.Collections.dbTable();
    newTable.setModel("Persons");
//    newTable.reset(<%= @c.toJSON %>);
    var c = new window.App.Views.dbTable({collection:newTable});

    c.render();
    var newTableCases = new window.App.Collections.dbTable();
    newTableCases.setModel("Cases");
    var cCases = new window.App.Views.dbTable({collection:newTableCases});
    cCases.render();
    var controller = new window.App.Routers.Controller(); // Создаём контроллер

    Backbone.history.start();// Запускаем HTML5 History push
    controller.navigate("select", true);

    $("#client_filter_div").load("./search/clientFilters");


//    добавление пользовательских запросов
    $("#add_user_request_button").click(function(event){
       // console.log(window.App.tblAdd.collection.toJSON());
       // var str= collechSearchCondition();
//        if(str.indexOf("&filter_empty=1")>0)alert("\t Фильтр пуст.\n Измените значения параметров.")
//        else{
            $("#statement").load("./search/createFilter",window.App.tblAdd.collection.toJSON());
//            $("#statement" ).toggle( "fast" );
//        }
    });

});
</script>


    <script  type="text/template" class="li">
        <li class="ui-widget-content" type="<%= type %>"  field="<%= field %>" table="<%= table %>" title="<%= tableAttr %>"><b><%= tableAttr %></b></li>
    </script>
    <script  type="text/template" class="li-add">
        <li class="ui-widget-content" type="<%= type %>"  field="<%= field %>" table="<%= table %>" title="<%= tableAttr %>"><b><%= table %>.<%= tableAttr %></b></li>
    </script>
    <script  type="text/template" class="addedIntegerField">
        <tr> <td class="data" field="<%= field %>"  table="<%= table %>" type="<%= type %>"><%= title %>:</td>
            <td><input type="text" class="inputinteger"  value="<%= value %>" /> </td>
            <td><input class="onscreen" type="checkbox" checked="<%= visible %>"></td>
        </tr>
    </script>
    <script  type="text/template" class="addedStringField">
        <tr> <td class="data" field="<%= field %>"  table="<%= table %>" type="<%= type %>"><%= title %>:</td>
            <td><input type="text" class="inputstring"  value="<%= value %>" /> </td>
            <td><input class="onscreen" type="checkbox" checked="<%= visible %>"  /></td>
        </tr>
    </script>
    <script  type="text/template" class="addedBooleanField">
        <tr> <td class="data" field="<%= field %>"  table="<%= table %>" type="<%= type %>"><%= title %>:</td>
            <td><input type="checkbox" checked="<%= value %>"/> </td>
            <td><input class="onscreen" type="checkbox" checked="<%= visible %>"></td>
        </tr>
    </script>
    <script  type="text/template" class="addedDateField">
        <tr>  <td class="data" field="<%= field %>"  table="<%= table %>" type="<%= type %>"><%= title %></td>
            <td>
                от:<input type="text" class="inputdate begin"  value="<%=begin%>" />
                до:<input type="text"  class="inputdate end"  value="<%=end%>" />
            </td>
            <td><input class="onscreen" type="checkbox" checked="<%= visible %>"></td>
        </tr>
    </script>
    <script  type="text/template" class="person">
        <tr person="<%= id %>"><td class="" >ФИО:<%= second_name %> <%= first_name %> <%= third_name %> <%= birth_date %> </td>
        </tr>
    </script>
    <script  type="text/template" class="tableView">
        <td>
    <div id="view_<%= tableName %>" class="tableView">
        <p class="head"><%= tableName %></p>
        <ol  class="list"></ol>

    </div>
        </td>
    </script>
    <script  type="text/template" >
        <h3>Создание пользовательского фильтра</h3>
        Название:<input type="text" size='20' name='filter_name' id='filter_name'><br />
             Для всех пользователей <input type='checkbox' id='for_all'><br />
            <table class="user_search"></table>
            <button  id='create'> Создать</button><button  id='cancel'>Отменить</button>
        <br /><br />
    </script>


</head>
<body>
<h1>Построитель запросов</h1>

<div id="select" class="block">
    <a href="#!/findForm">Далее</a>
    <div class='row type3' id='statement' style='z-index:100;padding-left:10px;' client_filter_change='0'></div>
    <h6>Клиентские запросы <b id='add_user_request_button'>+</b>
    </h6>
    </center>
    <div id='client_filter_div'>
        <select style='font-size:14px;color:#555;margin-top:0em;'>
            <option value="" style='font-size:14px;'></option>
            <option value="" style='font-size:14px;'>Показать всех</option>
        </select>
    </div>
    <table>
<tr><td>
         <ol id="added"  style="background:#bbbbbb">

        </ol>
    </td></tr>
    <tr class="tables">
    </tr>
</table>

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
