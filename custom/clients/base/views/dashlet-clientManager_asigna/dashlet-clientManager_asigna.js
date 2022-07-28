({
    plugins: ['Dashlet'],
    registros:0,
    registrosAplazados: [],
    registrosPerdidos: [],

    events: {
        'click #crear_lead': 'crearLead',
        'click #asignaCancelados': 'asignarPorCancelados',
        'click #clientePerdido': 'asignarPorPerdido',
        'click .modalRecordsCancel': 'closeModal',
        'click .modalRecordsLost': 'closeModal_L',
        'click .btnLeadSelect': 'activarLead',
        'click .btnLeadLostSelect': 'reactivarLead',
    },

    initialize: function (options) {
        this._super("initialize", [options]);
        self_asigna = this;
        self_asigna.registros = 0;

        var posicion_operativa = App.user.attributes.posicion_operativa_c;
        self_asigna.viewEnable = posicion_operativa.indexOf("3")>=0 ? true:false;
        this.getRegistrosAsignados();
    },

    _render: function () {
        this._super("_render");

    },

    crearLead: function (evt) {
        var objLead = {
            action: 'edit',
            copy: true,
            create: true,
            layout: 'create',
            module: 'Leads',
            dataFromProtocolo: '1'
        };

        app.controller.loadView(objLead);
        // update the browser URL with the proper
        app.router.navigate('#Leads/create', { trigger: false });
    },

    asignarPorCancelados: function () {
        if (this.registrosAplazados.length == 0) {
            app.alert.show('sinCancelados', {
                level: 'warning',
                messages: 'No existen registros de Leads Cancelados / Aplazados',
                autoClose: true
            });
        }else {
            var modal = $('#modalRecordsCancel');
            if (modal) {
                modal.show();
            }
        }
    },

    asignarPorPerdido: function () {
        if (this.registrosPerdidos.length == 0) {
            app.alert.show('sinPerdidos', {
                level: 'warning',
                messages: 'No existen registros de Cuentas Perdidos',
                autoClose: true
            });
        }else {
            var modal_L = $('#modalRecordsLost');
            if (modal_L) {
                modal_L.show();
            }
        }
    },

    /*
    Función ejecutada para saber si la información se debe de mostrar
    */
    getRegistrosAsignados: function () {

        var id_user = App.user.attributes.id;
        
        app.api.call('GET', app.api.buildURL('GetRegistrosAsignadosForProtocolo/' + id_user), null, {
            success: function (data) {
                //App.alert.dismiss('obtieneAsignados');
                var maximo_registros_list = App.lang.getAppListStrings('limite_maximo_asignados_list');
                var limitePersonal = (App.user.attributes.limite_asignacion_lm_c > 0) ? App.user.attributes.limite_asignacion_lm_c : 0;
                var maximo_registros = (limitePersonal > 0) ? limitePersonal : parseInt(maximo_registros_list["1"]);
                self_asigna.registros = data.total_asignados;
                console.log(self_asigna.registros);
                self_asigna.limite_asignacion = maximo_registros;
                if (data.total_asignados < maximo_registros) { //Las opciones de protocolo solo serán visibles cuando el usuario tiene menos de 20 registros asignados
                    self_asigna.viewEnable = true;
                    self_asigna.getLeadsAplazadosCancelados();
                    self_asigna.getLeadsPerdidos();
                } else {
                    self_asigna.viewEnable = false;
                    self_asigna.render();
                }
            },
            error: function (e) {
                throw e;
            }
        });
    },

    getLeadsAplazadosCancelados: function () {
        var id_user = App.user.attributes.id;
        App.alert.show('getLeadsCancelados', {
            level: 'process'
        });

        //subtipo_registro_c=3, LEAD CANCELADO
        app.api.call('GET', app.api.buildURL('GetLeadsAccountsAplazadosCancelados/' + id_user), null, {
            success: function (data) {
                App.alert.dismiss('getLeadsCancelados');
                self_asigna.registrosAplazados = data.records;
                self_asigna.render();
            },
            error: function (e) {
                App.alert.dismiss('getLeadsCancelados');
                throw e;
            }
        });
    },

    getLeadsPerdidos: function () {
        var id_user = App.user.attributes.id;
        App.alert.show('getLeadsPerdidos', {
            level: 'process'
        });

        app.api.call('GET', app.api.buildURL('GetLeadsAccountsPerdidos/' + id_user), null, {
            success: function (data) {
                App.alert.dismiss('getLeadsPerdidos');
                self_asigna.registrosPerdidos = data.records;
                self_asigna.render();
            },
            error: function (e) {
                App.alert.dismiss('getLeadsPerdidos');
                throw e;
            }
        });
    },

    closeModal: function () {

        var modal = $('#modalRecordsCancel');
        if (modal) {
            modal.hide();
        }
    },

    closeModal_L: function () {

        var modal_L = $('#modalRecordsLost');
        if (modal_L) {
            modal_L.hide();
        }
    },

    searchIndex: function (arreglo, id) {

        var index = -1;

        if (arreglo.length > 0) {

            for (var i = 0; i < arreglo.length; i++) {
                if (arreglo[i].id == id) {
                    index = i;
                }
            }
        }
        return index;
    },

    activarLead: function (evt) {

        var nombre = $(evt.currentTarget).parent().parent().children().eq(0).children().html();
        var id = $(evt.currentTarget).attr('data-id');
        var tipo = $(evt.currentTarget).attr('data-type');
        var idProducto = $(evt.currentTarget).attr('data-product');

        var hoy = new Date();
        var dia = hoy.getDate();
        var mmes = hoy.getMonth() + 1;
        var anio = hoy.getFullYear();
        if (dia < 10) { dia = '0' + dia }
        if (mmes < 10) { mmes = '0' + mmes }
        FechaAsignacion = anio + '-' + mmes + '-' + dia;

        app.alert.show('confirmActivation', {
            level: 'confirmation',
            messages: 'Se procederá a activar el siguiente registro:<br>' + nombre + '<br>¿Estás seguro?',
            autoClose: false,
            onConfirm: function () {
                if (tipo == 'lead') {
                    var url = app.api.buildURL('Leads/' + id, null, null);

                    App.alert.show('activaLead', {
                        level: 'process',
                        title: 'Activando registro, por favor espere',
                    });

                    var api_params = {};
                    api_params['lead_cancelado_c'] = 0;
                    api_params['motivo_cancelacion_c'] = "";
                    api_params['status_management_c'] = "1";//Activo
                    api_params['subtipo_registro_c'] = "1";//Sin Contactar
                    api_params['metodo_asignacion_lm_c'] = "4"; //Metodo de Asignación LM - 4.- Reactivación Cancelado / Aplazado
                    api_params['fecha_asignacion_c'] = FechaAsignacion;

                    app.api.call('update', url, api_params, {
                        success: _.bind(function (data) {
                            app.alert.dismiss('activaLead');

                            var mensaje = 'Se ha actualizado el Lead: ' + '<a href="#Leads/' + data.id + '">' + data.name + '</a>';

                            app.alert.show('activaLeadSuccess', {
                                level: 'success',
                                messages: mensaje,
                            });

                            var indice = self_asigna.searchIndex(self_asigna.registros, id);
                            self_asigna.registros.splice(indice, 1);
                            self_asigna.numero_registros++
                            self_asigna.viewEnable = (self_asigna.numero_registros >= self_asigna.limite_asignacion) ? 0 : self_asigna.viewEnable;
                            self_asigna.render();
                        })
                    });
                } else {
                    //Activar cuenta
                    var url = app.api.buildURL('uni_Productos/' + idProducto, null, null);

                    App.alert.show('activaCuenta', {
                        level: 'process',
                        title: 'Activando registro, por favor espere',
                    });

                    var api_params = {};
                    api_params['no_viable'] = 0;
                    api_params['no_viable_razon'] = "";
                    api_params['no_viable_razon_fp'] = "";
                    api_params['no_viable_razon_ni'] = "";
                    api_params['no_viable_producto'] = "";
                    api_params['no_viable_otro_c'] = "";
                    api_params['no_viable_quien'] = "";
                    api_params['no_viable_porque'] = "";
                    api_params['status_management_c'] = "1";
                    api_params['metodo_asignacion_lm_c'] = "4"; //Metodo de Asignación LM - 4.- Reactivación Cancelado / Aplazado
                    api_params['fecha_asignacion_c'] = FechaAsignacion; 

                    app.api.call('update', url, api_params, {
                        success: _.bind(function (data) {
                            app.alert.dismiss('activaCuenta');

                            var mensaje = 'Se ha actualizado el registro: ' + '<a href="#Accounts/' + data.accounts_uni_productos_1accounts_ida + '">' + data.accounts_uni_productos_1_name + '</a>';

                            app.alert.show('activaCuentaSuccess', {
                                level: 'success',
                                messages: mensaje,
                            });

                            var indice = self_asigna.searchIndex(self_asigna.registros, id);
                            self_asigna.registros.splice(indice, 1);
                            self_asigna.numero_registros++
                            self_asigna.viewEnable = (self_asigna.numero_registros >= self_asigna.limite_asignacion) ? 0 : self_asigna.viewEnable;
                            self_asigna.render();
                        })
                    });

                }
            },
            onCancel: function () {

            }
        });
    },

    reactivarLead: function (evt) {

        var nombre = $(evt.currentTarget).parent().parent().children().eq(0).children().html();
        var id = $(evt.currentTarget).attr('data-id');
        var tipo = $(evt.currentTarget).attr('data-type');
        var idProducto = $(evt.currentTarget).attr('data-product');
        var id_user = App.user.attributes.id;

        var hoy = new Date();
        var dia = hoy.getDate();
        var mmes = hoy.getMonth() + 1;
        var anio = hoy.getFullYear();
        if (dia < 10) { dia = '0' + dia }
        if (mmes < 10) { mmes = '0' + mmes }
        FechaAsignacion = anio + '-' + mmes + '-' + dia;

        app.alert.show('confirmActivation', {
            level: 'confirmation',
            messages: 'Se procederá a activar el siguiente registro:<br>' + nombre + '<br>¿Estás seguro?',
            autoClose: false,
            onConfirm: function () {
                if (tipo == 'lead') {
                    self_asigna.modulo = "Lead";
                }else{
                    self_asigna.modulo = "Cuenta";
                }
                
                App.alert.show('activaLead', {
                    level: 'process',
                    title: 'Activando registro, por favor espere',
                });

                var api_params = {};
                api_params['lead_cancelado_c'] = 0;
                api_params['motivo_cancelacion_c'] = "";
                api_params['status_management_c'] = "1";//Activo
                api_params['subtipo_registro_c'] = "1";//Sin Contactar
                api_params['metodo_asignacion_lm_c'] = "4"; //Metodo de Asignación LM - 4.- Reactivación Cancelado / Aplazado
                api_params['fecha_asignacion_c'] = FechaAsignacion;
                
                app.api.call("read", app.api.buildURL("UpdateLeadFromProtocolo/" + id + "/" + id_user + "/" + self_asigna.modulo, null, null, null), null, {
                    success: _.bind(function (data) {
                        var moduleLink = "";
                        if (self_asigna.modulo == "Cuenta") {
                            moduleLink = "Accounts"
                        } else {
                            moduleLink = "Leads"
                        }
                        app.alert.dismiss('activaLead');
                        var mensaje = 'Se ha asignado el registro: ' + '<a href="#' + moduleLink + '/' + data.id + '">' + data.name + '</a>';

                        app.alert.show('assignFromDB', {
                            level: 'success',
                            messages: mensaje,
                        });
                        self_asigna.numero_registros++
                        self_asigna.viewEnable = (self_asigna.numero_registros >= self_asigna.limite_asignacion) ? 0 : self_asigna.viewEnable;
                        self_asigna.render();

                    }, this)
                });
            },
            onCancel: function () {

            }
        });
    },

})
