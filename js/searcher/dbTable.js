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
    initialize: function(){
        // this.url +=  "?tableName=" + this.tableName;
    },
});
window.App.Views.dbTable = Backbone.View.extend({
    template: _.template($(".li").html()),
    templateTable: _.template($(".tableView").html()),
    initialize:function(){
        this.collection.fetch({async: false});

    },
    render:function(){
        //console.log(this.collection.get("id"));
        $(".tables").append(this.templateTable({tableName:this.collection.tableName}));
        this.$el = $("#view_" + this.collection.tableName + " ol");
        //console.log(this.collection.models[0].attributes);
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
            //console.log(this);

            var coll = window.App.tblAdd.collection.where({
                    "table":$(this).attr("table"),
                    "field":$(this).attr("field")}
            );
            if(coll.length == 0) {
                window.App.tblAdd.collection.add({
                    "type": $(this).attr("type"),
                    "title": $(this).attr("title"),
                    "table": $(this).attr("table"),
                    "field": $(this).attr("field")
                });
                window.App.temp.newAdd = true;
            }
            //$(this).remove();
        });
    }
});

