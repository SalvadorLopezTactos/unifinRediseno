({
    className: 'verifica-view',

    events: {
        'click #btn-rechazar-cambios': 'rechazarCambios',
        'click #btn-aprobar-cambios': 'aprobarCambios',
        'click .closeModalVerificaCambios': 'rechazarCambios',
    },

    usr_aprobo_rechazo:null,
    id_usr_aprobo_rechazo:null,
    fecha_aprobo_rechazo:null,
    nombrePrevio: null,
    direccionPrevia: null,
    fechacambioPrevia: null,
    nombreNuevo: null,
    direccionNueva: null,
    fechacambioNueva: null,
    json_audit_cuenta: null,
    json_audit_direccion: null,

    initialize: function (options) {
        this._super("initialize", [options]);
        var idCuenta = options.context.get('model').id;
        var json_audit_cuenta = options.context.get('model').attributes.json_audit_c;
        var json_direcciones = ( options.context.get('model').attributes.cambio_dirfiscal_c ) ? options.context.get('model').attributes.json_direccion_audit_c : "";
        var cambioDirFiscal =  options.context.get('model').attributes.cambio_dirfiscal_c;
        var cambioDirApi = options.context.get('model').attributes.direccion_actualizada_api_c;
        if( idCuenta !== undefined ){
            this.getCambiosDetectados( idCuenta, json_audit_cuenta, json_direcciones, cambioDirFiscal , cambioDirApi );
        }
    },
    
    getCambiosDetectados: function(idCuenta,json_audit_cuenta,json_direcciones_string, cambioFiscal, cambioDirApi){
        this.json_audit_cuenta = json_audit_cuenta;
        contextCambios = this;

        if( !cambioDirApi ){

            if( this.json_audit_cuenta !== undefined && this.json_audit_cuenta !== "" ){
                //Armando objeto de Cuentas
                var json_cuenta = JSON.parse(this.json_audit_cuenta);
                this.json_audit_cuenta = json_cuenta;
                this.nombrePrevio = json_cuenta.nombre_actual;
                this.nombreNuevo = json_cuenta.nombre_por_actualizar;
                this.fechacambioNueva = json_cuenta.fecha_cambio;
                this.fechacambioPrevia = json_cuenta.fecha_cambio;
            }
    
            if( json_direcciones_string !== "" && cambioFiscal == 1){
            
                var json_direcciones = JSON.parse(json_direcciones_string);
                var fiscal_actual = this.getDireFiscal(json_direcciones['json_dire_actual']);
                var nombre_direccion_actual = this.buildFullNameDireccion(fiscal_actual);
    
                var fiscal_por_actualizar = this.getDireFiscal(json_direcciones['json_dire_actualizar']);
                var nombre_direccion_por_actualizar= this.buildFullNameDireccion(fiscal_por_actualizar);
    
                this.direccionPrevia = nombre_direccion_actual;
                this.direccionNueva = nombre_direccion_por_actualizar;
                this.fechacambioNueva = json_direcciones['fecha_cambio'];
                this.fechacambioPrevia =json_direcciones['fecha_cambio'];
    
            }
    
            this.usr_aprobo_rechazo = this.model.get('usr_aprueba_rechaza_c');
            this.id_usr_aprobo_rechazo = this.model.get('user_id9_c');
            this.fecha_aprobo_rechazo = this.model.get('fecha_aprueba_rechaza_c');
    
            this.render();

        }else{
            //Entra else cuando el cambio de dirección se realice via API
            app.alert.show('getCambios', {
                level: 'process',
                title: 'Cargando...',
            });

            var url = app.api.buildURL('cambiosRazonSocialDireFiscal/' + idCuenta, null, null,);
            app.api.call('GET', url, {}, {
                success: function (data) {
                    app.alert.dismiss('getCambios');
                    contextCambios.nombrePrevio = "";
                    contextCambios.direccionPrevia = "";
                    contextCambios.fechacambioPrevia = "";

                    contextCambios.nombreNuevo = "";
                    contextCambios.direccionNueva = "";
                    contextCambios.fechacambioNueva = "";
                    if( contextCambios.json_audit_cuenta !== undefined && contextCambios.json_audit_cuenta !== "" ){
                        var json_cuenta = JSON.parse(contextCambios.json_audit_cuenta);
                        contextCambios.json_audit_cuenta = json_cuenta;
                        contextCambios.nombrePrevio = json_cuenta.nombre_actual;
                        contextCambios.nombreNuevo = json_cuenta.nombre_por_actualizar;
                        contextCambios.fechacambioNueva = json_cuenta.fecha_cambio;
                        contextCambios.fechacambioPrevia = json_cuenta.fecha_cambio;
                    }

                    if( !_.isEmpty(data) ){
                        var json_direccion = JSON.parse(data[0]);
                        contextCambios.json_audit_direccion = json_direccion;
                        contextCambios.direccionPrevia = json_direccion.direccion_completa_actual;
                        contextCambios.direccionNueva = json_direccion.direccion_completa_por_actualizar;
                        contextCambios.fechacambioNueva = json_direccion.fecha_cambio;
                        contextCambios.fechacambioPrevia = json_direccion.fecha_cambio;
                    }

                    contextCambios.usr_aprobo_rechazo = contextCambios.model.get('usr_aprueba_rechaza_c');
                    contextCambios.id_usr_aprobo_rechazo = contextCambios.model.get('user_id9_c');
                    contextCambios.fecha_aprobo_rechazo = contextCambios.model.get('fecha_aprueba_rechaza_c');

                    contextCambios.render();
                }
            });
        }

    },

    getDireFiscal: function( json_direcciones ){

        var dire_fiscal = {};
        if( json_direcciones.length > 0 ){
            var indicadores_fiscales = [2,3,6,7,10,11,14,15,18,19,22,23,26,27,30,31,34,35,38,39,42,43,46,47,50,51,54,55,58,59,62,63];
            for (let index = 0; index < json_direcciones.length; index++) {
                
                if( indicadores_fiscales.includes( Number(json_direcciones[index]['indicador']) ) && json_direcciones[index]['inactivo'] == 0 ){
                    
                    dire_fiscal = json_direcciones[index];
                    //Index se establece con el indice para salir del ciclo
                    index = json_direcciones.length;

                }
            }
        }

        return dire_fiscal;

    },

    buildFullNameDireccion: function( obj_direccion ){
        //Calle: BATOPILAS, CP: 33400, País: MEXICO, Estado: CHIHUAHUA, Municipio: BATOPILAS, Ciudad: CIUDAD CAMARGO, Colonia: BATOPILAS, Número Exterior: CIUDAD CAMARGO, Número Interior: BATOPILAS
        var calle = obj_direccion['calle'];
        var cp = obj_direccion['valCodigoPostal'];
        var pais = obj_direccion['listPais'][obj_direccion['pais']];
        var estado = obj_direccion['listEstado'][obj_direccion['estado']];
        var municipio = obj_direccion['listMunicipio'][obj_direccion['municipio']];
        var ciudad = obj_direccion['listCiudad'][obj_direccion['ciudad']];
        var colonia = this.searchNameColonia( obj_direccion['colonia'], obj_direccion['listColonia'] );
        var exterior = obj_direccion['numext'];
        var interior = obj_direccion['numint'];

        return "Calle: "+ calle + ", CP: "+ cp + ", País: " + pais +", Estado: "+ estado +", Municipio: "+ municipio +", Ciudad: "+ ciudad +", Colonia: "+ colonia +", Número exterior: "+ exterior +", Número interior: "+ interior;
    },

    searchNameColonia: function ( idColonia, listaColonias ){
        var nombreColonia = "";

        for (let index = 0; index < Object.keys(listaColonias).length; index++) {
            if( listaColonias[index].idColonia == idColonia ){
                nombreColonia = listaColonias[index].nameColonia;

                index = Object.keys(listaColonias).length;
            }
        }

        return nombreColonia;
    }, 

    rechazarCambios: function(e) {

        var elemento =  $(e.currentTarget)[0].nodeName;
        var model = this.context.attributes.model;
        //Validacion para saber desde donde se lanzó la función para cerrar el drawer
        if( elemento === 'BUTTON' ){
            app.alert.show('close_valida_cambios', {
                level: 'confirmation',
                messages: '¿Está seguro que desea rechazar los cambios?',
                autoClose: false,
                onConfirm: function(){
                    $('#btn-rechazar-cambios').attr('disabled',true);
                     //Manda a llamar api custom para resetar banderas y rechazar cambios                
                    app.alert.show('loadingRevert', {
                        level: 'process',
                        title: 'Cargando...',
                    });

                    var elementos_rechazar = {};
                    elementos_rechazar['cuenta']={};
                    elementos_rechazar['direccion']={};
                    elementos_rechazar['idCuenta']= model.attributes.id;
                    elementos_rechazar['direcciones']={};
                    if( contextCambios.json_audit_cuenta !== null ){
                        contextCambios.json_audit_cuenta['id_cuenta']= model.attributes.id;
                        elementos_rechazar['cuenta']= contextCambios.json_audit_cuenta;
                    }
                    if( contextCambios.json_audit_direccion !== null ){
                        elementos_rechazar['direccion']= contextCambios.json_audit_direccion;
                    }
                    if( model.get('json_direccion_audit_c') !== "" && !model.get('direccion_actualizada_api_c') ){
                        elementos_rechazar['direcciones']= JSON.parse( model.get('json_direccion_audit_c') );
                    }
                    var url = app.api.buildURL('RechazarCambiosRazonSocialDireFiscal', null, null,);
                    app.api.call('create', url, elementos_rechazar, {
                        success: function (data) {
                            app.alert.show('revertExitoso', {
                                level: 'info',
                                messages: 'Los cambios han sido rechazados',
                                autoClose: true
                            });

                            app.alert.dismiss('loadingRevert');
                            $('#btn-rechazar-cambios').removeAttr('disabled');
                            
                            var modal = $('#myModalVerificaCambios');
                            if (modal) {
                                modal.hide();
                            }
                            app.drawer.close(contextCambios.context,contextCambios.model,"update");
                        }
                    });

                },
                onCancel: function(){
                   app.alert.dismiss('close_valida_cambios');
                }
            });

        }else{
            //Se ejecuta acción proveniente del icono "x", el cual solo cierra el drawer
            var modal = $('#myModalVerificaCambios');
            if (modal) {
                modal.hide();
            }
            app.drawer.close();

        }
    },

    aprobarCambios: function(e){
        
        var model = this.context.attributes.model;
        app.alert.show('alert_aprobar_cambios', {
            level: 'confirmation',
            messages: '¿Está seguro que desea aprobar los cambios?',
            autoClose: false,
            onConfirm: function(){
                $('#btn-aprobar-cambios').attr('disabled',true);

                var elementos = {};
                elementos['idCuenta']= model.attributes.id;
                elementos['cuenta']={};
                elementos['direccion']={};
                elementos['direcciones']={};
                if( contextCambios.json_audit_cuenta !== null ){
                    contextCambios.json_audit_cuenta['id_cuenta']= model.attributes.id;
                    elementos['cuenta']= contextCambios.json_audit_cuenta;
                }
                if( contextCambios.json_audit_direccion !== null ){
                    elementos['direccion']= contextCambios.json_audit_direccion;
                }

                if( model.get('json_direccion_audit_c') !== "" && !model.get('direccion_actualizada_api_c') ){
                    elementos['direcciones']= JSON.parse( model.get('json_direccion_audit_c') );
                }

                app.alert.show('loadingAprobar', {
                    level: 'process',
                    title: 'Cargando...',
                });
                var url = app.api.buildURL('AprobarCambiosRazonSocialDireFiscal', null, null,);
                    app.api.call('create', url, elementos, {
                        success: function (data) {
                            app.alert.show('revertExitoso', {
                                level: 'success',
                                messages: 'Los valores se han guardado correctamente',
                                autoClose: true
                            });

                            app.alert.dismiss('loadingAprobar');
                            $('#btn-aprobar-cambios').removeAttr('disabled');
                            
                            var modal = $('#myModalVerificaCambios');
                            if (modal) {
                                modal.hide();
                            }
                            app.drawer.close(contextCambios.context,contextCambios.model,"update");
                        }
                    });
                
            },
            onCancel: function(){
               app.alert.dismiss('alert_aprobar_cambios');
            }
        });
        
    },

})