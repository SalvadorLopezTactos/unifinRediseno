({
    plugins: ['Dashlet'],

    events: {
        'click #btnCancelActivo': 'canceLeadActivos',
        'click #btnProspectoActivo': 'gotoLeadActivos',
        'click #btnAplazarActivo': 'gotoAplazarLeadActivos',
    },

    dataLeadActivos: [],

    initialize: function (options) {
        this._super("initialize", [options]);
        self_lead_activo = this;
        this.leadNoAtendidosActivo();
    },


    leadNoAtendidosActivo: function () {
        //API para obtener los Leads sin contactar con estatus Activo 
        estatusActivo = "1";

        app.api.call('GET', app.api.buildURL('GetLeadsNoAtendidos/' + estatusActivo), null, {
            success: function (data) {

                self_lead_activo.dataLeadActivos = data.records;

                _.each(self_lead_activo.dataLeadActivos, function (value, key) {
                    self_lead_activo.dataLeadActivos[key]['semaforo'] = (self_lead_activo.dataLeadActivos[key]['semaforo'] == "1") ? true : false;
                }),

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
            title: 'Se direccionó al detalle del Lead, cuenta con lo que resta del día en curso para realizar una llamada o una reunión',
            autoClose: false
        });
    },

    canceLeadActivos: function (events) {

        btnIdLeadCancelActivo = $(events.currentTarget).attr('title');

        var quickCreateView = null;
        if (!quickCreateView) {

            quickCreateView = app.view.createView({
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

    gotoAplazarLeadActivos: function (events) {

        btnIdAplazarLeadlActivo = $(events.currentTarget).attr('title');
        
        if (btnIdAplazarLeadlActivo != "") {

            app.alert.show('aplazar-lead-activo', {
                level: 'process',
                title: 'Cargando...',
            });

            var lead = app.data.createBean('Leads', { id: btnIdAplazarLeadlActivo });
            lead.fetch({
                success: _.bind(function (model) {

                    app.alert.dismiss('aplazar-lead-activo');

                    app.alert.show('lead-activo-aplazado', {
                        level: 'success',
                        messages: 'Lead Aplazado...',
                        autoClose: true
                    });

                    model.set('status_management_c', '2');  //Cambia Estatus "Aplazado"
                    model.save();
                    location.reload(); //refresca la página

                }, self_lead_activo)
            });
        }
    },
})
