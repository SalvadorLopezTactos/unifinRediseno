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

        // this.tipo_producto_list = App.lang.getAppListStrings('tipo_producto_list');
        this.tipo_producto_list = App.lang.getAppListStrings('tipo_producto_relaciones_list'); //Lista que solo contiene UNICLICK
        delete this.tipo_producto_list[""];
        this.model.on('change:relaciones_activas', this.rel_Productos, this);
        this.model.on('sync', this.loadData, this);
    },

    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                this.render();
            }
        }, this);
    },

    rel_Productos: function () {
        var arr_re_selecc = rel_product.model.get('relaciones_activas');
        var list_rel_prod = App.lang.getAppListStrings('relaciones_producto_list');
        var arr_final_rel = [];

        for (var property in list_rel_prod) {
            for (var k = 0; k < arr_re_selecc.length; k++) {
                if (list_rel_prod.hasOwnProperty(property) && arr_re_selecc[k] == property) {
                    arr_final_rel.push({ "rel": property, "prod": "" });

                }
            }
        }
        var jsonCampo = rel_product.actualizaCampo(arr_final_rel);
        rel_product.model.set('relaciones_producto_c', JSON.stringify(jsonCampo));
        rel_product.productoSeleccionado = jsonCampo;
        rel_product.render();

    },

    actualizaCampo: function (relacion) {
        var array_temp = [];
        var campo_json = (rel_product.model.get('relaciones_producto_c') != undefined && rel_product.model.get('relaciones_producto_c') != "")  ? rel_product.model.get('relaciones_producto_c') : JSON.stringify([{
            'rel': "",
            'prod': ""
        }]);
        var campo_json = JSON.parse(campo_json);

        if (relacion != null) {
            for (var row in relacion) {
                console.log("opciones " + relacion[row].rel);
                var flag = false;
                var temp_val = "";
                if (relacion[row].rel!='' && relacion[row].rel!=undefined) {
                for (row_json in campo_json) {

                        if (relacion[row].rel == campo_json[row_json].rel) {
                            flag = true;
                            temp_val = campo_json[row_json];
                        }
                    }

                    if (flag==true) {
                        array_temp.push(temp_val)
                    } else {
                        array_temp.push(relacion[row]);
                    }
                }
            }
        }
        return array_temp;
    },

    relTipo_Producto: function (events) {

        var row = $(events.currentTarget).closest("tr");    // especifica al campo y busca el tr del producto seleccionado
        var selectProducto = $(events.currentTarget).val();
        var selectProducto_clsc = $(events.currentTarget).val();

        for (var i = 0; i < selectProducto.length; i++) {
            selectProducto[i] = '^' + selectProducto[i] + '^';
        }

        var campo_temp = JSON.parse(rel_product.model.get('relaciones_producto_c'));
        campo_temp[row.index()].prod = selectProducto.toString();

        cadena_temp = "";
        for (var j = 0; j < selectProducto_clsc.length; j++) {
            cadena_temp += rel_product.tipo_producto_list[selectProducto_clsc[j]] + ",";
        }
        cadena_temp = cadena_temp.slice(0, -1);
        campo_temp[row.index()].productoList = cadena_temp;
        rel_product.model.set('relaciones_producto_c', JSON.stringify(campo_temp));
    },

    loadData: function () {
        var relacionProducto = rel_product.model.get('relaciones_producto_c');
        rel_product.productoSeleccionado = JSON.parse(relacionProducto);
        rel_product.render();
    },

    _render: function () {
        this._super("_render");
        $("div[data-name='relaciones_producto_c']").hide();
    },

})