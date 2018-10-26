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
     // this.model.set('minuta_compromisos',[{"compromiso":"1","id_resp":"716822f6-f2f9-3053-e052-5626c99305ac","responsable":"Carmen Velasco","fecha":"2018-10-24"},{"compromiso":"2","id_resp":"bafb1018-7a44-11e8-bb52-00155d967407","responsable":"Adrian","fecha":"2018-10-30"}]);
      //myData = $.parseJSON( '{"myData":{"records":'+JSON.stringify(this.model.get('minuta_compromisos'))+'}}');


        app.api.call('GET', app.api.buildURL('minut_Minutas/'+this.model.get('id')+'/link/minut_minutas_minut_compromisos'), null, {
            success: function (data) {
                self.myData = $.parseJSON( '{"myData":{"records":'+JSON.stringify(data.records)+'}}');
                _.extend(self, self.myData);
                self.render();
                console.log("myData seteado");
            },
            error: function (e) {
                console.log(e);
            }
        });

        arr_responsables={"arr_responsables": {"responsables":[{"id_resp2":"39b44c75-fbff-aa7e-d246-5629671efaa2",
                                            "responsable2":"Sonia Sanchez"},
                                                            {"id_resp2":"bafb1018-7a44-11e8-bb52-00155d967407",
                                                  "responsable2":"Adrian"}
                                                            ]
                                            }
                        };

      //_.extend(this, myData);
      _.extend(this, arr_responsables);
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
        "compromiso":valor1,"id_resp":valor2, "responsable":valor3, "fecha":valor4
      };

      this.myData.records.push(item);
      this.model.set('minuta_compromisos',this.myData.records);
      //this.model.save();
      this.render();
    },

    _render: function () {
        this._super("_render");

        $('.removecompromiso').click(function(evt) {
            var row = $(this).closest(".compromisos");    // Find the row
            self.myData.records.splice(row.index(),1);
            self.render();
        });

        $('.existingresponsable').change(function(evt) {
            var row = $(this).closest(".compromisos");    // Find the row
            var val= row.find(".existingresponsable").context.value;
            var text = row.find(".existingresponsable option[value="+val+"]").text();
            self.myData.records[row.index()].responsable = text;
            self.myData.records[row.index()].id_resp = val;
            self.render();
        });

        $('.existingcompromiso').change(function(evt) {
            var row = $(this).closest(".compromisos");    // Find the row
            var val= row.find(".existingcompromiso").context.value;
            self.myData.records[row.index()].compromiso = val;
            self.render();
        });

        $('.existingdate').change(function(evt) {
            var row = $(this).closest(".compromisos");    // Find the row
            var val= row.find(".existingdate").context.value;
            self.myData.records[row.index()].fecha = val;
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
