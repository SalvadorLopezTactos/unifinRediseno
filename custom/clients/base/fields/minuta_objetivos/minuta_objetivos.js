/*
 *  AF - 2018-10-23
 *  CustomField - Grid
 */
({
    /**
     * @inheritdoc
     * @param options
     */
    initialize: function (options) {
        //Inicializa campo custom
        self = this;
        this._super('initialize', [options]);
        this.model.addValidationTask('ObtenerObjetivos', _.bind(this.almacenaobjetivos, this));
        //Carga datos
        this.model.on('sync', this.loadData, this);
        this.myobjmin={};
        this.myobjmin.records=[];
    },


    loadData: function (options) {
        myobjmin = "";
        var selfvalue= this;
        if (this.model.get("minut_minutas_meetingsmeetings_idb") != "")  {
        app.api.call('GET', app.api.buildURL('Meetings/' + this.model.get("minut_minutas_meetingsmeetings_idb") + '/link/meetings_minut_objetivos_1'), null, {
            success: function (data) {
                selfvalue.myobjmin= data;
                _.extend(this, selfvalue.myobjmin);
                selfvalue.render();
            },
            error: function (e) {
                throw e;
            }
        });
    }


    },



    _render: function () {
        self = this;
        this._super("_render");

        $('.updateRecord').click(function(evt) {
          var row = $(this).closest("tr");    // Find the row
          if (self.myobjmin.records[row.index()].cumplimiento != '') {
              self.myobjmin.records[row.index()].cumplimiento = '';
          }else{
              self.myobjmin.records[row.index()].cumplimiento = '1';
          }
          self.render();
        });

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
        this.model.set('minuta_objetivos', self.myobjmin);


        callback(null, fields, errors);
    },


})
