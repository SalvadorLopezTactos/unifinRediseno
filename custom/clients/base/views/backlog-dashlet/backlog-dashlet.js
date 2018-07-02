/**
 * Created by Levementum on 2/25/2016.
 * User: jgarcia@levementum.com
 */

({
    plugins: ['Dashlet'],

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
        'change .anio_switch_popup': 'getCurrentYearMonthMoverMes',
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
        'click #EquipoSort': 'ordenarPorEquipo',
        'click #PromotorSort': 'ordenarPorPromotor',
        'click #ClienteSort': 'ordenarPorCliente',
        'click #NumeroBacklogSort': 'ordenarPorNumeroBacklog',
        'click #MontoOperacionSort': 'ordenarPorMontoOperacion',
        'click #MontoFinalSort': 'ordenarPorMontoFinal',
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
        this.lograda_switch = "none";
        this.compromiso_masivo_switch = "none";
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

        this.seleccionados = [];
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

                                if(self.access == 'Full_Access' || self.has_subordinados == true){
                                    promotores_list_html += '<option value="Todos">Todos</option>';
                                }
                                _.each(data, function(key, value) {
                                    promotores_list_html += '<option value="' + value + '">' + key + '</option>';
                                });

                                self.promotores_list_html = promotores_list_html;

                                self.render();
                                self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);

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
                messages: 'Esta operacion ya ha sido comprometida',
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
            this.comentarios_switch = "none";
            this.cancelar_switch = "none";
            this.revivir_switch = "none";
            this.compromiso_masivo_switch = "none";

        }else {
            this.popup_switch = "none";
            this.mes_switch = "none";
            this.comentarios_switch = "none";
            this.cancelar_switch = "none";
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
        var currentBacklogMonth = this.backlogMonth();
        if(backlogAnio <= currentYear) {
            // Si el BL ya esta cancelado no puede moverse
            //if(backlogEstatus != 'Activa') {
            if(backlogEstatus == 'Cancelada') {
                //if (currentBacklogMonth >= backlogMes) {
                    app.alert.show('backlog_pasado', {
                        level: 'error',
                        messages: 'Esta operacion no puede moverse debido a que se encuentra ' + backlogEstatus,
                        autoClose: false
                    });
                    return;
                //}
            }else {
                // No se pueden mover los Backlogs del mes actual BL una vez que ha iniciado
                var currentDay = (new Date).getDate();
                var BacklogCorriente = this.getElaborationBacklog();

                if(backlogMes <= BacklogCorriente && backlogEstatus != 'Cancelada') {
                    if (backlogMes == BacklogCorriente /*&& currentDay > 15*/ && currentDay <= 20){
                        if (currentDay == 21 && rolAutorizacion != "DGA") {
                            app.alert.show('backlog corriente', {
                                level: 'error',
                                messages: 'Esta operacion no puede moverse debido a que se encuentra en periodo de revision.',
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
                        if (rolAutorizacion == "Promotor"){
                            //SI es un Backlo anterior o igual al mes corriente natural nadie puede
                            app.alert.show('backlog corriente', {
                                level: 'error',
                                messages: 'Esta operacion no puede moverse debido a que el Backlog ya esta corriendo.',
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
            this.getCurrentYearMonthMoverMes();

            this.cancel = 'Cancelar';
            this.save = 'Guardar';
            this.backlogName = backlogName;
            this.backlogMonto = monto;
            this.backlogId = backlogId;
            this.progresoBL = ProgresoBL;

            this.mes_switch = "block";
            this.comentarios_switch = "none";
            this.cancelar_switch = "none";
            this.revivir_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";

        }else {
            this.popup_switch = "none";
            this.mes_switch = "none";
            this.comentarios_switch = "none";
            this.cancelar_switch = "none";
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
                messages: 'Esta operacion ya ha sido cancelada',
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
                        messages: 'La operación solo puede ser cancelada por directores.',
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
            this.revivir_switch = "none";
            this.comentarios_switch = "none";
            this.mes_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";

        }else {
            this.popup_switch = "none";
            this.cancelar_switch = "none";
            this.revivir_switch = "none";
            this.comentarios_switch = "none";
            this.mes_switch = "none";
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
            this.comentarios_switch = "none";
            this.mes_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";

        }else {
            this.popup_switch = "none";
            this.cancelar_switch = "none";
            this.revivir_switch = "none";
            this.comentarios_switch = "none";
            this.mes_switch = "none";
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
            this.cancelar_switch = "none";
            this.revivir_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";

        }else {
            this.popup_switch = "none";
            this.comentarios_switch = "none";
            this.mes_switch = "none";
            this.cancelar_switch = "none";
            this.revivir_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";
        }
        self.loadData(); self.render();
        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
    },

    persistData: function(mesFiltro, anioFiltro, regionFiltro, tipoOppFiltro, etapaFiltro, estatusFiltro, equipoFiltro, promotorFiltro, progreso){

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
        //$("#etapa_filtro").val(etapaFiltro);
        if(!_.isEmpty(etapaFiltro)){
            $("#etapa_filtro").select2('val' ,etapaFiltro);
        }

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
    },

    popupSave: function(e){
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
                        return;
                    }
                    self.popup_switch = "none";
                    self.comentarios_switch = "none";
                    this.revivir_switch = "none";
                    this.mes_switch = "none";
                    this.cancelar_switch = "none";
                    this.lograda_switch = "none";
                    this.compromiso_masivo_switch = "none";
                    self.loadData(); self.render();
                    self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
                })
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
            var Url = app.api.buildURL("RevivirBacklog", '', {}, {});
            app.api.call("create", Url, {data: Params}, {
                success: _.bind(function (data) {
                    if (self.disposed) {
                        return;
                    }
                    self.popup_switch = "none";
                    self.revivir_switch = "none";
                    this.cancelar_switch = "none";
                    this.comentarios_switch = "none";
                    this.mes_switch = "none";
                    this.lograda_switch = "none";
                    this.compromiso_masivo_switch = "none";
                    self.loadData();
                    self.render();
                    self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
                })
            });
        }
        if(this.cancelar_switch == "block"){
            var MotivoCancelacion = $('#motivo_de_cancelacion_popup').val();
            var MontoReal = $('#monto_cancelacion_popup').html();
            var RentaReal = $('#renta_cancelacion_popup').html();
            var comentarios = $('#comentarios_de_cancelacion').val();
            var mes = $('.mes_popup').val();
            var anio = $('.anio_popup').val();

            console.log('Progreso' + self.progresoBL);

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

            if(_.isEmpty(MotivoCancelacion)){
                app.alert.show('motivo_requerido', {
                    level: 'error',
                    messages: 'El motivo de cancelacion es requerido',
                    autoClose: true
                });
                return;
            }

            if (MotivoCancelacion == 'Mes posterior' && mes == 0){
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
            };
            var Url = app.api.buildURL("BacklogCancelar", '', {}, {});
            app.api.call("create", Url, {data: Params}, {
                success: _.bind(function (data) {
                    if (self.disposed) {
                        return;
                    }
                    self.popup_switch = "none";
                    self.cancelar_switch = "none";
                    this.revivir_switch = "none";
                    this.comentarios_switch = "none";
                    this.mes_switch = "none";
                    this.lograda_switch = "none";
                    this.compromiso_masivo_switch = "none";
                    self.loadData(); self.render();
                    self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
                })
            });
        }
        if(this.mes_switch == "block"){
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
            var Url = app.api.buildURL("MoverOperacion", '', {}, {});
            app.api.call("create", Url, {data: Params}, {
                success: _.bind(function (data) {
                    if (self.disposed) {
                        return;
                    }

                    if(!_.isEmpty(data)){
                        alert(data);
                    }
                    self.popup_switch = "none";
                    self.cancelar_switch = "none";
                    this.revivir_switch = "none";
                    this.comentarios_switch = "none";
                    this.mes_switch = "none";
                    this.lograda_switch = "none";
                    this.compromiso_masivo_switch = "none";
                    self.loadData(); self.render();
                    self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
                })
            });
        }
        if(this.lograda_switch == "block"){
            if ($('#mes_a_comprometer_popup').val() == 0){
                app.alert.show('Mes requerido', {
                    level: 'error',
                    messages: 'Debe indicar el mes al que se comprometera el Backlog.',
                    autoClose: true
                });
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
                        return;
                    }
                    self.popup_switch = "none";
                    self.cancelar_switch = "none";
                    this.revivir_switch = "none";
                    this.comentarios_switch = "none";
                    this.mes_switch = "none";
                    this.lograda_switch = "none";
                    this.compromiso_masivo_switch = "none";
                    self.loadData();
                    self.render();
                    self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
                })
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
                        return;
                    }
                    self.popup_switch = "none";
                    self.cancelar_switch = "none";
                    this.comentarios_switch = "none";
                    this.revivir_switch = "none";
                    this.mes_switch = "none";
                    this.lograda_switch = "none";
                    this.compromiso_masivo_switch = "none";
                    self.seleccionados = [];
                    self.loadData(); self.render();
                    self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor, tempProgreso);
                })
            });
        }
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

        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth() + 1;
        var currentDay = (new Date).getDate();

        var anio_popup = $('.anio_popup').val();
        var mes_popup = $('.mes_popup').val();
        var motivo_de_cancelacion_popup = $('#motivo_de_cancelacion_popup').val();

        if(typeof anio_popup === "undefined"){
            anio_popup = currentYear;
        }

        if(currentDay <= 20 && (currentMonth) <= tempMes){
            currentMonth += 1;
        }

        if(currentDay > 20 && (currentMonth) == tempMes){
            currentMonth += 1;
        }

        if (currentMonth > 12){  //Si resulta mayor a diciembre
            currentMonth = currentMonth - 12;
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
                if(key < currentMonth){
                    delete opciones_mes[key];
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
        this.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor);
        $('.anio_popup').val(anio_popup);
        $('.mes_popup').val(mes_popup);
        $('#motivo_de_cancelacion_popup').val(motivo_de_cancelacion_popup);
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

        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();

        var anio_popup = $('.anio_switch_popup').val();
        var tempmes_switch_popup = $(".mes_switch_popup").val();

        if(typeof anio_popup === "undefined"){
            anio_popup = currentYear;
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

        var meses_keys = opciones_mes;

        var meses_list_popup_mover_mes = '';
        for (meses_keys in opciones_mes) {
            meses_list_popup_mover_mes += '<option value="' + meses_keys + '">' + opciones_mes[meses_keys] + '</option>'

        }
        this.meses_list_popup_mover_mes = meses_list_popup_mover_mes;

        this.render();
        this.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, tempPromotor);
        $('.anio_switch_popup').val(anio_popup);
        $('.mes_switch_popup').val(tempmes_switch_popup);
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
            this.cancelar_switch = "none";
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
            this.cancelar_switch = "none";
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

                if(self.access == 'Full_Access'){
                    promotores_list_html += '<option value="Todos">Todos</option>';
                }
                _.each(data, function(key, value) {
                    promotores_list_html += '<option value="' + value + '">' + key + '</option>';
                });

                self.promotores_list_html = promotores_list_html;

                self.render();
                self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, "", tempProgreso);
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
                self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo, "", tempProgreso);
            })
        });
        //END GetEquipos
    },

    motivoCancelacion: function(){
        if($('#motivo_de_cancelacion_popup').val() == "Mes posterior"){
            //Solicitar mes
            $('#mes_cancelacion').show();
            $('#anio_cancelacion').show();
            //$('#label_mes_cancelacion').display = "inherit";
            $('#label_mes_cancelacion').show();
            $('#label_anio_cancelacion').show();
        }else{
            //Ocultar mes y año para mover
            $('#mes_cancelacion').hide();
            $('#anio_cancelacion').hide();
            //$('#label_mes_cancelacion').display = "none";
            $('#label_mes_cancelacion').hide();
            $('#label_anio_cancelacion').hide();
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
})


