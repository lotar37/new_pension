/**
 * Created on 28.11.2015.
 */
window.App.Models.FieldAdd  = Backbone.Model.extend({
    default:{
        title:"",
        table:"",
        field:"",
        type:"",
        value:"",
        visible:true,
        id:0
    }
});
window.App.Collections.TableAdd = Backbone.Collection.extend({
    model:window.App.Models.FieldAdd,
     comparator : function(model) {
        return model.get("id");
    },

});
window.App.Views.TableAdd = Backbone.View.extend({
    el:$("#added"),
    template:_.template($(".li-add").html()),
    initialize:function(){
        this.collection.bind("add", this.fun2, this);
        this.collection.bind("remove", this.fun2, this);
        this.collection.bind("reset", this.render, this);
    },
    render:function(){
        this.$el.empty();

        this.collection.each(function(per){
            this.$el.append(
                this.template({
                    tableAttr:per.attributes.title,
                    field:per.attributes.field,
                    table:per.attributes.table,
                    type:per.attributes.type
                })
            );
        },this);
        $("#added li").on("click",function(){
            var mod = window.App.tblAdd.collection.where({
                table:$(this).attr("table"),
                field:$(this).attr("field")
            });
            window.App.tblAdd.collection.remove(mod);
            //$(this).remove()
        });
    },

    fun2:function(){
        this.render();
    },
});

