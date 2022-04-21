({
    events:{
        'click .gpoEmpresarial': 'openGpoEmpresarial',
        'click .closeModalGpoEmpresarial': 'closeModalGpoEmpresarial',
        'click .btnAddContact':'openDrawerRelacion',
        'click .btnNuevaReunion':'openDrawerReunion',
        'click .addCall':'generatecall',
        'click .sendEmail':'openDrawerSendEmail',
        'click .btnNewPre':'openDrawerPre',


        //Despliegue de detalle
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
      'click #orderByAnexo': 'orderAnexo',
      'click #orderByAnexoContrata': 'orderAnexoContratacion',
      'click #orderByAnexoTermino': 'orderAnexoTerminacion',
      //Contratos
      'click #orderByContrato': 'orderContrato',
      'click #orderByContratoContrata': 'orderContratoContratacion',
      'click #orderByContratoTermino': 'orderContratoTerminacion',
      //Cesiones
      'click #orderByCesion': 'orderCesion',
      'click #orderByCesionVencimiento': 'orderCesionVencimiento',
      'click .btn-Guardar': 'Save_comentario',
      'click #btn-Descargar':'descargapdf',
    },

    initialize: function(options) {
        this._super('initialize', [options]);
        //vista360 es la variable que guarda el contexto de el actual campo custom y se llena desde el record.js de Cuentas
        vista360 = this;
        //Define variables de ordenamiento
        this.sortAnexo = "ASC";
        this.sortAnexoContratacion = "ASC";
        this.sortAnexoTerminacion = "ASC";
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

                var modeloEmail=App.data.createBean('Emails');
                modeloEmail.set('name','Correo desde 360');
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

      orderAnexoContratacion: function(){
        //Ordenamiento: Anexos por fecha de contratación - Columna 3
        // console.log('--anexosdata--');
        // console.log(this.anexosdata);
        var self = this;
        var orderData = this.anexosdata;
        if (this.sortAnexoContratacion == "ASC") {
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
            if (self.fDate(a.columna3) > self.fDate(b.columna3)) {
              return 1;
            }
            if (self.fDate(a.columna3) < self.fDate(b.columna3)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoContratacion = "DESC";
        }else{
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
            if (self.fDate(a.columna3) < self.fDate(b.columna3)) {
              return 1;
            }
            if (self.fDate(a.columna3) > self.fDate(b.columna3)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexoContratacion = "ASC";
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
          if (self.fDate(a.columna4) > self.fDate(b.columna4)) {
              return 1;
            }
            if (self.fDate(a.columna4) < self.fDate(b.columna4)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoTerminacion = "DESC";
        }else{
          orderData.anexos_activos = this.anexosdata.anexos_activos.sort(function (a, b) {
          if (self.fDate(a.columna4) < self.fDate(b.columna4)) {
              return 1;
            }
            if (self.fDate(a.columna4) > self.fDate(b.columna4)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexoTerminacion = "ASC";
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
            if (self.fDate(a.columna3) > self.fDate(b.columna3)) {
              return 1;
            }
            if (self.fDate(a.columna3) < self.fDate(b.columna3)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoContratacion = "DESC";
        }else{
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
            if (self.fDate(a.columna3) < self.fDate(b.columna3)) {
              return 1;
            }
            if (self.fDate(a.columna3) > self.fDate(b.columna3)) {
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
          if (self.fDate(a.columna4) > self.fDate(b.columna4)) {
              return 1;
            }
            if (self.fDate(a.columna4) < self.fDate(b.columna4)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });
          this.sortAnexoTerminacion = "DESC";
        }else{
          orderData.contratos_activos = this.anexosdata.contratos_activos.sort(function (a, b) {
          if (self.fDate(a.columna4) < self.fDate(b.columna4)) {
              return 1;
            }
            if (self.fDate(a.columna4) > self.fDate(b.columna4)) {
              return -1;
            }
            // a must be equal to b
            return 0;
          });

          this.sortAnexoTerminacion = "ASC";
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
      // Función para comparación de fechas
      fDate: function(s) {
        var d = new Date();
        s = s.split('/');
        d.setFullYear(s[2]);
        d.setMonth(s[1]);
        d.setDate(s[0]);
        return d;
      },
        //Funcion para descargar el pdf de la seccion vista 360
        descargapdf: function() {
            //Variable url con estructura de dirección de descarga dinámica, sin importar el ambiente en el que se encuentre.
            var url = window.location.origin+window.location.pathname+'custom/pdf/NoticiasUnifin.pdf';
            //Elimina index.php en caso de tenerlo para dejar la url intacta.
            url = url.replace(/index.php/gi, "");
            //Abre ventana nueva con las dimensiones establecidas.
            window.open(url, 'Noticias', 'width=450, height=500, top=85, left=50', true);
        },

    openDrawerPre:function(e){
        var modeloOppty = App.data.createBean('Opportunities');
        var id_cuenta = contexto_cuenta.model.attributes.id;
        var nombre_cuenta= contexto_cuenta.model.attributes.name;
        var tipo_producto = $(e.currentTarget).attr('data-name');
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


    },


})
