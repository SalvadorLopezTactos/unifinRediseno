({
    events: {
        'change .producto_list': 'relTipo_Producto',
        'change .financiero_list': 'relProducto_Financiero',
    },

    productoSeleccionado: "",
    
    initialize: function (options) {
        //Inicializa campo custom
        this._super('initialize', [options]);
        options = options || {};
        options.def = options.def || {};
        rel_product = this;
        this.aux_bandera = 0;
        this.objectListaProdFinancieros={};

        this.tipo_producto_list = App.lang.getAppListStrings('tipo_producto_list'); //Lista que contiene todos los tipos de producto
        // this.tipo_producto_list = App.lang.getAppListStrings('tipo_producto_relaciones_list'); //Lista que solo contiene UNICLICK
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

    rel_Productos: function (listaProdFinanciero,posicion) {

        var arr_re_selecc = rel_product.model.get('relaciones_activas');
        var list_rel_prod = App.lang.getAppListStrings('relaciones_producto_list');
        var arr_final_rel = [];
        //Funcion donde se hace la comparación de ambas listas de relaciones, para la visualización de los valores de Relación en la tabla de Relaciones por producto
        for (var property in list_rel_prod) {
            for (var k = 0; k < arr_re_selecc.length; k++) {
                if (list_rel_prod.hasOwnProperty(property) && arr_re_selecc[k] == property) {
                    //Se agrega condición para mantener la lista de cada fila de forma independiente
                    if(typeof(rel_product.productoSeleccionado)=="string"){
                        arr_final_rel.push({ "rel": property, "prod": "", 'fncro': "", 'productoFncroList': "" });
                    }else{
                        if(typeof(posicion)=="number"){//Validación para saber que la función fue llamada manualmente desde el success de api call
                            arr_final_rel.push({ "rel": property, "prod": "", 'fncro': "", 'productoFncroList': rel_product.objectListaProdFinancieros[property] });
                        }else{
                            //Validación para saber que la función se llamó desde el evento change del campo y además el objeto ya viene lleno 
                            //para mantener los valores previamente seleccionados en la tabla de relaciones por producto
                            if(!_.isEmpty(rel_product.objectListaProdFinancieros)){

                                if(rel_product.objectListaProdFinancieros[property]==undefined){

                                    arr_final_rel.push({ "rel": property, "prod": "", 'fncro': "", 'productoFncroList': "" });

                                }else{

                                    arr_final_rel.push({ "rel": property, "prod": "", 'fncro': "", 'productoFncroList': rel_product.objectListaProdFinancieros[property] });

                                }

                            }else{
                                arr_final_rel.push({ "rel": property, "prod": "", 'fncro': "", 'productoFncroList': "" });
                            }
                            
                        }
                        
                    }
                    
                }
            }
        }
        /*
        if(listaProdFinanciero !=undefined && typeof(posicion)=="number"){
            arr_final_rel[posicion].productoFncroList=listaProdFinanciero;
        }
        */
        var jsonCampo = rel_product.actualizaCampo(arr_final_rel);
        console.log(jsonCampo);
        rel_product.model.set('relaciones_producto_c', JSON.stringify(jsonCampo));
        rel_product.productoSeleccionado = jsonCampo;
        rel_product.render();

    },

    actualizaCampo: function (relacion) {
        var array_temp = [];
        var campo_json = (rel_product.model.get('relaciones_producto_c') != undefined && rel_product.model.get('relaciones_producto_c') != "") ? rel_product.model.get('relaciones_producto_c') : JSON.stringify([{
            'rel': "",
            'prod': "",
            'productoList':"",
            'fncro': "",
            'productoFncroList': "",
        }]);
        if(rel_product.productoSeleccionado.length>0){
            campo_json=campo_json=JSON.stringify(rel_product.productoSeleccionado);
        }
        var campo_json = JSON.parse(campo_json);
        //Validación para mostrar las relaciones dependiendo si existe el valor de la relación en la lista relaciones_producto_list
        if (relacion != null) {
            for (var row in relacion) {
                console.log("opciones " + relacion[row].rel);
                var flag = false;
                var temp_val = "";
                if (relacion[row].rel != '' && relacion[row].rel != undefined) {
                    for (row_json in campo_json) {

                        if (relacion[row].rel == campo_json[row_json].rel) {
                            flag = true;
                            temp_val = campo_json[row_json];
                        }
                    }

                    if (flag == true) {
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

        var row = $(events.currentTarget).closest("tr"); //Especifica el campo Tipo de Producto y busca el tr del producto seleccionado
        var selectProducto = $(events.currentTarget).val(); //Obtiene el valor del Tipo de Producto seleccionado
        var selectProducto_clsc = $(events.currentTarget).val(); //Obtiene el valor del Tipo de Producto seleccionado
        this.row=$(events.currentTarget).closest("tr");
        this.elemento=events;

        /********Servicio para obtener los productos financieros por Tipo de Producto********/
        if (selectProducto != "" && selectProducto != null && selectProducto != undefined) {
            console.log("selectProducto " + selectProducto);

            app.api.call('GET', app.api.buildURL('GetProductosFinancieros/' + selectProducto), null, {
                success: function (data) {
                    DataProductFinanciers = data;
                    ProdFinanciers = [];

                    // console.log(DataProductFinanciers);

                    _.each(DataProductFinanciers, function (value, key) {

                        ProdFinanciers.push(DataProductFinanciers[key].producto_financiero);
                    });

                    console.log(ProdFinanciers);
                    //Se crea nueva lista con los valores dependientes del tipo de producto que se seleccione
                    var financiero_list = app.lang.getAppListStrings('producto_financiero_list');
                    
                    
                    Object.keys(financiero_list).forEach(function (key) {
                        if (!ProdFinanciers.includes(key)) {
                            delete financiero_list[key];
                        }
                    });
                    var relacion=$(rel_product.elemento.currentTarget).parent().siblings().eq(0).html();
                    //Eliminando acentos al key, específicamente para "Cónyuge"
                    var rel_clean=relacion.normalize("NFD").replace(/[\u0300-\u036f]/g, "");


                    rel_product.objectListaProdFinancieros[rel_clean]=financiero_list;
                    rel_product.producto_financiero_list = financiero_list; //Setea los valores dependientes por tipo de producto a la lista producto_financiero_list
                    console.log(rel_product.producto_financiero_list);
                    //Valor seleccionado en producto
                    var selectProducto=$(rel_product.elemento.currentTarget).val();
                    for (var i = 0; i < selectProducto.length; i++) {
                        selectProducto[i] = '^' + selectProducto[i] + '^';  //Ciclo para concatenar ^ al Tipo de producto
                    }
                    rel_product.productoSeleccionado[rel_product.row.index()].prod = selectProducto.toString();

                    rel_product.rel_Productos(financiero_list,rel_product.row.index()); //Ejecuta la funcion de Tipo de Producto ya que se quitaba el valor al momento de seleccionar un producto financiero

                    if(!_.isEmpty(rel_product.objectListaProdFinancieros)){

                        for (var element in rel_product.objectListaProdFinancieros) {
                            var nombre_relacion=element;
                            var posicion=-1;
                            for(var i=0;i<rel_product.productoSeleccionado.length;i++){

                                if(rel_product.productoSeleccionado[i].rel==nombre_relacion){
                                    posicion=i;
                                    nombre_relacion=rel_product.productoSeleccionado[i].rel;
                                }
                            }
                            if(posicion!=-1){
                                rel_product.productoSeleccionado[posicion].productoFncroList=rel_product.objectListaProdFinancieros[nombre_relacion];
                            }
                            
                        }

                    }
                    
                    rel_product.aux_bandera = 1; //Bandera para que no se cicle al momento de seleccionar un Tipo de producto y obtenga el producto financiero
                    rel_product.render();

                },
                error: function (e) {
                    throw e;
                }
            });
        }

        for (var i = 0; i < selectProducto.length; i++) {
            selectProducto[i] = '^' + selectProducto[i] + '^';  //Ciclo para concatenar ^ al Tipo de producto
        }

        var campo_temp = JSON.parse(rel_product.model.get('relaciones_producto_c'));
        campo_temp[row.index()].prod = selectProducto.toString();  //Se agrega la variable prod para el valor en el hbs

        cadena_temp = "";
        for (var j = 0; j < selectProducto_clsc.length; j++) {
            cadena_temp += rel_product.tipo_producto_list[selectProducto_clsc[j]] + ",";  //Ciclo para obtener el valor a la lista tipo_producto_list
        }

        cadena_temp = cadena_temp.slice(0, -1);
        campo_temp[row.index()].productoList = cadena_temp; //Se agrega variable productoList para el valor de la etiqueta y lo muestre en el detail hbs
        rel_product.model.set('relaciones_producto_c', JSON.stringify(campo_temp));

    },

    relProducto_Financiero: function (events) {

        var rowFinanciero = $(events.currentTarget).closest("tr"); //Se obtiene el tr en que esta posicionado el producto financiero seleccionado
        var selectProdFinanciero = $(events.currentTarget).val(); //Se obtiene el valor del producto financiero seleccionado
        var selectProdFinanciero_clsc = $(events.currentTarget).val(); //Se obtiene el valor del producto financiero seleccionado

        // console.log(rowFinanciero);
        console.log("selectProdFinanciero " + selectProdFinanciero);

        for (var x = 0; x < selectProdFinanciero.length; x++) {
            selectProdFinanciero[x] = '^' + selectProdFinanciero[x] + '^'; //Ciclo para concatenar ^ al Producto Financiero
        }

        var financiero_temp = JSON.parse(rel_product.model.get('relaciones_producto_c'));
        financiero_temp[rowFinanciero.index()].fncro = selectProdFinanciero.toString(); //Se agrega la variable fncro para el valor en el hbs
        // console.log(financiero_temp[rowFinanciero.index()].fncro);

        cadena_fncro = "";
        for (var z = 0; z < selectProdFinanciero_clsc.length; z++) {
            cadena_fncro += rel_product.producto_financiero_list[selectProdFinanciero_clsc[z]] + ","; //Ciclo para obtener el valor a la lista producto_financiero_list
        }
        console.log("cadena_fncro " + cadena_fncro);
        cadena_fncro = cadena_fncro.slice(0, -1);
        financiero_temp[rowFinanciero.index()].productoFncroList = cadena_fncro; //Se agrega variable productoFncroList para el valor de la etiqueta y lo muestre en el detail hbs
        console.log(financiero_temp[rowFinanciero.index()].productoFncroList);

        rel_product.model.set('relaciones_producto_c', JSON.stringify(financiero_temp));
    },

    loadData: function () {

        //Carga de Inicio todos los valores que se tiene en el JSON en el campo de relaciones_producto_c
        var relacionProducto = rel_product.model.get('relaciones_producto_c');
        console.log("relacionProducto");
        console.log(relacionProducto);
        rel_product.productoSeleccionado = JSON.parse(relacionProducto);
        rel_product.render();
    },

    _render: function () {
        this._super("_render");
        $("div[data-name='relaciones_producto_c']").hide(); //Oculta el campo relaciones_producto_c donde se almacena el JSON

        if (this.aux_bandera == 0) { //Bandera para que se ejecute la función de Tipo de producto
            $('.producto_list').trigger('change');
        }
    },

})