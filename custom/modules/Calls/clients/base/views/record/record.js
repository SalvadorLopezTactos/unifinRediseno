({
        extendsFrom: 'RecordView',

        initialize: function (options) {
            self = this;
            this._super("initialize", [options]);

            this.on('render',this.disableparentsfields,this);
            this.model.addValidationTask('VaildaFechaPermitida', _.bind(this.validaFechaInicial, this));

        },

        _render: function () {
            this._super("_render");
        },

        /* @Alvador Lopez Y Adrian Arauz
           Oculta los campos relacionados
         */
        disableparentsfields:function () {
                this.$('[data-name="parent_name"]').attr('style', 'pointer-events:none;')
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


})