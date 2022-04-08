({
    events:{
        'click .gpoEmpresarial': 'openGpoEmpresarial',
        'click .closeModalGpoEmpresarial': 'closeModalGpoEmpresarial',
        'click .btnAddContact':'openDrawerRelacion',
        'click .btnNuevaReunion':'openDrawerReunion',
        'click .addCall':'generatecall',
        'click .sendEmail':'openDrawerSendEmail'
    },

    initialize: function(options) {
        this._super('initialize', [options]);
        //vista360 es la variable que guarda el contexto de el actual campo custom y se llena desde el record.js de Cuentas
        vista360 = this;
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

    openDrawerRelacion:function(){
        
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
                                model: model
                                },
                            },
                            function(variable){
                                console.log("DESDE PREVIEW RELACION");
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
                                model: model
                            },
                        },
                        function(variable){
                            console.log("DESDE PREVIEW RELACION");
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
                              model: model
                          },
                      },
                      function(variable){
                          console.log("DESDE PREVIEW RELACION");
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
        var nombre_cuenta=$(e.currentTarget).attr('data-name');
        
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
    }

})