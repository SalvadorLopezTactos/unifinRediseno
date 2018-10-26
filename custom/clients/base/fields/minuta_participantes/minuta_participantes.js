/*
 *  AF - 2018-10-23
 *  CustomField - Grid
 */
({
    events: {
        'click  .addParticipante': 'addParticipanteFunction',
    },

    mParticipantes : [],
    /**
     * @inheritdoc
     * @param options
     */
    initialize: function (options) {
        //Inicializa campo custom
        self = this;
        this._super('initialize', [options]);

        //Carga datos
        this.loadData();
    },


    loadData: function (options) {
      //Recupera data existente
      mParticipantes = $.parseJSON( '{"idReunion":"bfa7bec6-d738-11e8-b1d9-a0b3cc24d95e","idCuenta":"43022956-4bb1-0e14-6a7e-58864d4069d4","participantes":[{"id":"aebe503b-c10c-9960-0f16-5626cdfba70a","nombres":"José Alfredo García Cruz","apaterno":"José Alfredo García Cruz","amaterno":"José Alfredo García Cruz","telefono":"5552495800","correo":"ggonzalez@unifin.com.mx","origen":"U","unifin":1,"tipo_contacto":"","asistencia":0},{"id":"c57e811e-b81a-cde4-d6b4-5626c9961772","nombres":"Wendy Amairini Reyes Peralta","apaterno":"Wendy Amairini Reyes Peralta","amaterno":"Wendy Amairini Reyes Peralta","telefono":"","correo":"ggonzalez@unifin.com.mx","origen":"U","unifin":1,"tipo_contacto":"","asistencia":0},{"id":"cf3b6b9f-db1a-bde7-4600-5925cedcacb5","nombres":"ALEJANDRO PEREZ VAZQUEZ","apaterno":"Wendy Amairini Reyes Peralta","amaterno":"Wendy Amairini Reyes Peralta","telefono":"","correo":"ggonzalez@unifin.com.mx","origen":"C","unifin":0,"tipo_contacto":"","asistencia":0}],"compromisos":[]}');
      //_.extend(this, mParticipantes);
      this.model.set('minuta_participantes',mParticipantes);
      this.render();
    },

    _render: function () {
        //self = this;
        this._super("_render");
        self.mParticipantes = self.model.set('minuta_participantes',mParticipantes);
        $('.updateAsistencia').click(function(evt) {
          var row = $(this).closest("tr");    // Find the row
          if (self.mParticipantes.participantes[row.index()].asistencia == 1) {
              self.mParticipantes.participantes[row.index()].asistencia = 0;
          }else{
              self.mParticipantes.participantes[row.index()].asistencia = 1;
          }
          self.render();
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

      this.mParticipantes.participantes.push(item);
      this.render();
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


})
