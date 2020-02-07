({

    extendsFrom: 'RecordView',

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
        this.model.addValidationTask('check_Requeridos', _.bind(this.valida_requeridos_min, this));
        this.model.on('sync', this._readonlyFields, this);
        this.context.on('button:convert_Lead_to_Accounts:click', this.convert_Lead_to_Accounts, this);
        this.model.on("change:lead_cancelado_c", _.bind(this._subMotivoCancelacion, this));
        this.model.on('sync', this._hideBtnConvert, this);
        this._readonlyFields();
        this.events['keypress [name=phone_mobile]'] = 'validaSoloNumerosTel';
        this.events['keypress [name=phone_home]'] = 'validaSoloNumerosTel';
        this.events['keypress [name=phone_work]'] = 'validaSoloNumerosTel';
        this.events['keydown [name=phone_mobile]'] = 'validaSoloNumerosTel';
        this.events['keydown [name=phone_home]'] = 'validaSoloNumerosTel';
        this.events['keydown [name=phone_work]'] = 'validaSoloNumerosTel';
        this.model.addValidationTask('check_longDupTel', _.bind(this.validaLongDupTel, this));
        this.model.addValidationTask('check_TextOnly', _.bind(this.checkTextOnly, this));
        this.model.addValidationTask('change:email', _.bind(this.expmail, this));
        this.events['keydown [name=ventas_anuales_c]'] = 'checkInVentas';
    },

    bindDataChange: function () {
        this._super("bindDataChange");
        //Si el registro es Persona Fisica, ya no se podra cambiar a Persona Moral
        this.model.on("change:regimen_fiscal_c", _.bind(function () {

            if (this.model._previousAttributes.regimen_fiscal_c == 'Persona Fisica') {
                if (this.model.get('regimen_fiscal_c') == 'Persona Moral') {
                    this.model.set('regimen_fiscal_c', 'Persona Fisica');
                }
            }
            if (this.model._previousAttributes.regimen_fiscal_c == 'Persona Fisica con Actividad Empresarial') {
                if (this.model.get('regimen_fiscal_c') == 'Persona Moral') {
                    this.model.set('regimen_fiscal_c', 'Persona Fisica con Actividad Empresarial');
                }
            }
            //Si es Persona Moral, ya no se podra cambiar a Persona Fisica
            if (this.model._previousAttributes.regimen_fiscal_c == 'Persona Moral') {
                if (this.model.get('regimen_fiscal_c') == 'Persona Fisica' || this.model.get('regimen_fiscal_c') == 'Persona Fisica con Actividad Empresarial') {
                    this.model.set('regimen_fiscal_c', 'Persona Moral');
                }
            }
        }, this));
    },

    _disableActionsSubpanel: function () {
        $('[data-subpanel-link="calls"]').find(".subpanel-controls").hide();
        $('[data-subpanel-link="meetings"]').find(".subpanel-controls").hide();
        $('[data-subpanel-link="tasks"]').find(".subpanel-controls").hide();
        $('[data-subpanel-link="notes"]').find(".subpanel-controls").hide();
        $('[data-subpanel-link="campaigns"]').find(".subpanel-controls").hide();
        $('[data-subpanel-link="archived_emails"]').find(".subpanel-controls").hide();
        $('[data-subpanel-link="leads_leads_1"]').find(".subpanel-controls").hide();
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
            if (this.model.get('phone_mobile') == this.model.get('phone_home') && this.model.get('phone_mobile') != "" && this.model.get('phone_home') != "") {
                duplicado = duplicado + 1;
                errors['phone_mobile'] = errors['phone_mobile'] || {};
                errors['phone_mobile'].required = true;
                errors['phone_home'] = errors['phone_home'] || {};
                errors['phone_home'].required = true;

            }
            if (this.model.get('phone_mobile') == this.model.get('phone_work') && this.model.get('phone_mobile') != "" && this.model.get('phone_work') != "") {
                duplicado = duplicado + 1;
                errors['phone_mobile'] = errors['phone_mobile'] || {};
                errors['phone_mobile'].required = true;
                errors['phone_work'] = errors['phone_work'] || {};
                errors['phone_work'].required = true;

            }
            if (this.model.get('phone_home') == this.model.get('phone_work') && this.model.get('phone_home') != "" && this.model.get('phone_work') != "") {
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

        if (evt.which != 8 && evt.which != 9 && evt.which != 0 && (evt.which < 48 || evt.which > 57) && (evt.which < 96 || evt.which > 105)) {

            app.alert.show('Caracter_Invalido', {
                level: 'error',
                autoClose: true,
                messages: 'El campo no acepta caracteres especiales.'
            });
            return false;
        }
    },

    _hideBtnConvert: function () {

        var btnConvert = this.getField("convert_Leads_button");

        if (btnConvert) {
            btnConvert.listenTo(btnConvert, "render", function () {

                if (this.model.get('subtipo_registro_c') == '2') {
                    btnConvert.show();
                } else {
                    btnConvert.hide();
                }
            });
        }
    },

    _subMotivoCancelacion: function () {

        if (!this.model.get('lead_cancelado_c')) {

            this.model.set('motivo_cancelacion_c', '');
        }
    },


    valida_requeridos_min:function (fields, errors, callback)  {
        var campos = "";

        _.each(errors, function (value, key) {
            _.each(this.model.fields, function (field) {
                if (_.isEqual(field.name, key)) {
                    if (field.vname) {
                        campos = campos + '<b>' + app.lang.get(field.vname, "Leads") + '</b><br>';
                    }
                }
            }, this);
        }, this);

        if (campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información para guardar un <b>Lead: </b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);

    },

    valida_requeridos: function () {
        var campos = "";
        var subTipoLead = this.model.get('subtipo_registro_c');
        var tipoPersona = this.model.get('regimen_fiscal_c');
        var campos_req = ['origen_c'];
        var response=false;
        var errors={};

        switch (subTipoLead) {
            /*******SUB-TIPO SIN CONTACTAR*****/
            case '1':
                if (tipoPersona == 'Persona Moral') {
                    campos_req.push('nombre_empresa_c');
                }
                else {
                    campos_req.push('nombre_c', 'apellido_paterno_c');
                }
                break;
            /********SUB-TIPO CONTACTADO*******/
            case '2':
                if (tipoPersona == 'Persona Moral') {
                    campos_req.push('nombre_empresa_c');
                }
                else {
                    campos_req.push('nombre_c', 'apellido_paterno_c', 'apellido_materno_c');
                }

                campos_req.push('puesto_c', 'macrosector_c','ventas_anuales_c','zona_geografica_c','email');

                break;

            default:
                break;
        }

        if (campos_req.length > 0) {

            for (i = 0; i < campos_req.length; i++) {

                var temp_req = campos_req[i];

                if(temp_req=='ventas_anuales_c')
                {
                    if(this.model.get('ventas_anuales_c')==0)
                    {
                        errors[temp_req] = errors[temp_req] || {};
                        errors[temp_req].required = true;

                    }
                }

                else if (this.model.get(temp_req) == '' || this.model.get(temp_req) == null) {
                    errors[temp_req] = errors[temp_req] || {};
                    errors[temp_req].required = true;
                }
            }
        }

        _.each(errors, function (value, key) {
            _.each(this.model.fields, function (field) {
                if (_.isEqual(field.name, key)) {
                    if (field.vname) {
                        campos = campos + '<b>' + app.lang.get(field.vname, "Leads") + '</b><br>';
                    }
                }
            }, this);
        }, this);

        if (((this.model.get('phone_mobile') == '' || this.model.get('phone_mobile') == null) &&
            (this.model.get('phone_home') == '' || this.model.get('phone_home') == null) &&
            (this.model.get('phone_work') == '' || this.model.get('phone_work') == null)) &&
            this.model.get('subtipo_registro_c') == '2') {

            campos = campos + '<b>' + 'Al menos un Teléfono' + '</b><br>';
            campos = campos.replace("<b>Móvil</b><br>", "");
            campos = campos.replace("<b>Teléfono de casa</b><br>", "");
            campos = campos.replace("<b>Teléfono de Oficina</b><br>", "");

            errors['phone_mobile'] = errors['phone_mobile'] || {};
            errors['phone_mobile'].required = true;
            errors['phone_home'] = errors['phone_home'] || {};
            errors['phone_home'].required = true;
            errors['phone_work'] = errors['phone_work'] || {};
            errors['phone_work'].required = true;
        }
        /*****CHECK LEAD CANCELAR*********/
        if (this.model.get('lead_cancelado_c') == '1') {
            if (this.model.get('motivo_cancelacion_c') == '' || this.model.get('motivo_cancelacion_c') == null) {

                campos = campos + '<b>' + app.lang.get("LBL_MOTIVO_CANCELACION_C", "Leads") + '</b><br>';
                errors['motivo_cancelacion_c'] = errors['motivo_cancelacion_c'] || {};
                errors['motivo_cancelacion_c'].required = true;
            }
        }
        if (campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información para guardar un <b>Lead: </b><br>" + campos,
                autoClose: false
            });
        }

        console.log("campos requeridos "  +campos);

        if(campos=="")
        {
            response= true;
        }

return response;
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

            this._disableActionsSubpanel();
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
    },

    convert_Lead_to_Accounts: function () {
        self = this;
        var filter_arguments = {
            "id": this.model.get('id')
        };
        // alert(this.model.get('id'))
        if (this.valida_requeridos()) {

            app.alert.show('upload', {level: 'process', title: 'LBL_LOADING', autoclose: false});

            app.api.call("create", app.api.buildURL("existsLeadAccounts", null, null, filter_arguments), null, {
                success: _.bind(function (data) {

                    console.log(data);
                    app.alert.dismiss('upload');
                    app.controller.context.reloadData({});

                    if (data.idCuenta === "") {
                        app.alert.show("Conversión", {
                            level: "error",
                            messages: data.mensaje,
                            autoClose: false
                        });
                    } else {
                        app.alert.show("Conversión", {
                            level: "success",
                            messages: data.mensaje,
                            autoClose: false
                        });
                        this._disableActionsSubpanel();

                    }
                    var btnConvert = this.getField("convert_Leads_button")

                    if (this.model.get('subtipo_registro_c') == '2') {
                        btnConvert.show();
                    } else {
                        btnConvert.hide();
                    }
                    //app.controller.context.reloadData({});
                    //SUGAR.App.controller.context.reloadData({})
                    /* Para refrescar solo un campo

                     model.fetch({

                      view: undefined,

                      fields: ['industry']

                    });
                     */

                }, this),
                failure: _.bind(function (data) {
                    app.alert.dismiss('upload');

                }, this),
                error: _.bind(function (data) {
                    app.alert.dismiss('upload');

                }, this)
            });

        }
    }
})
