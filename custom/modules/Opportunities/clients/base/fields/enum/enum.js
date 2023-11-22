({
    extendsFrom: 'EnumField',

    initialize: function (options){

        this._super('initialize',[options]);
    },

    render : function(){
        //Se elimina el Producto Leasing en la creación de solicitudes
    	if (this.name === "tipo_producto_c" && this.view.action == 'create') {
        var lista_producto = app.lang.getAppListStrings("tipo_producto_list");
        Object.keys(lista_producto).forEach(function (key) {
            if (key == "1") {
                delete lista_producto[key];
            }
        });
        this.items = lista_producto;
      }

        this._super('render');
    },

})