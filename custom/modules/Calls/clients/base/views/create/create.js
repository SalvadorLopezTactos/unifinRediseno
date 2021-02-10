({
    extendsFrom: 'CreateView',
    personasRelData_list: null,
    initialize: function (options) {
        this.plugins = _.union(this.plugins || [], ['AddAsInvitee', 'ReminderTimeDefaults']);
        self = this;
        this._super("initialize", [options]);
        this.on('render', this.disableparentsfields, this);
        // this.on('render',this.disabledates,this);
        this.on('render', this.noestatusedit, this);
        // this.model.on("change:date_start_date", _.bind(this.validaFecha, this));
        this.model.addValidationTask('valida_cuenta_no_contactar', _.bind(this.valida_cuenta_no_contactar, this));
        this.model.on("change:tct_conferencia_chk_c", _.bind(this.ocultaConferencia, this));
        this.model.addValidationTask('VaildaFechaPermitida', _.bind(this.validaFechaInicialCall, this));
        this.model.addValidationTask('rqueridoPErsona', _.bind(this.reqPersona, this));
        this.model.addValidationTask('valida_requeridos', _.bind(this.valida_requeridos, this));


    },

    /* @F. Javier G. Solar
     * Valida que la Fecha Inicial no sea menor que la actual
     * 14/08/2018
     */
    validaFechaInicialCall: function (fields, errors, callback) {

        // FECHA INICIO
        var dateInicio = new Date(this.model.get("date_start"));
        var d = dateInicio.getDate();
        var m = dateInicio.getMonth() + 1;
        var y = dateInicio.getFullYear();
        var fechaCompleta = [m, d, y].join('/');
        // var dateFormat = dateInicio.toLocaleDateString();
        var fechaInicio = Date.parse(fechaCompleta);


        // FECHA ACTUAL
        var dateActual = new Date();
        var d1 = dateActual.getDate();
        var m1 = dateActual.getMonth() + 1;
        var y1 = dateActual.getFullYear();
        var dateActualFormat = [m1, d1, y1].join('/');
        var fechaActual = Date.parse(dateActualFormat);


        if (fechaInicio < fechaActual) {
            app.alert.show("Fecha no valida", {
                level: "error",
                title: "No puedes crear una Llamada con fecha menor al d&iacutea de hoy",
                autoClose: false
            });

            app.error.errorName2Keys['custom_message1'] = 'La fecha no puede ser menor a la actual';
            errors['date_start'] = errors['date_start'] || {};
            errors['date_start'].custom_message1 = true;
        }
        callback(null, fields, errors);
    },

    _render: function () {
        this._super("_render");
        this.hide_subpanel();
        this.disabledates();
        this.getPersonas();
        this.hidePErsonaEdit();
    },

    /* @Jesus Carrillo
       Oculta el subpanel del boton dropdown y campos de fechas
     */
    hide_subpanel: function () {
        var subpanel = this.getField("save_invite_button");
        if (subpanel) {
            subpanel.listenTo(subpanel, "render", function () {
                subpanel.hide();
            });
        }
    },

    disabledates: function () {
        console.log(App.user.attributes.puestousuario_c);
        if (App.user.attributes.puestousuario_c != '27' && App.user.attributes.puestousuario_c != '31') {
            this.$('div[data-name="tct_fecha_cita_dat_c"]').hide();
            $('div[data-name="tct_usuario_cita_rel_c"]').hide();
            console.log('SE ocultaron');
        } else {
            this.$('div[data-name="tct_fecha_cita_dat_c"]').show();
            $('div[data-name="tct_usuario_cita_rel_c"]').show();
            console.log('SE mostraron');
        }
    },

    /* @Alvador Lopez Y Adrian Arauz
       Oculta los campos relacionados
     */
    disableparentsfields: function () {
        if (this.createMode) {//Evalua si es la vista  de creacion
            if (this.model.get('parent_id') != undefined) {
                this.$('[data-name="parent_name"]').attr('style', 'pointer-events:none;')
            }
        }
    },

    valida_cuenta_no_contactar: function (fields, errors, callback) {

        if (this.model.get('parent_id') && this.model.get('parent_type') == "Accounts") {
            var account = app.data.createBean('Accounts', {id: this.model.get('parent_id')});
            account.fetch({
                success: _.bind(function (model) {
                    if (model.get('tct_no_contactar_chk_c') == true) {

                        app.alert.show("cuentas_no_contactar", {
                            level: "error",
                            title: "Cuenta No Contactable<br>",
                            messages: "Cualquier duda o aclaraci\u00F3n, favor de contactar al \u00E1rea de <b>Administraci\u00F3n de cartera</b>",
                            autoClose: false
                        });

                        app.error.errorName2Keys['custom_message1'] = '';
                        errors['cliente'] = errors['cliente'] || {};
                        errors['cliente'].custom_message1 = true;

                        //Cerrar vista de creación de solicitud
                        if (app.drawer.count()) {
                            app.drawer.close(this.context);
                            //Ocultar alertas excepto la que indica que no se pueden crear relacionados a Cuentas No Contactar
                            var alertas = app.alert.getAll();
                            for (var property in alertas) {
                                if (property != 'cuentas_no_contactar') {
                                    app.alert.dismiss(property);
                                }
                            }
                        } else {
                            app.router.navigate(this.module, {trigger: true});
                        }

                    }
                    callback(null, fields, errors);
                }, this)
            });
        } else {
            callback(null, fields, errors);
        }

    },

    ocultaConferencia: function () {
        if (this.model.get('tct_conferencia_chk_c')) {
            this.model.set('tct_resultado_llamada_ddw_c', "Conferencia");
            this.$('div[data-name="tct_calificacion_conferencia_c"]').hide();
        }
    },

    //No permite editar el campo Estado al crear una nueva llamada.
    //Adrian Arauz 6/09/2018
    noestatusedit: function () {
        $('span[data-name=status]').css("pointer-events", "none");
    },

    valida_requeridos: function (fields, errors, callback) {
        var campos = "";
        _.each(errors, function (value, key) {
            _.each(this.model.fields, function (field) {
                if (_.isEqual(field.name, key)) {
                    if (field.vname) {
                        campos = campos + '<b>' + app.lang.get(field.vname, "Calls") + '</b><br>';
                    }
                }
            }, this);
        }, this);
        if (campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información en la <b>Llamada:</b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    reqPersona: function (fields, errors, callback) {

        var idUsrFirmado = App.user.attributes.id;
        var tipoCuenta = person.model.attributes.parent.tipodepersona_c;
        var idUsrAsignado = person.model.get('assigned_user_id');

        if (idUsrFirmado == idUsrAsignado && tipoCuenta == 'Persona Moral' && (this.model.get('persona_relacion_c') == "" || this.model.get('persona_relacion_c') == undefined)) {
            app.alert.show("Falta Persona", {
                level: "error",
                title: "Hace falta completar la siguiente información  : <br> Persona con quien se atiende la llamada",
                autoClose: false
            });
            $('[data-name="calls_persona_relacion"]').find('.select2-choice').css('border-color', 'red');
            errors['calls_persona_relaccion'] = "Persona con quien se atiende la llamada";
            errors['calls_persona_relaccion'].required = true;
        }
        callback(null, fields, errors);
    },

    getPersonas: function () {
        var idCuenta = selfPerson.model.get('parent_id');
        var tipoCuenta = selfPerson.model.attributes.parent.tipodepersona_c;
        if (tipoCuenta == 'Persona Moral') {
            app.api.call('GET', app.api.buildURL('GetRelRelaciones/' + idCuenta), null, {
                success: function (data) {
                    var idpersonas = selfPerson.model.get('persona_relacion_c');
                    var arrayPersonas = [];
                    var isSelect = false;
                    for (var i = 0; i < data.length; i++) {

                        if (idpersonas != "" && idpersonas == data[i]['id']) {
                            isSelect = true;
                        }
                        arrayPersonas.push({
                            "id": data[i]['id'],
                            "name": data[i]['name'],
                            "select": isSelect
                        });
                    }
                    //console.log(arrayPersonas);
                    selfPerson.personasRelData_list = arrayPersonas;
                    selfPerson.render();
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }

    },

    hidePErsonaEdit: function () {
        person = this;
        var puestosDispo = app.lang.getAppListStrings('puestos_llamadas_list');
        var arrayPuestos = [];
        Object.keys(puestosDispo).forEach(function (key) {
            arrayPuestos.push(Number(key));
        });
        var puesto_usr = Number(app.user.attributes.puestousuario_c);
        var tipoCuenta = person.model.attributes.parent.tipodepersona_c;
        var parentModule = person.model.get('parent_type');

        if (arrayPuestos.includes(puesto_usr) && tipoCuenta == 'Persona Moral' && parentModule == 'Accounts') {
            $('.divPersonasRel').show();
            $('[data-name="persona_relacion_c"]').hide()
            // Valida si el usuario firmado pertenece a la cuenta o a la llamada
            var idUsrFirmado = App.user.attributes.id;
            var idUsrLeading = person.model.attributes.parent.user_id_c;
            var idUsrAsignado = person.model.get('assigned_user_id');
            if (idUsrFirmado != idUsrAsignado || idUsrFirmado != idUsrLeading) {
                $('[data-name="calls_persona_relacion"]').attr('style', 'pointer-events:none')
            }
        }
        else {
            $('.divPersonasRel').hide();
            $('[data-name="persona_relacion_c"]').hide()
            //$('[data-name="calls_persona_relacion"]').addClass('hide');
        }
    },

})