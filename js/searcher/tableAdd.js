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
        visible:true
    }
});
window.App.Collections.TableAdd = Backbone.Collection.extend({
    model:window.App.Models.FieldAdd,
});
window.App.Views.TableAdd = Backbone.View.extend({
    el:$("#added"),
    template:_.template($(".li-add").html()),
    initialize:function(){
        this.collection.bind("add", this.fun2, this);
        this.collection.bind("remove", this.fun2, this);
        //this.render();
    },
    render:function(){
        this.$el.empty();
        this.collection.each(function(per){
            console.log(per.attributes);
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
            //    console.log(this);
            var mod = window.App.tblAdd.collection.where({
                table:$(this).attr("table"),
                field:$(this).attr("field")
            });
            // console.log(mod);
            window.App.tblAdd.collection.remove(mod);
            //$(this).remove()
        });
    },
    fun2:function(){
        //console.log(this.collection);
        this.render();
    },
});

