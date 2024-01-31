({
    extendsFrom: 'RecordView',
    seleccionado:null,

    initialize: function (options) {
        this._super("initialize", [options]);

        this.model.on('sync', this.ocultaOpcionesSubpanelSeguros, this);
        this.model.on('sync', this.validaEdicionMesCorriente, this);

        this.model.addValidationTask('validaMontosPrimas', _.bind(this.validaMontosPrimas, this));
        this.model.addValidationTask('valida_requeridos',_.bind(this.valida_requeridos, this));

    },

    _render: function (options) {
        this._super("_render");

    },

    ocultaOpcionesSubpanelSeguros: function (){

        //Oculta botón de creación en subpaneles
        $(".subpanels-layout")
            .find(".filtered.tabbable")
            .find('[name="create_button"]')
            .hide();
        //Oculta botón de creación en emails
        $(".subpanels-layout")
            .find(".filtered.tabbable")
            .find('[name="email_compose_button"]')
            .hide();
        //Oculta botón de acciones en subpaneles
        $(".subpanels-layout")
            .find(".filtered.tabbable")
            .find(".btn.dropdown-toggle")
            .hide();
        
         //Oculta subpanel completo de Oportunidades de Seguros Asociadas
        $('[data-subpanel-link="tctbl_backlog_seguros_s_seguros"]').hide()
    },

    validaEdicionMesCorriente: function () {

        var fechaActual = new Date();
        var diaDelMesActual = fechaActual.getDate();
        var mes_actual = fechaActual.getMonth() + 1;
        var anio_actual = fechaActual.getUTCFullYear();

        var mes_bl = this.model.get('mes');
        var anio_bl = this.model.get('anio');

        if (anio_bl < anio_actual || (anio_bl == anio_actual && mes_bl <= mes_actual && diaDelMesActual > 20)) {

            app.alert.show('message-id', {
                level: 'warning',
                title: "Registro no editable",
                messages: 'El periodo de edición del registro se ha vencido',
                autoClose: false
            });

            $('[name="edit_button"]').hide();

            $('.record').attr('style','pointer-events:none');
            // _.each(this.model.fields, function(field){
            //     this.noEditFields.push(field.name);
			// },this);

        }

    },


    validaMontosPrimas: function (fields, errors, callback){

        if (parseFloat(this.model.get('estimado_prima_neta_objetivo')) <= 0 || this.model.get('estimado_prima_neta_objetivo') == "")
        {
            errors['estimado_prima_neta_objetivo'] = errors['estimado_prima_neta_objetivo'] || {};
            errors['estimado_prima_neta_objetivo'].required = true;
        }

        if (parseFloat(this.model.get('estimado_prima_total_objetivo')) <= 0 || this.model.get('estimado_prima_total_objetivo') == "" )
        {
            errors['estimado_prima_total_objetivo'] = errors['estimado_prima_total_objetivo'] || {};
            errors['estimado_prima_total_objetivo'].required = true;
        }


        callback(null, fields, errors);
    },

    valida_requeridos: function(fields, errors, callback) {
        var campos = "";
        _.each(errors, function(value, key) {
            _.each(this.model.fields, function(field) {
                if(_.isEqual(field.name,key)) {
                    if(field.vname) {
                        campos = campos + '<b>' + app.lang.get(field.vname, "TCTBL_Backlog_Seguros") + '</b><br>';
                    }
                    }
            }, this);
        }, this);
        if(campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información en el registro:<br>" + campos,
                autoClose: false
            });
        }
    callback(null, fields, errors);
    },


})
