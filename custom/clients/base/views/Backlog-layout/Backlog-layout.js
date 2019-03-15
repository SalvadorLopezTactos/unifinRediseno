/**
 * Created by Salvador Lopez on 13/03/2019.
 * User: salvador.lopez@tactos.com.mx
 * Reestructura de layout backlog
 */

 ({
    plugins: ['Dashlet'],

    events: {
        'click #btn_Buscar': 'cargarBacklogsButton',
        'click .crearBacklog': 'crearBacklog', 
        'click .mass_update': 'seleccionarBacklog',
        'click .marcarTodos': 'marcarCasillas',
        'click #EquipoSort': 'ordenarPorEquipo',
        'click #PromotorSort': 'ordenarPorPromotor',
        'click #ClienteSort': 'ordenarPorCliente',
        'click #NumeroBacklogSort': 'ordenarPorNumeroBacklog',
        'click #MontoOperacionSort': 'ordenarPorMontoOperacion',
        'click #MontoFinalSort': 'ordenarPorMontoFinal',
        'change .checkboxChange': 'SetMenuOptions',
        'change #mass_update_btn': 'seleccionarTodo',
		    'change #equipo_filtro': 'recalcularPromotores'
    },

    meses_list_html : null,
    anio_list_html_filter : null,
    equipo_list_html : null,
    promotores_list_html : null,
    progreso_list_html : null,
    tipo_operacion_list_html : null,
    etapa_list_html : null,
    estatus_list_html : null,
    backlogs : null,
    
    initialize: function (options) {
        self = this;
        //Actualizar esta variable para cerrar los periodos de Backlog a Petición del usuario
        //1 = Mes cerrado --- 0 = Mes abierto
        self.mesNaturalCerrado = 0;

        this.reporteesEndpoint = app.api.buildURL('Forecasts', 'orgtree/' + app.user.get('id'), null, {'level': 10});

        this._super("initialize", [options]);

        this.progreso_list_html = app.lang.getAppListStrings('progreso_list');
        this.tipo_operacion_list_html = app.lang.getAppListStrings('tipo_de_operacion_0');
        this.etapa_list_html = app.lang.getAppListStrings('etapa_backlog');
        this.estatus_list_html = app.lang.getAppListStrings('estatus_de_la_operacion_list');
        
        this.EquipoSortDirection = 'DESC';
        this.PromotorSortDirection = 'DESC';
        this.ClienteSortDirection = 'DESC';
        this.NumeroBacklogSortDirection = 'DESC';
        this.MontoOperacionSortDirection = 'DESC';
        this.MontoFinalSortDirection = 'DESC';
    },

    loadData: function (options) {
        if (_.isUndefined(this.model)) {
            return;
        }
        var self = this;
        this.meses_list_html = app.lang.getAppListStrings('mes_list');
        var anio_list = app.lang.getAppListStrings('anio_list');
        var currentYear = new Date().getFullYear();
        Object.keys(anio_list).forEach(key => {
          if(key < currentYear-2) {
            delete anio_list[key];
          }
        });
        this.anio_list_html_filter = anio_list;
        var anio_actual = (new Date).getFullYear();
        var mes_actual = self.getActualBacklog();
        self.obtenerBacklogColumnas();
        this.cargarBacklogs('','',anio_actual,mes_actual);
    },
    
    cargarBacklogsButton: function(){
        var anio_actual = $("#anio_filtro").val();
        var mes_actual = $("#mes_filtro").val();   
        this.cargarBacklogs('','',anio_actual,mes_actual);
    },

    cargarBacklogs: function(ordenarPor, direccion, anio_actual, mes_actual){
        $(".loadingIcon").show();
        if (typeof ordenarPor === "undefined") {
            ordenarPor = '';
        }
        if (typeof direccion === "undefined") {
            direccion = '';
        }
        self.has_subordinados = true;
        app.api.call("read", this.reporteesEndpoint, {}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }

                if (!_.isEmpty(data.children)) {
                    _.extend(self, {Subordinados: data.children});
                }

                if(_.isEmpty(self.Subordinados)){
                    self.has_subordinados = false;
                }

                var valores = self.getValores();
                $("#anio_filtro").val(anio_actual);
                $("#mes_filtro").val(mes_actual);

                //Persiste las columnas escondidas
                self.columnas_escondidas = [];
                $('.hide_show_col').each(function(){
                    if($(this).prop('checked')){
                        self.columnas_escondidas.push($(this).prop("id"));
                    }
                });

                var sfa_options = {
                    user_id: app.user.get('id'),
                    data_source: 'operaciones',
                    subordinados: self.Subordinados,
                    mes: $("#mes_filtro").val(),
                    anio: $("#anio_filtro").val(),
                    region: $("#region_filtro").val(),
                    tipo_operacion: $("#tipo_operacion_filtro").val(),
                    etapa: $("#etapa_filtro").val(),
                    estatus: $("#estatus_filtro").val(),
                    equipo: $("#equipo_filtro").val(),
                    promotor: $("#promotor_filtro").val(),
                    progreso: $("#progreso_filtro").val(),
                    sortBy: ordenarPor,
                    sortByDireccion: direccion,
                }

                var backlogUrl = app.api.buildURL("BacklogDashlet", '', {}, {});
                app.api.call("create", backlogUrl, {data: sfa_options}, {
                    success: _.bind(function (data) {
                        if (self.disposed) {
                            return;
                        }

                        self.backlogs = data;
                        _.extend(this, self.backlogs);

                        if(data.backlogs.RoleView == 'Full_Access'){
                            self.access = 'Full_Access';
                        }

                        //genera las listas de equipos
                        self.getEquipos();

                        var Access = data.backlogs.RoleView;
                        self.rolAutorizacion = data.backlogs.RolAutorizacion;
                        //GetPromotores
                        var Params = {
                            Access: Access,
                            equipo: $("#equipo_filtro").val(),
                            mes: $("#mes_filtro").val(),
                        };
                        var Url = app.api.buildURL("BacklogPromotores", '', {}, {});
                        app.api.call("create", Url, {data: Params}, {
                            success: _.bind(function (data) {
                                if (self.disposed) {
                                    return;
                                }
                                self.promotores_list_html = data;
                                self.render();
                                $(".loadingIcon").hide();
                                if(app.alert.get('loadingRender') !=undefined){
                                    app.alert.dismiss('loadingRender');
                                }
                                setTimeout(function(){
                                  self.setValores(valores);
                                  $("#anio_filtro").val(anio_actual);
                                  $("#mes_filtro").val(mes_actual);
                                }, 100);
                            })
                        });
                        //END GetPromotores
                    })
                });
            })
        });
    },

    getActualBacklog: function(){
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();

        if(currentDay <= 20){
            currentMonth += 1;
        }
        if(currentDay > 20){
            currentMonth += 2;
        }

        if (currentMonth > 12){  //Si resulta mayor a diciembre
            currentMonth = currentMonth - 12;
        }

        return currentMonth;
    },

    seleccionarBacklog: function(e){
        if($(e.target).attr("checked")){
            this.seleccionados.push($(e.target).val());
        }else{
            var itemToRemove = $(e.target).val();
            var seleccionadosClone = this.seleccionados;
            var seleccionadosCleaned = [];
            this.seleccionados = [];
            $(seleccionadosClone).each(function( index,value ) {
                if(value != itemToRemove){
                    seleccionadosCleaned.push(value);
                }
            });
            this.seleccionados = seleccionadosCleaned;
        }
    },

    seleccionarTodo: function(){
        if ($('#mass_update_btn').is(':checked')) {
            var seleccionarTodo = [];
            $('.mass_update').each(function (index, value) {

                if($(this).prop("disabled")) {
                    return;
                }
                seleccionarTodo.push($(this).val());
                $(this).prop('checked', true);
            });
        } else {
            $('.mass_update').each(function (index, value) {
                if($(this).prop("disabled")) {
                    return;
                }
                seleccionarTodo = [];
                $(this).prop('checked', false);
            });
        }
        this.seleccionados = seleccionarTodo;
    },

    getEquipos:function() {
        var Params = {
            Access: self.access,
        };
        var Url = app.api.buildURL("BacklogEquipos", '', {}, {});
        app.api.call("create", Url, {data: Params}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }
                self.equipo_list_html = data;
                self.render();
            })
        });
    },

    obtenerBacklogColumnas: function(){
        var options = $('#sel_columnas option');
        var values = $.map(options ,function(option) {
            return option.value;
        });
        //ObtenerBacklogColumnas
        var Params = {
            values: values,
        };
        var Url = app.api.buildURL("ObtenerBacklogColumnas", '', {}, {});
        app.api.call("create", Url, {data:Params}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }
                self.seleccionarColumnas = data;
            })
        });
        //END ObtenerBacklogColumnas
    },

    marcarCasillas: function () {
        console.log("seleccionarTodo");
        if($('input[id="selectAll"]').attr('checked')){
            $('input[type="checkbox"]').attr('checked', true);
        }else{
            $('input[type="checkbox"]').attr('checked', false);
        }
    },

    SetMenuOptions: function () {
        var checks = $('input[type="checkbox"]');
        var active = false;
        for (var i = 0; i < checks.length; i++) {
            if(checks[i].checked == true){
                active = true;
            }
        }
        if (active == true) {
            $("#menuOptions").removeClass('disabled');
        }else {
            $("#menuOptions").addClass("disabled");
        }
    },

    recalcularPromotores:function(){
        var valores = this.getValores();
        var Params = {
            Access: self.access,
            equipo: $("#equipo_filtro").val(),
            mes: $("#mes_filtro").val(),
        };
        var Url = app.api.buildURL("BacklogPromotores", '', {}, {});
        app.api.call("create", Url, {data: Params}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }
                 self.promotores_list_html = data;
                 self.render();
                 self.setValores(valores);
            })
        });
    },

    crearBacklog: function(){
      var model=app.data.createBean('lev_Backlog');
      app.drawer.open({
        layout: 'create',
        context: {
          create: true,
          module: 'lev_Backlog',
          model: model
        },
      }, function(){
         location.reload();
      });
    },

    ordenarPorEquipo: function(){
        var valores = this.getValores();
        var sortedObjs = [];
        if(this.EquipoSortDirection == 'DESC'){
            this.EquipoSortDirection = 'ASC';
            sortedObjs = _.sortBy(this.backlogs.backlogs.MyBacklogs.linea, 'equipo');
        }else{
            this.EquipoSortDirection = 'DESC';
            sortedObjs = _.sortBy(this.backlogs.backlogs.MyBacklogs.linea, 'equipo').reverse();
        }
        this.backlogs.backlogs.MyBacklogs.linea = sortedObjs;
        this.render();
        this.setValores(valores);
    },
    
    ordenarPorPromotor: function(){
        var valores = this.getValores();
        var sortedObjs = [];
        if(this.PromotorSortDirection == 'DESC'){
            this.PromotorSortDirection = 'ASC';
            sortedObjs = _.sortBy(this.backlogs.backlogs.MyBacklogs.linea, 'promotor');
        }else{
            this.PromotorSortDirection = 'DESC';
            sortedObjs = _.sortBy(this.backlogs.backlogs.MyBacklogs.linea, 'promotor').reverse();
        }
        this.backlogs.backlogs.MyBacklogs.linea = sortedObjs;
        this.render();
        this.setValores(valores);
    },

    ordenarPorCliente: function(){
        var valores = this.getValores();
        var sortedObjs = [];
        if(this.ClienteSortDirection == 'DESC'){
            this.ClienteSortDirection = 'ASC';
            sortedObjs = _.sortBy(this.backlogs.backlogs.MyBacklogs.linea, 'cliente');
        }else{
            this.ClienteSortDirection = 'DESC';
            sortedObjs = _.sortBy(this.backlogs.backlogs.MyBacklogs.linea, 'cliente').reverse();
        }
        this.backlogs.backlogs.MyBacklogs.linea = sortedObjs;
        this.render();
        this.setValores(valores);
    },

    ordenarPorNumeroBacklog: function(){
        var valores = this.getValores();
        var sortedObjs = [];
        if(this.NumeroBacklogSortDirection == 'DESC'){
            this.NumeroBacklogSortDirection = 'ASC';
            sortedObjs = _.sortBy(this.backlogs.backlogs.MyBacklogs.linea, 'numero_de_backlog');
        }else{
            this.NumeroBacklogSortDirection = 'DESC';
            sortedObjs = _.sortBy(this.backlogs.backlogs.MyBacklogs.linea, 'numero_de_backlog').reverse();
        }
        this.backlogs.backlogs.MyBacklogs.linea = sortedObjs;
        this.render();
        this.setValores(valores); 
    },

    ordenarPorMontoOperacion: function(){
        var valores = this.getValores();
        var sortedObjs = [];
        if(this.MontoOperacionSortDirection == 'DESC'){
            this.MontoOperacionSortDirection = 'ASC';
            sortedObjs = _.sortBy(this.backlogs.backlogs.MyBacklogs.linea, 'monto_original');
        }else{
            this.MontoOperacionSortDirection = 'DESC';
            sortedObjs = _.sortBy(this.backlogs.backlogs.MyBacklogs.linea, 'monto_original').reverse();
        }
        this.backlogs.backlogs.MyBacklogs.linea = sortedObjs;
        this.render();
        this.setValores(valores);
    },

    ordenarPorMontoFinal: function(){
        var valores = this.getValores();
        var sortedObjs = [];
        if(this.MontoFinalSortDirection == 'DESC'){
            this.MontoFinalSortDirection = 'ASC';
            sortedObjs = _.sortBy(this.backlogs.backlogs.MyBacklogs.linea, 'monto_final_comprometido');
        }else{
            this.MontoFinalSortDirection = 'DESC';
            sortedObjs = _.sortBy(this.backlogs.backlogs.MyBacklogs.linea, 'monto_final_comprometido').reverse();
        }
        this.backlogs.backlogs.MyBacklogs.linea = sortedObjs;
        this.render();
        this.setValores(valores);
    },
    
    getValores: function(){
      var valores = {
         tempMes: $("#mes_filtro").val(),
         tempAnio: $("#anio_filtro").val(),
         tempEquipo: $("#equipo_filtro").val(),
         tempPromotor: $("#promotor_filtro").val(),
         tempSolicitud: $("#progreso_filtro").val(),
         tempTipoOperacion: $("#tipo_operacion_filtro").val(),
         tempEtapa: $("#etapa_filtro").val(),
         tempEstatus: $("#estatus_filtro").val()
      }
      return valores;
    },

    setValores: function(valores){
         $("#mes_filtro").val(valores.tempMes);
         $("#anio_filtro").val(valores.tempAnio);
         $("#equipo_filtro").val(valores.tempEquipo);
         $("#promotor_filtro").val(valores.tempPromotor);
         $("#progreso_filtro").val(valores.tempSolicitud);
         $("#tipo_operacion_filtro").val(valores.tempTipoOperacion);
         $("#etapa_filtro").val(valores.tempEtapa);
         $("#estatus_filtro").select2('val' ,valores.tempEstatus);
    },
})