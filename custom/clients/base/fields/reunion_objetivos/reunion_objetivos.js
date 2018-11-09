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
        this.model.addValidationTask('validaobjetivosave', _.bind(this.validaobjetivos, this));

        //Carga datos
        this.model.on('sync', this.loadData, this);
        //Data real
        this.myobject={};
        this.myobject.records=[];
        //Data eliminada
        this.myDeletedObj={};
        this.myDeletedObj.records=[];
        //Data original
        this.myOriginal={};
        this.myOriginal.records=[];

        //Array para mantener indices eliminados
        this.myIndexDeleted=[];
    },


    loadData: function (options) {

       var selfvalue = this;

        if (this.model.get("id") != "") {
            app.api.call('GET', app.api.buildURL('Meetings/' + this.model.get("id") + '/link/meetings_minut_objetivos_1?order_by=date_entered:asc'), null, {
                success: function (data) {
                    //Reiniciando arreglos de registros eliminados
                    selfvalue.myDeletedObj={};
                    selfvalue.myDeletedObj.records=[];
                    selfvalue.myIndexDeleted=[];

                    selfvalue.myobject = data;
                    selfvalue.myOriginal = data;
                    _.extend(this, selfvalue.myobject);
                    _.extend(this, selfvalue.myOriginal);
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
           if (self.myobject.records[row.index()].id) {
             //Agrega a myDeletedObj
             self.myobject.records[row.index()].deleted = 1;
             self.myDeletedObj.records.push(self.myobject.records[row.index()]);
           }

           self.myIndexDeleted.push(row.index());
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

        if($('.newCampo1').val() == '' || $('.newCampo1').val() == null || $('.newCampo1').val().trim()==''){
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
      "name":valor1,"cumplimiento":"", "description":1
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
        myObjetivos={};
        myObjetivos.records=[];

        //Itera myobject
        Object.keys(self.myobject.records).forEach(function(key) {
            myObjetivos.records.push(self.myobject.records[key]);
        });

        //Itera myDeletedObj
        Object.keys(self.myDeletedObj.records).forEach(function(key) {
            myObjetivos.records.push(self.myDeletedObj.records[key]);
        });

        this.model.set('reunion_objetivos', myObjetivos);
        // if (this.model.get('reunion_objetivos') == "" || this.model.get('reunion_objetivos') == null || this.model.get('reunion_objetivos').records.length==0) {
        //     errors['reunion_objetivos'] = "Al menos un objetivo es requerido.";
        //     errors['reunion_objetivos'].required = true;
        // }
        callback(null, fields, errors);
    },

    //Adrian Arauz
    //Validacion para que los objetivos añadidos no estén vacíos a la hora de crear la reunion.
    validaobjetivos: function (fields, errors, callback) {
        var cont=0;
        $('.objetivoSelect').find('.span10').each(function () {

            if ($(this).val()=="") {

                $(this).css('border-color', 'red');
                errors[$(this)] = errors['<b>Favor de no añadir Objetivo(s) vac\u00EDos</b>'] || {};
                errors[$(this)].required = true;
            }

        });
        callback(null, fields, errors);
    },


})
