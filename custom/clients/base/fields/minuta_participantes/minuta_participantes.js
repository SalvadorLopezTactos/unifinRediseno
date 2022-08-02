/*
 *  AF - 2018-10-23
 *  CustomField - Grid
 */
({
    events: {
        'click  .addParticipante': 'addParticipanteFunction',
        'click  .addParticipantes': 'addParticipantesFunction',
        'change .newCampo5P': 'validaTamano'
    },

    /**
     * @inheritdoc
     * @param options
     */
    mParticipantes : null,
    tipoContacto : null,
    initialize: function (options) {
        //Inicializa campo custom
        self = this;
        this._super('initialize', [options]);

        this.model.addValidationTask('GuardarParticipantes', _.bind(this.estableceParticipantes, this));

        //Carga datos:
        //Creación
        this.loadData();
        //Registro
        this.model.on('sync', this.loadData, this);

    },

    loadData: function (options) {
      //Recupera data existente
      this.mParticipantes = '';
      this.tipoContacto = App.lang.getAppListStrings('Tipo_Contacto_list');

      selfData = this;
      var idReunion = '';

      if (this.action == 'detail') {
        //Recupera datos para vista de detalle
        idReunion = this.model.get('id');
        app.api.call('GET', app.api.buildURL('RecordParticipantes/'+idReunion), null, {
            success: function (data) {
                selfData.mParticipantes= data;
                _.extend(this, selfData.mParticipantes);
                selfData.render();
            },
            error: function (e) {
                throw e;
            }
        });
      }else if(this.context.parent){

          //Recupera datos para vista de creación
          idReunion = this.context.parent.attributes.modelId;
          app.alert.show('alert_participants', {
            level: 'process',
            title: 'Cargando...'
          });
          var moduleid = app.data.createBean('Meetings',{id:idReunion});
          moduleid.fetch({
              success:_.bind(function(modelo){
                  /*if(modelo.get('parent_meeting_c')!="" && modelo.get('parent_meeting_c')!="undefine"){
                      idReunion = modelo.get('parent_meeting_c');
                  }*/

                  app.api.call('GET', app.api.buildURL('GetParticipantes/'+idReunion), null, {
                      success: function (data) {
                          selfData.mParticipantes= data;
                          _.extend(this, selfData.mParticipantes);
                          selfData.render();
                          app.alert.dismiss('alert_participants');
                      },
                      error: function (e) {
                          throw e;
                      }
                  });

              }, this)
          });
      }
      this.render();
    },

    _render: function () {
        this._super("_render");
        //self.mParticipantes = self.model.set('minuta_participantes',mParticipantes);

        var self = this;
        //Función related
        $('.bigdrop').each(function( index, value ) {
            $('#'+this.id).select2({
                placeholder: "Buscar participante...",
                minimumInputLength: 1,
                allowClear: true,
                ajax: {
                    url: window.location.origin + window.location.pathname+"rest/v11_1/searchaccount",
                    dataType: 'json',
                    data: function (term, page) {
                        return {q:term};
                    },
                    results: function (data, page) {
                        return {results: data.records};
                    }
                },
                formatResult: function(m) { return m.text; },
                formatSelection: function(m) { return m.text; }
            })
        });

        $('.updateAsistencia').click(function(evt) {
          var row = $(this).closest("tr");    // Find the row
          if (selfData.mParticipantes.participantes[row.index()].asistencia == 1) {
              selfData.mParticipantes.participantes[row.index()].asistencia = 0;
          }else{
              selfData.mParticipantes.participantes[row.index()].asistencia = 1;
          }
          selfData.render();
        });
        $('.campo2P').change(function(evt) {
          var row = $(this).closest("tr");
          var correo =row.prevObject[0].value; //$('.campo2P').eq(row.index()).val();
          if(correo.trim() == "") {
                if (selfData.mParticipantes.participantes[row.index()].asistencia == 1) {
                    $('.campo2SelectP').eq(row.index()).find('input').css('border-color', 'red');
                    //Alerta coreo requerido
                    app.alert.show('email_telefono_error', {
                      level: 'error',
                      autoClose: true,
                      messages: 'El correo es requerido para un paprticipante con asistencia,'
                    });
                }
                //Alerta correo vacío
                app.alert.show('email_vacio', {
                  level: 'warning',
                  autoClose: true,
                  messages: 'El Correo solo se eliminará de la información de la minuta, no de la cuenta del participante.'
                });
          }else{
              $('.campo2SelectP').eq(row.index()).find('input').css('border-color', '');
              if (!selfData.validaMail(correo)) {
                $('.campo2SelectP').eq(row.index()).find('input').css('border-color', 'red');
                app.alert.show('mail_participante_error', {
                    level: 'error',
                    autoClose: true,
                    messages: 'Formato de correo incorrecto'
                });
                $('.campo2SelectP').eq(row.index()).find('input').val('');
              }
              else {
                selfData.mParticipantes.participantes[row.index()].correo = correo;
              }
          }
          selfData.mParticipantes.participantes[row.index()].correo = correo;
        });
        $('.campo3P').change(function(evt) {
            var row = $(this).closest("tr");
            var telefono = row.prevObject[0].value; //$('.campo3P').eq(row.index()).val();
            //Notifica teléfono vacío
            if (telefono.trim() == "") {
                //Alerta correo vacío
                app.alert.show('telefono_vacio', {
                  level: 'warning',
                  autoClose: true,
                  messages: 'El Teléfono solo se eliminará de la información de la minuta, no de la cuenta del participante.'
                });
            }
            if(telefono!="" && telefono!= selfData.mParticipantes.participantes[row.index()].tel_previo) {
                if (!selfData.validaTamano(telefono) && telefono) {
                    $('.campo3SelectP').eq(row.index()).find('input').css('border-color', 'red');
                    app.alert.show('phone_participante_error', {
                        level: 'error',
                        autoClose: true,
                        messages: 'Formato de tel\u00E9fono incorrecto'
                    });
                    $('.campo3SelectP').eq(row.index()).find('input').val('');
                }else {

                    var idtelefono=  selfData.mParticipantes.participantes[row.index()].id;
                    var urlapi = app.api.buildURL("Accounts/" + idtelefono + "/link/accounts_tel_telefonos_1");
                    var repetido= 0;

                    app.api.call("read", urlapi, null, null, {
                        success: _.bind(function (data) {
                            if (data.records.length > 0) {
                                Object.keys(data.records).forEach(function (key) {
                                    if (telefono == data.records[key].telefono) {
                                        repetido++;
                                    }
                                });
                                if (repetido>0) {
                                    var nombrec= selfData.mParticipantes.participantes[row.index()].nombres;
                                    var apellidoc=selfData.mParticipantes.participantes[row.index()].apaterno;
                                    var apellidomc=selfData.mParticipantes.participantes[row.index()].amaterno;
                                    var idcuenta= selfData.mParticipantes.participantes[row.index()].id;
                                    app.alert.show('Error_telefono_repetido', {
                                        level: 'error',
                                        autoClose: false,
                                        messages: 'El número <b>' + telefono + '</b> ya existe en la cuenta '+'<a href="#Accounts/'+idcuenta+'" target= "_blank">'+ nombrec +' '+ apellidoc +' '+apellidomc+' </a>',
                                    });

                                    $('.campo3SelectP').eq(row.index()).find('input').css('border-color', 'red');
                                    selfData.mParticipantes.participantes[row.index()].telefono = selfData.mParticipantes.participantes[row.index()].tel_previo;
                                    selfData.render();
                                }
                                else{
                                    $('.campo3SelectP').eq(row.index()).find('input').css('border-color', '');
                                    selfData.mParticipantes.participantes[row.index()].telefono = telefono;
                                }
                            }else{
                                $('.campo3SelectP').eq(row.index()).find('input').css('border-color', '');
                                selfData.mParticipantes.participantes[row.index()].telefono = telefono;
                            }
                        }, this),
                    });
                }
            }else{
                selfData.mParticipantes.participantes[row.index()].telefono = telefono;
            }
        });
    },

    /*
        Función para agregar nuevos elementos al objeto
    */
    addParticipanteFunction: function (options) {
            //Estableciendo el color de borde original en cada campo
            $('.newCampo1P').css('border-color', '');
            $('.newCampo2P').css('border-color', '');
            $('.newCampo3P').css('border-color', '');
            $('.newCampo4P').css('border-color', '');
            $('.newCampo5P').css('border-color', '');
            $('.newCampo6P').css('border-color', '');

            //Obteniendo valores de los campos
            var valor1 = $('.newCampo1P')[0].value.trim();
            var valor2 = $('.newCampo2P')[0].value.trim();
            var valor3 = $('.newCampo3P')[0].value.trim();
            var valor4 = $('.newCampo4P')[0].value;
            var valor5 = $('.newCampo5P')[0].value;
            var valor6 = $('.newCampo6P')[0].value;

            var item = {
                "id": "",
                "nombres": valor1,
                "apaterno": valor2,
                "amaterno": valor3,
                "telefono": valor5,
                "correo": valor4,
                "origen": "N",
                "unifin": 0,
                "tipo_contacto": valor6,
                "asistencia": 1,
                "activo" : "1",
                "clean_name":"",
                "tel_previo":valor3
            };

            //Valida campos requeridos
            var faltantes = 0;
            var campos = "";
            //Nombres
            if (valor1 == '' || valor1.trim()=='') {
                    $('.newCampo1P').css('border-color', 'red');
                    campos = campos + '<b>' + $('.newCampo1P')[0].placeholder + '</b><br>';
                    faltantes++;
            }

            if ((valor1 != '' || valor1.trim()!='') ) {
                if(!this.ValidaCaracter(valor1))
                {
                    $('.newCampo1P').css('border-color', 'red');
                    app.alert.show('Tname_participante_error', {
                        level: 'error',
                        autoClose: true,
                        messages: 'Formato de nombre incorrecto'
                    });
                    faltantes++;
                }
            }

            //Apellido Paterno
            if (valor2 == '' || valor2.trim()=='') {
                $('.newCampo2P').css('border-color', 'red');
                campos = campos + '<b>' + $('.newCampo2P')[0].placeholder + '</b><br>';
                faltantes++
            }

            if ((valor2 != '' || valor2.trim()!='') ) {
                if(!this.ValidaCaracter(valor2))
                {
                    $('.newCampo2P').css('border-color', 'red');
                    app.alert.show('Tname_participante_error', {
                        level: 'error',
                        autoClose: true,
                        messages: 'Formato de apellido paterno incorrecto'
                    });
                    faltantes++;
                }
            }

            // Apellido Materno
            if ((valor3 != '' || valor3.trim()!='') ) {
                if(!this.ValidaCaracter(valor3))
                {
                    $('.newCampo3P').css('border-color', 'red');
                    app.alert.show('Tname_participante_error', {
                        level: 'error',
                        autoClose: true,
                        messages: 'Formato de apellido materno incorrecto'
                    });
                    faltantes++;
                }
            }

            //Correo
            if (valor4 == '') {
                $('.newCampo4P').css('border-color', 'red');
                campos = campos + '<b>' + $('.newCampo4P')[0].placeholder + '</b><br>';
                faltantes++
            }

            //Tipo de contacto
            if (valor6 == '' || valor6 == 'Tipo de Contacto') {
                $('.newCampo6P').css('border-color', 'red');
                campos = campos + '<b>Tipo de Contacto</b><br>';
                faltantes++
            }

            // valida telefono
            if (valor5 != "") {
                if (!this.validaTamano(valor5)) {
                    $('.newCampo5P').css('border-color', 'red');
                    faltantes++;
                    app.alert.show('phone_participante_error', {
                        level: 'error',
                        autoClose: true,
                        messages: 'Formato de tel\u00E9fono incorrecto'
                    });
                }
            }

            // valida la máscara del correo
            if (valor4 != "") {
                if (!this.validaMail(valor4)) {
                    $('.newCampo4P').css('border-color', 'red');
                    faltantes++;
                    app.alert.show('mail_participante_error', {
                        level: 'error',
                        autoClose: true,
                        messages: 'Formato de correo incorrecto'
                    });
                }
            }

            // Valida si existen duplicados
            if (faltantes == 0) {
              if (this.mParticipantes.participantes.length >= 0) {
                var duplicados = false;
                Object.keys(this.mParticipantes.participantes).forEach(function(key) {
                  if(this.mParticipantes.participantes[key].nombres.toUpperCase() == valor1.toUpperCase() && this.mParticipantes.participantes[key].apaterno.toUpperCase() == valor2.toUpperCase() && this.mParticipantes.participantes[key].amaterno.toUpperCase() == valor3.toUpperCase()) {
                    duplicados = true;
                  }
                }, this);
                if(duplicados){
                  $(".newCampo1P").val("");
                  $(".newCampo2P").val("");
                  $(".newCampo3P").val("");
                  app.alert.show('participante_duplicado', {
                    level: 'error',
                    autoClose: true,
                    title: "No se puede agregar al participante. <br> Esta persona ya ha sido registrada."
                  });
                }
              }
              if(!duplicados)
              {
                $('.addParticipante').bind('click', false);
                App.alert.show('loadingParticipante', {
                    level: 'process',
                    title: 'Cargando, por favor espere.',
                });
                  var original_name = $(".newCampo1P").val() + $(".newCampo2P").val() + $(".newCampo3P").val();
                  var list_check = app.lang.getAppListStrings('validacion_duplicados_list');
                  var simbolos = app.lang.getAppListStrings('validacion_simbolos_list');
                  //Define arreglos para guardar nombre de cuenta
                  var clean_name_split = [];
                  var clean_name_split_full = [];
                  clean_name_split = original_name.split(" ");
                  //Elimina simbolos: Ej. . , -
                  _.each(clean_name_split, function (value, key) {
                      _.each(simbolos, function (simbolo, index) {
                          var clean_value = value.split(simbolo).join('');
                          if (clean_value != value) {
                              clean_name_split[key] = clean_value;
                          }
                      });
                  });
                  clean_name_split_full = App.utils.deepCopy(clean_name_split);

                  if (this.model.get('tipodepersona_c')=="Persona Moral") {
                      //Elimina tipos de sociedad: Ej. SA, de , CV...
                      var totalVacio = 0;
                      _.each(clean_name_split, function (value, key) {
                          _.each(list_check, function (index, nomenclatura) {
                              var upper_value = value.toUpperCase();
                              if (upper_value == nomenclatura) {
                                  var clean_value = upper_value.replace(nomenclatura, "");
                                  clean_name_split[key] = clean_value;
                              }
                          });
                      });
                      //Genera clean_name con arreglo limpio
                      var clean_name = "";
                      _.each(clean_name_split, function (value, key) {
                          clean_name += value;
                          //Cuenta elementos vacíos
                          if (value == "") {
                              totalVacio++;
                          }
                      });

                      //Valida que exista más de un elemento, caso cotrarioe establece para clean_name valores con tipo de sociedad
                      if ((clean_name_split.length - totalVacio) <= 1) {
                          clean_name = "";
                          _.each(clean_name_split_full, function (value, key) {
                              clean_name += value;
                          });
                      }
                      clean_name = clean_name.toUpperCase();
                      item.clean_name= clean_name;
                  }else{
                      original_name = original_name.replace(/\s+/gi,'');
                      original_name= original_name.toUpperCase();
                      item.clean_name= original_name;
                  }

                  var fields = ["primernombre_c", "segundonombre_c", "apellidopaterno_c", "apellidomaterno_c", "tipo_registro_cuenta_c"];
                app.api.call("read", app.api.buildURL("Accounts/", null, null, {
                  fields: fields.join(','),
                  max_num: 5,
                  "filter": [
                    {
                      "clean_name": item.clean_name
                    }
                  ]
                  }), null, {
                  success: _.bind(function (data) {
                    if(data.records.length > 0) {
                      app.alert.show("DuplicateCheck", {
                        level: "error",
                        title: "La persona ingresada ya existe.",
                        autoClose: false
                      });
                      $(".newCampo1P").val("");
                      $(".newCampo2P").val("");
                      $(".newCampo3P").val("");
                    }
                    else {
                      this.mParticipantes.participantes.push(item);
                      this.render();
                    }
                    $('.addParticipante').unbind('click', false);
                    App.alert.dismiss('loadingParticipante');
                  }, this)
                });
              }
            }
            else
            {
              if(campos)
              {
                app.alert.show('campos_requeridos', {
                  level: 'error',
                  autoClose: false,
                  messages: "Hace falta completar la siguiente información en los <b>Participantes:</b><br>" + campos
                });
              }
            }
    },

    addParticipantesFunction: function (options) {
            //Estableciendo el color de borde original en cada campo
            $('.newCampo7P').css('border-color', '');
            $('.busca-participante').find('.select2-choice').css('border-color','');

            //Obteniendo valores de los campos
            var valor7 = $('.newCampo7P')[0].value;
            var idParti = $('input.busca-participante').val();

            //Valida campos requeridos
            var campos = "";
            var faltantes = 0;
            //Nombre
            if(idParti == '') {
              $('.busca-participante').find('.select2-choice').css('border-color','red');
              campos = campos + '<b>Participante</b><br>';
              faltantes++;
            }

            //Tipo de contacto
            if(valor7 == '' || valor7 == 'Tipo de Contacto') {
              $('.newCampo7P').css('border-color', 'red');
              campos = campos + '<b>Tipo de Contacto</b><br>';
              faltantes++
            }

            // Valida si existen duplicados
            if(faltantes == 0) {
              if (this.mParticipantes.participantes.length >= 0) {
                var duplicados = false;
                Object.keys(this.mParticipantes.participantes).forEach(function(key) {
                  var concatena = this.mParticipantes.participantes[key].nombres + " " + this.mParticipantes.participantes[key].apaterno + " " + this.mParticipantes.participantes[key].amaterno;
                  if(concatena.toUpperCase() == $('.busca-participante')[0].innerText.toUpperCase()) {
                    duplicados = true;
                  }
                }, this);
                if(duplicados){
                  $('.busca-participante').select2("data", "");
                  app.alert.show('participante_duplicado', {
                    level: 'error',
                    autoClose: true,
                    title: "No se puede agregar al participante. <br> Esta persona ya ha sido registrada."
                  });
                }
              }
              if(!duplicados)
              {
                App.alert.show('loadingParticipantes', {
                    level: 'process',
                    title: 'Cargando, por favor espere.',
                });
                $('.addParticipantes').bind('click', false);
                // Obtiene datos del participante seleccionado
                var fields = ["id", "primernombre_c", "segundonombre_c", "apellidopaterno_c", "apellidomaterno_c", "email1", "phone_office", "tipo_registro_cuenta_c"];
                app.api.call("read", app.api.buildURL("Accounts/", null, null, {
                  fields: fields.join(','),
                  max_num: 5,
                  "filter": [
                    {
                      "id": idParti,
                      "tipodepersona_c": {
                        "$not_equals" : "Persona Moral",
                      }
                    }
                  ]
                  }), null, {
                  success: _.bind(function (data) {
                    if(data.records.length > 0) {
                      var valor1 = data.records[0].primernombre_c;
                      var valor2 = data.records[0].apellidopaterno_c;
                      var valor3 = data.records[0].apellidomaterno_c;
                      var valor4 = data.records[0].email1;
                      var valor5 = data.records[0].phone_office;
                      var item = {
                          "id": idParti,
                          "nombres": valor1,
                          "apaterno": valor2,
                          "amaterno": valor3,
                          "telefono": valor5,
                          "correo": valor4,
                          "origen": "E",
                          "unifin": 0,
                          "tipo_contacto": valor7,
                          "asistencia": 1,
                          "activo" : "1"
                      };
                      this.mParticipantes.participantes.push(item);
                      this.render();
                    }
                    else
                    {
                      app.alert.show("PersonaCheck", {
                        level: "error",
                        title: "Participantes del Régimen Fiscal Persona Moral NO pueden ser agregados.",
                        autoClose: false
                      });
                      $('.busca-participante').select2("data", "");
                    }
                    $('.addParticipantes').unbind('click', false);
                    App.alert.dismiss('loadingParticipantes');
                  }, this)
                });
              }
            }
            else
            {
              if(campos)
              {
                app.alert.show('campos_requeridos', {
                  level: 'error',
                  autoClose: false,
                  messages: "Hace falta completar la siguiente información en los <b>Participantes:</b><br>" + campos
                });
              }
            }
    },

    // /**
    //  * Binds DOM changes to set field value on model.
    //  * @param {Backbone.Model} model model this field is bound to.
    //  * @param {String} fieldName field name.
    //  */
    // bindDomChange: function () {
    //     if (this.tplName === 'list-edit') {
    //         this._super("bindDomChange");
    //     }
    // },

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

    estableceParticipantes:function(fields, errors, callback) {
        this.model.set('minuta_participantes', selfData.mParticipantes);
        callback(null, fields, errors);
    },

   /* F. Javier G. Solar 13/11/2018
   OBS70
    Se debe validar que el teléfono ingresado no tenga los mismos números
    Valida que se ingrese solo numero
    VAlida que su tamaño sea entre 8 y 10
    */
    validaTamano: function (ValTel) {
        var telefonoTam = ValTel.length;
        var banderTelefono = false;
        var expreg = /^[0-9]{8,13}$/;
        if (telefonoTam >= 8 && telefonoTam <= 13) {
            if (expreg.test(ValTel)) {
                var cont = 0;
                for (var j = 0; j < telefonoTam; j++) {
                    if (ValTel.charAt(0) == ValTel.charAt(j)) {
                        cont++;
                    }
                }
                if (cont != telefonoTam) {
                    banderTelefono = true;
                }
            }
        }
        else {
            /*   app.alert.show("N\u00FAmero incorrecto", {
               level: "error",
               title: "Formato invalido",
               autoClose: true
               });*/
        }
        return banderTelefono;
    },

    ValidaCaracter: function(texto) {
        var valido = false;
        if (texto!="" && texto!=undefined) {
            var letter = /^[a-zA-ZÀ-ÿ\s]*$/g;
            if (texto.match(letter)) {
                valido = true;
            }
        }
            return valido;
    },

    validaMail:function(correo1) {
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        //var emailPattern = /^\S+@\S+\.\S+[$%&|<>#]?$/;
        var banderCorreo=false;
        if ( emailPattern.test(correo1) ) {
            banderCorreo=true;
        }
        return banderCorreo;
    },
})
