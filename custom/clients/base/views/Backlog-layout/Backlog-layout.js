/**
 * Created by Levementum on 2/25/2016.
 * User: jgarcia@levementum.com
 */

 ({
    plugins: ['Dashlet'],

    //array_checks:null,
    //checks_actualizar:null,
    //checks_no_actualizar:null,

    events: {
        'click #btn_Buscar': 'cargarBacklogsButton',
        'click .Cancelar': 'cancelarBacklog',
        'click .Comentario': 'comentarioBacklog',
        'click .MoverOperacion': 'moverOperacion',
        'click .Comprometer': 'comprometer',
        'click .Revivir': 'revivir',
        'click .popupCancel': 'popupCancel',
        'click .popupSave': 'popupSave',
        'change .anio_popup': 'getCurrentYearMonthPopUp',
        //Nuevo evento para control change de ddw en cancelar masivo
        'change .anio_masivo_popup': 'getCurrentYearMonthPopUp',
        'change .anio_switch_popup': 'getCurrentYearMonthMoverMes',
        'change .anio_masivo_switch_popup': 'getCurrentYearMonthMoverMes',

        //'change .anio_masivo_switch_popup': 'getCurrentYearMonthMoverMes',

        'change .anio_a_comprometer_popup': 'getCurrentYearMonthComprometer',
        'change #mass_update_btn': 'seleccionarTodo',
        'click .mass_update': 'seleccionarBacklog',
        'click .Comprometer_mass': 'ComprometerMasivo',
        'click .ocultar_columnas': 'ocultarColumnas',
        'click #btn_cancela_ocultar_columnas': 'cancelaOcultarColumnas',
        'click #btn_ejecuta_ocultar_columnas': 'ejecutaOcultarColumnas',
        'click .exportar': 'exportarXL',
        'click #expandir_backlog_button': 'expandirPantalla',
        'click #colapsar_backlog_button': 'colapsarPantalla',
        'click .hide_show_col': 'hideCol',
        'change #equipo_filtro': 'recalcularPromotores',
        'change #ri_porciento': 'calcularRI',
        'change #renta_a_comprometer': 'calcularPorcientoRI',
        'change #motivo_de_cancelacion_popup': 'motivoCancelacion',
        'change #motivo_de_cancelacion_masivo_popup': 'motivoCancelacionMasivo',


        'click #EquipoSort': 'ordenarPorEquipo',
        'click #PromotorSort': 'ordenarPorPromotor',
        'click #ClienteSort': 'ordenarPorCliente',
        'click #NumeroBacklogSort': 'ordenarPorNumeroBacklog',
        'click #MontoOperacionSort': 'ordenarPorMontoOperacion',
        'click #MontoFinalSort': 'ordenarPorMontoFinal',
        // AF: 10/04/2018
        // Backlog: Actualizar masivamente
        'click .marcarTodos': 'marcarCasillas',
        'click .CancelarMasiva': 'cancelarBacklogMasiva',
        'click .MoverOperacionMasiva': 'moverOperacionMasiva',

        'change .checkboxChange': 'SetMenuOptions'
    },

    initialize: function (options) {
        self = this;
        //Actualizar esta variable para cerrar los periodos de Backlog a Petición del usuario
        //1 = Mes cerrado --- 0 = Mes abierto
        self.mesNaturalCerrado = 0;

        this.reporteesEndpoint = app.api.buildURL('Forecasts', 'orgtree/' + app.user.get('id'), null, {'level': 10});

        this._super("initialize", [options]);

        var meses_list = app.lang.getAppListStrings('mes_list');
        var meses_keys = app.lang.getAppListKeys('mes_list');
        var meses_list_html = '<option value=""></option>';
        meses_list_html += '<option value="Todos">Todos</option>';
        for (meses_keys in meses_list) {
            meses_list_html += '<option value="' + meses_keys + '">' + meses_list[meses_keys] + '</option>'

        }
        this.meses_list_html = meses_list_html;

        var anio_list = app.lang.getAppListStrings('anio_list');
        var anio_keys = app.lang.getAppListKeys('anio_list');
        var anio_list_html = '<option value=""></option>';
        for (anio_keys in anio_list) {
            anio_list_html += '<option value="' + anio_keys + '">' + anio_list[anio_keys] + '</option>'

        }
        this.anio_list_html = anio_list_html;

        //genera las listas de mes y anio que seran utilizadas en el popup de cancelar
        this.getCurrentYearMonthPopUp();
        this.getCurrentYearMonthMoverMes();
        this.getCurrentYearMonthComprometer();

        var region_list = app.lang.getAppListStrings('region_list');
        var region_keys = app.lang.getAppListKeys('region_list');
        var region_list_html = '<option value=""></option>';
        for (region_keys in region_list) {
            region_list_html += '<option value="' + region_keys + '">' + region_list[region_keys] + '</option>'

        }
        this.region_list_html = region_list_html;

        var progreso_list = app.lang.getAppListStrings('progreso_list');
        var progreso_keys = app.lang.getAppListKeys('progreso_list');
        var progreso_list_html = '<option value=""></option>';
        for (progreso_keys in progreso_list) {
            progreso_list_html += '<option value="' + progreso_keys + '">' + progreso_list[progreso_keys] + '</option>'
        }
        this.progreso_list_html = progreso_list_html;

        var tipo_operacion_list = app.lang.getAppListStrings('tipo_de_operacion_0');
        var tipo_operacion_keys = app.lang.getAppListKeys('tipo_de_operacion_0');
        var tipo_operacion_list_html = '<option value=""></option>';
        for (tipo_operacion_keys in tipo_operacion_list) {
            tipo_operacion_list_html += '<option value="' + tipo_operacion_keys + '">' + tipo_operacion_list[tipo_operacion_keys] + '</option>'
        }
        this.tipo_operacion_list_html = tipo_operacion_list_html;

        var etapa_list = app.lang.getAppListStrings('etapa_backlog');
        var etapa_keys = app.lang.getAppListKeys('etapa_backlog');
        //delete etapa_list['Autorizada'];
        var etapa_list_html = '<option value=""></option>';
        for (etapa_keys in etapa_list) {
            etapa_list_html += '<option value="' + etapa_keys + '">' + etapa_list[etapa_keys] + '</option>'
        }
        this.etapa_list_html = etapa_list_html;

        var estatus_list = app.lang.getAppListStrings('estatus_de_la_operacion_list');
        var estatus_keys = app.lang.getAppListKeys('estatus_de_la_operacion_list');
        var estatus_list_html = '<option value=""></option>';
        for (estatus_keys in estatus_list) {
            estatus_list_html += '<option value="' + estatus_keys + '">' + estatus_list[estatus_keys] + '</option>'

        }
        this.estatus_list_html = estatus_list_html;
        /*
         var equipo_list = app.lang.getAppListStrings('equipo_list');
         var equipo_keys = app.lang.getAppListKeys('equipo_list');
         var equipo_list_html = '<option value=""></option>';
         equipo_list_html += '<option value="Todos">Todos</option>';
         for (equipo_keys in equipo_list) {
         equipo_list_html += '<option value="' + equipo_keys + '">' + equipo_list[equipo_keys] + '</option>'

         }
         this.equipo_list_html = equipo_list_html;
         */
         var motivo_de_cancelacion_list = app.lang.getAppListStrings('motivo_de_cancelacion_list');
         var motivo_de_cancelacion_keys = app.lang.getAppListKeys('motivo_de_cancelacion_list');
         var motivo_de_cancelacion_list_html = '<option value=""></option>';
         for (motivo_de_cancelacion_keys in motivo_de_cancelacion_list) {
            motivo_de_cancelacion_list_html += '<option value="' + motivo_de_cancelacion_keys + '">' + motivo_de_cancelacion_list[motivo_de_cancelacion_keys] + '</option>'

        }
        this.motivo_de_cancelacion_list_html = motivo_de_cancelacion_list_html;

        app.api.call("read", app.api.buildURL("Users/" + app.user.get('id'), null, null, {
            fields: name,
        }), null, {
            success: _.bind(function (data) {
                this.defaultEquipo = data.equipo_c;
                this.render();
            }, this)
        });

        this.currentUserName = app.user.get('full_name');
        this.popup_switch = "none";
        this.comentarios_switch = "none";
        this.mes_switch = "none";
        this.cancelar_switch = "none";
        this.cancelar_masivo_switch = "none";
        this.lograda_switch = "none";
        this.compromiso_masivo_switch = "none";
        this.mes_masivo_switch="none";
        this.backlogName = '';
        this.backlogId = '';
        this.backlogMonto = '';
        this.backlogMonto_Real = '';
        this.backlogRentaInicial = '';
        this.cancel = 'Cancelar';
        this.save = 'Guardar';
        this.mes_seleccionado = '';
        this.anio_seleccionado = '';
        this.comentarios_existentes = '';
        this.access = '';
        this.autorizaciones = '';
        this.riPorciento = '';
        this.EquipoSortDirection = 'DESC';
        this.PromotorSortDirection = 'DESC';
        this.ClienteSortDirection = 'DESC';
        this.NumeroBacklogSortDirection = 'DESC';
        this.MontoOperacionSortDirection = 'DESC';
        this.MontoFinalSortDirection = 'DESC';
        this.saving = 0;

        this.seleccionados = [];

        //AGREGANDO ARREGLOS PARA MANTENER REGISTROS A ACTUALIZAR MASIVAMENTE
        this.array_checks=[];
        this.checks_actualizar=[];
        this.checks_no_actualizar=[];

        //Arreglos que mantendrán los registros a Cancelar masivamente
        this.array_checks_cancelar=[];
        this.checks_cancelar=[];
        this.checks_cancelar_error=[];

        this.checks_clean=[];

        this.flag=0;
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
                                self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso,self.array_checks,self.array_checks_cancelar);

                                //autopopula los campos de mes y anio en el popup de Comprometer;
                                $('#mes_a_comprometer_popup').val(backlog_mes).change();
                                $('#anio_a_comprometer_popup').val(backlog_anio).change();

                                $('#mes_a_comprometer_mass_popup').val(tempMes).change();
                                $('#anio_a_comprometer_mass_popup').val(tempAnio).change();

                                $(".loadingIcon").hide();
                            })
                        });
                        //END GetPromotores

                    })
                });
            })

});
},

