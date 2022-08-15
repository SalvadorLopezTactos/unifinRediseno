({
    className: 'client_manager_asigna-perdidos',
    registros:0,
    registrosPerdidos: [],
    viewEnableLost:false,

    events: {
        'click #clientePerdido': 'asignarPorPerdido',
        'click .modalRecordsLost': 'closeModal_L',
        'click .btnLeadLostSelect': 'reactivarLead',
    },

    initialize: function (options) {
        this._super("initialize", [options]);
        self_lost = this;
        self_lost.registrosPerdidos=this.context.get('myData');
        //self_asigna = this;
        self_lost.registros = self_asigna.registros;

        var posicion_operativa = App.user.attributes.posicion_operativa_c;
        this.viewEnableLost = posicion_operativa.indexOf("3")>=0 ? true:false;
        //this.getRegistrosAsignados();
    },

    _render: function () {
        this._super("_render");

    },

    asignarPorPerdido: function () {
        if (this.registrosPerdidos.length == 0) {
            app.alert.show('sinPerdidos', {
                level: 'warning',
                messages: 'No existen registros de Cuentas Perdidos',
                autoClose: true
            });
        }else {
            /*var modal_L = $('#modalRecordsLost');
            if (modal_L) {
                modal_L.show();
            }*/
            app.drawer.open({
                layout: 'client_manager_asigna-perdidos',
                context: {
                    myData: this.registrosPerdidos
                },
            },function() {
            });
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
                    //self_asigna.getLeadsAplazadosCancelados();
                    //self_asigna.getLeadsPerdidos();
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

    closeModal_L: function () {
        app.drawer.close();
        /*var modal = $('#modalRecordsCancel');
        if (modal) {
            modal.hide();
        }*/
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
                    this.modulo = "Lead";
                }else{
                    this.modulo = "Cuenta";
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
                
                app.api.call("read", app.api.buildURL("UpdateLeadFromProtocolo/" + id + "/" + id_user + "/" + this.modulo, null, null, null), null, {
                    success: _.bind(function (data) {
                        var moduleLink = "";
                        if (this.modulo == "Cuenta") {
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
                        self.numero_registros++
                        self.viewEnableLost = (self.numero_registros >= self.limite_asignacion) ? 0 : self.viewEnableLost;
                        self_lost.render();

                    }, self_lost)
                });
            },
            onCancel: function () {

            }
        });
    },

})
