/**
 * Created on 28.11.2015.
 */
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
            var siblCheck = $(obj).siblings()[1];

            var onscreen = $(siblCheck).children("input");
            tables.push($(obj).attr("table"));
            if($(obj).attr("type")== "date") {
                arr.push({
                    type: $(obj).attr("type"),
                    field: $(obj).attr("field"),
                    table: $(obj).attr("table"),
                    begin: $(obj3[0]).val(),
                    end: $(obj3[1]).val(),
                    onscreen: $(onscreen).prop("checked") ? 1 : 0
                });
            }else{
                arr.push({
                    type:$(obj).attr("type"),
                    field:$(obj).attr("field"),
                    table: $(obj).attr("table"),
                    val:$(obj3[0]).val(),
                    onscreen: $(onscreen).prop("checked") ? 1 : 0
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
        //$("#findForm").show(); // Показываем нужный
        $("#result").show(); // Показываем нужный

    },
});