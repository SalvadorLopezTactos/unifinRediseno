({
    plugins: ['Dashlet'],

    events: {
        'click #btnNoViableAplazados': 'noViableAplazados',
        'click #btnProspIntExpAplazado': 'ConvertirProspIntExpAplazado',
    },

    dataAccSolicitudesAplazados:[],

    initialize: function (options) {
        this._super("initialize", [options]);
        self_pi_aplazados = this;
        this.cuentasProspectInteresadoAplazados();
    },


    cuentasProspectInteresadoAplazados: function () {
        //API para obtener los Leads sin contactar con estatus Activo
        estAplazados = "2";

        app.api.call('GET', app.api.buildURL('GetLeadsProspectoInteresado/'+ estAplazados), null, {
            success: function (data) {

                self_pi_aplazados.dataAccSolicitudesAplazados = data.records;
                // console.log(self_solpi.dataAccSolicitudes);
                self_pi_aplazados.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },

    noViableAplazados: function (events) {

        btnIdCuentaAplazados = $(events.currentTarget).attr('title');
        
        var quickCreateView = null;
        if (!quickCreateView) {

            quickCreateView = app.view.createView ({
                context: this.context,
                name: 'ModalNoViableCuentas',
                layout: this.layout,
                module: 'Accounts',
                contextIdCuenta: btnIdCuentaAplazados
            });

            this.layout._components.push(quickCreateView);
            this.layout.$el.append(quickCreateView.$el);

        }
        this.layout.trigger("app:view:ModalNoViableCuentas");
    },

    ConvertirProspIntExpAplazado: function () {

        app.alert.show('go-to-prospintexp-aplazado', {
            level: 'info',
            title: 'Cuenta con el resto del día en curso, para completar el activo, Scoring Comercial y asignación de Back Office para pasar a Prospecto en Integración de Expediente',
            autoClose: false
        });
    },
})
