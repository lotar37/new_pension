/**
 * Created by Андрей on 10.11.2015.
 */
window.App = {
    Models : {},
    Views : {},
    Collections : {},
    Routers : {},
    temp : {}
};
window.App.Models.Table  = Backbone.Model.extend({
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
            this.$el.append(this.template({tableAttr:num, table:key}));
        },this);
    }
});
window.App.Routers.Controller = Backbone.Router.extend({
    routes: {
        "": "select", // Пустой hash-тэг
        "!/": "select", // Пустой hash-тэг
        "!/select": "select", // Выбор полей поиска
        "!/findForm": "findForm", // Поисковая форма
    },

    select: function () {
        $(".block").hide(); // Прячем все блоки
        $("#select").show(); // Показываем нужный
    },

    findForm: function () {
        $(".block").hide();
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
            var s = "";
                $.each(d, function(i, object) {
                if (i == $(obj).attr("field")) {
                    s = object;
                    return
                }
            });
            if(s == "boolean")$(".addedFields").append(templateB({title:$(obj).attr("title"),field:$(obj).attr("field")}));
            if(s == "string")$(".addedFields").append(templateS({title:$(obj).attr("title"),field:$(obj).attr("field")}));
            if( s == "integer")$(".addedFields").append(templateI({title:$(obj).attr("title"),field:$(obj).attr("field")}));
            if(s == "date")$(".addedFields").append(templateD({title:$(obj).attr("title"),field:$(obj).attr("field")}));
        });
        $(".inputdate").inputmask("d.m.y");
        $(".inputinteger").inputmask("integer");
        $("#findForm").show();
    },

});

