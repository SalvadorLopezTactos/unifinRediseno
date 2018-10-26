/*
 *  AF - 2018-10-23
 *  CustomField - Grid
 */
({
    events: {
        'click  .addParticipante': 'addParticipanteFunction',
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
        idReunion = this.model.get('minut_minutas_meetingsmeetings_idb');
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
      }else if(this.context.parent){
        //Recupera datos para vista de creación
        idReunion = this.context.parent.attributes.modelId;
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
      var valor1 = $('.newCampo1P')[0].value;
      var valor2 = $('.newCampo2P')[0].value;
      var valor3 = $('.newCampo3P')[0].value;
      var valor4 = $('.newCampo4P')[0].value;
      var valor5 = $('.newCampo5P')[0].value;
      var valor6 = $('.newCampo6P')[0].value;

      var item = {
        "id":"",
        "nombres":valor1,
        "apaterno":valor2,
        "amaterno":valor3,
        "telefono":valor5,
        "correo":valor4,
        "origen": "N",
        "unifin": 0,
        "tipo_contacto":valor6,
        "asistencia": 1
      };

      //Valida campos requeridos
      var faltantes = 0;
      //Nombres
      if (valor1=='') {
        $('.newCampo1P').css('border-color', 'red');
        faltantes++;
      }
      //Apellido Paterno
      if (valor2=='') {
        $('.newCampo2P').css('border-color', 'red');
        faltantes++
      }
      //Correo o Teléfono
      if (valor4=='' && valor5=='') {
        $('.newCampo4P').css('border-color', 'red');
        $('.newCampo5P').css('border-color', 'red');
        faltantes++
      }
      //Tipo de contacto
      if (valor6=='' || valor6 =='Tipo de Contacto') {
        $('.newCampo6P').css('border-color', 'red');
        faltantes++
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


})
