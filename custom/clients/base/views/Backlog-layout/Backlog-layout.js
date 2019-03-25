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

        'click .ocultar_columnas': 'ocultarColumnas',
        'click .exportar': 'exportarXL',

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
        //Nuevos eventos de cancelar
        'click .updateCancelar':'cancelarNew',
        'click #btn-CanCancelar':'ocultaCancelar',
        'click #btn-GuardarCan':'guardaCancelar',
        'click .closeCancelar':'ocultaCancelar',
        'change #anio_cancelar':'fechaCancelar',
        'change #motivoCancelar':'motivoCancelarC',
        'change .motivoCancelarC':'motivoCancelarC'

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
                                //Persistiendo anio y mes
                                $("#anio_filtro").val(anio_actual);
                                $("#mes_filtro").val(mes_actual);

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
                         var href = 'data:text/csv;charset=utf-8,' + encodeURI(response[1]);
                         element.setAttribute('href', href);
                         element.setAttribute('target','_blank');
                         element.setAttribute('download', response[0]);
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
       //Notificacion de inicio de proceso
       app.alert.show('ComentAlert', {
            level: 'process',
            title: 'Cargando, por favor espere.',
        });
       $('#btn-Cancelar').prop('disabled',true);
       $('#btn-Guardar').prop('disabled',true);
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
        var anio_popup=$('#anio_cancelar').val();

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
        self.render();
        var modal = $('#myModalCan');
        modal.show();
        $('.Quien').hide();
        $('.Producto').hide();
        $('.FechaCancelar').hide();
        //$("#formulariomayores").css("display", "block")
        },

    motivoCancelarC:function(){
        this.motivoCancelar=app.lang.getAppListStrings('motivo_de_cancelacion_list');;
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
        var competencia=$('.QuienInput');
        var producto=$('.ProductoInput');
        
        
        if( $('#motivoCancelarC').val()==null || $('#motivoCancelarC').val()==""){
            app.alert.show('motivo_requerido', {
                level: 'error',
                messages: 'El motivo de cancelacion es requerido',
                autoClose: true
            });
            $('#motivoCancelarC').css('border-color', 'red');
        }

        if($('#motivoCancelarC').val()=="Competencia" && ($('.QuienInput').val()==null || $('.QuienInput').val()=="" competencia.trim()==0 )){
            app.alert.show('Competencia_requerida', {
                level: 'error',
                messages: 'El campo Quién es requerido',
                autoClose: true
            });
            $('.QuienInput').css('border-color', 'red');
            return;
        }
        if($('#motivoCancelarC').val()=="No tenemos el producto que requiere" && ($('.ProductoInput').val()==null || $('.ProductoInput').val()=="" || producto.trim()==0)){
            app.alert.show('Producto_requerido', {
                level: 'error',
                messages: 'El campo Producto es requerido',
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
                if (data ==1){
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
})