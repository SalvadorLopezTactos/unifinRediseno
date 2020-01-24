({

    extendsFrom: 'CreateView',

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
        this.model.addValidationTask('check_Requeridos', _.bind(this.valida_requeridos, this));
        this.model.on('sync', this._readonlyFields, this);
        this.model.on("change:lead_cancelado_c", _.bind(this._subMotivoCancelacion, this));
        this._readonlyFields();
        this.events['keydown [name=phone_mobile]'] = 'validaSoloNumerosTel';
        this.events['keydown [name=phone_home]'] = 'validaSoloNumerosTel';
        this.events['keydown [name=phone_work]'] = 'validaSoloNumerosTel';
        this.model.addValidationTask('check_longDupTel', _.bind(this.validaLongDupTel, this));
        this.model.addValidationTask('check_TextOnly', _.bind(this.checkTextOnly, this));
        this.model.addValidationTask('change:email', _.bind(this.expmail, this));
        this.events['keydown [name=ventas_anuales_c]'] = 'checkInVentas';
        this.on('render',this._hidechkLeadCancelado,this);
        
    },

    _hidechkLeadCancelado: function () {
        /****Oculta check Lead Cancelado solo al crear Lead****/
        this.$('[data-name=lead_cancelado_c]').hide(); 
    },

    expmail: function (fields, errors, callback) {
        if (this.model.get('email') != null && this.model.get('email') != "") {

            var input = (this.model.get('email'));
            var expresion = /^\S+@\S+\.\S+[$%&|<>#]?$/;
            var cumple = true;

            for (i = 0; i < input.length; i++) {

                if (expresion.test(input[i].email_address) == false) {
                    cumple = false;

                }
            }

            if (cumple == false) {
                app.alert.show('Error al validar email', {
                    level: 'error',
                    autoClose: false,
                    messages: '<b>Formato de Email Incorrecto.</b>'
                })
                errors['email'] = errors['email'] || {};
                errors['email'].required = true;
            }
        }

        callback(null, fields, errors);
    },

    checkTextOnly: function (fields, errors, callback) {
        app.alert.dismiss('Error_validacion_Campos');
        var camponame = "";
        var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);

        if (this.model.get('nombre_c') != "" && this.model.get('nombre_c') != undefined) {
            var nombre = this.model.get('nombre_c');
            var comprueba = expresion.test(nombre);
            if (comprueba != true) {
                camponame = camponame + '<b>' + app.lang.get("LBL_NOMBRE", "Leads") + '</b><br>';
                errors['nombre_c'] = errors['nombre_c'] || {};
                errors['nombre_c'].required = true;
            }
        }
        if (this.model.get('apellido_paterno_c') != "" && this.model.get('apellido_paterno_c') != undefined) {
            var apaterno = this.model.get('apellido_paterno_c');
            var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
            var validaap = expresion.test(apaterno);
            if (validaap != true) {
                camponame = camponame + '<b>' + app.lang.get("LBL_APELLIDO_PATERNO_C", "Leads") + '</b><br>';
                errors['apellido_paterno_c'] = errors['apellido_paterno_c'] || {};
                errors['apellido_paterno_c'].required = true;
            }
        }
        if (this.model.get('apellido_materno_c') != "" && this.model.get('apellido_materno_c') != undefined) {
            var amaterno = this.model.get('apellido_materno_c');
            var expresion = new RegExp(/^[a-zA-ZÀ-ÿ\s]*$/g);
            var validaam = expresion.test(amaterno);
            if (validaam != true) {
                camponame = camponame + '<b>' + app.lang.get("LBL_APELLIDO_MATERNO_C", "Leads") + '</b><br>';
                errors['apellido_materno_c'] = errors['apellido_materno_c'] || {};
                errors['apellido_materno_c'].required = true;
            }
        }
        if (camponame) {
            app.alert.show("Error_validacion_Campos", {
                level: "error",
                messages: 'Los siguientes campos no permiten Caracteres Especiales y Números:<br>' + camponame,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    validaLongDupTel: function (fields, errors, callback) {

        if ((this.model.get('phone_mobile') != "" && this.model.get('phone_mobile') != undefined) || (this.model.get('phone_home') != "" && this.model.get('phone_home') != undefined) || (this.model.get('phone_work') != "" && this.model.get('phone_work') != undefined)) {

            var phoneMobile = this.model.get('phone_mobile') != "" ? this.validaTmanoRepetido(this.model.get('phone_mobile')) : false;
            var phoneHome = this.model.get('phone_home') != "" ? this.validaTmanoRepetido(this.model.get('phone_home')) : false;
            var phoneWork = this.model.get('phone_work') != "" ? this.validaTmanoRepetido(this.model.get('phone_work')) : false;

            /***********************Valida Longitud y Carácteres repetidos********************/
            num_errors = 0;
            if (phoneMobile) {
                num_errors = num_errors + 1;
                errors['phone_mobile'] = errors['phone_mobile'] || {};
                errors['phone_mobile'].required = true;
            }
            if (phoneHome) {
                num_errors = num_errors + 1;
                errors['phone_home'] = errors['phone_home'] || {};
                errors['phone_home'].required = true;
            }
            if (phoneWork) {
                num_errors = num_errors + 1;
                errors['phone_work'] = errors['phone_work'] || {};
                errors['phone_work'].required = true;
            }

            if (num_errors > 0) {
                app.alert.show("Num-invalido", {
                    level: "error",
                    title: "El teléfono debe contener entre 8-13 números / Contiene carácteres repetidos",
                    autoClose: false
                });
            }

            /************************* Valida duplciados ******************************/

            duplicado = 0;
            if (this.model.get('phone_mobile') == this.model.get('phone_home') && this.model.get('phone_mobile') != undefined && this.model.get('phone_home') != undefined) {
                duplicado = duplicado + 1;
                errors['phone_mobile'] = errors['phone_mobile'] || {};
                errors['phone_mobile'].required = true;
                errors['phone_home'] = errors['phone_home'] || {};
                errors['phone_home'].required = true;

            }
            if (this.model.get('phone_mobile') == this.model.get('phone_work') && this.model.get('phone_mobile') != undefined && this.model.get('phone_work') != undefined) {
                duplicado = duplicado + 1;
                errors['phone_mobile'] = errors['phone_mobile'] || {};
                errors['phone_mobile'].required = true;
                errors['phone_work'] = errors['phone_work'] || {};
                errors['phone_work'].required = true;

            }
            if (this.model.get('phone_home') == this.model.get('phone_work') && this.model.get('phone_home') != undefined && this.model.get('phone_work') != undefined) {
                duplicado = duplicado + 1;
                errors['phone_home'] = errors['phone_home'] || {};
                errors['phone_home'].required = true;
                errors['phone_work'] = errors['phone_work'] || {};
                errors['phone_work'].required = true;

            }

            if (duplicado > 0) {
                app.alert.show("Tel-Duplicado", {
                    level: "error",
                    title: "No se puede agregar el número: Ya ha sido registrado.",
                    autoClose: false
                });
            }
        }
        callback(null, fields, errors);
    },

    validaTmanoRepetido: function (telefono) {
        requerido = false;

        if (telefono != "" && telefono != undefined) {
            if (telefono.length >= 8) {

                if (telefono.length > 1) {
                    var repetido = true;
                    for (var itelefono = 0; itelefono < telefono.length; itelefono++) {
                        repetido = (telefono[0] != telefono[itelefono]) ? false : repetido;
                    }
                    if (repetido) {
                        requerido = true;
                    }
                }
            }
            else {
                requerido = true;
            }
        }

        return requerido;
    },

    validaSoloNumerosTel: function (evt) {
        if ($.inArray(evt.keyCode, [110, 188, 45, 33, 36, 35, 34, 8, 9, 20, 16, 17, 37, 40, 39, 38, 16, 49, 50, 51, 52, 53, 54, 55, 56, 57, 48, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105]) < 0) {
            app.alert.show("Caracter Invalido", {
                level: "error",
                title: "Solo n\u00FAmeros son permitidos en este campo.",
                autoClose: true
            });
            return false;

        } else {
            return true;
        }
    },

    _subMotivoCancelacion: function () {

        if (!this.model.get('lead_cancelado_c')) {

            this.model.set('motivo_cancelacion_c', '');
        }
    },

    valida_requeridos: function (fields, errors, callback) {
        var campos = "";
        var requerido = 0;

        /*****************************************************************************************************************
         * *********************************************SUB-TIPO SIN CONTACTAR*******************************************
         ****************************************************************************************************************/

        if (this.model.get('subtipo_registro_c') == '1') {

            if ((this.model.get('nombre_c') == '' || this.model.get('nombre_c') == null) &&
                this.model.get('regimen_fiscal_c') != 'Persona Moral') {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_NOMBRE", "Leads") + '</b><br>';
                errors['nombre_c'] = errors['nombre_c'] || {};
                errors['nombre_c'].required = true;
            }
            if ((this.model.get('apellido_paterno_c') == '' || this.model.get('apellido_paterno_c') == null) &&
                this.model.get('regimen_fiscal_c') != 'Persona Moral') {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_APELLIDO_PATERNO_C", "Leads") + '</b><br>';
                errors['apellido_paterno_c'] = errors['apellido_paterno_c'] || {};
                errors['apellido_paterno_c'].required = true;
            }
            if ((this.model.get('nombre_empresa_c') == '' || this.model.get('nombre_empresa_c') == null) &&
                this.model.get('regimen_fiscal_c') == 'Persona Moral') {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_NOMBRE_EMPRESA", "Leads") + '</b><br>';
                errors['nombre_empresa_c'] = errors['nombre_empresa_c'] || {};
                errors['nombre_empresa_c'].required = true;
            }
            if (this.model.get('origen_c') == '' || this.model.get('origen_c') == null) {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_ORIGEN", "Leads") + '</b><br>';
                errors['origen_c'] = errors['origen_c'] || {};
                errors['origen_c'].required = true;
            }
            if (this.model.get('detalle_origen_c') == '' || this.model.get('detalle_origen_c') == null) {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_DETALLE_ORIGEN", "Leads") + '</b><br>';
                errors['detalle_origen_c'] = errors['detalle_origen_c'] || {};
                errors['detalle_origen_c'].required = true;
            }

            if (requerido > 0) {
                app.alert.show("Campos Requeridos", {
                    level: "error",
                    messages: "Hace falta completar la siguiente información para guardar un <b>Lead: </b><br>" + campos,
                    autoClose: false
                });
            }
        }

        /*****************************************************************************************************************
         * *********************************************SUB-TIPO CONTACTADO*******************************************
         ****************************************************************************************************************/

        if (this.model.get('subtipo_registro_c') == '2') {
            if (this.model.get('origen_c') == '' || this.model.get('macrosector_c') == null) {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_ORIGEN", "Leads") + '</b><br>';
                errors['origen_c'] = errors['origen_c'] || {};
                errors['origen_c'].required = true;
            }
            if (this.model.get('detalle_origen_c') == '' || this.model.get('detalle_origen_c') == null) {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_DETALLE_ORIGEN", "Leads") + '</b><br>';
                errors['detalle_origen_c'] = errors['detalle_origen_c'] || {};
                errors['detalle_origen_c'].required = true;
            }
            if (this.model.get('macrosector_c') == '' || this.model.get('macrosector_c') == null) {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_MACROSECTOR_C", "Leads") + '</b><br>';
                errors['macrosector_c'] = errors['macrosector_c'] || {};
                errors['macrosector_c'].required = true;
            }
            if (this.model.get('ventas_anuales_c') == '' || this.model.get('ventas_anuales_c') == null) {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_VENTAS_ANUALES_C", "Leads") + '</b><br>';
                errors['ventas_anuales_c'] = errors['ventas_anuales_c'] || {};
                errors['ventas_anuales_c'].required = true;
            }
            if (this.model.get('potencial_lead_c') == '' || this.model.get('potencial_lead_c') == null) {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_POTENCIAL_LEAD", "Leads") + '</b><br>';
                errors['potencial_lead_c'] = errors['potencial_lead_c'] || {};
                errors['potencial_lead_c'].required = true;
            }
            if (this.model.get('zona_geografica_c') == '' || this.model.get('zona_geografica_c') == null) {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_ZONA_GEOGRAFICA_C", "Leads") + '</b><br>';
                errors['zona_geografica_c'] = errors['zona_geografica_c'] || {};
                errors['zona_geografica_c'].required = true;
            }
            if (this.model.get('email') == '' || this.model.get('email') == null) {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_EMAIL_ADDRESS", "Leads") + '</b><br>';
                errors['email'] = errors['email'] || {};
                errors['email'].required = true;
            }
            if ((this.model.get('puesto_c') == '' || this.model.get('puesto_c') == null) &&
                this.model.get('regimen_fiscal_c') != 'Persona Moral') {

                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_PUESTO_C", "Leads") + '</b><br>';
                errors['puesto_c'] = errors['puesto_c'] || {};
                errors['puesto_c'].required = true;
            }
            if (this.model.get('assigned_user_name') == '' || this.model.get('assigned_user_name') == null) {
                requerido = requerido + 1;
                campos = campos + '<b>' + 'Asignado a' + '</b><br>';

                errors['assigned_user_name'] = errors['assigned_user_name'] || {};
                errors['assigned_user_name'].required = true;
            }
            if ((this.model.get('nombre_empresa_c') == '' || this.model.get('nombre_empresa_c') == null) &&
                this.model.get('regimen_fiscal_c') == 'Persona Moral') {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_NOMBRE_EMPRESA", "Leads") + '</b><br>';
                errors['nombre_empresa_c'] = errors['nombre_empresa_c'] || {};
                errors['nombre_empresa_c'].required = true;
            }
            if ((this.model.get('nombre_c') == '' || this.model.get('nombre_c') == null) &&
                this.model.get('regimen_fiscal_c') != 'Persona Moral') {

                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_NOMBRE", "Leads") + '</b><br>';

                errors['nombre_c'] = errors['nombre_c'] || {};
                errors['nombre_c'].required = true;
            }
            if ((this.model.get('apellido_paterno_c') == '' || this.model.get('apellido_paterno_c') == null) &&
                this.model.get('regimen_fiscal_c') != 'Persona Moral') {

                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_APELLIDO_PATERNO_C", "Leads") + '</b><br>';

                errors['apellido_paterno_c'] = errors['apellido_paterno_c'] || {};
                errors['apellido_paterno_c'].required = true;
            }
            if ((this.model.get('apellido_materno_c') == '' || this.model.get('apellido_materno_c') == null) &&
                this.model.get('regimen_fiscal_c') != 'Persona Moral') {

                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_APELLIDO_MATERNO_C", "Leads") + '</b><br>';

                errors['apellido_materno_c'] = errors['apellido_materno_c'] || {};
                errors['apellido_materno_c'].required = true;
            }
            if ((this.model.get('phone_mobile') == '' || this.model.get('phone_mobile') == null) &&
                (this.model.get('phone_home') == '' || this.model.get('phone_home') == null) &&
                (this.model.get('phone_work') == '' || this.model.get('phone_work') == null)) {

                requerido = requerido + 1;
                campos = campos + '<b>' + 'Al menos un Teléfono' + '</b><br>';

                errors['phone_mobile'] = errors['phone_mobile'] || {};
                errors['phone_mobile'].required = true;
                errors['phone_home'] = errors['phone_home'] || {};
                errors['phone_home'].required = true;
                errors['phone_work'] = errors['phone_work'] || {};
                errors['phone_work'].required = true;
            }

            if (requerido > 0) {
                app.alert.show("Campos Requeridos", {
                    level: "error",
                    messages: "Hace falta completar la siguiente información para guardar un <b>Lead: </b><br>" + campos,
                    autoClose: false
                });
            }
        }

        /*****************************************************************************************************************
         * *********************************************CHECK CANCELAR LEAD*******************************************
         ****************************************************************************************************************/

        if (this.model.get('lead_cancelado_c') == '1') {
            if (this.model.get('motivo_cancelacion_c') == '' || this.model.get('motivo_cancelacion_c') == null) {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_MOTIVO_CANCELACION_C", "Leads") + '</b><br>';
                errors['motivo_cancelacion_c'] = errors['motivo_cancelacion_c'] || {};
                errors['motivo_cancelacion_c'].required = true;
            }
            if (requerido > 0) {
                app.alert.show("Campos Requeridos", {
                    level: "error",
                    messages: "Hace falta completar la siguiente información para guardar un <b>Lead: </b><br>" + campos,
                    autoClose: false
                });
            }
        }

        callback(null, fields, errors);
    },

    _readonlyFields: function () {
        var self = this;
        /***************************READONLY PARA SUBTIPO DE LEAD CANCELADO**************************/
        if (this.model.get('lead_cancelado_c') == '1' && this.model.get('subtipo_registro_c') == '3') {

            var editButton = self.getField('edit_button');
            editButton.setDisabled(true);

            _.each(this.model.fields, function (field) {

                self.noEditFields.push(field.name);
                self.$('.record-edit-link-wrapper[data-name=' + field.name + ']').remove();
                self.$('[data-name=' + field.name + ']').attr('style', 'pointer-events:none;');
            });
        }
        /***************************READONLY PARA SUBTIPO DE LEAD CONVERTIDO**************************/
        if (this.model.get('subtipo_registro_c') == '4') {

            var editButton = self.getField('edit_button');
            editButton.setDisabled(true);

            _.each(this.model.fields, function (field) {

                self.noEditFields.push(field.name);
                self.$('.record-edit-link-wrapper[data-name=' + field.name + ']').remove();
                self.$('[data-name=' + field.name + ']').attr('style', 'pointer-events:none;');

            });
        }
    },

    setButtonStates: function (state) {
        this._super("setButtonStates", [state]);
        var $saveButtonEl = this.buttons[this.saveButtonName];
        if ($saveButtonEl) {
            switch (state) {
                case this.STATE.CREATE:
                case this.STATE.SELECT:
                    $saveButtonEl.getFieldElement().text(app.lang.get('LBL_SAVE_BUTTON_LABEL', this.module));
                    break;
                case this.STATE.DUPLICATE:
                    $saveButtonEl.getFieldElement().text(app.lang.get('LBL_IGNORE_DUPLICATE_AND_SAVE', this.module)).hide();
                    //OCULTANDO BOTON DE IGNORAR DUPLICADO CON JQUERY
                    $('[name="duplicate_button"]').hide();
                    $('[data-event="list:dupecheck-list-select-edit:fire"]').addClass("hidden");
                    break;
            }
        }
    },

    checkInVentas: function (evt) {
        var enteros = this.checkmoneyint(evt);
        var decimales = this.checkmoneydec(evt);
        $.fn.selectRange = function (start, end) {
            if (!end) end = start;
            return this.each(function () {
                if (this.setSelectionRange) {
                    this.focus();
                    this.setSelectionRange(start, end);
                } else if (this.createTextRange) {
                    var range = this.createTextRange();
                    range.collapse(true);
                    range.moveEnd('character', end);
                    range.moveStart('character', start);
                    range.select();
                }
            });
        };//funcion para posicionar cursor

        (function ($, undefined) {
            $.fn.getCursorPosition = function () {
                var el = $(this).get(0);
                var pos = [];
                if ('selectionStart' in el) {
                    pos = [el.selectionStart, el.selectionEnd];
                } else if ('selection' in document) {
                    el.focus();
                    var Sel = document.selection.createRange();
                    var SelLength = document.selection.createRange().text.length;
                    Sel.moveStart('character', -el.value.length);
                    pos = Sel.text.length - SelLength;
                }
                return pos;
            }
        })(jQuery); //funcion para obtener cursor
        var cursor = $(evt.handleObj.selector).getCursorPosition();//setear cursor


        if (enteros == "false" && decimales == "false") {
            if (cursor[0] == cursor[1]) {
                return false;
            }
        } else if (typeof enteros == "number" && decimales == "false") {
            if (cursor[0] < enteros) {
                $(evt.handleObj.selector).selectRange(cursor[0], cursor[1]);
            } else {
                $(evt.handleObj.selector).selectRange(enteros);
            }
        }

    },

    checkmoneyint: function (evt) {
        if (!evt) return;
        var $input = this.$(evt.currentTarget);
        var digitos = $input.val().split('.');
        if ($input.val().includes('.')) {
            var justnum = /[\d]+/;
        } else {
            var justnum = /[\d.]+/;
        }
        var justint = /^[\d]{0,14}$/;

        if ((justnum.test(evt.key)) == false && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
            app.alert.show('error_dinero', {
                level: 'error',
                autoClose: true,
                messages: 'El campo no acepta Caracteres Especiales.'
            });
            return "false";
        }

        if (typeof digitos[0] != "undefined") {
            if (justint.test(digitos[0]) == false && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
                //console.log('no se cumplen enteros')
                if (!$input.val().includes('.')) {
                    $input.val($input.val() + '.')
                }
                return "false";

            } else {
                return digitos[0].length;
            }
        }
    },

    checkmoneydec: function (evt) {
        if (!evt) return;
        var $input = this.$(evt.currentTarget);
        var digitos = $input.val().split('.');
        if ($input.val().includes('.')) {
            var justnum = /[\d]+/;
        } else {
            var justnum = /[\d.]+/;
        }
        var justdec = /^[\d]{0,1}$/;

        if ((justnum.test(evt.key)) == false && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
            app.alert.show('error_dinero', {
                level: 'error',
                autoClose: true,
                messages: 'El campo no acepta caracteres especiales.'
            });
            return "false";
        }
        if (typeof digitos[1] != "undefined") {
            if (justdec.test(digitos[1]) == false && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
                //console.log('no se cumplen dec')
                return "false";
            } else {
                return "true";
            }
        }
    },

    _render: function (options) {
        this._super("_render");
    }
})
