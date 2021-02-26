({
    plugins: ['Dashlet'],

    events: {
        'click #btnCancelPCActivo': 'noViablePCActivo',
        'click #btnPresolicitudActivo': 'preSolicitudPCActivo',
        'click #btnAplazarPCActivo': 'AplazarProductoPCActivo',
    },

    dataAcProspectoContactadoActivo: [],

    initialize: function (options) {
        this._super("initialize", [options]);
        self_pc_activos = this;
        this.cuentasProspectContactadoActivo();
    },


    cuentasProspectContactadoActivo: function () {
        //API para obtener los Cuentas prospecto contactado sin solicitudes DASHLET: PROSPECTOS SIN SOLICITUD
        estPCActivo = "1";

        app.api.call('GET', app.api.buildURL('GetAccountProspectoContactado/' + estPCActivo), null, {
            success: function (data) {

                self_pc_activos.dataAcProspectoContactadoActivo = data.records;

                _.each(self_pc_activos.dataAcProspectoContactadoActivo, function (value, key) {
                    self_pc_activos.dataAcProspectoContactadoActivo[key]['semaforo'] = (self_pc_activos.dataAcProspectoContactadoActivo[key]['semaforo'] == "1") ? true : false;
                }),
                
                self_pc_activos.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },

    preSolicitudPCActivo: function (events) {

        idCuentaActivo = $(events.currentTarget).attr('title');

        app.alert.show('go-to-presolicitud-activo', {
            level: 'info',
            title: 'Cuenta con el resto del día en curso, para realizar una presolicitud',
            autoClose: false
        });

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

    AplazarProductoPCActivo: function (events) {
        var userPCtipoproducto = App.user.attributes.tipodeproducto_c; //Tipo de producto que tiene el usuario
        btnIdCuentaAplazadoPCActivo = $(events.currentTarget).attr('title');  //Obtiene el Id de la Cuenta
        var idProductoPC = '';

        if (btnIdCuentaAplazadoPCActivo != "") {

            app.alert.show('alert-aplazado-pc', {
                level: 'process',
                title: 'Cargando...',
            });

            app.api.call('GET', app.api.buildURL('GetProductosCuentas/' + btnIdCuentaAplazadoPCActivo), null, {
                success: function (data) {
                    ProductosPC = data;

                    _.each(ProductosPC, function (value, key) {
                        var tipoProductoPC = ProductosPC[key].tipo_producto;

                        if (tipoProductoPC == userPCtipoproducto) { //Tipo de Producto Leasing "1"

                            idProductoPC = ProductosPC[key].id; //Id cuenta de uni productos "Leasing"

                            var producto = app.data.createBean('uni_Productos', { id: idProductoPC });
                            producto.fetch({
                                success: _.bind(function (model) {

                                    app.alert.dismiss('alert-aplazado-pc');

                                    app.alert.show('aplazado-pc-producto', {
                                        level: 'success',
                                        messages: 'Se establecio el producto como Aplazado...',
                                        autoClose: true
                                    });

                                    model.set('status_management_c', '2'); //ESTATUS PRODUCTO APLAZADO
                                    model.save();
                                    location.reload(); //refresca la página

                                }, self_pc_activos)
                            });
                        }
                    });
                },
                error: function (e) {
                    throw e;
                }
            });
        }
    },
})
