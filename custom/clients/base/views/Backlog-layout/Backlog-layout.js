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
        'change #equipo_filtro': 'recalcularPromotores',
        'click .exportar': 'exportarXL',

        //Nuevos eventos para ocultar columnas
        'click .ocultar_columnas': 'ocultarColumnas',
        'click #btn_ejecuta_ocultar_columnas': 'ejecutaOcultarColumnas',
        'click #btn_cancela_ocultar_columnas': 'ocultaModal',

        //Nuevos eventos para mover mes
        'click .MoverOperacion': 'moverOperacion',
        'click #btn-GuardarMover':'moverMes',


        //Nuevos eventos de comentarios en Modal
        'click .updateComentario': 'comentarioNew',
        'click .btn-danger': 'ocultaModal',
        'click .close': 'ocultaModal',
        'click  #btn-Guardar': 'GuardaComentario',
        //Nuevos eventos de Revivir en Modal
        'click .updateRevivir':'revivirNew',
        'click #btn-CancelarRe':'ocultaRevivir',
        'click #btn-GuardarRe':'guardaRevivir',
        'click .closeRe': 'ocultaRevivir',
        'change #anio_revivir':'fecha',

        //Eventos para filtros
        'change .filtros': 'updateFilters',
        
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
        //Objetos de comentario y revivir
        this.newComentario='';
        this.newRevivir='';
        this.anioRevivir='';
        this.mesRevivir='';
        //Variables para filtros
        this.mes_filtro = ((new Date).getMonth()+1).toString();
        this.anio_filtro = ((new Date).getFullYear()).toString();
        this.equipo_filtro = "";
        this.promotor_filtro = "";
        this.progreso_filtro = "";
        this.tipo_operacion_filtro = "";
        this.etapa_filtro = "";
        this.estatus_filtro = "";
        this.progreso_list_html[''] = "";
        this.tipo_operacion_list_html[''] = "";
        this.etapa_list_html[''] = "";
        this.estatus_list_html[''] = "";
        //Variable para total de registros
        this.totalRegistros = 0;
        


    },

    loadData: function (options) {
        if (_.isUndefined(this.model)) {
            return;
        }
        var self = this;
        this.meses_list_html = app.lang.getAppListStrings('mes_list');
        var anio_list = app.lang.getAppListStrings('anio_list');
        var currentYear = new Date().getFullYear();
        Object.keys(anio_list).forEach(function(key){
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
                //$("#anio_filtro").val(anio_actual);
                //$("#mes_filtro").val(mes_actual);

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
                        self.totalRegistros = (data.backlogs.MyBacklogs == null)? 0 : Object.keys(self.backlogs.backlogs.MyBacklogs.linea).length;
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
                                self.promotores_list_html[""]="Todos"
                                self.render();
                                $(".loadingIcon").hide();
                                if(app.alert.get('loadingRender') !=undefined){
                                    app.alert.dismiss('loadingRender');
                                }
                                //Persistiendo anio y mes
                                //$("#anio_filtro").val(anio_actual);
                                //$("#mes_filtro").val(mes_actual);

                                /*
                                setTimeout(function(){
                                  self.setValores(valores);
                                  $("#anio_filtro").val(anio_actual);
                                  $("#mes_filtro").val(mes_actual);
                                }, 100);
                                */
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

     ocultarColumnas:function(){
         console.log(self.rolAutorizacion);
         if(self.rolAutorizacion != "DGA"){
             app.alert.show('periodo_de_aprobacion', {
                 level: 'error',
                 messages: 'No cuenta con privilegios para modificar la estructura del tablero.',
                 autoClose: false
             });
             return;
         }
         //Mostrar modal
         var modalCols = $('#myModalHideCols');
         modalCols.show();

     },

    exportarXL: function () {
        var anio_actual = $("#anio_filtro").val();
        var mes_actual = $("#mes_filtro").val();
        this.cargarBacklogs('','',anio_actual,mes_actual);
         var backlog_options = {
             'backlogs': this.backlogs,
         }

         var backlogUrl = app.api.buildURL("CrearArchivoCSV", '', {}, {});
         app.api.call("create", backlogUrl, {data: backlog_options}, {
             success: _.bind(function (data) {
                 //window.open("#bwc/index.php?entryPoint=exportarBacklog&backlog_doc=" + data);
                 var blDownCSV = app.api.buildURL("ExportBL/"+data, '', {}, {});

                 app.api.call('GET', blDownCSV,{}, {
                     success: _.bind(function (response) {
                         var element = document.createElement('a');
                         var href = 'data:text/csv;charset=UTF-8,' + encodeURI(response[0]);
                         element.setAttribute('href', href);
                         element.setAttribute('target','_blank');
                         element.setAttribute('download', response[1]);
                         element.style.display = 'none';
                         document.body.appendChild(element);

                         element.click();

                         document.body.removeChild(element);
                     }, self),
                 });

                 if (self.disposed) {
                     return;
                 }

                 // console.log(data);
                 _.extend(self, {backlogs: data});

             })
         });
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
                self.equipo_list_html[""]="Todos"
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
                 self.promotores_list_html[""]="Todos"
                 self.render();
                 //self.setValores(valores);
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
        //this.setValores(valores);
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
        //this.setValores(valores);
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
        //this.setValores(valores);
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
        //this.setValores(valores); 
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
        //this.setValores(valores);
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
        //this.setValores(valores);
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
         //$("#mes_filtro").val(valores.tempMes);
         //$("#anio_filtro").val(valores.tempAnio);
         $("#equipo_filtro").val(valores.tempEquipo);
         $("#promotor_filtro").val(valores.tempPromotor);
         $("#progreso_filtro").val(valores.tempSolicitud);
         $("#tipo_operacion_filtro").val(valores.tempTipoOperacion);
         $("#etapa_filtro").val(valores.tempEtapa);
         $("#estatus_filtro").select2('val' ,valores.tempEstatus);
    },

     ejecutaOcultarColumnas:function(){

         var options = $('#sel_columnas option');
         var values = $.map(options ,function(option) {
             return option.value;
         });

         _.each(values, function(key, value) {

             $('#' + key).show();
             $('.' + key).show();
         });

         $('.hide_show_col').each(function(){
             $(this).prop('checked', false);
             $('.' + $(this).prop("id")).show();
             $('#' + $(this).prop("id")).show();
         });

         $('#myModalHideCols').hide();
         var coldata = $('#sel_columnas').val();
         _.each(coldata, function(key, value) {

             $('#' + key).hide();
             $('.' + key).hide();
         });
         //self.floatHeader();

         //BacklogColumns
         var Params = {
             columnas: coldata,
             values: values,
         };
         var Url = app.api.buildURL("BacklogColumns", '', {}, {});
         app.api.call("create", Url, {data: Params}, {
             success: _.bind(function (data) {
                 if (self.disposed) {
                     return;
                 }

                 self.obtenerBacklogColumnas();
                 //self.floatHeader();
             })
         });
         //END BacklogColumns
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

     moverOperacion:function(e){

         var idBacklog=e.currentTarget.getAttribute('data-id');
         var backlog=self.backlogs.backlogs.MyBacklogs.linea[idBacklog];
         this.newMoverMes={
             "idBacklog":idBacklog,
             "nameBacklog":backlog.name,
             "montoOriginalBacklog":backlog.monto_comprometido,
             "montoRealBacklog":backlog.monto_real,
             "comentariosExistentes":backlog.comentarios,
             "comentarioNuevo":"",
         };

         //Valores default año y mes
         this.anio_filtro_popup_mover = ((new Date).getFullYear()).toString();
         this.mes_filtro_mover_op=((new Date).getMonth()+1).toString();

         //Listas generadas para año y mes
         var lista_mes_anio=this.getMonthYear();
         this.anio_list_html_mover=lista_mes_anio['anio'];

         this.meses_list_html=lista_mes_anio['mes'];


         self.render();

         var modalMover = $('#myModalMover');
         modalMover.show();

     },

     moverMes:function () {

         var tempMes = $("#mes_filtro").val();
         var tempAnio = $("#anio_filtro").val();

         var mes_popup = $('.mes_switch_popup').val();
         var anio_popup = $('.anio_switch_popup').val();
         var current_backlog = $('#mes_filtro').val();


         if(_.isEmpty(anio_popup)){
             app.alert.show('anio requerido', {
                 level: 'error',
                 messages: 'Favor de completar la informacion.',
                 autoClose: false
             });
             return;
         }

         //Validar que la Persona de Backlog no cuente con Backlogs en el mismo mes
         var idBacklog=this.newMoverMes.idBacklog;
         //Obteniendo id de persona
         var bl=$('.MoverOperacion[data-id="'+idBacklog+'"]');
         var str=bl.closest('tr').children('.hide_cliente').children('a').attr('href');

         var num_bl=bl.closest('tr').children('.hide_operacion').children('a').text();

         var arr_p=str.split('#Accounts/');

         var id_account=arr_p[1];

         var bl_url = app.api.buildURL('lev_Backlog?filter[0][account_id_c][$equals]='+id_account+'&filter[1][mes][$equals]='+mes_popup+'&filter[2][anio][$equals]='+anio_popup+'&filter[3][estatus_de_la_operacion][$not_equals]=Cancelada&fields=id,mes,estatus_de_la_operacion',
             null, null, null);

         //Notificacion de inicio de proceso
         app.alert.show('moverAlert', {
             level: 'process',
             title: 'Cargando, por favor espere.',
         });

         app.api.call('GET', bl_url, {}, {
             success: _.bind(function (data) {

                 var meses =['0','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
                 if(data.records.length>0){
                     app.alert.dismiss('moverAlert');
                     app.alert.show('error_bl_mes', {
                         level: 'error',
                         messages: 'Esta Cuenta ya posee un backlog en el mes: '+meses[data.records[0].mes],
                         autoClose: false
                     });
                     return;

                 }else{
                     var Url = app.api.buildURL("UpdateFechaBl", '', {}, {});
                     var Params = {
                         "bl":num_bl,
                         "mesActual":tempMes,
                         "anioActual":tempAnio,
                         "mesNuevo":mes_popup,
                         "anioNuevo":anio_popup
                     };
                     app.api.call("create", Url, {data: Params}, {
                         success: _.bind(function (data) {
                             this.moverOpAfterValidateIndividual(mes_popup,anio_popup,tempMes,tempAnio);

                         },this)
                     });
                 }

             },this)

         });

     },

     moverOpAfterValidateIndividual:function(mes_popup,anio_popup,tempMes,tempAnio){
         var currentYear = (new Date).getFullYear();
         var currentMonth = (new Date).getMonth();
         var currentDay = (new Date).getDate();
         var tipo_opp = '';
         var periodo_revision = false;
         var access = $('#access').val();
         //currentMonth += 1;

         if(currentDay <= 20){
             currentMonth += 1;
         }
         if(currentDay > 20){
             currentMonth += 2;
         }

         if (currentMonth > 12){  //Si resulta mayor a diciembre
             currentMonth = currentMonth - 12;
         }

         if(anio_popup <= currentYear){
             if(mes_popup > currentMonth){
                 tipo_opp = "Original";
             }
             else if(mes_popup == currentMonth){
                 tipo_opp = "Adicional";
             }else{
                 tipo_opp = "Adicional";
             }
         }else{
             tipo_opp = "Original";
         }
         // CVV regresar a 20
         if(currentDay >= 15 && currentDay <= 19){
             periodo_revision = true;
         }

         var Params = {
             'backlogId': this.newMoverMes.idBacklog,
             'backlogName': this.newMoverMes.nameBacklog,
             'mes_popup': mes_popup,
             'anio_popup': anio_popup,
             'tipo_operacion': tipo_opp,
             'periodo_revision': periodo_revision,
             'access': access,
             'monto_comprometido': $('#monto_mes').html(),
             'rolAutorizacion': self.rolAutorizacion,
             'MesAnterior': tempMes,
             'AnioAnterior': tempAnio,
         };
         var Url = app.api.buildURL("MoverOperacion", '', {}, {});
         app.api.call("create", Url, {data: Params}, {
             success: _.bind(function (data) {
                 if (self.disposed) {

                     app.alert.dismiss('moverAlert');
                     return;
                 }

                 if(!_.isEmpty(data)){
                     alert(data);
                 }
                 $('#btn-Cancelar').prop('disabled',false);
                 $('#btn-GuardarMover').prop('disabled',false);
                 app.alert.dismiss('moverAlert');
                 self.ocultaModal();
                 self.cargarBacklogsButton();
                 self.render();
             },this)
         });
     },

     getMonthYear:function () {

         var currentMonth = (new Date).getMonth()+1;
         var currentYear = new Date().getFullYear();
         var anio_popup =  new Date().getFullYear();;
         //Valida número de mes actual
         var limitMonth = currentMonth + 2;
         var nextMonth = 0;
         var nextYear = currentYear;
         if (limitMonth > 12) {
             nextMonth = limitMonth - 12;
             nextYear = currentYear + 1;
         }
         var opciones_year= app.lang.getAppListStrings('anio_list');
         Object.keys(opciones_year).forEach(function(key){
             //Quita años previos
             if(key < currentYear){
                 delete opciones_year[key];
             }
             //Habilita años futuros
             if(key > nextYear){
                 delete opciones_year[key];
             }
         });


         var opciones_mes = app.lang.getAppListStrings('mes_list');
         //Quita mese para año futuro
         if(anio_popup > currentYear){
             Object.keys(opciones_mes).forEach(function(key){
                 if(key != ''){
                     if(key > nextMonth){
                         delete opciones_mes[key];
                     }
                 }
             });
         }
         //Quita meses para año actual
         if(anio_popup == currentYear || anio_popup ==""){
             Object.keys(opciones_mes).forEach(function(key){
                 if(key != ''){
                     //Quita meses fuera de rango(3 meses)
                     if(key < currentMonth || key >limitMonth ){
                         delete opciones_mes[key];
                     }
                 }
             });
         }

         var arr_return=[];
         arr_return['anio']=opciones_year;
         arr_return['mes']=opciones_mes;

         return arr_return;

     },

    //Nuevas Funciones Comentario
    comentarioNew:function(e){
        var idBacklog=e.currentTarget.getAttribute('data-id');
        var backlog=self.backlogs.backlogs.MyBacklogs.linea[idBacklog];
        this.newComentario={
            "idBacklog":idBacklog,
            "nameBacklog":backlog.name,
            "montoOriginalBacklog":backlog.monto_comprometido,
            "montoRealBacklog":backlog.monto_real,
            "comentariosExistentes":backlog.comentarios,
            "comentarioNuevo":"",
        };
        self.render();
            var modal = $('#myModal');
            modal.show();
    },
    
    ocultaModal:function(){
        //Modal Ocultar columnas
        var modalCol=$('#myModalHideCols');
        modalCol.hide();

        //Modal Mover Operación
        var modalMover=$('#myModalMover');
        modalMover.hide();

        //Modal comentarios
        var modal = $('#myModal');
        modal.hide();


    },

    //Para guardar con nuevo metodo
    GuardaComentario:function(){
        //Recuperar variables de Comentario
        var description = $('#AddDescrip').val();
        var Params = {
            'backlogId': this.newComentario.idBacklog,
            'backlogName': this.newComentario.nameBacklog,
            'description': description,
        };
        //Validar existencia de comentario
        if( description == null || description == "" || description.trim().length ==0 ) {
            app.alert.show('alertcom', {
                level: 'error',
                messages: 'Favor de agregar un comentario.',
                autoClose: true
            });
            return;
       }

       $('#btn-Cancelar').prop('disabled',true);
       $('#btn-Guardar').prop('disabled',true);
        //Notificacion de inicio de proceso
        app.alert.show('ComentAlert', {
            level: 'process',
            title: 'Cargando, por favor espere.',
        });
       //Generar Peticion para guardar comentario
        var Url = app.api.buildURL("BacklogComentarios", '', {}, {});
        app.api.call("create", Url, {data: Params}, {
            success: _.bind(function (data) {
                self.backlogs.backlogs.MyBacklogs.linea[self.newComentario.idBacklog].comentarios=data;
                self.backlogs.backlogs.MyBacklogs.linea[self.newComentario.idBacklog].comentado="fa-comment";
                $('#btn-Cancelar').prop('disabled',false);
                $('#btn-Guardar').prop('disabled',false);
                app.alert.dismiss('ComentAlert');
                self.ocultaModal();
                self.render();
            },this),
            error:function(error){
                $('#btn-Cancelar').prop('disabled',false);
                $('#btn-Guardar').prop('disabled',false);
                app.alert.dismiss('ComentAlert');
                app.alert.show('errorAlert', {
                    level: 'error',
                    messages: error,
                    autoClose: true
                });
            }
        }); 
    },
    
    fecha:function(){
        //Muestra de año
        var self=this;
        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentMonthTemp = (new Date).getMonth();
        var currentDay = (new Date).getDate();
        var limitMonth = currentMonth + 3;
        var nextMonth = 0;
        var nextYear = currentYear;
        var anio_popup=$('#anio_revivir').val();

        if (limitMonth > 12) {
            nextMonth = limitMonth - 12;
            nextYear = currentYear + 1;
        }

        currentMonth = currentMonthTemp +1;
        this.anioRevivir = app.lang.getAppListStrings('anio_list');
        Object.keys(this.anioRevivir).forEach(function(key){
            //Quita años previos
            if(key < currentYear){
                delete self.anioRevivir[key];
            }
            //Habilita años futuros
            if(key > nextYear){
                delete self.anioRevivir[key];
            }
        });

        //Muestra de meses 
        this.mesRevivir = app.lang.getAppListStrings('mes_list');
        //Quita meses para año futuro
        if(anio_popup > currentYear){
            Object.keys(this.mesRevivir).forEach(function(key){
                if(key != ''){
                    if(key > nextMonth){
                        delete self.mesRevivir[key];
                    }
                }
            });
        }
        //Quita meses para año actual
        if(anio_popup == currentYear || anio_popup ==""){
            Object.keys(this.mesRevivir).forEach(function(key){
                if(key != ''){
                    //Quita meses fuera de rango(3 meses)
                    if(key < currentMonth || key >limitMonth ){
                        delete self.mesRevivir[key];
                    }
                }
            });
        }
    },
    //Nuevas funciones Revivir
    revivirNew:function(e){
        this.fecha();        
        var idBacklog=e.currentTarget.getAttribute('data-id');
        //var mes=e.currentTarget.getAttribute('data-mes');
        //var anio=e.currentTarget.getAttribute('data-anio');
        var backlog=self.backlogs.backlogs.MyBacklogs.linea[idBacklog];

        this.newRevivir={
            "idBacklog":idBacklog,
            "nameBacklog":backlog.name,
            "montoOriginalBacklog":backlog.monto_comprometido,
            "rentaInicialOriginal":backlog.ri_comprometida,
            "status":backlog.estatus_de_la_operacion,
            "mesBacklog":backlog.mes_int,
            "anioBacklog":"20"+backlog.anio
        };
        if (backlog.estatus_de_la_operacion != 'Cancelada'){
           app.alert.show('Operacion Activa', {
               level: 'error',
               messages: 'Unicamente pueden revivirse operaciones canceladas.',
               autoClose: false
            });
           return;
        }


        self.render();
        var modal = $('#myModalRe');
        modal.show();
    },

    ocultaRevivir:function(){
        var modal = $('#myModalRe');
        modal.hide();        
    },
    
    guardaRevivir:function(){
        var mes = $('#mes_revivir').val();
        var anio = $('#anio_revivir').val();
        var comentarios=$('#ComentarioRev').val();
        var Params = {
           'backlogId':this.newRevivir.idBacklog,
           'backlogName': this.newRevivir.backlogName,
           'Monto': this.newRevivir.montoOriginalBacklog,
           'RentaInicial': this.newRevivir.rentaInicialOriginal,
           'Comentarios': comentarios,
           'Mes':mes,
           'Anio': anio,
           'MesAnterior': this.newRevivir.mesBacklog,
           'AnioAnterior': this.newRevivir.anioBacklog,
        };
        //Notificacion de inicio de proceso
       app.alert.show('RevivirAlert', {
            level: 'process',
            title: 'Cargando, por favor espere.',
        });
       $('#btn-CancelarRe').prop('disabled',true);
       $('#btn-GuardarRe').prop('disabled',true);

        var Url = app.api.buildURL("RevivirBacklog", '', {}, {});
        app.api.call("create", Url, {data: Params}, {
           success: _.bind(function (data) {
                if(self.newRevivir.mesBacklog==$('#mes_revivir').val() && self.newRevivir.anioBacklog==$('#anio_revivir').val()){
                    self.backlogs.backlogs.MyBacklogs.linea[self.newRevivir.idBacklog].color="#E5FFCC";
                    self.backlogs.backlogs.MyBacklogs.linea[self.newRevivir.idBacklog].estatus_de_la_operacion="Comprometida";
                }
                
                $('#btn-CancelarRe').prop('disabled',false);
                $('#btn-GuardarRe').prop('disabled',false);
                app.alert.dismiss('RevivirAlert');
                self.ocultaRevivir();
                self.render();
            },this),
            error:function(error){
                $('#btn-CancelarRe').prop('disabled',false);
                $('#btn-GuardarRe').prop('disabled',false);
                app.alert.dismiss('RevivirAlert');
                app.alert.show('errorAlertRe', {
                    level: 'error',
                    messages: error,
                    autoClose: true
                });
            }
        }); 
    },

    updateFilters: function(){
        //Función para generar persistencia de variables en filtros
        this.mes_filtro = $("#mes_filtro").val();
        this.anio_filtro = $("#anio_filtro").val();
        if (this.equipo_filtro != $("#equipo_filtro").val()){
            this.equipo_filtro = $("#equipo_filtro").val();
            this.promotor_filtro = "";
        }else{
            this.promotor_filtro = $("#promotor_filtro").val();    
        }
        this.progreso_filtro = $("#progreso_filtro").val();
        this.tipo_operacion_filtro = $("#tipo_operacion_filtro").val();
        this.etapa_filtro = $("#etapa_filtro").val();
        this.estatus_filtro = $('#estatus_filtro').select2('val').toString()
        var rep = /,/gi;
        this.estatus_filtro = (this.estatus_filtro == "")? "": "^"+this.estatus_filtro.replace(rep, "^,^")+"^";

        
        this.render();

    },
})