({
    extendsFrom: 'RecordView',
    seleccionado:null,

    initialize: function (options) {
      	
        self = this;
        this._super("initialize", [options]);
        
        this.model.addValidationTask('valida_requeridos_min', _.bind(this.valida_requeridos_min, this));
        this.model.on('sync', this.getPersonas, this);
        this.model.on('change:account_name', this.getPersonas, this);       
    },

    _render: function (options) {
        this._super("_render");
    },

    handleCancel: function () {
        this._super("handleCancel");
        if(self.model.get('contacto_principal_c')!="")
        {
            self.model.set('case_cuenta_relacion','Muestra');
        }
    },

    valida_requeridos_min: function (fields, errors, callback) {
        var campos = "";

        _.each(errors, function (value, key) {
            _.each(this.model.fields, function (field) {
                if (_.isEqual(field.name, key)) {
                    if (field.vname) {
                        campos = campos + '<b>' + app.lang.get(field.vname, "Cases") + '</b><br>';
                    }
                }
            }, this);
        }, this);

        if (campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información para guardar un <b>Caso: </b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    getPersonas: function () {
        nombreSelect="";
        var idCuenta = selfPerson.model.get('account_id');
        var parentModule = selfPerson.model.get('parent_type');
        if(idCuenta!=undefined && idCuenta!=""){
            app.api.call('GET', app.api.buildURL('GetRelRelaciones/' + idCuenta), null, {
                success: function (data) {
                    //console.log(data.records);
                    var idpersonas = selfPerson.model.get('persona_relacion_c');
                    var arrayPersonas = [];
                    var isSelect = false;
                    if(data.length > 0){
                        var filter_arguments =
                        {
                            max_num:-1,
                            "fields": [
                                "id",
                                "name",
                                "tipodepersona_c"
                            ],
                        };
                        filter_arguments["filter"] = [
                            {
                                "$and":[
                                    {
                                    "tipodepersona_c":{
                                        "$not_equals":"Persona Moral"
                                        }
                                    },
                                    {
                                    "id":{"$in":[]}
                                    }
                                ]
                            }
                        ];
                        
                        var or_arr = [];
                        var json_arr = {};
                        for (var i = 0; i < data.length; i++) {
                            //json_arr["id"] = data[i]['id'];
                            //or_arr.push(json_arr);
                            or_arr.push(data[i]['id']);
                        }
                        filter_arguments.filter[0]["$and"][1]["id"]["$in"]=or_arr;
                        console.log(filter_arguments);
                        
                        app.api.call('GET', app.api.buildURL('Accounts',null,null,filter_arguments), null, {
                            success: function (cuentas) {
                                console.log(cuentas);
                                var idpersonas = selfPerson.model.get('account_id_c');;
                                for (var i = 0; i < cuentas.records.length; i++) {
                                    if (idpersonas != "" && idpersonas == data[i]['id']) {
                                        isSelect = true;
                                        nombreSelect=cuentas.records[i]['name'];
                                    }else{ isSelect = false;  }

                                    arrayPersonas.push({
                                        "id": cuentas.records[i]['id'],
                                        "name": cuentas.records[i]['name'],
                                        "select": isSelect
                                    });
                                }
                                console.log(arrayPersonas);
                                selfPerson.seleccionado=nombreSelect;
                                selfPerson.personasRelData_list = arrayPersonas;
                                selfPerson.render();
                                if(idpersonas!="")
                                {
                                    selfPerson.model.set('case_cuenta_relacion','nombreSelect');
                                }
                            },
                            error: function (e) {
                                throw e;
                            }
                        });
                    }
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
    },

})
