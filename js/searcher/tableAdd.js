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
    updateSort:false,
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
                    titleTable:window.App.SelectFields.permitingTables[per.attributes.table],
                    table:per.attributes.table,
                    type:per.attributes.type
                })
            );
        },this);
        $("#added li").on("dblclick",function(){
            var mod = window.App.tblAdd.collection.where({
                table:$(this).attr("table"),
                field:$(this).attr("field")
            });
            window.App.tblAdd.collection.remove(mod);
            var i=0;
            window.App.tblAdd.collection.each(function(field){
                    i++;
                    field.set({id:i});
                }
            );
            //$(this).remove()
        });
    },
    sort:function(){
        var i = 0;
        var coll = new window.App.Collections.TableAdd();
        $("#added li").each(function(){
            i++;
            var mod = window.App.tblAdd.collection.where({
                table:$(this).attr("table"),
                field:$(this).attr("field")
            });
            var b = mod[0];
            b.set({id:i});
            coll.add(b,{silent: true});
        });
        this.collection.reset(coll.models);
        coll.remove();
    },

    fun2:function(){
        this.render();
    },
});

