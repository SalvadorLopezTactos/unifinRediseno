({
    plugins: ['Dashlet'],

    events: {
        'click #btnCancelPCAplazado': 'noViablePCAplazado',
        'click #btnPresolicitudAplazado': 'preSolicitudPCAplazado',
    },

    dataAcProspectoContactadoAplazado: [],

    initialize: function (options) {
        this._super("initialize", [options]);
        self_pc_aplazado = this;
        this.cuentasProspectContactadoAplazado();
    },


    cuentasProspectContactadoAplazado: function () {
        //API para obtener los Cuentas prospecto contactado sin solicitudes
        estPCAplazado = "2";

        app.api.call('GET', app.api.buildURL('GetAccountProspectoContactado/' + estPCAplazado), null, {
            success: function (data) {

                self_pc_aplazado.dataAcProspectoContactadoAplazado = data.records;

                self_pc_aplazado.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },

    preSolicitudPCAplazado: function (events) {
        
        idCuentaAplazado = $(events.currentTarget).attr('title');

        app.alert.show('go-to-presolicitud-aplazado', {
            level: 'info',
            title: 'Cuenta con el resto del día en curso, para realizar una presolicitud',
            autoClose: false
        });

        app.alert.show('sol-pc-aplazado', {
            level: 'process',
            title: 'Cargando...',
        });
        
        app.api.call("read", app.api.buildURL("Accounts/" + idCuentaAplazado, null, null, {
            fields: "name",
        }), null, {
            success: _.bind(function (data) {

                app.alert.dismiss('sol-pc-aplazado');

                var objOpp = {
                    action: 'edit',
                    copy: true,
                    create: true,
                    layout: 'create',
                    module: 'Opportunities',
                    idAccount: idCuentaAplazado,
                    idNameAccount: data.name
                };
                app.controller.loadView(objOpp);
                // update the browser URL with the proper
                app.router.navigate('#Opportunities/create', { trigger: false });
            }, this)
        });
    },

    noViablePCAplazado: function (events) {

        btnIdCuentaPCAplazado = $(events.currentTarget).attr('title');

        var quickCreateView = null;
        if (!quickCreateView) {

            quickCreateView = app.view.createView({
                context: this.context,
                name: 'ModalNoViableCuentas',
                layout: this.layout,
                module: 'Accounts',
                contextIdCuenta: btnIdCuentaPCAplazado
            });

            this.layout._components.push(quickCreateView);
            this.layout.$el.append(quickCreateView.$el);

        }
        this.layout.trigger("app:view:ModalNoViableCuentas");
    },
})
