({
    events: {
        'click  .btn-ReenviarCliente': 'ReenviaCorreoCliente',
        'click  .btn-DescargarCliente': 'DescargaArchivoCliente',
    },

    initialize: function (options) {
        //Inicializa campo custom
        options = options || {};
        options.def = options.def || {};
        analizate_lead=this;
        this._super('initialize', [options]);
        //Carga lista de valores para la creacion de la url portal
        analizate_lead.lista_url = App.lang.getAppListStrings('analizate_url_list');
        listaEstado = App.lang.getAppListStrings('anlzt_estado_list');
        this.AnalizateCliente = [];
        this.AnalizateCliente.Estado1=[];
        this.AnalizateCliente.Estado2=[];
        this.AnalizateCliente.Estado3=[];
        this.AnalizateCliente.Estado4=[];
        this.AnalizateCliente.Estado5=[];
        this.AnalizateCliente.Estado1.Valor='';
        this.AnalizateCliente.Estado1.Class='';
        this.AnalizateCliente.Estado1.Fecha='';
        this.AnalizateCliente.Estado1.FechaClass='ocult';
        this.AnalizateCliente.Estado2.Valor='';
        this.AnalizateCliente.Estado2.Class='';
        this.AnalizateCliente.Estado2.Fecha='';
        this.AnalizateCliente.Estado2.FechaClass='ocult';
        this.AnalizateCliente.Estado3.Valor='';
        this.AnalizateCliente.Estado3.Class='';
        this.AnalizateCliente.Estado3.Fecha='';
        this.AnalizateCliente.Estado3.FechaClass='ocult';
        this.AnalizateCliente.Estado4.Valor='';
        this.AnalizateCliente.Estado4.Class='';
        this.AnalizateCliente.Estado4.Fecha='';
        this.AnalizateCliente.Estado4.FechaClass='ocult';
        this.AnalizateCliente.Estado5.Valor='';
        this.AnalizateCliente.Estado5.Class='';
        this.AnalizateCliente.Estado5.Fecha='';
        this.AnalizateCliente.Estado5.FechaClass='ocult';
    },

    _render: function () {
        this._super("_render");
    },

    cargapipeline: function () {
        var estado = analizate_lead.Analizate.Cliente.estado;
        var fecha = analizate_lead.Analizate.Cliente.fecha;
        console.log("Inicia campo cstm analizate Leads.");
        //Condicion para cargar el subpanel de Analizate
        if (estado==""){
            $('[data-panelname=LBL_RECORDVIEW_PANEL4]').hide();
        }else{
            $('[data-panelname=LBL_RECORDVIEW_PANEL4]').show();
        }
        this.AnalizateCliente.Estado1.Valor = listaEstado[1];
        this.AnalizateCliente.Estado2.Valor = listaEstado[2];
        this.AnalizateCliente.Estado3.Valor = listaEstado[3];
        this.AnalizateCliente.Estado4.Valor = listaEstado[4];
        this.AnalizateCliente.Estado5.Valor = 'Datos CFDI Actualizados';
        this.AnalizateCliente.Estado1.Fecha = fecha;
        this.AnalizateCliente.Estado2.Fecha = fecha;
        this.AnalizateCliente.Estado3.Fecha = fecha;
        this.AnalizateCliente.Estado4.Fecha = fecha;
        this.AnalizateCliente.Estado5.Fecha = fecha;
        switch(estado) {
          case "1":
            this.AnalizateCliente.Estado1.Valor = listaEstado[estado];
            this.AnalizateCliente.Estado1.Class = 'current';
            this.AnalizateCliente.Estado1.FechaClass='success';
            break;
          case "2":
            this.AnalizateCliente.Estado2.Valor = listaEstado[estado];
            this.AnalizateCliente.Estado1.Class = 'done';
            this.AnalizateCliente.Estado2.Class = 'current';
            this.AnalizateCliente.Estado2.FechaClass='success';
            break;
          case "3":
            this.AnalizateCliente.Estado3.Valor = listaEstado[estado];
            this.AnalizateCliente.Estado1.Class = 'done';
            this.AnalizateCliente.Estado2.Class = 'done';
            this.AnalizateCliente.Estado3.Class = 'current';
            this.AnalizateCliente.Estado3.FechaClass='success';
            break;
          case "4":
            this.AnalizateCliente.Estado4.Valor = listaEstado[estado];
            this.AnalizateCliente.Estado1.Class = 'done';
            this.AnalizateCliente.Estado2.Class = 'done';
            this.AnalizateCliente.Estado3.Class = 'done';
            this.AnalizateCliente.Estado4.Class = 'current';
            this.AnalizateCliente.Estado4.FechaClass='success';
            break;
          case "5":
            this.AnalizateCliente.Estado5.Valor = 'Datos CFDI Actualizados';
            this.AnalizateCliente.Estado1.Class = 'done';
            this.AnalizateCliente.Estado2.Class = 'done';
            this.AnalizateCliente.Estado3.Class = 'done';
            this.AnalizateCliente.Estado4.Class = 'done';
            this.AnalizateCliente.Estado5.Class = 'current';
            this.AnalizateCliente.Estado5.FechaClass='success';
            break;
          default:
            this.AnalizateCliente.Estado1.Valor = 'Pendiente';
            this.AnalizateCliente.Estado1.Class = 'current';
        }
    },

    _render: function () {
        this._super("_render");
    },

    ReenviaCorreoCliente: function () {

        if (this.model.get('subtipo_registro_c') == "3" || this.model.get('subtipo_registro_c') == "4") {
            app.alert.show('No_subtipo', {
                level: 'error',
                messages: 'No se puede solicitar CIEC para Leads cancelados o convertidos.',
                autoClose: false
            });
            return;
        }
        if (this.model.get('email')[0].email_address == "" || this.model.get('email')[0].email_address == undefined) {
            app.alert.show('No_Envio', {
                level: 'error',
                messages: 'El Lead no contiene un correo electrónico.',
                autoClose: false
            });
            return;
        }
        $('.btn-ReenviarCliente').bind('click', false);
        App.alert.show('eventoEnvioMailCliente', {
            level: 'process',
            title: 'Cargando, por favor espere.',
        });

        //enviar elementos de la cuenta
        var api_params = {
            "idCuenta": this.model.id,
            "idUsuario": App.user.id
        };
        var url = app.api.buildURL('solicitaCIECCliente/', null, null);
        app.api.call('create', url, api_params, {
            success: function (data) {
                App.alert.dismiss('eventoEnvioMailCliente');
                $('.btn-ReenviarCliente').unbind('click', false);
                var levelStatus = (data['status'] == '200') ? 'success' : 'error';
                app.alert.show('Correo_reenviado', {
                    level: levelStatus,
                    messages: data['message'],
                    autoClose: false
                });
            },
            error: function (e) {
                App.alert.dismiss('eventoEnvioMailCliente');
                $('.btn-ReenviarCliente').unbind('click', false);
                app.alert.show('Correo_no_reenviado', {
                    level: 'error',
                    messages: 'No se ha podido enviar un nuevo correo a la cuenta.',
                    autoClose: false
                });
            }
        });
    },

    DescargaArchivoCliente: function () {
        //Valida existencia de contexto cliente
        if (analizate_lead.Analizate.Cliente != undefined) {
            var archivo = analizate_lead.Analizate.Cliente.url_documento;
            if (archivo != null && archivo != "") {
                $('.btn-DescargarCliente').bind('click', false);
                App.alert.show('enventoDescargaPDFCliente', {
                    level: 'process',
                    title: 'Generando descarga, por favor espere.',
                });
                //Peticion de servicio para obtener el documento con el id en url_documento
                var host = App.config.analizate;
                var direccion = host + archivo;
                direccion = btoa(direccion);
                /*Realiza api call para obtener el documento en base 64 para añadirle cabecera
               extensión y descargarlo*/

                var valUrl = app.api.buildURL("ObtieneDocumento/" + direccion, '', {}, {});
                app.api.call("read", valUrl, null, {
                    success: _.bind(function (data) {
                        if (data != null) {
                            App.alert.dismiss('enventoDescargaPDFCliente');
                            $('.btn-DescargarCliente').unbind('click', false);
                            //Para descarga del pdf
                            var archivo = 'data:application/octet-stream;base64,' + data;
                            //Crea elemento
                            var downloadLink = document.createElement("a");
                            downloadLink.href = archivo;
                            downloadLink.download = "CFDIActualizado.pdf";
                            document.body.appendChild(downloadLink);
                            downloadLink.click();
                            document.body.removeChild(downloadLink);
                        }
                    }, this)
                });

            } else {
                app.alert.show('message_documento_cliente', {
                    level: 'info',
                    messages: 'Actualmente no cuenta con el documento de descarga.',
                    autoClose: false
                });
            }
        }
    },
})
