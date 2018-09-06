/**
 * Created by Levementum on 3/8/2016.
 * User: jgarcia@levementum.com
 */

({
    events: {
        'click  .add_incremento_CondicionFinanciera': 'addNewCondicionFinanciera',
        'click  .remove_incremento_CondicionFinanciera': 'removeCondicionFinanciera',
        'change  .porcentaje': 'checarPorcentajeRango',
        'change .existing_incremento_Activo': 'updateExistingCondicionFinanciera',
        'change .new_incremento_Activo': '_inicializaCondicionesFinancieras',
        'change .existing_incremento_Plazo': 'updateExistingCondicionFinanciera',
        'change .porcentaje': 'updateExistingCondicionFinanciera',
        'change .checkbox_incremento_Update': 'updateExistingCondicionFinanciera',
        'change .new_incremento_Plazo': '_inicializaCondicionesFinancieras_Plazo',
    },

    plugins: ['Tooltip', 'ListEditable', 'EmailClientLaunch'],

    initialize: function (options) {

        self = this;
        options = options || {};
        options.def = options.def || {};

        this._super('initialize', [options]);

        var activo_list = app.lang.getAppListStrings('idactivo_list');
        var activo_keys = app.lang.getAppListKeys('idactivo_list');
        var incremento_activo_list_html = '<option value=""></option>';
        for (activo_keys in activo_list) {
            incremento_activo_list_html += '<option value="' + activo_keys + '">' + activo_list[activo_keys] + '</option>'

        }
        this.incremento_activo_list_html = incremento_activo_list_html;

        var plazo_list = app.lang.getAppListStrings('plazo_0');
        var plazo_keys = app.lang.getAppListKeys('plazo_0');
        var incremento_plazo_list_html = '<option value=""></option>';
        for (plazo_keys in plazo_list) {
            incremento_plazo_list_html += '<option value="' + plazo_keys + '">' + plazo_list[plazo_keys] + '</option>'

        }
        this.incremento_plazo_list_html = incremento_plazo_list_html;

        var api_params = {
            'max_num': 99,

            //Ajuste generado por Salvador Lopez <salvador.lopez@tactos.com.mx>
            //Cambio de orden
            'order_by': 'idactivo:ASC,plazo:ASC',
            'filter': [
                {
                    'lev_condicionesfinancieras_opportunitiesopportunities_ida': this.model.id,
                    'incremento_ratificacion': 1
                }
            ]
        };
        var pull_condicionFinanciera_url = app.api.buildURL('lev_CondicionesFinancieras',
            null, null, api_params);

        app.api.call('READ', pull_condicionFinanciera_url, {}, {
            success: function (data) {

                if(data.records[0] != null) {
                    var activo_list = app.lang.getAppListStrings('idactivo_list');
                    for (var i = 0; i < data.records.length; i++) {
                        self.value[i] = data.records[i].idactivo;
                        //add label for tpl use


                        data.records[i].activo_label = activo_list[data.records[i].idactivo];
                        data.records[i].plazo_label = plazo_list[data.records[i].plazo];

                        if (data.records[i].deposito_en_garantia == true) {
                            data.records[i].detail_deposito_en_garantia_checked = "checked";
                        }

                        if (data.records[i].activo_nuevo == true) {
                            data.records[i].detail_activo_nuevo_checked = "checked";
                        }

                        if (data.records[i].uso_particular == true) {
                            data.records[i].detail_uso_particular_checked = "checked";
                        }

                        if (data.records[i].uso_empresarial == true) {
                            data.records[i].detail_uso_empresarial_checked = "checked";
                        }
                    }

                    //set model so tpl detail tpl can read data
                    self.model.set('condiciones_financieras_incremento_ratificacion', data.records);
                    self.model._previousAttributes.condiciones_financieras_incremento_ratificacion = data.records;
                    self.model._syncedAttributes.condiciones_financieras_incremento_ratificacion = data.records;
                    self.format();
                    self._render();
                }else{

                    app.api.call('read', app.api.buildURL('lev_CondicionesFinancieras',
                        null, null, {
                            'max_num': 99,
                            //Ajuste generado por Salvador Lopez <salvador.lopez@tactos.com.mx>
                            //Cambio de orden
                            'order_by': 'idactivo:ASC,plazo:ASC',
                            'filter': [
                                {
                                    'lev_condicionesfinancieras_opportunitiesopportunities_ida': self.model.id
                                }
                            ]
                        }), null, {
                        success: function (data) {

                            if (data.records[0] != null) {

                                var activo_list = app.lang.getAppListStrings('idactivo_list');
                                for (var i = 0; i < data.records.length; i++) {
                                    self.value[i] = data.records[i].idactivo;
                                    //add label for tpl use
                                    data.records[i].activo_label = activo_list[data.records[i].idactivo];

                                    data.records[i].plazo_label = plazo_list[data.records[i].plazo];

                                    if (data.records[i].deposito_en_garantia == true) {
                                        data.records[i].detail_deposito_en_garantia_checked = "checked";
                                    }

                                    if (data.records[i].activo_nuevo == true) {
                                        data.records[i].detail_activo_nuevo_checked = "checked";
                                    }

                                    if (data.records[i].uso_particular == true) {
                                        data.records[i].detail_uso_particular_checked = "checked";
                                    }

                                    if (data.records[i].uso_empresarial == true) {
                                        data.records[i].detail_uso_empresarial_checked = "checked";
                                    }
                                }

                                //set model so tpl detail tpl can read data
                                self.model.set('condiciones_financieras_incremento_ratificacion', data.records);
                                self.model._previousAttributes.condiciones_financieras_incremento_ratificacion = data.records;
                                self.model._syncedAttributes.condiciones_financieras_incremento_ratificacion = data.records;
                                self.format();
                                self._render();
                            }
                        }
                    });
                }
            }
        });

        //Obtener las condiciones iniciales
        var api_params_cond_iniciales = {
            'max_num': 500,
        };
        var pull_condiciones_iniciales_url = app.api.buildURL('UNI_condiciones_iniciales',
            null, null, api_params_cond_iniciales);

        app.api.call('READ', pull_condiciones_iniciales_url, {}, {
            success: function (data) {
                self.condiciones_iniciales = {};
                if (!_.isEmpty(data.records)) {
                    self.condiciones_iniciales = data.records;
                }
            }
        });
    },

    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                this.render();
            }
        }, this);
    },

    bindDomChange: function () {
        if (this.tplName === 'list-edit') {
            this._super("bindDomChange");
        }
    },

    _render: function () {
        var CondicionFinancieraHtml = '';
        this._super("_render");
        if (this.tplName === 'edit') {
            //get realted records
            _.each(this.model.get('condiciones_financieras_incremento_ratificacion'), function (condicion_financiera) {
                CondicionFinancieraHtml += this._buildCondicionFinancieraFieldHtml(condicion_financiera);
            }, this);
            this.$el.prepend(CondicionFinancieraHtml);

        } //if edit


    },

    _buildCondicionFinancieraFieldHtml: function (condicion_financiera) {
        var editCondicionFinancieraFieldTemplate = app.template.getField('condiciones_financieras_incremento_ratificacion', 'edit-condiciones_financieras_incremento_ratificacion'),
            CondicionFinanciera = this.model.get('condiciones_financieras_incremento_ratificacion'),
            index = _.indexOf(CondicionFinanciera, condicion_financiera);

        var activo_list = app.lang.getAppListStrings('idactivo_list');
        var incremento_activo_list_html = '';

        for (activo_tipo_key in activo_list) {
            if (activo_tipo_key == condicion_financiera.idactivo) {
                incremento_activo_list_html += '<option value="' + activo_tipo_key + '" selected="true">' + activo_list[activo_tipo_key] + '</option>';

            }
            else {
                incremento_activo_list_html += '<option value="' + activo_tipo_key + '">' + activo_list[activo_tipo_key] + '</option>';

            }
        }

        var plazo_list = app.lang.getAppListStrings('plazo_0');
        var incremento_plazo_list_html = '';

        for (plazo_tipo_key in plazo_list) {
            if (plazo_tipo_key == condicion_financiera.plazo) {
                incremento_plazo_list_html += '<option value="' + plazo_tipo_key + '" selected="true">' + plazo_list[plazo_tipo_key] + '</option>';

            }
            else {
                incremento_plazo_list_html += '<option value="' + plazo_tipo_key + '">' + plazo_list[plazo_tipo_key] + '</option>';

            }
        }

        if(condicion_financiera.deposito_en_garantia == true){
            var deposito_en_garantia_checked = "checked";
        }

        if(condicion_financiera.uso_particular == true){
            var uso_particular_checked = "checked";
        }

        if(condicion_financiera.uso_empresarial == true){
            var uso_empresarial_checked = "checked";
        }

        if(condicion_financiera.activo_nuevo == true){
            var activo_nuevo_checked = "checked";
        }

        return editCondicionFinancieraFieldTemplate({
            max_length: this.def.len,
            index: index === -1 ? condicion_financiera.length - 1 : index,
            idactivo: incremento_activo_list_html,
            plazo: incremento_plazo_list_html,
            tasa_minima: condicion_financiera.tasa_minima,
            tasa_maxima: condicion_financiera.tasa_maxima,
            vrc_minimo: condicion_financiera.vrc_minimo,
            vrc_maximo: condicion_financiera.vrc_maximo,
            vri_minimo: condicion_financiera.vri_minimo,
            vri_maximo: condicion_financiera.vri_maximo,
            comision_minima: condicion_financiera.comision_minima,
            comision_maxima: condicion_financiera.comision_maxima,
            renta_inicial_minima: condicion_financiera.renta_inicial_minima,
            renta_inicial_maxima: condicion_financiera.renta_inicial_maxima,
            deposito_en_garantia: condicion_financiera.deposito_en_garantia,
            uso_particular: condicion_financiera.uso_particular,
            uso_empresarial: condicion_financiera.uso_empresarial,
            activo_nuevo: condicion_financiera.activo_nuevo,
            deposito_en_garantia_checked: deposito_en_garantia_checked,
            uso_particular_checked: uso_particular_checked,
            uso_empresarial_checked: uso_empresarial_checked,
            activo_nuevo_checked: activo_nuevo_checked,
        });
    },

    addNewCondicionFinanciera: function (evt) {
        if (!evt) return;

        var idactivo = this.$(evt.currentTarget).val() || this.$('.new_incremento_Activo').val(),
            currentValue,
            CondicionFinancieraFieldHtml,
            $CondicionFinanciera;

             //activo = $.trim(activo);
        if ((idactivo !== '') && (this._addNewCondicionFinancieraToModel(idactivo))) {
            currentValue = this.model.get(this.name);

        CondicionFinancieraFieldHtml = this._buildCondicionFinancieraFieldHtml({
            idactivo: idactivo,
            plazo: $('.new_incremento_Plazo').val(),
            tasa_minima: $('.new_incremento_TasaMinima').val(),
            tasa_maxima: $('.new_incremento_TasaMaxima').val(),
            vrc_minimo: $('.new_incremento_VRCMinimo').val(),
            vrc_maximo: $('.new_incremento_VRCMaximo').val(),
            vri_minimo: $('.new_incremento_VRIMinimo').val(),
            vri_maximo: $('.new_incremento_VRIMaximo').val(),
            comision_minima: $('.new_incremento_ComisionMinima').val(),
            comision_maxima: $('.new_incremento_ComisionMaxima').val(),
            renta_inicial_minima: $('.new_incremento_RentaInicialMinima').val(),
            renta_inicial_maxima: $('.new_incremento_RentaInicialMaxima').val(),
            deposito_en_garantia: $('.new_incremento_Deposito').prop("checked"),
            uso_particular: $('.new_incremento_UsoParticular').prop("checked"),
            uso_empresarial: $('.new_incremento_UsoEmpresarial').prop("checked"),
            activo_nuevo: $('.new_incremento_ActivoNuevo').prop("checked"),
        });


            // append the new field before the new direccion input
        $CondicionFinanciera = this._getNewCondicionFinancieraField()
                .closest('.condiciones_financieras_incremento_ratificacion')
                .before(CondicionFinancieraFieldHtml);

            // add tooltips
            //this.addPluginTooltips($CondicionFinanciera.prev());


            this._clearNewCondicionFinancieraField();
        }

    },

    _addNewCondicionFinancieraToModel: function (idactivo){
        var existingCondicionFinanciera = app.utils.deepCopy(this.model.get('condiciones_financieras_incremento_ratificacion'));

        existingCondicionFinanciera.push({
            idactivo: idactivo,
            plazo: $('.new_incremento_Plazo').val(),
            tasa_minima: $('.new_incremento_TasaMinima').val(),
            tasa_maxima: $('.new_incremento_TasaMaxima').val(),
            vrc_minimo: $('.new_incremento_VRCMinimo').val(),
            vrc_maximo: $('.new_incremento_VRCMaximo').val(),
            vri_minimo: $('.new_incremento_VRIMinimo').val(),
            vri_maximo: $('.new_incremento_VRIMaximo').val(),
            comision_minima: $('.new_incremento_ComisionMinima').val(),
            comision_maxima: $('.new_incremento_ComisionMaxima').val(),
            renta_inicial_minima: $('.new_incremento_RentaInicialMinima').val(),
            renta_inicial_maxima: $('.new_incremento_RentaInicialMaxima').val(),
            deposito_en_garantia: $('.new_incremento_Deposito').prop("checked"),
            uso_particular: $('.new_incremento_UsoParticular').prop("checked"),
            uso_empresarial: $('.new_incremento_UsoEmpresarial').prop("checked"),
            activo_nuevo: $('.new_incremento_ActivoNuevo').prop("checked"),

        });
        console.log("existingCondicionFinanciera");
        console.log(existingCondicionFinanciera);
        this.model.set(this.name, existingCondicionFinanciera);
        success = true;

        return success;
    },

    removeCondicionFinanciera: function (evt) {
        if (!evt) return;

        var $deleteButtons = this.$('.remove_incremento_CondicionFinanciera'),
            $deleteButton = this.$(evt.currentTarget),
            index = $deleteButtons.index($deleteButton),
            primaryRemoved,
            $removeThisField;

        primaryRemoved = this._removeCondicionFinancieraInModel(index);

        $removeThisField = $deleteButton.closest('.condiciones_financieras_incremento_ratificacion');
        //this.removePluginTooltips($removeThisField); // remove tooltips
        $removeThisField.remove();

        if (primaryRemoved) {
            // If primary has been removed, the first email address is the primary address.
            //this.$('[data-emailproperty=principal]')
            //    .first()
            //    .addClass('active');
        }

        // if this field is required, and there is nothing in the model, then we should decorate it as required
        if (this.def.required && _.isEmpty(this.model.get(this.name))) {
            this.decorateRequired();
        }
    },

    _removeCondicionFinancieraInModel: function (index) {
        var existingCondicionesFinancieras = app.utils.deepCopy(this.model.get(this.name)),
            primaryCondicionFinanciera = !!existingCondicionesFinancieras[index][this.name];

        //Reject this index from existing condicion financiera
        existingCondicionesFinancieras = _.reject(existingCondicionesFinancieras, function (condicionFinancieraInfo, i) {
            return i == index;
        });

        // If a removed address was the primary email, we still need at least one address to be set as the primary email
        if (primaryCondicionFinanciera) {
            //Let's pick the first one
            var address = _.first(existingCondicionesFinancieras);
            if (address) {
                address.principal = true;
            }
        }

        this.model.set(this.name, existingCondicionesFinancieras);
        return primaryCondicionFinanciera;
    },

    _clearNewCondicionFinancieraField: function () {
        this._getNewCondicionFinancieraField()
            .val('');
        $('.new_incremento_Activo').val('');
        $('.new_incremento_Plazo').val('');
        $('.new_incremento_TasaMinima').val('');
        $('.new_incremento_TasaMaxima').val('');
        $('.new_incremento_VRCMinimo').val('');
        $('.new_incremento_VRCMaximo').val('');
        $('.new_incremento_VRIMinimo').val('');
        $('.new_incremento_VRIMaximo').val('');
        $('.new_incremento_ComisionMinima').val('');
        $('.new_incremento_ComisionMaxima').val('');
        $('.new_incremento_RentaInicialMinima').val('');
        $('.new_incremento_RentaInicialMaxima').val('');
        $('.new_incremento_Deposito').prop("checked",false);
        $('.new_incremento_UsoParticular').prop("checked",false);
        $('.new_incremento_UsoEmpresarial').prop("checked",false);
        $('.new_incremento_ActivoNuevo').prop("checked",false);
    },

    updateExistingCondicionFinanciera: function (evt) {
        if (!evt) return;
        //get field that changed
        var $input = this.$(evt.currentTarget);
        //get field type
        var class_name = $input[0].className,
            field_name = $($input).attr('data-field');

        //split the class name in case the field has more than 1 class
        var class_name_split = [];
        class_name_split.push($.trim(class_name).split(" "));

        var $inputs = this.$('.' + class_name_split[0]),
            index = $inputs.index($input),
            newCFinanciera = $input.val(),
            primaryRemoved;

        if(class_name_split[0][1] == "checkbox_incremento_Update"){
            newCFinanciera = $input.prop("checked");
        }

        newCFinanciera = $.trim(newCFinanciera);
        if (newCFinanciera === '') {
            // remove email if email is empty
            primaryRemoved = this._removeCondicionFinancieraInModel(index);

            $input
                .closest('.condiciones_financieras_incremento_ratificacion')
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
        }
        else {
            this._updateExistingCondicionFinancieraInModel(index, newCFinanciera, field_name);
        }
    },

    _updateExistingCondicionFinancieraInModel: function (index, newCFinanciera, field_name) {
        var existingCFinanciera = app.utils.deepCopy(this.model.get('condiciones_financieras_incremento_ratificacion'));
        //Simply update the email address
        existingCFinanciera[index][field_name] = newCFinanciera;
        this.model.set(this.name, existingCFinanciera);
    },

    _getNewCondicionFinancieraField: function () {
        return this.$('.new_incremento_Activo');
    },

    _inicializaCondicionesFinancieras: function (evt) {
        if (!evt) return;
        //Obten el campo que acaba de cambiar
        var $input = this.$(evt.currentTarget);
        _.each(self.condiciones_iniciales, function (condicion_inicial) {
            if ($input.val() == condicion_inicial.activo) { //Detecta si el activo seleccionado coincide con la lista que se esta ciclando
                if($('#' + condicion_inicial.campo_destino_minimo).attr('type') == 'checkbox'){ //Checa si es un checkbox, ya que estos se manejan diferente
                    if(!_.isEmpty(condicion_inicial.rango_minimo)){
                        $('#' + condicion_inicial.campo_destino_minimo).prop('checked', true);
                    }else{
                        $('#' + condicion_inicial.campo_destino_minimo).prop('checked', false);
                    }
                }else{ //procesa como un campo normal solo asignando los valores
                    $('#' + condicion_inicial.campo_destino_minimo).val(condicion_inicial.rango_minimo);
                    $('#' + condicion_inicial.campo_destino_maximo).val(condicion_inicial.rango_maximo);
                }
            }
        }, this);
    },

    _inicializaCondicionesFinancieras_Plazo: function (evt) {

        if (!evt) return;
        //Obten el campo que acaba de cambiar
        var $input = this.$(evt.currentTarget);
        _.each(self.condiciones_iniciales, function (condicion_inicial) {
            if ($input.val() == condicion_inicial.plazo && $('.new_incremento_Activo').val() == condicion_inicial.activo) { //Detecta si el activo seleccionado coincide con la lista que se esta ciclando
                if($('#' + condicion_inicial.campo_destino_minimo).attr('type') == 'checkbox'){ //Checa si es un checkbox, ya que estos se manejan diferente
                    if(!_.isEmpty(condicion_inicial.rango_minimo)){
                        $('#' + condicion_inicial.campo_destino_minimo).prop('checked', true);
                    }else{
                        $('#' + condicion_inicial.campo_destino_minimo).prop('checked', false);
                    }
                }else{ //procesa como un campo normal solo asignando los valores
                    $('#' + condicion_inicial.campo_destino_minimo).val(condicion_inicial.rango_minimo);
                    $('#' + condicion_inicial.campo_destino_maximo).val(condicion_inicial.rango_maximo);
                }
            }
        }, this);
    },

    // FUNCIONES DE UTILERIA //
    checarPorcentajeRango: function(evt){
        var valor_campo = $(evt.currentTarget).val();
        var valor_maximo = $('.' +$(evt.currentTarget).attr('data-max')).val();
        var valor_minimo = $('.' +$(evt.currentTarget).attr('data-min')).val();

        if(parseInt(valor_campo) > 99.99){
            app.alert.show('', {
                level: 'error',
                autoClose: true,
                messages: app.lang.get('LBL_PORCENTAGE_MAYOR_RANGO', 'lev_CondicionesFinancieras')
            });
            $(evt.currentTarget).val('99.99');
            $(evt.currentTarget).focus();
        }

        if(parseInt(valor_campo) < 1){
            app.alert.show('', {
                level: 'error',
                autoClose: true,
                messages: app.lang.get('LBL_PORCENTAGE_MENOR_RANGO', 'lev_CondicionesFinancieras')
            });
            $(evt.currentTarget).val('1');
            $(evt.currentTarget).focus();
        }

        if(parseInt(valor_campo) >  valor_maximo && !_.isEmpty(valor_maximo)){
            app.alert.show('', {
                level: 'error',
                autoClose: true,
                messages: app.lang.get('LBL_PORCENTAGE_MAYOR_A_MAXIMO', 'lev_CondicionesFinancieras') + " : " + valor_maximo
            });
            $(evt.currentTarget).val(valor_maximo);
            $(evt.currentTarget).focus();
        }

        if(parseInt(valor_campo) < valor_minimo && !_.isEmpty(valor_minimo)){
            app.alert.show('', {
                level: 'error',
                autoClose: true,
                messages: app.lang.get('LBL_PORCENTAGE_MENOR_MINIMO', 'lev_CondicionesFinancieras') + " : " + valor_minimo
            });
            $(evt.currentTarget).val(valor_minimo);
            $(evt.currentTarget).focus();
        }


    }
})
