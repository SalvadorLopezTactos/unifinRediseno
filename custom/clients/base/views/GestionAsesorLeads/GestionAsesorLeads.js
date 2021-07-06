({
    className: 'gestion_asignacion_lm',

    events: {
        'click #btn_Buscar': 'buscar',
        'click #btn_guardar': 'guardar',
        //'change .usuarios': 'actualizaUsuarios',
        'change .limite_max': 'actualizaLimite',
        'change .posicion_operativa': 'actualizaPosicionOperativa',
        //'change .sub_puesto': 'actualizaSubpuesto',
    },

    initialize: function(options){
        this._super("initialize", [options]);
        this.loadView = false;
        if(app.user.attributes.gestion_lm_c == 1){
          this.loadView = true;
          agentes = this;
          agentes.filtros = {
            "Nombre":"",
            "Apellidos":"",
            "PosicionOperativa":"",
            "Producto":"1",
            "Total":"0"
          };

          this.lista_equipo = app.lang.getAppListStrings('equipo_list');
          this.lista_producto = app.lang.getAppListStrings('tipo_producto_list');
          this.lista_posicion_operativa = app.lang.getAppListStrings('posicion_operativa_list');
          // this.lista_subpuesto = app.lang.getAppListStrings('subpuesto_list');
          //
          // var strUrl = 'Users?fields=id,nombre_completo_c&order_by=nombre_completo_c:asc&max_num=-1&filter[][status]=Active';
          // app.api.call("GET", app.api.buildURL(strUrl), null, {
          //   success: _.bind(function (data) {
          //     if(data.records.length > 0) {
          //       var usuario = {};
          //       for(var i = 0; i < data.records.length; i++) {
          //         usuario[data.records[i].id] = data.records[i].nombre_completo_c;
          //       }
          //       usuario[''] = '';
          //       agentes.usuarios_list = usuario;
          //     }
          //   }, this)
          // });
        }else{
            var route = app.router.buildRoute(this.module, null, '');
            app.router.navigate(route, {trigger: true});
        }
    },

    buscar: function(){
        var AgenteN = $('#AgenteN').val().trim();
        var AgenteA = $('#AgenteA').val().trim();
        var posicionO = $("#PosicionOperativa").val();
        var producto = $("#Producto").val();
        if(AgenteN!="" || AgenteA !="" || posicionO!="" || producto!="") {
          agentes.filtros = {
              "Nombre": AgenteN,
              "Apellidos": AgenteA,
              "PosicionOperativa":posicionO,
              "Producto":producto
          };
          $('#successful').hide();
          var strUrl = 'Users?fields=id,nombre_completo_c,posicion_operativa_c,puestousuario_c,subpuesto_c,reports_to_id,reports_to_name,equipo_c,equipos_c,limite_asignacion_lm_c&max_num=-1&filter[][status]=Active&order_by=nombre_completo_c:asc';
          if(AgenteN != "" && AgenteN != null) {
            strUrl = strUrl + '&filter[][first_name][$contains]=' + AgenteN;
          }
          if(AgenteA != "" && AgenteA != null) {
            strUrl = strUrl + '&filter[][last_name][$contains]=' + AgenteA;
          }
          if(posicionO != "" && posicionO != null) {
            strUrl = strUrl + '&filter[][posicion_operativa_c][$contains]=' + posicionO;
          }
          if(producto != "" && producto != null) {
            strUrl = strUrl + '&filter[][productos_c][$contains]=' + producto;
          }
          $('#processing').show();
          app.api.call("GET", app.api.buildURL(strUrl), null, {
             success: _.bind(function (data) {

                if(data.records.length > 0) {
                  agentes.listausuarios = [];
                  agentes.listausuarios_previo = [];

                  for(var i = 0; i < data.records.length; i++) {
                    var actual = {
                         "id": data.records[i].id,
                         "equipo_c": data.records[i].equipo_c,
                         "nombre_completo_c": data.records[i].nombre_completo_c,
                         "puestousuario_c": data.records[i].puestousuario_c,
                         "posicion_operativa_c": '^'+data.records[i].posicion_operativa_c.join('^,^')+'^',
                         "limite_asignacion_lm_c":data.records[i].limite_asignacion_lm_c
                     };
                     var previo = {
                         "id": data.records[i].id,
                         "equipo_c": data.records[i].equipo_c,
                         "nombre_completo_c": data.records[i].nombre_completo_c,
                         "puestousuario_c": data.records[i].puestousuario_c,
                         "posicion_operativa_c":'^'+data.records[i].posicion_operativa_c.join('^,^')+'^',
                         "limite_asignacion_lm_c":data.records[i].limite_asignacion_lm_c
                     };
                     agentes.listausuarios.push(actual);
                     agentes.listausuarios_previo.push(previo);
                     agentes.filtros.Total = data.records.length;
                  }

                } else {
                  agentes.listausuarios = [];
                  agentes.listausuarios_previo = [];
                  agentes.filtros.Total = 0;
                }
                $('#processing').hide();
                agentes.render();
                //$('#btn_guardar').attr('style', 'pointer-events:none;');
                $(".notFound").removeClass("hide");
             }, this)
          });
        }else{
            app.alert.show("Campos faltantes para búsqueda", {
                level: "error",
                messages: 'Ingrese algún criterio de búsqueda',
                autoClose: false
            });
        }
    },

    actualizaLimite: function(evt) {
        var inputs = this.$('[data-field="limite_asignacion_lm_c"].updateL'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        agentes.listausuarios[index].limite_asignacion_lm_c = input.val();
        $('#btn_guardar').attr('style', 'pointer-events:auto;');
    },

    actualizaPosicionOperativa: function(evt) {
      var inputs = this.$('[data-field="posicion_operativa"].updatePO');
      var input = this.$(evt.currentTarget);
      var index = inputs.index(input);
      var selectPO = $(evt.currentTarget).val();

      for (var i = 0; i < selectPO.length; i++) {
        selectPO[i] = '^' + selectPO[i] + '^';
      }
      agentes.listausuarios[index].posicion_operativa_c = selectPO.toString();
      $('#btn_guardar').attr('style', 'pointer-events:auto;');
    },

    guardar: function (){
        $('#btn_guardar').attr('style', 'pointer-events:none;');
        for(var i = 0; i < agentes.listausuarios.length; i++) {
          if(agentes.listausuarios[i].posicion_operativa_c != agentes.listausuarios_previo[i].posicion_operativa_c || agentes.listausuarios[i].limite_asignacion_lm_c != agentes.listausuarios_previo[i].limite_asignacion_lm_c ) {

            app.alert.show("alerta_update", {
                level: 'process',
                title: "Actualizando usuario(s), por favor espere.",
                autoClose: false
            });
            var at_options = {
              user_id: agentes.listausuarios[i].id,
              posicion_operativa_c: agentes.listausuarios[i].posicion_operativa_c,
              limite_asignacion_lm_c: agentes.listausuarios[i].limite_asignacion_lm_c
            };

            var Url = app.api.buildURL("ActualizaGestionLM", '', {}, {});
            app.api.call("create", Url, {data: at_options}, {
              success: _.bind(function (data) {
                app.alert.dismiss('alerta_update');
                app.alert.show("Confirmacion_agentes", {
                  level: 'success',
                  title: "Usuario(s) actualizados correctamente.",
                  autoClose: true
                });
                this.buscar();
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
            agentes.listausuarios_previo[i].posicion_operativa_c = agentes.listausuarios[i].posicion_operativa_c;
            agentes.listausuarios_previo[i].limite_asignacion_lm_c = agentes.listausuarios[i].limite_asignacion_lm_c;
          }
        }
    },
})
