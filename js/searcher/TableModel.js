/**
 * Created by Андрей on 10.11.2015.
 */
window.App = {
    Models : {},
    Views : {},
    Collections : {},
    temp : {}
};
window.App.Models.Table  = Backbone.Model.extend({
    defaults: {
        name: 'name',
        description: 'desc',
        size: 100
    },
    initialize:function(){
        //$.ajax({
        //    url: './search/getModelAttributes',
        //    async: true,
        //    type: 'GET',
        //    contentType: 'application/x-www-form-urlencoded',
        //    dataType: 'json',
        //    success: function (data) {
        //        console.log(this);
        //        window.App.temp = {df:12};
        //    }
        //});
        console.log(window.App.temp);
        _.each(window.App.temp, function(num, key){
            this.set(key,num);
            //console.log(this);

        },this);
    }
});
window.App.Views.Table = Backbone.View.extend({
    tagName: 'ol',
});
