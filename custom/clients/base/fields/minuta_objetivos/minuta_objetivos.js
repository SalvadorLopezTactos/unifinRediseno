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

        //Carga datos
        this.loadData();
    },


    loadData: function (options) {
      //Recupera data existente
      //myData = $.parseJSON('{"myData":{"records":[{"objetivo":"Objetivo 1","cumplimiento":""},{"objetivo":"Objetivo 2","cumplimiento":""},{"objetivo":"Objetivo 3","cumplimiento":""}]}}');
      mObjetivos     =  $.parseJSON('{"records":[{"objetivo":"Objetivo 1","cumplimiento":""},{"objetivo":"Objetivo 2","cumplimiento":""},{"objetivo":"Objetivo 3","cumplimiento":""}]}');
      _.extend(this, mObjetivos);
      this.render();
    },


    _render: function () {
        self = this;
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
