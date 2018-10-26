/*
 *  AF - 2018-10-23
 *  CustomField - Grid
 */
({
    events: {
        'click  .addRecord': 'addRecordFunction',
    },

    /**
     * @inheritdoc
     * @param options
     */
    initialize: function (options) {
        //Inicializa campo custom
        self = this;
        this._super('initialize', [options]);

        this.model.addValidationTask('Guardarobjetivos', _.bind(this.almacenaobjetivos, this));

        //Carga datos
        this.loadData();
    },


    loadData: function (options) {
      //Recupera data existente
      //myData = $.parseJSON('{"myData":{"records":[{"objetivo":"Objetivo 1","cumplimiento":""},{"objetivo":"Objetivo 2","cumplimiento":""},{"objetivo":"Objetivo 3","cumplimiento":""}]}}');
        myData = "";


        app.api.call('GET', app.api.buildURL('Meetings/2ba66d5c-d716-11e8-8ece-a0481cdf89eb/link/meetings_minut_objetivos_1'), null, {
            success: function (data) {
                self.myData= data;
                _.extend(this, myData);
            },
            error: function (e) {
                throw e;
            }
        });
        this.render();

      },


    _render: function () {
        this._super("_render");

        $('.updateRecord').click(function(evt) {
          var row = $(this).closest("tr");    // Find the row
          if (self.myData.records[row.index()].cumplimiento != '') {
              self.myData.records[row.index()].cumplimiento = '';
          }else{
              self.myData.records[row.index()].cumplimiento = '1';
          }
          self.render();
        });

        $('.deleteRecord').click(function(evt) {
           var row = $(this).closest("tr");    // Find the row
           //self.myData.records[row.index()].deleted = 1;
           self.myData.records.splice(row.index(),1);
           self.render();
       });

       $('.objetivoSelect').change(function(evt) {
          var row = $(this).closest("tr");    // Find the row
          var text = row.find(".objetivoSelect").context.value;
          self.myData.records[row.index()].name = text;
          self.render();
      });

    },

    /*
        Función para agregar nuevos elementos al objeto
    */
    addRecordFunction: function (options) {
      var valor1 = $('.newCampo1')[0].value;

      var item = {
        "name":valor1,"cumplimiento":""
      };

      this.myData.records.push(item);
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

    almacenaobjetivos:function(fields, errors, callback) {
        this.model.set('reunion_objetivos', self.myData);
        if (this.model.get('reunion_objetivos') == "" || this.model.get('reunion_objetivos') == null) {
            errors['reunion_objetivos'] = "Almenos un objetivo es requerido.";
            errors['reunion_objetivos'].required = true;
        }
        callback(null, fields, errors);
    },

})
