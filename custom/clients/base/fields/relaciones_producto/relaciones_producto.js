({
    events: {
        'change .producto_list': 'relTipo_Producto',
    },
    productoSeleccionado: "",

    initialize: function (options) {
        //Inicializa campo custom
        this._super('initialize', [options]);
        options = options || {};
        options.def = options.def || {};
        rel_product = this;
        // this.productoSeleccionado = [];

        this.tipo_producto_list = App.lang.getAppListStrings('tipo_producto_list'); //Lista de Tipo Producto
        delete this.tipo_producto_list[""]; //Quita el vacio de la lista de productos

        this.model.on('change:relaciones_activas', this.rel_Productos, this);
        //this.loadData(); //Creación
        this.model.on('sync', this.loadData, this); //Registro
    },


    rel_Productos: function () {

        Array.prototype.unique = function (a) {
            return function () {
                return this.filter(a)
            }
        }(function (a, b, c) {
            return c.indexOf(a, b + 1) < 0
        });
        self_rel = this;
        var arr_rel_prev = self_rel.model._previousAttributes.relaciones_activas;
        var arr_re_selecc = self_rel.model.get('relaciones_activas');
        var list_rel_prod = App.lang.getAppListStrings('relaciones_producto_list');
        var arr_rel_nuevo = [];

        if (arr_rel_prev[0] != "" || arr_rel_prev!=undefined) {
            for (var i = 0; i < arr_re_selecc.length; i++) { // conyugue contacto aval
                var bandera = false;
                var valor = "";
                for (var j = 0; j < arr_rel_prev.length; j++) { // contacto conyugue

                    if (arr_re_selecc[i] == arr_rel_prev[j]) {
                        bandera = true;
                        valor = arr_rel_prev[j];
                    }
                }

                if (bandera) {
                    arr_rel_nuevo.push(valor);
                }
                else {
                    arr_rel_nuevo.push(arr_re_selecc[i]);
                }
            }
        }
        else {
            for (var i = 0; i < arr_re_selecc.length; i++) {
                arr_rel_nuevo.push(arr_re_selecc[i]);
            }
        }


        console.log(arr_rel_nuevo.unique());
        arr_rel_nuevo = arr_rel_nuevo.unique();
        var arr_final_rel = [];
        for (var property in list_rel_prod) {
            for (var k = 0; k < arr_rel_nuevo.length; k++) {
                if (list_rel_prod.hasOwnProperty(property) && arr_rel_nuevo[k] == property) {
                    arr_final_rel.push({relacion: property, producto: ''})
                }
            }
        }

        console.log(arr_final_rel);

        self_rel.productoSeleccionado = arr_final_rel.length > 0 ? arr_final_rel : "No data";
        self_rel.model.set('relaciones_producto_c', JSON.stringify(self_rel.productoSeleccionado));

        self_rel.render();

        /*  for (var property in relProducto) {
         for (var i = 0; i < relActiva.length; i++) {
         if (relProducto.hasOwnProperty(property) && relActiva[i] == property) {

         rel_product.productoSeleccionado.push({ relacion: property, producto: '' });

         }
         }
         }
         //Guarda JSON en el campo relaciones producto
         this.model.set('relaciones_producto_c', JSON.stringify(rel_product.productoSeleccionado));
         console.log(rel_product.productoSeleccionado);

         this.render();*/
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