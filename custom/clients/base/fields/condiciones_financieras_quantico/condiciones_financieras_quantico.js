({
    initialize: function (options) {
        this._super('initialize', [options]);

        this.model.on('sync', this.loadData, this);
        
    },

    loadData: function(options){
        this.headers=[];
        this.bodyTable=[];
        this.idsTipo=[];
        self=this;

        //Forma url de petición
        var url = app.api.buildURL('CondicionesFinancierasQuantico?tipo=12345', null, null, {});
        app.api.call('GET', url, {},{
            success: function (data){
                //Recorres el array de respuesta para corroborar el tipo de dato para conocer el campo html que corresponde
                if(data.FinancialTermGroupResponseList.length>0){
                    var arrayRespuesta=data.FinancialTermGroupResponseList[3].FinancialTermResponseList;
                    if(arrayRespuesta.length>0){
                        for (var i = 0; i < arrayRespuesta.length; i++) {
                            var objHeader={};
                            var objBody={};
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
                            //Rangos (2 Text)
                            if(arrayRespuesta[i].DataType.Id=='4' || arrayRespuesta[i].DataType.Id=='5' || arrayRespuesta[i].DataType.Id=='9' || arrayRespuesta[i].DataType.Id=='11'){
                                self.bodyTable.push({'select':'','text':'1','checkbox':'','nombreCampo':arrayRespuesta[i].Name});
                                self.bodyTable.push({'select':'','text':'1','checkbox':'','nombreCampo':arrayRespuesta[i].Name});
                            }else if(arrayRespuesta[i].DataType.Id=='7'){//Catálogo
                                self.bodyTable.push({'select':'1','text':'','checkbox':'','nombreCampo':arrayRespuesta[i].Name});
                            }else if(arrayRespuesta[i].DataType.Id=='1'){//Check
                                self.bodyTable.push({'select':'','text':'','checkbox':'1','nombreCampo':arrayRespuesta[i].Name});
                            }else{// Solo 1 Text
                                self.bodyTable.push({'select':'','text':'1','checkbox':'','nombreCampo':arrayRespuesta[i].Name});
                            }

                        }


                    }

                }
                                
                self.render();
            }
          });
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
