({
    /**
     * Modified by Adrian Arauz 21/11/2019
     */
    //Declaración de Listas de valores
    activo_list: null,
    plazo_list: null,

    events: {
        'click  .addCondicionFinanciera': 'addNewCondicionFinanciera',
        'click  .removeCondicionFinanciera': 'removeCondicionFinanciera',
        'change .porcentaje': 'checarPorcentajeRango',
        'change .existingActivo': 'updateExistingCondicionFinanciera',
        'change .newActivo': '_inicializaCondicionesFinancieras',
        'change .existingPlazo': 'updateExistingCondicionFinanciera',
        'change .porcentaje': 'updateExistingCondicionFinanciera',
        'change .checkboxUpdate': 'updateExistingCondicionFinanciera',
        'change .newPlazo': '_inicializaCondicionesFinancieras_Plazo',
    },

    plugins: ['Tooltip', 'ListEditable', 'EmailClientLaunch'],

    initialize: function (options) {

        //window.contador=0;
        options = options || {};
        options.def = options.def || {};
        cont_cf = this;
        this._super('initialize', [options]);
        this.listascf();


    },

    listascf: function () {
    this.activo_list = app.lang.getAppListStrings('idactivo_list');
    this.plazo_list = app.lang.getAppListStrings('plazo_0');
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
        this._super("_render");

    },

    /*_buildCondicionFinancieraFieldHtml: function (condicion_financiera) {
        var editCondicionFinancieraFieldTemplate = app.template.getField('condiciones_financieras', 'edit-condiciones-financieras'),
            CondicionFinanciera = this.model.get('condiciones_financieras'),
            index = _.indexOf(CondicionFinanciera, condicion_financiera);
        var activo_list = app.lang.getAppListStrings('idactivo_list');
        var activo_list_html = '';

        for (activo_tipo_key in activo_list) {
            if (activo_tipo_key == condicion_financiera.idactivo) {
                activo_list_html += '<option value="' + activo_tipo_key + '" selected="true">' + activo_list[activo_tipo_key] + '</option>';

            }
            else {
                activo_list_html += '<option value="' + activo_tipo_key + '">' + activo_list[activo_tipo_key] + '</option>';

            }
        }

        var plazo_list = app.lang.getAppListStrings('plazo_0');
        var plazo_list_html = '';

        for (plazo_tipo_key in plazo_list) {
            if (plazo_tipo_key == condicion_financiera.plazo) {
                plazo_list_html += '<option value="' + plazo_tipo_key + '" selected="true">' + plazo_list[plazo_tipo_key] + '</option>';

            }
            else {
                plazo_list_html += '<option value="' + plazo_tipo_key + '">' + plazo_list[plazo_tipo_key] + '</option>';

            }
        }

        if (condicion_financiera.deposito_en_garantia == true) {
            var deposito_en_garantia_checked = "checked";
        }

        if (condicion_financiera.uso_particular == true) {
            var uso_particular_checked = "checked";
        }

        if (condicion_financiera.uso_empresarial == true) {
            var uso_empresarial_checked = "checked";
        }

        if (condicion_financiera.activo_nuevo == true) {
            var activo_nuevo_checked = "checked";
        }
        return editCondicionFinancieraFieldTemplate({
            max_length: this.def.len,
            index: index === -1 ? condicion_financiera.length - 1 : index,
            idactivo: activo_list_html,
            plazo: plazo_list_html,
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
    },*/

    addNewCondicionFinanciera: function (options) {
        if (this.oFinanciera == undefined) {
            this.oFinanciera = self.oFinanciera;
        }
        if (this.$('.newActivo').select2('val') !="" && this.$('.newActivo').select2('val')!=null) {
            //Valida Requerido
            if (this.$('.newPlazo').select2('val') === '') {
                this.$('.newPlazo').find('.select2-choice').css('border-color', 'red');
                app.alert.show("Plazo requerido", {
                    level: "error",
                    title: "El campo Plazo es requerido.",
                    autoClose: false
                });
            }else {

                //Obtiene Valores de los campos
                var idActivo = this.$('.newActivo').select2('val');
                var idplazo = this.$('.newPlazo').select2('val');
                var tasa_minima = $('.newTasaMinima').val();
                var tasa_maxima = $('.newTasaMaxima').val();
                var vrc_minimo = $('.newVRCMinimo').val();
                var vrc_maximo = $('.newVRCMaximo').val();
                var vri_minimo = $('.newVRIMinimo').val();
                var vri_maximo = $('.newVRIMaximo').val();
                var comision_minima = $('.newComisionMinima').val();
                var comision_maxima = $('.newComisionMaxima').val();
                var renta_inicial_minima = $('.newRentaInicialMinima').val();
                var renta_inicial_maxima = $('.newRentaInicialMaxima').val();
                var deposito_en_garantia = $('.newDeposito').prop("checked");
                var uso_particular = $('.newUsoParticular').prop("checked");
                var uso_empresarial = $('.newUsoEmpresarial').prop("checked");
                var activo_nuevo = $('.newActivoNuevo').prop("checked");

                //Crea objeto condiciones financieras
                var condfin = {
                    "idactivo": idActivo,
                    "plazo": idplazo,
                    "tasa_minima": tasa_minima,
                    "tasa_maxima": tasa_maxima,
                    "vrc_minimo": vrc_minimo,
                    "vrc_maximo": vrc_maximo,
                    "vri_minimo": vri_minimo,
                    "vri_maximo": vri_maximo,
                    "comision_minima": comision_minima,
                    "comision_maxima": comision_maxima,
                    "renta_inicial_minima": renta_inicial_minima,
                    "renta_inicial_maxima": renta_inicial_maxima,
                    "deposito_en_garantia": deposito_en_garantia,
                    "uso_particular": uso_particular,
                    "uso_empresarial": uso_empresarial,
                    "activo_nuevo": activo_nuevo
                };

                //Setea valores al objeto
                this.oFinanciera.condicion.push(condfin);
                this.render();
            }
        }else{
            $('.newActivo').find('.select2-choice').css('border-color', 'red');
            app.alert.show("Activo requerido", {
                level: "error",
                title: "El campo Activo es requerido.",
                autoClose: false
            });
        }

    },

   /* _addNewCondicionFinancieraToModel: function (idactivo) {
        var existingCondicionFinanciera = app.utils.deepCopy(this.model.get('condiciones_financieras'));
        existingCondicionFinanciera.push({
            idactivo: idactivo,
            activo: $('.newActivo').val(),
            plazo: $('.newPlazo').val(),
            tasa_minima: $('.newTasaMinima').val(),
            tasa_maxima: $('.newTasaMaxima').val(),
            vrc_minimo: $('.newVRCMinimo').val(),
            vrc_maximo: $('.newVRCMaximo').val(),
            vri_minimo: $('.newVRIMinimo').val(),
            vri_maximo: $('.newVRIMaximo').val(),
            comision_minima: $('.newComisionMinima').val(),
            comision_maxima: $('.newComisionMaxima').val(),
            renta_inicial_minima: $('.newRentaInicialMinima').val(),
            renta_inicial_maxima: $('.newRentaInicialMaxima').val(),
            deposito_en_garantia: $('.newDeposito').prop("checked"),
            uso_particular: $('.newUsoParticular').prop("checked"),
            uso_empresarial: $('.newUsoEmpresarial').prop("checked"),
            activo_nuevo: $('.newActivoNuevo').prop("checked"),
        });
        console.log("existingCondicionFinanciera");
        console.log(existingCondicionFinanciera);
        this.model.set(this.name, existingCondicionFinanciera);
        success = true;

        return success;
    },

    removeCondicionFinanciera: function (evt) {
        if (!evt) return;

        var $deleteButtons = this.$('.removeCondicionFinanciera'),
            $deleteButton = this.$(evt.currentTarget),
            index = $deleteButtons.index($deleteButton),
            primaryRemoved,
            $removeThisField;

        primaryRemoved = this._removeCondicionFinancieraInModel(index);

        $removeThisField = $deleteButton.closest('.condiciones_financieras');
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
        this._getNewCondicionFinancieraField().val('');
        $('.newActivo').val('');
        $('.newPlazo').val('');
        $('.newTasaMinima').val('');
        $('.newTasaMaxima').val('');
        $('.newVRCMinimo').val('');
        $('.newVRCMaximo').val('');
        $('.newVRIMinimo').val('');
        $('.newVRIMaximo').val('');
        $('.newComisionMinima').val('');
        $('.newComisionMaxima').val('');
        $('.newRentaInicialMinima').val('');
        $('.newRentaInicialMaxima').val('');
        $('.newDeposito').prop("checked", false);
        $('.newUsoParticular').prop("checked", false);
        $('.newUsoEmpresarial').prop("checked", false);
        $('.newActivoNuevo').prop("checked", false);
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

        if (class_name_split[0][1] == "checkboxUpdate") {
            newCFinanciera = $input.prop("checked");
        }

        newCFinanciera = $.trim(newCFinanciera);
        if (newCFinanciera === '') {
            // remove email if email is empty
            primaryRemoved = this._removeCondicionFinancieraInModel(index);

            $input
                .closest('.condiciones_financieras')
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
        var existingCFinanciera = app.utils.deepCopy(this.model.get('condiciones_financieras'));
        //Simply update the email address
        existingCFinanciera[index][field_name] = newCFinanciera;
        this.model.set(this.name, existingCFinanciera);
    },

    _getNewCondicionFinancieraField: function () {
        return this.$('.newActivo');
    },

    _inicializaCondicionesFinancieras: function (evt) {
        if (!evt) return;
        //Obten el campo que acaba de cambiar
        var $input = this.$(evt.currentTarget);
        _.each(cont_cf.condiciones_iniciales, function (condicion_inicial) {
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
        _.each(cont_cf.condiciones_iniciales, function (condicion_inicial) {
            if ($input.val() == condicion_inicial.plazo && $('.newActivo').val() == condicion_inicial.activo) { //Detecta si el activo seleccionado coincide con la lista que se esta ciclando
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
    checarPorcentajeRango: function (evt) {
        var valor_campo = $(evt.currentTarget).val();
        var valor_maximo = $('.' + $(evt.currentTarget).attr('data-max')).val();
        var valor_minimo = $('.' + $(evt.currentTarget).attr('data-min')).val();

        if (parseInt(valor_campo) > 99.99) {
            app.alert.show('', {
                level: 'error',
                autoClose: true,
                messages: app.lang.get('LBL_PORCENTAGE_MAYOR_RANGO', 'lev_CondicionesFinancieras')
            });
            $(evt.currentTarget).val('99.99');
            $(evt.currentTarget).focus();
        }

        if (parseInt(valor_campo) < 1) {
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
    }*/
})
