({
    plugins: ['Dashlet'],

    events: {
        'click #btnCancel': 'canceLead',
    },

    dataLead:[],

    initialize: function (options) {
        this._super("initialize", [options]);
        self_leadnc = this;
        this.leadNoContactado();
    },


    leadNoContactado: function () {
        //API para obtener los Leads sin contactar
        app.api.call('GET', app.api.buildURL('GetLeadsNoAtendidos/'), null, {
            success: function (data) {

                self_leadnc.dataLead = data.records;
                // console.log(self_leadnc.dataLead);
                self_leadnc.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },

    canceLead: function (events) {

        btnIdLeadCancel = $(events.currentTarget).attr('title');
        
        var quickCreateView = null;
        if (!quickCreateView) {

            quickCreateView = app.view.createView ({
                context: this.context,
                name: 'CancelModalLead',
                layout: this.layout,
                module: 'Leads',
                contextIdLead: btnIdLeadCancel
            });

            this.layout._components.push(quickCreateView);
            this.layout.$el.append(quickCreateView.$el);

        }
        this.layout.trigger("app:view:CancelModalLead");
    },
})
