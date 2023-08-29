({
    className: 'asignacion_po',

    events: {
        'click #btn_guardar': 'guardar',
        'change .oficinas_atiende': 'actualizaOficinasAtiende',
    },

    initialize: function(options){
        this._super("initialize", [options]);
        this.loadView = false;
        if(app.user.attributes.asignacion_po_c == 1){
          this.loadView = true;
          asignacionPO = this;
          asignacionPO.lista_equipo = app.lang.getAppListStrings('equipo_list');
          app.api.call("read", app.api.buildURL('getAsignacionPO'), null, {
            success: _.bind(function (data) {
              if(data.length > 0) {

                asignacionPO.listaAsignacionPO = [];
                asignacionPO.listaAsignacionPO_previo = [];

                for(var i = 0; i < data.length; i++) {

                  var equiposOA = data[i].equipos;
                  var equiposOA_concat = "";
                  equiposOA_concat = equiposOA;
         
                  var actual = {
                       "zona_geografica": data[i].zona_geografica,
                       "equipos": equiposOA_concat,
                       "uName": data[i].uName,
                       "date_modified": data[i].date_modified
                   };
                   var previo = {
                     "zona_geografica": data[i].zona_geografica,
                     "equipos": equiposOA_concat,
                     "uName": data[i].uName,
                     "date_modified": data[i].date_modified
                   };
                   asignacionPO.listaAsignacionPO.push(actual);
                   asignacionPO.listaAsignacionPO_previo.push(previo);
                   asignacionPO.Total = data.length;
                }

              } else {
                asignacionPO.listaAsignacionPO = [];
                asignacionPO.listaAsignacionPO_previo = [];
                asignacionPO.Total = 0;
              }
              asignacionPO.render();
            }, this)
          });
        }else{
            var route = app.router.buildRoute(this.module, null, '');
            app.router.navigate(route, {trigger: true});
        }
    },

    actualizaOficinasAtiende: function(evt) {
      
      var inputs = this.$('[data-field="oficinas_atiende_id"].updateOA');
      var input = this.$(evt.currentTarget);
      var index = inputs.index(input);
      var selectOA = $(evt.currentTarget).val();

      for (var i = 0; i < selectOA.length; i++) {
        selectOA[i] = '^' + selectOA[i] + '^'; 
      }
      asignacionPO.listaAsignacionPO[index].equipos = selectOA.toString();
      $('#btn_guardar').attr('style', 'pointer-events:auto;');
    },
    
    guardar: function (){
        $('#btn_guardar').attr('style', 'pointer-events:none;');
        for(var i = 0; i < asignacionPO.listaAsignacionPO.length; i++) {
          if(asignacionPO.listaAsignacionPO[i].equipos != asignacionPO.listaAsignacionPO_previo[i].equipos) {
            
            app.alert.show("alerta_update", {
                level: 'process',
                title: "Actualizando mapeo, por favor espere.",
                autoClose: false
            });
            var update = {
              zona_geografica: asignacionPO.listaAsignacionPO[i].zona_geografica,
              equipos: asignacionPO.listaAsignacionPO[i].equipos,
              modified_by: App.user.id
            };
            
            var Url = app.api.buildURL("upAsignacionPO", '', {}, {});
            app.api.call("create", Url, update, {
              success: _.bind(function (data) {
                app.alert.dismiss('alerta_update');
                app.alert.show("Confirmacion_agentes", {
                  level: 'success',
                  title: "Mapeo actualizado correctamente",
                  autoClose: true
                });
                //this.buscar();
              }, this),
                error: function (error) {
                  app.alert.dismiss('alerta_update');
                  app.alert.show('Confirmacion_error', {
                    level: 'error',
                    messages: error,
                    autoClose: true
                  });
                }
            });
            asignacionPO.listaAsignacionPO[i].equipos = asignacionPO.listaAsignacionPO[i].equipos;
          }
        }
    },
})
