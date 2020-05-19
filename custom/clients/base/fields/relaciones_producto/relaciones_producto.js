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

        self_rel = this;
        var arr_rel_prev = self_rel.model._previousAttributes.relaciones_activas;
        var arr_re_selecc = self_rel.model.get('relaciones_activas');
        var list_rel_prod = App.lang.getAppListStrings('relaciones_producto_list');
        var arr_rel_nuevo = [];
        console.log(arr_rel_prev);
        arr_rel_prev = arr_rel_prev == undefined ? arr_re_selecc : arr_rel_prev;

        if (arr_rel_prev[0] != "") {
            for (var i = 0; i < arr_re_selecc.length; i++) { // valor seleccionado de rel activa
                var bandera = false;
                var valor = "";
                for (var j = 0; j < arr_rel_prev.length; j++) { // valor previo de rel activa

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

        var arr_final_rel = [];
        for (var property in list_rel_prod) {
            for (var k = 0; k < arr_rel_nuevo.length; k++) {
                if (list_rel_prod.hasOwnProperty(property) && arr_rel_nuevo[k] == property) {

                    arr_final_rel.push({ relacion: property, producto: '' });
                    
                }
            }
        }

        console.log(arr_final_rel);

        self_rel.productoSeleccionado = arr_final_rel.length > 0 ? arr_final_rel : "No data";
        self_rel.model.set('relaciones_producto_c', JSON.stringify(self_rel.productoSeleccionado));

        // console.log(JSON.stringify(self_rel.productoSeleccionado));
        self_rel.render();
    },

    relTipo_Producto: function (events) {
        var row = $(events.currentTarget).closest("tr"); // busca los productos mediante el tr
        var selectProducto = $(events.currentTarget).val(); // obtiene el valor de los productos que esta seleccionando en el multiselect
        var selectProducto_det = $(events.currentTarget).val();
        // Se agregan los gorritos ^ por cada producto seleccionado
        for (var i = 0; i < selectProducto.length; i++) {
            selectProducto[i] = '^' + selectProducto[i] + '^';
        }

        rel_product.productoSeleccionado[row.index()].producto = selectProducto.toString();  //Productos separados con gorritos ^ para que se visualicen en el edit.hbs en el multiselect
        rel_product.productoSeleccionado[row.index()].productoList = selectProducto_det.toString().split(',');; //Productos que se visualizan en el detail.hbs

        //Guarda JSON en el campo relaciones producto
        this.model.set('relaciones_producto_c', JSON.stringify(rel_product.productoSeleccionado));
    },

    loadData: function () {
        //Carga la información del campo que almacena un JSON para la carga de datos en la tabla de relaciones productos
        var relacionProducto = rel_product.model.get('relaciones_producto_c'); //campo relacion productos JSON
        rel_product.productoSeleccionado = JSON.parse(relacionProducto);

        // console.log(rel_product.productoSeleccionado);
        rel_product.render();
    },

    _render: function () {
        this._super("_render");
    },
})