({
    events: {
        'click  .btn-ReenviarCliente': 'ReenviaCorreoCliente',
        'click  .btn-DescargarCliente': 'DescargaArchivoCliente',
    },

    initialize: function (options) {
        //Inicializa campo custom
        options = options || {};
        options.def = options.def || {};
        analizate_cl=this;
        this._super('initialize', [options]);
        //Carga lista de valores para la creacion de la url portal
        cont_nlzt.lista_url = App.lang.getAppListStrings('analizate_url_list');
        listaEstado = App.lang.getAppListStrings('anlzt_estado_list');
        //this.model.on('sync', this.cargapipelineCliente, this);
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

    cargapipelineCliente: function () {
        var estado = cont_nlzt.Analizate.Cliente.estado;
        var fecha = cont_nlzt.Analizate.Cliente.fecha;
        console.log("Inicia campo cstm analizate clientes.");
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

        // if (estado == '' || estado == undefined) {
        //     $('#estado1').addClass('current');
        //     $("#estado1").html('Sin enviar');
        //     $("#fecha1").removeClass('ocult');
        //     $('#fecha1').addClass('success');
        //     $("#fecha1").html('-');
        // }
        // if (estado == 1) {
        //     $('#estado1').addClass('current');
        //     $("#estado1").html(listaEstado[estado]);
        //     if (fecha !="") {
        //         $("#fecha1").removeClass('ocult');
        //         $('#fecha1').addClass('success');
        //         $("#fecha1").html(fecha);
        //     }
        // }
        //
        // if (estado == 2) {
        //     $('#estado2').addClass('current');
        //     $("#estado2").html(listaEstado[estado]);
        //     $('#estado1').addClass('done');
        //     if (fecha != "") {
        //         $("#fecha2").removeClass('ocult');
        //         $('#fecha2').addClass('success');
        //         $("#fecha2").html(fecha);
        //     }
        // }
        //
        // if (estado == 3) {
        //     $('#estado3').addClass('current');
        //     $("#estado3").html(listaEstado[estado]);
        //     $('#estado2').addClass('done');
        //     $('#estado1').addClass('done');
        //     if (fecha != "") {
        //         $("#fecha3").removeClass('ocult');
        //         $('#fecha3').addClass('success');
        //         $("#fecha3").html(fecha);
        //     }
        // }
        // if (estado == 4) {
        //     $('#estado4').addClass('current');
        //     $("#estado4").html(listaEstado[estado]);
        //     $('#estado3').addClass('done');
        //     $('#estado2').addClass('done');
        //     $('#estado1').addClass('done');
        //     if (fecha != "") {
        //         $("#fecha4").removeClass('ocult');
        //         $('#fecha4').addClass('success');
        //         $("#fecha4").html(fecha);
        //     }
        // }
        // if (estado == 5) {
        //     $('#estado5').addClass('current');
        //     $("#estado5").html(listaEstado[estado]);
        //     $('#estado4').addClass('done');
        //     $('#estado3').addClass('done');
        //     $('#estado2').addClass('done');
        //     $('#estado1').addClass('done');
        //     if (fecha != "") {
        //         $("#fecha5").removeClass('ocult');
        //         $('#fecha5').addClass('success');
        //         $("#fecha5").html(fecha);
        //     }
        //
        // }
    },

    _render: function () {
        this._super("_render");
    },

    ReenviaCorreoCliente: function () {
        //Valida que sea proveedor para reenviar
        if (this.model.get('tipo_registro_cuenta_c') != "3") {
            app.alert.show('No_Cliente', {
                level: 'error',
                messages: 'Sólo se puede reenviar el correo a cuentas de tipo Cliente.',
                autoClose: false
            });
            return;
        }

        if (this.model.get('email1') == "" || this.model.get('email1') == undefined) {
            app.alert.show('No_Envio', {
                level: 'error',
                messages: 'La cuenta no contiene un correo electrónico.',
                autoClose: false
            });
            return;
        }
        $('.btn-ReenviarCliente').bind('click', false);
        App.alert.show('eventoEnvioMailCliente', {
            level: 'process',
            title: 'Cargando, por favor espere.',
        });
        //Se declaran variables para armar la url
        var rfc = btoa(this.model.get('rfc_c'));
        var id = btoa(this.model.get('id'));
        var mailAccount = btoa(this.model.get('email1'));
        var link = '&UUID=' + id + '&RFC_CIEC=' + rfc + '&MAIL=' + mailAccount;

        // FECHA ACTUAL
        var today = new Date();
        var yyyy = today.getFullYear();
        var mm = today.getMonth()+1; //January is 0!
        var dd = today.getDate();
        var hour = today.getHours();
        var min = today.getMinutes();
        var secs = today.getSeconds();
        var zona= new Date().getTimezoneOffset()/60;

        if(mm<10) {
        mm = '0'+mm
        }
        if(dd<10) {
        dd = '0'+dd
        }
        if(hour<10){
        hour='0'+hour
        }
        if(min<10){
        min='0'+min
        }
        if(secs<10){
        secs='0'+secs
        }
        var fecha= yyyy + '-' + mm + '-' + dd + 'T'+hour +':'+min+':'+secs+'-0'+zona+':00';

        //enviar elementos de la cuenta
        var api_params = {
            "tipo": "1",
            "estado": "1",
            "documento": "",
            "url_portal": link,
            "url_documento": "",
            "empresa": "1",
            "fecha_actualizacion": fecha,
            "anlzt_analizate_accountsaccounts_ida": this.model.id,
            "tipo_registro_cuenta_c":"3" //Cliente
        };
        var url = app.api.buildURL('ANLZT_analizate/', null, null);
        app.api.call('create', url, api_params, {
            success: function (data) {
                App.alert.dismiss('eventoEnvioMailCliente');
                $('.btn-ReenviarCliente').unbind('click', false);
                app.alert.show('Correo_reenviado', {
                    level: 'success',
                    messages: 'Se ha enviado un nuevo correo a la cuenta.',
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
        if (cont_nlzt.Analizate.Cliente != undefined) {
            var archivo = cont_nlzt.Analizate.Cliente.url_documento;
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
