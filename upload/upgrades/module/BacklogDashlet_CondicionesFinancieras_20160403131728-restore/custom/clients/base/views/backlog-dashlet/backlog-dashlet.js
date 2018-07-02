/**
 * Created by Levementum on 2/25/2016.
 * User: jgarcia@levementum.com
 */

({
    plugins: ['Dashlet'],

    events: {
        'click #btn_Buscar': 'cargarBacklogs',
        'click .Cancelar': 'cancelarBacklog',
        'click .Comentario': 'comentarioBacklog',
        'click .MoverOperacion': 'moverOperacion',
        'click .Comprometer': 'comprometer',
        'click .popupCancel': 'popupCancel',
        'click .popupSave': 'popupSave',
        'change .anio_popup': 'getCurrentYearMonthPopUp',
        'change .anio_switch_popup': 'getCurrentYearMonthMoverMes',
        'change .anio_a_comprometer_popup': 'getCurrentYearMonthComprometer',
        'change #mass_update_btn': 'seleccionarTodo',
        'click .mass_update': 'seleccionarBacklog',
        'click .Comprometer_mass': 'ComprometerMasivo',
        'click .mostrar_columnas': 'mostrarColumnas',
        'click .exportar': 'exportarXL',
        'click #expandir_backlog_button': 'expandirPantalla',
        'click #colapsar_backlog_button': 'colapsarPantalla',
        'click .hide_show_col': 'hideCol',
    },

    initialize: function (options) {
        self = this;

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
        var anio_list_html = '';
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

        var tipo_operacion_list = app.lang.getAppListStrings('tipo_de_operacion_0');
        var tipo_operacion_keys = app.lang.getAppListKeys('tipo_de_operacion_0');
        var tipo_operacion_list_html = '<option value=""></option>';
        for (tipo_operacion_keys in tipo_operacion_list) {
            tipo_operacion_list_html += '<option value="' + tipo_operacion_keys + '">' + tipo_operacion_list[tipo_operacion_keys] + '</option>'

        }
        this.tipo_operacion_list_html = tipo_operacion_list_html;

        var etapa_list = app.lang.getAppListStrings('estatus_c_operacion_list');
        var etapa_keys = app.lang.getAppListKeys('estatus_c_operacion_list');
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

        var equipo_list = app.lang.getAppListStrings('equipo_list');
        var equipo_keys = app.lang.getAppListKeys('equipo_list');
        var equipo_list_html = '<option value=""></option>';
        equipo_list_html += '<option value="Todos">Todos</option>';
        for (equipo_keys in equipo_list) {
            equipo_list_html += '<option value="' + equipo_keys + '">' + equipo_list[equipo_keys] + '</option>'

        }
        this.equipo_list_html = equipo_list_html;

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
        this.cancel = 'Cancel';
        this.save = 'Save';
        this.mes_seleccionado = '';
        this.anio_seleccionado = '';
        this.comentarios_existentes = '';
        this.access = '';

        this.seleccionados = [];
    },

    loadData: function (options) {
        if (_.isUndefined(this.model)) {
            return;
        }
        var self = this;

        this.cargarBacklogs();

    },

    cargarBacklogs: function(){

        $(".loadingIcon").show();
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
                var tempEstatus = $("#estatus_filtro").val();
                var tempEquipo = $("#equipo_filtro").val();

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

                        if(self.has_subordinados == true){
                            self.access = 'Full_Access';
                        }

                        self.render();
                        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);



                        //autopopula los campos de mes y anio en el popup de Comprometer;
                        $('#mes_a_comprometer_popup').val(backlog_mes).change();
                        $('#anio_a_comprometer_popup').val(backlog_anio).change();

                        $('#mes_a_comprometer_mass_popup').val(tempMes).change();
                        $('#anio_a_comprometer_mass_popup').val(tempAnio).change();

                        if(data.backlogs.RoleView == 'Full_Access'){
                            $("#equipo_filtro").prop( "disabled", false);
                        }

                        if(self.has_subordinados == true){
                            $("#equipo_filtro").prop( "disabled", false);
                        }

                        $(".loadingIcon").hide();

                        //backlogs

                        self.floatHeader();

                    })
                });

                // console.log('data.children');
                // console.log(data.children);
            })

        });
    },

    floatHeader: function(){
        var clonedHeaderRow;

        $(".backlog_dashlet_box").each(function() {

            var columnSizes = {}
            $(".backlog_dashlet_box").find('th').each(function(i, el){
                columnSizes[i] = $(el).width();
            });

            clonedHeaderRow = $(".backlog_dashlet_header", this);

            clonedHeaderRow
                .before(clonedHeaderRow.clone())
                .css("width", clonedHeaderRow.width())
                .addClass("backlogHeaderFloat")
                //.css('top', clonedHeaderRow.position().top - 90 + "px");

            clonedHeaderRow.find('th').each(function(i, el){
                $(el).css('width', columnSizes[i] + "px");
            });

            //backlog_dashlet_header_totals
            clonedHeaderRowTotals = $(".backlog_dashlet_header_totals", this);

            clonedHeaderRowTotals
                .before(clonedHeaderRowTotals.clone())
                .css("width", clonedHeaderRowTotals.width())
                .addClass("backlogHeaderFloat_totals")
                //.css('top', clonedHeaderRowTotals.position().top + 250 + "px");

            clonedHeaderRowTotals.find('th').each(function(i, el){
                $(el).css('width', columnSizes[i] + "px");
            });

        });

        $('.dashlet-content > div').each(function(){

            if($(this).children('div').attr('class') == 'backlog-dashlet-wrapper'){
                $(this).scroll(toggleHeader)
                $(this).trigger("scroll");
            }
        });

        $(".backlogHeaderFloat").hide();
        $(".backlogHeaderFloat_totals").hide();
        function toggleHeader() {

            // console.log('toggleHeader');
            var scrollTop = $('.backlog-dashlet-wrapper').parent().offset().top;

            $(".backlog_dashlet_box").each(function() {

                var el             = $(this),
                    offset         = el.offset(),
                    c1HeaderFloat = $(".backlogHeaderFloat", this)

                // console.log ('(C1) scrollTop: ' + scrollTop + ' - offset.top: ' + offset.top + ' -  el.height(): ' +  el.height());

                var trackingOffset = offset.top;
                if ((scrollTop > trackingOffset) && (scrollTop < trackingOffset + el.height())) {
                    $(".backlogHeaderFloat").show();
                    $('.backlogHeaderFloat').css('top', scrollTop + 'px');

                    $(".backlogHeaderFloat_totals").show();
                    $('.backlogHeaderFloat_totals').css('top', scrollTop + 80 + 'px');
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

        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();
        var access = $('#access').val();

        if(estatus == "Comprometida"){
            app.alert.show('opp_cancelada', {
                level: 'error',
                messages: 'Esta operacion ya ha sido comprometida',
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

        if(access != "Full_Access") {
            if ($('#anio_filtro').val() <= currentYear) {
                if (currentDay >= 10 && currentDay <= 20) {
                    var next_month = currentMonth + 2;
                    if ($('#mes_filtro').val() == next_month) {
                        app.alert.show('periodo_de_aprobacion', {
                            level: 'error',
                            messages: 'Durante este periodo no se pueden comprometer operaciones para este mes',
                            autoClose: false
                        });
                        return;
                    }
                }
            }
        }

        if (this.popup_switch == "none") {
            this.popup_switch = "block";
            this.getCurrentYearMonthComprometer();

            this.backlogName = backlogName;
            this.backlogMonto = monto;
            this.backlogRentaInicial = renta_inicial;
            this.backlogId = backlogId;
            this.mes_seleccionado = backlog_mes;
            this.anio_seleccionado = backlog_anio;

            this.lograda_switch = "block";
            this.mes_switch = "none";
            this.comentarios_switch = "none";
            this.cancelar_switch = "none";
            this.compromiso_masivo_switch = "none";

        }else {
            this.popup_switch = "none";
            this.mes_switch = "none";
            this.comentarios_switch = "none";
            this.cancelar_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";
        }
        self.loadData(); self.render();
        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);

        //autopopula los campos de mes y anio en el popup de Comprometer;
        $('#mes_a_comprometer_popup').val(backlog_mes).change();
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

        var currentYear = (new Date).getFullYear();
        var currentBacklogMonth = this.backlogMonth();

        if(backlogAnio <= currentYear) {
            if(backlogEstatus == 'Comprometida') {
                if (currentBacklogMonth > backlogMes) {
                    app.alert.show('backlog_pasado', {
                        level: 'error',
                        messages: 'Esta operacion fue comprometida en un mes anterior',
                        autoClose: false
                    });
                    return;
                }
            }
        }

        if (this.popup_switch == "none") {
            this.popup_switch = "block";
            this.getCurrentYearMonthMoverMes();

            this.cancel = 'Cancel';
            this.save = 'Save';
            this.backlogName = backlogName;
            this.backlogMonto = monto;
            this.backlogId = backlogId;

            this.mes_switch = "block";
            this.comentarios_switch = "none";
            this.cancelar_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";

        }else {
            this.popup_switch = "none";
            this.mes_switch = "none";
            this.comentarios_switch = "none";
            this.cancelar_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";
        }
        self.loadData(); self.render();
        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);
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

        if(!_.isEmpty(opp_related)){
            app.alert.show('opp_relacionada', {
                level: 'error',
                messages: 'Para cancelar una operación del backlog ligada a una solicitud de línea de crédito se debe realizar por el módulo de operaciones',
                autoClose: false
            });
            return;
        }

        if(estatus == "Cancelada"){
            app.alert.show('opp_cancelada', {
                level: 'error',
                messages: 'Esta operacion ya ha sido cancelada',
                autoClose: false
            });
            return;
        }

        if(estatus != "Comprometida"){
            app.alert.show('opp_cancelada', {
                level: 'error',
                messages: 'Solo se puede cancelar una operacion comprometida',
                autoClose: false
            });
            return;
        }

        var currentYear = (new Date).getFullYear();
        var currentBacklogMonth = this.backlogMonth();

        if(backlogAnio <= currentYear) {
            if(estatus == 'Comprometida') {
                if (currentBacklogMonth > backlogMes) {
                    app.alert.show('backlog_pasado', {
                        level: 'error',
                        messages: 'Esta operacion fue comprometida en un mes anterior',
                        autoClose: false
                    });
                    return;
                }
            }
        }

        if (this.popup_switch == "none") {
            this.popup_switch = "block";

            this.getCurrentYearMonthPopUp();
            this.cancel = 'Cancel';
            this.save = 'Save';
            this.backlogName = backlogName;
            this.backlogMonto = monto;
            this.backlogRentaInicial = renta_inicial;
            this.backlogId = backlogId;

            this.cancelar_switch = "block";
            this.comentarios_switch = "none";
            this.mes_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";

        }else {
            this.popup_switch = "none";
            this.cancelar_switch = "none";
            this.comentarios_switch = "none";
            this.mes_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";
        }
        self.loadData(); self.render();
        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);

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

        if (this.popup_switch == "none") {
            this.popup_switch = "block";

            this.cancel = 'Cancel';
            this.save = 'Save';
            this.backlogName = backlogName;
            this.backlogMonto = monto;
            this.backlogMonto_Real = monto_real;
            this.backlogId = backlogId;
            this.comentarios_existentes = comentarios_existentes;

            this.comentarios_switch = "block";
            this.mes_switch = "none";
            this.cancelar_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";

        }else {
            this.popup_switch = "none";
            this.comentarios_switch = "none";
            this.mes_switch = "none";
            this.cancelar_switch = "none";
            this.lograda_switch = "none";
            this.compromiso_masivo_switch = "none";
        }
        self.loadData(); self.render();
        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);
    },

    persistData: function(mesFiltro, anioFiltro, regionFiltro, tipoOppFiltro, etapaFiltro, estatusFiltro, equipoFiltro){

        $("#mes_filtro").val(mesFiltro);
        $("#anio_filtro").val(anioFiltro);
        $("#region_filtro").val(regionFiltro);
        $("#tipo_operacion_filtro").val(tipoOppFiltro);
        $("#etapa_filtro").val(etapaFiltro);
        $("#estatus_filtro").val(estatusFiltro);
        $("#equipo_filtro").val(equipoFiltro);

        //var seleccionadosClone = this.seleccionados;
        //var seleccionadosCleaned = [];
        //this.seleccionados = [];

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

        if(currentDay < 20){
            currentMonth += 1;
        }
        if(currentDay >= 20){
            currentMonth += 2;
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

        this.popup_switch = "none";

        self.loadData(); self.render();
        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);
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
                    this.mes_switch = "none";
                    this.cancelar_switch = "none";
                    this.lograda_switch = "none";
                    this.compromiso_masivo_switch = "none";
                    self.loadData(); self.render();
                    self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);
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

            if(_.isEmpty(MotivoCancelacion)){

                app.alert.show('motivo_requerido', {
                    level: 'error',
                    messages: 'El motivo de cancelacion es requerido',
                    autoClose: true
                });
                return;
            }

            var Params = {
                'backlogId': this.backlogId,
                'backlogName': this.backlogName,
                'MotivoCancelacion': MotivoCancelacion,
                'MontoReal': MontoReal,
                'RentaReal': RentaReal,
                'Comentarios': comentarios,
                'Mes': mes,
                'Anio': anio,
            };
            var Url = app.api.buildURL("BacklogCancelar", '', {}, {});
            app.api.call("create", Url, {data: Params}, {
                success: _.bind(function (data) {
                    if (self.disposed) {
                        return;
                    }
                    self.popup_switch = "none";
                    self.cancelar_switch = "none";
                    this.comentarios_switch = "none";
                    this.mes_switch = "none";
                    this.lograda_switch = "none";
                    this.compromiso_masivo_switch = "none";
                    self.loadData(); self.render();
                    self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);
                })
            });
        }
        if(this.mes_switch == "block"){
            var mes_popup = $('.mes_switch_popup').val();
            var anio_popup = $('.anio_switch_popup').val();
            var current_backlog = $('#mes_filtro').val();

            var currentYear = (new Date).getFullYear();
            var currentMonth = (new Date).getMonth();
            var currentDay = (new Date).getDate();
            var tipo_opp = '';
            var periodo_revision = false;
            var access = $('#access').val();
            //currentMonth += 1;

            if(currentDay < 20){
                currentMonth += 1;
            }
            if(currentDay >= 20){
                currentMonth += 2;
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

            if(currentDay >= 15 && currentDay <= 20){
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
                    this.comentarios_switch = "none";
                    this.mes_switch = "none";
                    this.lograda_switch = "none";
                    this.compromiso_masivo_switch = "none";
                    self.loadData(); self.render();
                    self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);
                })
            });
        }
        if(this.lograda_switch == "block"){

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
            };
            var Url = app.api.buildURL("OperacionLograda", '', {}, {});
            app.api.call("create", Url, {data: Params}, {
                success: _.bind(function (data) {
                    if (self.disposed) {
                        return;
                    }
                    self.popup_switch = "none";
                    self.cancelar_switch = "none";
                    this.comentarios_switch = "none";
                    this.mes_switch = "none";
                    this.lograda_switch = "none";
                    this.compromiso_masivo_switch = "none";
                    self.loadData(); self.render();
                    self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);
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
                    this.mes_switch = "none";
                    this.lograda_switch = "none";
                    this.compromiso_masivo_switch = "none";
                    self.seleccionados = [];
                    self.loadData(); self.render();
                    self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);
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

        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();

        var anio_popup = $('.anio_popup').val();

        if(typeof anio_popup === "undefined"){
            anio_popup = currentYear;
        }

        if(currentDay < 20){
            currentMonth += 2;
        }
        if(currentDay >= 20){
            currentMonth += 3;
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

        var meses_list_popup_html = '';
        for (meses_keys in opciones_mes) {
            meses_list_popup_html += '<option value="' + meses_keys + '">' + opciones_mes[meses_keys] + '</option>'

        }
        this.meses_list_popup_html = meses_list_popup_html;

        this.render();
        this.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);
        $('.anio_popup').val(anio_popup);
    },

    getCurrentYearMonthMoverMes: function(){

        var tempMes = $("#mes_filtro").val();
        var tempAnio = $("#anio_filtro").val();
        var tempRegion = $("#region_filtro").val();
        var tempTipoOperacion = $("#tipo_operacion_filtro").val();
        var tempEtapa = $("#etapa_filtro").val();
        var tempEstatus = $("#estatus_filtro").val();
        var tempEquipo = $("#equipo_filtro").val();

        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();

        var anio_popup = $('.anio_switch_popup').val();

        if(typeof anio_popup === "undefined"){
            anio_popup = currentYear;
        }

        if(currentDay < 20){
            currentMonth += 1;
        }
        if(currentDay >= 20){
            currentMonth += 2;
        }

        if(currentMonth == tempMes){
            currentMonth += 1;
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

        var meses_list_popup_mover_mes = '';
        for (meses_keys in opciones_mes) {
            meses_list_popup_mover_mes += '<option value="' + meses_keys + '">' + opciones_mes[meses_keys] + '</option>'

        }
        this.meses_list_popup_mover_mes = meses_list_popup_mover_mes;

        this.render();
        this.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);
        $('.anio_switch_popup').val(anio_popup);
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

        if (this.popup_switch == "none") {
            this.popup_switch = "block";

            this.cancel = 'Cancel';
            this.save = 'Save';

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
                    self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);

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
        self.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);

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

        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();

        var anio_popup = $('.anio_a_comprometer_popup').val();

        if(typeof anio_popup === "undefined"){
            anio_popup = currentYear;
        }

        if(currentDay < 20){
            currentMonth += 1;
        }
        if(currentDay >= 20){
            currentMonth += 2;
        }

        if(currentMonth == tempMes){
            currentMonth += 1;
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

        var meses_a_comprometer_list_html = '';
        for (meses_keys in opciones_mes) {
            meses_a_comprometer_list_html += '<option value="' + meses_keys + '">' + opciones_mes[meses_keys] + '</option>'

        }
        this.meses_a_comprometer_list_html = meses_a_comprometer_list_html;

        this.render();
        this.persistData(tempMes, tempAnio, tempRegion, tempTipoOperacion, tempEtapa, tempEstatus, tempEquipo);
        $('.anio_a_comprometer_popup').val(anio_popup);
    },

    backlogMonth: function(){
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();

        if(currentDay < 20){
            currentMonth += 1;
        }
        if(currentDay >= 20){
            currentMonth += 2;
        }

        return currentMonth;
    },

    mostrarColumnas:function(){
        $('.hide_show_col').each(function(){
            $(this).prop('checked', false);
            $('.' + $(this).prop("id")).show();
        });
        $(".backlogHeaderFloat").remove();
        $(".backlogHeaderFloat_totals").remove();
        self.floatHeader();
    },

    hideCol:function(evt){
        $('.' + $(evt.currentTarget).prop("id")).hide();
        $(".backlogHeaderFloat").remove();
        $(".backlogHeaderFloat_totals").remove();
        self.floatHeader();
    },
})


