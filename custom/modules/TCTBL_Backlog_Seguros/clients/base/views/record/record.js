({
    extendsFrom: 'RecordView',
    seleccionado:null,

    initialize: function (options) {
        this._super("initialize", [options]);

        this.model.on('sync', this.ocultaOpcionesSubpanelSeguros, this);
        this.model.on('sync', this.validaEdicionMesCorriente, this);

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

    }


})
