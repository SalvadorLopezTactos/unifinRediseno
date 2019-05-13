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
        'click #btn-Cancelar':'ocultaModal',

        //Nuevos eventos para mover masivo
        'click .MoverOperacionMasiva': 'moverOperacionMasiva',
        'click #btn-GuardarMoverMasiva':'moverMesMasivo',


        //Nuevos eventos de comentarios en Modal
        'click .updateComentario': 'comentarioNew',
        'click #btn-CancelarComen': 'ocultaModal',
        'click .close': 'ocultaModal',
        'click  #btn-GuardarComen': 'GuardaComentario',
        //Nuevos eventos de Revivir en Modal
        'click .updateRevivir':'revivirNew',
        'click #btn-CancelarRe':'ocultaRevivir',
        'click #btn-GuardarRe':'guardaRevivir',
        'click .closeRe': 'ocultaRevivir',
        'change #anio_revivir':'fecha',

        //Nuevos eventos de cancelar
        'click .updateCancelar':'cancelarNew',
        'click #btn-CanCancelar':'ocultaCancelar',
        'click #btn-GuardarCan':'guardaCancelar',
        'click .closeCancelar':'ocultaCancelar',
        'change #anio_cancelar':'fechaCancelar',
        'change #motivoCancelar':'motivoCancelarC',
        'change .motivoCancelarC':'motivoCancelarC',

        //Nuevos eventos para cancelar masivo
        'click .CancelarMasiva': 'cancelarBacklogMasiva',
        'change #motivoCancelarMasivo': 'motivoCancelacionMasivo',
        'click #btn-GuardarCanMasivo': 'cancelarGuardarBacklogMasivo',

        //Eventos para filtros
        'change .filtros': 'updateFilters'

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
        //Objetos de comentario, revivir, cancerlar
        this.newComentario='';
        this.newRevivir='';
        this.newCancelar='';
        this.anioRevivir='';
        this.mesRevivir='';

        this.anioCancelar='';
        this.mesCancelar='';
        this.motivoCancelar='';
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

        this.anio_filtro_popup_mover='';
        this.mes_filtro_mover_op='';



    },

    loadData: function (options) {
        if (_.isUndefined(this.model)) {
            return;
        }
        var self = this;
        this.meses_list_html = app.lang.getAppListStrings('mes_list');
        this.meses_list_html[""]="Todos";
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
                    asesor: $("#promotor_filtro").val(),
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
      var model = app.data.createBean('lev_Backlog');
      app.drawer.open({
        layout: 'create',
        context: {
          create: true,
          module: 'lev_Backlog',
          model: model,
          mythis: this
        },
      },
      //Función de callback para que persista el contexto 'this' al cerrar drawer de creación de Backlog
      function(context,model){
         self=context.get('mythis');
      });
    },

    ordenarPorEquipo: function(){
        var arreglo = {};
        var sortedObjs = {};
        Object.keys(this.backlogs.backlogs.MyBacklogs.linea).forEach(function(key) {
            self.backlogs.backlogs.MyBacklogs.linea[key].id=key;
        });
        if(this.EquipoSortDirection == 'DESC'){
            this.EquipoSortDirection = 'ASC';
            sortedObjs = _.sortBy(self.backlogs.backlogs.MyBacklogs.linea, 'equipo');
        }else{
            this.EquipoSortDirection = 'DESC';
            sortedObjs = _.sortBy(self.backlogs.backlogs.MyBacklogs.linea, 'equipo').reverse();
        }
        for(var i=0, n=sortedObjs.length; i<n; i++){
            arreglo[sortedObjs[i].id] = sortedObjs[i];
        }
        this.backlogs.backlogs.MyBacklogs.linea = arreglo;
        this.render();
    },

    ordenarPorPromotor: function(){
        var arreglo = {};
        var sortedObjs = {};
        Object.keys(this.backlogs.backlogs.MyBacklogs.linea).forEach(function(key) {
            self.backlogs.backlogs.MyBacklogs.linea[key].id=key;
        });
        if(this.PromotorSortDirection == 'DESC'){
            this.PromotorSortDirection = 'ASC';
            sortedObjs = _.sortBy(self.backlogs.backlogs.MyBacklogs.linea, 'promotor');
        }else{
            this.PromotorSortDirection = 'DESC';
            sortedObjs = _.sortBy(self.backlogs.backlogs.MyBacklogs.linea, 'promotor').reverse();
        }
        for(var i=0, n=sortedObjs.length; i<n; i++){
            arreglo[sortedObjs[i].id] = sortedObjs[i];
        }
        this.backlogs.backlogs.MyBacklogs.linea = arreglo;
        this.render();
    },

    ordenarPorCliente: function(){
        var arreglo = {};
        var sortedObjs = {};
        Object.keys(this.backlogs.backlogs.MyBacklogs.linea).forEach(function(key) {
            self.backlogs.backlogs.MyBacklogs.linea[key].id=key;
        });
        if(this.ClienteSortDirection == 'DESC'){
            this.ClienteSortDirection = 'ASC';
            sortedObjs = _.sortBy(self.backlogs.backlogs.MyBacklogs.linea, 'cliente');
        }else{
            this.ClienteSortDirection = 'DESC';
            sortedObjs = _.sortBy(self.backlogs.backlogs.MyBacklogs.linea, 'cliente').reverse();
        }
        for(var i=0, n=sortedObjs.length; i<n; i++){
            arreglo[sortedObjs[i].id] = sortedObjs[i];
        }
        this.backlogs.backlogs.MyBacklogs.linea = arreglo;
        this.render();
    },

    ordenarPorNumeroBacklog: function(){
        var arreglo = {};
        var sortedObjs = {};
        Object.keys(this.backlogs.backlogs.MyBacklogs.linea).forEach(function(key) {
            self.backlogs.backlogs.MyBacklogs.linea[key].id=key;
        });
        if(this.NumeroBacklogSortDirection == 'DESC'){
            this.NumeroBacklogSortDirection = 'ASC';
            sortedObjs = _.sortBy(self.backlogs.backlogs.MyBacklogs.linea, 'numero_de_backlog');
        }else{
            this.NumeroBacklogSortDirection = 'DESC';
            sortedObjs = _.sortBy(self.backlogs.backlogs.MyBacklogs.linea, 'numero_de_backlog').reverse();
        }
        for(var i=0, n=sortedObjs.length; i<n; i++){
            arreglo[sortedObjs[i].id] = sortedObjs[i];
        }
        this.backlogs.backlogs.MyBacklogs.linea = arreglo;
        this.render();
    },

    ordenarPorMontoOperacion: function(){
        var arreglo = {};
        var sortedObjs = {};
        Object.keys(this.backlogs.backlogs.MyBacklogs.linea).forEach(function(key) {
            self.backlogs.backlogs.MyBacklogs.linea[key].id=key;
        });
        if(this.MontoOperacionSortDirection == 'DESC'){
            this.MontoOperacionSortDirection = 'ASC';
            sortedObjs = _.sortBy(self.backlogs.backlogs.MyBacklogs.linea, 'monto_comprometido');
            sortedObjs.sort(function(a, b) {
              return parseFloat(a.monto_comprometido) - parseFloat(b.monto_comprometido);
            });
        }else{
            this.MontoOperacionSortDirection = 'DESC';
            sortedObjs = _.sortBy(self.backlogs.backlogs.MyBacklogs.linea, 'monto_comprometido').reverse();
            sortedObjs.sort(function(a, b) {
              return parseFloat(b.monto_comprometido) - parseFloat(a.monto_comprometido);
            });
        }
        for(var i=0, n=sortedObjs.length; i<n; i++){
            arreglo[sortedObjs[i].id] = sortedObjs[i];
        }
        this.backlogs.backlogs.MyBacklogs.linea = arreglo;
        this.render();
    },

    ordenarPorMontoFinal: function(){
        var arreglo = {};
        var sortedObjs = {};
        Object.keys(this.backlogs.backlogs.MyBacklogs.linea).forEach(function(key) {
            self.backlogs.backlogs.MyBacklogs.linea[key].id=key;
        });
        if(this.MontoFinalSortDirection == 'DESC'){
            this.MontoFinalSortDirection = 'ASC';
            sortedObjs = _.sortBy(self.backlogs.backlogs.MyBacklogs.linea, 'monto_final_comprometido');
            sortedObjs.sort(function(a, b) {
              return parseFloat(a.monto_final_comprometido) - parseFloat(b.monto_final_comprometido);
            });
        }else{
            this.MontoFinalSortDirection = 'DESC';
            sortedObjs = _.sortBy(self.backlogs.backlogs.MyBacklogs.linea, 'monto_final_comprometido').reverse();
            sortedObjs.sort(function(a, b) {
              return parseFloat(b.monto_final_comprometido) - parseFloat(a.monto_final_comprometido);
            });
        }
        for(var i=0, n=sortedObjs.length; i<n; i++){
            arreglo[sortedObjs[i].id] = sortedObjs[i];
        }
        this.backlogs.backlogs.MyBacklogs.linea = arreglo;
        this.render();
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

        var tempMes = $("#mes_filtro").val();
        var tempAnio = $("#anio_filtro").val();
        var tempRegion = $("#region_filtro").val();
        var tempTipoOperacion = $("#tipo_operacion_filtro").val();
        var tempEtapa = $("#etapa_filtro").val();
        var tempEstatus = $("#estatus_filtro").val();
        var tempEquipo = $("#equipo_filtro").val();
        var backlogId = e.currentTarget.getAttribute('data-id');
        var backlogName = e.currentTarget.getAttribute('data-name');
        var monto = e.currentTarget.getAttribute('data-monto');
        var backlogMes = e.currentTarget.getAttribute('data-mes');
        var backlogAnio = e.currentTarget.getAttribute('data-anio');
        var backlogEstatus = e.currentTarget.getAttribute('data-estatus');
        var tempPromotor = $("#promotor_filtro").val();
        var tempProgreso = $("#progreso_filtro").val();
        var ProgresoBL = e.currentTarget.getAttribute('data-progreso');

        var rolAutorizacion = self.rolAutorizacion;

        var currentYear = (new Date).getFullYear();
        var currentAnioSub= currentYear.toString().substr(-2);
        var currentBacklogMonth = this.backlogMonth();

        if(backlogAnio <= currentAnioSub) {
            // Si el BL ya esta cancelado no puede moverse
            //if(backlogEstatus != 'Activa') {
                if(backlogEstatus == 'Cancelada') {
                //if (currentBacklogMonth >= backlogMes) {
                    app.alert.show('backlog_pasado', {
                        level: 'error',
                        messages: 'Esta operaci\u00F3n no puede moverse debido a que se encuentra ' + backlogEstatus,
                        autoClose: false
                    });
                    return;
                //}
                }else {
                    // No se pueden mover los Backlogs del mes actual BL una vez que ha iniciado
                    var currentDay = (new Date).getDate();
                    var BacklogCorriente = this.getElaborationBacklog();
                    if(backlogAnio <= currentAnioSub){
                        if(backlogMes <= BacklogCorriente && backlogEstatus != 'Cancelada') {
                            if (backlogMes == BacklogCorriente /*&& currentDay > 15*/ && currentDay <= 20){
                                if (currentDay == 21 && rolAutorizacion != "DGA") {
                                    app.alert.show('backlog corriente', {
                                        level: 'error',
                                        messages: 'Esta operaci\u00F3n no puede moverse debido a que se encuentra en periodo de revisi\u00F3n.',
                                        autoClose: false
                                    });
                                    return;
                                }
                            //CVV  se comenta para permitir mover BL comprometidos hasta el 20
                            /*if ((currentDay > 15 && currentDay < 19 && rolAutorizacion == "Promotor") || (currentDay >= 19 && currentDay <= 20 && rolAutorizacion != "DGA")) {
                             app.alert.show('backlog corriente', {
                             level: 'error',
                             messages: 'Esta operacion no puede moverse debido a que el Backlog ya esta corriendo o se encuentra en periodo de revision.',
                             autoClose: false
                             });
                             return;
                         }*/
                            }else{
                                if (rolAutorizacion == "Promotor" ){
                                //SI es un Backlog anterior o igual al mes corriente natural nadie puede
                                    app.alert.show('backlog corriente', {
                                        level: 'error',
                                        messages: 'Esta operaci\u00F3n no puede moverse debido a que el Backlog ya est\u00E1 corriendo.',
                                        autoClose: false
                                    });
                                    return;
                                }
                            }
                        }
                    }
            }
        }

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

         this.meses_list_html_mover=lista_mes_anio['mes'];


         self.render();

         var modalMover = $('#myModalMover');
         modalMover.show();


         var arr_values=[];

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
                 messages: 'Favor de completar la informaci\u00F3n.',
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

        $('#btn-Cancelar').prop('disabled',true);
        $('#btn-GuardarMover').prop('disabled',true);
         //Notificacion de inicio de proceso
         app.alert.show('moverAlert', {
             level: 'process',
             title: 'Cargando, por favor espere.',
         });

         app.api.call('GET', bl_url, {}, {
             success: _.bind(function (data) {

                 var meses =['0','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
                 if(data.records.length>0){
                    $('#btn-Cancelar').prop('disabled',false);
                    $('#btn-GuardarMover').prop('disabled',false);
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
                 /*
                 if(!_.isEmpty(data)){
                     alert(data);
                 }
                 */
                 $('#btn-Cancelar').prop('disabled',false);
                 $('#btn-GuardarMover').prop('disabled',false);
                 app.alert.dismiss('moverAlert');
                 self.ocultaModal();
                 delete self.backlogs.backlogs.MyBacklogs.linea[self.newMoverMes.idBacklog];
                 //self.cargarBacklogsButton();
                 self.render();
             },this)
         });
     },

     moverOperacionMasiva:function () {

         var arr_checks=[];
         var arr_checks_actualizar=[];
         var arr_checks_no_actualizar=[];

         //Obteniendo valores del apartado de filtros
         var tempMes = $("#mes_filtro").val();
         var tempAnio = $("#anio_filtro").val();
         var tempRegion = $("#region_filtro").val();
         var tempTipoOperacion = $("#tipo_operacion_filtro").val();
         var tempEtapa = $("#etapa_filtro").val();
         var tempEstatus = $("#estatus_filtro").val();
         var tempEquipo = $("#equipo_filtro").val();

         //Obteniendo campos check
         var checks=$('input[type="checkbox"]');

         //AGREGANDO CHECKS SELECCIONADOS
         $.each( checks, function( key, value ) {
             if(value['checked']==true && value['id'] !== "selectAll"){
                 //array_checks contendrá los campos checks con valor true
                 //this.array_checks.push(checks[key]);
                 arr_checks.push(checks[key]);
             }
         });

         this.array_checks=arr_checks;
         this.countChecks=this.array_checks.length;

         var tempPromotor = $("#promotor_filtro").val();
         var tempProgreso = $("#progreso_filtro").val();

         var rolAutorizacion = self.rolAutorizacion;

         var currentYear = (new Date).getFullYear();
         var currentAnioSub= currentYear.toString().substr(-2);
         var currentBacklogMonth = this.backlogMonth();

         var countChecks= this.array_checks.length;

         if(countChecks>0){
             //Recorriendo arreglo de checks
             for(var i=0;i<countChecks;i++){
                 var backlogId = this.array_checks[i].getAttribute('data-id');
                 var backlogName = this.array_checks[i].getAttribute('data-name');
                 var monto = this.array_checks[i].getAttribute('data-monto');
                 var backlogMes = this.array_checks[i].getAttribute('data-mes');
                 var backlogAnio = this.array_checks[i].getAttribute('data-anio');
                 var backlogEstatus = this.array_checks[i].getAttribute('data-estatus');
                 var backlogNum = this.array_checks[i].getAttribute('data-numbacklog');

                 if(backlogAnio <= currentAnioSub) {
                     // Si el BL ya esta cancelado no puede moverse
                     //if(backlogEstatus != 'Activa') {
                     if(backlogEstatus == 'Cancelada') {

                         app.alert.show('backlog_pasado', {
                             level: 'error',
                             //messages: 'Esta operacion no puede moverse debido a que se encuentra ' + backlogEstatus,
                             messages: 'Alguna de las operaciones no puede moverse debido a que se encuentra ' + backlogEstatus +
                             '<br>No. Backlog: '+ backlogNum,
                             autoClose: false
                         });

                         $('input[type="checkbox"][data-id='+backlogId+']').attr('checked',false);
                         return;

                     }else {
                         // No se pueden mover los Backlogs del mes actual BL una vez que ha iniciado
                         var currentDay = (new Date).getDate();
                         var BacklogCorriente = this.getElaborationBacklog();

                         if(backlogAnio <= currentAnioSub){
                             if(backlogMes <= BacklogCorriente && backlogEstatus != 'Cancelada') {
                                 if (backlogMes == BacklogCorriente /*&& currentDay > 15*/ && currentDay <= 20){
                                     if (currentDay == 21 && rolAutorizacion != "DGA") {

                                         arr_checks_no_actualizar.push(this.array_checks[i]);

                                     }else{
                                         arr_checks_actualizar.push(this.array_checks[i]);
                                     }
                                 }else{
                                     if (rolAutorizacion == "Promotor"){
                                         //Si es un Backlog anterior o igual al mes corriente natural nadie puede

                                         app.alert.show('backlog corriente', {
                                             level: 'error',
                                             //messages: 'Esta operacion no puede moverse debido a que el Backlog ya esta corriendo.',
                                             messages: 'Alguna de las operaciones seleccionadas no puede moverse debido a que el Backlog ya est\u00E1 corriendo <br>'+
                                             'No. Backlog: '+backlogNum,
                                             autoClose: false
                                         });

                                         $('input[type="checkbox"][data-id='+backlogId+']').attr('checked',false);

                                         return;

                                         //arr_checks_no_actualizar.push(this.array_checks[i]);
                                     }else{
                                         arr_checks_actualizar.push(this.array_checks[i]);
                                     }
                                 }
                             }else{
                                 arr_checks_actualizar.push(this.array_checks[i]);
                             }

                         }

                     }
                 }else{
                     //this.checks_actualizar.push(this.array_checks[i]);
                     arr_checks_actualizar.push(this.array_checks[i]);
                 }

             }

             //this.checks_actualizar=arr_checks_actualizar;
             //this.checks_no_actualizar=arr_checks_no_actualizar;

         }

         //CONDICIÓN PARA SABER SI SE DEBE MOSTRAR POPUP PARA ACTUALIZACIÓN MASIVA
         if(arr_checks_actualizar.length > 0){

             this.countChecks=arr_checks_actualizar.length;

             //Valores default año y mes
             this.anio_filtro_popup_mover = ((new Date).getFullYear()).toString();
             this.mes_filtro_mover_op=((new Date).getMonth()+1).toString();


             //Listas generadas para año y mes
             var lista_mes_anio=this.getMonthYear();
             this.anio_list_html_mover=lista_mes_anio['anio'];

             this.meses_list_html_mover=lista_mes_anio['mes'];

             this.checks_actualizar=arr_checks_actualizar;
             this.checks_no_actualizar=arr_checks_no_actualizar;

             self.render();
             //Recorriendo registros seleccionados para persistencia después de aplicar render
             for(var i=0;i< this.checks_actualizar.length;i++){
                    $('input[type="checkbox"][data-id="'+this.checks_actualizar[i].getAttribute('data-id')+'"]').attr("checked",true)
            }

             var modalMoverMasiva = $('#myModalMoverMasiva');
             modalMoverMasiva.show();

         }else{

             app.alert.show('cheks_no_actualizar', {
                 level: 'error',
                 messages: 'Alguno de los registros relacionados no se puede mover.',
                 autoClose: false
             });

         }

     },

     moverMesMasivo:function(){

         var tempMes = $("#mes_filtro").val();
         var tempAnio = $("#anio_filtro").val();
         var mes_popup = $('.mes_switch_masivo_popup').val();
         var anio_popup = $('.anio_masivo_switch_popup').val();
         var current_backlog = $('#mes_filtro').val();

         if(_.isEmpty(anio_popup)){
             app.alert.show('anio requerido', {
                 level: 'error',
                 messages: 'Favor de completar la informaci\u00F3n.',
                 autoClose: false
             });
             return;
         }

         var countChecks=this.checks_actualizar.length;

         //Añadir validación para evitar crear Backlogs a Cuentas que ya tienen registros de Backlog en el mismo mes al que se quiere mover
         if(countChecks>0){

             this.controlCount=0;
             this.count=0;

             for(var i=0; i<countChecks;i++){

                 var current_element=this.checks_actualizar[i];
                 var idBacklog=current_element.getAttribute('data-id');
                 var bl_check=$('.MoverOperacion[data-id="'+idBacklog+'"]');
                 var str=bl_check.closest('tr').children('.hide_cliente').children('a').attr('href');
                 var num_bl=bl_check.closest('tr').children('.hide_operacion').children('a').text();
                 var arr_p=str.split('#Accounts/');
                 var id_account=arr_p[1];
                 var bl_url = app.api.buildURL('lev_Backlog?filter[0][account_id_c][$equals]='+id_account+'&filter[1][mes][$equals]='+mes_popup+'&filter[2][anio][$equals]='+anio_popup+'&fields=id,mes,estatus_de_la_operacion,name',
                     null, null, null);

                $('#btn-Cancelar').prop('disabled',true);
                $('#btn-GuardarMoverMasiva').prop('disabled',true);
                 //Notificacion de inicio de proceso
                 app.alert.show('moverMasivoAlert', {
                     level: 'process',
                     title: 'Cargando, por favor espere.',
                 });

                 app.api.call('GET', bl_url, {}, {
                     success: _.bind(function (data) {
                         app.alert.dismiss('moverMasivoAlert');

                         var meses =['0','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
                         if(data.records.length>0){
                             var name_bl=data.records[0].name;
                             var arr_for_cuenta=name_bl.split('-');

                            $('#btn-Cancelar').prop('disabled',false);
                            $('#btn-GuardarMoverMasiva').prop('disabled',false);

                             app.alert.show('error_bl_mes', {
                                 level: 'error',
                                 messages: 'La cuenta: '+arr_for_cuenta[2]+' ya posee un backlog en el mes: '+meses[data.records[0].mes],
                                 autoClose: false
                             });
                             return;


                         }else{
                             this.controlCount++;
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
                                 },this)
                             });
                             if(this.controlCount==this.checks_actualizar.length){
                                 this.moverOperacionAfterValidate(mes_popup,anio_popup,tempMes,tempAnio);
                             }

                         }
                         this.count++;


                     },this)

                 });

             }


         }

     },

     moverOperacionAfterValidate:function(mes_popup,anio_popup,tempMes,tempAnio){
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

         var countChecks=this.checks_actualizar.length;
         if(countChecks>0){

             var successCount=0;
             var countChecksError=this.checks_no_actualizar.length;
             var actualizadosResumen="";
             var noActualizadosResumen="";
             //Ciclo para llenar cadena para mostrar mensaje de resumen sobre registros no actualizados debido a algún error
             if(countChecksError>0){
                 for(var j=0;j<this.checks_no_actualizar.length;j++){
                     noActualizadosResumen+="No. Backlog: "+this.checks_no_actualizar[j].getAttribute('data-numBacklog')+"<br>"
                 }

             }
             for(var i=0;i<countChecks;i++){

                 var Params = {
                     'backlogId': this.checks_actualizar[i].getAttribute('data-id'),
                     'backlogName': this.checks_actualizar[i].getAttribute('data-name'),
                     'mes_popup': mes_popup,
                     'anio_popup': anio_popup,
                     'tipo_operacion': tipo_opp,
                     'periodo_revision': periodo_revision,
                     'access': access,
                     //'monto_comprometido': $('#monto_mes').html(),
                     'rolAutorizacion': self.rolAutorizacion,
                     'MesAnterior': tempMes,
                     'AnioAnterior': tempAnio,

                 };
                 actualizadosResumen+="No. Backlog: "+this.checks_actualizar[i].getAttribute('data-numBacklog')+"<br>";
                 //Notificacion de inicio de proceso
                 app.alert.show('moverMasivoAlert', {
                     level: 'process',
                     title: 'Cargando, por favor espere.',
                 });
                 var Url = app.api.buildURL("MoverOperacion", '', {}, {});
                 app.api.call("create", Url, {data: Params}, {
                     success: _.bind(function (data) {
                         successCount++;
                         if (self.disposed) {
                             app.alert.dismiss('moverMasivoAlert');
                             return;
                         }
                        /*
                         if(!_.isEmpty(data[0])){
                             alert(data[0]);
                         }
                         */

                         //Actualizando objeto backlogs para no hacer una nueva búsqueda
                         delete self.backlogs.backlogs.MyBacklogs.linea[data[1]];

                         //Validación para saber si se ejecutó el último índice
                         if(successCount==countChecks){

                             $('#btn-Cancelar').prop('disabled',false);
                             $('#btn-GuardarMoverMasiva').prop('disabled',false);
                             app.alert.dismiss('moverMasivoAlert');
                             self.ocultaModal();
                             //self.cargarBacklogsButton();
                             self.render();

                             app.alert.show('success_actualizar', {
                                 level: 'success',
                                 messages: countChecks +" Registros actualizados:<br>"+ actualizadosResumen,
                                 autoClose: false
                             });



                             if(countChecksError>0){
                                 app.alert.show('info_no_actualizar', {
                                     level: 'info',
                                     messages: countChecksError +" Registros no actualizados:<br>"+ noActualizadosResumen,
                                     autoClose: false
                                 });

                             }
                             this.array_checks=[];

                         }
                     },this),

                 });

             }

         }
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

     backlogMonth: function(){
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

     getElaborationBacklog: function(){
         //Obtiene el Backlog en elaboración
         var currentDay = (new Date).getDate();
         var BacklogCorriente = (new Date).getMonth();

         if(currentDay > 15){ // Si ya cerro el periodo de elaboración de promotor, el Backlog del siguiente mes (natural) se encuentra corriendo
             BacklogCorriente += 2;
         }else{
             BacklogCorriente += 1;
         }

         if (BacklogCorriente > 12){  //Si resulta mayor a diciembre
             BacklogCorriente = BacklogCorriente - 12;
         }

         return BacklogCorriente;
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

        //Modal Mover Operación Masiva
        var modalMoverMasiva=$('#myModalMoverMasiva');
        modalMoverMasiva.hide();

        var modalCancelarMasiva=$('#myModalCanMasiva');
        modalCancelarMasiva.hide();

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

       $('#btn-CancelarComen').prop('disabled',true);
       $('#btn-GuardarComen').prop('disabled',true);
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
                $('#btn-CancelarComen').prop('disabled',false);
                $('#btn-GuardarComen').prop('disabled',false);
                app.alert.dismiss('ComentAlert');
                self.ocultaModal();
                self.render();
            },this),
            error:function(error){
                $('#btn-CancelarComen').prop('disabled',false);
                $('#btn-GuardarComen').prop('disabled',false);
                app.alert.dismiss('ComentAlert');
                app.alert.show('errorAlert', {
                    level: 'error',
                    messages: error,
                    autoClose: true
                });
            }
        });
    },

    fecha:function(backlogMes){
        //Muestra de año
        var self=this;
        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentMonthTemp = (new Date).getMonth();
        var currentDay = (new Date).getDate();
        var limitMonth = currentMonth + 3;
        var nextMonth = 0;
        var nextYear = currentYear;
        var anio_popup=($('#anio_revivir').val()==null) ? currentYear: $('#anio_revivir').val();
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
        if(self.rolAutorizacion != "Promotor"){
            var opciones_mes = app.lang.getAppListStrings('mes_list');
            for (meses_keys in opciones_mes) {
                if(backlogMes == meses_keys){
                    self.mesRevivir[backlogMes]=opciones_mes[backlogMes];
                }
            }
        }
    },
    //Nuevas funciones Revivir
    revivirNew:function(e){
        var idBacklog=e.currentTarget.getAttribute('data-id');
        //var mes=e.currentTarget.getAttribute('data-mes');
        //var anio=e.currentTarget.getAttribute('data-anio');
        var backlog=self.backlogs.backlogs.MyBacklogs.linea[idBacklog];
        var backlogMes = backlog.mes_int;

        this.fecha(backlogMes);
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
        if( $('#anio_revivir').val()==null || $('#anio_revivir').val()==""){
            app.alert.show('anio_revivir_requerido', {
                level: 'error',
                messages: 'El año es requerido',
                autoClose: true
            });
            $('#anio_revivir').css('border-color', 'red');
            return;
        }
        if( $('#mes_revivir').val()==null || $('#mes_revivir').val()==""){
            app.alert.show('mes_revivir_requerido', {
                level: 'error',
                messages: 'El mes es requerido',
                autoClose: true
            });
            $('#mes_revivir').css('border-color', 'red');
            return;
        }
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

    //Funciones de cancelar
    fechaCancelar:function(){
        //Muestra de año
        var self=this;
        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentMonthTemp = (new Date).getMonth();
        var currentDay = (new Date).getDate();
        var limitMonth = currentMonth + 3;
        var nextMonth = 0;
        var nextYear = currentYear;
        var anio_popup = ($('#anio_cancelar').val() == null) ? currentYear : $('#anio_cancelar').val();

        if (limitMonth > 12) {
            nextMonth = limitMonth - 12;
            nextYear = currentYear + 1;
        }

        currentMonth = currentMonthTemp +1;
        this.anioCancelar = app.lang.getAppListStrings('anio_list');
        Object.keys(this.anioCancelar).forEach(function(key){
            //Quita años previos
            if(key < currentYear){
                delete self.anioCancelar[key];
            }
            //Habilita años futuros
            if(key > nextYear){
                delete self.anioCancelar[key];
            }
        });

        //Muestra de meses
        this.mesCancelar = app.lang.getAppListStrings('mes_list');
        //Quita meses para año futuro
        if(anio_popup > currentYear){
            Object.keys(this.mesCancelar).forEach(function(key){
                if(key != ''){
                    if(key > nextMonth){
                        delete self.mesCancelar[key];
                    }
                }
            });
        }
        //Quita meses para año actual
        if(anio_popup == currentYear || anio_popup ==""){
            Object.keys(this.mesCancelar).forEach(function(key){
                if(key != ''){
                    //Quita meses fuera de rango(3 meses)
                    if(key < currentMonth || key >limitMonth ){
                        delete self.mesCancelar[key];
                    }
                }
            });
        }
    },

    cancelarNew:function(e){
        this.fechaCancelar();
        this.motivoCancelar=app.lang.getAppListStrings('motivo_de_cancelacion_list');
        var idBacklog=e.currentTarget.getAttribute('data-id');
        var backlog=self.backlogs.backlogs.MyBacklogs.linea[idBacklog];
        var status=e.currentTarget.getAttribute('data-estatus');
        var backlogAnio = e.currentTarget.getAttribute('data-anio');
        var rolAutorizacion = self.rolAutorizacion;
        var backlogMes = e.currentTarget.getAttribute('data-mes');
        this.newCancelar={
            "idBacklog":idBacklog,
            "nameBacklog":backlog.name,
            "montoOriginalBacklog":backlog.monto_comprometido,
            "rentaInicialOriginal":backlog.ri_comprometida,
            "motivoCancelacion":'',
            "status":backlog.estatus_de_la_operacion,
            "mesBacklog":backlog.mes_int,
            "anioBacklog":"20"+backlog.anio
        };

        var currentDay = (new Date).getDate();
        var currentMonth = (new Date).getMonth()+1;
        var currentYear = (new Date).getFullYear();
        var BacklogCorriente = this.getElaborationBacklog();

        var currentYearTwoDigits=(new Date()).getFullYear().toString().substr(-2);

        var flagShowModal=true;

        var checkrol = 0;
        for (var i = 0; i < App.user.attributes.roles.length; i++) {
            if (App.user.attributes.roles[i] == "Backlog-Cancelar") {
                checkrol++;
            }
        }

        //No se pueden cancelar operaciones canceladas
        if (status == "Cancelada") {
            app.alert.show('opp_cancelada', {
                level: 'error',
                messages: 'Solo se puede cancelar una operaci\u00F3n original si esta comprometida',
                autoClose: false
            });
            return;
        }

        //Validación para no permitir cancelar Backlogs anteriores al mes actual
        if(backlogAnio < currentYearTwoDigits){

            app.alert.show('backlog_anterior', {
                level: 'error',
                messages: 'Esta operaci\u00F3n no puede ser cancelada pues ya pertenece a un mes anterior al actual',
                autoClose: false
            });
            return;

        }
        if(backlogMes < currentMonth && backlogAnio == currentYearTwoDigits){

            app.alert.show('backlog_anterior', {
                level: 'error',
                messages: 'Esta operaci\u00F3n no puede ser cancelada pues ya pertenece a un mes anterior al actual',
                autoClose: false
            });
            return;

        }

        //Validación para permitir cancelar Backlogs del mes actual a usuarios con Rol de Backlog-Cancelar
        if(backlogMes == currentMonth && backlogAnio == currentYearTwoDigits){
            if(checkrol>0){

                flagShowModal=true;

            }else{

                flagShowModal=false;

                app.api.call("read", app.api.buildURL ("UsuariosBLcancelar"), {}, {
                    success: _.bind(function (data) {
                        var mensaje= "";
                        data.forEach(function(element){
                            mensaje= mensaje +element+'<br>';
                        });
                        app.alert.show('No Permisos', {
                            level: 'error',
                            messages: 'No cuenta con los privilegios para realizar esta acción. Favor de comunicarse con alguno de los siguientes usuarios:<br>' + '<b>'+mensaje +'</b>',
                            autoClose: false
                        });
                    }, this)
                });

            }

        }else{

            if (backlogAnio <= currentYear) {
                if (backlogMes <= BacklogCorriente) {
                    //Operaciones de meses anteriores al actual solo pueden ser canceladas por directores
                    if (backlogMes < BacklogCorriente && rolAutorizacion == "Promotor") {
                        app.alert.show('backlog_pasado', {
                            level: 'error',
                            messages: 'La operaci\u00F3n solo puede ser cancelada por directores.',
                            autoClose: false
                        });
                        return;
                    } else {
                        //Si esta en proceso de revisión solo dir y/o DGA pueden cancelar validando roles
                        if ((backlogMes == BacklogCorriente && currentDay > 15 && currentDay < 19 && rolAutorizacion == "Promotor") ||
                            (backlogMes == BacklogCorriente && currentDay > 19 && currentDay <= 19 && rolAutorizacion != "DGA")) { //CVV se comenta para cerra periodo de Julio  CVV regresar a 20
                            //if (backlogMes == BacklogCorriente && rolAutorizacion != "DGA"){
                            app.alert.show('backlog_pasado', {
                                level: 'error',
                                messages: 'No cuenta con los privilegios para cancelar operaciones en este periodo.',
                                autoClose: false
                            });
                            return;
                        } else {
                            //Si es el mes actual fuera de periodo de revisión, solo Directores y DGA's
                            if ((currentDay < 16 || currentDay < 21) && rolAutorizacion == "Promotor") {  //CVV se comenta para cerra periodo de Julio
                                //if (rolAutorizacion != "DGA"){
                                app.alert.show('backlog_pasado', {
                                    level: 'error',
                                    messages: 'No cuenta con los privilegios para cancelar.',
                                    autoClose: false
                                });
                                return;
                            }
                        }
                    }
                }
            }


        }

        //Validación para saber si se debe de mostrar la ventana modal
        if(flagShowModal){

            self.render();
            if (status != "Cancelada") {
                var modal = $('#myModalCan');
                modal.show();
                $('.Quien').hide();
                $('.Producto').hide();
                $('.FechaCancelar').hide();
            }

        }

        //$("#formulariomayores").css("display", "block")
    },

    motivoCancelarC:function(){
        this.motivoCancelar=app.lang.getAppListStrings('motivo_de_cancelacion_list');
        if($('#motivoCancelarC').val()=='Competencia'){
            $('.Quien').show();
        }else{
            $('.Quien').hide();
        }
        if($('#motivoCancelarC').val()=='No tenemos el producto que requiere'){
            $('.Producto').show();
        }else{
            $('.Producto').hide();
        }
        if($('#motivoCancelarC').val()=='Mes posterior'){
            $('.FechaCancelar').show();
        }else{
            $('.FechaCancelar').hide();
        }
    },

    guardaCancelar:function(){
        var mes=$('#mes_cancelar').val();
        var anio=$('#anio_cancelar').val();
        var comentarios=$('#ComentarioCan').val();
        var motivo=$('#motivoCancelarC').val();
        var productova=$('.ProductoInput').val();
        var competenciava=$('.QuienInput').val();
        var competencia=$('.QuienInput');
        var producto=$('.ProductoInput');


        if( $('#motivoCancelarC').val()==null || $('#motivoCancelarC').val()==""){
            app.alert.show('motivo_requerido', {
                level: 'error',
                messages: 'El motivo de cancelaci\u00F3n es requerido',
                autoClose: true
            });
            $('#motivoCancelarC').css('border-color', 'red');
            return;
        }

        if($('#motivoCancelarC').val()=="Competencia" && ($('.QuienInput').val()==null || $('.QuienInput').val()=="" || competenciava.trim().length==0 )){
            app.alert.show('Competencia_requerida', {
                level: 'error',
                messages: 'El campo ¿Qui\u00E9n? es requerido',
                autoClose: true
            });
            $('.QuienInput').css('border-color', 'red');
            return;
        }
        if($('#motivoCancelarC').val()=="No tenemos el producto que requiere" && ($('.ProductoInput').val()==null || $('.ProductoInput').val()=="" || productova.trim().length==0)){
            app.alert.show('Producto_requerido', {
                level: 'error',
                messages: 'El campo ¿Qué producto? es requerido',
                autoClose: true
            });
            $('.ProductoInput').css('border-color', 'red');
            return;
        }
        if($('#motivoCancelarC').val()=='Mes posterior' &&($('.mes_cancelar').val()==0 || $('.mes_cancelar').val()==null || $('.mes_cancelar').val()=="")){
            app.alert.show('mes_requerido', {
                level: 'error',
                messages: 'Debe indicar el mes para el nuevo Backlog',
                autoClose: true
            });
            $('.mes_cancelar').css('border-color', 'red');
            return;
        }

        if(self.progresoBL == 'SI'){
           if (self.rolAutorizacion == 'DGA'){
               if(!confirm('El Bl cuenta con operaciones en Pipe.  ¿Desea cancelar?')){
                   return;
                }
            }else {
               app.alert.show('Operaciones en Pipe', {
                   level: 'error',
                   messages: 'El BL no puede ser cancelado debido a que tiene operaciones en pipeline',
                   autoClose: true
               });
                return;
            }
        }

        var currentYear = (new Date).getFullYear();
        var currentMonth = ((new Date).getMonth()) + 1;
        var currentDay = (new Date).getDate();
        var fechaCancelacion = currentMonth + '/' + currentDay + '/' + currentYear;
        comentarios += '\r\n' + "UNI2CRM - " + fechaCancelacion + ": MOTIVO DE CANCELACION -> " + motivo;

        var Params={
            'backlogId':this.newCancelar.idBacklog,
            'backlogName':this.newCancelar.backlogName,
            'MontoReal':this.newCancelar.montoOriginalBacklog,
            'motivoCancelacion':motivo,
            'RentaReal':this.newCancelar.rentaInicialOriginal,
            'Comentarios':comentarios,
            'Mes':mes,
            'Anio':anio,
            'MesAnterior':this.newCancelar.mesBacklog,
            'AnioAnterior':this.newCancelar.anioBacklog,
            'Competencia':'',
            'Producto':''
        };

        //Notificacion de inicio de proceso
       app.alert.show('CancelAlert', {
            level: 'process',
            title: 'Cargando, por favor espere.',
        });
       $('#btn-CanCancelar').prop('disabled',true);
       $('#btn-GuardarCan').prop('disabled',true);

        var Url = app.api.buildURL("BacklogCancelar", '', {}, {});
        app.api.call("create", Url, {data: Params}, {
            success: _.bind(function (data) {
                if (data[0] ==1){
                    //Elimina el registro del objeto Backlogs
                    delete self.backlogs.backlogs.MyBacklogs.linea[self.newCancelar.idBacklog];
                }
                else{
                    //Marcar como cancelado, pintar en rojo y status en cancelada
                    self.backlogs.backlogs.MyBacklogs.linea[self.newCancelar.idBacklog].color="#FF6666";
                    self.backlogs.backlogs.MyBacklogs.linea[self.newCancelar.idBacklog].estatus_de_la_operacion="Cancelada";
                }
                $('#btn-CanCancelar').prop('disabled',false);
                $('#btn-GuardarCan').prop('disabled',false);
                app.alert.dismiss('CancelAlert');
                self.ocultaCancelar();
                //self.cargarBacklogsButton();
                self.render();
            },this),
            error:function(error){
                $('#btn-CanCancelar').prop('disabled',false);
                $('#btn-GuardarCan').prop('disabled',false);
                app.alert.dismiss('CancelAlert');
                app.alert.show('errorAlertCancelar',{
                    level:'error',
                    messages:error,
                    autoClose:true
                })
            }
        });
    },

    ocultaCancelar:function(){
        var modal = $('#myModalCan');
        modal.hide();
    },

    cancelarBacklogMasiva: function () {

        var arr_checks_cancelar=[];
        var checks_cancelar=[];
        var checks_cancelar_error=[];

        var tempMes = $("#mes_filtro").val();
        var tempAnio = $("#anio_filtro").val();
        var tempRegion = $("#region_filtro").val();
        var tempTipoOperacion = $("#tipo_operacion_filtro").val();
        var tempEtapa = $("#etapa_filtro").val();
        var tempEstatus = $("#estatus_filtro").val();
        var tempEquipo = $("#equipo_filtro").val();

        var tempPromotor = $("#promotor_filtro").val();
        //var oppTipo = e.currentTarget.getAttribute('data-oppTipo');
        var tempProgreso = $("#progreso_filtro").val();
        //var ProgresoBL = e.currentTarget.getAttribute('data-progreso');
        var rolAutorizacion = self.rolAutorizacion;

        //Obteniendo campos check
        var checks=$('input[type="checkbox"]');

        //AGREGANDO CHECKS SELECCIONADOS
        $.each( checks, function( key, value ) {
            if(value['checked']==true && value['id'] !=="selectAll"){
                //array_checks contendrá los campos checks com valor true
                //this.array_checks.push(checks[key]);
                arr_checks_cancelar.push(checks[key]);
            }
        });

        this.array_checks_cancelar=arr_checks_cancelar;
        this.countChecksCancelar=this.array_checks_cancelar.length;

        var currentDay = (new Date).getDate();
        var currentYear = (new Date).getFullYear();

        if(this.countChecksCancelar>0){
            //Recorriendo arreglo de checks
            for(var i=0;i<this.countChecksCancelar;i++){

                var backlogId = this.array_checks_cancelar[i].getAttribute('data-id');
                 var backlogName = this.array_checks_cancelar[i].getAttribute('data-name');
                 var monto = this.array_checks_cancelar[i].getAttribute('data-monto');
                 var renta_inicial = this.array_checks_cancelar[i].getAttribute('data-renta_inicial');
                 var opp_related = this.array_checks_cancelar[i].getAttribute('data-oppId');
                 var estatus = this.array_checks_cancelar[i].getAttribute('data-estatus');
                 var backlogMes = this.array_checks_cancelar[i].getAttribute('data-mes');
                 var backlogAnio = this.array_checks_cancelar[i].getAttribute('data-anio');
                 var backlogNum=this.array_checks_cancelar[i].getAttribute('data-numbacklog');

                 var oppTipo = this.array_checks_cancelar[i].getAttribute('data-oppTipo');
                 var ProgresoBL = this.array_checks_cancelar[i].getAttribute('data-progreso');
                 self.mesAnterior = this.array_checks_cancelar[i].getAttribute('data-mes');

                 if(estatus == "Cancelada"){

                    app.alert.show('opp_cancelada', {
                        level: 'error',
                        messages: 'Alguna de las operaciones ya ha sido cancelada '+
                        '<br>No. Backlog: '+ backlogNum,
                        autoClose: false
                    });

                    $('input[type="checkbox"][data-id='+backlogId+']').attr('checked',false);

                    return;
                }

                var BacklogCorriente = this.getElaborationBacklog();

                if(backlogAnio <= currentYear) {
                    if (backlogMes <= BacklogCorriente){
                        //Operaciones de meses anteriores al actual solo pueden ser canceladas por directores
                        if (backlogMes < BacklogCorriente && rolAutorizacion == "Promotor") {

                            checks_cancelar_error.push(this.array_checks_cancelar[i]);

                        }else{
                            //Si esta en proceso de revisión solo dir y/o DGA pueden cancelar validando roles
                            if ((backlogMes == BacklogCorriente && currentDay > 15 && currentDay < 19 && rolAutorizacion == "Promotor") ||
                                (backlogMes == BacklogCorriente && currentDay > 19 && currentDay <= 19 && rolAutorizacion != "DGA")){ //CVV se comenta para cerra periodo de Julio  CVV regresar a 20

                                checks_cancelar_error.push(this.array_checks_cancelar[i]);
                            }else{
                                //Si es el mes actual fuera de periodo de revisión, solo Directores y DGA's
                                if ((currentDay < 16 || currentDay < 21) && rolAutorizacion == "Promotor"){  //CVV se comenta para cerra periodo de Julio

                                    checks_cancelar_error.push(this.array_checks_cancelar[i]);
                                }else{
                                    checks_cancelar.push(this.array_checks_cancelar[i]);
                                }
                            }
                        }
                    }else{
                        checks_cancelar.push(this.array_checks_cancelar[i]);
                    }
                }else{
                    checks_cancelar.push(this.array_checks_cancelar[i]);
                }
            }
        }

        //Condición para saber si se debe mostrar el popup para cancelar masivamente
        if(checks_cancelar.length > 0){
            this.checks_cancelar=checks_cancelar;
            this.checks_cancelar_error=checks_cancelar_error;
            this.motivoCancelarMasivoList=app.lang.getAppListStrings('motivo_de_cancelacion_list');
            this.motivoDefault="Mes posterior";

             //Listas generadas para año y mes
             var lista_mes_anio=this.getMonthYear();
             this.anioCancelarMasivo=lista_mes_anio['anio'];

             this.mesCancelarMasivo=lista_mes_anio['mes'];

             self.render();

             //Recorriendo registros seleccionados para persistencia después de aplicar render
             for(var i=0;i< this.checks_cancelar.length;i++){
                    $('input[type="checkbox"][data-id="'+this.checks_cancelar[i].getAttribute('data-id')+'"]').attr("checked",true)
            }

            var modalCancelarMasiva = $('#myModalCanMasiva');
            modalCancelarMasiva.show();

        }else{
            app.alert.show('cheks_no_cancelar', {
                level: 'error',
                messages: 'Ninguno de los registros seleccionados se puede cancelar',
                autoClose: false
            });
        }
    },

    motivoCancelacionMasivo: function(e){
        var valor=$(e.currentTarget).val();

        if(valor=="Mes posterior"){

            $('.FechaCancelar').show();
            $('.Quien').hide();
            $('.Producto').hide();

        }else if(valor == "Competencia"){

            $('.Quien').show();
            $('.FechaCancelar').hide();
            $('.Producto').hide();

        }else if(valor == "No tenemos el producto que requiere"){

            $('.Quien').hide();
            $('.Producto').show();
            $('.FechaCancelar').hide();

        }else{

            //Ocultar mes y año para mover
            $('.FechaCancelar').hide();
            $('.Quien').hide();
            $('.Producto').hide();
        }
    },

    cancelarGuardarBacklogMasivo:function(){

        var self = this;
        var tempMes = $("#mes_filtro").val();
        var tempAnio = $("#anio_filtro").val();
        var tempRegion = $("#region_filtro").val();
        var tempTipoOperacion = $("#tipo_operacion_filtro").val();
        var tempEtapa = $("#etapa_filtro").val();
        var tempEstatus = $("#estatus_filtro").val();
        var tempEquipo = $("#equipo_filtro").val();
        var tempPromotor = $("#promotor_filtro").val();
        var tempProgreso = $("#progreso_filtro").val();

        var arr_posiciones=[];

        $('#quienMasivo').attr('style','');
        $('#productoInputMasivo').attr('style','');
        $('#motivoCancelarMasivo').attr('style','');
        $('select#mes_cancelar').attr('style','');

        var MotivoCancelacion = $('#motivoCancelarMasivo').val();
        var comentarios = $('#ComentarioCanMasivo').val();
        var mes = $('select#mes_cancelar')[1].value;
        var anio = $('select#anio_cancelar')[1].value;
        var Competencia = $('#quienMasivo').val();
        var Producto = $('#productoInputMasivo').val();

        if( Competencia == null || Competencia == "" || Competencia.trim().length==0 ) {

                    if(MotivoCancelacion == 'Competencia') {

                        $('#quienMasivo').attr('style','border-color:red');

                        app.alert.show('alertquien', {
                            level: 'error',
                            messages: 'El campo \u00bfQui\u00E9n? es requerido',
                            autoClose: true
                        });
                        return;
                    }

        }
        if(Producto == null || Producto == "" || Producto.trim().length==0) {

                    if(MotivoCancelacion == 'No tenemos el producto que requiere') {

                        $('#productoInputMasivo').attr('style','border-color:red');
                        app.alert.show('alertproducto', {
                            level: 'error',
                            messages: 'El campo \u00bfQu\u00E9 Producto? es requerido',
                            autoClose: true
                        });
                        return;
                    }

        }

        var countChecksCancelar=this.checks_cancelar.length;

        if(countChecksCancelar>0) {

            for (var i = 0; i < countChecksCancelar; i++) {

                if (this.checks_cancelar[i].getAttribute('data-progreso') == 'SI') {
                            if (self.rolAutorizacion == 'DGA') {
                                //AGREGAR AL ARREGLO INDICANDO CON MENSAJE QUE SON BACKLOGS QUE NO SE CANCELARON PORQUE TIENEN OPERACIONES EN PIPELINE
                                this.checks_cancelar_error.push(this.checks_cancelar[i]);
                                //Llenar arreglo con la posición, para posteriormente eliminar el registro de los backlogs por procesar
                                arr_posiciones.push(i);
                            } else {
                                /*
                                 app.alert.show('Operaciones en Pipe', {
                                 level: 'error',
                                 messages: 'El BL no puede ser cancelado debido a que tiene operaciones en pipeline',
                                 autoClose: true
                                 });
                                 this.saving = 0;
                                 return;
                                 }
                                 */
                                 this.checks_cancelar_error.push(this.checks_cancelar[i]);
                                 arr_posiciones.push(i);
                            }
                }

            }
        }

        if(_.isEmpty(MotivoCancelacion)){

                $('#motivoCancelarMasivo').attr('style','border-color:red');
                    app.alert.show('motivo_requerido', {
                        level: 'error',
                        messages: 'El motivo de cancelaci\u00F3n es requerido',
                        autoClose: true
                    });
                    return;
        }

        if (MotivoCancelacion == 'Mes posterior' && $('select#mes_cancelar')[1].value==""){
                    $('select#mes_cancelar').attr('style',"border-color:red");
                    app.alert.show('Mes requerido', {
                        level: 'error',
                        messages: 'Debe indicar el mes para el nuevo Backlog.',
                        autoClose: true
                    });
                    return;
        }



        //CVV - Se agrega el motivo de cancelación a los comentarios
        var currentYear = (new Date).getFullYear();
        var currentMonth = ((new Date).getMonth()) + 1;
        var currentDay = (new Date).getDate();
        var fechaCancelacion = currentMonth + '/' + currentDay + '/' + currentYear;
        comentarios += '\r\n' + "UNI2CRM - " + fechaCancelacion + ": MOTIVO DE CANCELACION -> " + MotivoCancelacion;

        var long=arr_posiciones.length;
        //Ciclo que recorre el arreglo con las posiciones para limpiar los Backlogs que se cancelarán
        if(long>0){
            for(var i=0;i<long;i++){
                delete this.checks_cancelar[arr_posiciones[i]]
            }
        }

        var countBacklogsCancelados=0;
        var successCountCancelar=0;
        var countChecksCancelarError=this.checks_cancelar_error.length;
        var canceladosResumen="";
        var noCanceladosResumen="";
        //Ciclo para llenar cadena para mostrar mensaje de resumen sobre registros no actualizados debido a algún error
        if(countChecksCancelarError>0){
            for(var j=0;j<countChecksError;j++){
                noCanceladosResumen+="No. Backlog: "+this.checks_cancelar_error[j].getAttribute('data-numBacklog')+"<br>"
            }
        }


        for(var i=0;i<countChecksCancelar;i++){
             //Tomando en cuenta que el arreglo {this.checks_cancelar} pudo haber cambiado por tener operaciones en pipeline
            //se agrega validación para evitar mandar registros empty
            //if(!_.isEmpty(this.checks_cancelar[i])){
                if(this.checks_cancelar[i] !== undefined){
                    countBacklogsCancelados++;
                   var Params = {
                        'backlogId': this.checks_cancelar[i].getAttribute('data-id'),
                        'backlogName': this.checks_cancelar[i].getAttribute('data-name'),
                        'MotivoCancelacion': MotivoCancelacion,
                        'MontoReal': this.checks_cancelar[i].getAttribute('data-monto'),
                        'RentaReal': this.checks_cancelar[i].getAttribute('data-renta_inicial'),
                        'Comentarios': comentarios,
                        'Mes': mes,
                        'Anio': anio,
                        'MesAnterior': tempMes,
                        'AnioAnterior': tempAnio,
                        'Competencia':Competencia,
                        'Producto':Producto
                    };

                    canceladosResumen+="No. Backlog: "+this.checks_cancelar[i].getAttribute('data-numBacklog')+"<br>";

                    $('#btn-Cancelar').prop('disabled',true);
                    $('#btn-GuardarCanMasivo').prop('disabled',true);
                    app.alert.show('cancelarMasivoAlert', {
                        level: 'process',
                        title: 'Cargando, por favor espere.',
                    });
                    var Url = app.api.buildURL("BacklogCancelar", '', {}, {});

                    app.api.call("create", Url, {data: Params}, {
                                success: _.bind(function (data) {
                                    if (data[0] ==1){
                                        //Elimina el registro del objeto Backlogs
                                        delete self.backlogs.backlogs.MyBacklogs.linea[data[1]];
                                    }
                                    else{
                                        //Marcar como cancelado, pintar en rojo y status en cancelada
                                        self.backlogs.backlogs.MyBacklogs.linea[data[1]].color="#FF6666";
                                        self.backlogs.backlogs.MyBacklogs.linea[data[1]].estatus_de_la_operacion="Cancelada";
                                    }
                                    successCountCancelar++;
                                    if (self.disposed) {
                                        app.alert.dismiss('cancelarMasivoAlert');
                                        return;
                                    }

                                    if(successCountCancelar==countChecksCancelar){

                                        $('#btn-CanCancelar').prop('disabled',false);
                                        $('#btn-GuardarCanMasivo').prop('disabled',false);
                                        app.alert.dismiss('cancelarMasivoAlert');
                                        self.ocultaModal();
                                        //self.cargarBacklogsButton();
                                        self.render();

                                    app.alert.show('success_actualizar', {
                                        level: 'success',
                                        messages: countBacklogsCancelados +" Registros cancelados:<br>"+ canceladosResumen,
                                        autoClose: false
                                    });


                                    if(countChecksCancelarError>0){
                                        app.alert.show('info_no_actualizar', {
                                            level: 'info',
                                            messages: countChecksCancelarError +" Registros no cancelados:<br>"+ noCanceladosResumen,
                                            autoClose: false
                                        });

                                    }
                                    this.array_checks=[];
                                    this.array_checks_cancelar=[];

                                }
                            },this)
                    });
                }
        }


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
