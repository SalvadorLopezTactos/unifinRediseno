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

        // var rproducto = this.model.get('relaciones_producto_c');

        // if (rproducto != '' && rproducto != undefined) { //No funciona se descompone la vista

        rel_product.productoSeleccionado = [];
        var relActiva = this.model.get('relaciones_activas'); //Valores de Relaciones Activas
        console.log("RelACtiva " + relActiva);
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

        // }
        this.render();
    },

    relTipo_Producto: function (events) {
        var row = $(events.currentTarget).closest("tr");    // especifica al campo y busca el tr del producto seleccionado 
        var selectProducto = $(events.currentTarget).val();

        rel_product.productoSeleccionado[row.index()].producto = selectProducto.toString();  //elemento actual que se esta escogiendo en String

        //Guarda JSON en el campo relaciones producto
        this.model.set('relaciones_producto_c', JSON.stringify(rel_product.productoSeleccionado));
    },

    loadData: function () {
        var relacionProducto = this.model.get('relaciones_producto_c'); //campo relacion productos JSON
        // var json = JSON.parse(relacionProducto);

        // for (i = 0; i < json.length; i++) {
        //     var keyproduct = json[i].producto; //ingreso al producto en el array
        //     var arsplit = keyproduct.split(','); //separo con comas

        //     var sConcat = ''; //inicia con vacio

        //     for (var x = 0; x < arsplit.length; x++) {
        //         sConcat += App.lang.getAppListStrings('tipo_producto_list').arsplit[i] + ','; //obtengo las etiquetas por id que recorren agregando una coma
        //     }
        //     json[i].producto = sConcat; //en mi producto agrego la conversion de id por las etiquetas

        //     console.log(json[i].producto);
        // }

        rel_product.productoSeleccionado = JSON.parse(relacionProducto);

        console.log(rel_product.productoSeleccionado);
    },

})