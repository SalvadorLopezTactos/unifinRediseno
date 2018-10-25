/*
 *  AF - 2018-10-23
 *  CustomField - Grid
 */
({
    events: {
        'click  .addcompromiso': 'addRecordFunction',
    },

    initialize: function (options) {
        //Inicializa campo custom
        self = this;
        this._super('initialize', [options]);
        Handlebars.registerHelper('if_eq', function(a, b, opts) {
          if (a == b) {
              return opts.fn(this);
          } else {
              return opts.inverse(this);
          }
        });
        //Carga datos
        this.loadData();
    },


    loadData: function (options) {
      //Recupera data existente
      //myData = $.parseJSON( '{"myData":{"records":[{"compromiso":"1","id_resp":"82ec8bcc-cdb3-b56e-a472-573a06966424","responsable":"Carmen Velasco","fecha":"2018-10-24","deleted":0},{"compromiso":"2","id_resp":"bafb1018-7a44-11e8-bb52-00155d967407","responsable":"Adrian","fecha":"2018-10-30","deleted":0}]}}');
      this.model.set('minuta_compromisos',[{"compromiso":"1","id_resp":"82ec8bcc-cdb3-b56e-a472-573a06966424","responsable":"Carmen Velasco","fecha":"2018-10-24","deleted":0},{"compromiso":"2","id_resp":"bafb1018-7a44-11e8-bb52-00155d967407","responsable":"Adrian","fecha":"2018-10-30","deleted":0}]);
      myData = $.parseJSON( '{"myData":{"records":'+JSON.stringify(this.model.get('minuta_compromisos'))+'}}');
      _.extend(this, myData);
      this.render();
    },

    /*
        Función para agregar nuevos elementos al objeto
    */
    addRecordFunction: function (options) {
      var valor1 = $('.newcompromiso')[0].value;
      var valor2 = $('.newresponsable')[0].value;
      var valor3 = $(".newresponsable option:selected").text();
      var valor4 = $('.newdate')[0].value;


      var item = {
        "compromiso":valor1,"id_resp":valor2, "responsable":valor3, "fecha":valor4, "id":"", "deleted":0
      };

      this.myData.records.push(item);
      this.model.set('minuta_compromisos',this.myData.records);
      this.model.save();
      this.render();
    },

    _render: function () {
        this._super("_render");

        $('.removecompromiso').click(function(evt) {
            var row = $(this).closest(".compromisos");    // Find the row
            self.myData.records[row.index()].deleted = 1;
            self.render();
        });
    },

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
