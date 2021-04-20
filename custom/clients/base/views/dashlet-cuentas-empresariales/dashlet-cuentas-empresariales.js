({
    plugins: ['Dashlet'],

    events: {
        'click #btnCompExpActivo': 'CompExpedienteActivo',
    },

    dataCuentasExpActivo:[],

    initialize: function (options) {
        this._super("initialize", [options]);
        cuentas_exp_activo = this;
        this.cuentasEmpresariales();
    },


    cuentasEmpresariales: function () {
        //DASHLET: CUENTAS EMPRESARIALES
		
    },

    CompExpedienteActivo: function () {

        app.alert.show('go-to-compexp-activo', {
            level: 'info',
            title: 'Cuenta con el resto del día en curso, para completar el Expediente.',
            autoClose: false
        });
    },

})
