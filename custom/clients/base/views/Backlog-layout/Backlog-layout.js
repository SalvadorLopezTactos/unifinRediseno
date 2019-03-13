/**
 * Created by Salvador Lopez on 13/03/2019.
 * User: salvador.lopez@tactos.com.mx
 * Reestructura de layout backlog
 */

 ({
    plugins: ['Dashlet'],

    //array_checks:null,
    //checks_actualizar:null,
    //checks_no_actualizar:null,

    events: {
        'click #btn_Buscar': 'cargarBacklogsButton',
        'change #mass_update_btn': 'seleccionarTodo',
        'click .mass_update': 'seleccionarBacklog',
        'click .marcarTodos': 'marcarCasillas',
        'change .checkboxChange': 'SetMenuOptions'
    },

    initialize: function (options) {
        self = this;
        //Actualizar esta variable para cerrar los periodos de Backlog a Petición del usuario
        //1 = Mes cerrado --- 0 = Mes abierto
        self.mesNaturalCerrado = 0;

        this.reporteesEndpoint = app.api.buildURL('Forecasts', 'orgtree/' + app.user.get('id'), null, {'level': 10});

        this._super("initialize", [options]);

        var estatus_list = app.lang.getAppListStrings('estatus_de_la_operacion_list');

        var estatus_list_html = '<option value=""></option>';
        for (estatus_keys in estatus_list) {
            estatus_list_html += '<option value="' + estatus_keys + '">' + estatus_list[estatus_keys] + '</option>'

        }
        this.estatus_list_html = estatus_list_html;


    },

    loadData: function (options) {
        if (_.isUndefined(this.model)) {
            return;
        }
        var self = this;

        self.obtenerBacklogColumnas();
        this.cargarBacklogs('','');
    },

    cargarBacklogsButton: function(){
        this.cargarBacklogs('','');
    },

    cargarBacklogs: function(ordenarPor, direccion){

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
                    //_.each(data.children, self.getSubordinadoOperaciones);
                }

                if(_.isEmpty(self.Subordinados)){
                    self.has_subordinados = false;
                }

                console.log("Anio asignado: " + $("#anio_filtro").val());
                if(_.isEmpty($("#anio_filtro").val())){
                    console.log("Anio vacio, se asignara: " + (new Date).getFullYear());
                    $("#anio_filtro").val((new Date).getFullYear());
                }

                if(_.isEmpty($("#mes_filtro").val())){
                    $("#mes_filtro").val(self.getActualBacklog());
                }

                if(_.isEmpty($("#equipo_filtro").val())){
                    $("#equipo_filtro").val(self.defaultEquipo);
                }

                var tempMes = $("#mes_filtro").val();
                var tempAnio = $("#anio_filtro").val();
                var tempRegion = $("#region_filtro").val();
                var tempTipoOperacion = $("#tipo_operacion_filtro").val();
                var tempEtapa = $("#etapa_filtro").val();
                var tempProgreso = $("#progreso_filtro").val();

                /*
                 if(_.isEmpty($("#estatus_filtro").val())){
                 $("#estatus_filtro").val('Comprometida');
                 console.log("jsr aquí");
             }*/
             var tempEstatus = $("#estatus_filtro").val();

             var tempEquipo = $("#equipo_filtro").val();
             var tempPromotor = $("#promotor_filtro").val();

             var backlog_mes = $('#mes_record').val();
             var backlog_anio = $('#anio_record').val();

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
                    mes: "3",
                    anio: "2019",
                    region: undefined,
                    tipo_operacion: "",
                    etapa: "",
                    estatus: null,
                    equipo: null,
                    promotor: null,
                    progreso: "",
                    sortBy: "",
                    sortByDireccion: "",
                }

                var backlogUrl = app.api.buildURL("BacklogDashlet", '', {}, {});
                app.api.call("create", backlogUrl, {data: sfa_options}, {
                    success: _.bind(function (data) {
                        if (self.disposed) {
                            return;
                        }

                        _.extend(self, {backlogs: data});

                        if(data.backlogs.RoleView == 'Full_Access'){
                            self.access = 'Full_Access';
                        }

                        //genera las listas de equipos
                        self.getEquipos();

                        var Access = data.backlogs.RoleView;
                        self.rolAutorizacion = data.backlogs.RolAutorizacion;
                        //GetPromotores
                        var Params = {
                            Access: "Full_Access",
                            equipo: null,
                            mes: "3",
                        };
                        var Url = app.api.buildURL("BacklogPromotores", '', {}, {});
                        app.api.call("create", Url, {data: Params}, {
                            success: _.bind(function (data) {
                                if (self.disposed) {
                                    return;
                                }

                                var promotores_list_html = '';

                                //WARP:  Ajustes Backlog Todos
                                promotores_list_html += '<option value="Todos">Todos</option>';
                                console.log('promotores_list_html.cargarBacklogs');

                                /*
                                 if(self.access == 'Full_Access' || self.has_subordinados == true){
                                 promotores_list_html += '<option value="Todos">Todos</option>';
                                 }
                                 */

                                 _.each(data, function(key, value) {
                                    promotores_list_html += '<option value="' + value + '">' + key + '</option>';
                                });

                                 self.promotores_list_html = promotores_list_html;

                                 self.render();
                                //var temp=_.isEmpty(self.array_checks) ? self.array_checks_cancelar:self.array_checks;

                                //autopopula los campos de mes y anio en el popup de Comprometer;
                                $('#mes_a_comprometer_popup').val(backlog_mes).change();
                                $('#anio_a_comprometer_popup').val(backlog_anio).change();

                                $('#mes_a_comprometer_mass_popup').val(tempMes).change();
                                $('#anio_a_comprometer_mass_popup').val(tempAnio).change();

                                $(".loadingIcon").hide();

                                if(app.alert.get('loadingRender') !=undefined){
                                    app.alert.dismiss('loadingRender');
                                }
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

        // console.log(this.seleccionados);
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
        // console.log(this.seleccionados);
    },

    getEquipos:function() {

        var tempMes = $("#mes_filtro").val();
        var tempAnio = $("#anio_filtro").val();
        var tempRegion = $("#region_filtro").val();
        var tempTipoOperacion = $("#tipo_operacion_filtro").val();
        var tempEtapa = $("#etapa_filtro").val();
        var tempEstatus = $("#estatus_filtro").val();
        var tempEquipo = $("#equipo_filtro").val();
        var tempProgreso = $("#progreso_filtro").val();

        //GetEquipos
        var Params = {
            Access: self.access,
        };
        var Url = app.api.buildURL("BacklogEquipos", '', {}, {});
        app.api.call("create", Url, {data: Params}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }

                var equipo_list_html = '';

                var count = 0;
                _.each(data, function (key, value) {
                    count++;
                });

                if (count >= 2) {
                    equipo_list_html += '<option value="Todos">Todos</option>';
                }
                _.each(data, function (key, value) {
                    //equipo_list_html += '<option value="' + value + '">' + key + '</option>';
                    equipo_list_html += '<option value="' + key + '">' + key + '</option>';
                });

                self.equipo_list_html = equipo_list_html;

                self.render();
            })
        });
        //END GetEquipos2
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
        //$('input[type="checkbox"]').attr('checked', false);
    },

    SetMenuOptions: function () {
        //console.log("SetMenuOptions");
        //Recupera checks
        var checks = $('input[type="checkbox"]');

        //Proecsa para validar
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
})
