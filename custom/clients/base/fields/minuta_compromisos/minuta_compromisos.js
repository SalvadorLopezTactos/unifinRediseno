/*
 *  AF - 2018-10-23
 *  CustomField - Grid
 */
({
    events: {
        'click  .addcompromiso': 'addRecordFunction',
        'blur   .newcompromiso': 'loadparticipantes',
    },

    initialize: function (options) {
        //Inicializa campo custom
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
        selfcomp=this;

        app.api.call('GET', app.api.buildURL('minut_Minutas/'+this.model.get('id')+'/link/minut_minutas_minut_compromisos'), null, {
            success: function (data) {
                for(var i=0;i<data.records.length;i++){
                    var temp=data.records[i].date_entered;
                    var temp2=temp.split("T");
                    data.records[i].date_entered=temp2[0];
                }
                selfcomp.myData2 = $.parseJSON( '{"myData2":{"records":'+JSON.stringify(data.records)+'}}');
                _.extend(selfcomp, selfcomp.myData2);
                selfcomp.render();
                console.log("myData2 seteado");
            },
            error: function (e) {
                console.log(e);
            }
        });

        myData = $.parseJSON( '{"myData":{"records":[]}}');
        _.extend(this, myData);
        console.log("myData seteado");
        this.render();
    },

    loadparticipantes:function(options){
        this.arr_responsables=$.parseJSON( '{"arr_responsables": {"responsables":'+JSON.stringify(selfData.mParticipantes.participantes)+'}}');
        for(var i=0;i<this.arr_responsables.arr_responsables.responsables.length;i++){
            if(this.arr_responsables.arr_responsables.responsables[i].apaterno!=null || this.arr_responsables.arr_responsables.responsables[i].apaterno!=undefined){
                this.arr_responsables.arr_responsables.responsables[i].nombres+=' '+this.arr_responsables.arr_responsables.responsables[i].apaterno;
            }
            if(this.arr_responsables.arr_responsables.responsables[i].amaterno!=null || this.arr_responsables.arr_responsables.responsables[i].amaterno!=undefined){
                this.arr_responsables.arr_responsables.responsables[i].nombres+=' '+this.arr_responsables.arr_responsables.responsables[i].amaterno;
            }
        }
        _.extend(this, this.arr_responsables);
        this.compromiso=$('.newcompromiso')[0].value;
        _.extend(this, this.compromiso);
        console.log("responsables seteados");

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
      var valor5=selfData.mParticipantes.idCuenta;

      var item = {
        "compromiso":valor1,"id_resp":valor2, "responsable":valor3, "fecha":valor4, "cuenta_madre":valor5
      };

        if(valor1.trim()!='') {
            this.myData.records.push(item);
            this.model.set('minuta_compromisos', this.myData.records);
            //this.model.save();
            this.render();
            $('.newcompromiso').val('');
            $('.newresponsable').val('0');
            $('.newdate ').val('');
        }
    },

    _render: function () {
        this._super("_render");

        if(this.compromiso!=undefined) {
            $('.newcompromiso').val(this.compromiso);
        }

        $('.removecompromiso2').click(function(evt) {
            var row = $(this).closest(".compromisos2");    // Find the row
            selfcomp.myData.records.splice(row.index(),1);
            selfcomp.render();
        });

        $('.existingresponsable').change(function(evt) {
            var row = $(this).closest(".compromisos2");    // Find the row
            var val= row.find(".existingresponsable").context.value;
            var text = row.find(".existingresponsable option[value="+val+"]").text();
            selfcomp.myData.records[row.index()].responsable = text;
            selfcomp.myData.records[row.index()].id_resp = val;
            selfcomp.render();
        });

        $('.existingcompromiso').change(function(evt) {
            var row = $(this).closest(".compromisos2");    // Find the row
            var val= row.find(".existingcompromiso").context.value;
            selfcomp.myData.records[row.index()].compromiso = val;
            selfcomp.render();
        });

        $('.existingdate').change(function(evt) {
            var row = $(this).closest(".compromisos2");    // Find the row
            var val= row.find(".existingdate").context.value;
            selfcomp.myData.records[row.index()].fecha = val;
            selfcomp.render();
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
