({
    plugins: ['Dashlet'],

    events: {
        'click #btnNoViable': 'noViable',
    },

    dataAccSolicitudes:[],

    initialize: function (options) {
        this._super("initialize", [options]);
        self_solpi = this;
        this.cuentasProspectInteresado();
    },


    cuentasProspectInteresado: function () {
        //API para obtener los Leads sin contactar
        app.api.call('GET', app.api.buildURL('GetLeadsProspectoInteresado/'), null, {
            success: function (data) {

                self_solpi.dataAccSolicitudes = data.records;
                // console.log(self_solpi.dataAccSolicitudes);
                self_solpi.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },

    noViable: function (events) {

        btnIdCuenta = $(events.currentTarget).attr('title');
        
        var quickCreateView = null;
        if (!quickCreateView) {

            quickCreateView = app.view.createView ({
                context: this.context,
                name: 'ModalNoViableCuentas',
                layout: this.layout,
                module: 'Accounts',
                contextIdCuenta: btnIdCuenta
            });

            this.layout._components.push(quickCreateView);
            this.layout.$el.append(quickCreateView.$el);

        }
        this.layout.trigger("app:view:ModalNoViableCuentas");
    },
})
