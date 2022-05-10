({
    plugins: ['Dashlet'],

    events: {
        'click #btnCancelAplazado': 'canceLeadAplazado',
        'click #btnProspectoAplazado': 'gotoLeadAplazado',
    },

    dataLeadAplazado:[],

    initialize: function (options) {
        this._super("initialize", [options]);
        self_lead_aplazado = this;
        this.leadNoAtendidoAplazado();
    },


    leadNoAtendidoAplazado: function () {
        //API para obtener los Leads sin contactar con estatus Aplazado
        estatusAplazado = "2";

        app.api.call('GET', app.api.buildURL('GetLeadsNoAtendidos/'+ estatusAplazado), null, {
            success: function (data) {

                self_lead_aplazado.dataLeadAplazado = data.records;
                
                self_lead_aplazado.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },

    gotoLeadAplazado: function () {

        app.alert.show('go-to-lead-aplazado', {
            level: 'info',
            title: 'Se direccionó al detalle del Lead, cuenta con lo que resta del día en curso para realizar una llamada o una reunión',
            autoClose: false
        });
    },

    canceLeadAplazado: function (events) {

        btnIdLeadCancelAplazado = $(events.currentTarget).attr('title');
        
        var quickCreateView = null;
        if (!quickCreateView) {

            quickCreateView = app.view.createView ({
                context: this.context,
                name: 'CancelModalLead',
                layout: this.layout,
                module: 'Leads',
                contextIdLead: btnIdLeadCancelAplazado
            });

            this.layout._components.push(quickCreateView);
            this.layout.$el.append(quickCreateView.$el);

        }
        this.layout.trigger("app:view:CancelModalLead");
    },
})
