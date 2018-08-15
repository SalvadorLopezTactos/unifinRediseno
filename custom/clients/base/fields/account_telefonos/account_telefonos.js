/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Fields.Base.telefonoField
 * @alias SUGAR.App.view.fields.BasetelefonoField
 * @extends View.Field
 */
({
    // CustomAccount_telefonos Field (base)

    events: {
        'change .existingTelephono': 'updateExistingAddress',
        'blur .existingTelephono': 'blurExistingTelefono',
        'blur .newTelefono': 'blurExistingTelefono',
        'keydown .newTelefono': 'keyDownNewExtension',
        'change .existingExtension': 'updateExistingAddress',
        'blur .existingExtension': 'blurExtension',
        'blur .newExtension': 'blurExtension',
        //'keydown .newExtension': 'keyDownNewExtension',
        'change .existingSecuencia': 'updateExistingAddress',
        'change .existingEstatus': 'updateExistingAddress',
        'change .existingPais': 'updateExistingAddress',
        'change .existingTipotelefono': 'updateExistingAddress',
        'click  .btn-edit': 'toggleExistingAddressProperty',
        'click  .removeEmail': 'removeExistingAddress',
        'click  .addTelefono': 'addNewTelefono',
    },
    
    _flag2Deco: {
        principal: {lbl: "LBL_EMAIL_PRIMARY", cl: "primary"},
        opt_out: {lbl: "LBL_EMAIL_OPT_OUT", cl: "opted-out"},
        invalid_email: {lbl: "LBL_EMAIL_INVALID", cl: "invalid"}
    },
    plugins: ['Tooltip', 'ListEditable', 'EmailClientLaunch'],

    /**
     * @inheritdoc
     * @param options
     */
    initialize: function (options) {
        self = this;
        window.ids = [];
        options = options || {};
        options.def = options.def || {};

        // By default, compose email link should be allowed
        if (_.isUndefined(options.def.emailLink)) {
            options.def.emailLink = true;
        }

        if (options.view.action === 'filter-rows') {
            options.viewName = 'filter-rows-edit';
        }

        this._super('initialize', [options]);
        //get related telefonos trobinson@levementum.com
        var tel_tipo_list = app.lang.getAppListStrings('tel_tipo_list');

        this.def.tipoTelLabel = app.lang.get('LBL_TIPOTELEFONO', 'Tel_Telefonos');
        this.def.estatusLabel = app.lang.get('LBL_ESTATUS', 'Tel_Telefonos');
        this.def.paisLabel = app.lang.get('LBL_PAIS', 'Tel_Telefonos');
        this.def.telefonoLabel = app.lang.get('LBL_TELEFONO', 'Tel_Telefonos');
        this.def.extensionLabel = app.lang.get('LBL_EXTENSION', 'Tel_Telefonos');

        var tel_estatus_list = app.lang.getAppListKeys('tel_estatus_list');
        var country_list = app.metadata.getCountries();
        var tel_tipo_list_html = '',
            tel_estatus_list_html = '',
            pais_list_html = '<option value="">Lada</option>';
        //dynamicly populate dropdown options based on language values
        for (var i = 0; i < tel_tipo_list.length; i++) {
            tel_tipo_list_html += '<option value="' + tel_tipo_list[i] + '">' + tel_tipo_list[i] + '</option>'
        }
        for (tel_tipo_key in tel_tipo_list) {
            tel_tipo_list_html += '<option value="' + tel_tipo_key + '" selected="true">' + tel_tipo_list[tel_tipo_key] + '</option>';
        }
        for (var i = 0; i < tel_estatus_list.length; i++) {
            tel_estatus_list_html += '<option value="' + tel_estatus_list[i] + '">' + tel_estatus_list[i] + '</option>'
        }
        var country_list = app.metadata.getCountries();
        for (var key in country_list) {
            pais_list_html += '<option value="' + country_list[key].lada + '" >' + country_list[key].name + '</option>'
        }
        this.def.tel_tipo_list_html = tel_tipo_list_html;
        this.def.tel_estatus_list_html = tel_estatus_list_html;
        this.def.pais_list_html = pais_list_html;
        //*
        var fields = ['id', 'name', 'estatus', 'extension', 'principal', 'secuencia', 'telefono', 'tipotelefono', 'pais'];
        //api request apamaters
        var api_params = {
            'fields': fields.join(','),
            'max_num': 99,
            'order_by': 'date_entered:desc',
            'filter': [{'accounts_tel_telefonos_1accounts_ida': this.model.id}]
            //'filter': [{'account_id_c': this.model.id}]
        };
        var pull_telefono_url = app.api.buildURL('Tel_Telefonos',
            null, null, api_params);

        app.api.call('READ', pull_telefono_url, {}, {
            success: function (data) {
                var country_list = app.metadata.getCountries();
                var tel_tipo_list = app.lang.getAppListStrings('tel_tipo_list');

                for (var i = 0; i < data.records.length; i++) {
                    //self.value[i] = data.records[i].telefono;
                    //add label for tpl use

                    //ignore empty country record trobinson@levementum.com 6/9
                    if (data.records[i].pais != "" && typeof(country_list[data.records[i].pais]) != 'undefined') {
                        data.records[i].country_code_label = country_list[data.records[i].pais].name;
                    }

                    data.records[i].tipo_label = tel_tipo_list[data.records[i].tipotelefono];
                }

                //set model so tpl detail tpl can read data
                self.model.set('account_telefonos', data.records);
                self.model._previousAttributes.account_telefonos = data.records;
                self.model._syncedAttributes.account_telefonos = data.records;
                self.format();
                self._render();
            }
        });

    },

    /**
     * When data changes, re-render the field only if it is not on edit (see MAR-1617).
     * @inheritdoc
     */
    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                this.render();
            }
        }, this);
    },

    /**
     * In edit mode, render telefono input fields using the edit-telefono-field template.
     * @inheritdoc
     * @private
     */
    _render: function () {
        var emailsHtml = '';
        this._super("_render");
        if (this.tplName === 'edit') {
            //get realted records
            _.each(this.model.get('account_telefonos'), function (telefono) {
                emailsHtml += this._buildTelefonoFieldHtml(telefono);
            }, this);
            this.$el.prepend(emailsHtml);
        }
    },

    /**
     * Get HTML for telefono input field.
     * @param {Object} telefono
     * @returns {Object}
     * @private
     */

    _buildTelefonoFieldHtml: function (telefono) {
        var editTelefonoFieldTemplate = app.template.getField('account_telefonos', 'edit-account-telefonos'),
            telefonos = this.model.get('account_telefonos'),
            index = _.indexOf(telefonos, telefono);

        this.def.tipoTelLabel = app.lang.get('LBL_TIPOTELEFONO', 'Tel_Telefonos');
        this.def.estatusLabel = app.lang.get('LBL_ESTATUS', 'Tel_Telefonos');
        this.def.paisLabel = app.lang.get('LBL_PAIS', 'Tel_Telefonos');
        this.def.telefonoLabel = app.lang.get('LBL_TELEFONO', 'Tel_Telefonos');
        this.def.extensionLabel = app.lang.get('LBL_EXTENSION', 'Tel_Telefonos');

        var tel_tipo_list = app.lang.getAppListStrings('tel_tipo_list');
        var tel_tipo_keys = app.lang.getAppListKeys('tel_tipo_list');
        var tel_estatus_list = app.lang.getAppListKeys('tel_estatus_list');
        var country_list = app.metadata.getCountries();
        var tel_tipo_list_html = '',
            tel_estatus_list_html = '',
            pais_list_html = '<option value="">Lada</option>';
        //dynamicly populate dropdown options based on language values
        //for(var i=0;i<tel_tipo_list.length;i++){
        //    if(telefono.tipotelefono==tel_tipo_list[i]){
        //        tel_tipo_list_html+='<option value="'+tel_tipo_list[i]+'" selected="true">'+tel_tipo_list[i]+'</option>'
        //
        //    }
        //    else{
        //        tel_tipo_list_html+='<option value="'+tel_tipo_list[i]+'">'+tel_tipo_list[i]+'</option>'
        //
        //    }
        //}
        for (tel_tipo_key in tel_tipo_list) {
            if (tel_tipo_key == telefono.tipotelefono) {
                tel_tipo_list_html += '<option value="' + tel_tipo_key + '" selected="true">' + tel_tipo_list[tel_tipo_key] + '</option>';

            }
            else {
                tel_tipo_list_html += '<option value="' + tel_tipo_key + '">' + tel_tipo_list[tel_tipo_key] + '</option>';

            }
        }
        for (var i = 0; i < tel_estatus_list.length; i++) {
            if (telefono.estatus == tel_estatus_list[i]) {
                tel_estatus_list_html += '<option value="' + tel_estatus_list[i] + '" selected="true">' + tel_estatus_list[i] + '</option>'

            }
            else {
                tel_estatus_list_html += '<option value="' + tel_estatus_list[i] + '">' + tel_estatus_list[i] + '</option>'

            }
        }

        for (var key in country_list) {
            if (country_list[key].lada == telefono.pais) {
                pais_list_html += '<option value="' + country_list[key].lada + '" selected="true">' + country_list[key].name + '</option>'

            }
            else {
                pais_list_html += '<option value="' + country_list[key].lada + '" >' + country_list[key].name + '</option>'

            }
        }
        return editTelefonoFieldTemplate({
            max_length: this.def.len,
            index: index === -1 ? telefonos.length - 1 : index,
            telefono: telefono.telefono,
            estatus: tel_estatus_list_html,
            extension: telefono.extension,
            principal: telefono.principal,
            tipotelefono: tel_tipo_list_html,
            secuencia: telefono.secuencia,
            pais: pais_list_html,
            tipoTelLabel: this.def.tipoTelLabel,
            estatusLabel: this.def.estatusLabel,
            paisLabel: this.def.paisLabel,
            telefonoLabel: this.def.telefonoLabel,
            extensionLabel: this.def.extensionLabel
        });
    },

    /**
     * Event handler to add a new telefono field.
     * @param {Event} evt
     */
    addNewTelefono: function (evt) {
        if (!evt) return;
        /*@Jesus Carrillo */
        var expreg =/^[0-9]{8,10}$/;

        if(this.$('.newTipotelefono').val()!='' && this.$('.newPais').val()!='' && expreg.test(this.$('.newTelefono').val()) &&
            this.$('.newExtension').val().trim()!='') {
            var telefono = this.$(evt.currentTarget).val() || this.$('.newTelefono').val(),
                currentValue,
                telefonoFieldHtml,
                $newTelefonoField;

            telefono = $.trim(telefono);

            if ((telefono !== '') && (this._addNewTelefonoToModel(telefono))) {
                // build the new email field
                currentValue = this.model.get(this.name);
                telefonoFieldHtml = this._buildTelefonoFieldHtml({
                    telefono: telefono,
                    extension: $('.newExtension').val(),
                    pais: $('.newPais').val(),
                    tipotelefono: $('.newTipotelefono').val(),
                    estatus: $('.newEstatus').val(),
                    principal: currentValue && (currentValue.length === 1)
                });

                // append the new field before the new email input
                $newTelefonoField = this._getNewEmailField()
                    .closest('.telefonos')
                    .before(telefonoFieldHtml);

                // add tooltips
                //this.addPluginTooltips($newTelefonoField.prev());

                if (this.def.required && this._shouldRenderRequiredPlaceholder()) {
                    // we need to remove the required place holder now
                    var label = app.lang.get('LBL_REQUIRED_FIELD', this.module),
                        el = this.$(this.fieldTag).last(),
                        placeholder = el.prop('placeholder').replace('(' + label + ') ', '');

                    el.prop('placeholder', placeholder.trim()).removeClass('required');
                }
            }

            this._clearNewAddressField();
        }else {
            app.alert.show('error_modultel', {
                level: 'error',
                autoClose: true,
                messages: 'Favor de llenar los campos señalados.'
            });
            if(this.$('.newTipotelefono').val()==''){
                this.$('.newTipotelefono').css('border-color', 'red');
            }else{
                this.$('.newTipotelefono').css('border-color', '');
            }
            if(this.$('.newPais').val()==''){
                this.$('.newPais').css('border-color', 'red');
            }else{
                this.$('.newPais').css('border-color', '');
            }
            if(!expreg.test(this.$('.newTelefono').val())){
                this.$('.newTelefono').css('border-color', 'red');
            }else{
                this.$('.newTelefono').css('border-color', '');
            }
            if(this.$('.newExtension').val().trim()==''){
                this.$('.newExtension').css('border-color', 'red');
            }else{
                this.$('.newExtension').css('border-color', '');
            }
            return;
        }
    },

    /**
     * Event handler to update an telefono address.
     * @param {Event} evt
     */
    updateExistingAddress: function (evt) {
        if (!evt) return;
        //get field that changed
        var $input = this.$(evt.currentTarget);
        //get field type
        var class_name = $input[0].className,
            field_name = $($input).attr('data-field');
        var $inputs = this.$('.' + class_name),
            index = $inputs.index($input),
            newTelefono = $input.val(),
            primaryRemoved;
        newTelefono = $.trim(newTelefono);
        if (newTelefono === '') {
            /*
            // remove email if email is empty
            primaryRemoved = this._removeExistingAddressInModel(index);

            $input
                .closest('.telefonos')
                .remove();

            if (primaryRemoved) {
                // on list views we need to set the current value on the input
                if (this.view && this.view.action === 'list') {
                    var addresses = this.model.get(this.name) || [];
                    var primaryAddress = _.filter(addresses, function (address) {
                        if (address.principal) {
                            return true;
                        }
                    });
                    if (primaryAddress[0] && primaryAddress[0].email_address) {
                        app.alert.show('list_delete_email_info', {
                            level: 'info',
                            autoClose: true,
                            messages: app.lang.get('LBL_LIST_REMOVE_EMAIL_INFO')
                        });
                        $input.val(primaryAddress[0].email_address);
                    }
                }
                this.$('[data-emailproperty=principal]')
                    .first()
                    .addClass('active');
            }
            */
        }
        else {
            this._updateExistingAddressInModel(index, newTelefono, field_name);
        }
    },

    /*@Jesus Carrillo*/
    blurExtension: function (evt) {
        if (!evt) return;
        var $input = this.$(evt.currentTarget);
        var class_name = $input[0].className,
            field_name = $($input).attr('data-field');
        if ($($input).val().trim() == '') {
            app.alert.show('error_ext', {
                level: 'error',
                autoClose: true,
                messages: 'Extensi\u00F3n Inv\u00E1lida.'
            });
            //$($input).focus();
            $($input).css('border-color', 'red');
            return;
        }else{
            $($input).css('border-color', '');
        }

    },

    blurExistingTelefono: function (evt) {
        if (!evt) return;
        var $input = this.$(evt.currentTarget);
        var class_name = $input[0].className,
            field_name = $($input).attr('data-field');
        var expreg =/^[0-9]{8,10}$/;
        //if ($.isNumeric($($input).val()) === false && $($input).val() != '') {
        if((expreg.test($($input).val()))==false){
            app.alert.show('error_telefono', {
                level: 'error',
                autoClose: true,
                messages: 'Tel\u00E9fono Inv\u00E1lido.'
            });
            //$($input).focus();
            $($input).css('border-color', 'red');
            return;
        }else{
            $($input).css('border-color', '');
        }

    },

    keyDownNewExtension: function (evt) {
        if (!evt) return;
        if(!this.checkNumOnly(evt)){
            return false;
        }

    },


    //UNI349 Control Telefonos - En el campo teléfono, extensión no se debe permitir caracteres diferentes a numéricos
    checkNumOnly:function(evt){
        if($.inArray(evt.keyCode,[110,188,190,45,33,36,46,35,34,8,9,20,16,17,37,40,39,38,16,49,50,51,52,53,54,55,56,57,48,96,97,98,99,100,101,102,103,104,105]) < 0) {
            app.alert.show("Caracter Invalido", {
                level: "error",
                title: "Solo n\u00FAmeros son permitidos en este campo.",
                autoClose: true
            });
            return false;
        }else{
            return true;
        }
    },
    /**
     * Event handler to remove an telefono address.
     * @param {Event} evt
     */
    removeExistingAddress: function (evt) {
        if (!evt) return;

        var $deleteButtons = this.$('.removeEmail'),
            $deleteButton = this.$(evt.currentTarget),
            index = $deleteButtons.index($deleteButton),
            primaryRemoved,
            $removeThisField;

        primaryRemoved = this._removeExistingAddressInModel(index);

        $removeThisField = $deleteButton.closest('.telefonos');
        //this.removePluginTooltips($removeThisField); // remove tooltips
        $removeThisField.remove();

        if (primaryRemoved) {
            // If primary has been removed, the first email address is the primary address.
            this.$('[data-emailproperty=principal]')
                .first()
                .addClass('active');
        }

        // if this field is required, and there is nothing in the model, then we should decorate it as required
        if (this.def.required && _.isEmpty(this.model.get(this.name))) {
            this.decorateRequired();
        }
    },

    /**
     * Event handler to toggle telefono address properties.
     * @param {Event} evt
     */
    toggleExistingAddressProperty: function (evt) {
        if (!evt) return;

        var $property = this.$(evt.currentTarget),
            property = $property.data('emailproperty'),
            $properties = this.$('[data-emailproperty=' + property + ']'),
            index = $properties.index($property);

        if (property === 'principal') {
            $properties.removeClass('active');
        }

        this._toggleExistingAddressPropertyInModel(index, property);
    },

    /**
     * Add the new telefono address to the model.
     * @param {String} telefono
     * @returns {Boolean} Returns true when a new telefono is added.  Returns false if duplicate is found,
     *          and was not added to the model.
     * @private
     */


    _addNewTelefonoToModel: function (telefono) {
        //var existingTelfonos = this.model.get('account_telefonos');
        var existingTelfonos = app.utils.deepCopy(this.model.get('account_telefonos'));

        existingTelfonos.push({
            telefono: telefono,
            extension: $('.newExtension').val(),
            pais: $('.newPais').val(),
            tipotelefono: $('.newTipotelefono').val(),
            estatus: $('.newEstatus').val(),
            principal: (existingTelfonos.length === 0)
        });
        this.model.set(this.name, existingTelfonos);
        success = true;

        return success;
    },
    /**
     * Update telefono address in the model.
     * @param {Number} index
     * @param {String} newtelefono
     * @private
     */
    _updateExistingAddressInModel: function (index, newTelefono, field_name) {
        var existingAddresses = app.utils.deepCopy(this.model.get('account_telefonos'));
        //Simply update the email address
        existingAddresses[index][field_name] = newTelefono;
        this.model.set(this.name, existingAddresses);
    },

    /**
     * Toggle telefono address properties: primary, opt-out, and invalid.
     * @param {Number} index
     * @param {String} property
     * @private
     */
    _toggleExistingAddressPropertyInModel: function (index, property) {
        var existingAddresses = app.utils.deepCopy(this.model.get(this.name));

        //If property is principal, we want to make sure one and only one primary email is set
        //As a consequence we reset all the principal properties to 0 then we toggle property for this index.
        if (property === 'principal') {
            existingAddresses[index][property] = false;
            _.each(existingAddresses, function (email, i) {
                if (email[property]) {
                    existingAddresses[i][property] = false;
                }
            });
        }

        // Toggle property for this email
        if (existingAddresses[index][property]) {
            existingAddresses[index][property] = false;
        }
        else {
            existingAddresses[index][property] = true;
        }

        this.model.set(this.name, existingAddresses);
    },

    /**
     * Remove telefono address from the model.
     * @param {Number} index
     * @returns {Boolean} Returns true if the removed address was the primary address.
     * @private
     */
    _removeExistingAddressInModel: function (index) {
        var existingAddresses = app.utils.deepCopy(this.model.get(this.name)),
            primaryAddressRemoved = !!existingAddresses[index]['principal'];
        window.ids.push(existingAddresses[index]['id']);

        //Reject this index from existing addresses
        existingAddresses = _.reject(existingAddresses, function (emailInfo, i) {
            return i == index;
        });

        // If a removed address was the primary email, we still need at least one address to be set as the primary email
        if (primaryAddressRemoved) {
            //Let's pick the first one
            var address = _.first(existingAddresses);
            if (address) {
                address.principal = true;
            }
        }
        this.model.set(this.name, existingAddresses);
        return primaryAddressRemoved;
    },

    /**
     * Clear out the new telefono address field.
     * @private
     */
    _clearNewAddressField: function () {
        this._getNewEmailField()
            .val('');
        $('.newPais').val('');
        $('.newPais').css('border-color', '');
        $('.newExtension').val('');
        $('.newExtension').css('border-color', '');
        $('.newTipotelefono').val('');
        $('.newTipotelefono').css('border-color', '');
        $('.newEstatus').val('');
        $('.newEstatus').css('border-color', '');
        $('.newTelefono').css('border-color', '');

    },

    /**
     * Get the new telefono address input field.
     * @returns {jQuery}
     * @private
     */
    _getNewEmailField: function () {
        return this.$('.newTelefono');
    },

    /**
     * Custom error styling for the e-mail field
     * @param {Object} errors
     * @override BaseField
     */
    decorateError: function (errors) {
        var emails;

        this.$el.closest('.record-cell').addClass("error");

        //Select all existing emails
        emails = this.$('input:not(.newTelefono)');

        _.each(errors, function (errorContext, errorName) {
            //For `email` validator the error is specific to an email
            if (errorName === 'email' || errorName === 'duplicateEmail') {

                // For each of our `sub-email` fields
                _.each(emails, function (e) {
                    var $email = this.$(e),
                        email = $email.val();

                    var isError = _.find(errorContext, function (emailError) {
                        return emailError === email;
                    });
                    // if we're on an email sub field where error occurred, add error styling
                    if (!_.isUndefined(isError)) {
                        this._addErrorDecoration($email, errorName, [isError]);
                    }
                }, this);
                //For required or primaryEmail we want to decorate only the first email
            }
            else {
                var $email = this.$('input:first');
                this._addErrorDecoration($email, errorName, errorContext);
            }
        }, this);
    },

    _addErrorDecoration: function ($input, errorName, errorContext) {
        var isWrapped = $input.parent().hasClass('input-append');
        if (!isWrapped)
            $input.wrap('<div class="input-append error ' + this.fieldTag + '">');
        $input.next('.error-tooltip').remove();
        $input.after(this.exclamationMarkTemplate([app.error.getErrorString(errorName, errorContext)]));
        //this.createErrorTooltips($input.next('.error-tooltip'));
    },

    /**
     * Binds DOM changes to set field value on model.
     * @param {Backbone.Model} model model this field is bound to.
     * @param {String} fieldName field name.
     */
    bindDomChange: function () {
        if (this.tplName === 'list-edit') {
            this._super("bindDomChange");
        }
    },

    /**
     * To display representation
     * @param {String|Array} value single telefono address or set of telefono addresses
     */
    format: function (value) {
        value = app.utils.deepCopy(value);
        if (_.isArray(value) && value.length > 0) {
            // got an array of email addresses
            _.each(value, function (email) {
                // On render, determine which e-mail addresses need anchor tag included
                // Needed for handlebars template, can't accomplish this boolean expression with handlebars
                email.hasAnchor = this.def.emailLink && !email.opt_out && !email.invalid_email;
            }, this);
        }
        else if ((_.isString(value) && value !== "") || this.view.action === 'list') {
            // expected an array with a single address but got a string or an empty array
            value = [{
                email_address: value[0].telefono,
                principal: true,
                hasAnchor: true
            }];
        }

        value = this.addFlagLabels(value);
        return value;
    },

    /**
     * Build label that gets displayed in tooltips.
     * @param {Object} value
     * @returns {Object}
     */
    addFlagLabels: function (value) {
        var flagStr = "", flagArray;
        _.each(value, function (emailObj) {
            flagStr = "";
            flagArray = _.map(emailObj, function (flagValue, key) {
                if (!_.isUndefined(this._flag2Deco[key]) && this._flag2Deco[key].lbl && flagValue) {
                    return app.lang.get(this._flag2Deco[key].lbl);
                }
            }, this);
            flagArray = _.without(flagArray, undefined);
            if (flagArray.length > 0) {
                flagStr = flagArray.join(", ");
            }
            emailObj.flagLabel = flagStr;
        }, this);
        return value;
    },

    /**
     * To API representation
     * @param {String|Array} value single telefono address or set of telefono addresses
     */
    unformat: function (value) {
        if (this.view.action === 'list') {
            var telefonos = app.utils.deepCopy(this.model.get(this.name));

            if (!_.isArray(telefonos)) { // telefonos is empty, initialize array
                telefonos = [];
            }

            telefonos = _.map(telefonos, function (email) {
                if (email.principal && email.email_address !== value) {
                    email.email_address = value;
                }
                return email;
            }, this);

            // Adding a new email
            if (telefonos.length == 0) {
                telefonos.push({
                    email_address: value,
                    principal: true
                });
            }

            return telefonos;
        }

        if (this.view.action === 'filter-rows') {
            return value;
        }
    },

    /**
     * Apply focus on the new email input field.
     */
    focus: function () {
        if (this.action !== 'disabled') {
            this._getNewEmailField().focus();
        }
    },

    /**
     * Retrieve link specific telefono options for launching the telefono client
     * Builds upon telefonoOptions on this
     *
     * @param $link
     * @private
     */
    _retrieveEmailOptionsFromLink: function ($link) {
        return {
            to_addresses: [
                {
                    email: $link.data('email-to'),
                    bean: this.emailOptions.related
                }
            ]
        };
    }
})
