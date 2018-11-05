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

    loadData: function () {
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

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10) {
            dd = '0'+dd
        }
        if(mm<10) {
            mm = '0'+mm
        }
        min_date = {"min_date": yyyy + '-' + mm + '-' + dd};
        _.extend(this, min_date);

        myData = $.parseJSON( '{"myData":{"records":[]}}');
        _.extend(this, myData);
        console.log("myData seteado");
        this.render();
    },

    loadparticipantes:function(){
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
        this.responsable=$('.newresponsable')[0].value;
        _.extend(this, this.responsable);
        this.date=$('.newdate')[0].value;
        _.extend(this, this.date);
        console.log("responsables seteados");

        this.render();

        $('.newcompromiso').val(this.compromiso);
        $('.newresponsable').val(this.responsable);
        $('.newdate').val(this.date);
    },

    //Función para agregar nuevos elementos al objeto
    addRecordFunction: function () {
      var valor1 = $('.newcompromiso')[0].value;
      var valor2 = $('.newresponsable')[0].value;
      var valor3 = $(".newresponsable option:selected").text();
      var valor4 = $('.newdate')[0].value;
      var valor5=selfData.mParticipantes.idCuenta;
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10) {
            dd = '0'+dd
        }
        if(mm<10) {
            mm = '0'+mm
        }
        today = yyyy+'-'+mm+'-'+dd;

      var item = {
        "compromiso":valor1,"id_resp":valor2, "responsable":valor3, "fecha":valor4, "cuenta_madre":valor5
      };

        if(valor1.trim()!='' && valor2!='0' && valor4!='' && valor4>=today) {
            this.myData.records.push(item);
            this.model.set('minuta_compromisos', this.myData.records);
            this.render();
            $('.newcompromiso').val('');
            $('.newcompromiso').css('border-color', '');
            $('.newresponsable').val('0');
            $('.newresponsable').css('border-color', '');
            $('.newdate ').val('');
            $('.newdate').css('border-color', '');

        }else{
            if(valor1.trim()=='') {
                $('.newcompromiso').css('border-color', 'red');
                app.alert.show("empty_comp", {
                    level: "error",
                    title: "El compromiso est\u00E1 vac\u00EDo",
                    autoClose: false
                });
            }else{
                $('.newcompromiso').css('border-color', '');
            }
            if(valor2=='0') {
                $('.newresponsable').css('border-color', 'red');
                app.alert.show("empty_resp", {
                    level: "error",
                    title: "El responsable est\u00E1 vac\u00EDo",
                    autoClose: false
                });
            }else{
                $('.newresponsable').css('border-color', '');
            }
            if(valor4=='') {
                $('.newdate').css('border-color', 'red');
                app.alert.show("empty_date", {
                    level: "error",
                    title: "La fecha est\u00E1 vac\u00EDa",
                    autoClose: false
                });
            }else{
                if(valor4<today){
                    $('.newdate').css('border-color', 'red');
                    app.alert.show("datecomp_invalid", {
                        level: "error",
                        title: "La fecha del compromiso que quieres agregar debe ser mayor al d\u00EDa de hoy",
                        autoClose: false
                    });
                }else{
                    $('.newdate').css('border-color', '');
                }
            }

        }
    },

    _render: function () {
        this._super("_render");

        $('.removecompromiso2').click(function(evt) {
            var row = $(this).closest(".compromisos2");    // Find the row
            selfcomp.myData.records.splice(row.index(),1);
            selfcomp.render();
        });

        $('.existingresponsable').change(function(evt) {
            var row = $(this).closest(".compromisos2");    // Find the row
            var val= row.find(".existingresponsable").context.value;
            var text = row.find(".existingresponsable option[value="+val+"]").text();
            if($('.existingresponsable').eq(row.index()).text().trim()!='') {
                selfcomp.myData.records[row.index()].responsable = text;
                selfcomp.myData.records[row.index()].id_resp = val;
                selfcomp.render();
                $('.existingresponsable').eq(row.index()).css('border-color', '');
            }else{
                $('.existingresponsable').eq(row.index()).css('border-color', 'red');
            }
        });

        $('.existingcompromiso').change(function(evt) {
            var row = $(this).closest(".compromisos2");    // Find the row
            var val= row.find(".existingcompromiso").context.value;
            if($('.existingcompromiso').eq(row.index()).val().trim()!='') {
            selfcomp.myData.records[row.index()].compromiso = val;
            selfcomp.render();
                $('.existingcompromiso').eq(row.index()).css('border-color', '');
            }else{
                $('.existingcompromiso').eq(row.index()).css('border-color', 'red');
            }
        });

        $('.existingdate').change(function(evt) {
            var row = $(this).closest(".compromisos2");    // Find the row
            var val= row.find(".existingdate").context.value;
            if($('.existingdate').eq(row.index()).val().trim()!='') {
            selfcomp.myData.records[row.index()].fecha = val;
            selfcomp.render();
            selfcomp.render();
                $('.existingdate').eq(row.index()).css('border-color', '');
            }else{
                $('.existingdate').eq(row.index()).css('border-color', 'red');
            }
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
