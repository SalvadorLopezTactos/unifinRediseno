({
    plugins: ['Dashlet'],

    events: {
        'click #btnNoViableActivo': 'noViableActivo',
        'click #btnAplazarPIActivo': 'AplazarProductoPIActivo',
        'click #btnProspIntExpActivo': 'ConvertirProspIntExpActivo',
    },

    dataAccSolicitudesActivo: [],

    initialize: function (options) {
        this._super("initialize", [options]);
        self_pi_activos = this;
        this.cuentasProspectInteresadoActivo();
    },


    cuentasProspectInteresadoActivo: function () {
        //API para obtener los Leads sin contactar con estatus Activo - DASHLET: SOLICITUDES SIN PROCESO
        estActivo = "1";

        app.api.call('GET', app.api.buildURL('GetLeadsProspectoInteresado/' + estActivo), null, {
            success: function (data) {

                self_pi_activos.dataAccSolicitudesActivo = data.records;
                // console.log(self_solpi.dataAccSolicitudes);
                _.each(self_pi_activos.dataAccSolicitudesActivo, function (value, key) {
                    self_pi_activos.dataAccSolicitudesActivo[key]['semaforo'] = (self_pi_activos.dataAccSolicitudesActivo[key]['semaforo'] == "1") ? true : false;
                }),
                
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

            quickCreateView = app.view.createView({
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

    AplazarProductoPIActivo: function (events) {
        var userPItipoproducto = App.user.attributes.tipodeproducto_c; //Tipo de producto que tiene el usuario
        btnIdCuentaAplazadoPIActivo = $(events.currentTarget).attr('title');  //Obtiene el Id de la Cuenta
        var idProductoPI = '';

        if (btnIdCuentaAplazadoPIActivo != "") {

            app.alert.show('alert-aplazado-pi', {
                level: 'process',
                title: 'Cargando...',
            });

            app.api.call('GET', app.api.buildURL('GetProductosCuentas/' + btnIdCuentaAplazadoPIActivo), null, {
                success: function (data) {
                    ProductosPI = data;

                    _.each(ProductosPI, function (value, key) {
                        var tipoProductoPI = ProductosPI[key].tipo_producto;

                        if (tipoProductoPI == userPItipoproducto) { //Tipo de Producto Leasing "1"

                            idProductoPI = ProductosPI[key].id; //Id cuenta de uni productos "Leasing"

                            var producto = app.data.createBean('uni_Productos', { id: idProductoPI });
                            producto.fetch({
                                success: _.bind(function (model) {

                                    app.alert.dismiss('alert-aplazado-pi');

                                    app.alert.show('aplazado-pi-producto', {
                                        level: 'success',
                                        messages: 'Se establecio el producto como Aplazado...',
                                        autoClose: true
                                    });

                                    model.set('status_management_c', '2'); //ESTATUS PRODUCTO APLAZADO
                                    model.save();
                                    location.reload(); //refresca la página

                                }, self_pi_activos)
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

    ConvertirProspIntExpActivo: function () {

        app.alert.show('go-to-prospintexp-activo', {
            level: 'info',
            title: 'Cuenta con el resto del día en curso, para completar el activo, Scoring Comercial y asignación de Back Office para pasar a Prospecto en Integración de Expediente',
            autoClose: false
        });
    },
})
