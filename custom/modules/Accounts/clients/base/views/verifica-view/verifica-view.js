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
        if( idCuenta !== undefined ){
            this.getCambiosDetectados(idCuenta,json_audit_cuenta);
        }
    },
    
    getCambiosDetectados: function(idCuenta,json_audit_cuenta){
        this.json_audit_cuenta = json_audit_cuenta;
        contextCambios = this;

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
                    if( contextCambios.json_audit_cuenta !== undefined ){
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
                    if( contextCambios.json_audit_cuenta !== null ){
                        contextCambios.json_audit_cuenta['id_cuenta']= model.attributes.id;
                        elementos_rechazar['cuenta']= contextCambios.json_audit_cuenta;
                    }
                    if( contextCambios.json_audit_direccion !== null ){
                        elementos_rechazar['direccion']= contextCambios.json_audit_direccion;
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
                elementos['cuenta']={};
                elementos['direccion']={};
                if( contextCambios.json_audit_cuenta !== null ){
                    contextCambios.json_audit_cuenta['id_cuenta']= model.attributes.id;
                    elementos['cuenta']= contextCambios.json_audit_cuenta;
                }
                if( contextCambios.json_audit_direccion !== null ){
                    elementos['direccion']= contextCambios.json_audit_direccion;
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
                
                
                /*
                model.save({}, {
                    showAlerts: true,
                    success:function (data) {
                        $('#btn-aprobar-cambios').removeAttr('disabled');
                        var modal = $('#myModalVerificaCambios');
                        if (modal) {
                            modal.hide();
                        }
                        app.drawer.close();
                    }
                });
                */
            },
            onCancel: function(){
               app.alert.dismiss('alert_aprobar_cambios');
            }
        });
        
    },

})