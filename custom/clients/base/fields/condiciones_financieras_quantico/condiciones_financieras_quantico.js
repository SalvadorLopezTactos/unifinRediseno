({
    events: {
        'click  .plusNuevaCF': 'addNewCFConfigurada',
    },
    initialize: function (options) {
        this._super('initialize', [options]);

        this.model.on('sync', this.loadData, this);
        
    },

    loadData: function(options){
        this.headers=[];
        this.bodyTable=[];
        this.mainRowsBodyTable=[];
        this.idsTipo=[];
        self=this;

        //Forma url de petición
        var url = app.api.buildURL('CondicionesFinancierasQuantico', null, null, {});
        app.api.call('GET', url, {},{
            success: function (data){

                //Llenar los headers
                //Recorres el array de respuesta para corroborar el tipo de dato para conocer el campo html que corresponde
                if(data.FinancialTermGroupResponseList.length>0){
                    var arrayRespuesta=data.FinancialTermGroupResponseList[0].FinancialTermResponseList;
                    if(arrayRespuesta.length>0){
                        for (var i = 0; i < arrayRespuesta.length; i++) {
                            var objHeader={};
                            objHeader["name"]=arrayRespuesta[i].Name;
                            objHeader["idCampo"]=arrayRespuesta[i].DataType.Id;

                            // Comprobando los id 4,5,9 y 11 para colocar doble campo, que son los de rango (2 inputs)
                            if(arrayRespuesta[i].DataType.Id=='4' || arrayRespuesta[i].DataType.Id=='5' || arrayRespuesta[i].DataType.Id=='9' || arrayRespuesta[i].DataType.Id=='11'){
                                objHeader['dobleCampo']='1';
                                self.bodyTable.push();
                            }else{
                                objHeader['dobleCampo']='';
                            }
                            self.headers.push(objHeader);
                        }
                    }

                    //Llenado del cuerpo de la tabla
                    for (var index = 0; index < data.FinancialTermGroupResponseList.length; index++) {
                        var arrayRespuesta=data.FinancialTermGroupResponseList[index];
                        var objRow={};
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
                       self.bodyTable=[];
                       for (var i = 0; i < arrayRespuesta.FinancialTermResponseList.length; i++){
                           if(arrayRespuesta.FinancialTermResponseList[i].DataType.Id=='4' || 
                            arrayRespuesta.FinancialTermResponseList[i].DataType.Id=='5' || 
                            arrayRespuesta.FinancialTermResponseList[i].DataType.Id=='9' || 
                            arrayRespuesta.FinancialTermResponseList[i].DataType.Id=='11'
                           ){
                               var rangoInferior=arrayRespuesta.FinancialTermResponseList[i].Value.ValueMin;
                               var rangoSuperior=arrayRespuesta.FinancialTermResponseList[i].Value.ValueMax;
                               self.bodyTable.push({'select':'','text':'1','checkbox':'','nombreCampo':arrayRespuesta.FinancialTermResponseList[i].Name,'rangoInferior':rangoInferior,'rangoSuperior':""});
                               self.bodyTable.push({'select':'','text':'1','checkbox':'','nombreCampo':arrayRespuesta.FinancialTermResponseList[i].Name,'rangoInferior':"",'rangoSuperior':rangoSuperior});
                            }else if(arrayRespuesta.FinancialTermResponseList[i].DataType.Id=='7'){//Catálogo
                                //Obteniendo los valores de la lista
                                var nombre_lista=arrayRespuesta.FinancialTermResponseList[i].Name;
                                //Obteniendo el mapeo desde la lista
                                var lista_valores=App.lang.getAppListStrings('mapeo_nombre_attr_cf_quantico_list')[nombre_lista];
                                var valores_select=data['listaValores'][lista_valores];
                                var valores_select_obj={};
                                //Convirtiendo el arreglo a objeto para poderlo mostrar en las opciones del campo select
                                for (var j = 0; j < valores_select.length; j++) {
                                    valores_select_obj[valores_select[j].Id]=valores_select[j].Name;
                                }
                                var valorSelected=arrayRespuesta.FinancialTermResponseList[i].Value.ValueId;
                                
                                self.bodyTable.push({'select':'1','text':'','checkbox':'','nombreCampo':arrayRespuesta.FinancialTermResponseList[i].Name,'valoresCatalogo':valores_select_obj,'valorSelected':valorSelected});
                            }else if(arrayRespuesta.FinancialTermResponseList[i].DataType.Id=='1'){//Check
                                var strChecked="";
                                var valorBoolean=arrayRespuesta.FinancialTermResponseList[11].Value.Value;
                                if(valorBoolean=="True"){
                                    strChecked='checked'
                                }
                                self.bodyTable.push({'select':'','text':'','checkbox':'1','nombreCampo':arrayRespuesta.FinancialTermResponseList[i].Name,"checked":strChecked});
                            }else{// Solo 1 Text
                                self.bodyTable.push({'select':'','text':'1','checkbox':'','nombreCampo':arrayRespuesta.FinancialTermResponseList[i].Name});
                            }
                       }
                       self.mainRowsBodyTable.push({'bodyTable':self.bodyTable});

                    }

                }
                
                                
                self.render();
            }
          });
    },

    addNewCFConfigurada:function(e){
        console.log('CLICK CF');

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
