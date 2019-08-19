/**
 * Created by Adrian Arauz 13/08/2019
 */
({
    listausuarios: null,
    listausuarios_previo:null,
    filtros: null,


    events: {
        'click #btn_Asesores': 'buscarCuentas',
        'click .check-vetado': 'updateVetado',
        'click #btn_guardavetados': 'guardarvetado',
    },

    initialize: function(options){
        this._super("initialize", [options]);
        vetados = this;
        this.loadView = false;
        if(app.user.attributes.puestousuario_c == "28" || app.user.attributes.puestousuario_c == "29" || app.user.attributes.puestousuario_c == "30" || app.user.attributes.is_manager == true){
            this.cargalistas();
            //this.generalistas();
            vetados.filtros = {
                "Nombre":"",
                "Apellidos":"",
                "Equipo":"",
                "Puesto":"",
                "Total":"0"
            };

            this.loadView = true;
            this.render();
        }else{
            var route = app.router.buildRoute(this.module, null, '');
            app.router.navigate(route, {trigger: true});
        }
    },

    _render: function () {
        this._super("_render");
    },

    cargalistas: function () {
        this.lista_equipo = app.lang.getAppListStrings('equipo_list');
        this.lista_puesto = app.lang.getAppListStrings('puestousuario_c_list');

    },

    generalistas: function ()
    {
        var lista1ID = app.lang.getAppListStrings('equipo_list');
        var lista_equipo = '';
        Object.keys(lista1ID).forEach(function (id) {
            //console.log(id, lista1apID[id]);
            lista_equipo += '<option value="' + id + '">' + lista1ID[id] + '</option>'
        });
        this.lista_equipo = lista_equipo;

        var lista2ID = app.lang.getAppListStrings('puestousuario_c_list');
        var lista_puesto = '';
        Object.keys(lista2ID).forEach(function (id) {
            //console.log(id, lista1apID[id]);
            lista_puesto += '<option value="' + id + '">' + lista2ID[id] + '</option>'
        });
        this.lista_puesto = lista_puesto;
    },
   /* _setOffset: function (){
        $("#offset_value").attr("from_set", 0);
        $("#crossSeleccionados").val("");
    },*/


    buscarCuentas: function(){
        var AsesorN = $('#AsesorN').val();
        var AsesorA = $('#AsesorA').val();
        var equipoA = $("#Equipos").val();
        var puestoA = $("#Puesto").val();

        vetados.filtros = {
          "Nombre":AsesorN,
          "Apellidos":AsesorA,
          "Equipo":equipoA,
          "Puesto":puestoA
        };

        $('#successful').hide();

        //var strUrl='Users?fields=id,name,puestousuario_c,vetados_chk_c,equipos_c&filter[][status]=Active&filter[][first_name][$contains]='+AsesorN+'&filter[][last_name][$contains]='+AsesorA+'&filter[][equipos_c][$equals]='+equipoA+'&filter[][puestousuario_c][$equals]='+puestoA+'&max_num=-1';
        var strUrl='Users?fields=id,name,puestousuario_c,vetados_chk_c,equipos_c&max_num=-1&filter[][status]=Active';
        if (AsesorN != "" && AsesorN != null) {
            strUrl= strUrl + '&filter[][first_name][$contains]='+AsesorN;
        }
        if (AsesorA != "" && AsesorA != null) {
            strUrl= strUrl + '&filter[][last_name][$contains]='+AsesorA;
        }
        if (equipoA != "" && equipoA != null) {
            strUrl= strUrl + '&filter[][equipos_c][$contains]='+equipoA;
        }
        if (puestoA != "" && puestoA != null) {
            strUrl= strUrl + '&filter[][puestousuario_c][$equals]='+puestoA;
        }
        $('#processing').show();
        app.api.call("GET", app.api.buildURL(strUrl), null, {
            success: _.bind(function (data) {
                if(data.records.length>0){
                    vetados.listausuarios=[];
                    vetados.listausuarios_previo=[];
                    for (var i = 0; i < data.records.length; i++) {
                        var actual = {
                            "id": data.records[i].id,
                            "puestousuario_c": data.records[i].puestousuario_c,
                            "equipos_c":data.records[i].equipos_c,
                            "name": data.records[i].name,
                            "vetados_chk_c": data.records[i].vetados_chk_c
                        };

                        var previo = {
                            "id": data.records[i].id,
                            "puestousuario_c": data.records[i].puestousuario_c,
                            "equipos_c":data.records[i].equipos_c,
                            "name": data.records[i].name,
                            "vetados_chk_c": data.records[i].vetados_chk_c

                        };

                        vetados.listausuarios.push(actual);
                        vetados.listausuarios_previo.push(previo);
                        vetados.filtros.Total = data.records.length;
                    }

                }else {
                    vetados.listausuarios=[];
                    vetados.listausuarios_previo=[];
                    vetados.filtros.Total = 0;
                }
                $('#processing').hide();
                vetados.render();
            }, this)
        });
    },

    updateVetado: function(evt) {
        var inputs = this.$('.check-vetado'),
            input = this.$(evt.currentTarget),
            index = inputs.index(input);
        vetados.listausuarios[index].vetados_chk_c= (input[0].checked == true) ? 1 : 0;
    },


    guardarvetado: function (){
        //$('.check-vetado').attr('style', 'pointer-events:none;');
        //$('#btn_guardavetados').attr('style', 'pointer-events:none;');
        app.alert.show("alerta_vetado_update", {
            level: 'process',
            title: "Actualizado usuario(s), por favor espere.",
            autoClose: false
        });
        var totalvetados= 0;
        for (var v=0; v< vetados.listausuarios.length; v++ ){
            if (vetados.listausuarios[v].vetados_chk_c!= vetados.listausuarios_previo[v].vetados_chk_c){
                totalvetados++;
            }
        }
        var actual= 0;
        for (var i = 0; i < vetados.listausuarios.length; i++) {
            if (vetados.listausuarios[i].vetados_chk_c!= vetados.listausuarios_previo[i].vetados_chk_c) {
                var idvetado= vetados.listausuarios[i].id;
                var valUrl = app.api.buildURL("Users/"+idvetado);
                app.api.call("update", valUrl, {'vetados_chk_c': vetados.listausuarios[i].vetados_chk_c}, {
                    success: _.bind(function (data) {
                        actual++;
                        if(actual==totalvetados){
                            App.alert.dismiss('alerta_vetado_update');
                            app.alert.show("Confirmacion_vetados", {
                                level: 'success',
                                title: "Usuario(s) actualizados correctamente.",
                                autoClose: true
                            });
                        }
                    }, this),
                    error:function(error) {
                        app.alert.dismiss('alerta_vetado_update');
                        app.alert.show('Confirmacion_error', {
                            level: 'error',
                            messages: error,
                            autoClose: true
                        });
                    }
                });

                vetados.listausuarios_previo[i].vetados_chk_c = vetados.listausuarios[i].vetados_chk_c;
               // $('.check-vetado').attr('style', 'pointer-events:block;');
                //$('#btn_guardavetados').attr('style', 'pointer-events:block;');
            }
        }
    },
})
