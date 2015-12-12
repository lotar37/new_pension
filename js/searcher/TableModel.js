/**
 * Created by Андрей on 10.11.2015.
 */
window.App = {
    Models : {},
    Views : {},
    Collections : {},
    Routers : {},
    tbl : {},
    SelectFiedls:false,
    findForm:false,
    Result:false,
    tblAdd: {}
};
//Backbone.sync = function(method, model, options) {
//    //options = "async:false";
//};
window.App.Models.Table  = Backbone.Model.extend({
    tableName:"defaultTable",
    url: './search/getModelAttributes',

    setModel: function(tableName){
        this.tableName = tableName;
        this.url = this.url + "?tableName=" + tableName;
    },
});

window.App.Views.SelectFields = Backbone.View.extend({
    tables : [],
    permitingTables : {"Persons":"Пенсионеры","Cases":"Пенсионные дела","Ranks":"Звания"},
    templatePT: _.template($(".permitingTable").html()),
    templateUR: _.template($(".userRequest").html()),
    templateERR: _.template($(".userRequestError").html()),
    templateTR: _.template($(".userRequestTR").html()),

    initialize:function(){
        window.App.tbl = new window.App.Models.Table();
        window.App.tbl.setModel("Persons");
        window.App.tbl.fetch({async: false});
        var coll = new window.App.Collections.TableAdd();
        window.App.tblAdd = new window.App.Views.TableAdd({collection:coll});
        this.render();
        _.each(this.permitingTables, function(i,table){
            $(".listTables").append(this.templatePT({tableName:table, title:i}));
            $( "#"+table ).button();
        },this);
     },
    render:function(){
        for(var i=0;i<this.tables.length;i++){
            this.addTable(this.tables[i]);
        }
    },
    addTable:function(tableName){
        var newTable = new window.App.Collections.dbTable();
        newTable.setModel(tableName);
        var tableView = new window.App.Views.dbTable({collection:newTable});
        tableView.render();
    },

    removeTable:function(tableName){

    },
    tableInspect:function(data){
        var arr = [];
        _.each(data,function(obj,i){
            arr.push(obj.table);
        });

        arr =  _.uniq(arr);
        //объединение
        var union = _.union(arr,this.tables);
        //следует добавить
        var add = _.difference(union,this.tables);
        //следует удалить
        var del = _.difference(union, arr);
        this.tables = arr;
        _.each(add, function(obj){
            this.addTable(obj);
            ///checkbox нажать
            $("#"+obj).prop('checked', 'checked');
        },this);
        _.each(del, function(obj){
            $("#view_"+obj).parent().remove();
            //checkbox отжать
            $("#"+obj).prop('checked', '');
        });
    },
    callback:function() {
        setTimeout(function() {
            $(".userRequestDivError").hide( "pulsate", {}, 500);
            //$( "#findForm:visible" ).removeAttr( "style" ).fadeOut();
        }, 3000 );
        setTimeout(function() {
             $(".userRequestDivError").remove();
        }, 5000 );
    },
    openUserRequest:function(type){
        if(type == "create") {
            if (window.App.tblAdd.collection.length == 0) {
                $(document.body).append(this.templateERR());
                $(".userRequestDivError").show( "clip", {}, 100, this.callback);
                $(".userRequestDivError .cansel").on("click", function () {
                    $(".userRequestDivError").remove();
                });
            } else {
                $(document.body).append(this.templateUR());
                window.App.tblAdd.collection.each(function (field) {
                    $(".search_phrase").append(this.templateTR(
                            {
                                title: field.attributes.title,
                                table: field.attributes.table,
                                visible: field.attributes.visible ? "Да" : "Нет",
                                value: field.attributes.value

                            })
                    );
                }, this);
                $(".userRequestDiv").on("click", ".cansel", function () {
                    $(".userRequestDiv").remove();
                });

            }
        }else if(type == "remove"){
            $(document.body).append($(".userFiltersRemove").html());
            $(".userFiltersRemoveList").load("./search/clientFilters?type=");
            $(".userRequestDivRemove").on("click", ".cancel", function () {
                $(".userRequestDivRemove").remove();
            });
            $(".userRequestDivRemove").on("click", ".remove", function () {
                var arr = [];
                $(".userRequestDivRemove input[type=checkbox]:checked").each(function(){

                    arr.push($(this).parent().attr("value"));
                });
                if(arr.length == 0){alert("Не выбрано объектов для удаления");}
                else
                $.ajax({
                    url : './search/deleteFilters',
                    async : true,
                    type : 'GET',
                    data : {
                        data:arr,
                    },
                    error:function(x,textStatus){
                        console.log(textStatus);
                        console.log("error");
                    },
                    success: function (data, textStatus){
                        console.log("success");
                        $(".userRequestDivRemove").remove();
                        $("#client_search_div").load("./search/clientFilters?type=select");
                            //if(confirm("Фильтр успешно сохранен."))$(".userRequestDiv").remove();
                     }
                });

            });
        }
    }

});

