/*
 *  AF - 2018-10-23
 *  CustomField - Grid
 */
({
    events: {
        'click  .addParticipante': 'addParticipanteFunction',
        'keydown .newCampo5P': 'keyDownNewPhone',
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
                  if(modelo.get('parent_meeting_c')!="" && modelo.get('parent_meeting_c')!="undefine"){
                      idReunion = modelo.get('parent_meeting_c');
                  }

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
        //self = this;
        this._super("_render");
        //self.mParticipantes = self.model.set('minuta_participantes',mParticipantes);
        $('.updateAsistencia').click(function(evt) {
          var row = $(this).closest("tr");    // Find the row
          if (selfData.mParticipantes.participantes[row.index()].asistencia == 1) {
              selfData.mParticipantes.participantes[row.index()].asistencia = 0;
          }else{
              selfData.mParticipantes.participantes[row.index()].asistencia = 1;
          }
          selfData.render();
        });
    },

    /*
        Función para agregar nuevos elementos al objeto
    */
    addParticipanteFunction: function (options) {
        //Estableciendo el color de borde original en cada campo
        $('.newCampo1P').css('border-color', '');
        $('.newCampo2P').css('border-color', '');
        $('.newCampo4P').css('border-color', '');
        $('.newCampo5P').css('border-color', '');
        $('.newCampo6P').css('border-color', '');

        //Obteniendo valores de los campos
        var valor1 = $('.newCampo1P')[0].value;
        var valor2 = $('.newCampo2P')[0].value;
        var valor3 = $('.newCampo3P')[0].value;
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
            "asistencia": 1
        };

        //Valida campos requeridos
        var faltantes = 0;
        //Nombres
        if (valor1 == '') {
            $('.newCampo1P').css('border-color', 'red');
            faltantes++;
        }
        //Apellido Paterno
        if (valor2 == '') {
            $('.newCampo2P').css('border-color', 'red');
            faltantes++
        }
        //Correo o Teléfono
        if (valor4 == '' && valor5 == '') {
            $('.newCampo4P').css('border-color', 'red');
            $('.newCampo5P').css('border-color', 'red');
            app.alert.show('email_telefono_error', {
                level: 'error',
                autoClose: true,
                messages: 'Favor de agregar un <b>Tel\u00E9fono</b> o un <b>Correo</b>'

            });
            faltantes++
        }
        //Tipo de contacto
        if (valor6 == '' || valor6 == 'Tipo de Contacto') {
            $('.newCampo6P').css('border-color', 'red');
            app.alert.show('tipo_contacto_error', {
                level: 'error',
                autoClose: true,
                messages: 'Favor de seleccionar un <b>Tipo de Contacto</b>'

            });
            faltantes++
        }

        if (valor5 != "") {
            if (!this.validaTamano()) {
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
            if (!this.validaMail()) {
                $('.newCampo4P').css('border-color', 'red');
                faltantes++;
                app.alert.show('mail_participante_error', {
                    level: 'error',
                    autoClose: true,
                    messages: 'Formato de correo incorrecto'

                });
            }
        }

        if (faltantes == 0) {
            this.mParticipantes.participantes.push(item);
            this.render();
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

    keyDownNewPhone: function (evt) {
        if (!evt) return;
        if(!this.checkNumOnly(evt)){
            return false;
        }

    },
    checkNumOnly:function(evt){
        if($.inArray(evt.keyCode,[110,188,190,45,33,36,46,35,34,8,9,20,16,17,37,40,39,38,16,49,50,51,52,53,54,55,56,57,48,96,97,98,99,100,101,102,103,104,105]) < 0) {
            app.alert.show("Caracter Invalido", {
                level: "error",
                title: "Solo n\u00FAmeros son permitidos en este campo.",
                autoClose: true
            });
            return false;
        }else{
            return true;
        }
    },
    validaTamano: function() {
        var telefonoTam=$('.newCampo5P').val().length;
        var banderTelefono=false;
        if(telefonoTam>=8 && telefonoTam<=10)
        {
            //$('.newCampo5P').css('border-color', '')
            banderTelefono=true;
        }
        else {
            /* app.alert.show("N\u00FAmero incorrecto", {
             level: "error",
             title: "El n\u00FAmero es incorrecto",
             autoClose: true
             });*/

        }
        return banderTelefono;
    },

    validaMail:function() {
        var correo1=$('.newCampo4P').val();
        //var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        var emailPattern = /^\S+@\S+\.\S+[$%&|<>#]?$/;
        var banderCorreo=false;

        if ( emailPattern.test(correo1) ) {
            banderCorreo=true;
        }
        return banderCorreo;
    },


})
