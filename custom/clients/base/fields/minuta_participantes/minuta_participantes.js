/*
 *  AF - 2018-10-23
 *  CustomField - Grid
 */
({
    events: {
        'click  .addParticipante': 'addParticipanteFunction',
        'click  .addParticipantes': 'addParticipantesFunction',
        'keydown .newCampo1P': 'checkText',
        'keydown .newCampo2P': 'checkText',
        'keydown .newCampo3P': 'checkText',
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
          var correo = row.context.value; //$('.campo2P').eq(row.index()).val();
          if(correo == "") {
              $('.campo2SelectP').eq(row.index()).find('input').css('border-color', 'red');
                app.alert.show('email_telefono_error', {
                level: 'error',
                autoClose: true,
                messages: 'Favor de agregar un <b>Correo</b>'
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
              }
              else {
                selfData.mParticipantes.participantes[row.index()].correo = correo;
              }
          }
          selfData.mParticipantes.participantes[row.index()].correo = correo;
        });
        $('.campo3P').change(function(evt) {
          var row = $(this).closest("tr");
          var telefono = row.context.value; //$('.campo3P').eq(row.index()).val();
          if (!selfData.validaTamano(telefono) && telefono) {
            $('.campo3SelectP').eq(row.index()).find('input').css('border-color', 'red');
            app.alert.show('phone_participante_error', {
                level: 'error',
                autoClose: true,
                messages: 'Formato de tel\u00E9fono incorrecto'
            });
          }
          else {
            $('.campo3SelectP').eq(row.index()).find('input').css('border-color', '');
            selfData.mParticipantes.participantes[row.index()].telefono = telefono;
          }
        });
    },

    //No aceptar numeros, solo letras (a-z), puntos(.) y comas(,)
    checkText: function (evt) {
         if ($.inArray(evt.keyCode, [9, 16, 17, 110, 190, 45, 33, 36, 46, 35, 34, 8, 9, 20, 16, 17, 37, 40, 39, 38, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 16, 32, 192]) < 0) {
            if (evt.keyCode != 186) {
                app.alert.show("Caracter Invalido", {
                    level: "error",
                    title: "Solo texto es permitido en este campo.",
                    autoClose: true
                });
                return false;
            }
        }
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
                "activo" : "1"
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
                var fields = ["primernombre_c", "segundonombre_c", "apellidopaterno_c", "apellidomaterno_c", "tipo_registro_c"];
                app.api.call("read", app.api.buildURL("Accounts/", null, null, {
                  fields: fields.join(','),
                  max_num: 5,
                  "filter": [
                    {
                      "primernombre_c": valor1,
                      "apellidopaterno_c": valor2,
                      "apellidomaterno_c": valor3,
                      "tipo_registro_c": "Persona",
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
                var fields = ["id", "primernombre_c", "segundonombre_c", "apellidopaterno_c", "apellidomaterno_c", "email1", "phone_office", "tipo_registro_c"];
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

    ValidaCaracter: function(texto)
    {
        var valido=false;
        var letter = /^[a-zA-Z\s]+$/;
        if(texto.match(letter)) 
        {
          valido = true;
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