window.App.Views.FindForm = Backbone.View.extend({
    templateB : _.template($(".addedBooleanField").html()),
    templateI : _.template($(".addedIntegerField").html()),
    templateS : _.template($(".addedStringField").html()),
    templateD : _.template($(".addedDateField").html()),
    initialize:function() {
        this.render();
    },
    render:function(){
        $(".addedFields").empty();
        $(".addedFields").append("<th>Поле</th><th>Поиск</th><th>Выводить на экран</th>");
        console.log("render findForm arr.length:"+window.App.tblAdd.collection.length);
        window.App.tblAdd.collection.each(function(field){
            var dataJ = {
                title:field.attributes.title,
                field:field.attributes.field ,
                type: field.attributes.type,
                table:field.attributes.table,
                visible:field.attributes.visible ? "checked" : ""
            };
            switch(field.attributes.type){
                case "boolean":
                    dataJ.value = dataJ.value ? "checked" : "";
                    $(".addedFields").append(this.templateB(dataJ));
                    break;
                case "string" :
                    dataJ.value = field.attributes.value;
                    $(".addedFields").append(this.templateS(dataJ));
                    break;
                case "integer":
                    dataJ.value = field.attributes.value;
                    $(".addedFields").append(this.templateI(dataJ));
                    break;
                case "date" :
                    dataJ.begin = field.attributes.begin;
                    dataJ.end = field.attributes.end;
                    $(".addedFields").append(this.templateD(dataJ));
             }
        },this);
        $(".inputdate").inputmask("d.m.y");
        $(".inputinteger").inputmask("integer");
        $("input").on("change",function() {
            if ($(this).attr("type") == "text") {
                var mod = window.App.tblAdd.collection.where({
                        "table": $(this).parent().prev().attr("table"),
                        "field": $(this).parent().prev().attr("field")
                    }
                );
                var b = mod[0];
                if($(this).hasClass("begin"))b.set({begin: $(this).val()});
                else if($(this).hasClass("end"))b.set({end: $(this).val()});
                else b.set({value: $(this).val()});
            } else if($(this).hasClass("onscreen")){
                var mod = window.App.tblAdd.collection.where({
                        "table": $(this).parent().prev().prev().attr("table"),
                        "field": $(this).parent().prev().prev().attr("field")
                    }
                );
                var b = mod[0];
                console.log("change checkbox:" + $(this).prop("checked"));
                b.set({visible: $(this).prop("checked")});
            }
            window.App.tblAdd.collection.remove(mod, {silent: true});
            window.App.tblAdd.collection.add(b, {silent: true});
            console.log(b);

        });
    }
});
window.App.Models.Result  = Backbone.Model.extend({
    //count:0,
    initialize:function(){
    }
});

window.App.Views.Result  = Backbone.View.extend({
    el:$(".resultTable"),
    template :   _.template($(".person").html()),
    templatePaging: _.template($(".paging").html()),
    render:function(){
        //var coll = $("#findForm td.data");
        var arr = [];
        var tables = [];
        //var i = 0;
        //подготовка запроса
        window.App.tblAdd.collection.each(function(field){
            var onscreen = (typeof field.attributes.visible == "undefined") ? true : field.attributes.visible;
            tables.push(field.attributes.table);
            if(field.attributes.type == "date") {
                arr.push({
                    title:field.attributes.title,
                    field:field.attributes.field ,
                    table:field.attributes.table,
                    type:field.attributes.type,
                    begin: field.attributes.begin,
                    end: field.attributes.end,
                    onscreen: onscreen ? 1 : 0
                });
            }else{
                arr.push({
                    title:field.attributes.title,
                    field:field.attributes.field ,
                    table:field.attributes.table,
                    type:field.attributes.type,
                    val:(typeof field.attributes.value == "undefined") ? "" : field.attributes.value,
                    onscreen: onscreen ? 1 : 0
                });
            }
            //i++;
        });
        var tableUnion = _.union(tables);
        var head = "";
        window.App.tblAdd.collection.each(function(field) {
            if(field.attributes.visible)head += "<th>"+ field.attributes.title +"</th>";

        },this);

        switch ($("#findForm select option:selected").text()) {
            case "Вывод на экран":
                //запрос
                $.ajax({
                    url: './search/request',
                    async: false,
                    dataType: 'json',
                    data: {d: arr, tables: tableUnion,type: "",thead:"",page:""},
                    success: function (datas) {
                        window.App.Result.model = new window.App.Models.Result($.parseJSON(datas.data));
                        window.App.Result.model.set({count:$.parseJSON(datas.count)});
                        //вывод результатов
                        window.App.Result.drawReport();
                    }
                }, this);
                break;
            case "Вывод в Excel":
                window.open("./search/request?"+$.param({d: arr, tables: tableUnion, type:"excel",thead:head}),"_blank");
                break;
            case "Вывод в отдельной вкладке":
                window.open("./search/request?"+$.param({d: arr, tables: tableUnion, type:"blank",thead:head}),"_blank");
                break;

       }
    },
    drawReport:function(){
        this.$el.empty();
        $(".pagingDiv").empty();
        $(".pagingDiv").append(this.templatePaging({count:this.model.attributes.count}));
        this.$el.append("<th>N</th>");
        window.App.tblAdd.collection.each(function(field) {
            if(field.attributes.visible)this.$el.append("<th>"+ field.attributes.title + "</th>");

        },this);
//console.log(this.model);
        var j = 0;
        _.each(this.model.attributes, function(obj, key){
            j++;
            var body = "<tr class='actform'><td>"+ j + "</td>";
            var arr = _.values(obj);
            //console.log(obj);
            for(var i=0;i<arr.length;i++){
                body += "<td>" + arr[i] + "</td>";
            }
            this.$el.append(body+"</tr>");
        },this);

    },

});
