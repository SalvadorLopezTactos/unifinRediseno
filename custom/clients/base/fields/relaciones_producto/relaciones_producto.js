({
    events: {
        'change .producto_list': 'relTipo_Producto',
        'change .negocio_list': 'relNegocio',
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
        this.objectListaNegocios = {};
        this.objectListaProdFinancieros = {};
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

    rel_Productos: function (listaProdFinanciero, posicion) {
        rel_product = this;
        var arr_re_selecc = rel_product.model.get('relaciones_activas');
        var list_rel_prod = App.lang.getAppListStrings('relaciones_producto_list');
        var arr_final_rel = [];
        var AsesorRMUniclick = App.user.attributes.puestousuario_c;
        var productoUNICLICK = App.user.attributes.productos_c;

        //Funcion donde se hace la comparación de ambas listas de relaciones, para la visualización de los valores de Relación en la tabla de Relaciones por producto
        for (var property in list_rel_prod) {
            for (var k = 0; k < arr_re_selecc.length; k++) {
                if (list_rel_prod.hasOwnProperty(property) && arr_re_selecc[k] == property) {
                    //Se agrega condición para mantener la lista de cada fila de forma independiente
                    if (typeof (rel_product.productoSeleccionado) == "string") {
                        //VALIDACIÓN DE PUESTO ASESOR RM / ASESOR UNICLICK Y PRODUCTO UNICLICK
                        if ((AsesorRMUniclick == '53' || AsesorRMUniclick == '54') && productoUNICLICK.includes("8") && (this.model.get('account_id1_c') == '' || this.model.get('account_id1_c') == undefined)) {
                            //CARGA EN AUTO TIPO DE PRODUCTO CREDITO SIMPLE, NEGOCIO UNICLIK Y PRODUCTO FINANCIERO UNICREDIT
                            arr_final_rel.push({ "rel": property, "prod": "^2^", "neg": "^10^", "fncro": "^39^", "productoFncroList": { "39": "UNICREDIT", "49": "UNIPREMIUM", "77": "CRÉDITO PYME" }, "negocioList": { "2": "CRÉDITO S0S", "3": "ESTRUCTURADO", "7": "OPERATIVO - NO NEGOCIO", "10": "UNICLICK", "11": "CRÉDITO SIMPLE", "13": "CRÉDITO PLAZO" }, "prodsFinancieros": "UNICREDIT" });

                        } else {
                            arr_final_rel.push({ "rel": property, "prod": "", "neg": "", 'fncro': "", 'productoFncroList': "" });
                        }

                    } else {

                        if (typeof (posicion) == "number") {//Validación para saber que la función fue llamada manualmente desde el success de api call
                            arr_final_rel.push({ "rel": property, "prod": "", "neg": "", 'fncro': "", 'productoFncroList': rel_product.objectListaProdFinancieros[property] });

                        } else {
                            //Validación para saber que la función se llamó desde el evento change del campo y además el objeto ya viene lleno 
                            //para mantener los valores previamente seleccionados en la tabla de relaciones por producto
                            if (!_.isEmpty(rel_product.objectListaProdFinancieros)) {

                                if (rel_product.objectListaProdFinancieros[property] == undefined) {
                                    //VALIDACIÓN DE PUESTO ASESOR RM / ASESOR UNICLICK Y PRODUCTO UNICLICK
                                    if ((AsesorRMUniclick == '53' || AsesorRMUniclick == '54') && productoUNICLICK.includes("8") && (this.model.get('account_id1_c') == '' || this.model.get('account_id1_c') == undefined)) {
                                        //CARGA EN AUTO TIPO DE PRODUCTO CREDITO SIMPLE, NEGOCIO UNICLIK Y PRODUCTO FINANCIERO UNICREDIT
                                        arr_final_rel.push({ "rel": property, "prod": "^2^", "neg": "^10^", "fncro": "^39^", "productoFncroList": { "39": "UNICREDIT", "49": "UNIPREMIUM", "77": "CRÉDITO PYME" }, "negocioList": { "2": "CRÉDITO S0S", "3": "ESTRUCTURADO", "7": "OPERATIVO - NO NEGOCIO", "10": "UNICLICK", "11": "CRÉDITO SIMPLE", "13": "CRÉDITO PLAZO" }, "prodsFinancieros": "UNICREDIT" });

                                    } else {
                                        arr_final_rel.push({ "rel": property, "prod": "", "neg": "", 'fncro': "", 'productoFncroList': "" });
                                    }

                                } else {
                                    arr_final_rel.push({ "rel": property, "prod": "", "neg": "", 'fncro': "", 'productoFncroList': rel_product.objectListaProdFinancieros[property] });
                                }

                            } else {
                                //VALIDACIÓN DE PUESTO ASESOR RM / ASESOR UNICLICK Y PRODUCTO UNICLICK
                                if ((AsesorRMUniclick == '53' || AsesorRMUniclick == '54') && productoUNICLICK.includes("8") && (this.model.get('account_id1_c') == '' || this.model.get('account_id1_c') == undefined)) {
                                    //CARGA EN AUTO TIPO DE PRODUCTO CREDITO SIMPLE, NEGOCIO UNICLIK Y PRODUCTO FINANCIERO UNICREDIT
                                    arr_final_rel.push({ "rel": property, "prod": "^2^", "neg": "^10^", "fncro": "^39^", "productoFncroList": { "39": "UNICREDIT", "49": "UNIPREMIUM", "77": "CRÉDITO PYME" }, "negocioList": { "2": "CRÉDITO S0S", "3": "ESTRUCTURADO", "7": "OPERATIVO - NO NEGOCIO", "10": "UNICLICK", "11": "CRÉDITO SIMPLE", "13": "CRÉDITO PLAZO" }, "prodsFinancieros": "UNICREDIT" });

                                } else {
                                    arr_final_rel.push({ "rel": property, "prod": "", "neg": "", 'fncro': "", 'productoFncroList': "" });
                                }
                            }
                        }
                    }
                }
            }
        }
        if (listaProdFinanciero != undefined && typeof (posicion) == "number") {
            arr_final_rel[posicion].productoFncroList = listaProdFinanciero;
        }
        var jsonCampo = rel_product.actualizaCampo(arr_final_rel);
        rel_product.model.set('relaciones_producto_c', JSON.stringify(jsonCampo));
        rel_product.productoSeleccionado = jsonCampo;
        rel_product.render();
    },

    actualizaCampo: function (relacion) {
        var array_temp = [];
        var campo_json = (rel_product.model.get('relaciones_producto_c') != undefined && rel_product.model.get('relaciones_producto_c') != "") ? rel_product.model.get('relaciones_producto_c') : JSON.stringify([{
            'rel': "",
            'prod': "",
            'neg': "",
            'productoList': "",
            'fncro': "",
            'productoFncroList': "",
        }]);
        if (rel_product.productoSeleccionado.length > 0) {
            campo_json = campo_json = JSON.stringify(rel_product.productoSeleccionado);
        }
        var campo_json = JSON.parse(campo_json);
        //Validación para mostrar las relaciones dependiendo si existe el valor de la relación en la lista relaciones_producto_list
        if (relacion != null) {
            for (var row in relacion) {
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
        this.row = $(events.currentTarget).closest("tr");
        this.elemento = events;
        /********Servicio para obtener los productos financieros por Tipo de Producto********/
        if (selectProducto != "" && selectProducto != null && selectProducto != undefined) {
            app.api.call('GET', app.api.buildURL('GetProductosFinancieros/' + selectProducto), null, {
                success: function (data) {
                    DataProductFinanciers = data;
                    ProdFinanciers = [];
                    Negocios = [];
                    _.each(DataProductFinanciers, function (value, key) {
                        Negocios.push(DataProductFinanciers[key].negocio);
                        ProdFinanciers.push(DataProductFinanciers[key].producto_financiero);
                    });
                    //Se crea nueva lista con los valores dependientes del tipo de producto que se seleccione
                    var negocio_list = app.lang.getAppListStrings('producto_negocio_list');
                    Object.keys(negocio_list).forEach(function (key) {
                        if (!Negocios.includes(key)) {
                            delete negocio_list[key];
                        }
                    });
                    //Se crea nueva lista con los valores dependientes del tipo de producto que se seleccione
                    var financiero_list = app.lang.getAppListStrings('producto_financiero_list');
                    Object.keys(financiero_list).forEach(function (key) {
                        if (!ProdFinanciers.includes(key)) {
                            delete financiero_list[key];
                        }
                    });
                    var relacion = $(rel_product.elemento.currentTarget).parent().siblings().eq(0).html();
                    //Eliminando acentos al key, específicamente para "Cónyuge"
                    var rel_clean = relacion.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                    rel_product.objectListaNegocios[rel_clean] = negocio_list;
                    rel_product.objectListaProdFinancieros[rel_clean] = financiero_list;
                    rel_product.negocio_list = negocio_list; //Setea los valores dependientes por tipo de producto a la lista negocio_list
                    //Valor seleccionado en producto
                    var selectProducto = $(rel_product.elemento.currentTarget).val();
                    for (var i = 0; i < selectProducto.length; i++) {
                        selectProducto[i] = '^' + selectProducto[i] + '^';  //Ciclo para concatenar ^ al Tipo de producto
                    }
                    rel_product.productoSeleccionado[rel_product.row.index()].prod = selectProducto.toString();
                    rel_product.rel_Productos(financiero_list, rel_product.row.index()); //Ejecuta la funcion de Tipo de Producto ya que se quitaba el valor al momento de seleccionar un producto financiero
                    if (!_.isEmpty(rel_product.objectListaNegocios)) {
                        for (var element in rel_product.objectListaNegocios) {
                            var nombre_relacion = element;
                            var posicion = -1;
                            for (var i = 0; i < rel_product.productoSeleccionado.length; i++) {
                                if (rel_product.productoSeleccionado[i].rel == nombre_relacion) {
                                    posicion = i;
                                    nombre_relacion = rel_product.productoSeleccionado[i].rel;
                                }
                            }
                            if (posicion != -1) {
                                rel_product.productoSeleccionado[posicion].negocioList = rel_product.objectListaNegocios[nombre_relacion];
                            }
                        }
                    }
                    newneg = '';
                    ProdFinanciers = [];
                    for (var option of $('[data-field="negocio_list"]')[rel_product.row.index()].options) {
                        if (option.selected) {
                            Object.keys(rel_product.productoSeleccionado[rel_product.row.index()].negocioList).forEach(function (key) {
                                if (option.value == key) {
                                    newneg = newneg + '^' + key + '^';
                                    _.each(DataProductFinanciers, function (value, key1) {
                                        if (DataProductFinanciers[key1].negocio == key) ProdFinanciers.push(DataProductFinanciers[key1].producto_financiero);
                                    });
                                }
                            });
                        }
                    }
                    Object.keys(financiero_list).forEach(function (key2) {
                        if (!ProdFinanciers.includes(key2)) delete financiero_list[key2];
                    });
                    newneg = newneg.replace("^^", "^,^");
                    rel_product.productoSeleccionado[rel_product.row.index()].neg = newneg.toString();
                    rel_product.rel_Productos(financiero_list, rel_product.row.index());
                    newpro = '';
                    for (var option of $('[data-field="financiero_list"]')[rel_product.row.index()].options) {
                        if (option.selected) {
                            Object.keys(financiero_list).forEach(function (key) {
                                if (option.value == key) newpro = newpro + '^' + key + '^';
                            });
                        }
                    }
                    newpro = newpro.replace("^^", "^,^");
                    rel_product.productoSeleccionado[rel_product.row.index()].fncro = newpro.toString();
                    rel_product.productoSeleccionado[rel_product.row.index()].productoFncroList = financiero_list;
                    rel_product.rel_Productos(financiero_list, rel_product.row.index());
                    rel_product.aux_bandera = 1; //Bandera para que no se cicle al momento de seleccionar un Tipo de producto y obtenga el producto financiero
                    rel_product.render();
                },
                error: function (e) {
                    throw e;
                }
            });
        }
        else {
            rel_product.productoSeleccionado[rel_product.row.index()].prod = "";
            rel_product.productoSeleccionado[rel_product.row.index()].neg = "";
            rel_product.productoSeleccionado[rel_product.row.index()].fncro = "";
            rel_product.productoSeleccionado[rel_product.row.index()].negocioList = "";
            rel_product.productoSeleccionado[rel_product.row.index()].productoFncroList = "";
            rel_product.negocio_list = "";
            rel_product.producto_financiero_list = "";
            rel_product.rel_Productos("", rel_product.row.index());
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

    relNegocio: function (events) {
        var row = $(events.currentTarget).closest("tr"); //Especifica el campo Negocio y busca el tr del producto seleccionado
        var selectNegocio = $(events.currentTarget).val(); //Obtiene el valor del campo Negocio seleccionado
        var selectNegocio_clsc = $(events.currentTarget).val(); //Obtiene el valor del Negocio seleccionado
        this.row = $(events.currentTarget).closest("tr");
        this.elemento = events;
        var producto = rel_product.productoSeleccionado[rel_product.row.index()].prod;
        producto = producto.replace(/\^/g, "");
        /********Obtiene los productos financieros por Negocio********/
        if (selectNegocio != "" && selectNegocio != null && selectNegocio != undefined) {
            app.api.call('GET', app.api.buildURL('GetProductosFinancieros/' + producto), null, {
                success: function (data) {
                    DataProductFinanciers = data;
                    ProdFinanciers = [];
                    var selectNegocio = $(rel_product.elemento.currentTarget).val();
                    _.each(DataProductFinanciers, function (value, key) {
                        for (var i = 0; i < selectNegocio.length; i++) {
                            if (DataProductFinanciers[key].negocio == selectNegocio[i]) {
                                ProdFinanciers.push(DataProductFinanciers[key].producto_financiero);
                            }
                        }
                    });
                    //Se crea nueva lista con los valores dependientes del tipo de producto que se seleccione
                    var financiero_list = app.lang.getAppListStrings('producto_financiero_list');
                    Object.keys(financiero_list).forEach(function (key) {
                        if (!ProdFinanciers.includes(key)) {
                            delete financiero_list[key];
                        }
                    });
                    var relacion = $(rel_product.elemento.currentTarget).parent().siblings().eq(0).html();
                    //Eliminando acentos al key, específicamente para "Cónyuge"
                    var rel_clean = relacion.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                    rel_product.objectListaProdFinancieros[rel_clean] = financiero_list;
                    rel_product.producto_financiero_list = financiero_list; //Setea los valores dependientes por negocio a la lista producto_financiero_list
                    //Valor seleccionado en Negocio
                    var selectNegocio = $(rel_product.elemento.currentTarget).val();
                    for (var i = 0; i < selectNegocio.length; i++) {
                        selectNegocio[i] = '^' + selectNegocio[i] + '^';  //Ciclo para concatenar ^ al Negocio
                    }
                    rel_product.productoSeleccionado[rel_product.row.index()].neg = selectNegocio.toString();
                    rel_product.rel_Productos(financiero_list, rel_product.row.index()); //Ejecuta la funcion de Tipo de Producto ya que se quitaba el valor al momento de seleccionar un producto financiero
                    if (!_.isEmpty(rel_product.objectListaProdFinancieros)) {
                        for (var element in rel_product.objectListaProdFinancieros) {
                            var nombre_relacion = element;
                            var posicion = -1;
                            for (var i = 0; i < rel_product.productoSeleccionado.length; i++) {
                                if (rel_product.productoSeleccionado[i].rel == nombre_relacion) {
                                    posicion = i;
                                    nombre_relacion = rel_product.productoSeleccionado[i].rel;
                                }
                            }
                            if (posicion != -1) {
                                rel_product.productoSeleccionado[posicion].productoFncroList = rel_product.objectListaProdFinancieros[nombre_relacion];
                            }
                        }
                    }
                    newpro = '';
                    for (var option of $('[data-field="financiero_list"]')[rel_product.row.index()].options) {
                        if (option.selected) {
                            Object.keys(financiero_list).forEach(function (key) {
                                if (option.value == key) newpro = newpro + '^' + key + '^';
                            });
                        }
                    }
                    newpro = newpro.replace("^^", "^,^");
                    rel_product.productoSeleccionado[rel_product.row.index()].fncro = newpro.toString();
                    rel_product.productoSeleccionado[rel_product.row.index()].productoFncroList = financiero_list;
                    rel_product.rel_Productos(financiero_list, rel_product.row.index());
                    rel_product.aux_bandera = 1; //Bandera para que no se cicle al momento de seleccionar un Tipo de producto y obtenga el producto financiero
                    var campo_temp = JSON.parse(rel_product.model.get('relaciones_producto_c'));
                    campo_temp[row.index()].productoFncroList = financiero_list;  //Se agrega la variable productoFncroList para el valor en el hbs
                    rel_product.model.set('relaciones_producto_c', JSON.stringify(campo_temp));
                    rel_product.render();
                },
                error: function (e) {
                    throw e;
                }
            });
        }
        else {
            rel_product.productoSeleccionado[rel_product.row.index()].neg = "";
            rel_product.productoSeleccionado[rel_product.row.index()].fncro = "";
            rel_product.productoSeleccionado[rel_product.row.index()].productoFncroList = "";
            rel_product.producto_financiero_list = "";
            rel_product.rel_Productos("", rel_product.row.index());
        }
        for (var i = 0; i < selectNegocio.length; i++) {
            selectNegocio[i] = '^' + selectNegocio[i] + '^';  //Ciclo para concatenar ^ al Tipo de negocio
        }
        var campo_temp = JSON.parse(rel_product.model.get('relaciones_producto_c'));
        campo_temp[row.index()].neg = selectNegocio.toString();  //Se agrega la variable prod para el valor en el hbs
        rel_product.model.set('relaciones_producto_c', JSON.stringify(campo_temp));
    },

    relProducto_Financiero: function (events) {
        var rowFinanciero = $(events.currentTarget).closest("tr"); //Se obtiene el tr en que esta posicionado el producto financiero seleccionado
        var selectProdFinanciero = $(events.currentTarget).val(); //Se obtiene el valor del producto financiero seleccionado
        var selectProdFinanciero_clsc = $(events.currentTarget).val(); //Se obtiene el valor del producto financiero seleccionado
        for (var x = 0; x < selectProdFinanciero.length; x++) {
            selectProdFinanciero[x] = '^' + selectProdFinanciero[x] + '^'; //Ciclo para concatenar ^ al Producto Financiero
        }
        cadena_fncro = "";
        var list_prod_financiero = app.lang.getAppListStrings('producto_financiero_list');
        for (var z = 0; z < selectProdFinanciero_clsc.length; z++) {
            cadena_fncro += list_prod_financiero[selectProdFinanciero_clsc[z]] + ","; //Ciclo para obtener el valor a la lista producto_financiero_list
        }
        cadena_fncro = cadena_fncro.slice(0, -1);
        rel_product.productoSeleccionado[rel_product.row.index()].fncro = selectProdFinanciero.toString();
        rel_product.rel_Productos(cadena_fncro, rel_product.row.index()); //Ejecuta la funcion de Tipo de Producto ya que se quitaba el valor al momento de seleccionar un producto financiero
        var financiero_temp = JSON.parse(rel_product.model.get('relaciones_producto_c'));
        financiero_temp[rowFinanciero.index()].fncro = selectProdFinanciero.toString(); //Se agrega la variable fncro para el valor en el hbs
        financiero_temp[rowFinanciero.index()].prodsFinancieros = cadena_fncro; //Se agrega variable prodsFinancieros para el valor de la etiqueta y lo muestre en el detail hbs
        rel_product.model.set('relaciones_producto_c', JSON.stringify(financiero_temp));
    },

    loadData: function () {
        if(rel_product.model.attributes.relaciones_producto_c!=""){
            //Carga de Inicio todos los valores que se tiene en el JSON en el campo de relaciones_producto_c
            var relacionProducto = rel_product.model.get('relaciones_producto_c');
            rel_product.productoSeleccionado = JSON.parse(relacionProducto);
            this.aux_bandera = 1;
            rel_product.render();
        }  
    },

    _render: function () {
        this._super("_render");
        if (this.action !== 'edit' && this.aux_bandera) {
            var relacionProducto = rel_product.model.get('relaciones_producto_c');
            rel_product.productoSeleccionado = JSON.parse(relacionProducto);
        }
        $("div[data-name='relaciones_producto_c']").hide(); //Oculta el campo relaciones_producto_c donde se almacena el JSON
    },
})