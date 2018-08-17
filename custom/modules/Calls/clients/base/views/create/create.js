({
    extendsFrom: 'CreateView',

    initialize: function (options) {
        this.plugins = _.union(this.plugins || [], ['AddAsInvitee', 'ReminderTimeDefaults']);
        self = this;
        this._super("initialize", [options]);
        this.on('render', this.disableparentsfields, this);
        // this.on('render',this.disabledates,this);

        // this.model.on("change:date_start_date", _.bind(this.validaFecha, this));
        this.model.addValidationTask('VaildaFechaPermitida', _.bind(this.validaFechaInicial, this));
    },

    /* @F. Javier G. Solar
     * Valida que la Fecha Inicial no sea menor que la actual
     * 14/08/2018
     */
    validaFechaInicial: function (fields, errors, callback) {
        var hoy =Date.parse(new Date());
        var fechaInicio =Date.parse(this.model.get("date_start"));

        if(fechaInicio<hoy)
        {
            app.alert.show("Fecha no valida", {
                level: "error",
                title: "La Fecha Inicio no puede ser menor a la actual ",
                autoClose: false
            });
            app.error.errorName2Keys['date_start'] = 'La fecha no puede ser menor a la actual';
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
})