({
    events: {
        'click  .btn-Reenviar': 'ReenviaCorreo',
        'click  .btn-Descargar': 'DescargaArchivo',
    },

    initialize: function (options) {
        //Inicializa campo custom
        options = options || {};
        options.def = options.def || {};
        cont_nlzt = this;
        this._super('initialize', [options]);
        //Carga lista de valores para la creacion de la url portal
        cont_nlzt.lista_url = App.lang.getAppListStrings('analizate_url_list');
    },


    DescargaArchivo:function (options){
        if (cont_nlzt.Financiera!= undefined){
                if(cont_nlzt.Financiera.url_documento!= null && cont_nlzt.Financiera.url_documento!=""){
                    $('.btn-Descargar').bind('click', false);
                    App.alert.show('enventoDescargaPDF', {
                        level: 'process',
                        title: 'Generando descarga, por favor espere.',
                    });
                    //Peticion de servicio para obtener el documento con el id en url_documento
                    var archivo= cont_nlzt.Financiera.url_documento;
                    var host= App.config.analizate;
                    var direccion = host+archivo;
                    direccion=btoa(direccion);
                    /*Realiza api call para obtener el documento en base 64 para añadirle cabecera
                   extensión y descargarlo*/

                    var valUrl = app.api.buildURL("ObtieneDocumento/"+direccion, '', {}, {});
                    app.api.call("read", valUrl, null, {
                        success: _.bind(function (data) {
                            if (data != null) {
                                App.alert.dismiss('enventoDescargaPDF');
                                $('.btn-Descargar').unbind('click', false);
                                //Para descarga del pdf
                                var archivo = 'data:application/octet-stream;base64,' + data;
                                //Crea elemento
                                var downloadLink = document.createElement("a");
                                downloadLink.href = archivo;
                                downloadLink.download = "ActualizatePDF.pdf";
                                document.body.appendChild(downloadLink);
                                downloadLink.click();
                                document.body.removeChild(downloadLink);
                            }
                        }, this)
                    });

                }else{
                    app.alert.show('message_documento', {
                        level: 'info',
                        messages: 'Actualmente no cuenta con el documento de descarga.',
                        autoClose: false
                    });
                }
            }
    },

    ReenviaCorreo: function (){
        if (this.model.get('email1')=="" || this.model.get('email1')==undefined) {
            app.alert.show('No Envio', {
                level: 'error',
                messages: 'La cuenta no contiene un correo electrónico.',
                autoClose: false
            });
            return;
        }
        $('.btn-Reenviar').bind('click', false);
        App.alert.show('eventoenviomail', {
            level: 'process',
            title: 'Cargando, por favor espere.',
        });
        //Se declaran variables para armar la url
        var rfc= this.model.get('rfc_c');
        var id= this.model.get('id');
        var url_financiera= App.lang.getAppListStrings('analizate_url_list')[1];
        var link= url_financiera+'&UUID='+id+'&RFC_CIEC='+rfc;

        //enviar elementos de la cuenta
        var api_params={
            "tipo":"1",
            "estado":"1",
            "documento":"",
            "url_portal":link,
            "url_documento":"",
            "empresa":"1",
            "fecha_actualizacion":"2020-02-24T16:49:00-06:00",
            "anlzt_analizate_accountsaccounts_ida":this.model.id
        };
            var url = app.api.buildURL('ANLZT_analizate/', null, null);
            app.api.call('create', url, api_params, {
            success: function (data) {
                App.alert.dismiss('eventoenviomail');
                $('.btn-Reenviar').unbind('click', false);
                app.alert.show('Correo_reenviado', {
                    level: 'success',
                    messages: 'Se ha enviado un nuevo correo a la cuenta.',
                    autoClose: false
                });
            },
            error: function (e) {
                App.alert.dismiss('eventoenviomail');
                $('.btn-Reenviar').unbind('click', false);
                app.alert.show('Correo_no_reenviado', {
                    level: 'error',
                    messages: 'No se ha podido enviar un nuevo correo a la cuenta.',
                    autoClose: false
                });
            }
        });
    },
})