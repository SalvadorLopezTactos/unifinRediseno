/*
 * Author levementum.com - jescamilla@levementum.com, jgarcia@levementum.com
 * File:  custom/modules/Accounts/clients/base/views/create-nodupecheck/create-nodupecheck.js
 *
 * Obtains a custom dependency list from the following API: custom/clients/base/api/customValidations.php
 * And hides or shows fields according to the rules found.
 * This acts as a custom dependency manager for Multi Select fields allowing dependencies to be interlocked.
 *
 * Target Module: Accounts - Personas
 */
({
    extendsFrom: 'CreateView',
    //extendsFrom: 'BaseCreateNodupecheckView',


    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
        this.enableDuplicateCheck = true;
        //add validation tasks
        this.model.addValidationTask('check_email_telefono', _.bind(this._doValidateEmailTelefono, this));
        this.model.addValidationTask('check_rfc', _.bind(this._doValidateRFC, this));
        this.model.addValidationTask('check_fecha_de_nacimiento', _.bind(this._doValidateMayoriadeEdad, this));
        this.model.addValidationTask('check_account_direcciones', _.bind(this._doValidateDireccion, this));
        this.model.addValidationTask('check_Tiene_Contactos', _.bind(this._doValidateTieneContactos, this));
        this.model.addValidationTask('check_1900_year', _.bind(this.fechaMenor1900, this));
        this.model.addValidationTask('fechadenacimiento_c', _.bind(this.doValidateDateNac, this));
        this.model.addValidationTask('fechaconstitutiva_c', _.bind(this.doValidateDateCons, this));
        //this.model.addValidationTask('check_formato_curp_c', _.bind(this.ValidaFormatoCURP, this));

        //this.model.on('change:tipo_registro_c', this._ShowDireccionesTipoRegistro, this);
        //this.model.on('change:estatus_c', this._ShowDireccionesTipoRegistro, this);
        this.model.on('change:tipodepersona_c', this._ActualizaEtiquetas, this);

        //this.model.on('change:fechadenacimiento_c', this._doGenera_RFC_CURP, this);
        //this.model.on('change:fechaconstitutiva_c', this._doGenera_RFC_CURP, this);
        //this.model.on('change:razonsocial_c', this._doGenera_RFC_CURP, this);
        //this.model.on('change:primernombre_c', this._doGenera_RFC_CURP, this);
        //this.model.on('change:apellidopaterno_c', this._doGenera_RFC_CURP, this);
        //this.model.on('change:apellidomaterno_c', this._doGenera_RFC_CURP, this);

        //this.model.on('change:genero_c', this._doGeneraCURP, this);
        //this.model.on('change:pais_nacimiento_c', this._doGeneraCURP, this);
        //this.model.on('change:estado_nacimiento_c', this._doGeneraCURP, this);

        this.model.on('change:profesion_c', this._doValidateProfesionRisk, this);
        this.model.on('change:pais_nacimiento_c', this._doValidateProfesionRisk, this);
        //this.model.on('change:pais_nacimiento_c',this.validaExtranjerosRFC, this);
        //this.model.on('change:rfc_c',this.validaFechaNacimientoDesdeRFC, this);

        this.events['keydown input[name=primernombre_c]'] = 'checkTextOnly';
        this.events['keydown input[name=segundonombre_c]'] = 'checkTextOnly';
        this.events['keydown input[name=apellidomaterno_c]'] = 'checkTextOnly';
        this.events['keydown input[name=apellidopaterno_c]'] = 'checkTextOnly';
        this.events['keydown input[name=ifepasaporte_c]'] = 'checkTextAndNum';

        this.events['click a[name=generar_rfc_c]'] = '_doGenera_RFC_CURP';
        this.events['click a[name=generar_curp_c]'] = '_doGeneraCURP';

        /**
         * @author Carlos Zaragoza Ortiz
         * @date 16-10-2015
         * UNIFIN TASK: Modificar el riesgo en caso de seleccionar "PEP" en cuestionario de PLD
         * */
        this.model.addValidationTask('verificaRiesgoPep', _.bind(this.cambiaRiesgodePersona, this));

        /**
         * @author Carlos Zaragoza Ortiz
         * @date 16-10-2015
         * Al ser proveedor debe solicitar como obligatorio el tipo de proveedor
         * */
        this.model.addValidationTask('tipo_proveedor_requerido', _.bind(this.validaProveedorRequerido, this));
        /* END */

        this.enableDuplicateCheck = true;

        //UNFIN TASK:
        //@author Carlos Zaragoza: Si la persona es extranjera debe generar RFC gen�rico (XXX010101XXX)
        //this.model.on('change:pais_nacimiento_c', this._doGeneraCURP, this);

        var valParams = {
            'modulo': 'Accounts',
        };
        var valUrl = app.api.buildURL("customValidations", '', {}, {});
        app.api.call("create", valUrl, {data: valParams}, { //Call and Collect the Dependencies
            success: _.bind(function (data) {
                if (data != null) {
                    self.validaciones = data;
                    _.each(data, function (values, parent_field) {
                        self.model.on("change:" + parent_field, function (el) { //Register on change functions for all parent fields.
                            var theField = parent_field;
                            _.each(self.validaciones, function (val_values, val_parent_field) {
                                if (parent_field == val_parent_field) {
                                    var parent_field_values = self.model.get(parent_field);
                                    _.each(val_values, function (rule, rule_name) { //VALIDATION MATCH
                                        if (_.contains(parent_field_values, rule_name) //is it contained in an array?
                                            || parent_field_values == rule_name) { //is it contained in a string?
                                            _.each(rule, function (rule_body, rule_index) {
                                                //Check to see if the rule is active
                                                if (_.isNull(rule_body.estatus) || rule_body.estatus == 'Inactivo') {
                                                    return;
                                                }

                                                //Check for visible, on this version this is the only dependency
                                                if (rule_body.visible == '0' || _.isNull(rule_body.visible)) { //VISIBLE RULE
                                                    $('[data-name="' + rule_body.campo_dependiente + '"]').addClass('vis_action_hidden disabled');
                                                }

                                                //EXECUTE SUB VALIDATIONS
                                                //jescamilla Process SubValidaciones (AND)
                                                if (rule_index == 'SubValidaciones') {
                                                    _.each(rule_body, function (subvalidacion, subvalidacion_index) {
                                                        if (self.model.get(subvalidacion.campo_padre) == subvalidacion.criterio_validacion) { //if its not required, do not enforce it
                                                            //WHAT IS THE SUB VALIDATION DIRECTIVE?
                                                            if (subvalidacion.visible == '0' || _.isNull(subvalidacion.visible)) { //VISIBLE RULE
                                                                $('[data-name="' + subvalidacion.campo_dependiente + '"]').addClass('vis_action_hidden disabled');
                                                            }

                                                            if (subvalidacion.visible == '1') { //VISIBLE RULE
                                                                var theField = $('[data-name="' + subvalidacion.campo_dependiente + '"]')
                                                                if (!theField.hasClass("vis_action_hidden")) { //do not show if its already visible
                                                                    return;
                                                                } //this prevent all the fields from flashing, only flash the fields that are being made visible
                                                                theField.removeClass('vis_action_hidden disabled'); //show the field because the dependency is no longer available
                                                                theField.closest(".row-fluid.panel_body").show(); //show row in case is hidden
                                                                theField.animate({ //flash the field to indicate the user which fields are coming back
                                                                    backgroundColor: '#FF8F8F'
                                                                }, 200, function () {
                                                                    theField.animate({
                                                                        backgroundColor: '#FFFFFF'
                                                                    }, 200, function () {
                                                                        //delete SUGAR.forms.flashInProgress[key];
                                                                    });
                                                                });
                                                            }
                                                        }
                                                    });
                                                }
                                            });
                                        } else { //VALIDATION MISSMATCH
                                            if (self.model.get(parent_field) != '') {
                                                return;
                                            }
                                            _.each(rule, function (rule_body, rule_index) {
                                                //Check to see if the rule is active
                                                if (_.isNull(rule_body.estatus) || rule_body.estatus == 'Inactivo') {
                                                    return;
                                                }

                                                //Check for visible, on this version this is the only dependency
                                                if (rule_body.visible == '0' || _.isNull(rule_body.visible)) { //VISIBLE RULE
                                                    var theField = $('[data-name="' + rule_body.campo_dependiente + '"]')
                                                    if (!theField.hasClass("vis_action_hidden")) { //do not show if its already visible
                                                        return;
                                                    } //this prevent all the fields from flashing, only flash the fields that are being made visible
                                                    theField.removeClass('vis_action_hidden disabled'); //show the field because the dependency is no longer available
                                                    theField.closest(".row-fluid.panel_body").show(); //show row in case is hidden
                                                    theField.animate({ //flash the field to indicate the user which fields are coming back
                                                        backgroundColor: '#FF8F8F'
                                                    }, 200, function () {
                                                        theField.animate({
                                                            backgroundColor: '#FFFFFF'
                                                        }, 200, function () {
                                                            //delete SUGAR.forms.flashInProgress[key];
                                                        });
                                                    });
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                        }, this);
                    });

                    /*jgarcia@levementum.com 9/28/2015 Description: Copiar relaciones activas de la Relacion creada desde el modulo de Relaciones y copiar esos valores en el campo de tipo de relacion*/
                    try {
                        if (relContext != null) {
                            self.model.set("tipo_relacion_c", relContext.model.get("relaciones_activas"));
                        }
                    } catch (e) {
                        console.log('No es relación el error: ' + e);
                    }
                }
            }, this)
        });

        /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 7/14/2015 Description: Cuando estamos en el modulo de Personas, no queremos que se muestre la opcion Persona para el tipo de registro */
        var new_options = app.lang.getAppListStrings('tipo_registro_list');


        if (this.context.parent.attributes.module == "Rel_Relaciones") {
            Object.keys(new_options).forEach(function (key) {
                if (key != "Persona") {
                    delete new_options[key];
                }
            });
        }
        else {

            // var new_options = app.lang.getAppListStrings('tipo_registro_list');

            Object.keys(new_options).forEach(function (key) {
                if (key == "Persona") {
                    delete new_options[key];
                }
            });

            if (App.user.attributes.tct_alta_clientes_chk_c == 1 && App.user.attributes.tct_altaproveedor_chk_c == 1) {
                Object.keys(new_options).forEach(function (key) {
                    if (key != "Cliente" && key != "Proveedor") {
                        delete new_options[key];
                    }
                });
            } else if (App.user.attributes.tct_alta_clientes_chk_c == 1) {

                Object.keys(new_options).forEach(function (key) {
                    if (key != "Cliente") {
                        delete new_options[key];
                    }
                });
            } else if (App.user.attributes.tct_altaproveedor_chk_c == 1) {

                Object.keys(new_options).forEach(function (key) {
                    if (key != "Proveedor") {
                        delete new_options[key];
                    }
                });
            }
            //En otro caso, solo mostrar Lead
            else {
                Object.keys(new_options).forEach(function (key) {
                    if (key != "Lead") {
                        delete new_options[key];
                    }
                });
            }


        }
        this.model.fields['tipo_registro_c'].options = new_options;


    },

    _render: function () {
        this._super("_render");
        this._doValidateProfesionRisk();
        /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 9/28/2015 Description: Copiar relaciones activas de la Relacion creada desde el modulo de Relaciones y copiar esos valores en
         * el campo de tipo de relacion*/
        try {
            if (relContext != null) {
                self.model.set("tipo_relacion_c", relContext.model.get("relaciones_activas"));
            }
        } catch (e) {
            console.log('No es relación  error: ' + e);
        }
        /* END CUSTOMIZATION */


        //cuando creamos una relacion de account a account, el tipo de registro siempre debe de ser persona
        this.model.set('tipo_registro_c', 'Persona');
        // this.model.on("change:tipo_registro_c", _.bind(function () {
        //     this.model.set('tipo_registro_c','Persona');
        // }, this));

        /*
         * @author Carlos Zaragoza ortiz
         * Ocultar campo de estatus Activo/Inactivo en creaci�n de personas
         * */
        this.$('div[data-name=estatus_persona_c]').hide();

        /*
           AF - 2018/07/06
           Cambio: Se coultan pesta�as:  Vista 360, Cuestionario PLD y campo show panel
        */
        //Oculta vista 360 y Cuestionario PLD
        //TabNav
        $("#drawers li.tab").removeClass('active');
        $('#drawers li.tab.panel_body').addClass("active");
        $('#drawers li.tab.LBL_RECORDVIEW_PANEL8').hide();
        $('#drawers li.tab.LBL_RECORDVIEW_PANEL1').hide();
        $('#drawers li.tab.LBL_RECORDVIEW_PANEL2').hide();

        /*
        * F. Javier G. Solar 06/08/2018
        * Si se crea desde Oportunidades el arreglo se recorre una posicion
        * para ocultar correctamente los paneles**/

        if (this.context.parent.attributes.module == "Opportunities") {
            //Tabcontent
            $("#drawers div.tab-content").children()[1].classList.remove('active');
            $("#drawers div.tab-content").children()[2].classList.add('active');
            $("#drawers div.tab-content").children()[2].classList.remove('fade');
        }
        else {
            //Tabcontent posiciones default
            $("#drawers div.tab-content").children()[0].classList.remove('active');
            $("#drawers div.tab-content").children()[1].classList.add('active');
            $("#drawers div.tab-content").children()[1].classList.remove('fade');
        }

        //Oculta campo
        $("div[data-name='show_panel_c']").hide();
    },

    _ActualizaEtiquetas: function () {
        if (this.model.get('tipodepersona_c') != 'Persona Moral' && $("div[data-name='pais_nacimiento_c']").length > 0) {
            this.$("div.record-label[data-name='pais_nacimiento_c']").text("Pa\u00EDs de nacimiento");
        } else {
            this.$("div.record-label[data-name='pais_nacimiento_c']").text("Pa\u00EDs de constituci\u00F3n");
        }

        if (this.model.get('tipodepersona_c') != 'Persona Moral' && $("div[data-name='estado_nacimiento_c']").length > 0) {
            this.$("div.record-label[data-name='estado_nacimiento_c']").text("Estado de nacimiento");
        } else {
            this.$("div.record-label[data-name='estado_nacimiento_c']").text("Estado de constituci\u00F3n");
        }
    },

    _doGeneraCURP: function () {
        if (this.model.get('tipodepersona_c') != 'Persona Moral') {
            //Valida que se tenga la informaci�n requerida para generar la CURP
            if (this.model.get('fechadenacimiento_c') != null && this.model.get('genero_c') != null && this.model.get('genero_c') != ''
                && this.model.get('primernombre_c') != null && this.model.get('apellidopaterno_c') != null && this.model.get('apellidomaterno_c') != null
                && this.model.get('pais_nacimiento_c') != null && this.model.get('estado_nacimiento_c') != null) {
                var firmoParams = {
                    'fechadenacimiento': this.model.get('fechadenacimiento_c'),
                    'primernombre': this.model.get('primernombre_c'),
                    'apellidoP': this.model.get('apellidopaterno_c'),
                    'apellidoM': this.model.get('apellidomaterno_c'),
                    'genero': this.model.get('genero_c'),
                    'pais': this.model.get('pais_nacimiento_c'),
                    'estado': this.model.get('estado_nacimiento_c'),
                    'tipodepersona': this.model.get('tipodepersona_c')
                };
                var dnbProfileUrl = app.api.buildURL("Accounts/GenerarCURP", '', {}, {});
                if (this.model.get('pais_nacimiento_c') == 2) {
                    app.api.call("create", dnbProfileUrl, {curpdata: firmoParams}, {
                        success: _.bind(function (data) {
                            if (data['UNI2_UTL_002_CreaCurpPersonaResult']['resultado']) {
                                this.model.set('curp_c', data['UNI2_UTL_002_CreaCurpPersonaResult']['curp']);
                            }
                        }, this)
                    });
                } else {
                    this.model.set('curp_c', '');
                }
            } else {
                app.alert.show("Generar CURP", {
                    level: "error",
                    title: "Faltan datos para poder generar el CURP",
                    autoClose: false
                });
            }
        }
    },

    _doValidateTieneContactos: function (fields, errors, callback) {
        if (this.model.get('tipodepersona_c') == 'Persona Moral' &&
            (/*this.model.get('tipo_registro_c') == "Cliente" || this.model.get('estatus_c') == "Interesado"
	    	||*/ this.model.get('tipo_registro_c') == "Prospecto")) {
            if (_.isEmpty(this.model.get('account_contacts'))) {
                app.alert.show("Persona sin contactos registrados", {
                    level: "error",
                    title: "Debe registrar al menos un contacto.",
                    autoClose: false
                });
                errors['account_contacts'] = errors['account_contacts'] || {};
                errors['account_contacts'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    ValidaFormatoCURP: function (fields, errors, callback) {
        if (this.model.get('tipodepersona_c') != 'Persona Moral') {
            var CURP = this.model.get('curp_c');
            if (CURP != '' && CURP != null) {
                CURP = CURP.toUpperCase().trim();

                if (!CURP.match("[A-Z]{4}[0-9]{6}[A-Z]{6}[0-9]?[0-9]?")) {
                    app.alert.show("CURP incorrecto", {
                        level: "error",
                        title: "El CURP no tiene un formato correcto.",
                        autoClose: false
                    });
                    errors['curp_c'] = errors['curp_c'] || {};
                    errors['curp_c'].required = true;
                }
            }
        }
        callback(null, fields, errors);
    },

    /*_ShowDireccionesTipoRegistro: function(){
        if(this.model.get('tipo_registro_c') == "Cliente" || this.model.get('estatus_c') == "Interesado" || this.model.get('tipo_registro_c') == "Persona"){
            this.$("div[data-name='account_direcciones']").show();
        }else{
            this.$("div[data-name='account_direcciones']").hide();
        }
        // Carlos Zaragoza: Se elimina el campo por defaiult de tipo de proveedor del registro pero sies proveedor, se selecciona bienes por default
        if(this.model.get('tipo_registro_c') == 'Proveedor'){
            this.model.set('tipo_proveedor_c', '1');
        }
    },*/

    _doValidateDireccion: function (fields, errors, callback) {
        if (this.model.get('tipo_registro_c') == "Cliente" || this.model.get('tipo_registro_c') == "Proveedor" || this.model.get('tipo_registro_c') == "Prospecto") {
            if (_.isEmpty(this.model.get('account_direcciones'))) {
                errors[$(".addDireccion")] = errors['account_direcciones'] || {};
                errors[$(".addDireccion")].required = true;
                $('.direcciondashlet').css('border-color', 'red');
                app.alert.show("Direccion requerida", {
                    level: "error",
                    title: "Al menos una direccion es requerida.",
                    autoClose: false
                });
            }
        }
        callback(null, fields, errors);
    },

    /** BEGIN CUSTOMIZATION: jgarcia@levementum.com 6/12/2015 Description: Persona Fisica and Persona Fisica con Actividad Empresarial must have an email or a Telefono*/
    _doValidateEmailTelefono: function (fields, errors, callback) {
        if (this.model.get('tipo_registro_c') != 'Persona' && this.model.get('tipo_registro_c') != 'Proveedor') {
            if (_.isEmpty(this.model.get('email')) && _.isEmpty(this.model.get('account_telefonos'))) {
                app.alert.show("Correo requerido", {
                    level: "error",
                    title: "Al menos un correo electr\u00F3nico o un tel\u00E9fono es requerido.",
                    autoClose: false
                });
                errors['email'] = errors['email'] || {};
                errors['email'].required = true;
                errors['account_telefonos'] = errors['account_telefonos'] || {};
                errors['account_telefonos'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    _doValidateRFC: function (fields, errors, callback) {
        var fields = ["primernombre_c", "segundonombre_c", "apellidopaterno_c", "apellidomaterno_c", 'rfc_c'];
        var RFC = this.model.get('rfc_c');
        if (RFC != '' && RFC != null) {
            /*M�todo que tiene la funci�n de validar el rfc*/
            RFC = RFC.toUpperCase().trim();
            var expReg = "";
            if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                expReg = "[A-Z&]{4}[0-9]{6}[A-Z0-9]{3}";
            } else {
                expReg = "[A-Z&]{3}[0-9]{6}[A-Z0-9]{3}";
            }
            if (!RFC.match(expReg)) {
                app.alert.show("RFC incorrecto", {
                    level: "error",
                    title: "El RFC no tiene un formato correcto.",
                    autoClose: false
                });
                errors['rfc_c'] = errors['rfc_c'] || {};
                errors['rfc_c'].required = true;
            }
        }

        var PrimerNombre = this.model.get('primernombre_c');
        var SegundoNombre = this.model.get('segundonombre_c');
        var ApellidoP = this.model.get('apellidopaterno_c');
        var ApellidoM = this.model.get('apellidomaterno_c');
        app.api.call("read", app.api.buildURL("Accounts/", null, null, {
            fields: fields.join(','),
            max_num: 5,
            "filter": [
                {
                    "rfc_c": RFC,
                    "primernombre_c": PrimerNombre,
                    "segundonombre_c": SegundoNombre,
                    "apellidopaterno_c": ApellidoP,
                    "apellidomaterno_c": ApellidoM,
                }
            ]
        }), null, {
            success: _.bind(function (data) {
                if (data.records.length > 0) {

                    app.alert.show("DuplicateCheck", {
                        level: "error",
                        title: "Se encontro un registro con Id " + data.records[0].id + " con mismo nombre y RFC.",
                        autoClose: false
                    });
                    errors['rfc_c'] = errors['rfc_c'] || {};
                    errors['rfc_c'].required = true;

                    errors['primernombre_c'] = errors['primernombre_c'] || {};
                    errors['primernombre_c'].required = true;

                    errors['apellidopaterno_c'] = errors['apellidopaterno_c'] || {};
                    errors['apellidopaterno_c'].required = true;

                    errors['apellidomaterno_c'] = errors['apellidomaterno_c'] || {};
                    errors['apellidomaterno_c'].required = true;

                }

            }, this)
        });
        callback(null, fields, errors);
    },

    _doValidateMayoriadeEdad: function (fields, errors, callback) {
        if (this.model.get('tipodepersona_c') != 'Persona Moral' && this.model.get('tipo_registro_c') != 'Persona') {
            var nacimiento = new Date(this.model.get("fechadenacimiento_c"));
            var enteredAge = this.getAge(nacimiento);
            if (enteredAge < 18) {
                app.alert.show("fechaDeNacimientoCheck", {
                    level: "error",
                    title: "Persona debe de ser mayor de 18 a�os.",
                    autoClose: false
                });
                errors['fechadenacimiento_c'] = errors['fechadenacimiento_c'] || {};
                errors['fechadenacimiento_c'].required = true;
            }
        }

        callback(null, fields, errors);
    },

    _doValidateSoloTexto: function (fields, errors, callback) {
        if (this.model.get('tipodepersona_c') != 'Persona Moral') {
            var nacimiento = new Date(this.model.get("fechadenacimiento_c"));
            var enteredAge = this.getAge(nacimiento);
            if (enteredAge < 18) {
                app.alert.show("fechaDeNacimientoCheck", {
                    level: "error",
                    title: "Persona debe de ser mayor de 18 a�os.",
                    autoClose: false
                });
                errors['fechadenacimiento_c'] = errors['fechadenacimiento_c'] || {};
                errors['fechadenacimiento_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    getAge: function (DOB) {
        var today = new Date();
        var birthDate = new Date(DOB);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    },

    _doValidateWSRFC: function () {
        var firmoParams = {
            'fechadenacimiento': this.model.get("fechadenacimiento_c"),
            'primernombre': this.model.get("primernombre_c"),
            'apellidoP': this.model.get("apellidopaterno_c"),
            'apellidoM': this.model.get("apellidomaterno_c"),
            'genero': this.model.get("genero_c"),
            'pais': this.model.get("pais_nacimiento_c"),
            'estado': this.model.get("estado_nacimiento_c"),
            'razonsocial': this.model.get("razonsocial_c"),
            'tipodepersona': this.model.get("tipodepersona_c"),
            'fechaconstitutiva': this.model.get("fechaconstitutiva_c")
        };

        var dnbProfileUrl = app.api.buildURL("Accounts/ValidarRFC", '', {}, {});
        app.api.call("create", dnbProfileUrl, {rfcdata: firmoParams}, {
            success: _.bind(function (data) {
                if (data != null) {
                    var rfc = this.model.get('rfc_c');
                    //Obtiene el resultado del WS dependiendo del regimen de la persona
                    if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                        var rfc_SinHomoclave = (data['UNI2_CTE_02_CreaRfcPersonaFisicaResult']['resultado'] ?
                            data['UNI2_CTE_02_CreaRfcPersonaFisicaResult']['rfcGenerado'] : "");
                        var rfc_local = (data['UNI2_CTE_02_CreaRfcPersonaFisicaResult']['resultado'] ?
                            data['UNI2_CTE_02_CreaRfcPersonaFisicaResult']['rfcGenerado'] + data['UNI2_CTE_02_CreaRfcPersonaFisicaResult']['homoClaveDV'] : "");
                    } else if (this.model.get("tipodepersona_c") == 'Persona Moral') {
                        var rfc_SinHomoclave = (data['UNI2_CTE_03_CreaRfcPersonaMoralResult']['resultado'] ?
                            data['UNI2_CTE_03_CreaRfcPersonaMoralResult']['rfcGenerado'] : "");
                        var rfc_local = (data['UNI2_CTE_03_CreaRfcPersonaMoralResult']['resultado'] ?
                            data['UNI2_CTE_03_CreaRfcPersonaMoralResult']['rfcGenerado'] + data['UNI2_CTE_03_CreaRfcPersonaMoralResult']['homoClaveDV'] : "");
                    }

                    if (rfc != "" && rfc != null) {
                        rfc = (this.model.get("tipodepersona_c") != 'Persona Moral' ? rfc.substring(0, 10) : rfc.substring(0, 9));
                        if (rfc != rfc_SinHomoclave) {
                            app.alert.show("Validar RFC", {
                                level: "confirmation",
                                messages: "El RFC calculado es diferente al escrito, �Desea reemplazarlo?",
                                autoClose: false,

                                onConfirm: function () {
                                    console.log("*** JSR *** el rfc se remplazo con �xito CONFIRMED");
                                    self.model.set("rfc_c", rfc_local);
                                },
                                onCancel: function () {
                                    console.log("*** JSR *** no se modific� el RFC");
                                    //alert("Cancelled!");
                                }
                            });
                        } else {
                            app.alert.show("RFC correcto", {
                                level: "error",
                                title: "El RFC capturado actualmente es correcto",
                                autoClose: true
                            });
                        }
                    } else {
                        console.log("*** JSR *** el rfc est� vacio");
                        this.model.set("rfc_c", rfc_local);
                    }
                }
            }, this)
        });
        //callback(null, fields, errors);
    },

    _doGenera_RFC_CURP: function () {
        if (this.model.get('pais_nacimiento_c') != 2 && this.model.get('pais_nacimiento_c') != '' && this.model.get('pais_nacimiento_c') != null
            && (this.model.get('tipo_registro_c') != 'Prospecto' || this.model.get('estatus_c') != 'Interesado')) {
            if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                this.model.set('rfc_c', 'XXXX010101XXX');
            } else {
                this.model.set('rfc_c', 'XXX010101XXX');
            }
        } else {
            if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                if (this.model.get('fechadenacimiento_c') != null && this.model.get('fechadenacimiento_c') != '' && this.model.get('primernombre_c') != null
                    && this.model.get('apellidopaterno_c') != null && this.model.get('apellidomaterno_c') != null) {
                    this._doValidateWSRFC();
                } else {
                    app.alert.show("Generar RFC", {
                        level: "error",
                        title: "Faltan datos para poder generar el RFC",
                        autoClose: true
                    });
                }
            } else {
                if (this.model.get('razonsocial_c') != null && this.model.get('fechaconstitutiva_c') != null) {
                    this._doValidateWSRFC();
                } else {
                    app.alert.show("Generar RFC", {
                        level: "error",
                        title: "Faltan datos para poder generar el RFC",
                        autoClose: true
                    });
                }
            }
        }
    },

    //No aceptar numeros, solo letras (a-z), puntos(.) y comas(,)
    checkTextOnly: function (evt) {
        if ($.inArray(evt.keyCode, [9, 16, 17, 110, 188, 190, 45, 33, 36, 46, 35, 34, 8, 9, 20, 16, 17, 37, 40, 39, 38, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 16, 32, 192]) < 0) {
            if (evt.keyCode != 186) {
                app.alert.show("Caracter Invalido", {
                    level: "error",
                    title: "Solo texto es permitido en este campo.",
                    autoClose: true
                });
                return false;
            }
        }
    },

    checkTextAndNum: function (evt) {
        //console.log(evt.keyCode);
        if ($.inArray(evt.keyCode, [110, 188, 190, 45, 33, 36, 46, 35, 34, 8, 9, 20, 16, 17, 37, 40, 39, 38, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 16, 32, 192, 186, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105]) < 0) {
            app.alert.show("Caracter Invalido", {
                level: "error",
                title: "Caracter Invalido.",
                autoClose: true
            });
            return false;
        }
    },

    _doValidateProfesionRisk: function () {
        if (!_.isEmpty(this.model.get("profesion_c")) || this.model.get("profesion_c") != null) {
            this.model.set("riesgo_c", "Bajo");
            var profesionActual = this.model.get("profesion_c");
            var profesiones_de_riesgo = app.lang.getAppListStrings('profesion_riesgo_list');
            Object.keys(profesiones_de_riesgo).forEach(function (key) {
                if (key == profesionActual) {
                    self.model.set("riesgo_c", "Alto");
                }
            });
        }
    },

    fechaMenor1900: function (fields, errors, callback) {
        var nacimiento = new Date(this.model.get("fechadenacimiento_c"));
        var year = nacimiento.getFullYear();
        if (year <= 1900) {
            app.alert.show("fechaDeNacimientoCheck", {
                level: "error",
                title: "La fecha de nacimiento no puede ser menor a 1900",
                autoClose: false
            });
            errors['fechadenacimiento_c'] = errors['fechadenacimiento_c'] || {};
            errors['fechadenacimiento_c'].required = true;
        }


        callback(null, fields, errors);
    },

    doValidateDateNac: function (fields, errors, callback) {
        /* if  date not empty, then check with today date and return error */
        if (!_.isEmpty(this.model.get('fechadenacimiento_c'))) {

            var fecnac_date = new Date(this.model.get('fechadenacimiento_c'));
            var today_date = new Date();

            if (fecnac_date > today_date) {

                console.log('La fecha de nacimiento no puede ser mayor al d�a de hoy');
                app.alert.show("fechaDeNacimientoValidate", {
                    level: "error",
                    title: "La fecha de nacimiento no puede ser mayor al d�a de hoy",
                    autoClose: false
                });
                errors['fechadenacimiento_c'] = errors['fechadenacimiento_c'] || {};
                //errors['fechaapertura'] = 'La fecha de apertura no puede ser posterior al d�a de hoy' || {};
                errors['fechadenacimiento_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    doValidateDateCons: function (fields, errors, callback) {
        /* if  date not empty, then check with today date and return error */
        if (!_.isEmpty(this.model.get('fechaconstitutiva_c'))) {

            var feccons_date = new Date(this.model.get('fechaconstitutiva_c'));
            var today_date = new Date();

            if (feccons_date > today_date) {

                console.log('La fecha de nacimiento no puede ser mayor al d�a de hoy');
                app.alert.show("fechaDeConsValidate", {
                    level: "error",
                    title: "La fecha constitutiva no puede ser mayor al d�a de hoy",
                    autoClose: false
                });

                errors['fechaconstitutiva_c'] = errors['fechaconstitutiva_c'] || {};
                //errors['fechaapertura'] = 'La fecha de apertura no puede ser posterior al d�a de hoy' || {};
                errors['fechaconstitutiva_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    /*
    validaExtranjerosRFC: function (){
        if((this.model.get('pais_nacimiento_c')!=2 && this.model.get('pais_nacimiento_c')!="") && (this.model.get('tipo_registro_c') != 'Prospecto' && this.model.get('tipo_registro_c') != 'Persona')){
            this.model.set('rfc_c','XXX010101XXX');
        }
        if(this.model.get('tipo_registro_c') == 'Prospecto' && this.model.get('estatus_c') == 'Interesado' && this.model.get('pais_nacimiento_c')!=2){
            this.model.set('rfc_c','XXX010101XXX');
        }
    },
    */

    validaFechaNacimientoDesdeRFC: function () {
        //this._doValidateRFC();
        var RFC = this.model.get('rfc_c');
        if (RFC != '' && RFC != null && RFC != 'XXX010101XXX') {
            console.log(this.model.get('rfc_c'));
            var expReg = "";
            var tipoControl = "";
            var fecha = "";
            if (this.model.get('tipodepersona_c') != 'Persona Moral') {
                tipoControl = 'fechadenacimiento_c';
                expReg = "[A-Z&]{4}[0-9]{6}[A-Z0-9]{3}";
                fecha = new Date(RFC.substring(6, 8) + "-" + RFC.substring(8, 10) + "-" + RFC.substring(4, 6));
            } else {
                tipoControl = 'fechaconstitutiva_c';
                expReg = "[A-Z&]{3}[0-9]{6}[A-Z0-9]{3}";
                fecha = new Date(RFC.substring(5, 7) + "-" + RFC.substring(7, 9) + "-" + RFC.substring(3, 5));
            }
            if (!RFC.match(expReg)) {
                app.alert.show("RFC incorrecto", {
                    level: "error",
                    title: "El RFC no tiene un formato correcto para ser evaluado",
                    autoClose: true
                });
            } else {
                var fechaFormateada = fecha.getFullYear() + "-" + (fecha.getMonth() < 10 ? "0" + (fecha.getMonth() + 1) : fecha.getMonth() + 1) + "-" + (fecha.getDate() < 10 ? "0" + fecha.getDate() : fecha.getDate());
                this.model.set(tipoControl, fechaFormateada);
            }


        }
    },
    /**
     * @author Carlos Zaragoza Ortiz
     * @date 16-10-2015
     * Al ser proveedor debe solicitar como obligatorio el tipo de proveedor
     * @type function
     * */
    validaProveedorRequerido: function (fields, errors, callback) {
        if (this.model.get('tipo_registro_c') == 'Proveedor') {
            var tipoProveedor = new String(this.model.get('tipo_proveedor_c'));
            if (tipoProveedor.length == 0) {
                app.alert.show("Proveedor Requerido", {
                    level: "error",
                    title: "Debe seleccionar un un tipo de proveedor al menos",
                    autoClose: false
                });
                errors['tipo_proveedor_c'] = errors['tipo_proveedor_c'] || {};
                errors['tipo_proveedor_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },
    /* END */
    /**
     * @author Carlos Zaragoza Ortiz
     * @date 16-10-2015
     * UNIFIN TASK: Modificar el riesgo en caso de seleccionar "PEP" en cuestionario de PLD
     * */
    cambiaRiesgodePersona: function (fields, errors, callback) {
        var riesgo = this.model.get('ctpldpoliticamenteexpuesto_c') == true ? 'Alto' : 'Bajo';
        this.model.set("riesgo_c", riesgo);
        console.log(this.model.get('ctpldpoliticamenteexpuesto_c'));
        console.log(this.model.get('riesgo_c'));
        callback(null, fields, errors);
    },
})
