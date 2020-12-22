({
    plugins: ['Dashlet'],

    events: {
        'click #btnNoViableActivo': 'noViableActivo',
    },

    dataAccSolicitudesActivo:[],

    initialize: function (options) {
        this._super("initialize", [options]);
        self_pi_activos = this;
        this.cuentasProspectInteresadoActivo();
    },


    cuentasProspectInteresadoActivo: function () {
        //API para obtener los Leads sin contactar con estatus Activo
        estActivo = "1";

        app.api.call('GET', app.api.buildURL('GetLeadsProspectoInteresado/'+ estActivo), null, {
            success: function (data) {

                self_pi_activos.dataAccSolicitudesActivo = data.records;
                // console.log(self_solpi.dataAccSolicitudes);
                self_pi_activos.render();
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
