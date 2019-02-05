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

        if(this.model.get('tct_dates_acc_statements_c')==undefined || this.model.get('tct_dates_acc_statements_c')==""){
            this.model.set('tct_dates_acc_statements_c',"{}")
        }
        this.obj_dates = JSON.parse(this.model.get('tct_dates_acc_statements_c'));
        _.extend(this, this.obj_dates);
        this.render();
        console.log("obj_dates seteado");


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
    },


    addRecordFunction: function () {
        var valor4 = $('.newdate')[0].value;

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

        if(valor4!=''/* && valor4>=today*/) {

            $('.newdate ').val('');
            $('.newdate').css('border-color', '');

            var k="d"+(Object.keys(this.obj_dates).length);
            this.obj_dates[k]=valor4;
            this.model.set('tct_dates_acc_statements_c',JSON.stringify(this.obj_dates));
            this.render();

        }else{
            $('.newdate').css('border-color', 'red');
                app.alert.show("empty_date", {
                    level: "error",
                    title: "La fecha est\u00E1 vac\u00EDa",
                    autoClose: false
            });
        }
    },


    _render: function () {
        this._super("_render");

        $('div[data-name=tct_dates_acc_statements_c]').hide();

        if($('.loadeddate').length>0){
            $('.divnewdate').removeAttr( 'style' );
        }

        $('.removecompromiso').click(function(evt) {
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

        $('.loadeddate').change(function(evt) {
            var row = $(this).closest(".compromisos2");    // Find the row
            var val= row.find(".existingdate").context.value;
            var key=$(this).closest(".control-group").find('.loadeddate')[0].id;
            selfcomp.obj_dates[key] = val;
            selfcomp.model.set('tct_dates_acc_statements_c',JSON.stringify(selfcomp.obj_dates))
            selfcomp.render();
            if($('.loadeddate').eq(row.index()).val().trim()!='') {
                $('.loadeddate').eq(row.index()).css('border-color', '');
            }else{
                $('.loadeddate').eq(row.index()).css('border-color', 'red');
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
