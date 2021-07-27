({
    plugins: ['Dashlet'],

    events: {
        'click #assign_cp': 'asignarCP',
        'click #assign_asesor': 'asignarPorAsesor',
        'click #assign_bd': 'asignarPorBD',
        'click #assign_cancel': 'asignarPorCancelados',
        'click .modalRecordsCancel': 'closeModal',
        'click .btnLeadSelect': 'activarLead',

    },

    registros: [],

    initialize: function (options) {
        this._super("initialize", [options]);
        self = this;
        this.viewEnable = false;
        this.numero_registros = 0;
        this.limite_asignacion = 0;
        this.getRegistrosAsignados();

        //this.getLeadsAplazadosCancelados();
    },

    /*
    Función ejecutada para saber si la información se debe de mostrar
    */
    getRegistrosAsignados: function () {

        var id_user = App.user.attributes.id;
        App.alert.show('obtieneAsignados', {
            level: 'process',
            title: 'Cargando',
        });

        app.api.call('GET', app.api.buildURL('GetRegistrosAsignadosForProtocolo/' + id_user), null, {
            success: function (data) {
                App.alert.dismiss('obtieneAsignados');

                var maximo_registros_list = App.lang.getAppListStrings('limite_maximo_asignados_list');
                var limitePersonal = (App.user.attributes.limite_asignacion_lm_c > 0) ? App.user.attributes.limite_asignacion_lm_c : 0;
                var maximo_registros = (limitePersonal > 0) ? limitePersonal : parseInt(maximo_registros_list["1"]);
                self.numero_registros = data.total_asignados;
                self.limite_asignacion = maximo_registros;
                if (data.total_asignados < maximo_registros) { //Las opciones de protocolo solo serán visibles cuando el usuario tiene menos de 20 registros asignados
                    self.viewEnable = '1';
                    self.getLeadsAplazadosCancelados();
                } else {
                    self.viewEnable = false;
                    self.render();
                }
            },
            error: function (e) {
                throw e;
            }
        });

    },

    asignarCP: function (evt) {

        app.alert.show('navigateToNotificationCP', {
            level: 'confirmation',
            messages: 'Se notificará al Asesor Telefónico para que se le asigne un nuevo Lead',
            autoClose: false,
            onConfirm: function () {
                App.alert.show('asignaLeadCP', {
                    level: 'process',
                    title: 'Procesando',
                });
                //Obtener los agentes telefónicos disponibles para generarle el registro de tarea
                // app.api.call("read", app.api.buildURL("GetSiguienteAgenteTel", null, null, {}), null, {
                app.api.call('GET', app.api.buildURL('GetAgenteCP/'), null, {
                    success: _.bind(function (data) {
                        var idAsesor = data.idAsesor;
                        var tmpfechaFin = data.fechaFin; 
                        var today = new Date();                       
                        var hora = today.getHours();
                        if (hora < 10) { hora = '0' + hora }
                        todayFormat = tmpfechaFin+"T"+hora+":"+"00"+":"+"00";
                        var todayISO = new Date(todayFormat);
                        var fechaFin = todayISO.toISOString();  //OBTIENE LA FECHA CON EL FORMATO DATE_TIME
                        var usuario = App.user.get('full_name');
                        var jsonDate = (new Date()).toJSON();

                        if (idAsesor != "" && idAsesor != null) {

                            var bodyTask = {
                                "name": "Solicitud de asignación de Lead/Cuenta - (Lead Management)",
                                "date_start": jsonDate,
                                "date_due": fechaFin,
                                "priority": "High",
                                "status": "Not Started",
                                "assigned_user_id": idAsesor,
                                "description": "Se solicita la asignación de Lead para asesor " + usuario
                            };
                            
                            app.api.call("create", app.api.buildURL("Tasks", null, null, bodyTask), null, {
                                success: _.bind(function (data) {
                                    console.log("TAREA CREADA CORRECTAMENTE AL ASESOR");
                                    App.alert.dismiss('asignaLeadCP');
                                    app.alert.show('taskCreteSuccess', {
                                        level: 'success',
                                        messages: 'Proceso completo<br>El agente encargado de gestionar la asignación es: <b>' + data.assigned_user_name,
                                        autoClose: false
                                    });

                                }, this)
                            });

                        } else {

                            App.alert.dismiss('asignaLeadCP');
                            app.alert.show('message-idAgente-CP', {
                                level: 'warning',
                                messages: 'Por el momento no se tienen Agentes disponibles para asignación. Por favor, intenta más tarde...',
                                autoClose: false
                            });
                        }

                    }, this)
                });
            },
            onCancel: function () { }
        });
    },

    asignarPorAsesor: function (evt) {

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

    asignarPorBD: function () {

        //Obtiene registros cargados a través de carga de layout
        app.alert.show('assignLeadFromDB', {
            level: 'confirmation',
            messages: 'Se asignará un Lead obtenido de una base de datos especial<br>¿Está seguro?',
            autoClose: false,
            onConfirm: function () {
                //Obtiene registros provenientes de la bd especial
                App.alert.show('asignaFromDB', {
                    level: 'process',
                    title: 'Procesando',
                });

                var equipo_usuario_logueado = App.user.attributes.equipo_c;

                app.api.call("read", app.api.buildURL("FilterLeadsToDB/" + equipo_usuario_logueado, null, null, null), null, {
                    success: _.bind(function (data) {

                        if (data.records.length > 0) {
                            //Actualizar lead desde potocolo, se hace desde api custom, para saltarse la seguridad de equipo
                            //y no se genere error al obtener registros que no estén asignados al asesor
                            var idRegistro = data.records[0].idRegistro;
                            self.modulo = data.records[0].modulo;
                            var id_usuario = App.user.get('id');

                            app.api.call("read", app.api.buildURL("UpdateLeadFromProtocolo/" + idRegistro + "/" + id_usuario + "/" + self.modulo, null, null, null), null, {
                                success: _.bind(function (data) {
                                    var moduleLink = "";
                                    if (self.modulo == "Cuenta") {
                                        moduleLink = "Accounts"
                                    } else {
                                        moduleLink = "Leads"
                                    }
                                    app.alert.dismiss('asignaFromDB');
                                    var modulo
                                    var mensaje = 'Se ha asignado el registro: ' + '<a href="#' + moduleLink + '/' + data.id + '">' + data.name + '</a>';

                                    app.alert.show('assignFromDB', {
                                        level: 'success',
                                        messages: mensaje,
                                    });
                                    self.numero_registros++
                                    self.viewEnable = (self.numero_registros >= self.limite_asignacion) ? 0 : self.viewEnable;
                                    self.render();

                                }, this)
                            })
                        } else {

                            app.alert.show('sinRegistrosDB', {
                                level: 'warning',
                                messages: 'No existen registros disponibles para asignar',
                                autoClose: true
                            });

                            app.alert.dismiss('asignaFromDB');
                            self.render();
                        }

                    }, this)
                });//Fin api call obtener registros de la bd

            },//OnConfirm
            onCancel: function () {

            }//onCancel
        });
    },

    asignarPorCancelados: function () {

        if (this.registros.length == 0) {
            app.alert.show('sinCancelados', {
                level: 'warning',
                messages: 'No existen registros de Leads Cancelados / Aplazados',
                autoClose: true
            });

        }
        else {
            var modal = $('#modalRecordsCancel');
            if (modal) {
                modal.show();
            }
        }

    },

    closeModal: function () {

        var modal = $('#modalRecordsCancel');
        if (modal) {
            modal.hide();
        }
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

                            var indice = self.searchIndex(self.registros, id);
                            self.registros.splice(indice, 1);
                            self.numero_registros++
                            self.viewEnable = (self.numero_registros >= self.limite_asignacion) ? 0 : self.viewEnable;
                            self.render();
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

                            var indice = self.searchIndex(self.registros, id);
                            self.registros.splice(indice, 1);
                            self.numero_registros++
                            self.viewEnable = (self.numero_registros >= self.limite_asignacion) ? 0 : self.viewEnable;
                            self.render();
                        })
                    });

                }
            },
            onCancel: function () {

            }
        });

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

    getLeadsAplazadosCancelados: function () {

        var id_user = App.user.attributes.id;

        App.alert.show('getLeadsCancelados', {
            level: 'process'
        });

        //subtipo_registro_c=3, LEAD CANCELADO
        app.api.call('GET', app.api.buildURL('GetLeadsAccountsAplazadosCancelados/' + id_user), null, {
            success: function (data) {
                App.alert.dismiss('getLeadsCancelados');
                self.registros = data.records;
                self.render();
            },
            error: function (e) {
                App.alert.dismiss('getLeadsCancelados');
                throw e;
            }
        });


    },

    _render: function () {
        this._super("_render");

    },

})
