({
    extendsFrom: 'CreateView',

    initialize: function (options) {
        this.plugins = _.union(this.plugins || [], ['AddAsInvitee', 'ReminderTimeDefaults']);
        self = this;
        this._super("initialize", [options]);
        this.on('render', this.disableparentsfields, this);
        // this.on('render',this.disabledates,this);

        // this.model.on("change:date_start_date", _.bind(this.validaFecha, this));
        this.model.on("change:tct_conferencia_chk_c", _.bind(this.ocultaConferencia, this));
        this.model.addValidationTask('VaildaFechaPermitida', _.bind(this.validaFechaInicialCall, this));
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
                title: "No puedes crear una Llamada con fecha menor al d&Iacutea de hoy",
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

    ocultaConferencia: function ()
    {
        if (this.model.get('tct_conferencia_chk_c'))
        {
            this.model.set('tct_resultado_llamada_ddw_c',"Conferencia");            
            this.$('div[data-name="tct_calificacion_conferencia_c"]').hide();
        }
    },    
})