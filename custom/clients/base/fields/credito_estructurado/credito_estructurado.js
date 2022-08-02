/*
 * @author eduardo.carrasco@tactos.com.mx
 */
({
    events: {
        'click  .addcomision': 'addRecordFunction',
    },

    initialize: function (options) {
        this._super('initialize', [options]);
        this.myData3 = $.parseJSON('{"myData3":{"records":[]}}');
        _.extend(this, this.myData3);
        window.carga = 0;
        window.contador = 0;
    },

    addRecordFunction: function () {
      var valor1 = $('.newcomision')[0].value;
      var valor2 = $('.newporcentaje')[0].value;
      var item = {
        "name":valor1,"porcentaje":valor2
      };
      if(valor1.trim()!='' && valor2!='') {
        this.myData3.records.push(item);
        this.model.set('ce_comisiones_c', JSON.stringify(this.myData3.records));
        window.carga = 0;
        this.render();
        $('.newcomision').val('');
        $('.newcomision').css('border-color', '');
        $('.newporcentaje').val('');
        $('.newporcentaje').css('border-color', '');
      }else{
        if(valor1.trim()=='') {
          $('.newcomision').css('border-color', 'red');
          app.alert.show("empty_com", {
            level: "error",
            title: "El nombre de la condición est\u00E1 vac\u00EDo",
            autoClose: false
          });
        }else{
          $('.newcomision').css('border-color', '');
        }
        if(valor2=='') {
          $('.newporcentaje').css('border-color', 'red');
          app.alert.show("empty_porce", {
            level: "error",
            title: "El porcentaje aplicado est\u00E1 vac\u00EDo",
            autoClose: false
          });
        }else{
          $('.newporcentaje').css('border-color', '');
        }
      }
    },

    _render: function () {
        this._super("_render");
        selfcom = this;
        window.contador = window.contador + 1;
        if(this.model.get('ce_comisiones_c') && (window.carga == 0 || window.contador == 1)) {
          this.myData3 = $.parseJSON('{"myData3":{"records":' + this.model.get('ce_comisiones_c') + '}}');
          _.extend(this, this.myData3);
          window.carga = 1;
          this.render();
        }
        $('.removecomision').click(function(evt) {
            var row = $(this).closest(".comisiones");
            selfcom.myData3.records.splice(row.index(),1);
            selfcom.model.set('ce_comisiones_c', JSON.stringify(selfcom.myData3.records));
            selfcom.render();
        });
        $('.loadedcomision').change(function(evt) {
            var row = $(this).closest(".comisiones");
            var val = $('.loadedcomision').eq(row.index()).val().trim();
            if($('.loadedcomision').eq(row.index()).val().trim()!='') {
              $('.loadedcomision').eq(row.index()).css('border-color', '');
              selfcom.myData3.records[row.index()].name = val;
              selfcom.model.set('ce_comisiones_c', JSON.stringify(selfcom.myData3.records));
              selfcom.render();
            }else{
              $('.loadedcomision').eq(row.index()).css('border-color', 'red');
            }
        });
        $('.loadedporcentaje').change(function(evt) {
            var row = $(this).closest(".comisiones");
            var val = $('.loadedporcentaje').eq(row.index()).val().trim();
            if($('.loadedporcentaje').eq(row.index()).val().trim()!='') {
              $('.loadedporcentaje').eq(row.index()).css('border-color', '');
              selfcom.myData3.records[row.index()].porcentaje = val;
              selfcom.model.set('ce_comisiones_c', JSON.stringify(selfcom.myData3.records));
              selfcom.render();
            }else{
              $('.loadedporcentaje').eq(row.index()).css('border-color', 'red');
            }
        });
        $('[data-name="ce_comisiones_c"]').hide();
    },

    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                this.render();
            }
        }, this);
    },
})
