({
    extendsFrom: 'RecordView',
    seleccionado:null,

    initialize: function (options) {
      	
        self = this;
        this._super("initialize", [options]);
        
        this.model.addValidationTask('valida_fcr_hd', _.bind(this.valida_fcr_hd, this));
        this.model.addValidationTask('valida_requeridos_min', _.bind(this.valida_requeridos_min, this));
        this.model.addValidationTask('valida_concluido', _.bind(this.valida_concluido, this));
        
        this.model.on('sync', this.getPersonas, this);
        this.model.on('sync', this.setOpcionesCredito, this);
        this.model.on('change:account_name', this.getPersonas, this);
        this.model.on('change:type', this.setPriority, this);
        this.model.on('change:subtipo_c', this.setPriority, this);  
    },

    delegateButtonEvents: function () {
        this._super("delegateButtonEvents");

        this.context.on('button:finalizar_ticket:click', this.finalizar_ticket, this);
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

    valida_fcr_hd:function(fields, errors, callback){
        //Valida fcr y hd, son requeridos siempre que estén visibles, en caso de que ambos lo estén, solo es requerido alguno de los 2
        if(!$('[data-name="case_fcr_c"].record-cell').hasClass('vis_action_hidden') && this.model.get('case_fcr_c')!==true &&
        !$('[data-name="case_hd_c"].record-cell').hasClass('vis_action_hidden') && this.model.get('case_hd_c')!==true){
            errors['case_fcr_c'] = errors['case_fcr_c'] || {};
            errors['case_fcr_c'].required = true;
            errors['case_hd_c'] = errors['case_hd_c'] || {};
            errors['case_hd_c'].required = true;

        }else if(!$('[data-name="case_fcr_c"].record-cell').hasClass('vis_action_hidden') && this.model.get('case_fcr_c')!==true && $('[data-name="case_hd_c"].record-cell').hasClass('vis_action_hidden')){

            errors['case_fcr_c'] = errors['case_fcr_c'] || {};
            errors['case_fcr_c'].required = true;

        }else if(!$('[data-name="case_hd_c"].record-cell').hasClass('vis_action_hidden') && this.model.get('case_hd_c')!==true && $('[data-name="case_fcr_c"].record-cell').hasClass('vis_action_hidden')){
            errors['case_hd_c'] = errors['case_hd_c'] || {};
            errors['case_hd_c'].required = true;
        }

        callback(null, fields, errors);
    },

    valida_concluido:function(fields, errors, callback){
        //Únicamente el usuario creador y su jefe tienen la capacidad de establecer "Completada" el caso
        var id_user_creator=this.model.get('created_by');

        app.alert.show('validar_concluido', {
            level: 'process',
            title: 'Validando, por favor espere'
        });

        app.api.call('GET', app.api.buildURL('UserRolesReportsToId/' + id_user_creator), null, {
            success: function (data) {
                app.alert.dismiss('validar_concluido')
                var user_log=App.user.id;
                var roles=data.roles;
                var roles_que_pueden_completar=Object.keys(App.lang.getAppListStrings('roles_seguimiento_comercial_list'));
                //Los usuarios con Roles Operativo o Directivos, si tienen permiso de establecer como "Completado" el caso
                var tieneRolComercial=0;
                for (let index = 0; index < roles.length; index++) {
                    if(roles_que_pueden_completar.includes(roles[index])){
                        tieneRolComercial++;
                    }
                }
                var reporta_a=data.reports_to_id;

                //Los usuarios que pueden "Completar" Casos son:
                //El usuario creador
                //Jefe directo (Reporta a) del usuario creador
                //El usuario asignado al registro en caso de que el usuario creador tenga algún rol comercial (Operativo, Directivos)
                var tiene_permiso_guardar=[];
                if(user_log == self.model.get('created_by') && tieneRolComercial==0){
                    tiene_permiso_guardar.push(1);
                }
                if(user_log == reporta_a && tieneRolComercial==0){
                    tiene_permiso_guardar.push(1);
                }

                if(user_log == self.model.get("assigned_user_id") && tieneRolComercial>0){
                    tiene_permiso_guardar.push(1);
                }

                if(self.model.get('status')=='3' && !tiene_permiso_guardar.includes(1)){
                    errors['status'] = errors['status'] || {};
                    errors['status'].required = true;

                    app.alert.show("completada_no_permitido", {
                        level: "error",
                        messages: "Usted no cuenta con el privilegio para establecer el Estatus como <b>Completado</b> para este registro",
                        autoClose: false
                    });
                }

                callback(null, fields, errors);
            },
            error: function (e) {
                throw e;
            }    
        });
        
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

    finalizar_ticket:function(){
        var id_user_creator=this.model.get('created_by');
        //Si no eres asignado, el creador o el jefe del creador

        if(this.model.get('status')=='3'){
            
            app.alert.show('finaliza_ticket_success', {
                level: 'warning',
                messages: 'El ticket ya se encuentra <b>Completado</b>',
                autoClose: true
            });

        }else{

            app.alert.show('validar_concluido', {
                level: 'process',
                title: 'Validando, por favor espere'
            });
    
            app.api.call('GET', app.api.buildURL('UserRolesReportsToId/' + id_user_creator), null, {
                success: function (data) {
                    app.alert.dismiss('validar_concluido');
                    var usuario_creador=self.model.get('created_by');
                    var user_log=App.user.id;
                    var roles=data.roles;
                    var roles_que_pueden_completar=Object.keys(App.lang.getAppListStrings('roles_seguimiento_comercial_list'));
                    if(user_log != self.model.get("assigned_user_id") && user_log != self.model.get('created_by') && user_log != reporta_a){
                        app.alert.show('error_finaliza', {
                            level: 'error',
                            messages: 'No tienes permiso para finalizar este ticket',
                            autoClose: false
                        });
                        return;
                    }
                    //Los usuarios con Roles Operativo o Directivos, si tienen permiso de establecer como "Completado" el caso
                    var tieneRolComercial=0;
                    for (let index = 0; index < roles.length; index++) {
                        if(roles_que_pueden_completar.includes(roles[index])){
                            tieneRolComercial++;
                        }
                    }
                    var reporta_a=data.reports_to_id;
    
                    //Los usuarios que pueden "Completar" Casos son:
                    //El usuario creador
                    //Jefe directo (Reporta a) del usuario creador
                    //El usuario asignado al registro en caso de que el usuario creador tenga algún rol comercial (Operativo, Directivos)
                    var tiene_permiso_guardar=[];
                    if(user_log == self.model.get('created_by') && tieneRolComercial==0){
                        tiene_permiso_guardar.push(1);
                    }
                    if(user_log == reporta_a && tieneRolComercial==0){
                        tiene_permiso_guardar.push(1);
                    }
    
                    if(user_log == self.model.get("assigned_user_id") && tieneRolComercial>0){
                        tiene_permiso_guardar.push(1);
                    }
                    
                    //Cuando se cumplen las condiciones para Completar, se establece el valor de "Completado"
                    //En otro caso, solo se reasigna al usuario creador
                    if(tiene_permiso_guardar.includes(1)){
                        app.alert.show('finaliza_ticket', {
                            level: 'process',
                            title: 'Guardando'
                        });
                        self.model.set('status','3');
                        self.model.save(null, {
                            success: function (model, response) {
                                
                                app.alert.dismiss('finaliza_ticket');
                                app.alert.show('finaliza_ticket_success', {
                                    level: 'success',
                                    messages: 'El ticket se ha establecido como <b>Completado</b>',
                                    autoClose: false
                                });
                                    
                            }, error: function (model, response) {
                                
                            }
                        });
                    }else{
                        self.model.set('assigned_user_id',usuario_creador);

                        app.alert.show('finaliza_ticket', {
                            level: 'process',
                            title: 'Guardando'
                        });
                        
                        self.model.save(null, {
                            success: function (model, response) {
                                
                                app.alert.dismiss('finaliza_ticket');
                                app.alert.show('finaliza_ticket_success', {
                                    level: 'success',
                                    messages: 'El ticket se ha reasignado al usuario creador para que éste lo pueda cerrar',
                                    autoClose: false
                                });
                                    
                            }, error: function (model, response) {
                                
                            }
                        });
                    }
                },
                error: function (e) {
                    throw e;
                }    
            });
        }  
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

    setPriority: function(){

        var subtipo=this.model.get('subtipo_c');

        switch (subtipo) {
            case '22':
            case '47':
            case '48':
            case '52':
            case '88':
                this.model.set('priority','P3');
            break;

            case '15':
            case '18':
            case '20':
            case '21':
            case '33':
            case '34':
            case '35':
            case '36':
            case '38':
            case '41':
            case '42':
            case '45':
            case '54':
            case '57':
            case '59':
            case '60':
            case '61':
            case '62':
            case '78':
            case '80':
            case '81':
            case '82':
            case '84':
            case '85':
            case '92':
                this.model.set('priority','P1');
            break;

            case '16':
            case '17':
            case '19':
            case '23':
            case '24':
            case '25':
            case '26':
            case '27':
            case '29':
            case '30':
            case '31':
            case '32':
            case '37':
            case '39':
            case '40':
            case '43':
            case '44':
            case '49':
            case '50':
            case '51':
            case '53':
            case '55':
            case '58':
            case '79':
            case '83':
            case '86':
            case '87':
                this.model.set('priority','P2');
            break;

            case '28':
            case '46':
            case '56':
                this.model.set('priority','P4');
            break;

            default: 
                this.model.set('priority','P1');
        }

    },

    setOpcionesCredito(){

        var roles=App.user.attributes.roles;
        //A los roles de esta lista se les muestran valores específicos en las listas desplegables
        var roles_credito=Object.keys(App.lang.getAppListStrings('roles_seguimiento_comercial_list'));
        
        var tieneRolComercial=0;
        for (let index = 0; index < roles.length; index++) {
            if(roles_credito.includes(roles[index])){
                tieneRolComercial++;
            }
        }

        if(tieneRolComercial>0){
            var lista_productos= app.lang.getAppListStrings('casos_productos_list');
            //A los usuarios con rol comercial (Operativo y Directivos), solo se les muestra el Producto "Seguimiento Comercial"
            Object.keys(lista_productos).forEach(function (key) {
                if(key !="SC6"){
                    delete lista_productos[key];
                }
            });
            this.model.fields['producto_c'].options = lista_productos;
            //Estableciendo nuevas opciones en campo de producto
            var campo_producto=this.getField('producto_c');
            campo_producto.items=lista_productos;
            //campo_producto.render();
            this.model.set('producto_c','SC6');

            //A los usuarios con rol comercial (Operativo y Directivos),en el campo de área interna, se muestra por default el valor "Crédito"
            var area_interna_list= app.lang.getAppListStrings('area_interna_list');
            Object.keys(area_interna_list).forEach(function (key) {
                if(key !="Credito"){
                    delete area_interna_list[key];
                }
            });
            this.model.fields['area_interna_c'].options = area_interna_list;
            //Estableciendo nuevas opciones en campo de producto
            var campo_area_interna=this.getField('area_interna_c');
            campo_area_interna.items=area_interna_list;
            //campo_area_interna.render();
            
            this.model.set('area_interna_c','Credito');

            this._render();
        }

    }

})