floatHeader: function(){
    var clonedHeaderRow;
    var clonedHeaderRowTotals;

    $(".backlog_dashlet_header").next('.backlogHeaderFloat').remove();
    $(".backlog_dashlet_header_totals").next('.backlogHeaderFloat_totals').remove();
    $(".backlog_dashlet_box").each(function() {

        var columnSizes = {}
        $(".backlog_dashlet_header").find('th').each(function (i, el) {
            columnSizes[i] = $(el).width();
        });

        clonedHeaderRow = $(".backlog_dashlet_header", this);

        clonedHeaderRow
        .before(clonedHeaderRow.clone())
        .css("width", clonedHeaderRow.width())
        .addClass("backlogHeaderFloat")

        clonedHeaderRow.find('th').each(function (i, el) {
            $(el).css('width', columnSizes[i] + "px");
        });

            //backlog_dashlet_header_totals
            clonedHeaderRowTotals = $(".backlog_dashlet_header_totals", this);

            clonedHeaderRowTotals
            .before(clonedHeaderRowTotals.clone())
            .css("width", clonedHeaderRowTotals.width())
            .addClass("backlogHeaderFloat_totals")

            clonedHeaderRowTotals.find('th').each(function (i, el) {
                $(el).css('width', columnSizes[i] + "px");
            });

        });

        // $('.dashlet-content > div').each(function(){
        //
        //     if($(this).children('div').attr('class') == 'backlog-dashlet-wrapper'){
        //         $(this).scroll(toggleHeader)
        //         $(this).trigger("scroll");
        //     }
        // });

        $( ".backlogInfo" ).scroll(function() {
            $(this).scroll(toggleHeader)
        });

        $(".backlogHeaderFloat").hide();
        $(".backlogHeaderFloat_totals").hide();
        function toggleHeader() {

            var scrollTop = $('.backlog-dashlet-wrapper').parent().offset().top;
            var scrollHorizontal = $('.backlog-dashlet-wrapper').parent().offset().left;

            $(".backlog_dashlet_box").each(function() {

                var el             = $(this),
                offset         = el.offset(),
                c1HeaderFloat = $(".backlogHeaderFloat", this)

                var filtrosHeight = $('.filtros_table').height() + $('.barra_de_acciones').height();
                var trackingOffset = offset.top - filtrosHeight;
                var trackingOffsetHorizontal = offset.left;

                if ((scrollTop > trackingOffset) && (scrollTop < trackingOffset + el.height())) {
                    $(".backlogHeaderFloat").show();
                    $('.backlogHeaderFloat').css('top', scrollTop + 15 + filtrosHeight);

                    $(".backlogHeaderFloat_totals").show();
                    $('.backlogHeaderFloat_totals').css('top', scrollTop + 15 + filtrosHeight + $('.backlog_dashlet_header').height());
                    //Horizontal scroll
                    if((scrollHorizontal >= trackingOffsetHorizontal) && (scrollHorizontal < trackingOffsetHorizontal + el.width())) {
                        $('.backlogHeaderFloat').css('left', trackingOffsetHorizontal);
                        $('.backlogHeaderFloat_totals').css('left', trackingOffsetHorizontal);
                    }
                    c1HeaderFloat.css({
                        "visibility": "visible"
                    });
                } else {
                    $(".backlogHeaderFloat").hide();
                    $(".backlogHeaderFloat_totals").hide();
                    c1HeaderFloat.css({
                        "visibility": "hidden"
                    });
                };
            });
        }
    },

    comprometer: function(e){
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
        var monto_original = e.currentTarget.getAttribute('data-monto-original');
        var renta_inicial = e.currentTarget.getAttribute('data-renta_inicial');
        var backlog_mes = e.currentTarget.getAttribute('data-mes');
        var backlog_anio = e.currentTarget.getAttribute('data-anio');
        var estatus = e.currentTarget.getAttribute('data-estatus');
        var riPorciento = e.currentTarget.getAttribute('data-porciento');
        var tempPromotor = $("#promotor_filtro").val();
        var ProgresoBL = e.currentTarget.getAttribute('data-progreso');

        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();
        var access = $('#access').val();
        var rolAutorizacion = self.rolAutorizacion;
        var tempProgreso = $("#progreso_filtro").val();

        if(estatus == "Comprometida"){
            app.alert.show('opp_cancelada', {
                level: 'error',
                messages: 'Esta operaci\u00F3n ya ha sido comprometida',
                autoClose: false
            });
            return;
        }

        if(estatus == "Cancelada"){
            app.alert.show('opp_cancelada', {
                level: 'error',
                messages: 'No puede comprometer una operación cancelada',
                autoClose: false
            });
            return;
        }

        if(_.isEmpty(monto)){
            app.alert.show('monto_requerido', {
                level: 'error',
                messages: 'Se requiere un monto comprometido',
                autoClose: false
            });
            return;
        }

        //if(access != "Full_Access") {
            if ($('#anio_filtro').val() <= currentYear) {
                var elaborationBacklog = this.getElaborationBacklog();
            // SI es plazo de directores pero eres promotor OR es plazo de DGA's y no tienes el rol DGA
            /*if ((backlog_mes == elaborationBacklog && currentDay > 15 && currentDay < 19 && rolAutorizacion == "Promotor") ||
            (backlog_mes == elaborationBacklog && currentDay >= 19 && currentDay <= 20 && rolAutorizacion != "DGA")) {*/
                if ((backlog_mes == elaborationBacklog && currentDay == 20 && rolAutorizacion != "DGA")) {
                //var next_month = currentMonth + 2;
                //if ($('#mes_filtro').val() == next_month) {
                    app.alert.show('periodo_de_aprobacion', {
                        level: 'error',
                        messages: 'No cuenta con privilegios para comprometer operaciones de este mes',
                        autoClose: false
                    });
                    return;
                //}
            }/*else{
             if (backlog_mes < elaborationBacklog && rolAutorizacion == "Promotor"){
             app.alert.show('backlog corriente', {
             level: 'error',
             messages: 'Esta operacion no se puede comprometer debido a que el Backlog ya esta corriendo o se encuentra en periodo de revision.',
             autoClose: false
             });
             return;
             }
         }*/
     }
        //}

        if (this.popup_switch == "none") {
            this.popup_switch = "block";
            this.getCurrentYearMonthComprometer();

            this.backlogName = backlogName;
            this.backlogMonto = monto;
            this.backlogRentaInicial = renta_inicial;
            this.backlogId = backlogId;
            this.mes_seleccionado = backlog_mes;
            this.anio_seleccionado = backlog_anio;
            this.riPorciento = riPorciento;
            this.progresoBL = ProgresoBL;

            this.lograda_switch = "block";
            this.mes_switch = "none";
            this.mes_masivo_switch="none";
            this.comentarios_switch = "none";
            this.cancelar_switch = "none";
            this.cancelar_masivo_switch = "none";
            this.revivir_switch = "none";
            this.compromiso_masivo_switch = "none";

        }else {
            this.popup_switch = "none";
            this.mes_switch = "none";
            this.mes_masivo_switch = "none";
            this.comentarios_switch = "none";
            this.cancelar_switch = "none";
            this.cancelar_masivo_switch = "none";
            this.revivir_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";
        }
        self.loadData();
        self.render();
        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);

        //autopopula los campos de mes y anio en el popup de Comprometer;
        //$('#mes_a_comprometer_popup').val(backlog_mes).change();
        $('#mes_a_comprometer_popup').val(0).change();
        $('#anio_a_comprometer_popup').val(backlog_anio).change();
    },

    moverOperacion: function(e){
        console.log('moverOperacion function');
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
                            //SI es un Backlo anterior o igual al mes corriente natural nadie puede
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

    if (this.popup_switch == "none") {
        this.popup_switch = "block";
        this.getCurrentYearMonthMoverMes();

        this.cancel = 'Cancelar';
        this.save = 'Guardar';
        this.backlogName = backlogName;
        this.backlogMonto = monto;
        this.backlogId = backlogId;
        this.progresoBL = ProgresoBL;

        this.mes_switch = "block";
        this.mes_masivo_switch = "none";
        this.comentarios_switch = "none";
        this.cancelar_switch = "none";
        this.cancelar_masivo_switch = "none";
        this.revivir_switch = "none";
        this.lograda_switch = "none";
        this.compromiso_masivo_switch = "none";

    }else {
        this.popup_switch = "none";
        this.mes_switch = "none";
        this.mes_masivo_switch = "none";
        this.comentarios_switch = "none";
        this.cancelar_switch = "none";
        this.cancelar_masivo_switch = "none";
        this.revivir_switch = "none";
        this.lograda_switch = "none";
        this.compromiso_masivo_switch = "none";
    }
    self.loadData();
    self.render();
    self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
},

