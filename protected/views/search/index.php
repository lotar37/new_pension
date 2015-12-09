<head>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/search_form.css');
?>



    <style>
    a{color:white}
    #feedback { font-size: 12px; }
    #selectable .ui-selecting { background: #FECA40;  }
    #selectable .ui-selected { background: #F39814; color: white; }
    .list { list-style-type: none; margin: 0; padding: 0; width: 40%; display:block; width:200px;height:130px;overflow-y: scroll;}
    .list li { margin: 3px; padding: 0.4em; font-size: 12px; height: 18px; }
    #added .ui-selecting { background: #FECA40; }
    #added .ui-selected { background: #F39814; color: white; }
    #added { list-style-type: none; margin: 0; padding: 0; display:block;width:550px;height:200px;overflow-y: scroll;}
    #added li { margin: 3px; padding: 0.4em; font-size: 16px; height: 18px; }
    p.head {width:200px; color:white;background:black;padding:4px;text-align:center;display:block;}
    div.dbTableView{background:#C5FBBD;width:200px;height: 200px;overflow:hidden;}
    div.userRequestDiv{padding:10px;background:#208074; top:200px;left:200px;position:absolute; overflow:hidden;border:4px solid white;}
    div.userRequestDiv td, .data td{background:#60b0a4;}
    div.userRequestDiv h3{color:white   }
    div.userRequestDivError{padding:10px;background:#bb0000; color:white; top:200px;left:200px;position:absolute; overflow:hidden;border:4px solid white;}
    div.userRequestDivError h3{color:white; }
    .checkbox_table{font-size:12px}
    .visible_check{text-align:center;}
    .pagingDiv td{color:#bce8f1;}
    .search_head{color:#fbde4a}
</style>

<script>
$(function() {
    var controller = new window.App.Routers.Controller(); // Создаём контроллер

    Backbone.history.start();// Запускаем HTML5 History push
    controller.navigate("!/select", true);



//    добавление пользовательских запросов
    $("#add_user_request_button").click(function(event){
         window.App.SelectFields.openUserRequest();
    });
    $("#del_user_request_button").click(function(){

    });
    $(document).on("click",".create",function(){
        if($("#filter_name").val() == ""){alert("Пустое поле имени фильтра.");$("#filter_name").focus()}
        else{
            $.ajax({
                url : './search/saveFilter',
                async : true,
                type : 'GET',
                data : {
                    filter:window.App.tblAdd.collection.toJSON(),
                    filter_name:$("#filter_name").val(),
                    prefix:$("#for_all").is(":checked") ? 'global' : '',
                },
                processData : true,
                contentType : 'application/x-www-form-urlencoded',
                dataType : 'json',
                success: function (data, textStatus) {
                    if(data == 1){
                        $("#client_search_div").load("./search/clientFilters");
                        if(confirm("Фильтр успешно сохранен."))$(".userRequestDiv").remove();
                    }
                    if(data == 0)
                        if(confirm("Такой фильтр уже существует."))$(".userRequestDiv").remove();
                }
            });
        }
    });
    $(document).on("change","#client_filter",function(){
        $.ajax({
            url : './search/getFilter',
            async : true,
            type : 'GET',
            data : {
                filter_name:$("#client_filter option:selected").text(),
            },
            processData : true,
            contentType : 'application/x-www-form-urlencoded',
            dataType : 'json',
            success: function (data) {
                window.App.tblAdd.collection.reset(data);
                window.App.SelectFields.tableInspect(data);
            }
        });

    });

    // работа с кнопками Списка доступных таблиц
    $(".listTables").on("change","input",function(){
        //выход, если таблица уже есть
        if($("#view_"+$(this).attr("id")).length==0){
            window.App.SelectFields.tables.push($(this).attr("id"));
            window.App.SelectFields.addTable($(this).attr("id"));
        }else{
            window.App.SelectFields.tables = _.without(window.App.SelectFields.tables,$(this).attr("id"));
            $("#view_"+$(this).attr("id")).parent().remove();
        }
        //сброс селектора клиентского запроса
        $("#client_filter [value='0']").prop("selected", "selected");

    });

    $( "#added" ).sortable({"update":function(){window.App.tblAdd.updateSort = true}});
    $( "#added" ).disableSelection();

    $("#client_search_div").load("./search/clientFilters?type=select");
});
</script>


    <!--  Шаблоны поля в таблице          -->
    <script  type="text/template" class="li">
        <li class="ui-widget-content" type="<%= type %>"  field="<%= field %>" table="<%= table %>" title="<%= tableAttr %>"><b><%= tableAttr %></b></li>
    </script>

    <!--  Шаблоны поля в таблице выбранных полей         -->
    <script  type="text/template" class="li-add">
        <li class="ui-widget-content" type="<%= type %>"  field="<%= field %>" table="<%= table %>" title="<%= tableAttr %>">
            <b id="del_li" style="cursor:pointer">-</b>&nbsp;&nbsp;&nbsp;&nbsp;<b><%= titleTable %>.<%= tableAttr %></b></li>
    </script>

    <!--  Шаблоны полей поиска для разных типов данных          -->
    <script  type="text/template" class="addedIntegerField">
        <tr class="data"> <td class="data" field="<%= field %>"  table="<%= table %>" type="<%= type %>"><%= title %>:</td>
            <td><input type="text" class="inputinteger"  value="<%= value %>" /> </td>
            <td class="visible_check"><input class="onscreen" type="checkbox" <%= visible %>="<%= visible %>" /></td>
        </tr>
    </script>
    <script  type="text/template" class="addedStringField">
        <tr class="data"> <td class="data" field="<%= field %>"  table="<%= table %>" type="<%= type %>"><%= title %>:</td>
            <td><input type="text" class="inputstring"  value="<%= value %>" /> </td>
            <td class="visible_check"><input class="onscreen" type="checkbox" <%= visible %>="<%= visible %>"  /></td>
        </tr>
    </script>
    <script  type="text/template" class="addedBooleanField">
        <tr class="data"> <td class="data" field="<%= field %>"  table="<%= table %>" type="<%= type %>"><%= title %>:</td>
            <td><input type="checkbox" checked="<%= value %>"/> </td>
            <td class="visible_check"><input class="onscreen" type="checkbox" <%= visible %>="<%= visible %>" /></td>
        </tr>
    </script>
    <script  type="text/template" class="addedDateField">
        <tr class="data">  <td class="data" field="<%= field %>"  table="<%= table %>" type="<%= type %>"><%= title %></td>
            <td>
                от:<input type="text" class="inputdate begin"  value="<%=begin%>" />
                до:<input type="text"  class="inputdate end"  value="<%=end%>" />
            </td>
            <td class="visible_check"><input class="onscreen" type="checkbox" <%= visible %>="<%= visible %>" /></td>
        </tr>
    </script>

    <!--  устаревший шаблон          -->
    <script  type="text/template" class="person">
        <tr person="<%= id %>"><td class="" >ФИО:<%= second_name %> <%= first_name %> <%= third_name %> <%= birth_date %> </td>
        </tr>
    </script>

    <!--  Шаблон внешнего вида таблицы           -->
    <script  type="text/template" class="tableView">
        <td>
    <div id="view_<%= tableName %>" class="dbTableView">
        <p class="head"><%= title %></p>
        <ol  class="list"></ol>

    </div>
        </td>
    </script>
    <!--  Шаблон создания пользовательского запроса         -->
    <script  type="text/template" class="userRequest">
        <div class="userRequestDiv">
            <h3>Создание пользовательского запроса</h3>
            Название:<input type="text" size='20' name='filter_name' id='filter_name'><br />
            Для всех пользователей <input type='checkbox' id='for_all'><br />
            <table class="search_phrase" style="">
                <th>Поле</th>
                <th>Значение</th>
                <th>Вывод на экран</th>
            </table>

            <button  class='create'> Создать</button><button  class='cansel'>Отменить</button>
            <br /><br />
        </div>
    </script>
    <!--  Шаблон создания пользовательского запроса  ERROR       -->
    <script  type="text/template" class="userRequestError">
        <div class="userRequestDivError">
            <h3>Создание пользовательского запроса</h3>
            <h2>Ошибка!Вы ничего не выбрали!</h2>
            <button  class='cansel'>Закрыть</button>
            <br /><br />
        </div>
        <!--  Шаблон удаления пользовательских фильтров       -->
        <script  type="text/template" class="userFiltersRemove">
            <h3>Отметьте запросы, которые вы хотели бы удалить</h3>
            <ol class="userFiltersRemoveList"></ol>
            <button  class='FiltersRemove'>Удалить</button>
        </script>
    <!--  Шаблон создания строки пользовательского запроса         -->
    <script  type="text/template" class="userRequestTR">
        <tr>
            <td><%= table %>.<%= title %></td>
            <td><%= value %></td>
            <td><%= visible %></td>
        </tr>
    </script>
    <!--  Шаблон создания строки пользовательского запроса         -->
    <script  type="text/template" class="paging">
        <table>
        <tr>
            <td>Всего найдено:<%= count %></td>
            <td></td>
            <td></td>
        </tr>
        </table>
    </script>
    <script  type="text/template" class="permitingTable">
        <input type="checkbox" id="<%= tableName %>"><label for="<%= tableName %>" class="checkbox_table"><%= title %></label><br>
    </script>
</head>
<body>
<h1>Построитель запросов</h1>
<div id="select" class="block">
    <a href="#!/findForm">Далее</a>
    <div class='row type3' id='statement' style='z-index:100;padding-left:10px;' client_filter_change='0'></div>
    <h6 style="color:#bce8f1">Клиентские запросы <b id='add_user_request_button' style="cursor:pointer;color:#ffaa55">+</b>
        <b id='client_search_div'></b>  <b id='del_user_request_button' style="cursor:pointer;color:#ffaa55">x</b> </h6>
    </center>
<h2 class="search_head">Выбор поисковых полей</h2>
    <table style="width:10%">
        <tr class="tables">
            <td class="listTables" style="vertical-align:top;background:#bce8f1;text-align:center;"><p style="width:200px;" class="head">Доступные таблицы</p></td>
        </tr>
    </table>
    <table style="width:10%">
        <th>Выбранные поля</th>
        <tr><td style="text-align:;">
            <ol id="added"  style="background:#bbbbbb"></ol>
        </td></tr>
    </table>

</div>


<div id="findForm" class="block">
    <a href="#!/">Назад</a>
    <a href="#!/result">Искать!</a>
    <h2 class="search_head">Выбраны поля &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <select>
        <option value='' style='font-size:14px;'>Вывод на экран</option>
        <option value='' style='font-size:14px;'>Вывод в Excel</option>
        <option value='' style='font-size:14px;'>Вывод в отдельной вкладке</option>

    </select></h2>
    <table class="addedFields"></table>

</div>
<div id="result" class="block">
    <a href="#!/findForm">Назад</a>
    <h2 class="search_head">Результат поиска</h2>
    <div class="pagingDiv"></div>
    <table class="resultTable search_form"></table>

</div>

<?php

/**
 * Created by PhpStorm.
 * Date: 09.11.2015
 * Time: 17:39
 */
