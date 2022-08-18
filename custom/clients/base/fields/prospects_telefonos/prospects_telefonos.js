({
    events: {
      'click  .mcall': 'makecall',
      'keydown .Telefonot': 'keyDownNewExtension',
      'keydown .Telefonoc': 'keyDownNewExtension',
      'keydown .Telefonom': 'keyDownNewExtension',
      'change .Telefonot': 'updateTelefonot', //Trabajo
      'change .Telefonoc': 'updateTelefonoc', //Casa
      'change .Telefonom': 'updateTelefonom', //Celular
    },

    initialize: function (options) {
      //Inicializa campo custom
      options = options || {};
      options.def = options.def || {};
      this._super('initialize', [options]);
      this.model.on('sync', this.loadData, this);
      this.c_estatus1 = 1;
      this.m_estatus1 = 1;
      this.o_estatus1 = 1;
      this.c_estatus = app.lang.getAppListStrings('estatus_telefono_list')[1];
      this.m_estatus = app.lang.getAppListStrings('estatus_telefono_list')[1];
      this.o_estatus = app.lang.getAppListStrings('estatus_telefono_list')[1];
    },

    loadData: function () {
      this.phone_home = this.model.get('phone_home');
      this.phone_mobile = this.model.get('phone_mobile');
      this.phone_work = this.model.get('phone_work');
      this.c_registro_reus_c = this.model.get('c_registro_reus_c');
      this.m_registro_reus_c = this.model.get('m_registro_reus_c');
      this.o_registro_reus_c = this.model.get('o_registro_reus_c');
      //Estatus Teléfono 06/01/2022 ECB
      var c_estatus_telefono_c = this.model.get('c_estatus_telefono_c');
      var m_estatus_telefono_c = this.model.get('m_estatus_telefono_c');
      var o_estatus_telefono_c = this.model.get('o_estatus_telefono_c');
      var c_c4 = 0;
      var m_c4 = 0;
      var o_c4 = 0;
      this.c_estatus1 = 0;
      this.c_estatus2 = 0;
      this.c_estatus3 = 0;
      this.m_estatus1 = 0;
      this.m_estatus2 = 0;
      this.m_estatus3 = 0;
      this.o_estatus1 = 0;
      this.o_estatus2 = 0;
      this.o_estatus3 = 0;
      if (c_estatus_telefono_c) {
        var c_estatus_tel = JSON.parse(c_estatus_telefono_c);
        if(c_estatus_tel[0].result == 0) {
          this.c_estatus1 = 1;
          this.c_estatus = app.lang.getAppListStrings('estatus_telefono_list')[1];
        }
        if(c_estatus_tel[0].result == 1) {
          this.c_estatus2 = 1;
          this.c_estatus = app.lang.getAppListStrings('estatus_telefono_list')[2] + ' (' + c_estatus_tel[0].Compania + ')';
        }
        if(c_estatus_tel[0].result == 2) {
          this.c_estatus3 = 1;
          this.c_estatus = app.lang.getAppListStrings('estatus_telefono_list')[3];
        }
        if(c_estatus_tel[0].Estatus_reporte) {
          if(c_estatus_tel[0].Estatus_reporte.substring(0,3) == 'Con') this.c_c4 = 1;
        }
      }
      else {
        this.c_estatus1 = 1;
        this.c_estatus = app.lang.getAppListStrings('estatus_telefono_list')[1];
      }
      if (m_estatus_telefono_c) {
        var m_estatus_tel = JSON.parse(m_estatus_telefono_c);
        if(m_estatus_tel[0].result == 0) {
          this.m_estatus1 = 1;
          this.m_estatus = app.lang.getAppListStrings('estatus_telefono_list')[1];
        }
        if(m_estatus_tel[0].result == 1) {
          this.m_estatus2 = 1;
          this.m_estatus = app.lang.getAppListStrings('estatus_telefono_list')[2] + ' (' + m_estatus_tel[0].Compania + ')';
        }
        if(m_estatus_tel[0].result == 2) {
          this.m_estatus3 = 1;
          this.m_estatus = app.lang.getAppListStrings('estatus_telefono_list')[3];
        }
        if(m_estatus_tel[0].Estatus_reporte) {
          if(m_estatus_tel[0].Estatus_reporte.substring(0,3) == 'Con') this.m_c4 = 1;
        }
      }
      else {
        this.m_estatus1 = 1;
        this.m_estatus = app.lang.getAppListStrings('estatus_telefono_list')[1];
      }
      if (o_estatus_telefono_c) {
        var o_estatus_tel = JSON.parse(o_estatus_telefono_c);
        if(o_estatus_tel[0].result == 0) {
          this.o_estatus1 = 1;
          this.o_estatus = app.lang.getAppListStrings('estatus_telefono_list')[1];
        }
        if(o_estatus_tel[0].result == 1) {
          this.o_estatus2 = 1;
          this.o_estatus = app.lang.getAppListStrings('estatus_telefono_list')[2] + ' (' + o_estatus_tel[0].Compania + ')';
        }
        if(o_estatus_tel[0].result == 2) {
          this.o_estatus3 = 1;
          this.o_estatus = app.lang.getAppListStrings('estatus_telefono_list')[3];
        }
        if(o_estatus_tel[0].Estatus_reporte) {
          if(o_estatus_tel[0].Estatus_reporte.substring(0,3) == 'Con') this.o_c4 = 1;
        }
      }
      else {
        this.o_estatus1 = 1;
        this.o_estatus = app.lang.getAppListStrings('estatus_telefono_list')[1];
      }
      $('[data-name="reus_work"]').hide();
      $('[data-name="reus_home"]').hide();
      $('[data-name="reus_mobile"]').hide();
      $('[data-name="phone_work"]').hide();
      $('[data-name="phone_home"]').hide();
      $('[data-name="phone_mobile"]').hide();
      $('[data-name="c_estatus_telefono_c"]').hide();
      $('[data-name="m_estatus_telefono_c"]').hide();
      $('[data-name="o_estatus_telefono_c"]').hide();
      this.render();
    },

    bindDataChange: function () {
      this.model.on('change:' + this.name, function () {
        if (this.action !== 'edit') {
        }
      }, this);
    },

    _render: function () {
      this._super("_render");
      if(window.cancel) {
        this.phone_work = this.model.get('phone_work');
        this.phone_home = this.model.get('phone_home');
        this.phone_mobile = this.model.get('phone_mobile');
        this.o_registro_reus_c = this.model.get('o_registro_reus_c');
        this.c_registro_reus_c = this.model.get('c_registro_reus_c');
        this.m_registro_reus_c = this.model.get('m_registro_reus_c');
        window.cancel = 0;
        this.render();
      }
    },

    keyDownNewExtension: function (evt) {
      if (!evt) return;
      if (!this.checkNumOnly(evt)) {
        return false;
      }
    },

    //UNI349 Control Telefonos - En el campo teléfono, extensión no se debe permitir caracteres diferentes a numéricos
    checkNumOnly: function (evt) {
      if ($.inArray(evt.keyCode, [110, 188, 190, 45, 33, 36, 46, 35, 34, 8, 9, 20, 16, 17, 37, 40, 39, 38, 16, 49, 50, 51, 52, 53, 54, 55, 56, 57, 48, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105]) < 0) {
        app.alert.show("Caracter Invalido", {
          level: "error",
          title: "Solo n\u00FAmeros son permitidos en este campo.",
          autoClose: true
        });
        return false;
      } else {
        return true;
      }
    },

    makecall: function (evt) {
      if (!evt) return;
      var $input = this.$(evt.currentTarget);
      var tel_client = $input.closest("tr").find("td").eq(1).html();
      var tel_usr = app.user.attributes.ext_c;
      var prospectid = this.model.get('id');
      //vicidial = app.config.vicidial + '?exten=SIP/' + tel_usr + '&number=' + tel_client;
      //_.extend(this, vicidial);
      if (tel_usr != '' && tel_usr != null) {
        if (tel_client != '' && tel_client != null) {
          context = this;
          app.alert.show('do-call', {
            level: 'confirmation',
            messages: '¿Realmente quieres realizar la llamada? <br><br><b>NOTA: La marcaci\u00F3n se realizar\u00E1 tal cual el n\u00FAmero est\u00E1 registrado</b>',
            autoClose: false,
            onConfirm: function () {
              //context.createcall(context.resultCallback);
              context.createcall(tel_client);
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
    },

    createcall: function (tel_client) {
      //Recupera variables para petición
      self = this;
      var posiciones = App.user.attributes.posicion_operativa_c;
      var posicion = '';
      var name_client = this.model.get('name');
      if(posiciones.includes(3)) posicion = 'Ventas';
      if(posiciones.includes(4)) posicion = 'Staff';
      var Params = {
          'id_cliente': this.model.get('id'),
          'nombre_cliente': name_client,
          'numero_cliente': tel_client,
          'modulo': 'Prospects',
          'posicion': posicion,
          'puesto_usuario': App.user.attributes.puestousuario_c,
          'ext_usuario': App.user.attributes.ext_c
      };
      //Ejecuta petición para generar llamada
      app.api.call('create', app.api.buildURL('createcall'), { data: Params }, {
        success: _.bind(function (data) {
          id_call = data;
          console.log('Llamada creada, id: ' + id_call);
          app.alert.show('message-to', {
            level: 'info',
            messages: 'Usted está llamando a ' + name_client,
            autoClose: true
          });
          //callback(id_call, self);
        }, this),
      });
    },

    resultCallback: function (id_call, context) {
      self = context;
      vicidial += '&prospectid=' + id_call;
      $.ajax({
        cache: false,
        type: "get",
        url: vicidial,
      });
    },

    updateTelefonot: function (evt) {
      var inputs = this.$('.Telefonot'),
      input = this.$(evt.currentTarget),
      index = inputs.index(input);
      var telefonot = input.val();
      this.model.set('phone_work',telefonot);
      this.phone_work = telefonot;
    },

    updateTelefonoc: function (evt) {
      var inputs = this.$('.Telefonoc'),
      input = this.$(evt.currentTarget),
      index = inputs.index(input);
      var telefonoc = input.val();
      this.model.set('phone_home',telefonoc);
      this.phone_home = telefonoc;
    },

    updateTelefonom: function (evt) {
      var inputs = this.$('.Telefonom'),
      input = this.$(evt.currentTarget),
      index = inputs.index(input);
      var telefonom = input.val();
      this.model.set('phone_mobile',telefonom);
      this.phone_mobile = telefonom;
    },
  })
