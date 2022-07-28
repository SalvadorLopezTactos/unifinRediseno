/**
 * Created by salvadorlopez salvador.lopez@tactos.com.mx
 */
({
    events: {
        'click #btn_Buscar_bl': 'cargarBacklogsGestionButton',
        'change .monto_prospecto': 'calculaMonto',
        'change .monto_credito': 'calculaMonto',
        'change .monto_rechazado': 'calculaMonto',
        'change .monto_sin_solicitud': 'calculaMonto',
        'change .monto_con_solicitud': 'calculaMonto',
        'change .monto_devuelta': 'calculaMonto',

        'keypress .monto_prospecto': 'soloNumeros',
        'keypress .monto_credito': 'soloNumeros',
        'keypress .monto_rechazado': 'soloNumeros',
        'keypress .monto_sin_solicitud': 'soloNumeros',
        'keypress .monto_con_solicitud': 'soloNumeros',
        'keypress .monto_devuelta': 'soloNumeros',
        'keypress .probabilidad': 'soloNumeros',
        'keypress .probabilidad_campo_masivo': 'soloNumeros',

        'change .probabilidad': 'calculaBLEstimado',
        'change .montoTotal': 'calculaBLEstimado',

        'click #btn_guardar': 'guardarBacklogs',
        'click #btn_actualizar_valores_masivo': 'actualizaValoresMasivo',

    },

    meses_list_html: null,
    anio_list_html_filter: null,
    etapa_list_html: null,
    producto_list_html: null,
    equipo_list_html:null,
    zona_list_html:null,
    tipo_operacion_list_html:null,

    initialize: function (options) {
        self = this;

        this._super("initialize", [options]);

        this.loadViewAdminBacklog = false;
        if (app.user.attributes.admin_backlog_c == 1) {
            this.loadViewAdminBacklog = true;
        } else {
            var route = app.router.buildRoute(this.module, null, '');
            app.router.navigate(route, { trigger: true });
        }

        this.etapa_list_html = app.lang.getAppListStrings('etapa_c_list');
        this.etapa_list_html[''] = "";

        this.producto_list_html = {};
        this.producto_list_html["0"] = "Todos";
        this.producto_list_html["1"] = "Leasing";
        this.producto_list_html["2"] = "Crédito Simple";
        this.producto_list_html["3"] = "Lumo";

        this.equipo_list_html=app.lang.getAppListStrings('equipo_list');
        var zona_list=app.lang.getAppListStrings('tct_team_region_list');
        var zona_list_unique={"0":""};
        for (const clave in zona_list) {
            if (!zona_list_unique.hasOwnProperty(zona_list[clave]) && clave!="") {
                zona_list_unique[zona_list[clave]]=zona_list[clave];
            }
        }
        this.zona_list_html=zona_list_unique;
        var tipo_operacion_list_leasing=app.lang.getAppListStrings('num_tipo_op_leasing_list');
        var tipo_operacion_list_credito=app.lang.getAppListStrings('num_tipo_op_credito_list');

        //Generando lista con valores concatenados de 2 listas num_tipo_op_leasing_list,num_tipo_op_credito_list
        this.tipo_operacion_list_html={};
        for (const key in tipo_operacion_list_leasing) {
            if(tipo_operacion_list_leasing[key]!==""){
                //this.tipo_operacion_list_html["0"+key+""]=tipo_operacion_list_leasing[key];
                //Se agrega condición para omitir agregarla ocpión de Crédito Puente
                if(key!=5){
                    this.tipo_operacion_list_html["0"+key+""]=tipo_operacion_list_leasing[key];
                }
            }
        }

        for (const key in tipo_operacion_list_credito) {
            this.tipo_operacion_list_html[key]=tipo_operacion_list_credito[key];
        }

        this.mes_filtro = ((new Date).getMonth() + 1).toString();
        this.anio_filtro = ((new Date).getFullYear()).toString();
    },

    _render: function () {
        this._super("_render");
        //Formato de DataTable para ocultar paginación, busqueda y filtro - tambien deshabilita las columnas con la clase no-sort seleccionadas para el ordenamiento asc y desc
        $('#dtAdminBacklog').DataTable({ "bPaginate": false, "bFilter": false, "bInfo": false, "aoColumnDefs":[{"bSortable":false,"aTargets":["no-sort"]}] });
    },

    loadData: function (options) {
        if (_.isUndefined(this.model)) {
            return;
        }
        var self = this;
        this.meses_list_html = app.lang.getAppListStrings('mes_list');
        this.meses_list_html[""] = "Todos";
        this.mes_filtro = ((new Date).getMonth() + 1).toString();

        this.anio_filtro = ((new Date).getFullYear()).toString();
        var anio_list = app.lang.getAppListStrings('anio_list');

        this.etapa_filtro = "";
        this.producto_filtro = "";

        var currentYear = new Date().getFullYear();
        Object.keys(anio_list).forEach(function (key) {
            if (key < currentYear || key == "") {
                delete anio_list[key];
            }
        });
        this.anio_list_html_filter = anio_list;
        this.lista_etapas = app.lang.getAppListStrings('etapa_c_list');

        var anio_actual = (new Date).getFullYear();
        //var mes_actual = self.getActualBacklog();
        var mes_actual = ((new Date).getMonth() + 1).toString();

        this.cargarBacklogsGestion(mes_actual, anio_actual, null, null);
    },

    getActualBacklog: function () {
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();

        if (currentDay <= 20) {
            currentMonth += 1;
        }
        if (currentDay > 20) {
            currentMonth += 2;
        }

        if (currentMonth > 12) {  //Si resulta mayor a diciembre
            currentMonth = currentMonth - 12;
        }

        return currentMonth;
    },

    cargarBacklogsGestionButton: function () {
        var mes = $('#mes_filtro').val();
        var anio = $('#anio_filtro').val();
        var etapa = $('#etapa_filtro').val();
        var producto = $('#producto_filtro').val();
        var equipo=$('#equipo_filtro').val();
        var asesor=$('[name="assigned_user_name"]').val();
        var cliente=$('#filtroClienteBacklog').val();
        var tipo_operacion=$('#tipo_operacion').val();
        //Antes de cargar los filtro con la llamada al api, validamos que los filtros de mes y año no sean de meses y años anteriores
        var mes_actual = ((new Date).getMonth() + 1).toString();
        var anio_actual = (new Date).getFullYear();
        if ((Number(anio) < Number(anio_actual)) || (Number(mes) < Number(mes_actual) && Number(anio) <= Number(anio_actual) && mes != '')) {
            app.alert.show('sin_registros_bl', {
                level: 'error',
                messages: 'No se encontraron registros con este criterio de búsqueda.\n Favor de seleccionar mes y año posteriores a los actuales',
                autoClose: false
            });

            return;
        }
        this.cargarBacklogsGestion(mes, anio, etapa, producto,equipo,asesor,cliente,tipo_operacion);
    },

    cargarBacklogsGestion: function (mes, anio, etapa, producto,equipo,asesor,cliente,tipo_operacion) {
        self.mes_filtro = $('#mes_filtro').val();
        self.anio_filtro = $('#anio_filtro').val();
        self.etapa_filtro = $('#etapa_filtro').val();
        self.producto_filtro = $('#producto_filtro').val();
        self.equipo_filtro = $('#equipo_filtro').val();
        self.asesor_filtro=$('[name="assigned_user_name"]').val();
        self.cliente_filtro=$('#filtroClienteBacklog').val();
        self.tipo_operacion_filtro=$('#tipo_operacion').val();
        self.zona_filtro=$('#zona_filtro').val();

        var mes_actual = ((new Date).getMonth() + 1).toString();
        var anio_actual = (new Date).getFullYear();
        //Por default que carguen todos los bl del mes y año actual
        var filtro = null;
        var mes_original = mes;
        mes = (mes == "") ? mes_actual : mes;

        if (anio > anio_actual) {
            mes = 1;
        }

        filtro = {
            "filter": [
                {
                    $and: [
                        {
                            "anio": {
                                "$gte": anio
                            }
                        },
                        {
                            "mes": {
                                "$gte": mes
                            }
                        },
                        {
                            "estatus_operacion_c": {
                                "$equals": "2"
                            }
                        },

                    ]
                }
            ],
            "max_num": "-1"
        }


        if (mes_original != null && mes_original != "") {
            filtro["filter"][0]["$and"][filtro["filter"][0]["$and"].length] = { "mes": { "$equals": mes } }
        }
        if (anio != null && anio != "") {
            filtro["filter"][0]["$and"][filtro["filter"][0]["$and"].length] = { "anio": { "$equals": anio } }
        }
        //Con esta validación se asegura que la llamada a esta función proviene del botón y no de loadData
        if (etapa != null && producto != null) {
            $('#processing_buscar').show();
            $('#btn_Buscar_bl').attr("disabled", true);

            //Armar filtro con lo seleccionado en los campos de la sección de búsqueda
            //Validar que en los campos de Mes y Producto se encuentre seleccionada la opción de "Todos"
            if (etapa != null && etapa != "") {
                filtro["filter"][0]["$and"][filtro["filter"][0]["$and"].length] = { "etapa_c": { "$equals": etapa } }
            }
            if (producto != null && producto != "" && producto != "0") {

                if (producto == "3") {
                    filtro["filter"][0]["$and"][filtro["filter"][0]["$and"].length] = { "lumo_cuentas_c": { "$equals": "1" } }

                } else {
                    filtro["filter"][0]["$and"][filtro["filter"][0]["$and"].length] = { "producto_c": { "$equals": producto } }
                    filtro["filter"][0]["$and"][filtro["filter"][0]["$and"].length] = { "lumo_cuentas_c": { "$equals": "0" } }
                }
            }

            if(equipo!=null && equipo!="" && equipo!="0"){
                filtro["filter"][0]["$and"][filtro["filter"][0]["$and"].length] = { "equipo": { "$equals": equipo } }
            }

            if(asesor!=null && asesor!="" && asesor!=undefined){
                filtro["filter"][0]["$and"][filtro["filter"][0]["$and"].length] = { "assigned_user_id": { "$equals": asesor } }
            }

            if(cliente!=null && cliente!="" && cliente!=undefined){
                filtro["filter"][0]["$and"][filtro["filter"][0]["$and"].length] = { "name": { "$contains": cliente } }
            }

            if(tipo_operacion!=null && tipo_operacion!="" && tipo_operacion!=undefined && tipo_operacion.length>0){

                var array_tipo_op_leasing=[];
                var array_tipo_op_credito=[];
                //Si los id del select contienen un "0" al inicio, quiere decir que hay que buscar en el campo de leasing, en otro caso hay que buscar en el de crédito

                if(tipo_operacion.includes('01')){
                    array_tipo_op_leasing.push(1);
                    var index=tipo_operacion.indexOf('01');
                    tipo_operacion.splice(index,1);
                }
                if(tipo_operacion.includes('02')){
                    array_tipo_op_leasing.push(2);
                    var index=tipo_operacion.indexOf('02');
                    tipo_operacion.splice(index,1);
                }
                if(tipo_operacion.includes('03')){
                    array_tipo_op_leasing.push(3);
                    var index=tipo_operacion.indexOf('03');
                    tipo_operacion.splice(index,1);
                }
                if(tipo_operacion.includes('04')){
                    array_tipo_op_leasing.push(4);
                    var index=tipo_operacion.indexOf('04');
                    tipo_operacion.splice(index,1);
                }
                if(tipo_operacion.includes('05')){
                    array_tipo_op_leasing.push(5);
                    var index=tipo_operacion.indexOf('05');
                    tipo_operacion.splice(index,1);
                }

                //Se agrega condición para el id 3 (Crédito Puente) para que no se duplique en la lista, pero en caso de que se seleccione
                //busque tanto para Leasing como para Crdito
                if(tipo_operacion.includes('3')){
                    array_tipo_op_leasing.push(5);
                }

                if(array_tipo_op_leasing.length>0 && tipo_operacion.length==0){//Se tienen valores para Leasing y ninguno para Crédito

                    filtro["filter"][0]["$and"][filtro["filter"][0]["$and"].length] = { "num_tipo_op_leasing_c": { "$contains": array_tipo_op_leasing } }
                }else if(tipo_operacion.length>0 && array_tipo_op_leasing==0){
                    filtro["filter"][0]["$and"][filtro["filter"][0]["$and"].length] = { "num_tipo_op_credito_c": { "$contains": tipo_operacion } }
                }else{
                    filtro["filter"][0]["$and"][filtro["filter"][0]["$and"].length] = {"$or":[{ "num_tipo_op_leasing_c": { "$contains": array_tipo_op_leasing } },{ "num_tipo_op_credito_c": { "$contains": tipo_operacion } }] }
                }
            }

        }

        var filtroUsuarios = {
            "filter": [
                {
                    "status": {
                        "$equals": "Active"
                    }
                }
            ],
            "max_num": "-1",
            "fields":"id,region_c,user_name"
        }
        var urlBacklog=app.api.buildURL('lev_Backlog', null, null, filtro);
        var urlUsuarios=app.api.buildURL('Users', null, null, filtroUsuarios);

        urlBacklog="/" + urlBacklog.split("rest/")[1];
        urlUsuarios="/" + urlUsuarios.split("rest/")[1];


        var requestBulk = {
            "requests": [
                {
                    "url": urlBacklog, "method": "GET"
                },
                {
                    "url": urlUsuarios, "method": "GET"
                }

            ]
        }

        app.alert.show('getBacklogs', {
            level: 'process',
            title: 'Cargando, por favor espere.',
        });
        /****************************** */
        //Llamada hacia API BULK
        app.api.call('create', app.api.buildURL('bulk', null, null, requestBulk), null, {
            success: _.bind(function (data) {

                if (data[0].contents.records.length > 0)
                {
                    data.records=data[0].contents.records;
                    self.listaBacklogs = [];
                    self.cantidad_backlogs = data.records.length;
                    for (index = 0; index < data.records.length; index++) {
                        self.counter = 0;
                        //Obteniendo la región (zona) a la que pertenece el usuario asignado al backlog
                        var registros_usuarios=data[1].contents.records;
                        if(registros_usuarios.length>0){
                            var id_usuario_asignado=data.records[index].assigned_user_id;
                            for (var idxUsers = 0; idxUsers < registros_usuarios.length; idxUsers++) {
                                if(id_usuario_asignado==registros_usuarios[idxUsers].id){
                                    data.records[index].zona=registros_usuarios[idxUsers].region_c;
                                    //Al encontrar al usuario, se agrega condición para salir del ciclo for
                                    idxUsers=registros_usuarios.length;
                                }

                            }

                        }
                        //Obteniendo el nombre de la cuenta, se puede obtener a partir del nombre
                        var nombre_cuenta = data.records[index].name.split("-")[2]
                        data.records[index].nombre_cuenta = nombre_cuenta.trim();

                        //Calcular Tipo, basado en campo Lumo de Cuentas (Asumiendo que el campo Lumo de Backlog está sincronizado completamente con el de cuentas)
                        var idCuenta = data.records[index].account_id_c;
                        if (data.records[index].lumo_cuentas_c == 1) {
                            data.records[index].tipo_calculado = "LUMO";
                        } else {
                            data.records[index].tipo_calculado = app.lang.getAppListStrings('tipo_producto_list')[data.records[index].producto_c];
                        }

                        //Llenando el Tipo de Operación Producto
                        //num_tipo_op_leasing_c => num_tipo_op_leasing_list,
                        //num_tipo_op_credito_c => num_tipo_op_credito_list
                        var producto = data.records[index].producto_c;
                        var tipo_op_producto = "";
                        var tipo_op = "";
                        if (producto == "1") {
                            var lista_tipo_op_leasing = app.lang.getAppListStrings('num_tipo_op_leasing_list');
                            var tipo_op_valores = data.records[index].num_tipo_op_leasing_c;
                            //var tipo_op_ids=tipo_op.split(',');
                            var tipo_op_string = [];
                            for (let i = 0; i < tipo_op_valores.length; i++) {
                                tipo_op_string.push(lista_tipo_op_leasing[tipo_op_valores[i]]);
                            }
                            tipo_op = tipo_op_string.join(",");

                        } else {

                            var lista_tipo_op_credito = app.lang.getAppListStrings('num_tipo_op_credito_list');
                            var tipo_op_valores = data.records[index].num_tipo_op_credito_c;
                            //var tipo_op_ids=tipo_op.split(',');
                            var tipo_op_string = [];
                            for (let i = 0; i < tipo_op_valores.length; i++) {
                                tipo_op_string.push(lista_tipo_op_credito[tipo_op_valores[i]]);
                            }
                            tipo_op = tipo_op_string.join(",");

                        }
                        data.records[index].tipo_op = tipo_op;
                        //Formateo de números
                        data.records[index].monto_prospecto_c = Number(data.records[index].monto_prospecto_c);
                        data.records[index].monto_credito_c = tipo_op = Number(data.records[index].monto_credito_c);
                        data.records[index].monto_rechazado_c = tipo_op = Number(data.records[index].monto_rechazado_c);
                        data.records[index].monto_sin_solicitud_c = tipo_op = Number(data.records[index].monto_sin_solicitud_c);
                        data.records[index].monto_con_solicitud_c = tipo_op = Number(data.records[index].monto_con_solicitud_c);


                        self.listaBacklogs.push(data.records[index]);
                    }

                    //Una vez llena la lista de Backlogs, se procede a filtrar la zona
                    //Obtiene el valor de la zona
                    var zona_filtro=$('#zona_filtro').val();
                    if(self.listaBacklogs.length>0 && zona_filtro!=null && zona_filtro!="" && zona_filtro!=undefined && zona_filtro!="0"){

                        var listaBacklogsAuxiliar=[];
                        for (let index = 0; index < self.listaBacklogs.length; index++) {
                            if(self.listaBacklogs[index].zona==zona_filtro){
                                listaBacklogsAuxiliar.push(self.listaBacklogs[index]);
                            }
                        }
                        self.listaBacklogs=listaBacklogsAuxiliar;

                    }

                    var cliente_filtro=$('#filtroClienteBacklog').val();
                    if(self.listaBacklogs.length>0 && cliente_filtro!=null && cliente_filtro!="" && cliente_filtro!=undefined){

                        var listaBacklogsAuxiliar=[];
                        for (let index = 0; index < self.listaBacklogs.length; index++) {
                            if(self.listaBacklogs[index].nombre_cuenta.toLowerCase().includes(cliente_filtro.toLowerCase())){
                                listaBacklogsAuxiliar.push(self.listaBacklogs[index]);
                            }
                        }
                        self.listaBacklogs=listaBacklogsAuxiliar;

                    }

                } else {

                    app.alert.show('sin_registros_bl', {
                        level: 'error',
                        messages: 'No se encontraron registros con este criterio de búsqueda.',
                        autoClose: false
                    });

                    self.listaBacklogs = [];

                    app.alert.dismiss('getBacklogs');
                    $('#processing_buscar').hide();
                    $('#btn_Buscar_bl').removeAttr("disabled");
                }

                app.alert.dismiss('getBacklogs');
                $('#processing_buscar').hide();
                $('#btn_Buscar_bl').removeAttr("disabled");

                self.render();

                //Después de render, se restablecen los valores en la barra de búsqueda para que persistan los valores
                if (self.mes_filtro != undefined && self.anio_filtro != undefined && self.etapa_filtro != undefined && self.producto_filtro) {
                    $('#mes_filtro').val(self.mes_filtro);
                    $('#anio_filtro').val(self.anio_filtro);
                    $('#etapa_filtro').val(self.etapa_filtro);
                    $('#producto_filtro').val(self.producto_filtro);
                    $('#equipo_filtro').select2('val',self.equipo_filtro);
                    $('[name="assigned_user_name"]').select2('val',self.asesor_filtro);
                    $('#filtroClienteBacklog').val(self.cliente_filtro);
                    $('#tipo_operacion').select2('val',self.tipo_operacion_filtro);
                    $('#zona_filtro').select2('val',self.zona_filtro);

                } else {
                    //$('#mes_filtro').val(((new Date).getMonth()+2).toString());
                    $('#mes_filtro').select2('val', ((new Date).getMonth() + 1).toString());
                    //$('#anio_filtro').val((new Date).getFullYear());
                    $('#anio_filtro').select2('val', ((new Date).getFullYear()));
                    $('#etapa_filtro').select2('val', "");
                    $('#producto_filtro').select2('val', "0");
                    $('[name="assigned_user_name"]').select2("val","");
                    $('#filtroClienteBacklog').val("");
                    $('#tipo_operacion').select2('val',"");
                    $('#zona_filtro').select2('val',"0");
                }

                //Se lanza evento change a través de la clase para que el Monto, BL Estimado y Rango se calculen cuando la vista se cargue
                $(".monto_prospecto").trigger("change");

            }, self)
        });

    },

    calculaMonto: function (e) {

        //FORMATO MONEDA DE LOS CAMPOS DE MONTO
        var formatoMontoProspecto = Number($(e.currentTarget).parent().parent().parent().find('[data-field="monto_prospecto"]').val().replaceAll(",", "")).toLocaleString('es-MX');
        var formatoMontoDevuelta = Number($(e.currentTarget).parent().parent().parent().find('[data-field="monto_devuelta"]').val().replaceAll(",", "")).toLocaleString('es-MX');
        var formatoMontoCredito = Number($(e.currentTarget).parent().parent().parent().find('[data-field="monto_credito"]').val().replaceAll(",", "")).toLocaleString('es-MX');
        var formatoMontoRechazado = Number($(e.currentTarget).parent().parent().parent().find('[data-field="monto_rechazado"]').val().replaceAll(",", "")).toLocaleString('es-MX');
        var formatoMontoSinSolicitud = Number($(e.currentTarget).parent().parent().parent().find('[data-field="monto_sin_solicitud"]').val().replaceAll(",", "")).toLocaleString('es-MX');
        var formatoMontoConSolicitud = Number($(e.currentTarget).parent().parent().parent().find('[data-field="monto_con_solicitud"]').val().replaceAll(",", "")).toLocaleString('es-MX');
        //SETEA EL MONTO CON EL FORMATO DE MONEDA
        $(e.currentTarget).parent().parent().parent().find('[data-field="monto_prospecto"]').val(formatoMontoProspecto);
        $(e.currentTarget).parent().parent().parent().find('[data-field="monto_devuelta"]').val(formatoMontoDevuelta);
        $(e.currentTarget).parent().parent().parent().find('[data-field="monto_credito"]').val(formatoMontoCredito);
        $(e.currentTarget).parent().parent().parent().find('[data-field="monto_rechazado"]').val(formatoMontoRechazado);
        $(e.currentTarget).parent().parent().parent().find('[data-field="monto_sin_solicitud"]').val(formatoMontoSinSolicitud);
        $(e.currentTarget).parent().parent().parent().find('[data-field="monto_con_solicitud"]').val(formatoMontoConSolicitud);
        //SETEA LOS VALORES DE LOS MONTOS A NIVEL SPAN
        $(e.currentTarget).parent().parent().parent().find('[data-field="span_monto_prospecto"]').text(formatoMontoProspecto);
        $(e.currentTarget).parent().parent().parent().find('[data-field="span_monto_devuelta"]').text(formatoMontoDevuelta);
        $(e.currentTarget).parent().parent().parent().find('[data-field="span_monto_credito"]').text(formatoMontoCredito);
        $(e.currentTarget).parent().parent().parent().find('[data-field="span_monto_rechazado"]').text(formatoMontoRechazado);
        $(e.currentTarget).parent().parent().parent().find('[data-field="span_monto_sin_solicitud"]').text(formatoMontoSinSolicitud);
        $(e.currentTarget).parent().parent().parent().find('[data-field="span_monto_con_solicitud"]').text(formatoMontoConSolicitud);
        //Obtiene valor y se lo suma al monto
        //var valorActual=$(e.currentTarget).val();
        var suma = 0;
        var campos_con_montos = $(e.currentTarget).parent().parent().parent().find('.montos');

        for (let index = 0; index < campos_con_montos.length; index++) {
            if (campos_con_montos.eq(index).val() != "") {
                suma += parseFloat(campos_con_montos.eq(index).val().replaceAll(",", ""));
            }
        }
        var formatoMontoTotal = suma.toLocaleString('es-MX');
        $(e.currentTarget).parent().parent().parent().find('[name="monto"]').val(formatoMontoTotal);

        if ($(e.currentTarget).parent().parent().parent().find('[name="actualizado"]').val() == "") {

            var etapa = $(e.currentTarget).parent().parent().parent().find('[data-field="etapa_c"]').val();
            var monto_prospecto = $(e.currentTarget).parent().parent().parent().find('[data-field="monto_prospecto"]').val().replaceAll(",", "");
            var monto_devuelta = $(e.currentTarget).parent().parent().parent().find('[data-field="monto_devuelta"]').val().replaceAll(",", "");
            var monto_credito = $(e.currentTarget).parent().parent().parent().find('[data-field="monto_credito"]').val().replaceAll(",", "");
            var monto_rechazado = $(e.currentTarget).parent().parent().parent().find('[data-field="monto_rechazado"]').val().replaceAll(",", "");
            var monto_sin_solicitud = $(e.currentTarget).parent().parent().parent().find('[data-field="monto_sin_solicitud"]').val().replaceAll(",", "");
            var monto_con_solicitud = $(e.currentTarget).parent().parent().parent().find('[data-field="monto_con_solicitud"]').val().replaceAll(",", "");
            var comentarios = $(e.currentTarget).parent().parent().parent().find('[data-field="comentarios"]').val();
            var probabilidad = $(e.currentTarget).parent().parent().parent().find('[data-field="probabilidad"]').val();
            var concat = etapa + monto_prospecto + monto_credito + monto_rechazado + monto_sin_solicitud + monto_con_solicitud + monto_devuelta + comentarios + probabilidad;
            $(e.currentTarget).parent().parent().parent().find('[name="actualizado"]').val(concat);

        }

        $(e.currentTarget).parent().parent().parent().find('[name="monto"]').trigger('change');

    },

    // soloNumerosDecimales: function (e) {
    //     var charC = (e.which) ? e.which : e.keyCode;
    //     if (charC == 46) {
    //         if ($(e.currentTarget).val().indexOf('.') === -1) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     } else {
    //         if (charC > 31 && (charC < 48 || charC > 57))
    //             return false;
    //     }
    //     return true;
    // },

    soloNumeros: function (e) {
        var charCode = (e.which) ? e.which : e.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    },

    calculaBLEstimado: function (e) {
        var valorMonto = $(e.currentTarget).parent().parent().parent().find('.montoTotal').val().replaceAll(",", "");
        var valorProbabilidad = $(e.currentTarget).parent().parent().parent().find('.probabilidad').val();

        if (valorProbabilidad < 0 || valorProbabilidad > 100) {
            $(e.currentTarget).parent().parent().parent().find('.probabilidad').val(0);
            valorProbabilidad = 0;

            app.alert.show('val_fields_probabilidad', {
                level: 'error',
                messages: 'Ingresa un valor entre 0 a 100',
                autoClose: false
            });
        }

        if (valorMonto != "" && valorProbabilidad != "") {

            var bl_Estimado = parseFloat(valorMonto) * (parseFloat(valorProbabilidad) / 100);
            var formatoBLEstimado = bl_Estimado.toLocaleString('es-MX');
            $(e.currentTarget).parent().parent().parent().find('[name="blEstimado"]').val(formatoBLEstimado);

        }

        //Una vez actualizado el monto, se calcula también el rango
        if ($(e.currentTarget).attr("name") == 'monto') {
            var rango = this.calculaRango($(e.currentTarget).val().replaceAll(",", ""));
            if (rango != null) {
                var lista_rangos = app.lang.getAppListStrings('rango_bl_list');
                $(e.currentTarget).parent().parent().parent().find('[name="rangoBL"]').val(lista_rangos[rango]);
                $(e.currentTarget).parent().parent().parent().find('[name="rangoBL"]').attr("data-id", rango);
            }
        }
    },

    calculaRango: function (valorMonto) {
        var lista_rangos = app.lang.getAppListStrings('rango_bl_list');
        var rango_encontrado = null;
        var bandera = 0;
        for (const rango in lista_rangos) {
            if (bandera == 0) {
                var valores_entre = rango.split(' ');
                if (valores_entre.length == 2) {
                    if (parseFloat(valorMonto) >= parseFloat(valores_entre[0]) && parseFloat(valorMonto) <= parseFloat(valores_entre[1])) {
                        rango_encontrado = rango;
                        bandera = 1;
                    }
                } else {
                    rango_encontrado = "100000001";
                    //bandera=1;
                }

            }

        }
        return rango_encontrado;
    },

    guardarBacklogs: function () {
        //Armar estructura json para mandar petición de actualización a través de un bulk
        var peticion = {
            "requests": [
            ]
        }

        var lista_peticiones = [];

        $('#processingGuardar').show();
        $('#btn_guardar').attr("disabled", true);
        $('#btn_actualizar_valores_masivo').attr("disabled", true);

        var contador = 0;
        var contador_lista = 0;
        var restantes = $('.registroBL').length;

        //Arreglo que guarda valores ids de backlogs para guardar en tabla de auditoria
        var ids_bl_audit={
            "backlogs_audit":[]
        }
        //Recorriendo los registros de la tabla para armar la petición BULK
        $('.registroBL').each(function (i, obj) {

            var id_bl = $(this).attr("data-id");
            var etapa = $(this).find("select.etapa_c").val();
            var monto_prospecto = $(this).find(".monto_prospecto").val().replaceAll(",", "");
			var monto_devuelta = $(this).find(".monto_devuelta").val().replaceAll(",", "");
            var monto_credito = $(this).find(".monto_credito").val().replaceAll(",", "");
            var monto_rechazado = $(this).find(".monto_rechazado").val().replaceAll(",", "");
            var monto_sin_solicitud = $(this).find(".monto_sin_solicitud").val().replaceAll(",", "");
            var monto_con_solicitud = $(this).find(".monto_con_solicitud").val().replaceAll(",", "");
            var monto = $(this).find(".montoTotal").val().replaceAll(",", "");
            var comentarios = $(this).find(".comentarios").val();
            var probabilidad = $(this).find(".probabilidad").val();
            var bl_estimado = $(this).find(".blEstimado").val().replaceAll(",", "");
            var tipo = $(this).find(".tipo").html();
            var rango = $(this).find(".rango_bl").attr('data-id');
            var concat = etapa + monto_prospecto + monto_credito + monto_rechazado + monto_sin_solicitud + monto_con_solicitud + monto_devuelta + comentarios + probabilidad;
            var concatOriginal = $(this).find(".actualizado").val();
            restantes--;

            if (concat != concatOriginal) {

                ids_bl_audit["backlogs_audit"].push(id_bl);

                var data = "{\"etapa_c\": \"test123\"}";
                peticion["requests"][contador] = {
                    "url": "/v11_8/lev_Backlog/" + id_bl, "method": "PUT", "data": "{\"etapa_c\": \"" + etapa + "\"," +
                        "\"monto_prospecto_c\":" + Number(monto_prospecto) + "," +
						"\"monto_devuelta_c\": " + Number(monto_devuelta) + "," +
                        "\"monto_credito_c\": " + Number(monto_credito) + "," +
                        "\"monto_rechazado_c\":" + Number(monto_rechazado) + "," +
                        "\"monto_sin_solicitud_c\": " + Number(monto_sin_solicitud) + "," +
                        "\"monto_con_solicitud_c\": " + Number(monto_con_solicitud) + "," +
                        //"\"monto_comprometido\": " + Number(monto) + "," +
                        "\"comentarios_c\": \"" + comentarios +"-adminbl-"+ "\"," +
                        "\"tct_conversion_c\": " + Number(probabilidad) + "," +
                        "\"bl_estimado_c\": " + Number(bl_estimado) + "," +
                        "\"tipo_bl_c\": \"" + tipo + "\"," +
                        "\"rango_bl_c\": \"" + rango + "\"}"
                }
                contador++;
            }
            //Se reinicia el contador, para que se vaya por bloques en la actualización masiva
            if (contador >= 9 || (restantes == 0 && peticion['requests'].length > 0)) {

                lista_peticiones[contador_lista] = peticion;
                contador = 0;
                contador_lista++;
                peticion = {
                    "requests": [
                    ]
                }
            }
        });

        if (lista_peticiones.length > 0) {

            var num_peticiones = lista_peticiones.length;
            var num_peticion_actual = 0;

            for (var peticion_actual = 0; peticion_actual < lista_peticiones.length; peticion_actual++) {

                app.alert.show('save-Backlog', {
                    level: 'process',
                    title: 'Guardando cambios, por favor espere.',
                });

                //Llamada hacia API BULK
                app.api.call('create', app.api.buildURL('bulk', null, null, lista_peticiones[peticion_actual]), null, {
                    success: _.bind(function (data) {

                        num_peticion_actual++;

                        //app.alert.dismiss('save-Backlog');

                        app.alert.show('backlogs_actualizados_correctos', {
                            level: 'success',
                            messages: 'Registros actualizados correctamente',
                            autoClose: true
                        });

                        if (num_peticiones == num_peticion_actual) {
                            self.cargarBacklogsGestionButton();

                            $('#processingGuardar').hide();
                            $('#btn_guardar').removeAttr("disabled");
                            $('#btn_actualizar_valores_masivo').removeAttr("disabled");
                        }

                    }, self)
                });
            }

            //Se agrega petición para api custom que actualizará valores en la tabla audit
            if(ids_bl_audit["backlogs_audit"].length>0){

                //Llamada a api
                app.api.call('create', app.api.buildURL('SetAuditBacklogs', null, null,ids_bl_audit ), null, {
                    success: _.bind(function (data) {

                        app.alert.dismiss('save-Backlog');

                    }, self)
                });

            }
        } else {

            App.alert.show('backlog_sin_cambios', {
                level: 'info',
                messages: 'No hay cambios para actualizar',
                autoClose: true
            });

            $('#processingGuardar').hide();
            $('#btn_guardar').removeAttr("disabled");
            $('#btn_actualizar_valores_masivo').removeAttr("disabled");
        }
    },

    actualizaValoresMasivo: function () {

        var campo = $('#campo_actualizacion_masiva').val();
        var valorCampo = $("#campo_masivo").val();

        $('#campo_actualizacion_masiva').parent().parent().parent().find('.record-label').attr('style', "");
        $(".probabilidad_campo_masivo").css('border-color', '');

        if (campo == "") {
            $('#campo_actualizacion_masiva').parent().parent().parent().find('.record-label').attr('style', "color:red");
            app.alert.show('campo_no_seleccionado', {
                level: 'error',
                messages: 'Elige un campo para actualización masiva',
                autoClose: false
            });
            return;
        }

        if (valorCampo == "") {
            $(".probabilidad_campo_masivo").css('border-color', 'red');

            app.alert.show('masivo_sin_valor', {
                level: 'error',
                messages: 'Elige un valor para actualizar',
                autoClose: false
            });
            return;
        }

        if (campo == 'probabilidad' && (valorCampo < 0 || valorCampo > 100)) {
            $(".probabilidad_campo_masivo").css('border-color', 'red');

            app.alert.show('masivo_val_probabilidad', {
                level: 'error',
                messages: 'Ingresa un valor entre 0 a 100',
                autoClose: false
            });
            return;
        }

        //ToDo: Obtener el nombre del campo que se quiere actualizar para modificar los valores de ese campo en la tabla
        if (campo == 'probabilidad' && valorCampo != "") {
            $(".probabilidad").val(valorCampo);
            $(".probabilidad").trigger('change');
        }
        if (campo == 'monto_prospecto' && valorCampo != "") {
            $(".monto_prospecto").val(valorCampo);
            $(".monto_prospecto").trigger('change');
        }
        if (campo == 'devuelta' && valorCampo != "") {
            $(".monto_devuelta").val(valorCampo);
            $(".monto_devuelta").trigger('change');
        }
        if (campo == 'monto_credito' && valorCampo != "") {
            $(".monto_credito").val(valorCampo);
            $(".monto_credito").trigger('change');
        }
        if (campo == 'monto_rechazado' && valorCampo != "") {
            $(".monto_rechazado").val(valorCampo);
            $(".monto_rechazado").trigger('change');
        }
        if (campo == 'monto_sin_solicitud' && valorCampo != "") {
            $(".monto_sin_solicitud").val(valorCampo);
            $(".monto_sin_solicitud").trigger('change');
        }
        if (campo == 'monto_con_solicitud' && valorCampo != "") {
            $(".monto_con_solicitud").val(valorCampo);
            $(".monto_con_solicitud").trigger('change');
        }
    },
})
