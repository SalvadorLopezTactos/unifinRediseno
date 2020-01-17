({
    className: 'agentes-telefonicos',

    events: {
        'click #btn_Buscar': 'buscar',
        'click #btn_guardar': 'guardar',
        'change .usuarios': 'actualizaUsuarios',
        'change .equipos': 'actualizaEquipos',
    },

    initialize: function(options){
        this._super("initialize", [options]);
        this.loadView = false;
        if(app.user.attributes.agente_telefonico_c == 1){
          this.loadView = true;
          agentes = this;
          agentes.filtros = {
            "Nombre":"",
            "Apellidos":"",
            "Equipo":"",
            "Informa":"",
            "Total":"0"
          };
          this.lista_equipo = app.lang.getAppListStrings('equipo_list');
          var strUrl = 'Users?fields=id,nombre_completo_c&order_by=nombre_completo_c:asc&max_num=-1&filter[][status]=Active';
          app.api.call("GET", app.api.buildURL(strUrl), null, {
            success: _.bind(function (data) {
              if(data.records.length > 0) {
                var usuario = {};
                for(var i = 0; i < data.records.length; i++) {
                  usuario[data.records[i].id] = data.records[i].nombre_completo_c;
                }
                usuario[''] = '';
                agentes.usuarios_list = usuario;
              }
            }, this)
          });
        }else{
            var route = app.router.buildRoute(this.module, null, '');
            app.router.navigate(route, {trigger: true});
        }
    },

    buscar: function(){
        var Informa = this.model.get('assigned_user_id');
        var AgenteN = $('#AgenteN').val().trim();
        var AgenteA = $('#AgenteA').val().trim();
        var equipoA = $("#Equipos").val();
        if(AgenteN!="" || AgenteA !="" || equipoA!="0" || Informa!=undefined || Informa!=null || Informa!="") {
          agentes.filtros = {
              "Nombre": AgenteN,
              "Apellidos": AgenteA,
              "Equipo": equipoA,
              "Informa": Informa
          };
          $('#successful').hide();
          var strUrl = 'Users?fields=id,nombre_completo_c,puestousuario_c,reports_to_id,reports_to_name,equipo_c&max_num=-1&filter[][status]=Active&filter[1][$or][0][puestousuario_c]=27&filter[1][$or][1][puestousuario_c]=31&order_by=nombre_completo_c:asc';
          if(AgenteN != "" && AgenteN != null) {
            strUrl = strUrl + '&filter[][first_name][$contains]=' + AgenteN;
          }
          if(AgenteA != "" && AgenteA != null) {
            strUrl = strUrl + '&filter[][last_name][$contains]=' + AgenteA;
          }
          if(equipoA != "0" && equipoA != null) {
            strUrl = strUrl + '&filter[][equipo_c][$equals]=' + equipoA;
          }
          if(Informa != "" && Informa != null) {
            strUrl = strUrl + '&filter[][reports_to_id][$equals]=' + Informa;
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
                         "reports_to_id": data.records[i].reports_to_id,
                         "equipo_c": data.records[i].equipo_c,
                         "nombre_completo_c": data.records[i].nombre_completo_c,
                         "reports_to_name": data.records[i].reports_to_name
                     };
                     var previo = {
                         "id": data.records[i].id,
                         "reports_to_id": data.records[i].reports_to_id,
                         "equipo_c": data.records[i].equipo_c,
                         "nombre_completo_c": data.records[i].nombre_completo_c,
                         "reports_to_name": data.records[i].reports_to_name
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
                $('#btn_guardar').attr('style', 'pointer-events:none;');
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

    actualizaUsuarios: function(evt) {
        var inputs = this.$('[data-field="user_id"].updateusr'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input); 
        agentes.listausuarios[index].reports_to_id = input.val();
        $('#btn_guardar').attr('style', 'pointer-events:auto;');
    },

    actualizaEquipos: function(evt) {
        var inputs = this.$('[data-field="equipo_id"].updateeqp'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        agentes.listausuarios[index].equipo_c = input.val();
        $('#btn_guardar').attr('style', 'pointer-events:auto;');
    },
    
    guardar: function (){
        $('#btn_guardar').attr('style', 'pointer-events:none;');
        for(var i = 0; i < agentes.listausuarios.length; i++) {
          if(agentes.listausuarios[i].reports_to_id != agentes.listausuarios_previo[i].reports_to_id || agentes.listausuarios[i].equipo_c != agentes.listausuarios_previo[i].equipo_c) {
            app.alert.show("alerta_update", {
                level: 'process',
                title: "Actualizando usuario(s), por favor espere.",
                autoClose: false
            });
            var idagente = agentes.listausuarios[i].id;
            var valUrl = app.api.buildURL("Users/" + idagente);
            app.api.call("update", valUrl, {'reports_to_id':agentes.listausuarios[i].reports_to_id, 'equipo_c':agentes.listausuarios[i].equipo_c}, {
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
            agentes.listausuarios_previo[i].reports_to_id = agentes.listausuarios[i].reports_to_id;
            agentes.listausuarios_previo[i].equipo_c = agentes.listausuarios[i].equipo_c;
          }
        }
    },
})