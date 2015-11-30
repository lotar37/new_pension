/**
 * Created  on 28.11.2015.
 */
window.App.Models.dbTableField  = Backbone.Model.extend({
    default:{
        field:{
            title:"",
            type:"",
            field:""
        },
    }
});
window.App.Collections.dbTable = Backbone.Collection.extend({
    tableName:"Persons",
    model:window.App.Models.dbTableField,
    url:"./search/getModelAttributes",
    setModel: function(tableName){
        this.tableName = tableName;
        this.url = this.url + "?tableName=" + tableName;
    },
});
window.App.Views.dbTable = Backbone.View.extend({
    template: _.template($(".li").html()),
    templateTable: _.template($(".tableView").html()),
    initialize:function(){
        this.collection.fetch({async: false});

    },
    render:function(){
        $(".tables").append(this.templateTable({tableName:this.collection.tableName}));
        this.$el = $("#view_" + this.collection.tableName + " ol");
        _.each(this.collection.models[0].attributes, function(field,id){
            this.$el.append(this.template({
                tableAttr: field.title,
                field: field.field,
                type: field.type,
                table: this.collection.tableName
            }));
        },this);
        $("#view_" + this.collection.tableName).draggable({ handle: "p" ,  containment: "parent"});
        $("#view_" + this.collection.tableName + " li").on("click",function (){

            var coll = window.App.tblAdd.collection.where({
                    "table":$(this).attr("table"),
                    "field":$(this).attr("field")}
            );
            if(coll.length == 0) {
                if($(this).attr("type")=="date") {
                    window.App.tblAdd.collection.add({
                        "type": $(this).attr("type"),
                        "title": $(this).attr("title"),
                        "table": $(this).attr("table"),
                        "field": $(this).attr("field"),
                        "begin": "",
                        "end": "",
                        "visible": true,
                        "id":window.App.tblAdd.collection.length + 1
                    });
                }else{
                    window.App.tblAdd.collection.add({
                        "type": $(this).attr("type"),
                        "title": $(this).attr("title"),
                        "table": $(this).attr("table"),
                        "field": $(this).attr("field"),
                        "value": "",
                        "visible": true,
                        "id":window.App.tblAdd.collection.length + 1
            });

                }
            }
        });
    }
});

