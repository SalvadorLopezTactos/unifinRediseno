({
    plugins: ['Dashlet'],

    events: {
        'click #btnNoViableExpActivo': 'noViableExpActivo',
        'click #btnCompExpActivo': 'CompExpedienteActivo',
    },

    dataCuentasExpActivo:[],

    initialize: function (options) {
        this._super("initialize", [options]);
        cuentas_exp_activo = this;
        this.cuentasExpProspectInteresadoActivo();
    },


    cuentasExpProspectInteresadoActivo: function () {
        //DASHLET: PROSPECTO EN INTEGRACION DE EXPEDIENTE
		estActivoExp = "1";
        app.api.call('GET', app.api.buildURL('GetCuentasExpediente/'+ estActivoExp), null, {
            success: function (data) {
				console.log(data);
                cuentas_exp_activo.dataCuentasExpActivo = data.records;
                // console.log(self_solpi.dataAccSolicitudes);
                _.each(cuentas_exp_activo.dataCuentasExpActivo, function (value, key) {
                    cuentas_exp_activo.dataCuentasExpActivo[key]['semaforo'] = (cuentas_exp_activo.dataCuentasExpActivo[key]['semaforo'] == "1") ? true : false;
                }),

                cuentas_exp_activo.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },

    noViableExpActivo: function (events) {

        btnIdCuentaExpActivo = $(events.currentTarget).attr('title');
        
        var quickCreateView = null;
        if (!quickCreateView) {

            quickCreateView = app.view.createView ({
                context: this.context,
                name: 'ModalNoViableCuentas',
                layout: this.layout,
                module: 'Accounts',
                contextIdCuenta: btnIdCuentaExpActivo
            });

            this.layout._components.push(quickCreateView);
            this.layout.$el.append(quickCreateView.$el);

        }
        this.layout.trigger("app:view:ModalNoViableCuentas");
    },

    CompExpedienteActivo: function () {

        app.alert.show('go-to-compexp-activo', {
            level: 'info',
            title: 'Cuenta con el resto del día en curso, para completar el Expediente.',
            autoClose: false
        });
    },
})
