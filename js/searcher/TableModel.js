/**
 * Created by Андрей on 10.11.2015.
 */
window.App = {
    Models : {},
    Views : {},
    Collections : {},
    Routers : {},
    temp : {newAdd:false},
    tbl : {},
    findForm:false,
    tblAdd: {}
};
//Backbone.sync = function(method, model, options) {
//    //options = "async:false";
//};

window.App.Models.TableAdd  = Backbone.Model.extend({
    default:{
        title:"",
        table:"",
        field:"",
        type:""
    }
});
window.App.Models.TableField  = Backbone.Model.extend({
    default:{
        title:"",
        type:"",
        field:""
    }
});
window.App.Collections.TableAdd = Backbone.Collection.extend({
    model:window.App.Models.TableAdd,

});
window.App.Views.Table2 = Backbone.View.extend({
    template: _.template($(".li").html()),
    templateTable: _.template($(".tableView").html()),
    initialize:function(){
        this.collection.fetch({async: false});
    },
    render:function(){
        console.log(this.collection);
        $(".tables").append(this.templateTable({tableName:this.collection.tableName}));
        this.$el = $("#view_" + this.collection.tableName + " ol");
        this.collection.each(function(field){
          //  console.log(field);
            this.$el.append(this.template({
                tableAttr:field.attributes.title,
                field:field.attributes.field,
                type:field.attributes.type,
                table:this.collection.tableName
            }));
        },this);
        $("#view_" + this.collection.tableName).draggable({ handle: "p" });
        $("#view_" + this.collection.tableName + " li").on("click",function (){
            console.log(this);
            window.App.tblAdd.collection.add({
                "title":$(this).attr("title"),
                "type":$(this).attr("type"),
                "table":$(this).attr("table"),
                "field":$(this).attr("field")});
            window.App.temp.newAdd = true;
            $(this).remove();
        });
    }
});
window.App.Collections.Table = Backbone.Collection.extend({
    tableName:"Persons",
    model:window.App.Models.TableField,
    url:"./search/getModelAttributes",
    setModel: function(tableName){
        this.tableName = tableName;
        this.url = this.url + "?tableName=" + tableName;
    },
    initialize: function(){
        this.url +=  "?tableName=" + this.tableName;
    },
});

window.App.Models.Table  = Backbone.Model.extend({
    tableName:"defaultTable",
    url: './search/getModelAttributes',

    setModel: function(tableName){
        this.tableName = tableName;
        this.url = this.url + "?tableName=" + tableName;
    },
    initialize:function(){

    }
});
window.App.Models.Result  = Backbone.Model.extend({
    initialize:function(){
    }
});
window.App.Views.TableAdd = Backbone.View.extend({
    el:$("#added"),
    template:_.template($(".li").html()),
    initialize:function(){
        this.collection.bind("add", this.fun2, this);
        //this.render();
    },
    render:function(){
        this.$el.empty();
        console.log(this.models);
        this.collection.each(function(per){
            console.log(per.attributes);
            this.$el.append(this.template({tableAttr:per.attributes.title, field:per.attributes.field, table:per.attributes.table, type:per.attributes.type}));
        },this);
    },
    fun2:function(){
       // console.log(this.collection);
        this.render();
    },
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
         window.App.tblAdd.collection.each(function(field){
            console.log(field);
            var dateJ = {title:field.attributes.title,field:field.attributes.field ,type: field.attributes.type, table:field.attributes.table};
            switch(field.attributes.type){
                case "boolean":$(".addedFields").append(this.templateB(dateJ));
                    break;
                case "string" : $(".addedFields").append(this.templateS(dateJ));
                    break;
                case "integer": $(".addedFields").append(this.templateI(dateJ));
                    break;
                case "date" : $(".addedFields").append(this.templateD(dateJ));
             }
        },this);
        $(".inputdate").inputmask("d.m.y");
        $(".inputinteger").inputmask("integer");

    }
});
window.App.Views.Result  = Backbone.View.extend({
    el:$(".resultTable"),
    template :   _.template($(".person").html()),
    initialize:function(){
        this.random();
    },
    random:function(){
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
window.App.Routers.Controller = Backbone.Router.extend({
    routes: {
        "": "select", // Пустой hash-тэг
        "!/": "select", // Пустой hash-тэг
        "!/select": "select", // Выбор полей поиска
        "!/findForm": "findForm", // Поисковая форма
        "!/result": "result", // Результат поиска
    },

    select: function () {
        $(".block").hide(); // Прячем все блоки
        $("#select").show(); // Показываем нужный
    },
    findForm: function () {
        $(".block").hide();
        if(!window.App.temp.newAdd){
            $("#findForm").show();
            return;
        }
        if(window.App.FindForm)window.App.FindForm.render();
        else window.App.FindForm = new window.App.Views.FindForm({model:window.App.tbl});

        window.App.temp.newAdd = false;
        $("#findForm").show();
    },
    result: function () {
        $(".block").hide(); // Прячем все блоки
        var coll = $("#findForm td.data");
//        var mod = new Backbone.Model.extend();
        var arr = [];
        var tables = [];
        var i = 0;
        for(var j=0;j<$("#findForm td.data").size();j++) {
            var obj = $("#findForm td.data")[j];
            var obj2 = $(obj).siblings()[0];
            var obj3 = $(obj2).children("input");
            tables.push($(obj).attr("table"));
            if($(obj).attr("type")== "date") {
                arr.push({
                    type: $(obj).attr("type"),
                    field: $(obj).attr("field"),
                    table: $(obj).attr("table"),
                    begin: $(obj3[0]).val(),
                    end: $(obj3[1]).val()
                });
            }else{
                arr.push({
                    type:$(obj).attr("type"),
                    field:$(obj).attr("field"),
                    table: $(obj).attr("table"),
                    val:$(obj3[0]).val()
                });
            }
            i++;
        }
        var tableUnion = _.union(tables);
        console.log(tableUnion);
        $.ajax({
            url: './search/request',
            async: false,
            dataType: 'json',
            data:{d:arr,tables:tableUnion},
            success: function (datas) {
                //console.log(datas);
                var tab = new window.App.Models.Result(datas);
                var res = new window.App.Views.Result({model:tab});
            }
        });
        $("#findForm").show(); // Показываем нужный
        $("#result").show(); // Показываем нужный

    },
});