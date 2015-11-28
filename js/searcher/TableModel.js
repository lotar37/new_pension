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
        $("input").on("change",function() {
            var mod = window.App.tblAdd.collection.where({
                    "table": $(this).parent().prev().attr("table"),
                    "field": $(this).parent().prev().attr("field")
                }
            );
            var b = mod[0];
            if ($(this).attr("type") == "text") {
                b.set({value: $(this).val()});
               // console.log($(this).parent().prev());
            } else if($(this).attr("type") == "checkbox"){
              //  console.log($(this).prop("checked"));
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
    initialize:function(){
        this.render();
    },
    render:function(){
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
