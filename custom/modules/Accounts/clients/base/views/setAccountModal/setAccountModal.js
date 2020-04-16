/**
 * @class View.Views.Base.QuickCreateView
 * @alias SUGAR.App.view.views.BaseQuickCreateView
 * @extends View.Views.Base.BaseeditmodalView
 */
({
    extendsFrom: 'BaseeditmodalView',
    fallbackFieldTemplate: 'edit',
    prod_list: null,
    events: {
        'click #btn-cancela': 'closeModal',
        'click #btn-asigna': 'assignedAccount',
    },

    context_Account: null,
    respuesta_msj: "",
    initialize: function (options) {
        self_modal = this;
        app.view.View.prototype.initialize.call(this, options);
        if (this.layout) {
            this.layout.on('app:view:setAccountModal', function () {

                $('#e6').select2('val', "");
                var newContext = options.context.get('model');
                var list_html = this.create_list_options(newContext);

                this.prod_list = list_html;
                this.context_Account = options;
                console.log(this.context_Account);
                if (list_html != '<option value="" >  </option>') {

                    app.alert.show('reasignando_modal_dos', {
                        level: 'process',
                        title: 'Cargando...'
                    });

                    app.api.call("GET", app.api.buildURL("Users/?fields=id,full_name,equipo_c&max_num=-1", null, null, {}), null, {
                        success: _.bind(function (data) {
                            app.alert.dismiss('reasignando_modal_dos');

                            self_modal.list_filter_usr = data.records;

                            self_modal.render();
                            self_modal.$('.modal').modal({
                                backdrop: ''
                            });
                            self_modal.$('.modal').modal('show');
                            $('.datepicker').css('z-index', '2000px');
                            app.$contentEl.attr('aria-hidden', true);
                            $('.modal-backdrop').insertAfter($('.modal'));

                        }, this)
                    });


                } else {
                    //alert
                    app.alert.show("Sin privilegios", {
                        level: "error",
                        title: "La cuenta no puede ser asignada a su nombre dado que hay actividad vigente del propietario actual, y si desea dicha cuenta, debe validarlo  el área correspondiente.",
                        autoClose: false
                    });
                }
                /**If any validation error occurs, system will throw error and we need to enable the buttons back*/
                this.context.get('model').on('error:validation', function () {
                    this.disableButtons(false);
                }, this);
            }, this);
        }
        this.bindDataChange();




    },

    // forms range
    _renderHtml: function () {
        this._super('_renderHtml');
        self_render=this;
        $("#e6").select2({
            placeholder: "Selecciona un Asesor",
            minimumInputLength: 1,

            data:{ results: self_render.list_filter_usr, text: 'full_name' },


            formatResult: function(m) { return m.full_name; },
            formatSelection: function(m) { return m.full_name; }
        });
    },
    create_list_options: function (objContext) {
        var temp_prod = (app.user.attributes.productos_c).replace(/\^/g, "");
        var userprod = temp_prod.split(",");
        var productos = app.lang.getAppListStrings('tipo_producto_list');
        var context360 = v360.ResumenCliente; // contiene la información vista 360
        var userpuesto = app.user.attributes.puestousuario_c;
        var product_dispo = ['1', '3', '4', '6', '8'];
        var id_user = app.user.id; //id de usuario firmado
        var list_html = "";
        if (userpuesto == "27") {
            list_html = '<option value="" >  </option>';
            _.each(productos, function (value, key) {
                if (product_dispo.includes(key)) {

                    switch (key) {
                        case "1":
                            if (cont_uni_p.ResumenProductos.leasing.dias > 30) {
                                list_html += '<option value="' + key + '">' + productos[key] + '</option>';
                            }
                            break;
                        case "3":
                            if (cont_uni_p.ResumenProductos.credito_auto.dias > 30) {
                                list_html += '<option value="' + key + '">' + productos[key] + '</option>';
                            }
                            break;
                        case "4":
                            if (cont_uni_p.ResumenProductos.factoring.dias > 30) {
                                list_html += '<option value="' + key + '">' + productos[key] + '</option>';
                            }
                            break;
                        case "6":
                            if (cont_uni_p.ResumenProductos.fleet.dias > 30) {
                                list_html += '<option value="' + key + '">' + productos[key] + '</option>';
                            }
                            break;
                        case "8":
                            if (cont_uni_p.ResumenProductos.uniclick.dias > 30) {
                                list_html += '<option value="' + key + '">' + productos[key] + '</option>';
                            }
                            break;

                    }


                }
            });
        } else {
            var temp_array = [];
            _.each(userprod, function (value, key) {
                console.log("valor" + value + " llave " + key);
                switch (value) {
                    case "1": // LEASING
                        var leasing_id = objContext.attributes.user_id_c; // id user producto cuenta
                        var leasig_status = context360.leasing.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido

                        if (!self_modal.validate_no_nueve(leasing_id)) {
                            var result = self_modal.validate_product_list(leasing_id, leasig_status, id_user);
                            if (result['status']) {
                                temp_array.push(value);
                            }
                        }
                        break;
                    case '3': //Credito-Automotriz
                        var credito_id = objContext.attributes.user_id2_c; // id user producto cuenta
                        var leasig_status = context360.credito_auto.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido

                        if (!self_modal.validate_no_nueve(credito_id)) {
                            var result = self_modal.validate_product_list(credito_id, leasig_status, id_user);
                            if (result['status']) {
                                temp_array.push(value);
                            }
                        }
                        break;

                    case '4': // FACTORAJE
                        var factoraje_id = objContext.attributes.user_id1_c; // id user producto cuenta
                        var leasig_status = context360.factoring.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido

                        if (!self_modal.validate_no_nueve(factoraje_id)) {
                            var result = self_modal.validate_product_list(factoraje_id, leasig_status, id_user);
                            if (result['status']) {
                                temp_array.push(value);
                            }
                        }
                        break;

                    case '6': // FLEET
                        var fleet_id = objContext.attributes.user_id6_c; // id user producto cuenta
                        var leasig_status = context360.fleet.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido

                        if (!self_modal.validate_no_nueve(fleet_id)) {
                            var result = self_modal.validate_product_list(fleet_id, leasig_status, id_user);
                            if (result['status']) {
                                temp_array.push(value);
                            }
                        }
                        break;

                    case '8': // UNICLICK
                        var uniclick_id = objContext.attributes.user_id7_c; // id user producto cuenta
                        var leasig_status = context360.uniclick.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido

                        if (!self_modal.validate_no_nueve(uniclick_id)) {
                            var result = self_modal.validate_product_list(uniclick_id, leasig_status, id_user);
                            if (result['status']) {
                                temp_array.push(value);
                            }
                        }
                        break;
                }
            })
            list_html = '<option value="" >  </option>';
            _.each(productos, function (value, key) {
                if (temp_array.includes(key)) {
                    list_html += '<option value="' + key + '">' + productos[key] + '</option>';
                }
            });
        }
        return list_html;
    },

    /** Valida que el id del producto no se ninguno del tipo 9 sin gestor**/
    validate_no_nueve: function (id_producto) {
        var bandera = false;
        var id_user_black = ['405cc6b7-fc4a-7cae-552f-5628f61fd849', // moroso
            '36af9462-37e6-11ea-baed-a44e314beb18', // bloqueado
            '569246c7-da62-4664-ef2a-5628f649537e', // sin gestor
            '28f5b8b8-ab06-6bfd-dc85-5628f6e9f411', // Perdido
            '42ee17c4-f67a-11e9-9711-00155d96730d', // express
            'cc736f7a-4f5f-11e9-856a-a0481cdf89eb' // no viable
        ];

        if (id_user_black.includes(id_producto)) {
            bandera = true;
        }
        return bandera;
    },

    validate_product_list: function (id_producto, status_producto, user_id) {
        exito = {'status': false, 'mensaje': ""};
        if (user_id == id_producto) {
            exito['status'] = true;
            exito['mensaje'] = "Asignar cuenta";

        }
        else {
            console.log("Este productos no te pertenece");
            exito['status'] = false;
            exito['mensaje'] = "Este productos no te pertenece";
        }
        return exito;
    },

    validate_product: function (id_producto, status_producto, user_id) {
        exito = {'status': false, 'mensaje': ""};
        if (user_id == id_producto) {
            if (status_producto == "2") {
                exito['status'] = true;
                exito['mensaje'] = "Asignar cuenta";
            }
            else {
                console.log("No cuentas con los privilegios para operar esta Cuenta");
                exito['status'] = false;
                exito['mensaje'] = "No cuentas con los privilegios para operar esta Cuenta";
            }
        }
        else {
            console.log("Este productos no te pertenece");
            exito['status'] = false;
            exito['mensaje'] = "Este productos no te pertenece";
        }
        return exito;
    },

    assignedAccount: function () {
        var contextModal = this;
        var modalAccount = this.context_Account; // contiene información de la cuenta

        var prod_select = $('#productos').val(); // producto seleccionada
        var user_select = $('#e6').select2('val') ;// usuario seleccionada
        var cuenta_id = modalAccount.context.get('model').attributes.id;
        console.log(user_select);

        if (prod_select != "" && user_select != "" && !contextModal.validate_no_nueve(user_select)) {

            var usuario = App.data.createBean('Users');
            usuario.set('id', user_select);
            usuario.fetch({
                success: function (model, data) {
                    // console.log(model, data, usuario);
                    // console.log(data);
                    // console.log(data.full_name);
                    // console.log(data.productos_c);
                    if (data.productos_c.includes(prod_select)) {
                        // reasigna cuenta
                        var productos_tem = contextModal.obten_status_producto(prod_select);
                        //console.log("Se puede reasignar el producto");
                        switch (prod_select) {
                            case "1": // LEASING
                                var leasing_id = modalAccount.context.get('model').attributes.user_id_c; // id user producto cuenta

                                if (!contextModal.validate_no_nueve(leasing_id)) {
                                    if (productos_tem['propietario']) {
                                        console.log("Es porpietario de esta cuenta y no importa el estatus");
                                        contextModal.call_service_reasignacion(cuenta_id, user_select, 'LEASING', prod_select, leasing_id, data.full_name);
                                    } else {
                                        console.log("no es porpietario y validamos estatus");

                                        if (productos_tem['estusAtencion'] == "2" || productos_tem['estusAtencion'] == "0") {
                                            console.log("esta desatendido");

                                            contextModal.call_service_reasignacion(cuenta_id, user_select, 'LEASING', prod_select, leasing_id, data.full_name);
                                        }
                                        else {
                                            contextModal.alert_message('Sin privilegios', 'No cuentas con los privilegios para operar esta Cuenta.');
                                        }
                                    }
                                }
                                else {
                                    contextModal.alert_message('Sin privilegios', 'No cuentas con los privilegios para operar esta Cuenta.');
                                }
                                break;
                            case '3': //Credito-Automotriz
                                var credito_id = modalAccount.context.get('model').attributes.user_id2_c; // id user producto cuenta

                                if (!contextModal.validate_no_nueve(credito_id)) {
                                    if (productos_tem['propietario']) {
                                        console.log("Es porpietario de esta cuenta y no importa el estatus");
                                        contextModal.call_service_reasignacion(cuenta_id, user_select, 'CREDITO AUTOMOTRIZ', prod_select, credito_id, data.full_name);
                                    } else {
                                        console.log("no es porpietario y validamos estatus");

                                        if (productos_tem['estusAtencion'] == "2" || productos_tem['estusAtencion'] == "0") {
                                            console.log("esta desatendido");

                                            contextModal.call_service_reasignacion(cuenta_id, user_select, 'CREDITO AUTOMOTRIZ', prod_select, credito_id, data.full_name);
                                        }
                                        else {
                                            contextModal.alert_message('Sin privilegios', 'No cuentas con los privilegios para operar esta Cuenta.');
                                        }
                                    }

                                }
                                else {
                                    contextModal.alert_message('Sin privilegios', 'No cuentas con los privilegios para operar esta Cuenta.');
                                }
                                break;

                            case '4': // FACTORAJE
                                var factoraje_id = modalAccount.context.get('model').attributes.user_id1_c; // id user producto cuenta
                                if (!contextModal.validate_no_nueve(factoraje_id)) {
                                    if (productos_tem['propietario']) {
                                        console.log("Es porpietario de esta cuenta y no importa el estatus");
                                        contextModal.call_service_reasignacion(cuenta_id, user_select, 'FACTORAJE', prod_select, factoraje_id, data.full_name);
                                    } else {
                                        console.log("no es porpietario y validamos estatus");

                                        if (productos_tem['estusAtencion'] == "2" || productos_tem['estusAtencion'] == "0") {
                                            console.log("esta desatendido");
                                            contextModal.call_service_reasignacion(cuenta_id, user_select, 'FACTORAJE', prod_select, factoraje_id, data.full_name);
                                        }
                                        else {
                                            contextModal.alert_message('Sin privilegios', 'No cuentas con los privilegios para operar esta Cuenta.');
                                        }
                                    }
                                }
                                else {
                                    contextModal.alert_message('Sin privilegios', 'No cuentas con los privilegios para operar esta Cuenta.');
                                }
                                break;

                            case '6': // FLEET
                                var fleet_id = modalAccount.context.get('model').attributes.user_id6_c; // id user producto cuenta

                                if (!contextModal.validate_no_nueve(fleet_id)) {
                                    if (productos_tem['propietario']) {
                                        console.log("Es porpietario de esta cuenta y no importa el estatus");
                                        contextModal.call_service_reasignacion(cuenta_id, user_select, 'FLEET', prod_select, fleet_id, data.full_name);
                                    } else {
                                        console.log("no es porpietario y validamos estatus");

                                        if (productos_tem['estusAtencion'] == "2" || productos_tem['estusAtencion'] == "0") {
                                            console.log("esta desatendido");
                                            contextModal.call_service_reasignacion(cuenta_id, user_select, 'FLEET', prod_select, fleet_id, data.full_name);
                                        }
                                        else {
                                            contextModal.alert_message('Sin privilegios', 'No cuentas con los privilegios para operar esta Cuenta.');
                                        }
                                    }
                                }
                                else {
                                    contextModal.alert_message('Sin privilegios', 'No cuentas con los privilegios para operar esta Cuenta.');
                                }
                                break;

                            case '8': // UNICLICK
                                var uniclick_id = modalAccount.context.get('model').attributes.user_id7_c; // id user producto cuenta

                                if (!contextModal.validate_no_nueve(uniclick_id)) {
                                    if (productos_tem['propietario']) {
                                        console.log("Es porpietario de esta cuenta y no importa el estatus");
                                        contextModal.call_service_reasignacion(cuenta_id, user_select, 'UNICLICK', prod_select, uniclick_id, data.full_name);
                                    } else {
                                        console.log("no es porpietario y validamos estatus");

                                        if (productos_tem['estusAtencion'] == "2" || productos_tem['estusAtencion'] == "0") {
                                            console.log("esta desatendido");
                                            contextModal.call_service_reasignacion(cuenta_id, user_select, 'UNICLICK', prod_select, uniclick_id, data.full_name);
                                        }
                                        else {
                                            contextModal.alert_message('Sin privilegios', 'No cuentas con los privilegios para operar esta Cuenta.');
                                        }
                                    }
                                }
                                else {
                                    contextModal.alert_message('Sin privilegios', 'No cuentas con los privilegios para operar esta Cuenta.');
                                }
                                break;
                        }

                    }
                    else {
                        contextModal.alert_message('Sin privilegios', 'No cuentas con los privilegios para operar esta Cuenta.');
                    }
                }
            });

        }
        else {
            contextModal.alert_message('Usuario no valido', 'Este usuario no es valido.');
        }

    },

    obten_status_producto: function (idProducto_selec) {
        var context360 = v360.ResumenCliente;
        var id_user_firmado = app.user.id; //id de usuario firmado
        var respuesta = {'estusAtencion': '', 'propietario': false};
        var modalAccount = this.context_Account;
        switch (idProducto_selec) {
            case "1": // LEASING
                respuesta['estusAtencion'] = context360.leasing.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido
                var leasing_id = modalAccount.context.get('model').attributes.user_id_c; // id user producto cuenta
                if (id_user_firmado = leasing_id) {
                    respuesta['propietario'] = true;
                }

                break;
            case '3': //Credito-Automotriz
                respuesta['estusAtencion'] = context360.credito_auto.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido
                var credito_id = modalAccount.context.get('model').attributes.user_id2_c; // id user producto cuenta
                if (id_user_firmado = credito_id) {
                    respuesta['propietario'] = true;
                }
                break;

            case '4': // FACTORAJE
                respuesta['estusAtencion'] = context360.factoring.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido
                var factoraje_id = modalAccount.context.get('model').attributes.user_id1_c; // id user producto cuenta
                if (id_user_firmado = factoraje_id) {
                    respuesta['propietario'] = true;
                }
                break;

            case '6': // FLEET
                respuesta['estusAtencion'] = context360.fleet.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido
                var fleet_id = modalAccount.context.get('model').attributes.user_id6_c; // id user producto cuenta
                if (id_user_firmado = fleet_id) {
                    respuesta['propietario'] = true;
                }
                break;

            case '8': // UNICLICK
                respuesta['estusAtencion'] = context360.uniclick.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido
                var uniclick_id = modalAccount.context.get('model').attributes.user_id7_c; // id user producto cuenta
                if (id_user_firmado = uniclick_id) {
                    respuesta['propietario'] = true;
                }
                break;
        }
        return respuesta;
    },

    call_service_reasignacion: function (id_cuenta, id_user_new, text_producto, id_producto, id_user_old, full_name) {
        modal = this;
        var Params = {
            'optBl': "actualMes", // manda actualMes
            'seleccionados': [id_cuenta],// ['idcuenta']
            'reAssignado': id_user_new, // id nuevo usuario
            'producto_seleccionado': text_producto,// texto LEASING
            'producto_seleccionado_id': id_producto,// id LEASING
            'promoActual': id_user_old, // cuenta user_id_c antes de asignar
            'status_producto': "1",
        };
        app.alert.show('reasignando_modal_dos_call', {
            level: 'process',
            title: 'Cargando...'
        });
        var dnbProfileUrl = app.api.buildURL("reAsignarCuentas", '', {}, {});
        app.api.call("create", dnbProfileUrl, {data: Params}, {
            success: _.bind(function (data) {
                console.log(typeof data);
                app.alert.dismiss('reasignando_modal_dos_call');
                if (data) {
                    modal.closeModal();
                    switch (id_producto) {
                        case "1": // LEASING
                            self.model.set('user_id_c', id_user_new); // id del nuevo asesor
                            self.model.set('promotorleasing_c', full_name);// nombre
                            v360.ResumenCliente.leasing.promotor = full_name;
                            cont_uni_p.ResumenProductos.leasing.dias = 0;
                            cont_uni_p.ResumenProductos.leasing.full_name = full_name;
                            cont_uni_p.ResumenProductos.leasing.assigned_user_id = id_user_new;
                            cont_uni_p.render();
                            v360.render();
                            break;
                        case '3': //Credito-Automotriz
                            self.model.set('user_id2_c', id_user_new); // id del nuevo asesor
                            self.model.set('promotorcredit_c', full_name);// nombre
                            v360.ResumenCliente.credito_auto.promotor = full_name;
                            cont_uni_p.ResumenProductos.credito_auto.dias = 0;
                            cont_uni_p.ResumenProductos.credito_auto.full_name = full_name;
                            cont_uni_p.ResumenProductos.credito_auto.assigned_user_id = id_user_new;
                            cont_uni_p.render();
                            v360.render();
                            break;

                        case '4': // FACTORAJE
                            self.model.set('user_id1_c', id_user_new); // id del nuevo asesor
                            self.model.set('promotorfactoraje_c', full_name);// nombre
                            v360.ResumenCliente.factoring.promotor = full_name;
                            cont_uni_p.ResumenProductos.factoring.dias = 0;
                            cont_uni_p.ResumenProductos.factoring.full_name = full_name;
                            cont_uni_p.ResumenProductos.factoring.assigned_user_id = id_user_new;
                            cont_uni_p.render();
                            v360.render();
                            break;

                        case '6': // FLEET
                            self.model.set('user_id6_c', id_user_new); // id del nuevo asesor
                            self.model.set('promotorfleet_c', full_name);// nombre
                            v360.ResumenCliente.fleet.promotor = full_name;
                            cont_uni_p.ResumenProductos.fleet.dias = 0;
                            cont_uni_p.ResumenProductos.fleet.full_name = full_name;
                            cont_uni_p.ResumenProductos.fleet.assigned_user_id = id_user_new;
                            cont_uni_p.render();
                            v360.render();
                            break;

                        case '8': // UNICLICK
                            self.model.set('user_id7_c', id_user_new); // id del nuevo asesor
                            self.model.set('promotoruniclick_c', full_name);// nombre
                            v360.ResumenCliente.uniclick.promotor = full_name;
                            cont_uni_p.ResumenProductos.uniclick.dias = 0;
                            cont_uni_p.ResumenProductos.uniclick.full_name = full_name;
                            cont_uni_p.ResumenProductos.uniclick.assigned_user_id = id_user_new;
                            cont_uni_p.render();
                            v360.render();
                            break;
                    }
                }
            }, this)
        });

    },

    alert_message: function (title, description) {

        app.alert.show(title, {
            level: "error",
            title: description,
            autoClose: false
        });
    },

    closeModal: function () {
        var modal = $('#setAccountModal');
        if (modal) {
            modal.hide();
            modal.remove();
        }
        $('.modal').modal('hide');
        $('.modal').remove();
        $('.modal-backdrop').remove();

    },
    /**Custom method to dispose the view*/
    _disposeView: function () {
        /**Find the index of the view in the components list of the layout*/
        var index = _.indexOf(this.layout._components, _.findWhere(this.layout._components, {name: 'setAccountModal'}));
        if (index > -1) {
            /** dispose the view so that the evnets, context elements etc created by it will be released*/
            this.layout._components[index].dispose();
            /**remove the view from the components list**/
            this.layout._components.splice(index, 1);
        }
    },
})
