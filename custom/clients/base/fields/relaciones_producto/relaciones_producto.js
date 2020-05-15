({
    events: {
        'change .producto_list': 'relTipo_Producto',
    },

    initialize: function (options) {
        //Inicializa campo custom
        this._super('initialize', [options]);
        options = options || {};
        options.def = options.def || {};
        rel_product = this;
        this.productoSeleccionado = [];

        this.tipo_producto_list = App.lang.getAppListStrings('tipo_producto_list'); //Lista de Tipo Producto 
        delete this.tipo_producto_list[""]; //Quita el vacio de la lista de productos

        this.model.on('change:relaciones_activas', this.rel_Productos, this);
        this.loadData(); //Creación
        this.model.on('sync', this.loadData, this); //Registro
    },

    rel_Productos: function () {

        // rel_product.productoSeleccionado = [];

        var relAtt = this.model._previousAttributes.relaciones_activas;
        var relActiva = this.model.get('relaciones_activas'); //Valores de Relaciones Activas
        var relProducto = App.lang.getAppListStrings('relaciones_producto_list'); //Lista nueva relaciones_producto_list

        for (var property in relProducto) {
            for (var i = 0; i < relActiva.length; i++) {
                if (relProducto.hasOwnProperty(property) && relActiva[i] == property) {

                    rel_product.productoSeleccionado.push({ relacion: property, producto: '' });

                }
            }
        }
        //Guarda JSON en el campo relaciones producto
        this.model.set('relaciones_producto_c', JSON.stringify(rel_product.productoSeleccionado));
        console.log(rel_product.productoSeleccionado);

        this.render();
    },

    relTipo_Producto: function (events) {
        var row = $(events.currentTarget).closest("tr");    // especifica al campo y busca el tr del producto seleccionado 
        var selectProducto = $(events.currentTarget).val();

        rel_product.productoSeleccionado[row.index()].producto = selectProducto.toString();  //elemento actual que se esta escogiendo en String

        var list = selectProducto.toString().split(','); //se crea un elemento para la separacion de productos por coma
        rel_product.productoSeleccionado[row.index()].productoList = list;

        //Guarda JSON en el campo relaciones producto
        this.model.set('relaciones_producto_c', JSON.stringify(rel_product.productoSeleccionado));
    },

    loadData: function () {
        var relacionProducto = this.model.get('relaciones_producto_c'); //campo relacion productos JSON
        rel_product.productoSeleccionado = JSON.parse(relacionProducto);

        console.log(rel_product.productoSeleccionado);
    },

})