({
    plugins: ['Dashlet'],

    events: {
        'click #btnNoViableExpActivo': 'noViableExpActivo',
        'click #btnCompExpActivo': 'CompExpedienteActivo',
        'click #btnAplazarExpActivo': 'AplazarProductoActivo',
    },

    dataCuentasExpActivo:[],

    initialize: function (options) {
        this._super("initialize", [options]);
        cuentas_exp_activo = this;
        this.cuentasExpProspectInteresadoActivo();
    },


    cuentasExpProspectInteresadoActivo: function () {
        //DASHLET: PROSPECTO EN INTEGRACION DE EXPEDIENTE
		estActivoExp = "1";
        app.api.call('GET', app.api.buildURL('GetCuentasExpediente/'+ estActivoExp), null, {
            success: function (data) {
				console.log(data);
                cuentas_exp_activo.dataCuentasExpActivo = data.records;
                // console.log(self_solpi.dataAccSolicitudes);
                _.each(cuentas_exp_activo.dataCuentasExpActivo, function (value, key) {
                    cuentas_exp_activo.dataCuentasExpActivo[key]['semaforo'] = (cuentas_exp_activo.dataCuentasExpActivo[key]['semaforo'] == "1") ? true : false;
                }),

                cuentas_exp_activo.render();
            },
            error: function (e) {
                throw e;
            }
        });
    },

    noViableExpActivo: function (events) {

        btnIdCuentaExpActivo = $(events.currentTarget).attr('title');
        
        var quickCreateView = null;
        if (!quickCreateView) {

            quickCreateView = app.view.createView ({
                context: this.context,
                name: 'ModalNoViableCuentas',
                layout: this.layout,
                module: 'Accounts',
                contextIdCuenta: btnIdCuentaExpActivo
            });

            this.layout._components.push(quickCreateView);
            this.layout.$el.append(quickCreateView.$el);

        }
        this.layout.trigger("app:view:ModalNoViableCuentas");
    },

    CompExpedienteActivo: function () {

        app.alert.show('go-to-compexp-activo', {
            level: 'info',
            title: 'Cuenta con el resto del día en curso, para completar el Expediente.',
            autoClose: false
        });
    },

    AplazarProductoActivo: function (events) {
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
