({
    initialize: function (options) {

        selfDisposiciones = this;
        options = options || {};
        options.def = options.def || {};

        self_disposiciones=this;
        this._super('initialize', [options]);

        this.getDisposicionesDWH();
    },

    getDisposicionesDWH: function (options) {
        
        //var id_cliente='a54b31cc-1296-11e9-bb47-00155d967307';
        var id_cliente=this.model.get('id');
        app.alert.show('getDisposiciones', {
            level: 'process',
            title: 'Cargando...',
        });
        
        app.api.call('GET', app.api.buildURL('GetDisposicionesDWH/'+id_cliente), null, {
            success: function (data) {
                App.alert.dismiss('getDisposiciones');
                if(data.length>0){
                    var arrDiposiciones=[];
                    var arrDisposicionesNumero=[];
                    var arrDisposicionesFinal=[];
                    //Recorre objeto para únicamente
                    for (const key in data) {
                        console.log(data.idSolicitud);
                        if(!arrDiposiciones.includes(data[key].idSolicitud) && data[key].idSolicitud!==undefined){
                            arrDiposiciones.push(data[key].idSolicitud);
                            arrDisposicionesNumero.push(data[key].numeroSolicitud);
                        }
                    }
    
                    //Recorre objeto para establecer el arreglo final
                    for (let index = 0; index < arrDiposiciones.length; index++) {
                        var arrNegociacion=[];
                        var arrCompras=[];
                        var arrContratacion=[];
                        var arrActivadasLiberadas=[];
                        for (const clave in data) {
                            
                            if(data[clave].idSolicitud==arrDiposiciones[index]){

                                switch(data[clave].subetapa){
                                    case 'Fuera del Flujo de Compras':
                                    case 'Negociación':
                                    case 'Cotización Precio':
                                    case 'Cotizado por Compras':
                                        arrNegociacion.push('Disposición '+data[clave].Disposicion);
                                    break;
                                    
                                    case 'Solicitud Compra':
                                    case 'Orden Compra':
                                        arrCompras.push('Disposición '+data[clave].Disposicion);
                                    break;
                                    
                                    case 'Contratación':
                                    case 'Contratadas':
                                        arrContratacion.push('Disposición '+data[clave].Disposicion);
                                    break;

                                    case 'Activado':
                                    case 'Liberado':
                                        arrActivadasLiberadas.push('Disposición '+data[clave].Disposicion);
                                    break;

                                }
                            }
                        }
                        var objDisposicion={
                            "Solicitud":arrDiposiciones[index],
                            "Negociacion":arrNegociacion,
                            "Compras":arrCompras,
                            "Contratacion":arrContratacion,
                            "ActivadasLiberadas":arrActivadasLiberadas,
                            "NumeroSolicitud":arrDisposicionesNumero[index]
                        }
                        arrDisposicionesFinal.push(objDisposicion);
                        
                    }

                    self_disposiciones.disposicionesDWH=arrDisposicionesFinal;
                    self_disposiciones.render();

                }
            },
            error: function (e) {
                throw e;
            }
        });
    },

    /**
     * When data changes, re-render the field only if it is not on edit (see MAR-1617).
     * @inheritdoc
     */
    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                this.render();
            }
        }, this);
    },

})