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
            this.layout.on('app:view:getAccountModal', function () {
                var userprod = (app.user.attributes.productos_c).replace(/\^/g, "");
                userprod = userprod.split(",");
                var productos = app.lang.getAppListStrings('tipo_producto_list');
                var context360 = v360.ResumenCliente; // contiene la información vista 360
                var id_user = app.user.id; //id de usuario firmado

                console.log(cont_uni_p.ResumenProductos.leasing.dias);
                var temp_array = [];
                _.each(userprod, function (value, key) {
                    console.log("valor" + value + " llave " + key);
                    switch (value) {
                        case "1": // LEASING
                            var leasing_id = options.context.get('model').attributes.user_id_c; // id user producto cuenta
                            var leasig_status = context360.leasing.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido

                            if (!self_modal.validate_no_nueve(leasing_id)) {
                                if (cont_uni_p.ResumenProductos.leasing.dias > 30) {
                                    var result = self_modal.validate_product(leasing_id, leasig_status, id_user);
                                    if (result['status']) {
                                        temp_array.push(value);
                                    }
                                }
                            }
                            break;
                        case '3': //Credito-Automotriz
                            var credito_id = options.context.get('model').attributes.user_id2_c; // id user producto cuenta
                            var leasig_status = context360.credito_auto.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido

                            if (!self_modal.validate_no_nueve(credito_id)) {
                                if (cont_uni_p.ResumenProductos.credito_auto.dias > 30) {
                                    var result = self_modal.validate_product(credito_id, leasig_status, id_user);
                                    if (result['status']) {
                                        temp_array.push(value);
                                    }
                                }
                            }
                            break;

                        case '4': // FACTORAJE
                            var factoraje_id = options.context.get('model').attributes.user_id1_c; // id user producto cuenta
                            var leasig_status = context360.factoring.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido

                            if (!self_modal.validate_no_nueve(factoraje_id)) {
                                if (cont_uni_p.ResumenProductos.factoring.dias > 30) {
                                    var result = self_modal.validate_product(factoraje_id, leasig_status, id_user);
                                    if (result['status']) {
                                        temp_array.push(value);
                                    }
                                }
                            }
                            break;

                        case '6': // FLEET
                            var fleet_id = options.context.get('model').attributes.user_id6_c; // id user producto cuenta
                            var leasig_status = context360.fleet.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido

                            if (!self_modal.validate_no_nueve(fleet_id)) {
                                if (cont_uni_p.ResumenProductos.fleet.dias > 30) {
                                    var result = self_modal.validate_product(fleet_id, leasig_status, id_user);
                                    if (result['status']) {
                                        temp_array.push(value);
                                    }
                                }
                            }
                            break;

                        case '8': // UNICLICK
                            var uniclick_id = options.context.get('model').attributes.user_id7_c; // id user producto cuenta
                            var leasig_status = context360.uniclick.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido

                            if (!self_modal.validate_no_nueve(uniclick_id)) {
                                if (cont_uni_p.ResumenProductos.uniclick.dias > 30) {
                                    var result = self_modal.validate_product(uniclick_id, leasig_status, id_user);
                                    if (result['status']) {
                                        temp_array.push(value);
                                    }
                                }
                            }
                            break;
                    }
                })

                var list_html = '<option value="" >  </option>';

                _.each(productos, function (value, key) {
                    if (temp_array.includes(key)) {
                        list_html += '<option value="' + key + '">' + productos[key] + '</option>';
                    }
                });

                this.prod_list = list_html;
                this.context_Account = options;

                if (list_html != '<option value="" >  </option>') {
                    this.render();
                    this.$('.modal').modal({
                        backdrop: '',
                        keyboard: true,
                        focus: true
                    });
                    this.$('.modal').modal('show');
                    $('.datepicker').css('z-index', '2000px');
                    app.$contentEl.attr('aria-hidden', true);
                    $('.modal-backdrop').insertAfter($('.modal'));

                } else {
                    //alert
                    app.alert.show("Sin privilegios", {
                        level: "error",
                        title: "No cuentas con los privilegios para operar esta Cuenta.",
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


    /* /!**Overriding the base cancelButton method*!/
     cancelButton: function () {
     this._super('cancelButton');
     app.$contentEl.removeAttr('s-hidden');
     this._disposeView();
     },
     */

    assignedAccount: function () {

        var contextModal = this;
        var context360 = v360.ResumenCliente; // contiene la información vista 360
        var modalAccount = this.context_Account; // contiene información de la cuenta

        var prod_select = $('#productos').val(); // opcion seleccionada
        var id_user = app.user.id; //id de usuario firmado
        var cuenta_id = modalAccount.context.get('model').attributes.id;

        if (prod_select != "") {
            var name_producto = app.lang.getAppListStrings('tipo_producto_list')[prod_select];

            switch (prod_select) {
                case "1": // LEASING
                    var leasing_id = modalAccount.context.get('model').attributes.user_id_c; // id user producto cuenta
                    var leasig_status = context360.leasing.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido

                    if (!contextModal.validate_no_nueve(leasing_id)) {
                        var result = contextModal.validate_product(leasing_id, leasig_status, id_user);
                        if (result['status']) {
                            contextModal.call_service_reasignacion(cuenta_id, id_user, 'LEASING', prod_select, leasing_id);


                        } else {
                            this.respuesta_msj = result['mensaje'];
                        }
                    } else {
                        //console.log("Esta cuenta no puede ser asignada.");
                    }
                    break;
                case '3': //Credito-Automotriz
                    var credito_id = modalAccount.context.get('model').attributes.user_id2_c; // id user producto cuenta
                    var leasig_status = context360.credito_auto.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido

                    if (!contextModal.validate_no_nueve(credito_id)) {
                        var result = contextModal.validate_product(credito_id, leasig_status, id_user);
                        if (result['status']) {
                            contextModal.call_service_reasignacion(cuenta_id, id_user, 'CREDITO AUTOMOTRIZ', prod_select, credito_id);

                        } else {
                            this.respuesta_msj = result['mensaje'];
                        }
                    } else {
                        //console.log("Esta cuenta no puede ser asignada.");
                    }
                    break;

                case '4': // FACTORAJE
                    var factoraje_id = modalAccount.context.get('model').attributes.user_id1_c; // id user producto cuenta
                    var leasig_status = context360.factoring.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido

                    if (!contextModal.validate_no_nueve(factoraje_id)) {
                        var result = contextModal.validate_product(factoraje_id, leasig_status, id_user);
                        if (result['status']) {
                            contextModal.call_service_reasignacion(cuenta_id, id_user, 'FACTORAJE', prod_select, factoraje_id);


                        } else {
                            this.respuesta_msj = result['mensaje'];
                        }
                    } else {
                        //console.log("Esta cuenta no puede ser asignada.");
                    }
                    break;

                case '6': // FLEET
                    var fleet_id = modalAccount.context.get('model').attributes.user_id6_c; // id user producto cuenta
                    var leasig_status = context360.fleet.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido

                    if (!contextModal.validate_no_nueve(fleet_id)) {
                        var result = contextModal.validate_product(fleet_id, leasig_status, id_user);
                        if (result['status']) {
                            contextModal.call_service_reasignacion(cuenta_id, id_user, 'FLEET', prod_select, fleet_id);

                        } else {
                            this.respuesta_msj = result['mensaje'];
                        }
                    } else {
                        // console.log("Esta cuenta no puede ser asignada.");
                    }
                    break;

                case '8': // UNICLICK
                    var uniclick_id = modalAccount.context.get('model').attributes.user_id7_c; // id user producto cuenta
                    var leasig_status = context360.uniclick.estatus_atencion; // estatus producto cuenta 1 atendido 2 desatendido

                    if (!contextModal.validate_no_nueve(uniclick_id)) {
                        var result = contextModal.validate_product(uniclick_id, leasig_status, id_user);
                        if (result['status']) {
                            contextModal.call_service_reasignacion(cuenta_id, id_user, 'UNICLICK', prod_select, uniclick_id);


                        } else {
                            this.respuesta_msj = result['mensaje'];
                        }
                    } else {
                        // console.log("Esta cuenta no puede ser asignada.");
                    }
                    break;

            }
        }


    },
    /** Validaciones **/

    validate_product: function (id_producto, status_producto, user_id) {
        exito = {'status': false, 'mensaje': ""};
        if (user_id != id_producto) {
            if (status_producto == "2") {
                console.log("Se puede asignar el producto");
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
            console.log("Este productos ya te pertenece");
            exito['status'] = false;
            exito['mensaje'] = "Este productos ya te pertenece";
        }
        return exito;
    },
    /** Valida que el id del producto no se ninguno del tipo 9 sin gestor**/
    validate_no_nueve: function (id_producto) {
        var bandera = false;
        var id_user_black = ['36af9462-37e6-11ea-baed-a44e314beb18',
            '405cc6b7-fc4a-7cae-552f-5628f61fd849']; // dejar solo las dos opciones de moroso y bloqueado

        if (id_user_black.includes(id_producto)) {
            bandera = true;
        }
        return bandera;
    },

    call_service_reasignacion: function (id_cuenta, id_user_new, text_producto, id_producto, id_user_old) {
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
        app.alert.show('reasignando', {
            level: 'process',
            title: 'Cargando...'
        });
        var dnbProfileUrl = app.api.buildURL("reAsignarCuentas", '', {}, {});
        app.api.call("create", dnbProfileUrl, {data: Params}, {
            success: _.bind(function (data) {
                //console.log(typeof data);
                if (data) {
                    app.alert.dismiss('reasignando');
//                    this.render();
                    modal.closeModal();
                    //SUGAR.App.controller.context.reloadData({});

                    switch (id_producto) {
                        case "1": // LEASING
                            self.model.set('user_id_c', app.user.id); // id del nuevo asesor
                            self.model.set('promotorleasing_c', app.user.attributes.full_name);// nombre
                            v360.ResumenCliente.leasing.promotor = app.user.attributes.full_name;
                            v360.ResumenCliente.leasing.estatus_atencion = 1;

                            cont_uni_p.ResumenProductos.leasing.dias=0;
                            cont_uni_p.ResumenProductos.leasing.full_name=app.user.attributes.full_name;
                            cont_uni_p.ResumenProductos.leasing.assigned_user_id=app.user.id;
                            cont_uni_p.ResumenProductos.leasing.estatus_atencion=1;

                            cont_uni_p.render();
                            v360.render();
                                break;
                        case '3': //Credito-Automotriz
                            self.model.set('user_id2_c', app.user.user_id2_c); // id del nuevo asesor
                            self.model.set('promotorcredit_c', app.user.attributes.full_name);// nombre
                            v360.ResumenCliente.credito_auto.promotor = app.user.attributes.full_name;
                            v360.ResumenCliente.credito_auto.estatus_atencion = 1;

                            cont_uni_p.ResumenProductos.credito_auto.dias=0;
                            cont_uni_p.ResumenProductos.credito_auto.full_name=app.user.attributes.full_name;
                            cont_uni_p.ResumenProductos.credito_auto.assigned_user_id=app.user.id;
                            cont_uni_p.ResumenProductos.credito_auto.estatus_atencion=1;

                            cont_uni_p.render();
                            v360.render();

                            break;

                        case '4': // FACTORAJE
                            self.model.set('user_id1_c', app.user.user_id1_c); // id del nuevo asesor
                            self.model.set('promotorfactoraje_c', app.user.attributes.full_name);// nombre
                            v360.ResumenCliente.factoring.promotor = app.user.attributes.full_name;
                            v360.ResumenCliente.factoring.estatus_atencion = 1;

                            cont_uni_p.ResumenProductos.factoring.dias=0;
                            cont_uni_p.ResumenProductos.factoring.full_name=app.user.attributes.full_name;
                            cont_uni_p.ResumenProductos.factoring.assigned_user_id=app.user.id;
                            cont_uni_p.ResumenProductos.factoring.estatus_atencion=1;

                            cont_uni_p.render();
                            v360.render();

                            break;

                        case '6': // FLEET
                            self.model.set('user_id6_c', app.user.user_id6_c); // id del nuevo asesor
                            self.model.set('promotorfleet_c', app.user.attributes.full_name);// nombre
                            v360.ResumenCliente.fleet.promotor = app.user.attributes.full_name;
                            v360.ResumenCliente.fleet.estatus_atencion = 1;

                            cont_uni_p.ResumenProductos.fleet.dias=0;
                            cont_uni_p.ResumenProductos.fleet.full_name=app.user.attributes.full_name;
                            cont_uni_p.ResumenProductos.fleet.assigned_user_id=app.user.id;
                            cont_uni_p.ResumenProductos.fleet.estatus_atencion=1;

                            cont_uni_p.render();
                            v360.render();

                            break;

                        case '8': // UNICLICK
                            self.model.set('user_id7_c', app.user.user_id7_c); // id del nuevo asesor
                            self.model.set('promotoruniclick_c', app.user.attributes.full_name);// nombre
                            v360.ResumenCliente.uniclick.promotor = app.user.attributes.full_name;
                            v360.ResumenCliente.uniclick.estatus_atencion = 1;

                            cont_uni_p.ResumenProductos.uniclick.dias=0;
                            cont_uni_p.ResumenProductos.uniclick.full_name=app.user.attributes.full_name;
                            cont_uni_p.ResumenProductos.uniclick.assigned_user_id=app.user.id;
                            cont_uni_p.ResumenProductos.uniclick.estatus_atencion=1;

                            cont_uni_p.render();
                            v360.render();

                            break;
                    }
                }
            }, this)
        });

    },

    closeModal: function () {
        var modal = $('#getAccountModal');
        if (modal) {
            modal.hide();
        }
        $('.modal').modal('hide');
        $('.modal-backdrop').remove();

    },
    /**Custom method to dispose the view*/
    _disposeView: function () {
        /**Find the index of the view in the components list of the layout*/
        var index = _.indexOf(this.layout._components, _.findWhere(this.layout._components, {name: 'getAccountModal'}));
        if (index > -1) {
            /** dispose the view so that the evnets, context elements etc created by it will be released*/
            this.layout._components[index].dispose();
            /**remove the view from the components list**/
            this.layout._components.splice(index, 1);
        }
    },
})