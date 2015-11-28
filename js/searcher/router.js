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
        //if(!window.App.temp.newAdd){
        //    $("#findForm").show();
        //    return;
        //}
        if(window.App.FindForm)window.App.FindForm.render();
        else window.App.FindForm = new window.App.Views.FindForm({model:window.App.tbl});
        window.App.temp.newAdd = false;
        $("#findForm").show();
    },
    result: function () {
        $(".block").hide(); // Прячем все блоки
        if(!window.App.Result) window.App.Result =new window.App.Views.Result();
        window.App.Result.render();
        $("#result").show(); // Показываем нужный
    },
});