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
    tables : ["Persons","Cases"],
    templateUR: _.template($(".userRequest").html()),
    templateERR: _.template($(".userRequestError").html()),
    templateTR: _.template($(".userRequestTR").html()),

    initialize:function(){
        window.App.tbl = new window.App.Models.Table();
        window.App.tbl.setModel("Persons");
        window.App.tbl.fetch({async: false});
        var coll = new window.App.Collections.TableAdd();
        window.App.tblAdd = new window.App.Views.TableAdd({collection:coll});
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
    openUserRequest:function(){
        if(window.App.tblAdd.collection.length == 0){
            $(document.body).append(this.templateERR());
            $(".userRequestDivError .cansel").on("click",function(){
                console.log(22222222222);
                $(".userRequestDivError").remove();
            });
        }else{
            $(document.body).append(this.templateUR());
             window.App.tblAdd.collection.each(function(field) {
                 console.log(field);
                 $(".search_phrase").append(this.templateTR(
                     {
                         title: field.attributes.title,
                         table: field.attributes.table,
                         visible: field.attributes.visible ? "Да" : "Нет",
                         value: field.attributes.value

                     })
                 );
             },this);
            $(".userRequestDiv .cansel").on("click",function(){
                console.log(3333333333333);
                $(".userRequestDiv").remove();
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
                b.set({visible: $(this).prop("checked")});
            }
            window.App.tblAdd.collection.remove(mod, {silent: true});
            window.App.tblAdd.collection.add(b, {silent: true});

        });
    }
});
window.App.Models.Result  = Backbone.Model.extend({
    initialize:function(){
    }
});

window.App.Views.Result  = Backbone.View.extend({
    el:$(".resultTable"),
    template :   _.template($(".person").html()),
    render:function(){
        //var coll = $("#findForm td.data");
        var arr = [];
        var tables = [];
        //var i = 0;
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
        $.ajax({
            url: './search/request',
            async: false,
            dataType: 'json',
            data:{d:arr,tables:tableUnion},
            success: function (datas) {
                window.App.Result.model = new window.App.Models.Result(datas);
                window.App.Result.drawReport();
            }
        },this);


    },
    drawReport:function(){
        this.$el.empty();
        _.each(this.model.attributes, function(obj, key){
            if(key>0)return 0;
            var keys = _.keys(obj);
            var head = "";
            for(var i=0;i<keys.length;i++){
                var a_attr = _.values(_.pick(window.App.tbl.attributes,keys[i]));
                if(a_attr[0]== undefined)continue;
                if(a_attr[0].attr== undefined)continue;
                head += "<th>" + a_attr[0].attr + "</th>";
            }
            this.$el.append(head);
        },this);

        _.each(this.model.attributes, function(obj, key){

            var body = "<tr>";
            var arr = _.values(obj);
            for(var i=0;i<arr.length;i++){
                body += "<td>" + arr[i] + "</td>";
            }
            this.$el.append(body+"</tr>");
        },this);

    },

});
