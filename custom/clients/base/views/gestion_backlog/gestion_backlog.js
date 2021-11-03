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

        'keypress .monto_prospecto': 'soloNumerosDecimales',
        'keypress .monto_credito': 'soloNumerosDecimales',
        'keypress .monto_rechazado': 'soloNumerosDecimales',
        'keypress .monto_sin_solicitud': 'soloNumerosDecimales',
        'keypress .monto_con_solicitud': 'soloNumerosDecimales',
        'keypress .probabilidad': 'soloNumeros',

        'change .probabilidad': 'calculaBLEstimado',
        'change .montoTotal': 'calculaBLEstimado',

        'click #btn_guardar': 'guardarBacklogs',

    },

    meses_list_html : null,
    anio_list_html_filter : null,
    etapa_list_html : null,
    producto_list_html : null,

    initialize: function(options){
        self=this;

        this._super("initialize", [options]);

        this.etapa_list_html = app.lang.getAppListStrings('etapa_c_list');
        this.etapa_list_html[''] = "";

        this.producto_list_html = {};
		this.producto_list_html["0"] = "Todos";
        this.producto_list_html["1"] = "Leasing";
        this.producto_list_html["2"] = "Crédito Simple";
        
        this.mes_filtro = ((new Date).getMonth()+1).toString();
        this.anio_filtro = ((new Date).getFullYear()).toString();
    },

    _render: function () {
        this._super("_render");
    },

    loadData: function (options) {
        if (_.isUndefined(this.model)) {
            return;
        }
        var self = this;
        this.meses_list_html = app.lang.getAppListStrings('mes_list');
        this.meses_list_html[""]="Todos";
        this.mes_filtro = ((new Date).getMonth()+1).toString();
        
        this.anio_filtro = ((new Date).getFullYear()).toString();
        var anio_list = app.lang.getAppListStrings('anio_list');

        this.etapa_filtro = "";
        this.producto_filtro = "";
        
        var currentYear = new Date().getFullYear();
        Object.keys(anio_list).forEach(function(key){
          if(key < currentYear-2) {
            delete anio_list[key];
          }
        });
        this.anio_list_html_filter = anio_list;
        this.lista_etapas=app.lang.getAppListStrings('etapa_c_list');

        var anio_actual = (new Date).getFullYear();
        //var mes_actual = self.getActualBacklog();
        var mes_actual = ((new Date).getMonth()+2).toString();

        this.cargarBacklogsGestion(mes_actual,anio_actual,null,null);
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

    cargarBacklogsGestionButton:function(){
        var mes=$('#mes_filtro').val();
        var anio=$('#anio_filtro').val();
        var etapa=$('#etapa_filtro').val();
        var producto=$('#producto_filtro').val();
        this.cargarBacklogsGestion(mes,anio,etapa,producto);
    },

    cargarBacklogsGestion: function(mes,anio,etapa,producto){
        self.mes_filtro=$('#mes_filtro').val();
        self.anio_filtro=$('#anio_filtro').val();
        self.etapa_filtro=$('#etapa_filtro').val();
        self.producto_filtro=$('#producto_filtro').val();

        //Por default que carguen todos los bl del mes y año actual
        var filtro=null;

        //Con esta validación se asegura que la llamada a esta función proviene del botón y no de loadData
        if(etapa !=null && producto!=null ){
            $('#processing_buscar').show();
            $('#btn_Buscar_bl').attr("disabled", true);
            //Armar filtro con lo seleccionado en los campos de la sección de búsqueda
            //Validar que en los campos de Mes y Producto se encuentre seleccionada la opción de "Todos"
            if((mes=="" && etapa=="" && producto=="0") || (mes!="" && etapa=="" && producto=="0")){
                filtro={
                    "filter":[
                        {
                            $and:[
                                {
                                    "anio":{
                                        "$in":[anio]
                                    }
                                },
                                {
                                    "mes":{
                                        "$in":[mes]
                                    }
                                }
                            ]
                        }
                    ]
                }
            }else if(mes!="" && etapa!="" && producto=="0"){
                filtro={
                    "filter":[
                        {
                            $and:[
                                {
                                    "anio":{
                                        "$in":[anio]
                                    }
                                },
                                {
                                    "mes":{
                                        "$in":[mes]
                                    }
                                },
                                {
                                    "etapa_c":{
                                        "$in":[etapa]
                                    }
                                }
                            ]
                        }
                    ]
                }
            }else if(mes!="" && etapa!="" && producto!="0"){
                filtro={
                    "filter":[
                        {
                            $and:[
                                {
                                    "anio":{
                                        "$in":[anio]
                                    }
                                },
                                {
                                    "mes":{
                                        "$in":[mes]
                                    }
                                },
                                {
                                    "etapa_c":{
                                        "$in":[etapa]
                                    }
                                },
                                {
                                    "producto_c":{
                                        "$in":[producto]
                                    }
                                }
                            ]
                        }
                    ]
                }

            }
            
        }else{//Si entra en este else, se lanzó el filtro por default
            filtro={
                "filter":[
                    {
                        $and:[
                            {
                                "anio":{
                                    "$in":[anio]
                                }
                            },
                            {
                                "mes":{
                                    "$in":[mes]
                                }
                            }
                        ]
                    }
                ]
            }
        }

        app.alert.show('getBacklogs', {
            level: 'process',
            title: 'Cargando, por favor espere.',
        });
        app.api.call('GET', app.api.buildURL('lev_Backlog', null, null, filtro), null, {
            success: _.bind(function (data){

                if(data.records.length > 0) {
                    self.listaBacklogs=[];
                    self.cantidad_backlogs=data.records.length;
                    for ( index = 0; index < data.records.length; index++) {
                        self.counter=0;
                        //Obteniendo el nombre de la cuenta, se puede obtener a partir del nombre
                        var nombre_cuenta=data.records[index].name.split("-")[2]
                        data.records[index].nombre_cuenta=nombre_cuenta.trim();

                        //Calcular Tipo, basado en campo Lumo de Cuentas
                        var idCuenta=data.records[index].account_id_c;
                        app.api.call("read", app.api.buildURL("Accounts/"+idCuenta, null, null, {
                            fields: "lumo_c"
                        }), null, {
                            success: _.bind(function (dataCuenta) {
                                if (dataCuenta) {
                                    
                                    if(dataCuenta.lumo_c==1){
                                        self.listaBacklogs[self.counter].tipo_calculado="LUMO";
                                        
                                    }else{
                                        self.listaBacklogs[self.counter].tipo_calculado=app.lang.getAppListStrings('tipo_producto_list')[self.listaBacklogs[self.counter].producto_c];
                                    }
                                    
                                    //Validación aplicada para que únicamente se aplique render cuando se hayan terminado de ejecutar todas las peticiones
                                    if(self.counter==self.cantidad_backlogs-1){
                                        app.alert.dismiss('getBacklogs');
                                        $('#processing_buscar').hide();
                                        $('#btn_Buscar_bl').removeAttr("disabled");
                                        self.render();

                                        //Después de render, se restablecen los valores en la barra de búsqueda para que persistan los valores
                                        if(self.mes_filtro!=undefined && self.anio_filtro!=undefined && self.etapa_filtro!=undefined && self.producto_filtro){
                                            $('#mes_filtro').val(self.mes_filtro);
                                            $('#anio_filtro').val(self.anio_filtro);
                                            $('#etapa_filtro').val(self.etapa_filtro);
                                            $('#producto_filtro').val(self.producto_filtro);
                                        }else{
                                            //$('#mes_filtro').val(((new Date).getMonth()+2).toString());
                                            $('#mes_filtro').select2('val',((new Date).getMonth()+2).toString());
                                            //$('#anio_filtro').val((new Date).getFullYear());
                                            $('#anio_filtro').select2('val',((new Date).getFullYear()));
                                            $('#etapa_filtro').select2('val',"");
                                            $('#producto_filtro').select2('val',"0");
                                        }

                                        //Se lanza evento change a través de la clase para que el Monto, BL Estimado y Rango se calculen cuando la vista se cargue
                                        $(".monto_prospecto").trigger("change");
                                        
                                    }
                                    self.counter++;
                                }
                                
                            }, this)
                        });

                        //Llenando el Tipo de Operación Producto 
                        //num_tipo_op_leasing_c => num_tipo_op_leasing_list, 
                        //num_tipo_op_credito_c => num_tipo_op_credito_list
                        var producto=data.records[index].producto_c;
                        var tipo_op_producto="";
                        var tipo_op="";
                        if(producto=="1"){
                            var lista_tipo_op_leasing=app.lang.getAppListStrings('num_tipo_op_leasing_list');
                            var tipo_op_valores=data.records[index].num_tipo_op_leasing_c;
                            //var tipo_op_ids=tipo_op.split(',');
                            var tipo_op_string=[];
                            for (let i = 0; i < tipo_op_valores.length; i++) {
                                tipo_op_string.push(lista_tipo_op_leasing[tipo_op_valores[i]]);
                            }
                            tipo_op=tipo_op_string.join(",");

                        }else{

                            var lista_tipo_op_credito=app.lang.getAppListStrings('num_tipo_op_credito_list');
                            var tipo_op_valores=data.records[index].num_tipo_op_credito_c;
                            //var tipo_op_ids=tipo_op.split(',');
                            var tipo_op_string=[];
                            for (let i = 0; i < tipo_op_valores.length; i++) {
                                tipo_op_string.push(lista_tipo_op_credito[tipo_op_valores[i]]);
                            }
                            tipo_op=tipo_op_string.join(",");

                        }
                        data.records[index].tipo_op=tipo_op;

                        self.listaBacklogs.push(data.records[index]);
                    }
                }else{

                    app.alert.show('sin_registros_bl', {
                        level: 'error',
                        messages: 'No se encontraron registros con este criterio de búsqueda.',
                        autoClose: false
                    });

                    app.alert.dismiss('getBacklogs');
                    $('#processing_buscar').hide();
                    $('#btn_Buscar_bl').removeAttr("disabled");
                }

                self.render();
            }, self)
        });


    },

    calculaMonto:function(e){
        //Obtiene valor y se lo suma al monto
        //var valorActual=$(e.currentTarget).val();
        var suma=0;
        var campos_con_montos=$(e.currentTarget).parent().parent().parent().find('.montos');
        for (let index = 0; index < campos_con_montos.length; index++) {
            if(campos_con_montos.eq(index).val()!=""){
                suma+=parseFloat(campos_con_montos.eq(index).val());
            }
        }
        $(e.currentTarget).parent().parent().parent().find('[name="monto"]').val(suma);

        $(e.currentTarget).parent().parent().parent().find('[name="monto"]').trigger('change');
        
    },

    soloNumerosDecimales:function(e){
        const regex = /[^\d.]|\.(?=.*\.)/g;
        const subst=``;
        const str=$(e.currentTarget).val();
        const result = str.replace(regex, subst);
        $(e.currentTarget).val(result);
    },

    soloNumeros:function(e){
        var charCode = (e.which) ? e.which : e.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    },

    calculaBLEstimado:function(e){
        var valorMonto=$(e.currentTarget).parent().parent().parent().find('.montoTotal').val();
        var valorProbabilidad=$(e.currentTarget).parent().parent().parent().find('.probabilidad').val();

        if(valorMonto!="" && valorProbabilidad !=""){

            var bl_Estimado= parseFloat(valorMonto) * (parseFloat(valorProbabilidad)/100);

            $(e.currentTarget).parent().parent().parent().find('[name="blEstimado"]').val(bl_Estimado);

        }

        //Una vez actualizado el monto, se calcula también el rango
        if($(e.currentTarget).attr("name")=='monto'){
            var rango=this.calculaRango($(e.currentTarget).val());
            if(rango!=null){
                var lista_rangos=app.lang.getAppListStrings('rango_bl_list');
                $(e.currentTarget).parent().parent().parent().find('[name="rangoBL"]').val(lista_rangos[rango]);
                $(e.currentTarget).parent().parent().parent().find('[name="rangoBL"]').attr("data-id",rango);
            }
        }
    },

    calculaRango:function(valorMonto){
        var lista_rangos=app.lang.getAppListStrings('rango_bl_list');
        var rango_encontrado=null;
        var bandera=0;
        for (const rango in lista_rangos) {
            if(bandera==0){
                var valores_entre=rango.split(' ');
                if(valores_entre.length==2){
                    if(parseFloat(valorMonto)>=parseFloat(valores_entre[0]) && parseFloat(valorMonto)<=parseFloat(valores_entre[1])){
                        rango_encontrado=rango;
                        bandera=1;
                    }
                }else{
                    rango_encontrado="100000001";
                    //bandera=1;
                }

            }
            
        }
        return rango_encontrado;
    },

    guardarBacklogs:function(){
        //Armar estructura json para mandar petición de actualización a través de un bulk
        var peticion={
            "requests":[
            ]
        }

        $('#processingGuardar').show();
        $('#btn_guardar').attr("disabled", true);

        //Recorriendo los registros de la tabla para armar la petición BULK
        $('.registroBL').each(function(i, obj) {
            var id_bl=$(this).attr("data-id");
            var etapa=$(this).find("select.etapa_c").val();
            var monto_prospecto=$(this).find(".monto_prospecto").val();
            var monto_credito=$(this).find(".monto_credito").val();
            var monto_rechazado=$(this).find(".monto_rechazado").val();
            var monto_sin_solicitud=$(this).find(".monto_sin_solicitud").val();
            var monto_con_solicitud=$(this).find(".monto_con_solicitud").val();
            var monto=$(this).find(".montoTotal").val();
            var comentarios=$(this).find(".comentarios").val();
            var probabilidad=$(this).find(".probabilidad").val();
            var bl_estimado=$(this).find(".blEstimado").val();
            var tipo=$(this).find(".tipo").html();
            var rango=$(this).find(".rango_bl").attr('data-id');

            var data="{\"etapa_c\": \"test123\"}";
            peticion["requests"][i]={"url": "/v11_8/lev_Backlog/"+id_bl, "method": "PUT", "data": "{\"etapa_c\": \""+etapa+"\","+
            "\"monto_prospecto_c\":"+Number(monto_prospecto)+","+
            "\"monto_credito_c\": "+Number(monto_credito)+","+
            "\"monto_rechazado_c\":"+Number(monto_rechazado)+","+
            "\"monto_sin_solicitud_c\": "+Number(monto_sin_solicitud)+","+
            "\"monto_con_solicitud_c\": "+Number(monto_con_solicitud)+","+
            "\"monto_comprometido\": "+Number(monto)+","+
            "\"comentarios_c\": \""+comentarios+"\","+
            "\"tct_conversion_c\": "+Number(probabilidad)+","+
            "\"bl_estimado_c\": "+Number(bl_estimado)+","+
            "\"tipo_bl_c\": \""+tipo+"\","+
            "\"rango_bl_c\": \""+rango+"\"}"}
        });

        //Llamada hacia API BULK
        app.api.call('create', app.api.buildURL('bulk', null, null, peticion), null, {
            success: _.bind(function (data){

                app.alert.show('backlogs_actualizados_correctos', {
                    level: 'success',
                    messages: 'Registros actualizados correctamente',
                    autoClose: true
                });

                self.cargarBacklogsGestionButton();

                $('#processingGuardar').hide();
                $('#btn_guardar').removeAttr("disabled");

            }, self)
        });

    }
})
