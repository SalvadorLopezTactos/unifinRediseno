({

    extendsFrom: 'CreateView',

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
        this.model.addValidationTask('check_Requeridos', _.bind(this.valida_requeridos, this));
        this.model.on('sync', this._readonlyFields, this);
        this._readonlyFields();        
    },

    valida_requeridos: function (fields, errors, callback) {
        var campos = "";
        var requerido = 0;

        /*****************************************************************************************************************
         * *********************************************SUB-TIPO CONTACTADO*******************************************
         ****************************************************************************************************************/

        if (this.model.get('subtipo_registro_c') == '2') {
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
            if (this.model.get('phone_mobile') == '' || this.model.get('phone_mobile') == null) {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_MOBILE_PHONE", "Leads") + '</b><br>';
                errors['phone_mobile'] = errors['phone_mobile'] || {};
                errors['phone_mobile'].required = true;
            }
            if (this.model.get('email') == '' || this.model.get('email') == null) {
                requerido = requerido + 1;
                campos = campos + '<b>' + app.lang.get("LBL_EMAIL_ADDRESS", "Leads") + '</b><br>';
                errors['email'] = errors['email'] || {};
                errors['email'].required = true;
            }
            if (this.model.get('puesto_c') == '' || this.model.get('puesto_c') == null) {
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
            if (this.model.get('leads_leads_1_name') == '' || this.model.get('leads_leads_1_name') == null) {
                requerido = requerido + 1;
                campos = campos + '<b>' + 'Contacto Asociado' + '</b><br>';

                errors['leads_leads_1_name'] = errors['leads_leads_1_name'] || {};
                errors['leads_leads_1_name'].required = true;
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
         * *********************************************SUB-TIPO CANCELADO*******************************************
         ****************************************************************************************************************/

        if (this.model.get('subtipo_registro_c') == '3') {
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

        /*****************************************************************************************************************
         * ****************************************VALIDACION DE TELEFONOS************************************************
         ****************************************************************************************************************/
        if ((this.model.get('phone_mobile') == '' || this.model.get('phone_mobile') == null) &&
            (this.model.get('phone_home') == '' || this.model.get('phone_home') == null) &&
            (this.model.get('phone_work') == '' || this.model.get('phone_work') == null)) {

            app.alert.show('message-phone', {
                level: 'error',
                messages: 'Agregar un número telefónico para guardar un <b>Lead: </b><br>'+'<b>'+'Móvil'+'</b>'+' o'+'<br>'+'<b>'+'Teléfono de Casa'+'</b>'+' o'+'<br>'+'<b>'+'Teléfono de Oficina'+'</b>'+' o'+'<br>',
                autoClose: false
            });

            errors['phone_mobile'] = errors['phone_mobile'] || {};
            errors['phone_mobile'].required = true;
            errors['phone_home'] = errors['phone_home'] || {};
            errors['phone_home'].required = true;
            errors['phone_work'] = errors['phone_work'] || {};
            errors['phone_work'].required = true;
        } 

        callback(null, fields, errors);
    },

    _readonlyFields: function () {
        var self = this;
        var subTipo = this.model.get('subtipo_registro_c');

        if (subTipo == '3') {

            var editButton = self.getField('edit_button');
            editButton.setDisabled(true);

            _.each(this.model.fields, function (field) {

                if (!_.isEqual(field.name, 'motivo_cancelacion_c') && !_.isEqual(field.name, 'submotivo_cancelacion_c')) {

                    self.noEditFields.push(field.name);
                    self.$('.record-edit-link-wrapper[data-name=' + field.name + ']').remove();
                    self.$('[data-name=' + field.name + ']').attr('style', 'pointer-events:none;');
                }
            });
        }
    },

    _render: function (options) {
        this._super("_render");

    }
})
