({
    plugins: ['Dashlet'],

    events: {
        'click #btnNoViableActivo': 'noViableActivo',
    },

    dataCuentas:[],

    initialize: function (options) {
        this._super("initialize", [options]);
        cuentas_exp = this;
        this.cuentasProspectInteresadoActivo();
    },


    cuentasProspectInteresadoActivo: function () {
		estActivo = "1";
        app.api.call('GET', app.api.buildURL('GetCuentasExpediente/'+ estActivo), null, {
            success: function (data) {
				console.log(data);
                cuentas_exp.dataCuentas = data.records;
                // console.log(self_solpi.dataAccSolicitudes);
                cuentas_exp.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },

    noViableActivo: function (events) {

        btnIdCuentaActivo = $(events.currentTarget).attr('title');
        
        var quickCreateView = null;
        if (!quickCreateView) {

            quickCreateView = app.view.createView ({
                context: this.context,
                name: 'ModalNoViableCuentas',
                layout: this.layout,
                module: 'Accounts',
                contextIdCuenta: btnIdCuentaActivo
            });

            this.layout._components.push(quickCreateView);
            this.layout.$el.append(quickCreateView.$el);

        }
        this.layout.trigger("app:view:ModalNoViableCuentas");
    },
})