cancelarBacklog: function(e){

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
    var renta_inicial = e.currentTarget.getAttribute('data-renta_inicial');
    var opp_related = e.currentTarget.getAttribute('data-oppId');
    var estatus = e.currentTarget.getAttribute('data-estatus');
    var backlogMes = e.currentTarget.getAttribute('data-mes');
    var backlogAnio = e.currentTarget.getAttribute('data-anio');
    var tempPromotor = $("#promotor_filtro").val();
    var oppTipo = e.currentTarget.getAttribute('data-oppTipo');
    var tempProgreso = $("#progreso_filtro").val();
    var ProgresoBL = e.currentTarget.getAttribute('data-progreso');
    var rolAutorizacion = self.rolAutorizacion;

    self.mesAnterior = e.currentTarget.getAttribute('data-mes');
        /*
         if(!_.isEmpty(opp_related)){
         app.alert.show('opp_relacionada', {
         level: 'error',
         messages: 'Para cancelar una operación del backlog ligada a una solicitud de crédito se debe cancelar la solicitud',
         autoClose: false
         });
         return;
         }
         */
         if(estatus == "Cancelada"){
            app.alert.show('opp_cancelada', {
                level: 'error',
                messages: 'Esta operaci\u00F3n ya ha sido cancelada',
                autoClose: false
            });
            return;
        }
        /*
         if(oppTipo == 'Original') {
         if (estatus != "Comprometida") {
         app.alert.show('opp_cancelada', {
         level: 'error',
         messages: 'Solo se puede cancelar una operacion original si esta comprometida',
         autoClose: false
         });
         return;
         }
         }
         */
         var currentDay = (new Date).getDate();
         var currentYear = (new Date).getFullYear();
         var BacklogCorriente = this.getElaborationBacklog();

         if(backlogAnio <= currentYear) {
            if (backlogMes <= BacklogCorriente){
                //Operaciones de meses anteriores al actual solo pueden ser canceladas por directores
                if (backlogMes < BacklogCorriente && rolAutorizacion == "Promotor") {
                    app.alert.show('backlog_pasado', {
                        level: 'error',
                        messages: 'La operaci\u00F3n solo puede ser cancelada por directores.',
                        autoClose: false
                    });
                    return;
                }else{
                    //Si esta en proceso de revisión solo dir y/o DGA pueden cancelar validando roles
                    if ((backlogMes == BacklogCorriente && currentDay > 15 && currentDay < 19 && rolAutorizacion == "Promotor") ||
                        (backlogMes == BacklogCorriente && currentDay > 19 && currentDay <= 19 && rolAutorizacion != "DGA")){ //CVV se comenta para cerra periodo de Julio  CVV regresar a 20
                        //if (backlogMes == BacklogCorriente && rolAutorizacion != "DGA"){
                            app.alert.show('backlog_pasado', {
                                level: 'error',
                                messages: 'No cuenta con los privilegios para cancelar operaciones en este periodo.',
                                autoClose: false
                            });
                            return;
                        }else{
                        //Si es el mes actual fuera de periodo de revisión, solo Directores y DGA's
                        if ((currentDay < 16 || currentDay < 21) && rolAutorizacion == "Promotor"){  //CVV se comenta para cerra periodo de Julio
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

            if (this.popup_switch == "none") {
                this.popup_switch = "block";

                this.getCurrentYearMonthPopUp();
                this.cancel = 'Cancelar';
                this.save = 'Guardar';
                this.backlogName = backlogName;
                this.backlogMonto = monto;
                this.backlogRentaInicial = renta_inicial;
                this.backlogId = backlogId;
                this.progresoBL = ProgresoBL;

                this.cancelar_switch = "block";
                this.cancelar_masivo_switch = "none";
                this.revivir_switch = "none";
                this.comentarios_switch = "none";
                this.mes_switch = "none";
                this.mes_masivo_switch="none";
                this.lograda_switch = "none";
                this.compromiso_masivo_switch = "none";

            }else {
                this.popup_switch = "none";
                this.cancelar_switch = "none";
                this.cancelar_masivo_switch = "none";
                this.revivir_switch = "none";
                this.comentarios_switch = "none";
                this.mes_switch = "none";
                this.mes_masivo_switch="none";
                this.lograda_switch = "none";
                this.compromiso_masivo_switch = "none";
            }
            self.loadData();
            self.render();
            self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);

        },

        revivir: function(e){

            var tempMes = $("#mes_filtro").val();
            var tempAnio = $("#anio_filtro").val();
            var tempRegion = $("#region_filtro").val();
            var tempTipoOperacion = $("#tipo_operacion_filtro").val();
            var tempEtapa = $("#etapa_filtro").val();
            var tempEstatus = $("#estatus_filtro").val();
            var tempEquipo = $("#equipo_filtro").val();
            var tempPromotor = $("#promotor_filtro").val();
            var tempProgreso = $("#progreso_filtro").val();

            var backlogId = e.currentTarget.getAttribute('data-id');
            var backlogName = e.currentTarget.getAttribute('data-name');
            var monto = e.currentTarget.getAttribute('data-monto');
            var renta_inicial = e.currentTarget.getAttribute('data-renta_inicial');
            var backlogMes = e.currentTarget.getAttribute('data-mes');
            var backlogAnio = e.currentTarget.getAttribute('data-anio');
            var ProgresoBL = e.currentTarget.getAttribute('data-progreso');
            var estatus = e.currentTarget.getAttribute('data-estatus');

            if (estatus != 'Cancelada'){
                app.alert.show('Operacion Activa', {
                    level: 'error',
                    messages: 'Unicamente pueden revivirse operaciones canceladas.',
                    autoClose: false
                });
                return;
            }


            if (this.popup_switch == "none") {
                this.popup_switch = "block";

                this.getCurrentYearMonthPopUp();
            // SI el usuario NO es promotor, puede revivir para el mismo mes
            if(self.rolAutorizacion != "Promotor"){
                var opciones_mes = app.lang.getAppListStrings('mes_list');
                for (meses_keys in opciones_mes) {
                    if(backlogMes == meses_keys){
                        this.meses_list_popup_html = '<option value="' + meses_keys + '">' + opciones_mes[meses_keys] + '</option>' + this.meses_list_popup_html;
                    }
                }
            }
            this.cancel = 'Cancelar';
            this.save = 'Guardar';
            this.backlogName = backlogName;
            this.backlogMonto = monto;
            this.backlogRentaInicial = renta_inicial;
            this.backlogId = backlogId;
            this.progresoBL = ProgresoBL;

            this.revivir_switch = "block";
            this.cancelar_switch = "none";
            this.cancelar_masivo_switch = "none";
            this.comentarios_switch = "none";
            this.mes_switch = "none";
            this.mes_masivo_switch="none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";

        }else {
            this.popup_switch = "none";
            this.cancelar_switch = "none";
            this.cancelar_masivo_switch = "none";
            this.revivir_switch = "none";
            this.comentarios_switch = "none";
            this.mes_switch = "none";
            this.mes_masivo_switch="none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";
        }
        self.loadData();
        self.render();
        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);

    },

    comentarioBacklog: function(e){

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
        var monto_real = e.currentTarget.getAttribute('data-mreal');
        var comentarios_existentes = e.currentTarget.getAttribute('data-comentarios');
        var tempPromotor = $("#promotor_filtro").val();
        var tempProgreso = $("#progreso_filtro").val();
        var ProgresoBL = e.currentTarget.getAttribute('data-progreso');

        if (this.popup_switch == "none") {
            this.popup_switch = "block";

            this.cancel = 'Cancelar';
            this.save = 'Guardar';
            this.backlogName = backlogName;
            this.backlogMonto = monto;
            this.backlogMonto_Real = monto_real;
            this.backlogId = backlogId;
            this.comentarios_existentes = comentarios_existentes;
            this.progresoBL = ProgresoBL;

            this.comentarios_switch = "block";
            this.mes_switch = "none";
            this.mes_masivo_switch="none";
            this.cancelar_switch = "none";
            this.cancelar_masivo_switch = "none";
            this.revivir_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";

        }else {
            this.popup_switch = "none";
            this.comentarios_switch = "none";
            this.mes_switch = "none";
            this.mes_masivo_switch="none";
            this.cancelar_switch = "none";
            this.cancelar_masivo_switch = "none";
            this.revivir_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";
        }
        self.loadData(); self.render();
        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
    },

    persistData: function(mesFiltro, anioFiltro, regionFiltro, tipoOppFiltro, etapaFiltro, estatusFiltro, equipoFiltro, promotorFiltro, progreso,checks,checks_cancel){

        self.floatHeader();
        _.each(self.seleccionarColumnas, function(key, value) {

            $('.' + value).show();
            $('#' + value).show();
            if(key == 'ON'){
                $('#sel_columnas option[value=' + value + ']').attr('selected','selected');
            }
        });
        self.ejecutaOcultarColumnas();
        $(".backlogInfo").show();

        $("#mes_filtro").val(mesFiltro);
        $("#anio_filtro").val(anioFiltro);
        $("#region_filtro").val(regionFiltro);
        $("#tipo_operacion_filtro").val(tipoOppFiltro);
        $("#etapa_filtro").val(etapaFiltro);

        if(!_.isEmpty(estatusFiltro)){
            $("#estatus_filtro").select2('val' ,estatusFiltro);
        }

        $("#equipo_filtro").val(equipoFiltro);
        $("#promotor_filtro").val(promotorFiltro);
        $("#progreso_filtro").val(progreso);

        $('.mass_update').each(function (index, value) {
            $(self.seleccionados).each(function(key, id){
                if($(value).val() == id){
                    $(value).prop('checked', true);
                }
            });
        });

        //Persiste Columnas Escondidas
        $(self.columnas_escondidas).each(function(index, column_class){
            $('#' + column_class).prop('checked', true);
            $('.' + column_class).hide();
        });

        //Persiste checkbox seleccionados
        var longarray=0;
        var longarray_cancel=0;
        if(checks !==undefined){
            longarray=checks.length;
            if(longarray>0){
                for(var i=0;i<longarray;i++){
                    var currentIdData=""+checks[i].getAttribute('data-id');
                    $('input[type="checkbox"][data-id='+currentIdData+']').attr('checked',true)
                }
            }
            /*else{
                $('input[type="checkbox"]').attr('checked', false);
            }
            */

        }

        if(checks_cancel !==undefined){
            longarray_cancel=checks_cancel.length;
            if(longarray_cancel>0){
                for(var i=0;i<longarray_cancel;i++){
                    var currentIdDataCancel=""+checks_cancel[i].getAttribute('data-id');
                    $('input[type="checkbox"][data-id='+currentIdDataCancel+']').attr('checked',true)
                }

            }
            /*    
            else{
                $('input[type="checkbox"]').attr('checked', false);
            }
            */
        }

        if(longarray==0 && longarray_cancel==0 ){
            $('input[type="checkbox"]').attr('checked', false);

        }
        console.log("PERSIST");
        console.log(checks);
        console.log(checks_cancel);


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

    popupCancel: function(){

        var tempMes = $("#mes_filtro").val();
        var tempAnio = $("#anio_filtro").val();
        var tempRegion = $("#region_filtro").val();
        var tempTipoOperacion = $("#tipo_operacion_filtro").val();
        var tempEtapa = $("#etapa_filtro").val();
        var tempEstatus = $("#estatus_filtro").val();
        var tempEquipo = $("#equipo_filtro").val();
        var tempPromotor = $("#promotor_filtro").val();
        var tempProgreso = $("#progreso_filtro").val();

        this.popup_switch = "none";

        self.loadData(); self.render();
        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
        this.array_checks=[];
        this.array_checks_cancelar=[];
    },

    /*
     AF: 21/12/17
     Ajuste para guardado de modificación a backlog
     */
     popupSave: function(e){
        //Si no existe proceso de guardado incia petición
        if (this.saving == 0){
            console.log('tct-popupSave function');
            this.saving = 1;

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


            if(this.comentarios_switch == "block") {
                console.log('tct-1st If');
                var description = $('#newBacklogDescription').val();
                var Params = {
                    'backlogId': this.backlogId,
                    'backlogName': this.backlogName,
                    'description': description,
                };
                var Url = app.api.buildURL("BacklogComentarios", '', {}, {});
                app.api.call("create", Url, {data: Params}, {
                    success: _.bind(function (data) {
                        if (self.disposed) {
                            this.saving = 0;
                            return;
                        }
                        self.popup_switch = "none";
                        self.comentarios_switch = "none";
                        this.revivir_switch = "none";
                        this.mes_switch = "none";
                        this.mes_masivo_switch="none";
                        this.cancelar_switch = "none";
                        this.cancelar_masivo_switch = "none";
                        this.lograda_switch = "none";
                        this.compromiso_masivo_switch = "none";
                        self.loadData(); self.render();
                        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
                        this.saving = 0;
                    },this)
                });
            }
            if(this.revivir_switch == "block"){

                var Monto = $('#monto_operacion_rev').html();
                var RentaInicial = $('#ri_operacion_rev').html();
                var comentarios = $('#comentarios_revivir').val();
                var mes = $('.mes_revivir').val();
                var anio = $('.anio_revivir').val();
                var tempMes = $("#mes_filtro").val();
                var tempAnio = $("#anio_filtro").val();

                var Params = {
                    'backlogId': this.backlogId,
                    'backlogName': this.backlogName,
                    'Monto': Monto,
                    'RentaInicial': RentaInicial,
                    'Comentarios': comentarios,
                    'Mes': mes,
                    'Anio': anio,
                    'MesAnterior': tempMes,
                    'AnioAnterior': tempAnio,
                };
                $(".savingIcon").show();
                var Url = app.api.buildURL("RevivirBacklog", '', {}, {});
                app.api.call("create", Url, {data: Params}, {
                    success: _.bind(function (data) {
                        if (self.disposed) {
                            this.saving = 0;
                            $(".savingIcon").hide();
                            return;
                        }
                        $(".savingIcon").hide();
                        self.popup_switch = "none";
                        self.revivir_switch = "none";
                        this.cancelar_switch = "none";
                        this.cancelar_masivo_switch = "none";
                        this.comentarios_switch = "none";
                        this.mes_switch = "none";
                        this.mes_masivo_switch="none";
                        this.lograda_switch = "none";
                        this.compromiso_masivo_switch = "none";
                        self.loadData();
                        self.render();
                        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
                        this.saving = 0;
                    },this)
                });
            }
            if(this.cancelar_switch == "block"){
                var MotivoCancelacion = $('#motivo_de_cancelacion_popup').val();
                var MontoReal = $('#monto_cancelacion_popup').html();
                var RentaReal = $('#renta_cancelacion_popup').html();
                var comentarios = $('#comentarios_de_cancelacion').val();
                var mes = $('.mes_popup').val();
                var anio = $('.anio_popup').val();
                var Competencia = $('#quien_opcion').val();
                var Producto = $('#producto_opcion').val();


                //app alert para validar y notificar que los campos quien y producto contengan información.

                if( Competencia == null || Competencia == "" || Competencia.length ==0 ) {

                    if(MotivoCancelacion == 'Competencia') {

                        app.alert.show('alertquien', {
                            level: 'error',
                            messages: 'El campo ¿Qui\u00E9n? es requerido',
                            autoClose: true
                        });
                        this.saving = 0;
                        return;
                    }

                    //check++;
                }
                if(Producto == null || Producto == "" || Producto.length==0 ) {

                    if(MotivoCancelacion == 'No tenemos el producto que requiere') {
                        app.alert.show('alertproducto', {
                            level: 'error',
                            messages: 'El campo ¿Qu\u00E9 Producto? es requerido',
                            autoClose: true
                        });
                        this.saving = 0;
                        return;
                    }

                    //check++;
                }
                /*if(check>0){
                    return;
                }*/

                console.log('Progreso' + self.progresoBL);

                if(self.progresoBL == 'SI'){
                    if (self.rolAutorizacion == 'DGA'){
                        if(!confirm('El Bl cuenta con operaciones en Pipe.  ¿Desea cancelar?')){
                            this.saving = 0;
                            return;
                        }
                    }else {
                        app.alert.show('Operaciones en Pipe', {
                            level: 'error',
                            messages: 'El BL no puede ser cancelado debido a que tiene operaciones en pipeline',
                            autoClose: true
                        });
                        this.saving = 0;
                        return;
                    }
                }

                if(_.isEmpty(MotivoCancelacion)){
                    app.alert.show('motivo_requerido', {
                        level: 'error',
                        messages: 'El motivo de cancelaci\u00F3n es requerido',
                        autoClose: true
                    });
                    this.saving = 0;
                    return;
                }

                if (MotivoCancelacion == 'Mes posterior' && mes == 0){
                    app.alert.show('Mes requerido', {
                        level: 'error',
                        messages: 'Debe indicar el mes para el nuevo Backlog.',
                        autoClose: true
                    });
                    this.saving = 0;
                    return;
                }

                //CVV - Se agrega el motivo de cancelación a los comentarios
                var currentYear = (new Date).getFullYear();
                var currentMonth = ((new Date).getMonth()) + 1;
                var currentDay = (new Date).getDate();
                var fechaCancelacion = currentMonth + '/' + currentDay + '/' + currentYear;
                comentarios += '\r\n' + "UNI2CRM - " + fechaCancelacion + ": MOTIVO DE CANCELACION -> " + MotivoCancelacion;

                var Params = {
                    'backlogId': this.backlogId,
                    'backlogName': this.backlogName,
                    'MotivoCancelacion': MotivoCancelacion,
                    'MontoReal': MontoReal,
                    'RentaReal': RentaReal,
                    'Comentarios': comentarios,
                    'Mes': mes,
                    'Anio': anio,
                    'MesAnterior': tempMes,
                    'AnioAnterior': tempAnio,
                    'Competencia': Competencia,
                    'Producto': Producto,
                };

                var Url = app.api.buildURL("BacklogCancelar", '', {}, {});
                $(".savingIcon").show();
                app.api.call("create", Url, {data: Params}, {
                    success: _.bind(function (data) {
                        if (self.disposed) {
                            $(".savingIcon").hide();
                            this.saving = 0;
                            return;
                        }
                        $(".savingIcon").hide();
                        self.popup_switch = "none";
                        self.cancelar_switch = "none";
                        this.cancelar_masivo_switch = "none";
                        this.revivir_switch = "none";
                        this.comentarios_switch = "none";
                        this.mes_switch = "none";
                        this.mes_masivo_switch="none";
                        this.lograda_switch = "none";
                        this.compromiso_masivo_switch = "none";
                        self.loadData(); self.render();
                        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
                        this.saving = 0;
                    },this)
                });
            }
            if(this.mes_switch == "block"){
                console.log('tct-mes_switch');
                var mes_popup = $('.mes_switch_popup').val();
                var anio_popup = $('.anio_switch_popup').val();
                var current_backlog = $('#mes_filtro').val();

                //Validar que la Persona de Backlog no cuente con Backlogs en el mismo mes
                var idBacklog=this.backlogId;
                //Obteniendo id de persona
                var bl=$('.MoverOperacion[data-id="'+idBacklog+'"]');
                var str=bl.closest('tr').children('.hide_cliente').children('a').attr('href');

                var arr_p=str.split('#Accounts/');

                var id_account=arr_p[1];
                /*
                var params={
                    'fields':"id,mes",
                    //'filter':[{'account_id_c':id_account}],
                    'filter':[
                        {
                            "$and":[
                                {
                                    "account_id_c":{
                                        "$equals":id_account
                                    }
                                },
                                {
                                    "mes":{
                                        "$equals":mes_popup
                                    }
                                }
                            ]

                        }
                    ]

                };
                */

                var bl_url = app.api.buildURL('lev_Backlog?filter[0][account_id_c][$equals]='+id_account+'&filter[1][mes][$equals]='+mes_popup+'&fields=id,mes,estatus_de_la_operacion',
                    null, null, null);


                app.api.call('GET', bl_url, {}, {
                   success: function (data) {
                       var meses =['0','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
                       if(data.records.length>0){

                           app.alert.show('error_bl_mes', {
                               level: 'error',
                               messages: 'Esta Cuenta ya posee un backlog en el mes: '+meses[data.records[0].mes],
                               autoClose: false
                           });
                           this.saving = 0;
                           return;

                       }


                   }


               });



                if(_.isEmpty(anio_popup)){
                    app.alert.show('anio requerido', {
                        level: 'error',
                        messages: 'Favor de completar la informacion.',
                        autoClose: false
                    });
                    this.saving = 0;
                    return;
                }



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
                    'backlogId': this.backlogId,
                    'backlogName': this.backlogName,
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
                console.log('tct-create moverOperacion');
                $(".savingIcon").show();
                var Url = app.api.buildURL("MoverOperacion", '', {}, {});
                app.api.call("create", Url, {data: Params}, {
                    success: _.bind(function (data) {
                        console.log('dataresult');
                        console.log(data);
                        if (self.disposed) {
                            this.saving = 0;
                            $(".savingIcon").hide();
                            return;
                        }

                        if(!_.isEmpty(data)){
                            alert(data);
                        }

                        $(".savingIcon").hide();
                        console.log('concluye ok');
                        self.popup_switch = "none";
                        self.cancelar_switch = "none";
                        this.cancelar_masivo_switch = "none";
                        this.revivir_switch = "none";
                        this.comentarios_switch = "none";
                        this.mes_switch = "none";
                        this.mes_masivo_switch="none";
                        this.lograda_switch = "none";
                        this.compromiso_masivo_switch = "none";
                        self.loadData(); self.render();
                        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
                        this.saving = 0;
                    },this)
                });
            }
            if(this.lograda_switch == "block"){
                if ($('#mes_a_comprometer_popup').val() == 0){
                    app.alert.show('Mes requerido', {
                        level: 'error',
                        messages: 'Debe indicar el mes al que se comprometera el Backlog.',
                        autoClose: true
                    });
                    this.saving = 0;
                    return;
                }

                var currentYear = (new Date).getFullYear();
                var currentMonth = this.backlogMonth();

                if($('.anio_a_comprometer_popup').val() <= currentYear){
                    if($('#mes_a_comprometer_popup').val() > currentMonth){
                        tipo_opp = "Original";
                    }
                    else if($('#mes_a_comprometer_popup').val() == currentMonth){
                        tipo_opp = "Adicional";
                    }else{
                        tipo_opp = "Adicional";
                    }
                }else{
                    tipo_opp = "Original";
                }

                var Params = {
                    'backlogId': this.backlogId,
                    'backlogName': this.backlogName,
                    'monto_comprometido': $('#monto_a_comprometer').val(),
                    'renta_comprometida': $('#renta_a_comprometer').val(),
                    'mes': $('#mes_a_comprometer_popup').val(),
                    'anio': $('.anio_a_comprometer_popup').val(),
                    'tipo_operacion': tipo_opp,
                    'rolAutorizacion': self.rolAutorizacion,
                    'RI': $('#ri_porciento').val(),
                };
                var Url = app.api.buildURL("OperacionLograda", '', {}, {});
                app.api.call("create", Url, {data: Params}, {
                    success: _.bind(function (data) {
                        if (self.disposed) {
                            this.saving = 0;
                            return;
                        }
                        self.popup_switch = "none";
                        self.cancelar_switch = "none";
                        this.cancelar_masivo_switch = "none";
                        this.revivir_switch = "none";
                        this.comentarios_switch = "none";
                        this.mes_switch = "none";
                        this.mes_masivo_switch="none";
                        this.lograda_switch = "none";
                        this.compromiso_masivo_switch = "none";
                        self.loadData();
                        self.render();
                        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
                        this.saving = 0;
                    },this)
                });
            }
            if(this.compromiso_masivo_switch == "block"){

                var currentYear = (new Date).getFullYear();
                var currentMonth = this.backlogMonth();

                if($('#anio_a_comprometer_mass_popup').val() <= currentYear){
                    if($('#mes_a_comprometer_mass_popup').val() > currentMonth){
                        tipo_opp = "Original";
                    }
                    else if($('#mes_a_comprometer_popup').val() == currentMonth){
                        tipo_opp = "Adicional";
                    }else{
                        tipo_opp = "Adicional";
                    }
                }else{
                    tipo_opp = "Original";
                }

                var Params = {
                    'backlogs': this.seleccionados,
                    'mes': $('#mes_a_comprometer_mass_popup').val(),
                    'anio': $('#anio_a_comprometer_mass_popup').val(),
                    'tipo_operacion': tipo_opp,
                };
                var Url = app.api.buildURL("MassComprometer", '', {}, {});
                app.api.call("create", Url, {data: Params}, {
                    success: _.bind(function (data) {
                        if (self.disposed) {
                            this.saving = 0;
                            return;
                        }
                        self.popup_switch = "none";
                        self.cancelar_switch = "none";
                        this.cancelar_masivo_switch = "none";
                        this.comentarios_switch = "none";
                        this.revivir_switch = "none";
                        this.mes_switch = "none";
                        this.mes_masivo_switch="none";
                        this.lograda_switch = "none";
                        this.compromiso_masivo_switch = "none";
                        self.seleccionados = [];
                        self.loadData(); self.render();
                        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
                        this.saving = 0;
                    },this)
                });
            }
            //this.saving = 0;

            //Nueva condición para mover mes masivo
            if(this.mes_masivo_switch == "block"){

                console.log('tct-mes_masivo_switch');
                var mes_popup = $('.mes_switch_masivo_popup').val();
                var anio_popup = $('.anio_masivo_switch_popup').val();
                var current_backlog = $('#mes_filtro').val();

                if(_.isEmpty(anio_popup)){
                    app.alert.show('anio requerido', {
                        level: 'error',
                        messages: 'Favor de completar la informacion.',
                        autoClose: false
                    });
                    this.saving = 0;
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
                        var arr_p=str.split('#Accounts/');
                        var id_account=arr_p[1];

                        var bl_url = app.api.buildURL('lev_Backlog?filter[0][account_id_c][$equals]='+id_account+'&filter[1][mes][$equals]='+mes_popup+'&filter[2][anio][$equals]='+anio_popup+'&fields=id,mes,estatus_de_la_operacion,name',
                            null, null, null);

                        $(".savingIcon").show();

                        app.api.call('GET', bl_url, {}, {
                            success: _.bind(function (data) {
                                $(".savingIcon").hide();

                                var meses =['0','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
                                if(data.records.length>0){
                                    var name_bl=data.records[0].name;
                                    var arr_for_cuenta=name_bl.split('-');

                                    app.alert.show('error_bl_mes', {
                                        level: 'error',
                                        messages: 'La cuenta: '+arr_for_cuenta[2]+' ya posee un backlog en el mes: '+meses[data.records[0].mes],
                                        autoClose: false
                                    });
                                    this.saving = 0;
                                    return;


                                }else{
                                    this.controlCount++;
                                    if(this.controlCount==this.checks_actualizar.length){
                                        this.moverOperacionAfterValidate(mes_popup,anio_popup,tempMes,tempAnio,tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
                                    }

                                }
                                this.count++;


                            },this)

                        });

                    }


                }

            }

            //Nueva condición para cancelar masivamente
            if(this.cancelar_masivo_switch == "block"){

                var arr_posiciones=[];

                var MotivoCancelacion = $('#motivo_de_cancelacion_masivo_popup').val();
                //var MontoReal = $('#monto_cancelacion_popup').html();
                //var RentaReal = $('#renta_cancelacion_popup').html();
                var comentarios = $('#comentarios_de_cancelacion_masivo').val();
                var mes = $('.mes_masivo_popup').val();
                var anio = $('.anio_masivo_popup').val();

                var Competencia = $('#quien_opcion_masivo').val();
                var Producto = $('#producto_opcion_masivo').val();


                //app alert para validar y notificar que los campos quien y producto contengan información.

                if( Competencia == null || Competencia == "" || Competencia.length==0 ) {

                    if(MotivoCancelacion == 'Competencia') {

                        app.alert.show('alertquien', {
                            level: 'error',
                            messages: 'El campo ¿Qui\u00E9n? es requerido',
                            autoClose: true
                        });
                        this.saving = 0;
                        return;
                    }

                }
                if(Producto == null || Producto == "" || Producto.length==0) {

                    if(MotivoCancelacion == 'No tenemos el producto que requiere') {
                        app.alert.show('alertproducto', {
                            level: 'error',
                            messages: 'El campo ¿Qu\u00E9´Producto? es requerido',
                            autoClose: true
                        });
                        this.saving = 0;
                        return;
                    }

                }

                console.log('Progreso' + self.progresoBL);

                var countChecksCancelar=this.checks_cancelar.length;


                if(countChecksCancelar>0) {
                    for (var i = 0; i < countChecksCancelar; i++) {
                        //e.currentTarget.getAttribute('data-progreso');
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
                    app.alert.show('motivo_requerido', {
                        level: 'error',
                        messages: 'El motivo de cancelaci\u00F3n es requerido',
                        autoClose: true
                    });
                    this.saving = 0;
                    return;
                }

                if (MotivoCancelacion == 'Mes posterior' && mes == 0){
                    app.alert.show('Mes requerido', {
                        level: 'error',
                        messages: 'Debe indicar el mes para el nuevo Backlog.',
                        autoClose: true
                    });
                    this.saving = 0;
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
                            $(".savingIcon").show();
                            var Url = app.api.buildURL("BacklogCancelar", '', {}, {});
                            app.api.call("create", Url, {data: Params}, {
                                success: _.bind(function (data) {
                                    successCountCancelar++;
                                    if (self.disposed) {
                                        this.saving = 0;
                                        $(".savingIcon").hide();
                                        return;
                                    }

                                    if(successCountCancelar==countChecksCancelar){
                                        self.handleViewsAfterCall(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
                                    //$('input[type="checkbox"]').attr('checked', false);

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
                }

            }
        },


        moverOperacionAfterValidate:function(mes_popup,anio_popup,tempMes,tempAnio,tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso){
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
                    console.log('tct-create moverOperacion');
                    $(".savingIcon").show();
                    var Url = app.api.buildURL("MoverOperacion", '', {}, {});
                    app.api.call("create", Url, {data: Params}, {
                        success: _.bind(function (data) {
                            console.log('dataresult');
                            console.log(data);
                            successCount++;
                            if (self.disposed) {
                                this.saving = 0;
                                $(".savingIcon").hide();
                                return;
                            }

                            if(!_.isEmpty(data)){
                                alert(data);
                            }

                            //Validación para saber si se ejecutó el último índice
                            if(successCount==countChecks){
                                self.handleViewsAfterCall(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);

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

        handleViewsAfterCall:function(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso){

            $(".savingIcon").hide();
            console.log('concluye ok');
            self.popup_switch = "none";
            self.cancelar_switch = "none";
            this.cancelar_masivo_switch = "none";
            this.revivir_switch = "none";
            this.comentarios_switch = "none";
            this.mes_switch = "none";
            this.mes_masivo_switch="none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";

            this.array_checks=[];
            this.array_checks_cancelar=[];

            self.loadData(); self.render();
            self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);

            this.saving = 0;

        },

        getCurrentYearMonthPopUp: function(){

            var tempMes = $("#mes_filtro").val();
            var tempAnio = $("#anio_filtro").val();
            var tempRegion = $("#region_filtro").val();
            var tempTipoOperacion = $("#tipo_operacion_filtro").val();
            var tempEtapa = $("#etapa_filtro").val();
            var tempEstatus = $("#estatus_filtro").val();
            var tempEquipo = $("#equipo_filtro").val();
            var tempPromotor = $("#promotor_filtro").val();
            var tempProgreso = $("#progreso_filtro").val();

            var currentYear = (new Date).getFullYear();
            //var currentMonth = (new Date).getMonth() + 1;
            var currentMonth = (new Date).getMonth();
            var currentDay = (new Date).getDate();

            var anio_popup = $('.anio_popup').val();
            var mes_popup = $('.mes_popup').val();
            var motivo_de_cancelacion_popup = $('#motivo_de_cancelacion_popup').val();

            var anio_masivo_popup = $('.anio_masivo_popup').val();
            var mes__masivo_popup = $('.mes_masivo_popup').val();
            var motivo_de_cancelacion_masivo_popup = $('#motivo_de_cancelacion_masivo_popup').val();

            if(typeof anio_popup === "undefined"){
                anio_popup = currentYear;
            }

        /*
            if(currentDay <= 20 && (currentMonth) <= tempMes){
                currentMonth += 1;
            }

            if(currentDay > 20 && (currentMonth) == tempMes){
                currentMonth += 1;
            }

        if (currentMonth > 12){  //Si resulta mayor a diciembre
            currentMonth = currentMonth - 12;
        }
        */

        if(currentDay <= 20){
            currentMonth += 1;
        }
        if(currentDay > 20){
            currentMonth += 2;
        }

        if(currentMonth == tempMes){
            currentMonth += 1;
        }

        if (currentMonth > 12){  //Si resulta mayor a diciembre
            currentMonth = currentMonth - 12;
        }

            //Valida número de mes actual
            var limitMonth = currentMonth + 2;
            var nextMonth = 0;
            var nextYear = currentYear;
            if (limitMonth > 12) {
                nextMonth = limitMonth - 12;
                nextYear = currentYear + 1;
            }


            var opciones_year = app.lang.getAppListStrings('anio_list');
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

            var anios_list_popup_cancelar = '';
            for (var anios_keys in opciones_year) {
                anios_list_popup_cancelar += '<option value="' + anios_keys + '">' + opciones_year[anios_keys] + '</option>'

            }
            this.anio_list_html = anios_list_popup_cancelar;


            var opciones_mes = app.lang.getAppListStrings('mes_list');

                //Quita meses para año futuro
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

                if(anio_masivo_popup > currentYear){
                    Object.keys(opciones_mes).forEach(function(key){
                        if(key != ''){
                            if(key > nextMonth){
                                delete opciones_mes[key];
                            }
                        }
                    });
                }
            //Quita meses para año actual
            if(anio_masivo_popup == currentYear || anio_popup ==""){
                Object.keys(opciones_mes).forEach(function(key){
                    if(key != ''){
                        //Quita meses fuera de rango(3 meses)
                        if(key < currentMonth || key >limitMonth ){
                            delete opciones_mes[key];
                        }
                    }
                });
            }
            



            var meses_keys = opciones_mes;

            var meses_list_popup_html = '<option value="' + 0 + '">SELECCIONAR</option>';
            for (meses_keys in opciones_mes) {
                meses_list_popup_html += '<option value="' + meses_keys + '">' + opciones_mes[meses_keys] + '</option>'

            }
            this.meses_list_popup_html = meses_list_popup_html;

            this.render();

        //var temp=_.isEmpty(this.array_checks) ? this.array_checks_cancelar:this.array_checks;

        this.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor,tempProgreso,this.array_checks,this.array_checks_cancelar);

        $('.anio_popup').val(anio_popup);
        $('.mes_popup').val(mes_popup);
        $('#motivo_de_cancelacion_popup').val(motivo_de_cancelacion_popup);

        $('.anio_masivo_popup').val(anio_masivo_popup);
        $('.mes_masivo_popup').val(mes__masivo_popup);
        $('#motivo_de_cancelacion_masivo_popup').val(motivo_de_cancelacion_masivo_popup);
    },

    getCurrentYearMonthMoverMes: function(){

        var tempMes = $("#mes_filtro").val();
        var tempAnio = $("#anio_filtro").val();
        var tempRegion = $("#region_filtro").val();
        var tempTipoOperacion = $("#tipo_operacion_filtro").val();
        var tempEtapa = $("#etapa_filtro").val();
        var tempEstatus = $("#estatus_filtro").val();
        var tempEquipo = $("#equipo_filtro").val();
        var tempPromotor = $("#promotor_filtro").val();
        var tempProgreso = $("#progreso_filtro").val();

        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();

        var anio_popup = $('.anio_switch_popup').val();
        var anio_masivo_popup = $('.anio_masivo_switch_popup').val();
        var tempmes_switch_popup = $(".mes_switch_popup").val();
        var tempmes_masivo_switch_popup = $(".mes_switch_masivo_popup").val();

        if(typeof anio_popup === "undefined"){
            anio_popup = currentYear;
        }

        
        if(typeof anio_masivo_popup === "undefined"){
            anio_masivo_popup = currentYear;
        }
        

        if(currentDay <= 20){
            currentMonth += 1;
        }
        if(currentDay > 20){
            currentMonth += 2;
        }

        if(currentMonth == tempMes){
            currentMonth += 1;
        }

        if (currentMonth > 12){  //Si resulta mayor a diciembre
            currentMonth = currentMonth - 12;
        }

        //Valida número de mes actual
        var limitMonth = currentMonth + 2;
        var nextMonth = 0;
        var nextYear = currentYear;
        if (limitMonth > 12) {
            nextMonth = limitMonth - 12;
            nextYear = currentYear + 1;
        }


        var opciones_year = app.lang.getAppListStrings('anio_list');
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
        //this.anio_list_html.options = opciones_year;

        var anios_list_popup_mover_mes = '';
        for (var anios_keys in opciones_year) {
            anios_list_popup_mover_mes += '<option value="' + anios_keys + '">' + opciones_year[anios_keys] + '</option>'

        }
        this.anio_list_html = anios_list_popup_mover_mes;


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
        /*
        if(anio_popup){
            if(anio_popup <= currentYear){
                Object.keys(opciones_mes).forEach(function(key){
                    if (self.mesNaturalCerrado == 1 && self.rolAutorizacion != "DGA"){
                        if(key < (currentMonth+1)){ // CVV PARA CERRAR PERIODO NATURAL
                            delete opciones_mes[key];
                        }
                    }else{
                        if(key < currentMonth){
                            delete opciones_mes[key];
                        }
                    }
                });
            }

        }
        */

        if(anio_masivo_popup){
            if(anio_masivo_popup <= currentYear){
                Object.keys(opciones_mes).forEach(function(key){
                    if (self.mesNaturalCerrado == 1 && self.rolAutorizacion != "DGA"){
                        if(key < (currentMonth+1)){ // CVV PARA CERRAR PERIODO NATURAL
                            delete opciones_mes[key];
                        }
                    }else{
                        if(key < currentMonth){
                            delete opciones_mes[key];
                        }
                    }
                });
            }
        }
        

        /*
        if(anio_masivo_popup <= currentYear){
            Object.keys(opciones_mes).forEach(function(key){
                if (self.mesNaturalCerrado == 1 && self.rolAutorizacion != "DGA"){
                    if(key < (currentMonth+1)){ // CVV PARA CERRAR PERIODO NATURAL
                        delete opciones_mes[key];
                    }
                }else{
                    if(key < currentMonth){
                        delete opciones_mes[key];
                    }
                }
            });
        }
        */

        var meses_keys = opciones_mes;

        var meses_list_popup_mover_mes = '';
        for (meses_keys in opciones_mes) {
            meses_list_popup_mover_mes += '<option value="' + meses_keys + '">' + opciones_mes[meses_keys] + '</option>'

        }
        this.meses_list_popup_mover_mes = meses_list_popup_mover_mes;

        this.render();

        //var temp=_.isEmpty(this.array_checks) ? this.array_checks_cancelar:this.array_checks;

        this.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor,tempProgreso,this.array_checks,this.array_checks_cancelar);
        $('.anio_switch_popup').val(anio_popup);
        $('.mes_switch_popup').val(tempmes_switch_popup);

        $('.mes_switch_masivo_popup').val(tempmes_masivo_switch_popup);
        $('.anio_masivo_switch_popup').val(anio_masivo_popup);
    },

    exportarXL: function () {
        this.cargarBacklogs();
        var backlog_options = {
            'backlogs': this.backlogs,
        }

        var backlogUrl = app.api.buildURL("CrearArchivoCSV", '', {}, {});
        app.api.call("create", backlogUrl, {data: backlog_options}, {
            success: _.bind(function (data) {
                window.open("#bwc/index.php?entryPoint=exportarBacklog&backlog_doc=" + data);
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

    ComprometerMasivo: function(){

        if(_.isEmpty(this.seleccionados)){
            app.alert.show('compromiso masivo', {
                level: 'error',
                messages: 'Por lo menos un registro debe ser seleccionado',
                autoClose: false
            });
            return;
        }

        var tempMes = $("#mes_filtro").val();
        var tempAnio = $("#anio_filtro").val();
        var tempRegion = $("#region_filtro").val();
        var tempTipoOperacion = $("#tipo_operacion_filtro").val();
        var tempEtapa = $("#etapa_filtro").val();
        var tempEstatus = $("#estatus_filtro").val();
        var tempEquipo = $("#equipo_filtro").val();
        var tempPromotor = $("#promotor_filtro").val();
        var tempProgreso = $("#progreso_filtro").val();

        if (this.popup_switch == "none") {
            this.popup_switch = "block";

            this.cancel = 'Cancelar';
            this.save = 'Guardar';

            this.compromiso_masivo_switch = "block";
            this.comentarios_switch = "none";
            this.mes_switch = "none";
            this.mes_masivo_switch="none";
            this.cancelar_switch = "none";
            this.cancelar_masivo_switch = "none";
            this.lograda_switch = "none";

            var backlog_options = {
                'backlogs': this.seleccionados,
            }

            var backlogUrl = app.api.buildURL("MassUpdateCount", '', {}, {});
            app.api.call("create", backlogUrl, {data: backlog_options}, {
                success: _.bind(function (data) {
                    if (self.disposed) {
                        return;
                    }

                    // console.log(data);
                    self.backlogMass_Monto = data.monto_comprometido;
                    self.backlog_mass_count = data.operaciones;

                    self.loadData(); self.render();
                    self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);

                })
            });

        }else {
            this.popup_switch = "none";
            this.comentarios_switch = "none";
            this.mes_switch = "none";
            this.mes_masivo_switch="none";
            this.cancelar_switch = "none";
            this.cancelar_masivo_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";
        }

        self.loadData(); self.render();
        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);

        //autopopula los campos de mes y anio en el popup de Comprometer;
        $('#mes_a_comprometer_mass_popup').val(tempMes).change();
        $('#anio_a_comprometer_mass_popup').val(tempAnio).change();
    },

    expandirPantalla: function(){
        $('.backlog-dashlet-row').show();
    },

    colapsarPantalla: function(){
        $('.backlog-dashlet-row').hide();
    },

    getCurrentYearMonthComprometer: function(){

        var tempMes = $("#mes_filtro").val();
        var tempAnio = $("#anio_filtro").val();
        var tempRegion = $("#region_filtro").val();
        var tempTipoOperacion = $("#tipo_operacion_filtro").val();
        var tempEtapa = $("#etapa_filtro").val();
        var tempEstatus = $("#estatus_filtro").val();
        var tempEquipo = $("#equipo_filtro").val();
        var tempPromotor = $("#promotor_filtro").val();

        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();

        var anio_popup = $('.anio_a_comprometer_popup').val();

        if(typeof anio_popup === "undefined"){
            anio_popup = currentYear;
        }
        var opciones_year = app.lang.getAppListStrings('anio_list');
        Object.keys(opciones_year).forEach(function(key){
            if(key < currentYear){
                delete opciones_year[key];
            }
        });
        this.anio_list_html.options = opciones_year;

        var opciones_mes = app.lang.getAppListStrings('mes_list');
        if(anio_popup <= currentYear){
            Object.keys(opciones_mes).forEach(function(key){
                if (self.mesNaturalCerrado == 1 && self.rolAutorizacion != "DGA"){
                    if(key <= (currentMonth+1)){ // CVV PARA CERRAR PERIODO NATURAL
                        delete opciones_mes[key];
                    }
                }else{
                    if(key <= currentMonth){
                        delete opciones_mes[key];
                    }
                }
            });
        }

        var meses_keys = opciones_mes;

        var meses_a_comprometer_list_html = '';
        var meses_a_comprometer_list_html = '<option value="' + 0 + '">SELECCIONAR</option>';
        for (meses_keys in opciones_mes) {
            meses_a_comprometer_list_html += '<option value="' + meses_keys + '">' + opciones_mes[meses_keys] + '</option>'

        }
        this.meses_a_comprometer_list_html = meses_a_comprometer_list_html;

        this.render();
        this.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor);
        //$('.anio_a_comprometer_popup').val(anio_popup);
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
        $('#form_mostrar_columnas').show();
    },

    cancelaOcultarColumnas:function(){
        $('#form_mostrar_columnas').hide();
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

        $('#form_mostrar_columnas').hide();
        var coldata = $('#sel_columnas').val();
        _.each(coldata, function(key, value) {

            $('#' + key).hide();
            $('.' + key).hide();
        });
        self.floatHeader();

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
                self.floatHeader();
            })
        });
        //END BacklogColumns
    },

    hideCol:function(evt){
        $('.' + $(evt.currentTarget).prop("id")).hide();
        self.floatHeader();
    },

    recalcularPromotores:function(){

        var tempMes = $("#mes_filtro").val();
        var tempAnio = $("#anio_filtro").val();
        var tempRegion = $("#region_filtro").val();
        var tempTipoOperacion = $("#tipo_operacion_filtro").val();
        var tempEtapa = $("#etapa_filtro").val();
        var tempEstatus = $("#estatus_filtro").val();
        var tempEquipo = $("#equipo_filtro").val();
        var tempProgreso = $("#progreso_filtro").val();

        //GetPromotores
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

                var promotores_list_html = '';

                //WARP:  Ajustes Backlog Todos
                promotores_list_html += '<option value="Todos">Todos</option>';
                console.log('promotores_list_html.recalcularPromotores');

                /*
                 if(self.access == 'Full_Access'){
                 promotores_list_html += '<option value="Todos">Todos</option>';
                 }
                 */
                 _.each(data, function(key, value) {
                    promotores_list_html += '<option value="' + value + '">' + key + '</option>';
                });

                 self.promotores_list_html = promotores_list_html;

                 self.render();
                 self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, "", tempProgreso,self.array_checks,self.array_checks_cancelar);
                /*
                 if(self.access == 'Full_Access'){
                 $("#equipo_filtro").prop( "disabled", false);
             }*/
         })
        });
        //END GetPromotores

    },

    calcularRI: function(){

        var monto_a_comprometer = $("#monto_a_comprometer").val().replace(/[^0-9\.]/g, '')
        var ri_porciento = $("#ri_porciento").val().replace(/[^0-9\.]/g, '');

        if(!_.isEmpty(monto_a_comprometer) && !_.isEmpty(ri_porciento)){
            var percent = Math.round((monto_a_comprometer * ri_porciento) / 100);
            percent = this.formatNumber(percent);
            $("#renta_a_comprometer").val(percent);
        }
    },

    calcularPorcientoRI: function(){

        var monto_a_comprometer = $("#monto_a_comprometer").val().replace(/[^0-9\.]/g, '');
        var renta_a_comprometer = $("#renta_a_comprometer").val().replace(/[^0-9\.]/g, '');

        if (renta_a_comprometer == 0){
            $("#ri_porciento").val(0);
        }else{
            if(!_.isEmpty(monto_a_comprometer) && !_.isEmpty(renta_a_comprometer)){
                var percent = Math.round((renta_a_comprometer * 100) / monto_a_comprometer);
                percent = this.formatNumber(percent);
                $("#ri_porciento").val(percent);
            }
        }
    },

    formatNumber: function(number){

        var str = number + '';
        x = str.split('.');
        x1 = x[0]; x2 = x.length > 1 ? '.' + x[1].substring(0,2) : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        number = (x1 + x2);
        return number;
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
                self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, "", tempProgreso,self.array_checks,self.array_checks_cancelar);
            })
        });
        //END GetEquipos2
    },

    motivoCancelacion: function(){
        if($('#motivo_de_cancelacion_popup').val() == "Mes posterior"){
            //Solicitar mes
            $('#mes_cancelacion').show();
            $('#anio_cancelacion').show();
            //$('#label_mes_cancelacion').display = "inherit";
            $('#label_mes_cancelacion').show();
            $('#label_anio_cancelacion').show();
            $('#tdquien').hide();
            $('#tdproducto').hide();
        }
        else if($('#motivo_de_cancelacion_popup').val() == "Competencia"){
            $('#tdquien').show();
            $('#tdproducto').hide();
            $('#mes_cancelacion').hide();
            $('#anio_cancelacion').hide();
            $('#label_mes_cancelacion').hide();
            $('#label_anio_cancelacion').hide();
        }

        else if($('#motivo_de_cancelacion_popup').val() == "No tenemos el producto que requiere"){
            $('#tdquien').hide();
            $('#tdproducto').show();
            $('#mes_cancelacion').hide();
            $('#anio_cancelacion').hide();
            $('#label_mes_cancelacion').hide();
            $('#label_anio_cancelacion').hide();
        }
        else{

            //Ocultar mes y año para mover
            $('#mes_cancelacion').hide();
            $('#anio_cancelacion').hide();
            //$('#label_mes_cancelacion').display = "none";
            $('#label_mes_cancelacion').hide();
            $('#label_anio_cancelacion').hide();
            $('#tdquien').hide();
            $('#tdproducto').hide();
        }
    },

    motivoCancelacionMasivo: function(){
        if($('#motivo_de_cancelacion_masivo_popup').val() == "Mes posterior"){
            //Solicitar mes
            $('#mes_cancelacion_masivo').show();
            $('#anio_cancelacion_masivo').show();
            //$('#label_mes_cancelacion').display = "inherit";
            $('#label_mes_cancelacion_masivo').show();
            $('#label_anio_cancelacion_masivo').show();
            //$('#tdquienMasivo').hide();
            //$('#tdproductoMasivo').hide();

            $('#quienMasivoLabel').hide();
            $('#productoMasivoLabel').hide();
            $('#quienMasivoVal').hide();
            $('#productoMasivoVal').hide();

        }
        else if($('#motivo_de_cancelacion_masivo_popup').val() == "Competencia"){
            //$('#tdquienMasivo').show();
            //$('#tdproductoMasivo').hide();
            
            $('#quienMasivoLabel').show();
            $('#productoMasivoLabel').hide();
            $('#quienMasivoVal').show();
            $('#productoMasivoVal').hide();

            $('#mes_cancelacion_masivo').hide();
            $('#anio_cancelacion_masivo').hide();
            $('#label_mes_cancelacion_masivo').hide();
            $('#label_anio_cancelacion_masivo').hide();
        }

        else if($('#motivo_de_cancelacion_masivo_popup').val() == "No tenemos el producto que requiere"){
            //$('#tdquienMasivo').hide();
            //$('#tdproductoMasivo').show();

            $('#quienMasivoLabel').hide();
            $('#productoMasivoLabel').show();
            $('#quienMasivoVal').hide();
            $('#productoMasivoVal').show();

            $('#mes_cancelacion_masivo').hide();
            $('#anio_cancelacion_masivo').hide();
            $('#label_mes_cancelacion_masivo').hide();
            $('#label_anio_cancelacion_masivo').hide();
        }
        else{

            //Ocultar mes y año para mover
            $('#mes_cancelacion_masivo').hide();
            $('#anio_cancelacion_masivo').hide();
            $('#label_mes_cancelacion_masivo').hide();
            $('#label_anio_cancelacion_masivo').hide();
            //$('#tdquienMasivo').hide();
            //$('#tdproductoMasivo').hide();

            $('#quienMasivoLabel').hide();
            $('#productoMasivoLabel').hide();
            $('#quienMasivoVal').hide();
            $('#productoMasivoVal').hide();
        }


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

    ordenarPorEquipo: function(){

        if(this.EquipoSortDirection == 'DESC'){
            this.EquipoSortDirection = 'ASC';
        }else{
            this.EquipoSortDirection = 'DESC';
        }
        this.cargarBacklogs('ordenEquipo', this.EquipoSortDirection);
    },

    ordenarPorPromotor: function(){

        if(this.PromotorSortDirection == 'DESC'){
            this.PromotorSortDirection = 'ASC';
        }else{
            this.PromotorSortDirection = 'DESC';
        }
        this.cargarBacklogs('promotor', this.PromotorSortDirection);
    },

    ordenarPorCliente: function(){

        if(this.ClienteSortDirection == 'DESC'){
            this.ClienteSortDirection = 'ASC';
        }else{
            this.ClienteSortDirection = 'DESC';
        }
        this.cargarBacklogs('account_name', this.ClienteSortDirection);
    },

    ordenarPorNumeroBacklog: function(){

        if(this.NumeroBacklogSortDirection == 'DESC'){
            this.NumeroBacklogSortDirection = 'ASC';
        }else{
            this.NumeroBacklogSortDirection = 'DESC';
        }
        this.cargarBacklogs('numero_de_backlog', this.NumeroBacklogSortDirection);
    },

    ordenarPorMontoOperacion: function(){

        if(this.MontoOperacionSortDirection == 'DESC'){
            this.MontoOperacionSortDirection = 'ASC';
        }else{
            this.MontoOperacionSortDirection = 'DESC';
        }
        this.cargarBacklogs('monto_comprometido', this.MontoOperacionSortDirection);
    },

    ordenarPorMontoFinal: function(){

        if(this.MontoFinalSortDirection == 'DESC'){
            this.MontoFinalSortDirection = 'ASC';
        }else{
            this.MontoFinalSortDirection = 'DESC';
        }
        this.cargarBacklogs('monto_final_comprometido', this.MontoFinalSortDirection);
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

    moverOperacionMasiva: function (e) {
        console.log("Mover operación masiva");

        var arr_checks=[];
        var arr_checks_actualizar=[];
        var arr_checks_no_actualizar=[];

        var tempMes = $("#mes_filtro").val();
        var tempAnio = $("#anio_filtro").val();
        var tempRegion = $("#region_filtro").val();
        var tempTipoOperacion = $("#tipo_operacion_filtro").val();
        var tempEtapa = $("#etapa_filtro").val();
        var tempEstatus = $("#estatus_filtro").val();
        var tempEquipo = $("#equipo_filtro").val();
        /*
         this.array_checks=[];
         this.checks_actualizar=[];
         this.checks_no_actualizar=[];
         * */

        //Obteniendo campos check
        var checks=$('input[type="checkbox"]');

        //AGREGANDO CHECKS SELECCIONADOS
        $.each( checks, function( key, value ) {
            if(value['checked']==true && value['id'] !== "selectAll"){
                //array_checks contendrá los campos checks com valor true
                //this.array_checks.push(checks[key]);
                arr_checks.push(checks[key]);
            }
        });

        this.array_checks=arr_checks;
        this.countChecks=this.array_checks.length;

        /*
        var backlogId = e.currentTarget.getAttribute('data-id');
        var backlogName = e.currentTarget.getAttribute('data-name');
        var monto = e.currentTarget.getAttribute('data-monto');
        var backlogMes = e.currentTarget.getAttribute('data-mes');
        var backlogAnio = e.currentTarget.getAttribute('data-anio');
        var backlogEstatus = e.currentTarget.getAttribute('data-estatus');
        */
        var tempPromotor = $("#promotor_filtro").val();
        var tempProgreso = $("#progreso_filtro").val();
        /*
        var ProgresoBL = e.currentTarget.getAttribute('data-progreso');
        */
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
                        //this.checks_no_actualizar.push(this.array_checks[i]);
                        //arr_checks_no_actualizar.push(this.array_checks[i]);

                    }else {
                        // No se pueden mover los Backlogs del mes actual BL una vez que ha iniciado
                        var currentDay = (new Date).getDate();
                        var BacklogCorriente = this.getElaborationBacklog();

                        if(backlogAnio <= currentAnioSub){
                            if(backlogMes <= BacklogCorriente && backlogEstatus != 'Cancelada') {
                                if (backlogMes == BacklogCorriente /*&& currentDay > 15*/ && currentDay <= 20){
                                    if (currentDay == 21 && rolAutorizacion != "DGA") {
                                    /*
                                    app.alert.show('backlog corriente', {
                                        level: 'error',
                                        messages: 'Esta operacion no puede moverse debido a que se encuentra en periodo de revision.',
                                        autoClose: false
                                    });
                                    return;
                                    */
                                    arr_checks_no_actualizar.push(this.array_checks[i]);

                                }else{
                                    arr_checks_actualizar.push(this.array_checks[i]);
                                }
                            }else{
                                if (rolAutorizacion == "Promotor"){
                                    //SI es un Backlo anterior o igual al mes corriente natural nadie puede
                                    
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
            if (this.popup_switch == "none") {
                this.popup_switch = "block";
                this.getCurrentYearMonthMoverMes();

                this.cancel = 'Cancelar';
                this.save = 'Guardar';
                /*
                 this.backlogName = backlogName;
                 this.backlogMonto = monto;
                 this.backlogId = backlogId;
                 this.progresoBL = ProgresoBL;
                 */
                 this.checks_actualizar=arr_checks_actualizar;
                 this.checks_no_actualizar=arr_checks_no_actualizar;

                 this.mes_masivo_switch="block";
                 this.mes_switch = "none";
                 this.comentarios_switch = "none";
                 this.cancelar_switch = "none";
                 this.cancelar_masivo_switch = "none";
                 this.revivir_switch = "none";
                 this.lograda_switch = "none";
                 this.compromiso_masivo_switch = "none";

             }else {
                this.popup_switch = "none";
                this.mes_masivo_switch="block";
                this.mes_switch = "none";
                this.comentarios_switch = "none";
                this.cancelar_switch = "none";
                this.cancelar_masivo_switch = "none";
                this.revivir_switch = "none";
                this.lograda_switch = "none";
                this.compromiso_masivo_switch = "none";
            }
            self.loadData();
            self.render();
            self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso,arr_checks);
        }else{

            app.alert.show('cheks_no_actualizar', {
                level: 'error',
                messages: 'Alguno de los registros relacionados no se puede mover.',
                autoClose: false
            });

        }

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
        /*
        var backlogId = e.currentTarget.getAttribute('data-id');
        var backlogName = e.currentTarget.getAttribute('data-name');
        var monto = e.currentTarget.getAttribute('data-monto');
        var renta_inicial = e.currentTarget.getAttribute('data-renta_inicial');
        var opp_related = e.currentTarget.getAttribute('data-oppId');
        var estatus = e.currentTarget.getAttribute('data-estatus');
        var backlogMes = e.currentTarget.getAttribute('data-mes');
        var backlogAnio = e.currentTarget.getAttribute('data-anio');
        */
        var tempPromotor = $("#promotor_filtro").val();
        //var oppTipo = e.currentTarget.getAttribute('data-oppTipo');
        var tempProgreso = $("#progreso_filtro").val();
        //var ProgresoBL = e.currentTarget.getAttribute('data-progreso');
        var rolAutorizacion = self.rolAutorizacion;

        //self.mesAnterior = e.currentTarget.getAttribute('data-mes');

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
                /*
                var backlogId = e.currentTarget.getAttribute('data-id');
                var backlogName = e.currentTarget.getAttribute('data-name');
                var monto = e.currentTarget.getAttribute('data-monto');
                var renta_inicial = e.currentTarget.getAttribute('data-renta_inicial');
                var opp_related = e.currentTarget.getAttribute('data-oppId');
                var estatus = e.currentTarget.getAttribute('data-estatus');
                var backlogMes = e.currentTarget.getAttribute('data-mes');
                var backlogAnio = e.currentTarget.getAttribute('data-anio');

                 var oppTipo = e.currentTarget.getAttribute('data-oppTipo');
                 var ProgresoBL = e.currentTarget.getAttribute('data-progreso');
                 self.mesAnterior = e.currentTarget.getAttribute('data-mes');
                 */
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

                    //checks_cancelar_error.push(this.array_checks_cancelar[i]);
                }


                var BacklogCorriente = this.getElaborationBacklog();

                if(backlogAnio <= currentYear) {
                    if (backlogMes <= BacklogCorriente){
                        //Operaciones de meses anteriores al actual solo pueden ser canceladas por directores
                        if (backlogMes < BacklogCorriente && rolAutorizacion == "Promotor") {
                            /*
                            app.alert.show('backlog_pasado', {
                                level: 'error',
                                messages: 'La operación solo puede ser cancelada por directores.',
                                autoClose: false
                            });
                            return;
                            */
                            checks_cancelar_error.push(this.array_checks_cancelar[i]);

                        }else{
                            //Si esta en proceso de revisión solo dir y/o DGA pueden cancelar validando roles
                            if ((backlogMes == BacklogCorriente && currentDay > 15 && currentDay < 19 && rolAutorizacion == "Promotor") ||
                                (backlogMes == BacklogCorriente && currentDay > 19 && currentDay <= 19 && rolAutorizacion != "DGA")){ //CVV se comenta para cerra periodo de Julio  CVV regresar a 20
                                //if (backlogMes == BacklogCorriente && rolAutorizacion != "DGA"){
                                /*
                                app.alert.show('backlog_pasado', {
                                    level: 'error',
                                    messages: 'No cuenta con los privilegios para cancelar operaciones en este periodo.',
                                    autoClose: false
                                });
                                return;
                                */
                                checks_cancelar_error.push(this.array_checks_cancelar[i]);
                            }else{
                                //Si es el mes actual fuera de periodo de revisión, solo Directores y DGA's
                                if ((currentDay < 16 || currentDay < 21) && rolAutorizacion == "Promotor"){  //CVV se comenta para cerra periodo de Julio
                                    //if (rolAutorizacion != "DGA"){
                                    /*
                                    app.alert.show('backlog_pasado', {
                                        level: 'error',
                                        messages: 'No cuenta con los privilegios para cancelar.',
                                        autoClose: false
                                    });
                                    return;
                                    */
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
            if (this.popup_switch == "none") {
                this.popup_switch = "block";

                this.getCurrentYearMonthPopUp();
                this.cancel = 'Cancelar';
                this.save = 'Guardar';
                /*
                 this.backlogName = backlogName;
                 this.backlogMonto = monto;
                 this.backlogRentaInicial = renta_inicial;
                 this.backlogId = backlogId;
                 this.progresoBL = ProgresoBL;

                 this.array_checks_cancelar=[];
                 this.checks_cancelar=[];
                 this.checks_cancelar_error=[];
                 */
                 this.checks_cancelar=checks_cancelar;
                 this.checks_cancelar_error=checks_cancelar_error;

                 this.cancelar_masivo_switch = "block";
                 this.cancelar_switch = "none";
                 this.revivir_switch = "none";
                 this.comentarios_switch = "none";
                 this.mes_switch = "none";
                 this.mes_masivo_switch="none";
                 this.lograda_switch = "none";
                 this.compromiso_masivo_switch = "none";

             }else {
                this.popup_switch = "none";
                this.cancelar_switch = "none";
                this.cancelar_masivo_switch = "none";
                this.revivir_switch = "none";
                this.comentarios_switch = "none";
                this.mes_switch = "none";
                this.mes_masivo_switch="none";
                this.lograda_switch = "none";
                this.compromiso_masivo_switch = "none";
            }
            self.loadData();
            self.render();
            self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso,self.array_checks,self.array_checks_cancelar);

        }else{
            app.alert.show('cheks_no_cancelar', {
                level: 'error',
                messages: 'Ninguno de los registros seleccionados se puede cancelar',
                autoClose: false
            });
        }


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