/**
 * Created by Андрей on 10.11.2015.
 */
window.App = {
    Models : {},
    Views : {},
    Collections : {},
    Routers : {},
    temp : {newAdd:false}
};
//Backbone.sync = function(method, model, options) {
//    //options = "async:false";
//};
window.App.Models.Table  = Backbone.Model.extend({
    url: './search/getModelAttributes',

    defaults: {
    },
    initialize:function(){
    }
});
window.App.Views.Table = Backbone.View.extend({
    el:$("#selectable"),
    template: _.template($(".li").html()),
    initialize:function(){
         this.render();
    },
    render:function(){
        _.each(this.model.attributes, function(num, key){
           // console.log(num.type);
            this.$el.append(this.template({tableAttr:num.attr, table:key}));
        },this);
    }
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
    result: function () {
        $(".block").hide(); // Прячем все блоки
        $("#result").show(); // Показываем нужный
        $.ajax({
            url: './search/request',
            async: false,
            //type: 'GET',
           // contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            data:{foo:{d:1,x:3}, arnor:{d:2,x:1}},
            success: function (datas) {

            }
        });

    },

    findForm: function () {
        $(".block").hide();
        if(!window.App.temp.newAdd){
            $("#findForm").show();
            return;
        }
        var templateB = _.template($(".addedBooleanField").html());
        var templateI = _.template($(".addedIntegerField").html());
        var templateS = _.template($(".addedStringField").html());
        var templateD = _.template($(".addedDateField").html());
        $(".addedFields").empty();
        var d = {};
        $.ajax({
            url: './search/getModelTypes',
            async: false,
            type: 'GET',
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            success: function (data) {
                d = data;
            }
        });
        $("#added li").each(function(index,obj){
            var a = _.values(_.pick(d,$(obj).attr("field")));
            //console.log(a[0]);
            if(a[0] == "boolean")$(".addedFields").append(templateB({title:$(obj).attr("title"),field:$(obj).attr("field")}));
            if(a[0] == "string")$(".addedFields").append(templateS({title:$(obj).attr("title"),field:$(obj).attr("field")}));
            if(a[0] == "integer")$(".addedFields").append(templateI({title:$(obj).attr("title"),field:$(obj).attr("field")}));
            if(a[0] == "date")$(".addedFields").append(templateD({title:$(obj).attr("title"),field:$(obj).attr("field")}));
        });
        $(".inputdate").inputmask("d.m.y");
        $(".inputinteger").inputmask("integer");
        window.App.temp.newAdd = false;
        $("#findForm").show();
    },

});

