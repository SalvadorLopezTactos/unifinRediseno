({
    extendsFrom: 'CreateView',

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
        this.model.addValidationTask('Valida_cuenta', _.bind(this.validacuenta, this));
        this.model.addValidationTask('Valida_noViable', _.bind(this.validaNoViable, this));
    },

    _render: function () {
        this._super("_render");
    },

    validacuenta: function (fields, errors, callback) {
        var cuenta=this.model.get('lic_licitaciones_accounts_name');
        if (cuenta==""|| cuenta==null) {
            app.alert.show("cuentaFaltante", {
                level: "error",
                title: "No se puede guardar el registro sin una cuenta asociada. Favor de verificar.",
                autoClose: false
            });
            errors['lic_licitaciones_accounts_name'] = errors['lic_licitaciones_accounts_name'] || {};
            errors['lic_licitaciones_accounts_name'].required = true;
        }
        callback(null, fields, errors);
    },

    validaNoViable: function (fields, errors, callback) {
        var resultado=this.model.get('resultado_licitacion_c');
        var razon=this.model.get('razon_no_viable_c');
        if (resultado=="2" && (razon=="" ||razon==null)) {
            app.alert.show("noViableFaltante", {
                level: "error",
                title: "Hace falta seleccionar una razón de no viable.",
                autoClose: false
            });
            errors['razon_no_viable_c'] = errors['razon_no_viable_c'] || {};
            errors['razon_no_viable_c'].required = true;
        }
        callback(null, fields, errors);
    },
})
