({
    events: {
        'click  .plusNuevaCF': 'addNewCFConfigurada',
        'click  .borrarCFQuantico': 'deleteCFConfigurada',
        'change .fieldCFConfig':'updateJsonCFConfiguradas'
    },
    initialize: function (options) {
        this._super('initialize', [options]);
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

        return jsonRespuesta;

    },

    loadData: function (options) {

        //Validación para obtener información del campo en lugar de lanzar petición al servicio
        if (this.model.get('cf_quantico_politica_c') == "") {
            this.headers = [];
            this.bodyTable = [];
            this.mainRowsBodyTable = [];
            this.mainRowsConfigBodyTable = [];
            self = this;

            //Forma url de petición
            var url = app.api.buildURL('CondicionesFinancierasQuantico', null, null, {});
            app.api.call('GET', url, {}, {
                success: function (data) {

                    //Llenar los headers
                    //Recorres el array de respuesta para corroborar el tipo de dato para conocer el campo html que corresponde
                    if (data.FinancialTermGroupResponseList.length > 0) {
                        var arrayRespuesta = data.FinancialTermGroupResponseList[0].FinancialTermResponseList;
                        if (arrayRespuesta.length > 0) {
                            for (var i = 0; i < arrayRespuesta.length; i++) {
                                var objHeader = {};
                                objHeader["name"] = arrayRespuesta[i].Name;
                                objHeader["idCampo"] = arrayRespuesta[i].DataType.Id;

                                // Comprobando los id 4,5,9 y 11 para colocar doble campo, que son los de rango (2 inputs)
                                if (arrayRespuesta[i].DataType.Id == '4' || arrayRespuesta[i].DataType.Id == '5' || arrayRespuesta[i].DataType.Id == '9' || arrayRespuesta[i].DataType.Id == '11') {
                                    objHeader['dobleCampo'] = '1';
                                    self.bodyTable.push();
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

                                    self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'rangoInferior': rangoInferior, 'rangoSuperior': "","limiteInferior":limiteInferior,"limiteSuperior":limiteSuperior});
                                    self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'rangoInferior': "", 'rangoSuperior': rangoSuperior,"limiteInferior":limiteInferior,"limiteSuperior":limiteSuperior });
                                } else if (arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '7') {//Catálogo
                                    //Obteniendo los valores de la lista
                                    var nombre_lista = arrayRespuesta.FinancialTermResponseList[i].Name;
                                    //Obteniendo el mapeo desde la lista
                                    var lista_valores = App.lang.getAppListStrings('mapeo_nombre_attr_cf_quantico_list')[nombre_lista];
                                    var valores_select = data['listaValores'][lista_valores];
                                    var valores_select_obj = {};
                                    //Convirtiendo el arreglo a objeto para poderlo mostrar en las opciones del campo select
                                    for (var j = 0; j < valores_select.length; j++) {
                                        valores_select_obj[valores_select[j].Id] = valores_select[j].Name;
                                    }
                                    var valorSelected = arrayRespuesta.FinancialTermResponseList[i].Value.ValueId;

                                    self.bodyTable.push({ 'select': '1', 'text': '', 'checkbox': '','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'valoresCatalogo': valores_select_obj, 'valorSelected': valorSelected });
                                } else if (arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '1') {//Check
                                    var strChecked = "";
                                    var valorBoolean = arrayRespuesta.FinancialTermResponseList[11].Value.Value;
                                    if (valorBoolean == "True") {
                                        strChecked = 'checked'
                                    }
                                    self.bodyTable.push({ 'select': '', 'text': '', 'checkbox': '1','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, "checked": strChecked });
                                } else {// Solo 1 Text
                                    self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name });
                                }
                            }
                            self.mainRowsBodyTable.push({ 'bodyTable': self.bodyTable });

                        }

                    }

                    self.render();
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
                var arrayRespuesta = data.FinancialTermGroupResponseList[0].FinancialTermResponseList;
                if (arrayRespuesta.length > 0) {
                    for (var i = 0; i < arrayRespuesta.length; i++) {
                        var objHeader = {};
                        objHeader["name"] = arrayRespuesta[i].Name;
                        objHeader["idCampo"] = arrayRespuesta[i].DataType.Id;

                        // Comprobando los id 4,5,9 y 11 para colocar doble campo, que son los de rango (2 inputs)
                        if (arrayRespuesta[i].DataType.Id == '4' || arrayRespuesta[i].DataType.Id == '5' || arrayRespuesta[i].DataType.Id == '9' || arrayRespuesta[i].DataType.Id == '11') {
                            objHeader['dobleCampo'] = '1';
                            self.bodyTable.push();
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

                            self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'rangoInferior': rangoInferior, 'rangoSuperior': "" ,"limiteInferior":limiteInferior,"limiteSuperior":limiteSuperior});
                            self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'rangoInferior': "", 'rangoSuperior': rangoSuperior,"limiteInferior":limiteInferior,"limiteSuperior":limiteSuperior });
                        } else if (arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '7') {//Catálogo
                            //Obteniendo los valores de la lista
                            var nombre_lista = arrayRespuesta.FinancialTermResponseList[i].Name;
                            //Obteniendo el mapeo desde la lista
                            var lista_valores = App.lang.getAppListStrings('mapeo_nombre_attr_cf_quantico_list')[nombre_lista];
                            var valores_select = data['listaValores'][lista_valores];
                            var valores_select_obj = {};
                            //Convirtiendo el arreglo a objeto para poderlo mostrar en las opciones del campo select
                            for (var j = 0; j < valores_select.length; j++) {
                                valores_select_obj[valores_select[j].Id] = valores_select[j].Name;
                            }
                            var valorSelected = arrayRespuesta.FinancialTermResponseList[i].Value.ValueId;

                            self.bodyTable.push({ 'select': '1', 'text': '', 'checkbox': '','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'valoresCatalogo': valores_select_obj, 'valorSelected': valorSelected });
                        } else if (arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '1') {//Check
                            var strChecked = "";
                            var valorBoolean = arrayRespuesta.FinancialTermResponseList[11].Value.Value;
                            if (valorBoolean == "True") {
                                strChecked = 'checked'
                            }
                            self.bodyTable.push({ 'select': '', 'text': '', 'checkbox': '1','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, "checked": strChecked });
                        } else {// Solo 1 Text
                            self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name });
                        }
                    }
                    self.mainRowsBodyTable.push({ 'bodyTable': self.bodyTable });

                }

            }

            //self.render();
        }

        this.setinfoCFConfiguradas();
        self.render();

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
                            //Obteniendo el mapeo desde la lista
                            var lista_valores = App.lang.getAppListStrings('mapeo_nombre_attr_cf_quantico_list')[nombre_lista];
                            var valores_select = data['listaValores'][lista_valores];
                            var valores_select_obj = {};
                            //Convirtiendo el arreglo a objeto para poderlo mostrar en las opciones del campo select
                            for (var j = 0; j < valores_select.length; j++) {
                                valores_select_obj[valores_select[j].Id] = valores_select[j].Name;
                            }
                            var valorSelected = arrayRespuesta.FinancialTermResponseList[i].Value.ValueId;

                            self.bodyTable.push({ 'select': '1', 'text': '', 'checkbox': '','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, 'valoresCatalogo': valores_select_obj, 'valorSelected': valorSelected });
                        } else if (arrayRespuesta.FinancialTermResponseList[i].DataType.Id == '1') {//Check
                            var strChecked = "";
                            var valorBoolean = arrayRespuesta.FinancialTermResponseList[11].Value.Value;
                            if (valorBoolean == "True") {
                                strChecked = 'checked'
                            }
                            self.bodyTable.push({ 'select': '', 'text': '', 'checkbox': '1','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name, "checked": strChecked });
                        } else {// Solo 1 Text
                            self.bodyTable.push({ 'select': '', 'text': '1', 'checkbox': '','nombreColumna':arrayRespuesta.FinancialTermResponseList[i].Name, 'nombreCampo': arrayRespuesta.FinancialTermResponseList[i].DataType.Name });
                        }
                    }
                    self.mainRowsConfigBodyTable.push({ 'bodyTable': self.bodyTable });

                }

            }

        }

    },

    addNewCFConfigurada: function (e) {

        var indiceFilaClickada = $(e.currentTarget).parent().parent().index();
        var filaPoliticaObtenida = self.mainRowsBodyTable[indiceFilaClickada];
        this.mainRowsConfigBodyTable.push(filaPoliticaObtenida);

        //Comienza a formarse estructura json de condiciones financieras configuradas
        this.jsonCFConfiguradas.RequestId=this.model.get('id');
        this.jsonCFConfiguradas.OpportunitiesId=this.model.get('idsolicitud_c');
        //Obteniendo el campo html para conocer el tipo de campo quie se envía al json
        var camposEnfila=$(e.currentTarget).parent().parent().find('td');
        var objetoTermResponseList=[];
        for (let index = 0; index < camposEnfila.length; index++) {
            var elemento = $(camposEnfila).eq(index);
            //Comprobar si el campo es select, por lo tanto se agrega json con definición de Catálogo
            if(elemento.children('select').length>0){
                 //Definición para campos de catálogo
                var objetoSelect=this.setPlantillasJSON("Catalogo");
                objetoSelect.Name=$(camposEnfila).eq(index).children('select').attr('data-columna');
                objetoSelect.Value.Value=$(camposEnfila).eq(index).children('select').children('option:selected').html();
                objetoSelect.Value.ValueId=$(camposEnfila).eq(index).children('select').eq(0).children(':selected').val();

                objetoTermResponseList.push(objetoSelect);

            }else if(elemento.children('input[type="text"]').length>0 && elemento.children('input[type="text"]').attr('data-info')=='inferior'){
                //Definición para campos de rango
                var objetoRango=this.setPlantillasJSON(elemento.children('input[type="text"]').attr('data-name'));
                objetoRango.Name=elemento.children('input[type="text"]').attr('data-columna');
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
                objetoCheckBox.Value.Value=valorJsonChk;
                objetoTermResponseList.push(objetoCheckBox);
            }
            
        }
        this.jsonCFConfiguradas.FinancialTermGroupResponseList.push({"Id":"67","FinancialTermResponseList":objetoTermResponseList})
        var jsonStringConfiguradas=JSON.stringify(this.jsonCFConfiguradas);
        this.model.set("cf_quantico_c",jsonStringConfiguradas);

        this.render();

    },

    deleteCFConfigurada: function (e) {
        var indiceBorrar = $(e.currentTarget).parent().parent().index();
        this.mainRowsConfigBodyTable.splice(indiceBorrar, 1);
        this.jsonCFConfiguradas.FinancialTermGroupResponseList.splice(indiceBorrar,1);
        var jsonStringConfiguradas=JSON.stringify(this.jsonCFConfiguradas);
        this.model.set("cf_quantico_c",jsonStringConfiguradas);

        this.render();
    },

    updateJsonCFConfiguradas:function(e){
        var indexCampo = $(e.currentTarget).parent().parent().index();
        var valorBuscado=$(e.currentTarget).attr('data-columna');
        var indiceEncontrado=this.searchIndexForUpdate(valorBuscado,self.jsonCFConfiguradas.FinancialTermGroupResponseList[indexCampo]);
        var indexForUpdateJsonToHbs=this.searchIndexForUpdateMainRowsConfigBodyTable(valorBuscado,self.mainRowsConfigBodyTable[indexCampo]);

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

        }else if(tipoCampo=="inputSuperior"){
            self.jsonCFConfiguradas.FinancialTermGroupResponseList[indexCampo].FinancialTermResponseList[indiceEncontrado].Value.ValueMax=$(e.currentTarget).val();

            //Se actualiza el objeto json que se dibuja en el hbs
            self.mainRowsConfigBodyTable[indexCampo].bodyTable[indexForUpdateJsonToHbs].rangoSuperior=$(e.currentTarget).val();

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


        }

        var jsonStringConfiguradas=JSON.stringify(self.jsonCFConfiguradas);
        self.model.set("cf_quantico_c",jsonStringConfiguradas);

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

    searchIndexForUpdateMainRowsConfigBodyTable:function(valor,arreglo){
        var indiceEncontrado="";
        for (var i = 0; i < arreglo.bodyTable.length; i++) {
            if(arreglo.bodyTable[i].nombreColumna==valor){
                indiceEncontrado=i;
                //Primero se valida el tipo de campo
                if(arreglo.bodyTable[i].text=="1"){
                    //Buscar si el limite inferior, en este caso se regresa la primera ocurrencia dentro del arreglo
                    //pero si es limite superior, se regresa la segunda ocurrencia
                    if(arreglo.bodyTable[i].rangoInferior=="0"){
                        indiceEncontrado=i;
                    }else{
                        //En este caso se regresa el índice con una unidad más, ya que en este caso se considera que representa a un campo de rango superior
                        indiceEncontrado=i+1;
                    }
                }
                //Se actualiza el indice para romper el loop
                i=arreglo.bodyTable.length;
            } 
        }

        return indiceEncontrado;

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
    },

})
