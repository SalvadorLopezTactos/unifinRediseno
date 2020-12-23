({
    plugins: ['Dashlet'],

    events: {
        'click #btnCancelActivo': 'canceLeadActivos',
        'click #btnProspectoActivo': 'gotoLeadActivos',
    },

    dataLeadActivos:[],

    initialize: function (options) {
        this._super("initialize", [options]);
        self_lead_activo = this;
        this.leadNoAtendidosActivo();
    },


    leadNoAtendidosActivo: function () {
        //API para obtener los Leads sin contactar con estatus Activo 
        estatusActivo = "1";

        app.api.call('GET', app.api.buildURL('GetLeadsNoAtendidos/'+ estatusActivo), null, {
            success: function (data) {

                self_lead_activo.dataLeadActivos = data.records;
                
                self_lead_activo.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },

    gotoLeadActivos: function () {

        app.alert.show('go-to-lead-activos', {
            level: 'info',
            title: 'Se direccionó al detalle del Lead, favor de agregar una Reunión o Llamada...',
            autoClose: false
        });
    },

    canceLeadActivos: function (events) {

        btnIdLeadCancelActivo = $(events.currentTarget).attr('title');
        
        var quickCreateView = null;
        if (!quickCreateView) {

            quickCreateView = app.view.createView ({
                context: this.context,
                name: 'CancelModalLead',
                layout: this.layout,
                module: 'Leads',
                contextIdLead: btnIdLeadCancelActivo
            });

            this.layout._components.push(quickCreateView);
            this.layout.$el.append(quickCreateView.$el);

        }
        this.layout.trigger("app:view:CancelModalLead");
    },
})
