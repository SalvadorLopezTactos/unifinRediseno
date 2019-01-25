/*
 *  AF - 2018-10-23
 *  CustomField - Grid
 */
({
    events: {
        'click  .addcompromiso': 'addRecordFunction',
        //'blur   .newcompromiso': 'loadparticipantes',
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
        //this.model.on('data:sync:complete', this.loadData(), this);
        //this.obj_dates=JSON.parse(this.model.get('tct_dates_acc_statements_c'));
        //_.extend(this, this.obj_dates);
        //this.render();
        //console.log("obj_dates seteado");
    },



    loadData: function () {
        selfcomp=this;

        if(this.model.get('id') != undefined || this.model.get('id') !="") {

            if(this.model.get('tct_dates_acc_statements_c')!=undefined) {
                if(this.model.get('tct_dates_acc_statements_c')==""){
                    this.model.set('tct_dates_acc_statements_c',"{}")
                }
                this.obj_dates = JSON.parse(this.model.get('tct_dates_acc_statements_c'));
                _.extend(this, this.obj_dates);
                this.render();
                console.log("obj_dates seteado");
            }

        /*    app.api.call('GET', app.api.buildURL('Accounts/' + this.model.get('id') + '/link/dates_account_statements'), null, {
                success: function (data) {
                    for (var i = 0; i < data.records.length; i++) {
                        if (data.records[i].tct_fecha_compromiso_c != '') {
                            var temp = data.records[i].tct_fecha_compromiso_c;
                            var temp2 = temp.split("T");
                            data.records[i].tct_fecha_compromiso_c = temp2[0];
                        }
                    }
                    selfcomp.myData2 = $.parseJSON('{"myData2":{"records":' + JSON.stringify(data.records) + '}}');
                    _.extend(selfcomp, selfcomp.myData2);
                    selfcomp.render();
                    console.log("myData2 seteado");
                },
                error: function (e) {
                    console.log(e);
                }
            }); */
        }


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

        /*myData = $.parseJSON( '{"myData":{"records":[]}}');
        _.extend(this, myData);
        console.log("myData seteado");
        this.render();*/

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
      //var valor1 = $('.newcompromiso')[0].value;
      //var valor2 = $('.newresponsable')[0].value;
      //var valor3 = $(".newresponsable option:selected").text();
      var valor4 = $('.newdate')[0].value;
      //var valor5=selfData.mParticipantes.idCuenta;
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

      /*var item = {
        "compromiso":valor1,"id_resp":valor2, "responsable":valor3, "fecha":valor4, "cuenta_madre":valor5
        };*/

        var item = valor4;

            if(valor4!=''/* && valor4>=today*/) {
            //this.myData.records.push(item);
            //this.model.set('minuta_compromisos', this.myData.records);
            //this.render();
            //$('.newcompromiso').val('');
            //$('.newcompromiso').css('border-color', '');
            //$('.newresponsable').val('0');
            //$('.newresponsable').css('border-color', '');
            $('.newdate ').val('');
            $('.newdate').css('border-color', '');

            //this.obj_dates=JSON.parse(this.model.get('tct_dates_acc_statements_c'));
            //this.obj_dates["d"+Object.keys(this.obj_dates).length]=valor4;
            var k="d"+(Object.keys(this.obj_dates).length);
            this.obj_dates[k]=valor4;
            //this.obj_dates.records.push(item);
            this.model.set('tct_dates_acc_statements_c',JSON.stringify(this.obj_dates));
            //this.model.set('tct_dates_acc_statements_c',arr_dates.toString());
            this.render();

        }else{
            //if(valor4=='') {
                $('.newdate').css('border-color', 'red');
                app.alert.show("empty_date", {
                    level: "error",
                    title: "La fecha est\u00E1 vac\u00EDa",
                    autoClose: false
                });
            /*}else{
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
            }*/

        }
    },




    _render: function () {
        this._super("_render");

        $('div[data-name=tct_dates_acc_statements_c]').hide();

        $('.removecompromiso').click(function(evt) {
            //var row = $(this).closest(".compromisos2");    // Find the row
            //selfcomp.myData.records.splice(row.index(),1);
            var key=$(this).closest(".control-group").find('.loadeddate')[0].id;
            delete selfcomp.obj_dates[key];
            keys=Object.keys(selfcomp.obj_dates);
            var new_obj_dates={};
            for(var i=0;i<keys.length;i++){
                new_obj_dates["d"+i]=selfcomp.obj_dates[keys[i]]
            }
            selfcomp.obj_dates=new_obj_dates;
            selfcomp.model.set('tct_dates_acc_statements_c',JSON.stringify(selfcomp.obj_dates));
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

        $('.loadeddate').change(function(evt) {
            var row = $(this).closest(".compromisos2");    // Find the row
            var val= row.find(".existingdate").context.value;
            var key=$(this).closest(".control-group").find('.loadeddate')[0].id;
            selfcomp.obj_dates[key] = val;
            selfcomp.model.set('tct_dates_acc_statements_c',JSON.stringify(selfcomp.obj_dates))
            selfcomp.render();
            if($('.loadeddate').eq(row.index()).val().trim()!='') {
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
