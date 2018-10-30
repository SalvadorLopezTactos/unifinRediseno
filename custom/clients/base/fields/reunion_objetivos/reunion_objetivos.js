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
        this.model.on('sync', this.loadData, this);
        this.myobject={};
        this.myobject.records=[];
    },


    loadData: function (options) {

       var selfvalue = this;

        if (this.model.get("id") != "") {
            app.api.call('GET', app.api.buildURL('Meetings/' + this.model.get("id") + '/link/meetings_minut_objetivos_1'), null, {
                success: function (data) {
                    selfvalue.myobject = data;
                    _.extend(this, selfvalue.myobject);
                    selfvalue.render();
                },
                error: function (e) {
                    throw e;
                }
            });
        }
      },


    _render: function () {
        this._super("_render");

        $('.updateRecord').click(function(evt) {
          var row = $(this).closest("tr");    // Find the row
          if (self.myobject.records[row.index()].cumplimiento != '') {
              self.myobject.records[row.index()].cumplimiento = '';
          }else{
              self.myobject.records[row.index()].cumplimiento = '1';
          }
          self.render();
        });

        $('.deleteRecord').click(function(evt) {
           var row = $(this).closest("tr");    // Find the row
           //self.myData.records[row.index()].deleted = 1;
           self.myobject.records.splice(row.index(),1);
           self.render();
       });

       $('.objetivoSelect').change(function(evt) {
          var row = $(this).closest("tr");    // Find the row
          var text = row.find(".objetivoSelect").context.value;
          self.myobject.records[row.index()].name = text;
          self.render();
      });

    },

    /*
        Función para agregar nuevos elementos al objeto
    */
    addRecordFunction: function (evt) {
        if (!evt) return;

        var errorMsg = '';
        var dirErrorCounter = 0;
        var dirError = false;

        if($('.newCampo1').val() == '' || $('.newCampo1').val() == null){
            $('.newCampo1').css('border-color', 'red');
            errorMsg = 'Favor de agregar un objetivo.';
            dirError = true; dirErrorCounter++;

            if (dirError) {
                if (dirErrorCounter > 1) errorMsg = ''
                app.alert.show('Error al agregar objetivo', {
                    level: 'error',
                    autoClose: true,
                    messages: errorMsg

                });
                return;
            }
        }else{
      var valor1 = $('.newCampo1')[0].value;
      var item = {
      "name":valor1,"cumplimiento":""
      };

      this.myobject.records.push(item);
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

    almacenaobjetivos:function(fields, errors, callback) {
        this.model.set('reunion_objetivos', self.myobject);
        if (this.model.get('reunion_objetivos') == "" || this.model.get('reunion_objetivos') == null || this.model.get('reunion_objetivos').records.length==0) {
            errors['reunion_objetivos'] = "Al menos un objetivo es requerido.";
            errors['reunion_objetivos'].required = true;
        }
        callback(null, fields, errors);
    },

})
