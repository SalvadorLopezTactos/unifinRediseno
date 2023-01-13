({
    events:{
        'click .gpoEmpresarial': 'openGpoEmpresarial',
        'click .closeModalGpoEmpresarial': 'closeModalGpoEmpresarial',
        'click .closeModalDisposiciones': 'closeModalDisposiciones',
        'click .btnAddContact':'openDrawerRelacion',
        'click .btnNuevaReunion':'openDrawerReunion',
        'click .addCall':'generatecall',
        'click .sendEmail':'openDrawerSendEmail',
        'click .btnNuevaLinea':'creaNuevaLinea',


        //Despliegue de detalle
      'click .openModalDisposiciones': 'getDisposiciones360',
      'click .openModalAnexos': 'getAnexos',
      'click .openModalCesiones': 'getCesiones',
      'click .openModalContratos': 'getContratos',
      //Despliegue de detalle Historicos
      'click .openModalAnexosH': 'getAnexosH',
      'click .openModalCesionesH': 'getCesionesH',
      'click .openModalContratosH': 'getContratosH',


      //Cierre de detalle
      'click .closeModalAnexos': 'closeModal',

      //Ordenamiento
      // Anexos
      'click #orderByActivo': 'orderActivo',
      'click #orderByActivoHistorico': 'orderActivoHistorico',
      'click #orderByAnexo': 'orderAnexo',
      'click #orderByAnexoHistorico': 'orderAnexoHistorico',
      'click #orderByAnexoContrata': 'orderAnexoContratacion',
      'click #orderByAnexoContrataHistorico': 'orderAnexoContratacionHistorico',
      'click #orderByAnexoTermino': 'orderAnexoTerminacion',
      'click #orderByAnexoTerminoHistorico': 'orderAnexoTerminacionHistorico',
      'click #orderByAnexoProxRenta': 'orderAnexoProxRenta',
      'click #orderByAnexoProxRentaHistorico': 'orderAnexoProxRentaHistorico',
      'click #orderByAnexoVigenciaSeguro': 'orderAnexoVigenciaSeguro',
      'click #orderByAnexoVigenciaSeguroHistorico': 'orderAnexoVigenciaSeguroHistorico',
      'click #orderByAnexoMontoRenta': 'orderAnexoMontoRenta',
      'click #orderByAnexoMontoRentaHistorico': 'orderAnexoMontoRentaHistorico',
      'click #orderByAnexoSaldoInsoluto': 'orderAnexoSaldoInsoluto',
      'click #orderByAnexoSaldoInsolutoHistorico': 'orderAnexoSaldoInsolutoHistorico',
      'click #orderByAnexoCarteraVencida': 'orderAnexoCarteraVencida',
      'click #orderByAnexoCarteraVencidaHistorico': 'orderAnexoCarteraVencidaHistorico',
      'click #orderByAnexoMoratorios': 'orderAnexoMoratorios',
      'click #orderByAnexoMoratoriosHistorico': 'orderAnexoMoratoriosHistorico',
      'click #orderByAnexoDiasMora': 'orderAnexoDiasMora',
      'click #orderByAnexoDiasMoraHistorico': 'orderAnexoDiasMoraHistorico',
      'click #orderByAnexoTasa': 'orderAnexoTasa',
      'click #orderByAnexoTasaHistorico': 'orderAnexoTasaHistorico',

      //Contratos
      'click #orderByUnidad': 'orderUnidad',
      'click #orderByContrato': 'orderContrato',
      'click #orderByContratoContrata': 'orderContratoContratacion',
      'click #orderByContratoTermino': 'orderContratoTerminacion',
      'click #orderByProxDom': 'orderProximaDomiciliacion',
      'click #orderByVigenciaSeguro': 'orderVigenciaSeguro',
      'click #orderByColocacion': 'orderColocacion',
      'click #orderBySaldoInsoluto': 'orderSaldoInsoluto',
      'click #orderByCarteraVencida': 'orderCarteraVencida',
      'click #orderByMoratorios': 'orderMoratorios',
      'click #orderByDiasMora': 'orderDiasMora',
      'click #orderByTasa': 'orderTasa',
      //Contratos Históricos
      'click #orderByUnidadHistorico': 'orderUnidadHistorico',
      'click #orderByProxDomHistorico': 'orderProximaDomiciliacionHistorico',
      'click #orderByVigenciaSeguroHistorico': 'orderVigenciaSeguroHistorico',
      'click #orderByColocacionHistorico': 'orderColocacionHistorico',
      'click #orderBySaldoInsolutoHistorico': 'orderSaldoInsolutoHistorico',
      'click #orderByCarteraVencidaHistorico': 'orderCarteraVencidaHistorico',
      'click #orderByMoratoriosHistorico': 'orderMoratoriosHistorico',
      'click #orderByDiasMoraHistorico': 'orderDiasMoraHistorico',
      'click #orderByTasaHistorico': 'orderTasaHistorico',
      
      //Cesiones
      'click #orderByCesion': 'orderCesion',
      'click #orderByCesionVencimiento': 'orderCesionVencimiento',
      'click .btn-Guardar': 'Save_comentario',
      'click #btn-Descargar':'descargapdf',
      //Cesiones Históricas
      'click #orderByCesionHistorico': 'orderCesionHistorico',
      'click #orderByDeudoresHistorico': 'orderDeudorHistorico',
      'click #orderByMontoVencerHistorico': 'orderMontoVencerHistorico',
      'click #orderByMontoDescuentoHistorico': 'orderMontoDescuentoHistorico',
      

    },

    initialize: function(options) {
        this._super('initialize', [options]);
        //vista360 es la variable que guarda el contexto de el actual campo custom y se llena desde el record.js de Cuentas
        vista360 = this;
        //Define variables de ordenamiento
        this.sortAnexo = "ASC";
        this.sortAnexoHistorico="ASC";
        this.sortActivo="ASC";
        this.sortActivoHistorico="ASC";
        this.sortAnexoContratacion = "ASC";
        this.sortAnexoContratacionHistorico = "ASC";
        this.sortAnexoTerminacion = "ASC";
        this.sortAnexoTerminacionHistorico = "ASC";
        this.sortAnexoProxRenta="ASC";
        this.sortAnexoProxRentaHistorico="ASC";
        this.sortAnexoVigenciaSeguro="ASC";
        this.sortAnexoVigenciaSeguroHistorico="ASC";
        this.sortAnexoMontoRenta="ASC";
        this.sortAnexoMontoRentaHistorico="ASC";
        this.sortAnexoSaldoInsoluto="ASC";
        this.sortAnexoSaldoInsolutoHistorico="ASC";
        this.sortAnexoCarteraVencida="ASC";
        this.sortAnexoCarteraVencidaHistorico="ASC";
        this.sortAnexoMoratorios="ASC";
        this.sortAnexoMoratoriosHistorico="ASC";
        this.sortAnexoDiasMora="ASC";
        this.sortAnexoDiasMoraHistorico="ASC";
        this.sortAnexoTasa="ASC";
        this.sortAnexoTasaHistorico="ASC";
        this.sortProxDomiciliacion="ASC";
        this.sortVigenciaSeguro = "ASC";
        this.sortColocacion = "ASC";
        this.sortSaldoInsoluto="ASC";

        this.sortUnidad="ASC";
        this.sortCarteraVencida="ASC";
        this.sortMoratorios="ASC";
        this.sortDiasMora="ASC";
        this.sortTasa="ASC";

        this.sortUnidadHistorico="ASC";
        this.sortProxDomiciliacionHistorico="ASC";
        this.sortVigenciaSeguroHistorico= "ASC";
        this.sortColocacionHistorico = "ASC";
        this.sortSaldoInsolutoHistorico="ASC";
        this.sortCarteraVencidaHistorico="ASC";
        this.sortMoratoriosHistorico="ASC";
        this.sortDiasMoraHistorico="ASC";
        this.sortTasaHistorico="ASC";

        this.sortCesionHistorico="ASC";
        this.sortDeudorHistorico="ASC";
        this.sortMontoVencerHistorico="ASC";
        this.sortMontoDescuentoHistorico="ASC";

        this.model.on('sync', this.hideElements, this);
    },

    _render: function () {
      this._super("_render");

      if($('[data-fieldname="account_vista360"] > span').length >0){
        $('[data-fieldname="account_vista360"] > span').show();
      }
    },

    openGpoEmpresarial:function(){
        var modal = $('#modalGpoEmpresarial');
        if (modal) {
            modal.show();
        }
    },

    closeModalGpoEmpresarial:function(){
        var modal = $('#modalGpoEmpresarial');
        if (modal) {
            modal.hide();
        }
    },

    openDrawerRelacion:function(e){
        this.e=e;
        if($(e.currentTarget).attr('disabled')==undefined){
            $(e.currentTarget).attr('disabled','disabled');
        }else{
            $(e.currentTarget).removeAttr('disabled');
        }

        self_v360=this;
        var id_cuenta=this.model.get('id');
        //Consumir servicio para establecer campo de
        /*
            Relaciones activas: Podrá nacer con las siguientes opciones:
            Negocio: En caso de no tener ninguna relación de tipo Negocio.
            Contacto Promoción: Cuando ya tenga al menos una relación de tipo Negocio.
        */
        var consulta = app.api.buildURL('Accounts/' + id_cuenta+'/link/rel_relaciones_accounts_1', null, null);
        app.alert.show('loadingGetRelaciones', {
            level: 'process',
            title: 'Cargando...',
        });
        app.api.call('read', consulta, {}, {
            success: _.bind(function (data) {
                app.alert.dismiss('loadingGetRelaciones');

                if(data.records.length>0){
                    //Evaluar que ya tenga alguna relación de tipo Negocios
                    var tieneNegocio=0;
                    for (let index = 0; index < data.records.length; index++) {
                        if(data.records[index].relaciones_activas.includes('Negocios')){
                            tieneNegocio++;
                            //Termina ciclo, ya que al tener una relacion con Relación Activa Negocio, se establece como Contacto Promoción
                            index=data.records.length;
                        }
                    }

                    if(tieneNegocio>0){
                        var model=App.data.createBean('Rel_Relaciones');
                        var id_cuenta=self_v360.model.get('id');
                        var nombre_cuenta=self_v360.model.get('name');
                        model.set('rel_relaciones_accounts_1accounts_ida', id_cuenta);
                        model.set('rel_relaciones_accounts_1_name', nombre_cuenta);
                        model.set('relaciones_activas', ['Contacto']);
                        model.set('tipodecontacto', 'Promocion');

                        app.drawer.open({
                            layout: 'create',
                            context: {
                                create: true,
                                module: 'Rel_Relaciones',
                                from360:'1',
                                model: model
                                },
                            },
                            function(variable){
                                if($(self_v360.e.currentTarget).attr('disabled')==undefined){
                                    $(self_v360.e.currentTarget).attr('disabled','disabled');
                                }else{
                                    $(self_v360.e.currentTarget).removeAttr('disabled');
                                }
                            }
                        );

                    }else{
                        //No tiene relaciones, Relaciones Activas se establece como tipo Negocios
                        var model=App.data.createBean('Rel_Relaciones');
                        var id_cuenta=self_v360.model.get('id');
                        var nombre_cuenta=self_v360.model.get('name');
                        model.set('rel_relaciones_accounts_1accounts_ida', id_cuenta);
                        model.set('rel_relaciones_accounts_1_name', nombre_cuenta);
                        model.set('relaciones_activas', ['Negocios']);
                        app.drawer.open({
                            layout: 'create',
                            context: {
                                create: true,
                                module: 'Rel_Relaciones',
                                from360:'1',
                                model: model
                            },
                        },
                        function(variable){
                            if($(self_v360.e.currentTarget).attr('disabled')==undefined){
                                $(self_v360.e.currentTarget).attr('disabled','disabled');
                            }else{
                                $(self_v360.e.currentTarget).removeAttr('disabled');
                            }
                        }
                        );
                    }

                }else{
                    //No tiene relaciones, Relaciones Activas se establece como tipo Negocios
                    var model=App.data.createBean('Rel_Relaciones');
                    var id_cuenta=self_v360.model.get('id');
                    var nombre_cuenta=self_v360.model.get('name');
                    model.set('rel_relaciones_accounts_1accounts_ida', id_cuenta);
                    model.set('rel_relaciones_accounts_1_name', nombre_cuenta);
                    model.set('relaciones_activas', ['Negocios']);
                    app.drawer.open({
                        layout: 'create',
                        context: {
                              create: true,
                              module: 'Rel_Relaciones',
                              from360:'1',
                              model: model
                          },
                      },
                      function(variable){
                        if($(self_v360.e.currentTarget).attr('disabled')==undefined){
                            $(self_v360.e.currentTarget).attr('disabled','disabled');
                        }else{
                            $(self_v360.e.currentTarget).removeAttr('disabled');
                        }
                      }
                    );
                }

            }, this)
        });

    },

    openDrawerReunion:function(e){
        var modeloMeetings=App.data.createBean('Meetings');
        var id_cuenta=$(e.currentTarget).attr('data-id');
        var nombre_cuenta=$(e.currentTarget).attr('data-name');

        if(id_cuenta!=null && id_cuenta!=""){
            modeloMeetings.set('parent_type',"Accounts");
            modeloMeetings.set('parent_id',id_cuenta);
            modeloMeetings.set('parent_name',nombre_cuenta);

            app.drawer.open({
                layout: 'create',
                context: {
                    create: true,
                    module: 'Meetings',
                    model: modeloMeetings
                    },
                },
                function(variable){
                    console.log("Cierra drawer de Meetings");
                }
            );
        }else{
            app.alert.show('error_drawer_reunion', {
                level: 'error',
                autoClose: true,
                messages: 'No existe una Cuenta para agendar reunión'
              });
        }

    },

    generatecall: function (evt) {
        if (!evt) return;
        var tel_client = $(evt.currentTarget).attr('data-telefono');
        this.nombre_cliente_llamada=$(evt.currentTarget).attr('data-nombre');
        this.id_cliente_llamada=$(evt.currentTarget).attr('data-id-nombre');

        var tel_usr = app.user.attributes.ext_c;
        var puesto_usuario = App.user.attributes.puestousuario_c;
        var idUsuarioLogeado = App.user.attributes.id;
        var arrayPuestosComerciales = [];
        var reus = false;
        var productoREUS = false;
        var telREUS = false;
        //LISTA PARA PUESTOS COMERCIALES
        Object.entries(App.lang.getAppListStrings('puestos_comerciales_list')).forEach(([key, value]) => {
            arrayPuestosComerciales.push(key);
        });

        if(self.oTelefonos==undefined){
            self.oTelefonos=this.view.oTelefonos;
        }
        //TELEFONOS QUE SOLO SON REUS
        for (var i = 0; i < self.oTelefonos.telefono.length; i++) {
            if (self.oTelefonos.telefono[i].reus == 1 && self.oTelefonos.telefono[i].telefono == tel_client) {
                telREUS = true;
            }
        }
        /*
        if(self.ResumenProductos == undefined){
            self.ResumenProductos = this.ResumenProductos;
        }*/

        if(self.ResumenProductos!=undefined){
            self1=self;
        }

        if(self.ResumenProductos==undefined){
            self=self1;
        }

        //VALIDACIONES PARA USUARIO LOGEADO CONTRA USUARIO ASIGNADO EN LOS PRODUCTOS Y QUE TIENEN TIPO DE CUENTA CLIENTE
        if (self.ResumenProductos.leasing.tipo_cuenta == "3") {
            productoREUS = true;
            // console.log("LEASING USUARIO LOGEADO & TIPO DE CUENTA CLIENTE");
        }
        if ( self.ResumenProductos.factoring.tipo_cuenta == "3") {
            productoREUS = true;
            // console.log("FACTORAJE USUARIO LOGEADO & TIPO DE CUENTA CLIENTE");
        }
        if (self.ResumenProductos.credito_auto.tipo_cuenta == "3") {
            productoREUS = true;
            // console.log("CREDITO-AUTO USUARIO LOGEADO & TIPO DE CUENTA CLIENTE");
        }
        if (self.ResumenProductos.uniclick.tipo_cuenta == "3") {
            productoREUS = true;
            // console.log("UNICLICK USUARIO LOGEADO & TIPO DE CUENTA CLIENTE");
        }
        if (self.ResumenProductos.fleet.tipo_cuenta == "3") {
            productoREUS = true;
            // console.log("FLEET USUARIO LOGEADO & TIPO DE CUENTA CLIENTE");
        }
        if (self.ResumenProductos.seguros.tipo_cuenta == "3") {
            productoREUS = true;
            // console.log("SEGUROS USUARIO LOGEADO & TIPO DE CUENTA CLIENTE");
        }

        if (telREUS == true) {
            //PUESTOS COMERCIALES AUTORIZADOS CON LA VALIDACION DE USUARIO ASIGNADO EN ALGUN PRODUCTO CON TIPO DE CUENTA-PRODUCTO CLIENTE
            if (arrayPuestosComerciales.includes(puesto_usuario) && productoREUS == true) {
                reus = true;
            }
            //PUESTOS COMERCIALES DIFERENTES A LOS AUTORIZADOS EN LA LISTA CON EL TIPO DE REGISTRO DE LA CUENTA CLIENTE
            if (!arrayPuestosComerciales.includes(puesto_usuario) && this.model.get('tipo_registro_cuenta_c') == '3') {
                reus = true;
            }

        } else {
            //ENTRA PARA LAS LLAMADAS QUE NO SON REUS
            reus = true;
        }
        //Valida REUS
        if (reus == true) {
          //Valida Teléfono y Extensión
          if (tel_usr != '' && tel_usr != null) {
            if (tel_client != '' && tel_client != null) {
              context = this;
              app.alert.show('do-call', {
                level: 'confirmation',
                messages: '¿Realmente quieres realizar la llamada? <br><br><b>NOTA: La marcaci\u00F3n se realizar\u00E1 tal cual el n\u00FAmero est\u00E1 registrado</b>',
                autoClose: false,
                onConfirm: function () {
                  //context.createcall(context.resultCallback);
                  context.createcall(tel_client,context.nombre_cliente_llamada,context.id_cliente_llamada);
                },
              });
            } else {
              app.alert.show('error_tel_client', {
                level: 'error',
                autoClose: true,
                messages: 'El cliente al que quieres llamar no tiene <b>N\u00FAmero telefónico</b>.'
              });
            }
          } else {
            app.alert.show('error_tel_usr', {
              level: 'error',
              autoClose: true,
              messages: 'El usuario con el que estas logueado no tiene <b>Extensi\u00F3n</b>.'
            });
          }
        } else {
            app.alert.show('message-reus-comercial', {
                level: 'error',
                messages: 'No se puede generar llamada a teléfono registrado en REUS',
                autoClose: false
            });
        }
    },

    createcall: function (tel_client,nombre_cliente,id_cliente) {
        //Recupera variables para petición
        self = this;
        var posiciones = App.user.attributes.posicion_operativa_c;
        var posicion = '';
        var name_client = nombre_cliente;
        if(posiciones.includes(3)) posicion = 'Ventas';
        if(posiciones.includes(4)) posicion = 'Staff';
        var Params = {
            'id_cliente': id_cliente,
            'nombre_cliente': name_client,
            'numero_cliente': tel_client,
            'modulo': 'Accounts',
            'posicion': posicion,
            'puesto_usuario': App.user.attributes.puestousuario_c,
            'ext_usuario': App.user.attributes.ext_c
        };

        app.alert.show('loadingCreateCalls', {
            level: 'process',
            title: 'Cargando...',
        });

        //Ejecuta petición para generar llamada
        app.api.call('create', app.api.buildURL('createcall'), { data: Params }, {
          success: _.bind(function (data) {
            app.alert.dismiss('loadingCreateCalls');
            id_call = data;
            console.log('Llamada creada, id: ' + id_call);
            app.alert.show('message-to', {
              level: 'info',
              messages: 'Usted está llamando a ' + name_client,
              autoClose: true
            });
          }, this),
        });
    },

    openDrawerSendEmail:function(e){

        //prepopulateEmailForCreate
        var id_cuenta=$(e.currentTarget).attr('data-id-nombre');
        var nombre_cuenta=$(e.currentTarget).attr('data-nombre');
        var beanContacto=app.data.createBean('Accounts', {id:id_cuenta});

        app.alert.show('loadingOpenDrawerEmail', {
            level: 'process',
            title: 'Cargando...',
        });
        beanContacto.fetch({
            success: function(data) {
                app.alert.dismiss('loadingOpenDrawerEmail');
                //Se genera registro para prellenar el correo destinatario
                var registro= app.data.createBean('EmailParticipants', {
                    _link: 'to',
                    parent: _.extend({type: "Accounts"}, data),
                    parent_type: data.module,
                    parent_id: data.id,
                    parent_name: data.get('name')
                });

                var email = app.data.createBean('EmailAddresses');
                email.set('email_address',data.attributes.email1);

                registro.set({
                    email_addresses: app.utils.deepCopy(email),
                    email_address_id: data.attributes.email[0].email_address_id,
                    email_address: email.get('email_address'),
                    invalid_email: email.get('invalid_email'),
                    opt_out: email.get('opt_out')
                });

                data.attributes.type="Accounts";

                var modeloEmail=App.data.createBean('Emails');
                modeloEmail.set('name','');
                modeloEmail.set('parent',data.attributes);
                modeloEmail.set('parent_type',"Accounts");
                modeloEmail.set('parent_id',data.id);
                modeloEmail.set('parent_name',data.get('name'));

                modeloEmail.get('to_collection').add(registro);

                app.drawer.open({
                    layout: 'compose-email',
                    context: {
                        create: true,
                        module: 'Emails',
                        model: modeloEmail

                    },
                },function(variable){
                    console.log("Cierra drawer de Emails");
                });

            }
        });
    },

    getDisposiciones360:function(){
      //var id_cliente='a54b31cc-1296-11e9-bb47-00155d967307';
      var id_cliente=this.model.get('id');
      app.alert.show('getDisposiciones360', {
          level: 'process',
          title: 'Cargando...',
      });
      
      app.api.call('GET', app.api.buildURL('GetDisposicionesDWH/'+id_cliente), null, {
          success: function (data) {
              App.alert.dismiss('getDisposiciones360');
              if(data.length>0){
                var userLeasing=vista360.model.get('user_id_c');
                var newData=[];
                for (const key in data) {
                  //Se muestran únicamente las disposiciones pertenecientes al asesori Leasing de la Cuenta actual 
                  if(data[key].idUsuario==userLeasing){
                    newData.push(data[key]);
                  }
                }
                vista360.ResumenCliente.leasing.disposiciones=newData;
                vista360.render();
                var modal = $('#modalDisposiciones');
                if (modal) {
                    modal.show();
                }
              }
          },
          error: function (e) {
              throw e;
          }
      });

    },

    getAnexos: function () {
        var id = this.model.get('idcliente_c');
        var peticion = "anexos_activos";
        this.getData(peticion, id);
      },

      getCesiones: function () {
        var id = this.model.get('idcliente_c');
        var peticion = "cesiones_activas";
        this.getData(peticion, id);
      },

      getContratos: function () {
        var id = this.model.get('idcliente_c');
        var peticion = "contratos_activos";
        this.getData(peticion, id);
      },

      //Funciones para drawers de Historicos
      getAnexosH: function () {
        var id = this.model.get('idcliente_c');
        var peticion="anexos_historicos";
        this.getData(peticion, id,);
      },
      getCesionesH: function () {
        var id = this.model.get('idcliente_c');
        var peticion="cesiones_historicas"
        this.getData(peticion, id);
      },
      getContratosH: function () {
        var id = this.model.get('idcliente_c');
        var peticion="contratos_historicos";
        this.getData(peticion, id);
      },

      /**
        Funciones de despliegue:
         - getData: consume servicio para obtención de información y despliegue de resultado
         - closeModal: Cierra modal con detalle
      */
      getData: function (peticion, id, records=null ) {
          console.log("getAnexos - clic");

          //Bloque botones
          $("#openDisposiciones").removeClass("openModalDisposiciones");
          $("#openAnexos").removeClass("openModalAnexos");
          $("#openCesiones").removeClass("openModalCesiones");
          $("#openContratos").removeClass("openModalContratos");
          //Historicos
          $("#openAnexosH").removeClass("openModalAnexosH");
          $("#openCesionesH").removeClass("openModalCesionesH");
          $("#openContratosH").removeClass("openModalContratosH");

          if (!records) {
            //Genera petición
            var Params = {
                'id_cliente': id,
                'tipo_peticion': peticion,
            };
            var url = app.api.buildURL('ConsultaAnexos','', {}, {});

            //
            App.alert.show('openAnexos', {
                level: 'process'
            });

            // $("#myModal1").show();
            // $(".loadingIcon").show();

            //Ejecuta petición
            var self = this;
            app.api.call('create', url, {data: Params},{
              success: function (data){
                //Logs
                console.log('data:');
                console.log(data);

                //var records2 = data;
                _.extend(self, {anexosdata:data});
                self.render();

                //Muestra modal
                App.alert.dismiss('openAnexos');

                // $("#loadingIcon").hide();
                // $(".myModal1").hide();

                var modal = $('#myModal');
                if (modal) {
                    modal.show();
                }

                //Bloque botones
                $("#openAnexos").removeClass("openModalAnexos");
                $("#openCesiones").removeClass("openModalCesiones");
                $("#openContratos").removeClass("openModalContratos");
                //Historicos
                $("#openAnexosH").removeClass("openModalAnexosH");
                $("#openCesionesH").removeClass("openModalCesionesH");
                $("#openContratosH").removeClass("openModalContratosH");

              }
            });
          }else {
            this.anexosdata = records;
            this.render();
            var modal = $('#myModal');
            if (modal) {
                modal.show();
            }
          }
      },

      closeModal: function () {
          console.log("closeModal - clic");
          var modal = $('#myModal');
          if (modal) {
              modal.hide();
          }

          //Habilita botones
          $("#openAnexos").addClass("openModalAnexos");
          $("#openCesiones").addClass("openModalCesiones");
          $("#openContratos").addClass("openModalContratos");

          $("#openAnexosH").addClass("openModalAnexosH");
          $("#openCesionesH").addClass("openModalCesionesH");
          $("#openContratosH").addClass("openModalContratosH");

      },

      closeModalDisposiciones:function(){
        var modal = $('#modalDisposiciones');
        if (modal) {
            modal.hide();
        }
    },

      orderActivo:function(){
        var orderData = this.anexosdata;
        if (this.sortActivo == "ASC") {
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
            if (a.columna1.trim() < b.columna1.trim()) {
              return -1;
            }
            if (b.columna1.trim() > a.columna1.trim()) {
              return 1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortActivo = "DESC";
        }else{
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
          if (a.columna1.trim() > b.columna1.trim()) {
              return -1;
            }
            if (b.columna1.trim() > a.columna1.trim()) {
              return 1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortActivo = "ASC";
        }

        this.getData(null,null,orderData);

      },

      orderActivoHistorico:function(){

        var orderData = this.anexosdata;
        if (this.sortActivoHistorico == "ASC") {
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
            if (a.columna1.trim() < b.columna1.trim()) {
              return -1;
            }
            if (b.columna1.trim() > a.columna1.trim()) {
              return 1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortActivoHistorico = "DESC";
        }else{
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
          if (a.columna1.trim() > b.columna1.trim()) {
              return -1;
            }
            if (b.columna1.trim() > a.columna1.trim()) {
              return 1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortActivoHistorico = "ASC";
        }

        this.getData(null,null,orderData);

      },

      orderAnexo: function(){
        //Ordenamiento: Anexos por Anexo - Columna 2
        // console.log('--anexosdata--');
        // console.log(this.anexosdata);

        var orderData = this.anexosdata;
        if (this.sortAnexo == "ASC") {
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
          if (a.columna2 > b.columna2) {
              return 1;
            }
            if (a.columna2 < b.columna2) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexo = "DESC";
        }else{
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
          if (a.columna2 < b.columna2) {
              return 1;
            }
            if (a.columna2 > b.columna2) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexo = "ASC";
        }
        this.getData(null,null,orderData);
      },

      orderAnexoHistorico:function(){

        var orderData = this.anexosdata;
        if (this.sortAnexoHistorico == "ASC") {
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
          if (a.columna2 > b.columna2) {
              return 1;
            }
            if (a.columna2 < b.columna2) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoHistorico = "DESC";
        }else{
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
          if (a.columna2 < b.columna2) {
              return 1;
            }
            if (a.columna2 > b.columna2) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexoHistorico = "ASC";
        }


        this.getData(null,null,orderData);

      },

      orderAnexoContratacion: function(){
        //Ordenamiento: Anexos por fecha de contratación - Columna 3
        // console.log('--anexosdata--');
        // console.log(this.anexosdata);
        var self = this;
        var orderData = this.anexosdata;
        if (this.sortAnexoContratacion == "ASC") {
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
            if (self.stringToDate(a.columna3) > self.stringToDate(b.columna3)) {
              return 1;
            }
            if (self.stringToDate(a.columna3) < self.stringToDate(b.columna3)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoContratacion = "DESC";
        }else{
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
            if (self.stringToDate(a.columna3) < self.stringToDate(b.columna3)) {
              return 1;
            }
            if (self.stringToDate(a.columna3) > self.stringToDate(b.columna3)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexoContratacion = "ASC";
        }


        this.getData(null,null,orderData);
      },

      orderAnexoContratacionHistorico:function(){

        var self = this;
        var orderData = this.anexosdata;
        if (this.sortAnexoContratacionHistorico == "ASC") {
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
            if (self.stringToDate(a.columna3) > self.stringToDate(b.columna3)) {
              return 1;
            }
            if (self.stringToDate(a.columna3) < self.stringToDate(b.columna3)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoContratacionHistorico = "DESC";
        }else{
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
            if (self.stringToDate(a.columna3) < self.stringToDate(b.columna3)) {
              return 1;
            }
            if (self.stringToDate(a.columna3) > self.stringToDate(b.columna3)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexoContratacionHistorico = "ASC";
        }


        this.getData(null,null,orderData);

      },

      orderAnexoTerminacion: function(){
        //Ordenamiento: Anexos por fecha de terminación - Columna 4
        // console.log('--anexosdata--');
        // console.log(this.anexosdata);
        var self = this;
        var orderData = this.anexosdata;
        if (this.sortAnexoTerminacion == "ASC") {
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
          if (self.stringToDate(a.columna4) > self.stringToDate(b.columna4)) {
              return 1;
            }
            if (self.stringToDate(a.columna4) < self.stringToDate(b.columna4)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoTerminacion = "DESC";
        }else{
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
          if (self.stringToDate(a.columna4) < self.stringToDate(b.columna4)) {
              return 1;
            }
            if (self.stringToDate(a.columna4) > self.stringToDate(b.columna4)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexoTerminacion = "ASC";
        }
        this.getData(null,null,orderData);
      },

      orderAnexoTerminacionHistorico:function(){

        var self = this;
        var orderData = this.anexosdata;
        if (this.sortAnexoTerminacionHistorico == "ASC") {
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
          if (self.stringToDate(a.columna4) > self.stringToDate(b.columna4)) {
              return 1;
            }
            if (self.stringToDate(a.columna4) < self.stringToDate(b.columna4)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoTerminacionHistorico = "DESC";
        }else{
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
          if (self.stringToDate(a.columna4) < self.stringToDate(b.columna4)) {
              return 1;
            }
            if (self.stringToDate(a.columna4) > self.stringToDate(b.columna4)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexoTerminacionHistorico = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderAnexoProxRenta: function(){
        //Ordenamiento: Anexos por fecha de terminación - Columna 4
        // console.log('--anexosdata--');
        // console.log(this.anexosdata);
        var self = this;
        var orderData = this.anexosdata;
        if (this.sortAnexoProxRenta == "ASC") {
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
          if (self.stringToDate(a.columna6) > self.stringToDate(b.columna6)) {
              return 1;
            }
            if (self.stringToDate(a.columna6) < self.stringToDate(b.columna6)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoProxRenta = "DESC";
        }else{
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
          if (self.stringToDate(a.columna6) < self.stringToDate(b.columna6)) {
              return 1;
            }
            if (self.stringToDate(a.columna6) > self.stringToDate(b.columna6)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexoProxRenta = "ASC";
        }
        this.getData(null,null,orderData);
      },

      orderAnexoProxRentaHistorico:function(){

        var self = this;
        var orderData = this.anexosdata;
        if (this.sortAnexoProxRentaHistorico == "ASC") {
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
          if (self.stringToDate(a.columna6) > self.stringToDate(b.columna6)) {
              return 1;
            }
            if (self.stringToDate(a.columna6) < self.stringToDate(b.columna6)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoProxRentaHistorico = "DESC";
        }else{
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
          if (self.stringToDate(a.columna6) < self.stringToDate(b.columna6)) {
              return 1;
            }
            if (self.stringToDate(a.columna6) > self.stringToDate(b.columna6)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexoProxRentaHistorico = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderAnexoVigenciaSeguro: function(){
        //Ordenamiento: Anexos por fecha de terminación - Columna 4
        // console.log('--anexosdata--');
        // console.log(this.anexosdata);
        var self = this;
        var orderData = this.anexosdata;
        if (this.sortAnexoVigenciaSeguro == "ASC") {
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
              if(self.stringToDate(a.columna7) > self.stringToDate(b.columna7)) {
                return 1;
              }
              if(self.stringToDate(a.columna7) < self.stringToDate(b.columna7)) {
                return -1;
              }
              // a must be equal to b
              return 0;
            
          });
          this.sortAnexoVigenciaSeguro = "DESC";
        }else{
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
            
              if (self.stringToDate(a.columna7) < self.stringToDate(b.columna7)) {
                return 1;
              }
              if (self.stringToDate(a.columna7) > self.stringToDate(b.columna7)) {
                return -1;
              }
              // a must be equal to b
              return 0;
            
            
          });

          this.sortAnexoVigenciaSeguro = "ASC";
        }
        this.getData(null,null,orderData);
      },

      orderAnexoVigenciaSeguroHistorico:function(){

        var self = this;
        var orderData = this.anexosdata;
        if (this.sortAnexoVigenciaSeguroHistorico == "ASC") {
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
              if(self.stringToDate(a.columna7) > self.stringToDate(b.columna7)) {
                return 1;
              }
              if(self.stringToDate(a.columna7) < self.stringToDate(b.columna7)) {
                return -1;
              }
              // a must be equal to b
              return 0;
            
          });
          this.sortAnexoVigenciaSeguroHistorico = "DESC";
        }else{
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
            
              if (self.stringToDate(a.columna7) < self.stringToDate(b.columna7)) {
                return 1;
              }
              if (self.stringToDate(a.columna7) > self.stringToDate(b.columna7)) {
                return -1;
              }
              // a must be equal to b
              return 0;
          });

          this.sortAnexoVigenciaSeguroHistorico = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderAnexoMontoRenta:function(){
        var orderData = this.anexosdata;
        if (this.sortAnexoMontoRenta == "ASC") {
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
          if (parseFloat(a.columna9) > parseFloat(b.columna9)) {
              return 1;
            }
            if (parseFloat(a.columna9) < parseFloat(b.columna9)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoMontoRenta = "DESC";
        }else{
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna9) - parseFloat(a.columna9);
          });


          this.sortAnexoMontoRenta = "ASC";
        }


        this.getData(null,null,orderData);

      },

      orderAnexoMontoRentaHistorico:function(){

        var orderData = this.anexosdata;
        if (this.sortAnexoMontoRentaHistorico == "ASC") {
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
          if (parseFloat(a.columna9) > parseFloat(b.columna9)) {
              return 1;
            }
            if (parseFloat(a.columna9) < parseFloat(b.columna9)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoMontoRentaHistorico = "DESC";
        }else{
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna9) - parseFloat(a.columna9);
          });
          this.sortAnexoMontoRentaHistorico = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderAnexoSaldoInsoluto:function(){

        var orderData = this.anexosdata;
        if (this.sortAnexoSaldoInsoluto == "ASC") {
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
          if (parseFloat(a.columna12) > parseFloat(b.columna12)) {
              return 1;
            }
            if (parseFloat(a.columna12) < parseFloat(b.columna12)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoSaldoInsoluto = "DESC";
        }else{
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna12) - parseFloat(a.columna12);
          });


          this.sortAnexoSaldoInsoluto = "ASC";
        }
        this.getData(null,null,orderData);
        
      },

      orderAnexoSaldoInsolutoHistorico:function(){

        var orderData = this.anexosdata;
        if (this.sortAnexoSaldoInsolutoHistorico == "ASC") {
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
          if (parseFloat(a.columna12) > parseFloat(b.columna12)) {
              return 1;
            }
            if (parseFloat(a.columna12) < parseFloat(b.columna12)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoSaldoInsolutoHistorico = "DESC";
        }else{
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna12) - parseFloat(a.columna12);
          });


          this.sortAnexoSaldoInsolutoHistorico = "ASC";
        }
        this.getData(null,null,orderData);
        
      },

      orderAnexoCarteraVencida:function(){
        var orderData = this.anexosdata;
        if (this.sortAnexoCarteraVencida == "ASC") {
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
          if (parseFloat(a.columna13) > parseFloat(b.columna13)) {
              return 1;
            }
            if (parseFloat(a.columna13) < parseFloat(b.columna13)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoCarteraVencida = "DESC";
        }else{
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna13) - parseFloat(a.columna13);
          });


          this.sortAnexoCarteraVencida = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderAnexoCarteraVencidaHistorico:function(){

        var orderData = this.anexosdata;
        if (this.sortAnexoCarteraVencidaHistorico == "ASC") {
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
          if (parseFloat(a.columna13) > parseFloat(b.columna13)) {
              return 1;
            }
            if (parseFloat(a.columna13) < parseFloat(b.columna13)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoCarteraVencidaHistorico = "DESC";
        }else{
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna13) - parseFloat(a.columna13);
          });


          this.sortAnexoCarteraVencidaHistorico = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderAnexoMoratorios:function(){

        var orderData = this.anexosdata;
        if (this.sortAnexoMoratorios == "ASC") {
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
          if (parseFloat(a.columna14) > parseFloat(b.columna14)) {
              return 1;
            }
            if (parseFloat(a.columna14) < parseFloat(b.columna14)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoMoratorios = "DESC";
        }else{
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna14) - parseFloat(a.columna14);
          });


          this.sortAnexoMoratorios = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderAnexoMoratoriosHistorico:function(){

        var orderData = this.anexosdata;
        if (this.sortAnexoMoratoriosHistorico == "ASC") {
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
          if (parseFloat(a.columna14) > parseFloat(b.columna14)) {
              return 1;
            }
            if (parseFloat(a.columna14) < parseFloat(b.columna14)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoMoratoriosHistorico = "DESC";
        }else{
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna14) - parseFloat(a.columna14);
          });


          this.sortAnexoMoratoriosHistorico = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderAnexoDiasMora:function(){

        var orderData = this.anexosdata;
        if (this.sortAnexoDiasMora == "ASC") {
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
          if (Number(a.columna15) > Number(b.columna15)) {
              return 1;
            }
            if (Number(a.columna15) < Number(b.columna15)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoDiasMora = "DESC";
        }else{
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return Number(b.columna15) - Number(a.columna15);
          });


          this.sortAnexoDiasMora = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderAnexoDiasMoraHistorico:function(){
        var orderData = this.anexosdata;
        if (this.sortAnexoDiasMoraHistorico == "ASC") {
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
          if (Number(a.columna15) > Number(b.columna15)) {
              return 1;
            }
            if (Number(a.columna15) < Number(b.columna15)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoDiasMoraHistorico = "DESC";
        }else{
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return Number(b.columna15) - Number(a.columna15);
          });


          this.sortAnexoDiasMoraHistorico = "ASC";
        }
        this.getData(null,null,orderData);
      },

      orderAnexoTasa:function(){

        var orderData = this.anexosdata;
        if (this.sortAnexoTasa == "ASC") {
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
          if (parseFloat(a.columna16) > parseFloat(b.columna16)) {
              return 1;
            }
            if (parseFloat(a.columna16) < parseFloat(b.columna16)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoTasa = "DESC";
        }else{
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna16) - parseFloat(a.columna16);
          });


          this.sortAnexoTasa = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderAnexoTasaHistorico:function(){

        var orderData = this.anexosdata;
        if (this.sortAnexoTasaHistorico == "ASC") {
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
          if (parseFloat(a.columna16) > parseFloat(b.columna16)) {
              return 1;
            }
            if (parseFloat(a.columna16) < parseFloat(b.columna16)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoTasaHistorico = "DESC";
        }else{
          orderData.anexos_historicos = this.anexosdata.anexos_historicos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna16) - parseFloat(a.columna16);
          });


          this.sortAnexoTasaHistorico = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderUnidad:function(){

        var orderData = this.anexosdata;
        if (this.sortUnidad == "ASC") {
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
            if (a.columna1.trim() < b.columna1.trim()) {
              return -1;
            }
            if (b.columna1.trim() > a.columna1.trim()) {
              return 1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortUnidad = "DESC";
        }else{
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (a.columna1.trim() > b.columna1.trim()) {
              return -1;
            }
            if (b.columna1.trim() > a.columna1.trim()) {
              return 1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortUnidad = "ASC";
        }

        this.getData(null,null,orderData);

      },

      orderUnidadHistorico:function(){

        var orderData = this.anexosdata;
        if (this.sortUnidadHistorico == "ASC") {
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
            if (a.columna1.trim() < b.columna1.trim()) {
              return -1;
            }
            if (b.columna1.trim() > a.columna1.trim()) {
              return 1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortUnidadHistorico = "DESC";
        }else{
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
          if (a.columna1.trim() > b.columna1.trim()) {
              return -1;
            }
            if (b.columna1.trim() > a.columna1.trim()) {
              return 1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortUnidadHistorico = "ASC";
        }

        this.getData(null,null,orderData);

      },

      orderContrato: function(){
        //Ordenamiento: Anexos por Anexo - Columna 2
        // console.log('--anexosdata--');
        // console.log(this.anexosdata);

        var orderData = this.anexosdata;
        if (this.sortAnexo == "ASC") {
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (a.columna2 > b.columna2) {
              return 1;
            }
            if (a.columna2 < b.columna2) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexo = "DESC";
        }else{
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (a.columna2 < b.columna2) {
              return 1;
            }
            if (a.columna2 > b.columna2) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexo = "ASC";
        }


        this.getData(null,null,orderData);
      },

      orderContratoContratacion: function(){
        //Ordenamiento: Anexos por fecha de contratación - Columna 3
        // console.log('--anexosdata--');
        // console.log(this.anexosdata);
        var self = this;
        var orderData = this.anexosdata;
        if (this.sortAnexoContratacion == "ASC") {
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
            if (self.stringToDate(a.columna3) > self.stringToDate(b.columna3)) {
              return 1;
            }
            if (self.stringToDate(a.columna3) < self.stringToDate(b.columna3)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoContratacion = "DESC";
        }else{
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
            if (self.stringToDate(a.columna3) < self.stringToDate(b.columna3)) {
              return 1;
            }
            if (self.stringToDate(a.columna3) > self.stringToDate(b.columna3)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexoContratacion = "ASC";
        }


        this.getData(null,null,orderData);
      },

      orderContratoTerminacion: function(){
        //Ordenamiento: Anexos por fecha de terminación - Columna 4
        // console.log('--anexosdata--');
        // console.log(this.anexosdata);
        var self = this;
        var orderData = this.anexosdata;
        if (this.sortAnexoTerminacion == "ASC") {
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (self.stringToDate(a.columna4) > self.stringToDate(b.columna4)) {
              return 1;
            }
            if (self.stringToDate(a.columna4) < self.stringToDate(b.columna4)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoTerminacion = "DESC";
        }else{
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (self.stringToDate(a.columna4) < self.stringToDate(b.columna4)) {
              return 1;
            }
            if (self.stringToDate(a.columna4) > self.stringToDate(b.columna4)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexoTerminacion = "ASC";
        }
        this.getData(null,null,orderData);
      },

      orderProximaDomiciliacion:function(){
        var self = this;
        var orderData = this.anexosdata;
        if (this.sortProxDomiciliacion == "ASC") {
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (self.stringToDate(a.columna6) > self.stringToDate(b.columna6)) {
              return 1;
            }
            if (self.stringToDate(a.columna6) < self.stringToDate(b.columna6)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortProxDomiciliacion = "DESC";
        }else{
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (self.stringToDate(a.columna6) < self.stringToDate(b.columna6)) {
              return 1;
            }
            if (self.stringToDate(a.columna6) > self.stringToDate(b.columna6)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortProxDomiciliacion = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderProximaDomiciliacionHistorico:function(){
        var self = this;
        var orderData = this.anexosdata;
        if (this.sortProxDomiciliacionHistorico == "ASC") {
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
          if (self.stringToDate(a.columna6) > self.stringToDate(b.columna6)) {
              return 1;
            }
            if (self.stringToDate(a.columna6) < self.stringToDate(b.columna6)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortProxDomiciliacionHistorico = "DESC";
        }else{
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
          if (self.stringToDate(a.columna6) < self.stringToDate(b.columna6)) {
              return 1;
            }
            if (self.stringToDate(a.columna6) > self.stringToDate(b.columna6)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortProxDomiciliacionHistorico = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderVigenciaSeguro:function(){
        var self = this;
        var orderData = this.anexosdata;
        if (this.sortVigenciaSeguro == "ASC") {
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (self.stringToDate(a.columna7) > self.stringToDate(b.columna7)) {
              return 1;
            }
            if (self.stringToDate(a.columna7) < self.stringToDate(b.columna7)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortVigenciaSeguro = "DESC";
        }else{
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (self.stringToDate(a.columna7) < self.stringToDate(b.columna7)) {
              return 1;
            }
            if (self.stringToDate(a.columna7) > self.stringToDate(b.columna7)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortVigenciaSeguro = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderVigenciaSeguroHistorico:function(){
        var self = this;
        var orderData = this.anexosdata;
        if (this.sortVigenciaSeguroHistorico == "ASC") {
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
          if (self.stringToDate(a.columna7) > self.stringToDate(b.columna7)) {
              return 1;
            }
            if (self.stringToDate(a.columna7) < self.stringToDate(b.columna7)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortVigenciaSeguroHistorico = "DESC";
        }else{
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
          if (self.stringToDate(a.columna7) < self.stringToDate(b.columna7)) {
              return 1;
            }
            if (self.stringToDate(a.columna7) > self.stringToDate(b.columna7)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortVigenciaSeguroHistorico = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderColocacion:function(){

        var orderData = this.anexosdata;
        if (this.sortColocacion == "ASC") {
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (parseFloat(a.columna8) > parseFloat(b.columna8)) {
              return 1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortColocacion = "DESC";
        }else{
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna8) - parseFloat(a.columna8);
          });

          this.sortColocacion = "ASC";
        }

        this.getData(null,null,orderData);

      },

      orderColocacionHistorico:function(){

        var orderData = this.anexosdata;
        if (this.sortColocacionHistorico == "ASC") {
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
          if (parseFloat(a.columna8) > parseFloat(b.columna8)) {
              return 1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortColocacionHistorico = "DESC";
        }else{
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna8) - parseFloat(a.columna8);
          });

          this.sortColocacionHistorico = "ASC";
        }

        this.getData(null,null,orderData);

      },

      orderSaldoInsoluto:function(){
        
        var orderData = this.anexosdata;
        if (this.sortSaldoInsoluto == "ASC") {
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (parseFloat(a.columna9) > parseFloat(b.columna9)) {
              return 1;
            }
            if (parseFloat(a.columna9) < parseFloat(b.columna9)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortSaldoInsoluto = "DESC";
        }else{
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna9) - parseFloat(a.columna9);
          });

          this.sortSaldoInsoluto = "ASC";
        }

        this.getData(null,null,orderData);

      },

      orderSaldoInsolutoHistorico:function(){
        
        var orderData = this.anexosdata;
        if (this.sortSaldoInsolutoHistorico == "ASC") {
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
          if (parseFloat(a.columna9) > parseFloat(b.columna9)) {
              return 1;
            }
            if (parseFloat(a.columna9) < parseFloat(b.columna9)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortSaldoInsolutoHistorico = "DESC";
        }else{
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna9) - parseFloat(a.columna9);
          });

          this.sortSaldoInsolutoHistorico = "ASC";
        }

        this.getData(null,null,orderData);

      },

      orderCarteraVencida:function(){
        
        var orderData = this.anexosdata;
        if (this.sortCarteraVencida == "ASC") {
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (parseFloat(a.columna10) > parseFloat(b.columna10)) {
              return 1;
            }
            if (parseFloat(a.columna10) < parseFloat(b.columna10)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortCarteraVencida = "DESC";
        }else{
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna10) - parseFloat(a.columna10);
          });

          this.sortCarteraVencida = "ASC";
        }

        this.getData(null,null,orderData);

      },

      orderCarteraVencidaHistorico:function(){
        
        var orderData = this.anexosdata;
        if (this.sortCarteraVencidaHistorico == "ASC") {
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
          if (parseFloat(a.columna10) > parseFloat(b.columna10)) {
              return 1;
            }
            if (parseFloat(a.columna10) < parseFloat(b.columna10)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortCarteraVencidaHistorico = "DESC";
        }else{
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna10) - parseFloat(a.columna10);
          });

          this.sortCarteraVencidaHistorico = "ASC";
        }

        this.getData(null,null,orderData);

      },

      orderMoratorios:function(){
        
        var orderData = this.anexosdata;
        if (this.sortMoratorios == "ASC") {
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (parseFloat(a.columna11) > parseFloat(b.columna11)) {
              return 1;
            }
            if (parseFloat(a.columna11) < parseFloat(b.columna11)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortMoratorios = "DESC";
        }else{
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna11) - parseFloat(a.columna11);
          });

          this.sortMoratorios = "ASC";
        }

        this.getData(null,null,orderData);

      },

      orderMoratoriosHistorico:function(){
        
        var orderData = this.anexosdata;
        if (this.sortMoratoriosHistorico == "ASC") {
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
          if (parseFloat(a.columna11) > parseFloat(b.columna11)) {
              return 1;
            }
            if (parseFloat(a.columna11) < parseFloat(b.columna11)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortMoratoriosHistorico = "DESC";
        }else{
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna11) - parseFloat(a.columna11);
          });

          this.sortMoratoriosHistorico = "ASC";
        }

        this.getData(null,null,orderData);

      },

      orderDiasMora:function(){
        var orderData = this.anexosdata;
        if (this.sortDiasMora == "ASC") {
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (Number(a.columna12) > Number(b.columna12)) {
              return 1;
            }
            if (Number(a.columna12) < Number(b.columna12)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortDiasMora = "DESC";
        }else{
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return Number(b.columna12) - Number(a.columna12);
          });


          this.sortDiasMora = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderDiasMoraHistorico:function(){
        var orderData = this.anexosdata;
        if (this.sortDiasMoraHistorico == "ASC") {
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
          if (Number(a.columna12) > Number(b.columna12)) {
              return 1;
            }
            if (Number(a.columna12) < Number(b.columna12)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortDiasMoraHistorico = "DESC";
        }else{
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return Number(b.columna12) - Number(a.columna12);
          });


          this.sortDiasMoraHistorico = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderTasa:function(){

        var orderData = this.anexosdata;
        if (this.sortTasa == "ASC") {
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (parseFloat(a.columna13) > parseFloat(b.columna13)) {
              return 1;
            }
            if (parseFloat(a.columna13) < parseFloat(b.columna13)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortTasa = "DESC";
        }else{
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna13) - parseFloat(a.columna13);
          });


          this.sortTasa = "ASC";
        }
        this.getData(null,null,orderData);

      },

      orderTasaHistorico:function(){

        var orderData = this.anexosdata;
        if (this.sortTasaHistorico == "ASC") {
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
          if (parseFloat(a.columna13) > parseFloat(b.columna13)) {
              return 1;
            }
            if (parseFloat(a.columna13) < parseFloat(b.columna13)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortTasaHistorico = "DESC";
        }else{
          orderData.contratos_historicos = this.anexosdata.contratos_historicos.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna13) - parseFloat(a.columna13);
          });


          this.sortTasaHistorico = "ASC";
        }
        this.getData(null,null,orderData);

      },

      Save_comentario: function(){
        var self =this;
            var comentario = this.$('#txtComment').val();
            //alert("comentarios  " +comentario);
            if(comentario!="")
            {
              app.api.call("update", app.api.buildURL("tct02_Resumen/"+this.model.get('id')),{"tct_datos_clave_txa_c":comentario
               }, {
                   success: _.bind(function (data) {
                       if (data!=null) {
                           app.alert.show("alerta_datos_clave", {
                               level: "info",
                               title: "Datos creados",
                               autoClose: false
                           });
                       }
                   }, this)
               });

            }
      },
      orderCesion: function(){
        //Ordenamiento: Anexos por Anexo - Columna 2
        // console.log('--anexosdata--');
        // console.log(this.anexosdata);

        var orderData = this.anexosdata;
        if (this.sortAnexo == "ASC") {
          orderData.cesiones_activas = this.anexosdata.cesiones_activas.sort(function (a, b) {
          if (a.columna1 > b.columna1) {
              return 1;
            }
            if (a.columna1 < b.columna1) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexo = "DESC";
        }else{
          orderData.cesiones_activas = this.anexosdata.cesiones_activas.sort(function (a, b) {
          if (a.columna1 < b.columna1) {
              return 1;
            }
            if (a.columna1 > b.columna1) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexo = "ASC";
        }


        this.getData(null,null,orderData);
      },

      orderCesionVencimiento: function(){
        //Ordenamiento: Anexos por fecha de contratación - Columna 3
        // console.log('--anexosdata--');
        // console.log(this.anexosdata);
        var self = this;
        var orderData = this.anexosdata;
        if (this.sortAnexoTerminacion == "ASC") {
          orderData.cesiones_activas = this.anexosdata.cesiones_activas.sort(function (a, b) {
            if (self.fDate(a.columna3) > self.fDate(b.columna3)) {
              return 1;
            }
            if (self.fDate(a.columna3) < self.fDate(b.columna3)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoTerminacion = "DESC";
        }else{
          orderData.cesiones_activas = this.anexosdata.cesiones_activas.sort(function (a, b) {
            if (self.fDate(a.columna3) < self.fDate(b.columna3)) {
              return 1;
            }
            if (self.fDate(a.columna3) > self.fDate(b.columna3)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexoTerminacion = "ASC";
        }


        this.getData(null,null,orderData);
      },

      orderCesionHistorico:function(){
        var orderData = this.anexosdata;
        if (this.sortCesionHistorico== "ASC") {
          orderData.cesiones_historicas = this.anexosdata.cesiones_historicas.sort(function (a, b) {
          if (a.columna1 > b.columna1) {
              return 1;
            }
            if (a.columna1 < b.columna1) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortCesionHistorico = "DESC";
        }else{
          orderData.cesiones_historicas = this.anexosdata.cesiones_historicas.sort(function (a, b) {
          if (a.columna1 < b.columna1) {
              return 1;
            }
            if (a.columna1 > b.columna1) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortCesionHistorico = "ASC";
        }


        this.getData(null,null,orderData);
      },

      orderDeudorHistorico:function(){

        var orderData = this.anexosdata;
        if (this.sortDeudorHistorico == "ASC") {
          orderData.cesiones_historicas = this.anexosdata.cesiones_historicas.sort(function (a, b) {
            if (a.columna2 < b.columna2) {
              return -1;
            }
            if (b.columna2 > a.columna2) {
              return 1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortDeudorHistorico = "DESC";
        }else{
          orderData.cesiones_historicas = this.anexosdata.cesiones_historicas.sort(function (a, b) {
          if (a.columna2 > b.columna2) {
              return -1;
            }
            if (b.columna2 > a.columna2) {
              return 1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortDeudorHistorico = "ASC";
        }

        this.getData(null,null,orderData);

      },

      orderMontoVencerHistorico:function(){
        var orderData = this.anexosdata;
        if (this.sortMontoVencerHistorico == "ASC") {
          orderData.cesiones_historicas = this.anexosdata.cesiones_historicas.sort(function (a, b) {
          if (parseFloat(a.columna4) > parseFloat(b.columna4)) {
              return 1;
            }
            if (parseFloat(a.columna4) < parseFloat(b.columna4)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortMontoVencerHistorico = "DESC";
        }else{
          orderData.cesiones_historicas = this.anexosdata.cesiones_historicas.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna4) - parseFloat(a.columna4);
          });

          this.sortMontoVencerHistorico = "ASC";
        }

        this.getData(null,null,orderData);
      },

      orderMontoDescuentoHistorico:function(){

        var orderData = this.anexosdata;
        if (this.sortMontoDescuentoHistorico == "ASC") {
          orderData.cesiones_historicas = this.anexosdata.cesiones_historicas.sort(function (a, b) {
          if (parseFloat(a.columna5) > parseFloat(b.columna5)) {
              return 1;
            }
            if (parseFloat(a.columna5) < parseFloat(b.columna5)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortMontoDescuentoHistorico = "DESC";
        }else{
          orderData.cesiones_historicas = this.anexosdata.cesiones_historicas.sort(function (a, b) {
            /*
          if (parseFloat(b.columna8) > parseFloat(a.columna8)) {
              return -1;
            }
            if (parseFloat(a.columna8) < parseFloat(b.columna8)) {
              return -1;
            }
            // a must be equal to b
            return 0;
            */
           return parseFloat(b.columna5) - parseFloat(a.columna5);
          });

          this.sortMontoDescuentoHistorico = "ASC";
        }

        this.getData(null,null,orderData);

      },
      // Función para comparación de fechas
      fDate: function(s) {
        var d = new Date();
        s = s.split('/');
        d.setFullYear(s[2]);
        d.setMonth(s[1]);
        d.setDate(s[0]);
        return d;
      },

      stringToDate: function(s) {
        var d = new Date();
        if(s!=null && s!=""){
          s = s.split('-');
          d.setFullYear(s[0]);
          d.setMonth(s[1]);
          d.setDate(s[2]);
          return d;
        }
        return "";
        
      },

    creaNuevaLinea:function(e){
        var tipo_producto = $(e.currentTarget).attr('data-name');
        var id_cuenta = contexto_cuenta.model.attributes.id;
        var nombre_cuenta= contexto_cuenta.model.attributes.name;
        var producto = 'leasing';
        switch (tipo_producto) {
            case '1':
                producto = 'leasing';
            break;
            case '4':
                producto = 'factoring';
            break;
            default:
        }
        if(!vista360.ResumenCliente[producto].tiene_linea_autorizada){
            // Drawer Pre-solicitud
            var modeloOppty = App.data.createBean('Opportunities');
            modeloOppty.set('account_id',id_cuenta);
            modeloOppty.set('account_name',nombre_cuenta);
            modeloOppty.set('tipo_producto_c',tipo_producto);

            App.drawer.open({
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
        }else{
            //Drawer Pre o R/I
            App.drawer.open({
                layout: 'solicitud-layout',
                context: {
                    nuevaOpp: {"idCuenta":id_cuenta,"idProducto":tipo_producto,"nombreCuenta":nombre_cuenta}
                },
            },
            function() {
                //on close, throw an alert
                console.log("Cierra drawer de Opportunities");
            });
        }

    },
    hideElements: function(s) {
      console.log('test');
    },


})
