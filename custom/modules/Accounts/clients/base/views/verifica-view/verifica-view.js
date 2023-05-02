({
    className: 'verifica-view',

    events: {
        'click #btn-rechazar-cambios': 'rechazarCambios',
        'click #btn-aprobar-cambios': 'aprobarCambios',
        'click .closeModalVerificaCambios': 'rechazarCambios',
    },

    nombrePrevio: null,
    direccionPrevia: null,
    fechacambioPrevia: null,
    nombreNuevo: null,
    direccionNueva: null,
    fechacambioNueva: null,

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
                        contextCambios.nombrePrevio = json_cuenta.nombre_actual;
                        contextCambios.nombreNuevo = json_cuenta.nombre_por_actualizar;
                        contextCambios.fechacambioNueva = json_cuenta.fecha_cambio;
                        contextCambios.fechacambioPrevia = json_cuenta.fecha_cambio;
                    }

                    if( !_.isEmpty(data) ){
                        var json_direccion = JSON.parse(data[0]);
                        contextCambios.direccionPrevia = json_direccion.direccion_completa_actual;
                        contextCambios.direccionNueva = json_direccion.direccion_completa_por_actualizar;
                        contextCambios.fechacambioNueva = json_direccion.fecha_cambio;
                        contextCambios.fechacambioPrevia = json_direccion.fecha_cambio;
                    }

                   contextCambios.render();
                }
            });
        
    },

    rechazarCambios: function(e) {

        var elemento =  $(e.currentTarget)[0].nodeName;
        //Validacion para saber desde donde se lanzó la función para cerrar el drawer
        if( elemento === 'BUTTON' ){
            app.alert.show('close_valida_cambios', {
                level: 'confirmation',
                messages: '¿Está seguro que desea rechazar los cambios?',
                autoClose: false,
                onConfirm: function(){
                     //Obtiene valores anteriores y estblece nuevos valores en el modelo
                    var idCuenta = contextCambios.context.attributes.model.attributes.id;
                    
                    app.alert.show('loadingRevert', {
                        level: 'process',
                        title: 'Cargando...',
                    });
            
                    var url = app.api.buildURL('revierteCambiosRazonSocialDireFiscal/' + idCuenta, null, null,);
                    app.api.call('GET', url, {}, {
                        success: function (data) {
                            app.alert.show('revertExitoso', {
                                level: 'success',
                                messages: 'Los valores se han reestablecido correctamente',
                                autoClose: true
                            });

                            app.alert.dismiss('loadingRevert');
                            
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
                model.set('valid_cambio_razon_social_c', false);
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
                
            },
            onCancel: function(){
               app.alert.dismiss('alert_aprobar_cambios');
            }
        });
        
    }
})