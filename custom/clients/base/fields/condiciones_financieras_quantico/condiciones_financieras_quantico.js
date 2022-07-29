({
    events: {
        'click  .plusNuevaCF': 'addNewCFConfigurada',
        'click  .borrarCFQuantico': 'deleteCFConfigurada',
        'change .fieldCFConfig':'updateJsonCFConfiguradas',
        'keyup .fieldValidateRange':'validarRangos',
        'change .selectToHidden':'setValToInputHidden',
        'change .setDefaultValues':'setDefaultValues'
    },
    initialize: function (options) {
        this._super('initialize', [options]);

        this.model.addValidationTask('chk_condFinEmptyValues', _.bind(this.chk_condFinEmptyValues, this));

        this.jsonCFConfiguradas={
            "RequestId":"",//IdSolicitudCRM
            "OpportunitiesId": "",
            "FinancialTermGroupResponseList":[]
        };

        this.model.on('sync', this.loadData, this);

        //Plantillas json para cada tipo de datos
        this.setPlantillasJSON();
    },

    setPlantillasJSON:function(tipoDato){
        var jsonRespuesta={};
        if(tipoDato=="Catalogo"){
            //Tipo Catálogo
            jsonRespuesta={
                "Id":"",
                "Name":"",
                "DataType":{
                    "Id":7,
                    "Name":"Catálogo",
                    "Catalog": {
                        "Id": 1,
                        "Name": "Tipo de activo"
                    }
                },
                "Value": {
                    "Value":"",
                    "ValueId": ""
                }
            };
        }
        if(tipoDato=="Rango Porcentaje"){
            jsonRespuesta={
                "Id":"",
                "Name":"",
                "DataType":{
                    "Id":9,
                    "Name":"Rango Porcentaje",
                },
                "Configuration": {
                    "IsDelimitedValues": true,
                    "UpperLimit": 100.00000000
                },
                "Value": {
                    "ValueMin": "",
                    "ValueMax": ""
                }
            };
        }
	if(tipoDato=="RangoDecimal"){
            jsonRespuesta={
                "Id":"",
                "Name":"",
                "DataType":{
                    "Id":11,
                    "Name":"RangoDecimal",
                },
                "Value": {
                    "ValueMin": "",
                    "ValueMax": ""
                }
            };
        }

        if(tipoDato=="Rango Entero"){
            jsonRespuesta={
                "Id": "",
                "Name": "",
                "DataType": {
                    "Id": 4,
                    "Name": "Rango Entero"
                },
                "Configuration": {
                    "IsDelimitedValues": true,
                    "LowerLimit": 1.00000000,
                    "UpperLimit": 1000.00000000
                },
                "Value": {
                    "ValueMin": "",
                    "ValueMax": ""
                }
            }
        }

        if(tipoDato=="Rango Moneda"){
            jsonRespuesta={
                "Id": "",
                "Name": "",
                "DataType": {
                    "Id": 5,
                    "Name": "Rango Moneda"
                },
                "Configuration": {
                    "IsDelimitedValues": true,
                    "UpperLimit": 100000.00000000
                },
                "Value": {
                    "ValueMin": "",
                    "ValueMax": ""
                }
            }
        }

        if(tipoDato=="Booleano"){
            jsonRespuesta={
                "Id": "",
                "Name": "",
                "DataType": {
                    "Id": 1,
                    "Name": "Booleano"
                },
                "Value": {
                    "Value": "True"
                }
            }
        }

	if(tipoDato=="Numérico"){
            jsonRespuesta={
                "Id": "",
                "Name": "",
                "DataType": {
                    "Id": 2,
                    "Name": "Numérico"
                },
                "Value": {
                    "Value": ""
                }
            }
        }


        return jsonRespuesta;

    },

    loadData: function (options) {
        //Solo cargar los datos de condiciones financieras cuando no se está creando y que sea diferente del tipo de producto Tarjeta de Crédito
        if(this.view.currentState != "create" && this.model.get('tipo_producto_c') != '14'){
            //Validación para obtener información del campo en lugar de lanzar petición al servicio
            if (this.model.get('cf_quantico_politica_c') == "") {
                this.headers = [];
                this.bodyTable = [];
                this.mainRowsBodyTable = [];
                this.mainRowsConfigBodyTable = [];
                self = this;

                //Alert procesando
                app.alert.show("getInfoCFQuantico", {
                    level: "process",
                    title: "Obteniendo información, por favor espere",
                    autoClose: false
                });

                //Forma url de petición
                var tipo_producto=self.model.get('tipo_producto_c');
                var product_id = self.model.get('producto_financiero_c');
                product_id = (product_id==undefined || product_id=='')? 0:product_id;
                var url = app.api.buildURL('CondicionesFinancierasQuantico?tipo_producto='+tipo_producto+'&product_id='+product_id, null, null, {});
                app.api.call('GET', url, {}, {
                    success: function (data) {
                        try {
                            var jsonStringPolitica=JSON.stringify(data);
                            //Llenar los headers
                            //Recorres el array de respuesta para corroborar el tipo de dato para conocer el campo html que corresponde
                            if (data.FinancialTermGroupResponseList != undefined && data.FinancialTermGroupResponseList.length > 0) {
                                self.model.set("cf_quantico_politica_c",jsonStringPolitica);
                                //Ajuste: Obtener el elemento con mayor número de columnas para evitar que algunas filas se vean sin un título en su respectiva columna
                                var arr_numero_elementos=[];
                                for (let pos = 0; pos < data.FinancialTermGroupResponseList.length; pos++) {
                                    arr_numero_elementos[pos]=data.FinancialTermGroupResponseList[pos].FinancialTermResponseList.length;
                                }
                                var posicion_del_maximo=self.indexOfMax(arr_numero_elementos);

                                var arrayRespuesta = data.FinancialTermGroupResponseList[posicion_del_maximo].FinancialTermResponseList;
                                if (arrayRespuesta.length > 0) {
                                    for (var i = 0; i < arrayRespuesta.length; i++) {

                                        var objHeader = {};
                                        //Procedimiento para obtener la opción de la lista con mayor número de caracteres
                                        //para poder establecer el ancho de la columna de mayor tamaño, añadiendo espacios en blanco
                                        if(arrayRespuesta[i].DataType.Id=='7'){
                                            var nombre_lista = arrayRespuesta[i].Name;
                                            nombre_lista=nombre_lista.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                                            var lista_valores = App.lang.getAppListStrings('mapeo_nombre_attr_cf_quantico_list')[nombre_lista];
                                            var valores_select = data['listaValores'][lista_valores];
                                            var array_longitudes=[];
                                            var array_aux_espacios=[];

                                            for (var index = 0; index < valores_select.length; index++) {
                                                array_longitudes.push(valores_select[index].Name.length)
                                            }
                                            var mayorLongitud=Math.max.apply(null, array_longitudes);
                                            //Generando string con valores vacíos para ajustar el ancho de columna
                                            for (let index = 0; index < mayorLongitud; index++) {
                                                array_aux_espacios.push('1');
                                            }

                                            objHeader["name"] = arrayRespuesta[i].Name;
                                            objHeader["idCampo"] = arrayRespuesta[i].DataType.Id;
                                            objHeader["numeroEspacios"] = array_aux_espacios;

                                        }else{
                                            objHeader["name"] = arrayRespuesta[i].Name;
                                            objHeader["idCampo"] = arrayRespuesta[i].DataType.Id;
                                        }

                                        // Comprobando los id 4,5,9 y 11 para colocar doble campo, que son los de rango (2 inputs)
                                        if (arrayRespuesta[i].DataType.Id == '4' || arrayRespuesta[i].DataType.Id == '5' || arrayRespuesta[i].DataType.Id == '9' || arrayRespuesta[i].DataType.Id == '11') {
                                            objHeader['dobleCampo'] = '1';
                                            //self.bodyTable.push();
                                        } else {
                                            objHeader['dobleCampo'] = '';
                                        }
                                        self.headers.push(objHeader);
                                    }
                                }

                                //Llenado del cuerpo de la tabla
                                for (var index = 0; index < data.FinancialTermGroupResponseList.length; index++) {
                                    var arrayRespuesta = data.FinancialTermGroupResponseList[index];
                                    var objRow = {};
                                    /*
                                        id 1: Booleano - Check
                                        id 2: Numérico - Text
                                        id 3: Texto - Text
                                        id 4: Rango entero - 2 Text
                                        id 5: Rango moneda - 2 Text
                                        id 6: Moneda - Text
                                        id 7: Catálogo - Select
                                        id 8: Porcentaje - Text
                                        id 9: Rango porcentaje - 2 Text
                                        id 10: Decimal - Text
                                        id 11: Rango Decimal - 2 Text
                                    */
                                    self.bodyTable = [];
                                    for (var i = 0; i < arrayRespuesta.FinancialTermResponseList.length; i++) {
                                        if (arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '4' ||
                                            arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '5' ||
                                            arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '9' ||
                                            arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '11'
                                        ) {
                                            var rangoInferior = arrayRespuesta.FinancialTermResponseList[i].Value.ValueMin;
                                            var rangoSuperior = arrayRespuesta.FinancialTermResponseList[i].Value.ValueMax;

                                            var limiteInferior="";
                                            var limiteSuperior="";
                                            if(arrayRespuesta.FinancialTermResponseList[i].Configuration != undefined){
                                                limiteSuperior=arrayRespuesta.FinancialTermResponseList[i].Configuration.UpperLimit;

                                                if(arrayRespuesta.FinancialTermResponseList[i].Configuration.LowerLimit != undefined){
                                                    limiteInferior=arrayRespuesta.FinancialTermResponseList[i].Configuration.LowerLimit;
                                                }
                                            }

                                            self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','idNodo':arrayRespuesta.FinancialTermResponseList[i].Id,'nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'rangoInferior': rangoInferior, 'rangoSuperior': "","limiteInferior":limiteInferior,"limiteSuperior":limiteSuperior});
                                            self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','idNodo':arrayRespuesta.FinancialTermResponseList[i].Id,'nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'rangoInferior': "", 'rangoSuperior': rangoSuperior,"limiteInferior":limiteInferior,"limiteSuperior":limiteSuperior });
                                        } else if (arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '7') {//Catálogo
                                            //Obteniendo los valores de la lista
                                            var nombre_lista = arrayRespuesta.FinancialTermResponseList[i].Name;
                                            nombre_lista=nombre_lista.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                                            //Obteniendo el mapeo desde la lista
                                            var lista_valores = App.lang.getAppListStrings('mapeo_nombre_attr_cf_quantico_list')[nombre_lista];
                                            var valores_select = data['listaValores'][lista_valores];
                                            var valores_select_obj = {};
                                            //Convirtiendo el arreglo a objeto para poderlo mostrar en las opciones del campo select
                                            for (var j = 0; j < valores_select.length; j++) {
                                                valores_select_obj[valores_select[j].Id] = valores_select[j].Name;
                                            }
                                            var valorSelected = arrayRespuesta.FinancialTermResponseList[i].Value.ValueId;

                                            self.bodyTable.push({ 'select': '1', 'text': '', 'checkbox': '','idNodo':arrayRespuesta.FinancialTermResponseList[i].Id,'nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'valoresCatalogo': valores_select_obj, 'valorSelected': valorSelected });
                                        } else if (arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '1') {//Check
                                            var strChecked = "";
                                            var valorBoolean = arrayRespuesta.FinancialTermResponseList[i].Value.Value;
                                            if (valorBoolean == "True") {
                                                strChecked = 'checked'
                                            }
                                            self.bodyTable.push({ 'select': '', 'text': '', 'checkbox': '1','idNodo':arrayRespuesta.FinancialTermResponseList[i].Id,'nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, "checked": strChecked });
                                        } else {// Solo 1 Text
                                            self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','idNodo':arrayRespuesta.FinancialTermResponseList[i].Id,'nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name,"valorCampo": arrayRespuesta.FinancialTermResponseList[i].Value.Value});
                                        }
                                    }
                                    self.mainRowsBodyTable.push({ 'bodyTable': self.bodyTable });

                                }

                            }else{
                                app.alert.show("errorGetInfoCFQuantico", {
                                    level: "warning",
                                    title: "No se recuperaron condiciones financieras de política para este producto.",
                                    autoClose: true
                                });
                            }
                            app.alert.dismiss('getInfoCFQuantico');

                            //Se agrega ajuste para saber cuando mostrar la tabla ajustada, en caso de que solo haya 1 una cf, el campo queda como anteriormente,
                            //En caso contrario, las condiciones financieras se consolidan solo en una fila
                            if(self.mainRowsBodyTable.length>1 && self.mainRowsBodyTable[0].bodyTable[0].select=='1'){//Se aplica parche para condiciones financieras múltiples para tipo Factoraje
                                //Consolidar todas las CF en una fila
                                self.showTableRows=0;
                                self.bodyTableModified=self.mainRowsBodyTable[0].bodyTable;
                                self.valoresCatalogoModified={};
                                var listaValoresCampoSelectBase={};

                                self.listaValoresRangoInferior={};
                                //Armando la lista para mostrar las opciones disponibles en el campo select, ejemplo: Tipo Activo
                                for (let index = 0; index < self.mainRowsBodyTable.length; index++) {
                                    //Se obtiene la lista con los valores del catálogo para poder extraer tanto el id como el valor
                                    for (let i = 0; i < self.mainRowsBodyTable[index].bodyTable.length; i++) {
                                        if(self.mainRowsBodyTable[index].bodyTable[i].select=="1"){
                                            var campoSelect=self.mainRowsBodyTable[index].bodyTable[i];
                                            var listaValoresCampoSelectBase=self.mainRowsBodyTable[index].bodyTable[i].valoresCatalogo;

                                            //Antes de agregar a la lista de valores que se mostrará, se comprueba que la clave aún no exista
                                            if (!self.valoresCatalogoModified.hasOwnProperty(campoSelect.valorSelected)) {
                                                self.valoresCatalogoModified[campoSelect.valorSelected]=listaValoresCampoSelectBase[campoSelect.valorSelected];

                                            }
                                            self.bodyTableModified[i].valoresCatalogoModified=self.valoresCatalogoModified;

                                        }

                                        if(self.mainRowsBodyTable[index].bodyTable[i].text=="1" && self.mainRowsBodyTable[index].bodyTable[i].rangoInferior!=""){

                                            var listaValoresRangoInferior={};
                                            var nombreColumna=self.mainRowsBodyTable[index].bodyTable[i].nombreColumna;

                                            //Se recorre nuevamente el objeto completo para obtener los valores diferentes por cada rango inferior con el mismo nombreColumma
                                            for (let x = 0; x < self.mainRowsBodyTable.length; x++) {

                                                for (let y = 0; y < self.mainRowsBodyTable[x].bodyTable.length; y++) {
                                                    if(self.mainRowsBodyTable[x].bodyTable[y].text=="1" && self.mainRowsBodyTable[x].bodyTable[y].rangoInferior!="" && self.mainRowsBodyTable[x].bodyTable[y].nombreColumna==nombreColumna){
                                                        if (!listaValoresRangoInferior.hasOwnProperty(self.mainRowsBodyTable[x].bodyTable[y].rangoInferior)) {
                                                            listaValoresRangoInferior[self.mainRowsBodyTable[x].bodyTable[y].rangoInferior]=self.mainRowsBodyTable[x].bodyTable[y].rangoInferior;
                                                        }

                                                    }
                                                }
                                            }

                                            //Se establece nuevo atributo para deshabilitar todos los campos de rango inferior excepto el primero dentro de la fila

                                            self.bodyTableModified[i].deshabilitado='disabled';

                                            self.bodyTableModified[i].valoresRangoInferior=listaValoresRangoInferior;
                                        }

                                        //Llenando lista con valores de rango superior
                                        if(self.mainRowsBodyTable[index].bodyTable[i].text=="1" && self.mainRowsBodyTable[index].bodyTable[i].rangoSuperior!=""){

                                            var listaValoresRangoSuperior={};
                                            var nombreColumna=self.mainRowsBodyTable[index].bodyTable[i].nombreColumna;

                                            //Se recorre nuevamente el objeto completo para obtener los valores diferentes por cada rango inferior con el mismo nombreColumma
                                            for (let x = 0; x < self.mainRowsBodyTable.length; x++) {

                                                for (let y = 0; y < self.mainRowsBodyTable[x].bodyTable.length; y++) {
                                                    if(self.mainRowsBodyTable[x].bodyTable[y].text=="1" && self.mainRowsBodyTable[x].bodyTable[y].rangoSuperior!="" && self.mainRowsBodyTable[x].bodyTable[y].nombreColumna==nombreColumna){
                                                        if (!listaValoresRangoSuperior.hasOwnProperty(self.mainRowsBodyTable[x].bodyTable[y].rangoSuperior)) {
                                                            listaValoresRangoSuperior[self.mainRowsBodyTable[x].bodyTable[y].rangoSuperior]=self.mainRowsBodyTable[x].bodyTable[y].rangoSuperior;
                                                        }

                                                    }
                                                }
                                            }

                                            self.bodyTableModified[i].deshabilitado='disabled';

                                            self.bodyTableModified[i].valoresRangoSuperior=listaValoresRangoSuperior;
                                        }

                                    }
                                }

                                //Se habilita primer rango superior y deshabilitando los restantes
                                self.bodyTableModified[2].deshabilitado='';

                                var jsonFormatToValuesDefault={};

                                for (var indice = 0; indice < self.mainRowsBodyTable.length; indice++) {
                                    var columnaBaseTipo="";
                                    var keyRangoInferior="";
                                    for (var idx = 0; idx < self.mainRowsBodyTable[indice].bodyTable.length; idx++) {

                                        //Armando nuevo json para establecer valores default al aplicar evento change en campos

                                        if(self.mainRowsBodyTable[indice].bodyTable[idx].select=="1"){
                                            if(columnaBaseTipo==""){
                                                var idValorSeleccionado=self.mainRowsBodyTable[indice].bodyTable[idx].valorSelected;
                                                columnaBaseTipo=self.mainRowsBodyTable[indice].bodyTable[idx].valoresCatalogo[idValorSeleccionado];
                                            }

                                            if(!jsonFormatToValuesDefault.hasOwnProperty(columnaBaseTipo)){
                                                jsonFormatToValuesDefault[columnaBaseTipo]={}
                                            }

                                        }
                                        if(self.mainRowsBodyTable[indice].bodyTable[idx].text=="1" && self.mainRowsBodyTable[indice].bodyTable[idx].rangoInferior!=""){
                                            if(keyRangoInferior==""){
                                                keyRangoInferior=self.mainRowsBodyTable[indice].bodyTable[idx].rangoInferior;
                                            }
                                            if(!jsonFormatToValuesDefault[columnaBaseTipo].hasOwnProperty(keyRangoInferior)){
                                                jsonFormatToValuesDefault[columnaBaseTipo][keyRangoInferior]={}
                                            }else{
                                                jsonFormatToValuesDefault[columnaBaseTipo][keyRangoInferior][self.mainRowsBodyTable[indice].bodyTable[idx].nombreColumna + "_inferior"]={};
                                                jsonFormatToValuesDefault[columnaBaseTipo][keyRangoInferior][self.mainRowsBodyTable[indice].bodyTable[idx].nombreColumna + "_inferior"]=self.mainRowsBodyTable[indice].bodyTable[idx].rangoInferior;
                                            }

                                            //jsonFormatToValuesDefault[self.mainRowsBodyTable[indice].bodyTable[idx].nombreColumna].rangoInferior=self.mainRowsBodyTable[indice].bodyTable[idx].rangoInferior;
                                        }
                                        if(self.mainRowsBodyTable[indice].bodyTable[idx].text=="1" && self.mainRowsBodyTable[indice].bodyTable[idx].rangoSuperior!=""){
                                            jsonFormatToValuesDefault[columnaBaseTipo][keyRangoInferior][self.mainRowsBodyTable[indice].bodyTable[idx].nombreColumna + "_superior"]={};
                                            jsonFormatToValuesDefault[columnaBaseTipo][keyRangoInferior][self.mainRowsBodyTable[indice].bodyTable[idx].nombreColumna + "_superior"]=self.mainRowsBodyTable[indice].bodyTable[idx].rangoSuperior;
                                        }
                                    }
                                }
                                //Se añade el json generado a una variable global para poder leerla a través de todo el código
                                self.jsonToValuesDefault=jsonFormatToValuesDefault;

                            }else{
                                self.showTableRows=1;
                            }

                            self.render();

                        } catch (e) {
                        app.alert.dismiss('getInfoCFQuantico');
                        app.alert.show("errorGetInfoCFQuantico", {
                            level: "warning",
                            title: "No se pudieron recuperar condiciones financieras de política. Por favor, intenta refrescando tu página.",
                            autoClose: true
                        });

                        }
                    },
                    error: function (e) {
                        console.log(e);
                        app.alert.dismiss('getInfoCFQuantico');
                        app.alert.show("errorGetInfoCFQuantico", {
                            level: "error",
                            title: "No se pudieron recuperar condiciones financieras de política. Por favor, intenta refrescando tu página",
                            autoClose: true
                        });
                    }
                });

            } else {
                this.headers = [];
                this.bodyTable = [];
                this.mainRowsBodyTable = [];
                this.mainRowsConfigBodyTable = [];
                self = this;
                //Cuando se tiene lleno el campo cf_quantico_politica_c, se formatea el el diseño con el contenido de dicho campo
                var data = JSON.parse(this.model.get('cf_quantico_politica_c'));
                //Llenar los headers
                //Recorres el array de respuesta para corroborar el tipo de dato para conocer el campo html que corresponde
                if (data.FinancialTermGroupResponseList.length > 0) {
                    //Ajuste: Obtener el elemento con mayor número de columnas para evitar que algunas filas se vean sin un título en su respectiva columna
                    var arr_numero_elementos=[];
                    for (let pos = 0; pos < data.FinancialTermGroupResponseList.length; pos++) {
                        arr_numero_elementos[pos]=data.FinancialTermGroupResponseList[pos].FinancialTermResponseList.length;
                    }
                    var posicion_del_maximo=self.indexOfMax(arr_numero_elementos);

                    var arrayRespuesta = data.FinancialTermGroupResponseList[posicion_del_maximo].FinancialTermResponseList;
                    if (arrayRespuesta.length > 0) {
                        for (var i = 0; i < arrayRespuesta.length; i++) {
                            var objHeader = {};
                            //Procedimiento para obtener la opción de la lista con mayor número de caracteres
                            //para poder establecer el ancho de la columna de mayor tamaño, añadiendo espacios en blanco
                            if(arrayRespuesta[i].DataType.Id=='7'){
                                var nombre_lista = arrayRespuesta[i].Name;
                                nombre_lista=nombre_lista.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                                var lista_valores = App.lang.getAppListStrings('mapeo_nombre_attr_cf_quantico_list')[nombre_lista];
                                var valores_select = data['listaValores'][lista_valores];
                                var array_longitudes=[];
                                var array_aux_espacios=[];

                                for (var index = 0; index < valores_select.length; index++) {
                                    array_longitudes.push(valores_select[index].Name.length);
                                }

                                var mayorLongitud=Math.max.apply(null, array_longitudes);
                                //Generando string con valores vacíos para ajustar el ancho de columna
                                for (let index = 0; index < mayorLongitud; index++) {
                                    array_aux_espacios.push('1');
                                }

                                objHeader["name"] = arrayRespuesta[i].Name;
                                objHeader["idCampo"] = arrayRespuesta[i].DataType.Id;
                                objHeader["numeroEspacios"] = array_aux_espacios;

                            }else{
                                objHeader["name"] = arrayRespuesta[i].Name;
                                objHeader["idCampo"] = arrayRespuesta[i].DataType.Id;
                            }

                            // Comprobando los id 4,5,9 y 11 para colocar doble campo, que son los de rango (2 inputs)
                            if (arrayRespuesta[i].DataType.Id == '4' || arrayRespuesta[i].DataType.Id == '5' || arrayRespuesta[i].DataType.Id == '9' || arrayRespuesta[i].DataType.Id == '11') {
                                objHeader['dobleCampo'] = '1';
                                //self.bodyTable.push();
                            } else {
                                objHeader['dobleCampo'] = '';
                            }
                            self.headers.push(objHeader);
                        }
                    }

                    //Llenado del cuerpo de la tabla
                    for (var index = 0; index < data.FinancialTermGroupResponseList.length; index++) {
                        var arrayRespuesta = data.FinancialTermGroupResponseList[index];
                        var objRow = {};
                        /*
                            id 1: Booleano - Check
                            id 2: Numérico - Text
                            id 3: Texto - Text
                            id 4: Rango entero - 2 Text
                            id 5: Rango moneda - 2 Text
                            id 6: Moneda - Text
                            id 7: Catálogo - Select
                            id 8: Porcentaje - Text
                            id 9: Rango porcentaje - 2 Text
                            id 10: Decimal - Text
                            id 11: Rango Decimal - 2 Text
                        */
                        self.bodyTable = [];
                        for (var i = 0; i < arrayRespuesta.FinancialTermResponseList.length; i++) {
                            if (arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '4' ||
                                arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '5' ||
                                arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '9' ||
                                arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '11'
                            ) {
                                var rangoInferior = arrayRespuesta.FinancialTermResponseList[i].Value.ValueMin;
                                var rangoSuperior = arrayRespuesta.FinancialTermResponseList[i].Value.ValueMax;

                                var limiteInferior="";
                                var limiteSuperior="";
                                if(arrayRespuesta.FinancialTermResponseList[i].Configuration != undefined){
                                    limiteSuperior=arrayRespuesta.FinancialTermResponseList[i].Configuration.UpperLimit;

                                    if(arrayRespuesta.FinancialTermResponseList[i].Configuration.LowerLimit != undefined){
                                        limiteInferior=arrayRespuesta.FinancialTermResponseList[i].Configuration.LowerLimit;
                                    }
                                }

                                self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','idNodo':arrayRespuesta.FinancialTermResponseList[i].Id,'nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'rangoInferior': rangoInferior, 'rangoSuperior': "" ,"limiteInferior":limiteInferior,"limiteSuperior":limiteSuperior});
                                self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','idNodo':arrayRespuesta.FinancialTermResponseList[i].Id,'nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'rangoInferior': "", 'rangoSuperior': rangoSuperior,"limiteInferior":limiteInferior,"limiteSuperior":limiteSuperior });
                            } else if (arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '7') {//Catálogo
                                //Obteniendo los valores de la lista
                                var nombre_lista = arrayRespuesta.FinancialTermResponseList[i].Name;
                                nombre_lista=nombre_lista.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                                //Obteniendo el mapeo desde la lista
                                var lista_valores = App.lang.getAppListStrings('mapeo_nombre_attr_cf_quantico_list')[nombre_lista];
                                var valores_select = data['listaValores'][lista_valores];
                                var valores_select_obj = {};
                                //Convirtiendo el arreglo a objeto para poderlo mostrar en las opciones del campo select
                                for (var j = 0; j < valores_select.length; j++) {
                                    valores_select_obj[valores_select[j].Id] = valores_select[j].Name;
                                }
                                var valorSelected = arrayRespuesta.FinancialTermResponseList[i].Value.ValueId;

                                self.bodyTable.push({ 'select': '1', 'text': '', 'checkbox': '','idNodo':arrayRespuesta.FinancialTermResponseList[i].Id,'nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'valoresCatalogo': valores_select_obj, 'valorSelected': valorSelected });
                            } else if (arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '1') {//Check
                                var strChecked = "";
                                var valorBoolean = arrayRespuesta.FinancialTermResponseList[i].Value.Value;
                                if (valorBoolean == "True") {
                                    strChecked = 'checked'
                                }
                                self.bodyTable.push({ 'select': '', 'text': '', 'checkbox': '1','idNodo':arrayRespuesta.FinancialTermResponseList[i].Id,'nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, "checked": strChecked });
                            } else {// Solo 1 Text
                                self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','idNodo':arrayRespuesta.FinancialTermResponseList[i].Id,'nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name,"valorCampo": arrayRespuesta.FinancialTermResponseList[i].Value.Value });
                            }
                        }
                        self.mainRowsBodyTable.push({ 'bodyTable': self.bodyTable });

                    }

                }

                //Se agrega ajuste para saber cuando mostrar la tabla ajustada, en caso de que solo haya 1 una cf, el campo queda como anteriormente,
                //En caso contrario, las condiciones financieras se consolidan solo en una fila
                if(self.mainRowsBodyTable.length>1 && self.mainRowsBodyTable[0].bodyTable[0].select=='1'){
                    //Consolidar todas las CF en una fila
                    self.showTableRows=0;
                    self.bodyTableModified=self.mainRowsBodyTable[0].bodyTable;
                    self.valoresCatalogoModified={};
                    var listaValoresCampoSelectBase={};

                    self.listaValoresRangoInferior={};
                    //Armando la lista para mostrar las opciones disponibles en el campo select, ejemplo: Tipo Activo
                    for (let index = 0; index < self.mainRowsBodyTable.length; index++) {
                        //Se obtiene la lista con los valores del catálogo para poder extraer tanto el id como el valor
                        for (let i = 0; i < self.mainRowsBodyTable[index].bodyTable.length; i++) {
                            if(self.mainRowsBodyTable[index].bodyTable[i].select=="1"){
                                var campoSelect=self.mainRowsBodyTable[index].bodyTable[i];
                                var listaValoresCampoSelectBase=self.mainRowsBodyTable[index].bodyTable[i].valoresCatalogo;

                                //Antes de agregar a la lista de valores que se mostrará, se comprueba que la clave aún no exista
                                if (!self.valoresCatalogoModified.hasOwnProperty(campoSelect.valorSelected)) {
                                    self.valoresCatalogoModified[campoSelect.valorSelected]=listaValoresCampoSelectBase[campoSelect.valorSelected];
                                }


                                self.bodyTableModified[i].valoresCatalogoModified=self.valoresCatalogoModified;

                            }

                            if(self.mainRowsBodyTable[index].bodyTable[i].text=="1" && self.mainRowsBodyTable[index].bodyTable[i].rangoInferior!=""){
                                var listaValoresRangoInferior={};
                                var nombreColumna=self.mainRowsBodyTable[index].bodyTable[i].nombreColumna;

                                //Se recorre nuevamente el objeto completo para obtener los valores diferentes por cada rango inferior con el mismo nombreColumma
                                for (let x = 0; x < self.mainRowsBodyTable.length; x++) {

                                    for (let y = 0; y < self.mainRowsBodyTable[x].bodyTable.length; y++) {
                                        if(self.mainRowsBodyTable[x].bodyTable[y].text=="1" && self.mainRowsBodyTable[x].bodyTable[y].rangoInferior!="" && self.mainRowsBodyTable[x].bodyTable[y].nombreColumna==nombreColumna){
                                            if (!listaValoresRangoInferior.hasOwnProperty(self.mainRowsBodyTable[x].bodyTable[y].rangoInferior)) {
                                                listaValoresRangoInferior[self.mainRowsBodyTable[x].bodyTable[y].rangoInferior]=self.mainRowsBodyTable[x].bodyTable[y].rangoInferior;
                                            }

                                        }
                                    }
                                }

                                //Se establece nuevo atributo para deshabilitar todos los campos de rango inferior excepto el primero dentro de la fila

                                self.bodyTableModified[i].deshabilitado='disabled';

                                self.bodyTableModified[i].valoresRangoInferior=listaValoresRangoInferior;
                            }

                            //Llenando lista con valores de rango superior
                            if(self.mainRowsBodyTable[index].bodyTable[i].text=="1" && self.mainRowsBodyTable[index].bodyTable[i].rangoSuperior!=""){

                                var listaValoresRangoSuperior={};
                                var nombreColumna=self.mainRowsBodyTable[index].bodyTable[i].nombreColumna;

                                //Se recorre nuevamente el objeto completo para obtener los valores diferentes por cada rango inferior con el mismo nombreColumma
                                for (let x = 0; x < self.mainRowsBodyTable.length; x++) {

                                    for (let y = 0; y < self.mainRowsBodyTable[x].bodyTable.length; y++) {
                                        if(self.mainRowsBodyTable[x].bodyTable[y].text=="1" && self.mainRowsBodyTable[x].bodyTable[y].rangoSuperior!="" && self.mainRowsBodyTable[x].bodyTable[y].nombreColumna==nombreColumna){
                                            if (!listaValoresRangoSuperior.hasOwnProperty(self.mainRowsBodyTable[x].bodyTable[y].rangoSuperior)) {
                                                listaValoresRangoSuperior[self.mainRowsBodyTable[x].bodyTable[y].rangoSuperior]=self.mainRowsBodyTable[x].bodyTable[y].rangoSuperior;
                                            }

                                        }
                                    }
                                }

                                self.bodyTableModified[i].deshabilitado='disabled';

                                self.bodyTableModified[i].valoresRangoSuperior=listaValoresRangoSuperior;
                            }

                        }
                    }

                    //Se habilita primer rango superior y deshabilitando los restantes
                    self.bodyTableModified[2].deshabilitado='';

                    var jsonFormatToValuesDefault={};

                    for (var indice = 0; indice < self.mainRowsBodyTable.length; indice++) {
                        var columnaBaseTipo="";
                        var keyRangoInferior="";
                        for (var idx = 0; idx < self.mainRowsBodyTable[indice].bodyTable.length; idx++) {

                            //Armando nuevo json para establecer valores default al aplicar evento change en campos

                            if(self.mainRowsBodyTable[indice].bodyTable[idx].select=="1"){
                                if(columnaBaseTipo==""){
                                    var idValorSeleccionado=self.mainRowsBodyTable[indice].bodyTable[idx].valorSelected;
                                    columnaBaseTipo=self.mainRowsBodyTable[indice].bodyTable[idx].valoresCatalogo[idValorSeleccionado];
                                }

                                if(!jsonFormatToValuesDefault.hasOwnProperty(columnaBaseTipo)){
                                    jsonFormatToValuesDefault[columnaBaseTipo]={}
                                }

                            }
                            if(self.mainRowsBodyTable[indice].bodyTable[idx].text=="1" && self.mainRowsBodyTable[indice].bodyTable[idx].rangoInferior!=""){
                                if(keyRangoInferior==""){
                                    keyRangoInferior=self.mainRowsBodyTable[indice].bodyTable[idx].rangoInferior;
                                }
                                if(!jsonFormatToValuesDefault[columnaBaseTipo].hasOwnProperty(keyRangoInferior)){
                                    jsonFormatToValuesDefault[columnaBaseTipo][keyRangoInferior]={}
                                }else{
                                    jsonFormatToValuesDefault[columnaBaseTipo][keyRangoInferior][self.mainRowsBodyTable[indice].bodyTable[idx].nombreColumna + "_inferior"]={};
                                    jsonFormatToValuesDefault[columnaBaseTipo][keyRangoInferior][self.mainRowsBodyTable[indice].bodyTable[idx].nombreColumna + "_inferior"]=self.mainRowsBodyTable[indice].bodyTable[idx].rangoInferior;
                                }

                                //jsonFormatToValuesDefault[self.mainRowsBodyTable[indice].bodyTable[idx].nombreColumna].rangoInferior=self.mainRowsBodyTable[indice].bodyTable[idx].rangoInferior;
                            }
                            if(self.mainRowsBodyTable[indice].bodyTable[idx].text=="1" && self.mainRowsBodyTable[indice].bodyTable[idx].rangoSuperior!=""){
                                jsonFormatToValuesDefault[columnaBaseTipo][keyRangoInferior][self.mainRowsBodyTable[indice].bodyTable[idx].nombreColumna + "_superior"]={};
                                jsonFormatToValuesDefault[columnaBaseTipo][keyRangoInferior][self.mainRowsBodyTable[indice].bodyTable[idx].nombreColumna + "_superior"]=self.mainRowsBodyTable[indice].bodyTable[idx].rangoSuperior;
                            }
                        }
                    }
                    //Se añade el json generado a una variable global para poder leerla a través de todo el código
                    self.jsonToValuesDefault=jsonFormatToValuesDefault;

                }else{
                    self.showTableRows=1;
                }
                //self.render();
            }
            if (this.model.get('cf_quantico_politica_c') != "") {
                this.setinfoCFConfiguradas();
            }

            self.render();
        }
    },

    indexOfMax:function(arr) {
        if (arr.length === 0) {
            return -1;
        }

        var max = arr[0];
        var maxIndex = 0;

        for (var i = 1; i < arr.length; i++) {
            if (arr[i] > max) {
                maxIndex = i;
                max = arr[i];
            }
        }

        return maxIndex;
    },

    setinfoCFConfiguradas:function(){

        if (this.model.get('cf_quantico_c') != "") {
            this.mainRowsConfigBodyTable = [];
            self = this;
             //Cuando se tiene lleno el campo cf_quantico_c, se formatea el el diseño con el contenido para mostrar la tabla llena par CF configuradas
            var data = JSON.parse(this.model.get('cf_quantico_c'));
            //Como se asume que ya se ha llenado previamente el campo de cf politicas y éste trae consigo la definición
            //de listas de valores, se establecen exactmanente los mismos pero ahora para la sección de CF configuradas
            var dataPolitica = JSON.parse(this.model.get('cf_quantico_politica_c'));
            data['listaValores']=dataPolitica.listaValores;

            if (data.FinancialTermGroupResponseList.length > 0) {
                //Llenado del cuerpo de la tabla
                for (var index = 0; index < data.FinancialTermGroupResponseList.length; index++) {
                    var arrayRespuesta = data.FinancialTermGroupResponseList[index];
                    var objRow = {};
                    /*
                        id 1: Booleano - Check
                        id 2: Numérico - Text
                        id 3: Texto - Text
                        id 4: Rango entero - 2 Text
                        id 5: Rango moneda - 2 Text
                        id 6: Moneda - Text
                        id 7: Catálogo - Select
                        id 8: Porcentaje - Text
                        id 9: Rango porcentaje - 2 Text
                        id 10: Decimal - Text
                        id 11: Rango Decimal - 2 Text
                    */
                    self.bodyTable = [];
                    for (var i = 0; i < arrayRespuesta.FinancialTermResponseList.length; i++) {
                        if (arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '4' ||
                            arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '5' ||
                            arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '9' ||
                            arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '11'
                        ) {
                            var rangoInferior = arrayRespuesta.FinancialTermResponseList[i].Value.ValueMin;
                            var rangoSuperior = arrayRespuesta.FinancialTermResponseList[i].Value.ValueMax;

                            var limiteInferior="";
                            var limiteSuperior="";
                            if(arrayRespuesta.FinancialTermResponseList[i].Configuration != undefined){
                                limiteSuperior=arrayRespuesta.FinancialTermResponseList[i].Configuration.UpperLimit;

                                if(arrayRespuesta.FinancialTermResponseList[i].Configuration.LowerLimit != undefined){
                                    limiteInferior=arrayRespuesta.FinancialTermResponseList[i].Configuration.LowerLimit;
                                }
                            }

                            self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'rangoInferior': rangoInferior, 'rangoSuperior': "" ,"limiteInferior":limiteInferior,"limiteSuperior":limiteSuperior});
                            self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'rangoInferior': "", 'rangoSuperior': rangoSuperior,"limiteInferior":limiteInferior,"limiteSuperior":limiteSuperior });
                        } else if (arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '7') {//Catálogo
                            //Obteniendo los valores de la lista
                            var nombre_lista = arrayRespuesta.FinancialTermResponseList[i].Name;
                            nombre_lista=nombre_lista.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                            //Obteniendo el mapeo desde la lista
                            var lista_valores = App.lang.getAppListStrings('mapeo_nombre_attr_cf_quantico_list')[nombre_lista];
                            var valores_select = data['listaValores'][lista_valores];
                            var valores_select_obj = {};

                            //Se añade condición para mostrar las mismas opciones que las CF de Política y no mostrar todas las opciones de la lista
                            //Esto solo se reaiza cuando se detecta que las CF de Politica, se consolidan en una sola
                            if(this.mainRowsBodyTable.length>1 && this.model.get('tipo_producto_c')!='4'){
                                //Dado que es la misma lista para cada CF configurada, se puede obtener siempre el primer item, es por eso que se pasa el "0" de manera fija
                                valores_select=valores_select=this.mainRowsBodyTable[0].bodyTable[0].valoresCatalogoModified;

                                for (const key in valores_select) {
                                    valores_select_obj[key] = valores_select[key];
                                }

                            }else{
                                //Convirtiendo el arreglo a objeto para poderlo mostrar en las opciones del campo select
                                for (var j = 0; j < valores_select.length; j++) {
                                    valores_select_obj[valores_select[j].Id] = valores_select[j].Name;
                                }
                            }
                            var valorSelected = arrayRespuesta.FinancialTermResponseList[i].Value.ValueId;

                            self.bodyTable.push({ 'select': '1', 'text': '', 'checkbox': '','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'valoresCatalogo': valores_select_obj, 'valorSelected': valorSelected });
                        } else if (arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '1') {//Check
                            var strChecked = "";
                            var valorBoolean = arrayRespuesta.FinancialTermResponseList[i].Value.Value;
                            if (valorBoolean == "True") {
                                strChecked = 'checked'
                            }
                            self.bodyTable.push({ 'select': '', 'text': '', 'checkbox': '1','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, "checked": strChecked });
                        } else {// Solo 1 Text
                            self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name,"valorCampo": arrayRespuesta.FinancialTermResponseList[i].Value.Value });
                        }
                    }
                    self.mainRowsConfigBodyTable.push({ 'bodyTable': self.bodyTable });

                }

            }

        }

    },

    addNewCFConfigurada: function (e) {

        var indiceFilaClickada = $(e.currentTarget).parent().parent().index();
        var filaPoliticaObtenida="";
        var plantillaFila=null;
        if(self.mainRowsBodyTable!=undefined){
            filaPoliticaObtenida = self.mainRowsBodyTable[indiceFilaClickada];
            //Se genera deepCopy ya que si se modifica sobre un objeto "igualado" (plantillaFila=self.mainRowsBodyTable[0])
            //todas las propiedades modificadas de plantillaFila afectan a todos los elementos del arreglo al que se genera push
            //Creando el deepCopy, se está editando un objeto independiente y por lo tanto ya no afecta a los otros elementos del arreglo
            plantillaFila=App.utils.deepCopy(filaPoliticaObtenida);

        }else{
            filaPoliticaObtenida=this.mainRowsBodyTable[indiceFilaClickada];
            plantillaFila=App.utils.deepCopy(filaPoliticaObtenida);
        }

        //Se aplica condición para cuando se detecte el producto factoraje, se aplique la funcionalidad anterior, es decir, que no se consolide todo sobre una fila y si muestre todas las condiciones disponibles
        if((self.mainRowsBodyTable!=undefined && self.mainRowsBodyTable.length>1 && this.model.get('tipo_producto_c')!='4') || (this.mainRowsBodyTable!=undefined && this.mainRowsBodyTable.length>1 && this.model.get('tipo_producto_c')!='4')){
            for (let index = 0; index < plantillaFila.bodyTable.length; index++) {
                if(plantillaFila.bodyTable[index].select=="1"){
                    var valorSelect=$(e.currentTarget).parent().parent().find('select.row-fluid')[index].value;
                    plantillaFila.bodyTable[index].valorSelected=$(e.currentTarget).parent().parent().find('select.row-fluid')[index].value;
                    plantillaFila.bodyTable[index].valoresCatalogo=plantillaFila.bodyTable[index].valoresCatalogoModified;
                }

                if(plantillaFila.bodyTable[index].text=="1"){

                    if(plantillaFila.bodyTable[index].rangoInferior!=""){
                        if($(e.currentTarget).parent().parent().find('select.row-fluid').length>0){
                            plantillaFila.bodyTable[index].rangoInferior=$(e.currentTarget).parent().parent().find('select.row-fluid')[index].value;
                        }else{
                            plantillaFila.bodyTable[index].rangoInferior=$(e.currentTarget).parent().parent().find('input[type="text"]')[index].value;
                        }
                    }

                    if(plantillaFila.bodyTable[index].rangoSuperior!=""){
                        if($(e.currentTarget).parent().parent().find('select.row-fluid').length>0){
                            plantillaFila.bodyTable[index].rangoSuperior=$(e.currentTarget).parent().parent().find('select.row-fluid')[index].value;
                        }else{
                            plantillaFila.bodyTable[index].rangoInferior=$(e.currentTarget).parent().parent().find('input[type="text"]')[index].value;
                        }

                    }
                }

                if(plantillaFila.bodyTable[index].checkbox=="1"){
                    plantillaFila.bodyTable[index].checked=$(e.currentTarget).parent().parent().find('input[type="checkbox"]')[index].is(":checked");
                }

            }

        }


        //Condición para controlar funcionamiento anterior, en caso de que mainRowsBodyTable traiga más de una fila, quiere decir que
        //todas las filas se consolidaron en una sola, por lo tanto, el item a dibujar en las CF configuradas se toma a partir de plantillaFila y no de filaPoliticaObtenida
        if(self.mainRowsBodyTable!=undefined){
            if(self.mainRowsBodyTable.length>1 && this.model.get('tipo_producto_c')!='4'){
                this.mainRowsConfigBodyTable.push(plantillaFila);
            }else{
                this.mainRowsConfigBodyTable.push(filaPoliticaObtenida);
            }
        }else{
            if(this.mainRowsBodyTable.length>1 && this.model.get('tipo_producto_c')!='4'){
                this.mainRowsConfigBodyTable.push(plantillaFila);
            }else{
                this.mainRowsConfigBodyTable.push(filaPoliticaObtenida);
            }
        }

        if(this.model.get('cf_quantico_c')!=""){
            this.jsonCFConfiguradas=JSON.parse(this.model.get('cf_quantico_c'));
        }else{
            //Comienza a formarse estructura json de condiciones financieras configuradas
            this.jsonCFConfiguradas.RequestId=this.model.get('idsolicitud_c');
            this.jsonCFConfiguradas.OpportunitiesId=this.model.get('id');
        }

        //Obteniendo el campo html para conocer el tipo de campo que se envía al json
        var camposEnfila=$(e.currentTarget).parent().parent().find('td');
        var objetoTermResponseList=[];

        /* Condición para seguir controlando el ajuste para filas consolidades en una sola para cuando las CF politica vienen con más de 1 valor*/
        if(self.mainRowsBodyTable!=undefined){
            if(self.mainRowsBodyTable.length>1 && this.model.get('tipo_producto_c')!='4'){
                //Validando que el primer elemento sea un select
                if(self.mainRowsBodyTable[0].bodyTable[0].select=='1'){
                    for (let index = 0; index < camposEnfila.length; index++) {
                        var elemento = $(camposEnfila).eq(index);
                        //Comprobar si el campo es select, por lo tanto se agrega json con definición de Catálogo
                        if(elemento.children('select').length>0 && elemento.children('input[type="hidden"]').length==0){
                             //Definición para campos de catálogo
                            var objetoSelect=this.setPlantillasJSON("Catalogo");
                            objetoSelect.Name=$(camposEnfila).eq(index).children('select').attr('data-columna');
                            objetoSelect.Id=$(camposEnfila).eq(index).children('select').attr('data-id-nodo');
                            objetoSelect.Value.Value=$(camposEnfila).eq(index).children('select').children('option:selected').html();
                            objetoSelect.Value.ValueId=$(camposEnfila).eq(index).children('select').eq(0).children(':selected').val();

                            objetoTermResponseList.push(objetoSelect);

                        }else if(elemento.children('input[type="hidden"]').length>0 && elemento.children('input[type="hidden"]').attr('data-info')=='inferior'){
                            //Definición para campos de rango
                            var objetoRango=this.setPlantillasJSON(elemento.children('input[type="hidden"]').attr('data-name'));
                            objetoRango.Name=elemento.children('input[type="hidden"]').attr('data-columna');
                            objetoRango.Id=elemento.children('input[type="hidden"]').attr('data-id-nodo');
                            objetoRango.Value.ValueMin=elemento.children('input[type="hidden"]').val();
                            //Para el value max, se toma el siguiente campo en <td>, por lo tanto se aumenta el index
                            objetoRango.Value.ValueMax=$(camposEnfila).eq(index+1).children('input[type="hidden"]').val();
                            index=index+1;
                            objetoTermResponseList.push(objetoRango);

                        }else if(elemento.children('input[type="checkbox"]').length>0){
                             //Definición para campos Boolean
                            var objetoCheckBox=this.setPlantillasJSON(elemento.children('input[type="checkbox"]').attr('data-name'));
                            var valorCheck=elemento.children('input[type="checkbox"]').eq(0).attr('checked');
                            var valorJsonChk="";
                            if(valorCheck=="checked"){
                                valorJsonChk="True";
                            }else{
                                valorJsonChk="False";
                            }

                            objetoCheckBox.Name=elemento.children('input[type="checkbox"]').attr('data-columna');
                            objetoCheckBox.Id=elemento.children('input[type="checkbox"]').attr('data-id-nodo');
                            objetoCheckBox.Value.Value=valorJsonChk;
                            objetoTermResponseList.push(objetoCheckBox);
                        }else if(elemento.children('input[type="hidden"]').length>0 && elemento.children('input[type="hidden"]').attr('data-info')=='input'){
                            //Definición para campos númerico
                            var objetoNumerico=this.setPlantillasJSON(elemento.children('input[type="hidden"]').attr('data-name'));
                            objetoNumerico.Name=elemento.children('input[type="hidden"]').attr('data-columna');
                            objetoNumerico.Id=elemento.children('input[type="hidden"]').attr('data-id-nodo');
                            objetoNumerico.Value.Value=elemento.children('input[type="hidden"]').val();

                            objetoTermResponseList.push(objetoNumerico);

                        }

                    }

                }else{
                        for (let index = 0; index < camposEnfila.length; index++) {
                            var elemento = $(camposEnfila).eq(index);
                            //Comprobar si el campo es select, por lo tanto se agrega json con definición de Catálogo
                            if(elemento.children('select').length>0){
                                 //Definición para campos de catálogo
                                var objetoSelect=this.setPlantillasJSON("Catalogo");
                                objetoSelect.Name=$(camposEnfila).eq(index).children('select').attr('data-columna');
                                objetoSelect.Id=$(camposEnfila).eq(index).children('select').attr('data-id-nodo');
                                objetoSelect.Value.Value=$(camposEnfila).eq(index).children('select').children('option:selected').html();
                                objetoSelect.Value.ValueId=$(camposEnfila).eq(index).children('select').eq(0).children(':selected').val();

                                objetoTermResponseList.push(objetoSelect);

                            }else if(elemento.children('input[type="text"]').length>0 && elemento.children('input[type="text"]').attr('data-info')=='inferior'){
                                //Definición para campos de rango
                                var objetoRango=this.setPlantillasJSON(elemento.children('input[type="text"]').attr('data-name'));
                                objetoRango.Name=elemento.children('input[type="text"]').attr('data-columna');
                                objetoRango.Id=elemento.children('input[type="text"]').attr('data-id-nodo');
                                objetoRango.Value.ValueMin=elemento.children('input[type="text"]').val();
                                //Para el value max, se toma el siguiente campo en <td>, por lo tanto se aumenta el indec
                                objetoRango.Value.ValueMax=$(camposEnfila).eq(index+1).children('input[type="text"]').val();
                                index=index+1;
                                objetoTermResponseList.push(objetoRango);

                            }else if(elemento.children('input[type="checkbox"]').length>0){
                                 //Definición para campos Boolean
                                var objetoCheckBox=this.setPlantillasJSON(elemento.children('input[type="checkbox"]').attr('data-name'));
                                var valorCheck=elemento.children('input[type="checkbox"]').eq(0).attr('checked');
                                var valorJsonChk="";
                                if(valorCheck=="checked"){
                                    valorJsonChk="True";
                                }else{
                                    valorJsonChk="False";
                                }

                                objetoCheckBox.Name=elemento.children('input[type="checkbox"]').attr('data-columna');
                                objetoCheckBox.Id=elemento.children('input[type="checkbox"]').attr('data-id-nodo');
                                objetoCheckBox.Value.Value=valorJsonChk;
                                objetoTermResponseList.push(objetoCheckBox);
                            }else if(elemento.children('input[type="text"]').length>0 && elemento.children('input[type="text"]').attr('data-info')=='input'){
                                //Definición para campos númerico
                                var objetoNumerico=this.setPlantillasJSON(elemento.children('input[type="text"]').attr('data-name'));
                                objetoNumerico.Name=elemento.children('input[type="text"]').attr('data-columna');
                                objetoNumerico.Id=elemento.children('input[type="text"]').attr('data-id-nodo');
                                objetoNumerico.Value.Value=elemento.children('input[type="text"]').val();

                                objetoTermResponseList.push(objetoNumerico);

                            }

                    }
                }

            }else{

                for (let index = 0; index < camposEnfila.length; index++) {
                    var elemento = $(camposEnfila).eq(index);
                    //Comprobar si el campo es select, por lo tanto se agrega json con definición de Catálogo
                    if(elemento.children('select').length>0){
                         //Definición para campos de catálogo
                        var objetoSelect=this.setPlantillasJSON("Catalogo");
                        objetoSelect.Name=$(camposEnfila).eq(index).children('select').attr('data-columna');
                        objetoSelect.Id=$(camposEnfila).eq(index).children('select').attr('data-id-nodo');
                        objetoSelect.Value.Value=$(camposEnfila).eq(index).children('select').children('option:selected').html();
                        objetoSelect.Value.ValueId=$(camposEnfila).eq(index).children('select').eq(0).children(':selected').val();

                        objetoTermResponseList.push(objetoSelect);

                    }else if(elemento.children('input[type="text"]').length>0 && elemento.children('input[type="text"]').attr('data-info')=='inferior'){
                        //Definición para campos de rango
                        var objetoRango=this.setPlantillasJSON(elemento.children('input[type="text"]').attr('data-name'));
                        objetoRango.Name=elemento.children('input[type="text"]').attr('data-columna');
                        objetoRango.Id=elemento.children('input[type="text"]').attr('data-id-nodo');
                        objetoRango.Value.ValueMin=elemento.children('input[type="text"]').val();
                        //Para el value max, se toma el siguiente campo en <td>, por lo tanto se aumenta el indec
                        objetoRango.Value.ValueMax=$(camposEnfila).eq(index+1).children('input[type="text"]').val();
                        index=index+1;
                        objetoTermResponseList.push(objetoRango);

                    }else if(elemento.children('input[type="checkbox"]').length>0){
                         //Definición para campos Boolean
                        var objetoCheckBox=this.setPlantillasJSON(elemento.children('input[type="checkbox"]').attr('data-name'));
                        var valorCheck=elemento.children('input[type="checkbox"]').eq(0).attr('checked');
                        var valorJsonChk="";
                        if(valorCheck=="checked"){
                            valorJsonChk="True";
                        }else{
                            valorJsonChk="False";
                        }

                        objetoCheckBox.Name=elemento.children('input[type="checkbox"]').attr('data-columna');
                        objetoCheckBox.Id=elemento.children('input[type="checkbox"]').attr('data-id-nodo');
                        objetoCheckBox.Value.Value=valorJsonChk;
                        objetoTermResponseList.push(objetoCheckBox);
                    }else if(elemento.children('input[type="text"]').length>0 && elemento.children('input[type="text"]').attr('data-info')=='input'){
                        //Definición para campos númerico
                        var objetoNumerico=this.setPlantillasJSON(elemento.children('input[type="text"]').attr('data-name'));
                        objetoNumerico.Name=elemento.children('input[type="text"]').attr('data-columna');
                        objetoNumerico.Id=elemento.children('input[type="text"]').attr('data-id-nodo');
                        objetoNumerico.Value.Value=elemento.children('input[type="text"]').val();

                        objetoTermResponseList.push(objetoNumerico);

                    }

                }
            }
        }else{
            if(this.mainRowsBodyTable.length>1 && this.model.get('tipo_producto_c')!='4'){
                if(this.mainRowsBodyTable[0].bodyTable[0].select=='1'){
                    for (let index = 0; index < camposEnfila.length; index++) {
                        var elemento = $(camposEnfila).eq(index);
                        //Comprobar si el campo es select, por lo tanto se agrega json con definición de Catálogo
                        if(elemento.children('select').length>0 && elemento.children('input[type="hidden"]').length==0){
                             //Definición para campos de catálogo
                            var objetoSelect=this.setPlantillasJSON("Catalogo");
                            objetoSelect.Name=$(camposEnfila).eq(index).children('select').attr('data-columna');
                            objetoSelect.Id=$(camposEnfila).eq(index).children('select').attr('data-id-nodo');
                            objetoSelect.Value.Value=$(camposEnfila).eq(index).children('select').children('option:selected').html();
                            objetoSelect.Value.ValueId=$(camposEnfila).eq(index).children('select').eq(0).children(':selected').val();

                            objetoTermResponseList.push(objetoSelect);

                        }else if(elemento.children('input[type="hidden"]').length>0 && elemento.children('input[type="hidden"]').attr('data-info')=='inferior'){
                            //Definición para campos de rango
                            var objetoRango=this.setPlantillasJSON(elemento.children('input[type="hidden"]').attr('data-name'));
                            objetoRango.Name=elemento.children('input[type="hidden"]').attr('data-columna');
                            objetoRango.Id=elemento.children('input[type="hidden"]').attr('data-id-nodo');
                            objetoRango.Value.ValueMin=elemento.children('input[type="hidden"]').val();
                            //Para el value max, se toma el siguiente campo en <td>, por lo tanto se aumenta el index
                            objetoRango.Value.ValueMax=$(camposEnfila).eq(index+1).children('input[type="hidden"]').val();
                            index=index+1;
                            objetoTermResponseList.push(objetoRango);

                        }else if(elemento.children('input[type="checkbox"]').length>0){
                             //Definición para campos Boolean
                            var objetoCheckBox=this.setPlantillasJSON(elemento.children('input[type="checkbox"]').attr('data-name'));
                            var valorCheck=elemento.children('input[type="checkbox"]').eq(0).attr('checked');
                            var valorJsonChk="";
                            if(valorCheck=="checked"){
                                valorJsonChk="True";
                            }else{
                                valorJsonChk="False";
                            }

                            objetoCheckBox.Name=elemento.children('input[type="checkbox"]').attr('data-columna');
                            objetoCheckBox.Id=elemento.children('input[type="checkbox"]').attr('data-id-nodo');
                            objetoCheckBox.Value.Value=valorJsonChk;
                            objetoTermResponseList.push(objetoCheckBox);
                        }else if(elemento.children('input[type="hidden"]').length>0 && elemento.children('input[type="hidden"]').attr('data-info')=='input'){
                            //Definición para campos númerico
                            var objetoNumerico=this.setPlantillasJSON(elemento.children('input[type="hidden"]').attr('data-name'));
                            objetoNumerico.Name=elemento.children('input[type="hidden"]').attr('data-columna');
                            objetoNumerico.Id=elemento.children('input[type="hidden"]').attr('data-id-nodo');
                            objetoNumerico.Value.Value=elemento.children('input[type="hidden"]').val();

                            objetoTermResponseList.push(objetoNumerico);

                        }

                    }

                }else{

                    for (let index = 0; index < camposEnfila.length; index++) {
                        var elemento = $(camposEnfila).eq(index);
                        //Comprobar si el campo es select, por lo tanto se agrega json con definición de Catálogo
                        if(elemento.children('select').length>0){
                             //Definición para campos de catálogo
                            var objetoSelect=this.setPlantillasJSON("Catalogo");
                            objetoSelect.Name=$(camposEnfila).eq(index).children('select').attr('data-columna');
                            objetoSelect.Id=$(camposEnfila).eq(index).children('select').attr('data-id-nodo');
                            objetoSelect.Value.Value=$(camposEnfila).eq(index).children('select').children('option:selected').html();
                            objetoSelect.Value.ValueId=$(camposEnfila).eq(index).children('select').eq(0).children(':selected').val();

                            objetoTermResponseList.push(objetoSelect);

                        }else if(elemento.children('input[type="text"]').length>0 && elemento.children('input[type="text"]').attr('data-info')=='inferior'){
                            //Definición para campos de rango
                            var objetoRango=this.setPlantillasJSON(elemento.children('input[type="text"]').attr('data-name'));
                            objetoRango.Name=elemento.children('input[type="text"]').attr('data-columna');
                            objetoRango.Id=elemento.children('input[type="text"]').attr('data-id-nodo');
                            objetoRango.Value.ValueMin=elemento.children('input[type="text"]').val();
                            //Para el value max, se toma el siguiente campo en <td>, por lo tanto se aumenta el indec
                            objetoRango.Value.ValueMax=$(camposEnfila).eq(index+1).children('input[type="text"]').val();
                            index=index+1;
                            objetoTermResponseList.push(objetoRango);

                        }else if(elemento.children('input[type="checkbox"]').length>0){
                             //Definición para campos Boolean
                            var objetoCheckBox=this.setPlantillasJSON(elemento.children('input[type="checkbox"]').attr('data-name'));
                            var valorCheck=elemento.children('input[type="checkbox"]').eq(0).attr('checked');
                            var valorJsonChk="";
                            if(valorCheck=="checked"){
                                valorJsonChk="True";
                            }else{
                                valorJsonChk="False";
                            }

                            objetoCheckBox.Name=elemento.children('input[type="checkbox"]').attr('data-columna');
                            objetoCheckBox.Id=elemento.children('input[type="checkbox"]').attr('data-id-nodo');
                            objetoCheckBox.Value.Value=valorJsonChk;
                            objetoTermResponseList.push(objetoCheckBox);
                        }else if(elemento.children('input[type="text"]').length>0 && elemento.children('input[type="text"]').attr('data-info')=='input'){
                            //Definición para campos númerico
                            var objetoNumerico=this.setPlantillasJSON(elemento.children('input[type="text"]').attr('data-name'));
                            objetoNumerico.Name=elemento.children('input[type="text"]').attr('data-columna');
                            objetoNumerico.Id=elemento.children('input[type="text"]').attr('data-id-nodo');
                            objetoNumerico.Value.Value=elemento.children('input[type="text"]').val();

                            objetoTermResponseList.push(objetoNumerico);

                        }

                    }

                }//fin else

            }else{
                for (let index = 0; index < camposEnfila.length; index++) {
                    var elemento = $(camposEnfila).eq(index);
                    //Comprobar si el campo es select, por lo tanto se agrega json con definición de Catálogo
                    if(elemento.children('select').length>0){
                         //Definición para campos de catálogo
                        var objetoSelect=this.setPlantillasJSON("Catalogo");
                        objetoSelect.Name=$(camposEnfila).eq(index).children('select').attr('data-columna');
                        objetoSelect.Id=$(camposEnfila).eq(index).children('select').attr('data-id-nodo');
                        objetoSelect.Value.Value=$(camposEnfila).eq(index).children('select').children('option:selected').html();
                        objetoSelect.Value.ValueId=$(camposEnfila).eq(index).children('select').eq(0).children(':selected').val();

                        objetoTermResponseList.push(objetoSelect);

                    }else if(elemento.children('input[type="text"]').length>0 && elemento.children('input[type="text"]').attr('data-info')=='inferior'){
                        //Definición para campos de rango
                        var objetoRango=this.setPlantillasJSON(elemento.children('input[type="text"]').attr('data-name'));
                        objetoRango.Name=elemento.children('input[type="text"]').attr('data-columna');
                        objetoRango.Id=elemento.children('input[type="text"]').attr('data-id-nodo');
                        objetoRango.Value.ValueMin=elemento.children('input[type="text"]').val();
                        //Para el value max, se toma el siguiente campo en <td>, por lo tanto se aumenta el indec
                        objetoRango.Value.ValueMax=$(camposEnfila).eq(index+1).children('input[type="text"]').val();
                        index=index+1;
                        objetoTermResponseList.push(objetoRango);

                    }else if(elemento.children('input[type="checkbox"]').length>0){
                         //Definición para campos Boolean
                        var objetoCheckBox=this.setPlantillasJSON(elemento.children('input[type="checkbox"]').attr('data-name'));
                        var valorCheck=elemento.children('input[type="checkbox"]').eq(0).attr('checked');
                        var valorJsonChk="";
                        if(valorCheck=="checked"){
                            valorJsonChk="True";
                        }else{
                            valorJsonChk="False";
                        }

                        objetoCheckBox.Name=elemento.children('input[type="checkbox"]').attr('data-columna');
                        objetoCheckBox.Id=elemento.children('input[type="checkbox"]').attr('data-id-nodo');
                        objetoCheckBox.Value.Value=valorJsonChk;
                        objetoTermResponseList.push(objetoCheckBox);
                    }else if(elemento.children('input[type="text"]').length>0 && elemento.children('input[type="text"]').attr('data-info')=='input'){
                        //Definición para campos númerico
                        var objetoNumerico=this.setPlantillasJSON(elemento.children('input[type="text"]').attr('data-name'));
                        objetoNumerico.Name=elemento.children('input[type="text"]').attr('data-columna');
                        objetoNumerico.Id=elemento.children('input[type="text"]').attr('data-id-nodo');
                        objetoNumerico.Value.Value=elemento.children('input[type="text"]').val();

                        objetoTermResponseList.push(objetoNumerico);

                    }

                }
            }
        }
        /** Termina sección con control de condiciones para setear objeto que se envía a Quantico */

        this.jsonCFConfiguradas.FinancialTermGroupResponseList.push({"Id":"67","FinancialTermResponseList":objetoTermResponseList})
        var jsonStringConfiguradas=JSON.stringify(this.jsonCFConfiguradas);
        this.model.set("cf_quantico_c",jsonStringConfiguradas);

        this.render();

    },

    deleteCFConfigurada: function (e) {
        var indiceBorrar = $(e.currentTarget).parent().parent().index();
        this.mainRowsConfigBodyTable.splice(indiceBorrar, 1);
        if(this.jsonCFConfiguradas.FinancialTermGroupResponseList.length==0){
            if(this.model.get("cf_quantico_c")!=""){
                this.jsonCFConfiguradas=JSON.parse(this.model.get("cf_quantico_c"))
            }

        }
        this.jsonCFConfiguradas.FinancialTermGroupResponseList.splice(indiceBorrar,1);
        var jsonStringConfiguradas=JSON.stringify(this.jsonCFConfiguradas);
        this.model.set("cf_quantico_c",jsonStringConfiguradas);

        this.render();
    },

    updateJsonCFConfiguradas:function(e){
        var valor=$(e.currentTarget).val();
        var esLimiteMayoroMenor=$(e.currentTarget).attr('data-tipo-campo');
        if(esLimiteMayoroMenor=="inputSuperior"){
            var indextd=$(e.currentTarget).closest('td').index();
            //Validación para comparar el valor actual (valor máximo) vs el valor mínimo, para que el valor máximo no sea menor que el valor mínimo
            var indexColumna=$(e.currentTarget).parent().index();
            var valorMinimoIngresado=$(e.currentTarget).parent().siblings().eq(indexColumna-1).children().val();
            if(valorMinimoIngresado!=""){
                if(valor.length>=valorMinimoIngresado.length){//Aplicar validación solo si valor mínimo y valor máximo tienen el mismo número de dígitos
                    if(Number(valor) < Number(valorMinimoIngresado)){
                        app.alert.show("fueraRango", {
                            level: "error",
                            title: "El n\u00FAmero ingresado no puede ser menor al Valor Mínimo",
                            autoClose: true
                        });
                        $(e.currentTarget).val("");
                        return false;
                    }
                }
            }
        }
        var indexCampo = $(e.currentTarget).parent().parent().index();
        var valorBuscado=$(e.currentTarget).attr('data-columna');
        var inferiorOsuperior=$(e.currentTarget).attr('data-tipo-campo');
        if(self.jsonCFConfiguradas==undefined){
            self.jsonCFConfiguradas=this.jsonCFConfiguradas;
        }
        if(self.mainRowsConfigBodyTable == undefined || self.mainRowsConfigBodyTable.length != this.mainRowsConfigBodyTable.length){
            self.mainRowsConfigBodyTable=this.mainRowsConfigBodyTable;
        }
        if(self.jsonCFConfiguradas.FinancialTermGroupResponseList.length==0){
            self.jsonCFConfiguradas=JSON.parse(this.model.get('cf_quantico_c'));
        }
        var indiceEncontrado=this.searchIndexForUpdate(valorBuscado,self.jsonCFConfiguradas.FinancialTermGroupResponseList[indexCampo]);
        var indexForUpdateJsonToHbs=this.searchIndexForUpdateMainRowsConfigBodyTable(valorBuscado,self.mainRowsConfigBodyTable[indexCampo],inferiorOsuperior);

        //Se valida el tipo de campo para saber el valor sobre el que se debe de actualizar
        var tipoCampo=$(e.currentTarget).attr('data-tipo-campo');
        if(tipoCampo=="catalogo"){
            self.jsonCFConfiguradas.FinancialTermGroupResponseList[indexCampo].FinancialTermResponseList[indiceEncontrado].Value.Value=$(e.currentTarget).children('option:selected').html();
            self.jsonCFConfiguradas.FinancialTermGroupResponseList[indexCampo].FinancialTermResponseList[indiceEncontrado].Value.ValueId=$(e.currentTarget).children(':selected').val();

            //Se actualiza el objeto json que se dibuja en el hbs
            self.mainRowsConfigBodyTable[indexCampo].bodyTable[indexForUpdateJsonToHbs].valorSelected=$(e.currentTarget).children(':selected').val();
        }else if(tipoCampo=="inputInferior"){
            self.jsonCFConfiguradas.FinancialTermGroupResponseList[indexCampo].FinancialTermResponseList[indiceEncontrado].Value.ValueMin=$(e.currentTarget).val();

            //Se actualiza el objeto json que se dibuja en el hbs
            self.mainRowsConfigBodyTable[indexCampo].bodyTable[indexForUpdateJsonToHbs].rangoInferior=$(e.currentTarget).val();
            if($(e.currentTarget).val()==""){
                self.mainRowsConfigBodyTable[indexCampo].bodyTable[indexForUpdateJsonToHbs].actualizadoPorUsuarioPermiteVacio="true";
            }


        }else if(tipoCampo=="inputSuperior"){
            self.jsonCFConfiguradas.FinancialTermGroupResponseList[indexCampo].FinancialTermResponseList[indiceEncontrado].Value.ValueMax=$(e.currentTarget).val();

            //Se actualiza el objeto json que se dibuja en el hbs
            self.mainRowsConfigBodyTable[indexCampo].bodyTable[indexForUpdateJsonToHbs].rangoSuperior=$(e.currentTarget).val();

            if($(e.currentTarget).val()==""){
                self.mainRowsConfigBodyTable[indexCampo].bodyTable[indexForUpdateJsonToHbs].actualizadoPorUsuarioInputSuperior="true";
            }

        }else if(tipoCampo=="check"){
            var valorSet="";
            if($(e.currentTarget).is(":checked")){
                valorSet="True";

                //Se actualiza el objeto json que se dibuja en el hbs
                self.mainRowsConfigBodyTable[indexCampo].bodyTable[indexForUpdateJsonToHbs].checked="checked";

            }else{
                valorSet="False";

                //Se actualiza el objeto json que se dibuja en el hbs
                self.mainRowsConfigBodyTable[indexCampo].bodyTable[indexForUpdateJsonToHbs].checked="";
            }
            self.jsonCFConfiguradas.FinancialTermGroupResponseList[indexCampo].FinancialTermResponseList[indiceEncontrado].Value.Value=valorSet;


        }else if(tipoCampo=="input"){
            self.jsonCFConfiguradas.FinancialTermGroupResponseList[indexCampo].FinancialTermResponseList[indiceEncontrado].Value.Value=$(e.currentTarget).val();
             //Se actualiza el objeto json que se dibuja en el hbs
             self.mainRowsConfigBodyTable[indexCampo].bodyTable[indexForUpdateJsonToHbs].valorCampo=$(e.currentTarget).val();
        }

        var jsonStringConfiguradas=JSON.stringify(self.jsonCFConfiguradas);
        self.model.set("cf_quantico_c",jsonStringConfiguradas);

    },

    validarRangos:function(e){
        var valor=$(e.currentTarget).val();
        var limite_inferior=$(e.currentTarget).attr('data-limite-inferior');
        var limite_superior=$(e.currentTarget).attr('data-limite-superior');
        //No permitir valores negativos, solo permitir números
        if (!this.checkNumOnly(e)) {
            $(e.currentTarget).val("");
            return false;
        }

        //Evitar keyup para tecla TAB
        if(e.keyCode==9 || e.key=='Tab'){
            return false;
        }
        //Limite inferior no puede ser mayor al limite superior
        //Validar que ambos valores caigan dentro del rango
        if(limite_inferior==""){
            limite_inferior=0;
        }
        var esLimiteMayoroMenor=$(e.currentTarget).attr('data-tipo-campo');
        if(esLimiteMayoroMenor=="inputInferior"){
            var indextd=$(e.currentTarget).closest('td').index();
            var valorCampoSuperior=$(e.currentTarget).closest('td').siblings().eq(indextd).find('input').val();
            if(valorCampoSuperior!= "" && valor !=""){
                if(Number(valor) > Number(valorCampoSuperior)){
                    app.alert.show("fueraRango", {
                        level: "error",
                        title: "El n\u00FAmero ingresado no puede ser mayor al Valor Máximo",
                        autoClose: true
                    });
                    $(e.currentTarget).val("");
                    return false;
                }
            }

            if(limite_superior!="" && valor !=""){
                if(Number(valor) < Number(limite_inferior) || Number(valor) > Number(limite_superior) ){
                    app.alert.show("fueraRango", {
                        level: "error",
                        title: "El n\u00FAmero ingresado está fuera del rango permitido",
                        autoClose: true
                    });
                    $(e.currentTarget).val("");
                    return false;
                }
            }

        }

        if(esLimiteMayoroMenor=="inputSuperior"){
            var indextd=$(e.currentTarget).closest('td').index();
            var valorCampoSuperior=$(e.currentTarget).closest('td').siblings().eq(indextd).find('input').val()

            //Validación para rangos, no permitir introducir valores que no caen dentro de los rangos de política
            if(limite_superior!="" && valor!=""){
                if(Number(valor) < Number(limite_inferior) || Number(valor) > Number(limite_superior) ){
                    app.alert.show("fueraRango", {
                        level: "error",
                        title: "El n\u00FAmero ingresado está fuera del rango permitido",
                        autoClose: true
                    });
                    $(e.currentTarget).val("");
                    return false;

                }
            }

            //Validación para comparar el valor actual (valor máximo) vs el valor mínimo, para que el valor máximo no sea menor que el valor mínimo
            var indexColumna=$(e.currentTarget).parent().index();
            var valorMinimoIngresado=$(e.currentTarget).parent().siblings().eq(indexColumna-1).children().val();
            if(valorMinimoIngresado!=""){
                if(valor.length>valorMinimoIngresado.length){//Aplicar validación solo si valor mínimo y valor máximo tienen el mismo número de dígitos
                    if(Number(valor) < Number(valorMinimoIngresado)){
                        app.alert.show("fueraRango", {
                            level: "error",
                            title: "El n\u00FAmero ingresado no puede ser menor al Valor Mínimo",
                            autoClose: true
                        });
                        $(e.currentTarget).val("");
                        return false;
                    }
                }
            }
        }
    },

    setValToInputHidden:function(e){
        var valor=$(e.currentTarget).val();
        $(e.currentTarget).siblings('input[type="hidden"]').val(valor);

        //Manda a llamar función para establecer valores default
        this.setDefaultValues(e);
    },

    setDefaultValues:function(e){

        //Obteniendo json formateado para establecer valores default
        console.log(this.jsonToValuesDefault);
        //Se obtiene valor de la opción seleccionada para filtrar en el json que auxilia para establecer valores default
        var valor_seleccionado="";
        var valor_inferior="";
        var valor_superior="";
        var elemento_disparador="";
        //Si no se encuentra valor en el elemento previo (elemento de la izquierda), quiere decir que el evento viene disparado del select de Tipo Activo
        //En otro caso, se asume que el evento se disparó desde el campo del rango inferior
        /*
        if($(e.currentTarget).parent().prev().find('select').find('option:selected').text()==''){
            elemento_disparador="select";
            valor_seleccionado=$(e.currentTarget).find('option:selected').text();
            valor_inferior=$(e.currentTarget).parent().next().find('option:selected').text();
        }else{
            //Entra condición, se obtiene elemento desde el campo de rango inferior
            elemento_disparador="inferior";
            valor_seleccionado=$(e.currentTarget).parent().prev().find('select').find('option:selected').text();
            valor_inferior=$(e.currentTarget).find('option:selected').text();
        }
        */

       if($(e.currentTarget).parent().prev().find('select[data-info="inferior"]').length==0){
        elemento_disparador="select";
        valor_seleccionado=$(e.currentTarget).find('option:selected').text();
        valor_inferior=$(e.currentTarget).parent().next().find('option:selected').text();
        }else{
            //Entra condición, se obtiene elemento desde el campo de rango inferior
            elemento_disparador="superior";
            valor_seleccionado=$(e.currentTarget).parent().prev().prev().find('select').find('option:selected').text();

            valor_superior=$(e.currentTarget).val();
            var nombre_columna=$(e.currentTarget).attr('data-columna');
            var esSuperiorInferior=$(e.currentTarget).attr('data-info');
            var nombre_elemento=nombre_columna+"_"+esSuperiorInferior;

            //valor_inferior=$(e.currentTarget).parent().prev().find('option:selected').text();
            //Buscar dentro del objeto el item con base al rango_superior seleccionado
            for (const key in this.jsonToValuesDefault[valor_seleccionado]) {
                var elemento_iterado=this.jsonToValuesDefault[valor_seleccionado][key];
                for (const k in elemento_iterado) {
                    if (k==nombre_elemento && elemento_iterado[nombre_elemento]==valor_superior) {
                        valor_inferior=key;
                    }
                }
            }

        }

        var item_to_set=this.jsonToValuesDefault[valor_seleccionado][valor_inferior];

        //Si se dispara desde select de Tipo Activo $(e.currentTarget).parent().next().find('select').select2('val','13')
        //Obteniendo número de campos sobre los que se tiene que establecer valor
        var numero_elementos=$(e.currentTarget).parent().siblings('td').length;

        //Si el campo que dispara el evento es el campo del rango inferior, no se toma en cuenta el primer sibling (Tipo Activo)
        if(elemento_disparador=='superior'){
            for (var index = 1; index < numero_elementos; index++) {
                if(index==1){
                    $(e.currentTarget).parent().siblings('td').eq(index).children().eq(0).val(valor_inferior);
                    $(e.currentTarget).parent().siblings('td').eq(index).children().eq(1).select2('val',valor_inferior);

                }else{
                    //Se obtiene el nombre de la columna
                    var nombre_columna=$(e.currentTarget).parent().siblings('td').eq(index).children().eq(0).attr('data-columna');
                    //Se obtiene el campo para saber si el elemento pertenece a un rango inferior o superior
                    var inferiorSuperior=$(e.currentTarget).parent().siblings('td').eq(index).children().eq(0)[0].attributes['data-info'].value;

                    for (const property in item_to_set) {
                        var properties_split=property.split('_');
                        if(properties_split.length >1){
                            if(properties_split[0]==nombre_columna && properties_split[1]==inferiorSuperior){

                                var valor_encontrado=item_to_set[property];
                                //Estableiendo valor al input hidden
                                $(e.currentTarget).parent().siblings('td').eq(index).children().eq(0).val(valor_encontrado);
                                //Estableciendo valor al select2
                                $(e.currentTarget).parent().siblings('td').eq(index).children().eq(1).select2('val',valor_encontrado);

                            }
                        }
                    }
                }

            }
        }else{//La acción fue disparada a través de select de Tipo Activo
            for (var index = 0; index < numero_elementos; index++) {
                //Se obtiene el nombre de la columna
                var nombre_columna=$(e.currentTarget).parent().siblings('td').eq(index).children().eq(0).attr('data-columna');
                //Se obtiene el campo para saber si el elemento pertenece a un rango inferior o superior
                var inferiorSuperior=$(e.currentTarget).parent().siblings('td').eq(index).children().eq(0)[0].attributes['data-info'].value;

                for (const property in item_to_set) {
                    var properties_split=property.split('_');
                    if(properties_split.length >1){
                        if(properties_split[0]==nombre_columna && properties_split[1]==inferiorSuperior){

                            var valor_encontrado=item_to_set[property];
                            //Estableiendo valor al input hidden
                            $(e.currentTarget).parent().siblings('td').eq(index).children().eq(0).val(valor_encontrado);
                            //Estableciendo valor al select2
                            $(e.currentTarget).parent().siblings('td').eq(index).children().eq(1).select2('val',valor_encontrado);
                            //Estableciendo valor al select (no formateado por el plugin select2)
                            $(e.currentTarget).parent().siblings('td').eq(index).children().eq(2).val(valor_encontrado);

                        }
                    }
                }

            }

            var valorSeleccionado=$(e.currentTarget).val();
            var arr_ids_cf=[];
            //Una vez establecidos los valores default, se establecen nuevos valores para rango superior
            for (var indice = 0; indice < this.mainRowsBodyTable.length; indice++) {
                var element = this.mainRowsBodyTable[indice].bodyTable;
                for (var pos = 0; pos < element.length; pos++) {
                    if(element[pos].valorSelected!=undefined && element[pos].valorSelected!=""){
                        if(element[pos].valorSelected==valorSeleccionado){
                            arr_ids_cf.push(indice);
                        }
                    }
                }
            }
            //Una vez lleno el arreglo que contiene los ids de las cf que corresponden al rango, se recorre para llenar el respectivo dropdown
            if(arr_ids_cf.length>0){
                var arreglo_rangos=[];
                for (var idx = 0; idx < arr_ids_cf.length; idx++) {
                    //Se toma el indice "2" ya que es el indice que tiene el rango superior que se encuentra habilitado en el front
                    var elemento= this.mainRowsBodyTable[idx].bodyTable[2];
                    arreglo_rangos.push(elemento.rangoSuperior);
                }
            }

            if(arreglo_rangos.length>0){

                //Eliminando todas las opciones del select antes de agregar las nueva
                $(e.currentTarget).parent().next().next().find('select').empty();

                for (let j = 0; j < arreglo_rangos.length; j++) {
                    var dataOption = {
                        id: arreglo_rangos[j],
                        text: arreglo_rangos[j]
                    };

                    var newOption = new Option(dataOption.text, dataOption.id, true, true);
                    // Append it to the select
                    $(e.currentTarget).parent().next().next().find('select').append(newOption).trigger('change');
                }

                //Estableciendo por default la primera opción del select cada que se establece una nueva serie de opciones
                var first_option=$(e.currentTarget).parent().next().next().find('select').find('option:first').val();
                $(e.currentTarget).parent().next().next().find('select').select2('val',first_option).trigger('change');;
            }
        }

    },

    //Función para solo permitir números
    checkNumOnly: function (evt) {
        if ($.inArray(evt.keyCode, [110, 188, 190, 45, 33, 36, 46, 35, 34, 8, 9, 20, 16, 17, 37, 40, 39, 38, 16, 49, 50, 51, 52, 53, 54, 55, 56, 57, 48, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105]) < 0) {
            app.alert.show("Caracter Invalido", {
                level: "error",
                title: "Solo n\u00FAmeros son permitidos en este campo.",
                autoClose: true
            });
            return false;
        } else {
            return true;
        }
    },

    searchIndexForUpdate:function(valor,arreglo){

        var indiceEncontrado="";
        for (var i = 0; i < arreglo.FinancialTermResponseList.length; i++) {
            if(arreglo.FinancialTermResponseList[i].Name==valor){
                indiceEncontrado=i;
                //Se actualiza el indice para romper el loop
                i=arreglo.FinancialTermResponseList.length;
            }
        }

        return indiceEncontrado;
    },

    searchIndexForUpdateMainRowsConfigBodyTable:function(valor,arreglo,inferiorOsuperior){
        var indiceEncontrado="";

        for (var i = 0; i < arreglo.bodyTable.length; i++) {
            if(arreglo.bodyTable[i].nombreColumna==valor){
                indiceEncontrado=i;
                //Primero se valida el tipo de campo
                if(arreglo.bodyTable[i].text=="1"){
                    //Buscar si el limite inferior, en este caso se regresa la primera ocurrencia dentro del arreglo
                    //pero si es limite superior, se regresa la segunda ocurrencia
                    if(inferiorOsuperior !=undefined){
                        if(inferiorOsuperior=="inputInferior" || inferiorOsuperior=='input'){
                            indiceEncontrado=i;
                        }else{
                            //En este caso se regresa el índice con una unidad más, ya que en este caso se considera que representa a un campo de rango superior
                            indiceEncontrado=i+1;
                        }

                    }

                }
                //Se actualiza el indice para romper el loop
                i=arreglo.bodyTable.length;
            }
        }

        return indiceEncontrado;

    },

    chk_condFinEmptyValues:function (fields, errors, callback){

        if(self.jsonCFConfiguradas!=undefined){
            if(self.jsonCFConfiguradas.FinancialTermGroupResponseList.length != this.jsonCFConfiguradas.FinancialTermGroupResponseList.length ){
                self.jsonCFConfiguradas=this.jsonCFConfiguradas;
            }
        }

        if(this.model.get('cf_quantico_c')!="" && this.model.get('cf_quantico_c')!=undefined){
            var strJsonConfiguradas = JSON.parse(this.model.get('cf_quantico_c'));
            if(strJsonConfiguradas.FinancialTermGroupResponseList.length>0){
                var strMsjErrorTitulo="Es requerido llenar todos los campos de condiciones financieras:<br>";
                //var strMsjError="";
                //var strMsjErrorCondicion="";
                var arrayMsjCompleto=[];
                for (var i = 0; i < strJsonConfiguradas.FinancialTermGroupResponseList.length; i++) {
                    var strMsjError="<br><b>Condición Financiera Configurada "+(i+1)+"</b><br>";
                    var listaCampos=strJsonConfiguradas.FinancialTermGroupResponseList[i].FinancialTermResponseList;
                    var arrayExistenVacios=[];
                    for (var index = 0; index < listaCampos.length; index++) {
                        if(listaCampos[index].Value.ValueMin!=undefined){
                            if(listaCampos[index].Value.ValueMin==""){
                                strMsjError+="-Valor mínimo de columna "+listaCampos[index].Name+"<br>";
                                arrayExistenVacios.push('true');
                            }
                        }
                        if(listaCampos[index].Value.ValueMax!=undefined){
                            if(listaCampos[index].Value.ValueMax==""){
                                strMsjError+="-Valor máximo de columna "+listaCampos[index].Name+"<br>";
                                arrayExistenVacios.push('true');
                            }

                        }
                    }
                    //Checar si la condición financiera tiene valores vacíos para que, en caso de que no tenga valores vacíos,
                    //se omite el titulo de la condición financiera del mensaje de error
                    if(arrayExistenVacios.includes('true')){
                        arrayMsjCompleto.push(strMsjError);
                    }

                }

                if(arrayMsjCompleto.length>0){
                    errors['condiciones_financieras_quantico_'] = errors['condiciones_financieras_quantico'] || {};
                    errors['condiciones_financieras_quantico_'].required = true;
                    $('.CFPoliticaQ').css('border-color', 'red');

                    app.alert.show("CondicionFinancieraQuantico valores vacios", {
                        level: "error",
                        messages: strMsjErrorTitulo+arrayMsjCompleto.join(''),
                        autoClose: false
                    });

                }

            }
        }

        callback(null, fields, errors);
    },

    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                this.render();
            }
        }, this);
    },

    bindDomChange: function () {
        if (this.tplName === 'list-edit') {
            this._super("bindDomChange");
        }
    },

    _render: function () {
        this._super("_render");
        $('[data-type="textarea"][data-name="cf_quantico_politica_c"]').addClass('hide');
        $('[data-type="textarea"][data-name="cf_quantico_c"]').addClass('hide');

        /*Este campo solo es editable para las siguientes etapas
        tct_etapa_ddw_c: Solicitud Inicial
        tct_etapa_ddw_c:Integración Expediente,estatus_c: En espera
        tct_etapa_ddw_c:Integración Expediente,estatus_c: Integración Expediente
        tct_etapa_ddw_c:Integración Expediente,estatus_c: Devuelta por Crédito
        tct_etapa_ddw_c:Integración Expediente,estatus_c: Devuelta BO Crédito
        tct_etapa_ddw_c:Rechazado,estatus_c: Rechazado Crédito
        */
       //$('[data-type="condiciones_financieras_quantico"]').attr('style',"pointer-events:none");
       if(this.model.get('tct_etapa_ddw_c') !='SI' &&
       this.model.get('estatus_c') !='PE' &&
       this.model.get('estatus_c') !='P' &&
       this.model.get('estatus_c') !='DP' &&
       this.model.get('estatus_c') !='DB' &&
       this.model.get('estatus_c') !='R'
        ){
            $('[data-type="condiciones_financieras_quantico"]').attr('style',"pointer-events:none");
       }else{
        $('[data-type="condiciones_financieras_quantico"]').attr('style',"pointer-events:block");
       }

       //Parche para evitar que el campo se vea cortado específicamente para el usuario aavalos
       if($(this.$el).parent().parent().hasClass('span10')){
           $(this.$el).parent().parent().removeClass('span10').addClass('span12');
       }

       if(this.view.currentState != "create" && this.view.currentState != "" && this.tplName=='edit' && this.mainRowsBodyTable.length>1 && this.model.get('tipo_producto_c')!='4'){
           //Se aplica evento change en vista de edicion de campo custom para establecer las opciones de Plazo Meses Días Correctamente con base al Tipo Activo seleccionado por default
           $('select.setDefaultValues').trigger('change');
       }
    },

})
