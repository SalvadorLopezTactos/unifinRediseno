({
    plugins: ['Dashlet'],

    events: {
        'click #btnNoViableExpAplazado': 'noViableExpActivo',
        'click #btnCompExpAplazado': 'CompExpedienteAplazado',
    },

    dataCuentasExpAplazado:[],

    initialize: function (options) {
        this._super("initialize", [options]);
        cuentas_exp_aplazado = this;
        this.cuentasProspectInteresadoExpAplazado();
    },


    cuentasProspectInteresadoExpAplazado: function () {
		estExpAplazado = "2";
        app.api.call('GET', app.api.buildURL('GetCuentasExpediente/'+ estExpAplazado), null, {
            success: function (data) {
				console.log(data);
                cuentas_exp_aplazado.dataCuentasExpAplazado = data.records;
                // console.log(self_solpi.dataAccSolicitudes);
                cuentas_exp_aplazado.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },

    noViableExpActivo: function (events) {

        btnIdCuentaExpAplazado = $(events.currentTarget).attr('title');
        
        var quickCreateView = null;
        if (!quickCreateView) {

            quickCreateView = app.view.createView ({
                context: this.context,
                name: 'ModalNoViableCuentas',
                layout: this.layout,
                module: 'Accounts',
                contextIdCuenta: btnIdCuentaExpAplazado
            });

            this.layout._components.push(quickCreateView);
            this.layout.$el.append(quickCreateView.$el);

        }
        this.layout.trigger("app:view:ModalNoViableCuentas");
    },

    CompExpedienteAplazado: function () {

        app.alert.show('go-to-compexp-aplazado', {
            level: 'info',
            title: 'Cuenta con el resto del día en curso, para completar el Expediente.',
            autoClose: false
        });
    },
})
