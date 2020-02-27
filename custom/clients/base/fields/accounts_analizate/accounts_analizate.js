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
    },


    DescargaArchivo:function (options){
            if (cont_nlzt.Financiera!= undefined){
                if(cont_nlzt.Financiera.url_documento!= null && cont_nlzt.Financiera.url_documento!=""){
                    //Peticion de servicio para obtener el documento con el id en url_documento


                    var urldoc= atob(nombre);
                    var url = urldoc;
                    //Abre ventana nueva con las dimensiones establecidas.
                    window.open(url, 'width=450, height=500, top=85, left=50', true);
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
        //enviar elementos de la cuenta
        var api_params={
            "tipo":"1",
            "estado":"1",
            "documento":"",
            "url_portal":"https://www.google.com.mx/",
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