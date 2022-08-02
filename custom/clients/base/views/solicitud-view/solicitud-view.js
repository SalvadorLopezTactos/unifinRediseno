
({

    className: 'solicitud-view',

    events: {
        'click .preSolicitud':'preSolicitud',
        'click .ratificaIncremento': 'ratificaIncremento',
        'click .ratificaIncrementoUnico': 'ratificaIncrementoUnico',
        'click .cierraSolicitud': 'cierraSolicitud',

    },

    initialize: function(options){
        this._super("initialize", [options]);
        nuevaSolicitud = this;
        nuevaSolicitud.idCuenta = this.context.attributes.nuevaOpp.idCuenta;
        nuevaSolicitud.nombreCuenta = this.context.attributes.nuevaOpp.nombreCuenta;
        nuevaSolicitud.idProducto = this.context.attributes.nuevaOpp.idProducto;
        nuevaSolicitud.solicitudes = [];
        nuevaSolicitud.loadView = false;
        nuevaSolicitud.muestraSolicitudes = false;
        nuevaSolicitud.filters = '';
        switch (nuevaSolicitud.idProducto) {
          case "1": //leasing
            nuevaSolicitud.filters = "filter[0][account_id][$equals]="+nuevaSolicitud.idCuenta+"&filter[1][tipo_producto_c][$equals]="+nuevaSolicitud.idProducto+"&filter[2][estatus_c][$not_equals]=K";
            break;
          case "2": //Crédito simple
            nuevaSolicitud.filters = "filter[0][account_id][$equals]="+nuevaSolicitud.idCuenta+"&filter[1][tipo_producto_c][$equals]="+nuevaSolicitud.idProducto+"&filter[2][estatus_c][$not_equals]=K&filter[3][negocio_c][$not_equals]=10";
            break;
          case "4": //Factoraje
            nuevaSolicitud.filters = "filter[0][account_id][$equals]="+nuevaSolicitud.idCuenta+"&filter[1][tipo_producto_c][$equals]="+nuevaSolicitud.idProducto+"&filter[2][estatus_c][$not_equals]=K";
            break;
          default:
        }
        //Recupera líneas existentes
        App.alert.show('loadingOpptys', {
            level: 'process',
            title: 'Cargando...',
        });
        App.api.call("read", app.api.buildURL("Opportunities?"+nuevaSolicitud.filters+"&fields=tipo_operacion_c,tipo_producto_c,producto_financiero_c,negocio_c,tct_etapa_ddw_c,estatus_c,tipo_operacion_c,tipo_de_operacion_c,ratificacion_incremento_c,name,monto_c,assigned_user_name", null, null, {
        }), null, {
            success: _.bind(function (data) {
                if(data.records){
                    nuevaSolicitud.solicitudes = data.records;
                }
                nuevaSolicitud.loadView = true;
                App.alert.dismiss('loadingOpptys');
                nuevaSolicitud.render();
            }, this)
        });

    },

    _render: function () {
        this._super("_render");
    },

    preSolicitud: function () {
        // Drawer Pre-solicitud
        var modeloOppty = App.data.createBean('Opportunities');
        modeloOppty.set('account_id',nuevaSolicitud.idCuenta);
        modeloOppty.set('account_name',nuevaSolicitud.nombreCuenta);
        modeloOppty.set('tipo_producto_c',nuevaSolicitud.idProducto);

        App.drawer.load({
            layout: 'create',
            context: {
                create: true,
                module: 'Opportunities',
                model: modeloOppty
                },
            },
            function(variable){
                console.log("Cierra drawer de Opportunities");
            }
        );

    },

    ratificaIncremento: function () {
        if(nuevaSolicitud.solicitudes.length == 1){
            //Redirect
            window.open("#Opportunities/"+nuevaSolicitud.solicitudes[0].id);
            App.drawer.reset();
        }else if(nuevaSolicitud.solicitudes.length>1){
            nuevaSolicitud.muestraSolicitudes = true;
            nuevaSolicitud.render();
        }
    },

    ratificaIncrementoUnico: function (e) {
        var idSolicitud = $(e.currentTarget).attr('data-name');
        window.open("#Opportunities/"+idSolicitud);
        App.drawer.reset();
        //redirect
    },

    cierraSolicitud: function () {
        App.drawer.close();
    },



})
