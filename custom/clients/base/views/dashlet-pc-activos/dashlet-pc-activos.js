({
    plugins: ['Dashlet'],

    events: {
        'click #btnCancelPCActivo': 'noViablePCActivo',
        'click #btnPresolicitudActivo': 'preSolicitudPCActivo',
    },

    dataAcProspectoContactadoActivo: [],

    initialize: function (options) {
        this._super("initialize", [options]);
        self_pc_activos = this;
        this.cuentasProspectContactadoActivo();
    },


    cuentasProspectContactadoActivo: function () {
        //API para obtener los Cuentas prospecto contactado sin solicitudes
        estPCActivo = "1";

        app.api.call('GET', app.api.buildURL('GetAccountProspectoContactado/' + estPCActivo), null, {
            success: function (data) {

                self_pc_activos.dataAcProspectoContactadoActivo = data.records;

                self_pc_activos.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },

    preSolicitudPCActivo: function (events) {

        idCuentaActivo = $(events.currentTarget).attr('title');

        app.alert.show('sol-pc-activo', {
            level: 'process',
            title: 'Cargando...',
        });

        app.api.call("read", app.api.buildURL("Accounts/" + idCuentaActivo, null, null, {
            fields: "name",
        }), null, {
            success: _.bind(function (data) {

                app.alert.dismiss('sol-pc-activo');

                var objOpp = {
                    action: 'edit',
                    copy: true,
                    create: true,
                    layout: 'create',
                    module: 'Opportunities',
                    idAccount: idCuentaActivo,
                    idNameAccount: data.name
                };
                app.controller.loadView(objOpp);
                // update the browser URL with the proper
                app.router.navigate('#Opportunities/create', { trigger: false });
            }, this)
        });
    },

    noViablePCActivo: function (events) {

        btnIdCuentaPCActivo = $(events.currentTarget).attr('title');

        var quickCreateView = null;
        if (!quickCreateView) {

            quickCreateView = app.view.createView({
                context: this.context,
                name: 'ModalNoViableCuentas',
                layout: this.layout,
                module: 'Accounts',
                contextIdCuenta: btnIdCuentaPCActivo
            });

            this.layout._components.push(quickCreateView);
            this.layout.$el.append(quickCreateView.$el);

        }
        this.layout.trigger("app:view:ModalNoViableCuentas");
    },
})
