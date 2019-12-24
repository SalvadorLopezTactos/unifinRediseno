/**
 * Created by Jorge on 7/17/2015.
 */
/**
 * Created by Jorge on 6/1/2015.
 */
({

    className: 'Reasignacion-de-promotores',

    events: {
        'click #btn_Cuentas': 'buscarCuentas',
        'click #btn_ReAsignar': 'reAsignarCuentas',
        'click .selected': 'seleccionarCuentas',
        'click #btn_STodo': 'seleccionarTodo',
        'click #next_offset': 'nextOffset',
        'click #previous_offset': 'previousOffset',
        'change #filtroCliente': '_setOffset',
    },

    initialize: function(options){
        this._super("initialize", [options]);

        this.cuentas = '';
        this.seleccionados = [];
        this.persistNoSeleccionados=[];
        this.flagSeleccionados=0;
        this.tipo_cuenta= App.lang.getAppListStrings('tipo_registro_list');
        this.model.on('change:users_accounts_1users_ida', this._setOffset, this);

        this.loadView = false;
        app.api.call("read", app.api.buildURL("UserRoles", null, null, {
        }), null, {
            success: _.bind(function (data) {
                var roleReasignacionPromotores = false;
                _.each(data, function (key, value) {

                    if (key == "Reasignacion de Promotores") {
                        roleReasignacionPromotores = true;
                    }
                });

                if(roleReasignacionPromotores == true){
                    this.obtenerProductosUsuario();
                    this.loadView = true;
                    this.render();
                }else{
                    var route = app.router.buildRoute(this.module, null, '');
                    app.router.navigate(route, {trigger: true});
                }

            }, this)
        });

    },

    _render: function () {
        this._super("_render");
        var tipos_cuenta=[];
         this.$('#tipo_de_cuenta').select2({
             width:'400px',
             closeOnSelect: false,
             containerCssClass: 'select2-choices-pills-close'
         });

        for (var key in this.tipo_cuenta) {
            if (this.tipo_cuenta.hasOwnProperty(key)) {
                tipos_cuenta.push(key);
            }
        }
        this.$("#tipo_de_cuenta").select2('val', tipos_cuenta);
    },

    _setOffset: function (){
        $("#offset_value").attr("from_set", 0);
        $("#crossSeleccionados").val("");
    },

    seleccionarTodo: function(e){

        if(this.persistNoSeleccionados!=undefined && this.persistNoSeleccionados.length>0){

            for(var i=0;i<this.persistNoSeleccionados.length;i++){

                //Añadir el elemento solo si no existe en arreglo full_cuentas
                if(!this.full_cuentas.includes(this.persistNoSeleccionados[i])){
                    this.full_cuentas.push(this.persistNoSeleccionados[i])
                }
            }

            this.persistNoSeleccionados=[];

        }else{

            this.persistNoSeleccionados=[];
        }
        

        //Control de bandera para saber si se ha oprimido el botón de "Seleccionar Todo" y de esta manera saber si el siguiente "offset" de la tabla
        // debe mostrarse con los check como true
        if(this.flagSeleccionados==0){
            this.flagSeleccionados=1;
        }else {
            this.flagSeleccionados=0;
        }
        var btnState = $(e.target).attr("btnState");
        if(btnState == "Off"){
            $(e.target).attr("btnState", "On");
            btnState='On';
        }else{
            $(e.target).attr("btnState", "Off");
            btnState='Off';
        }

        $('.selected').each(function (index, value) {
            if(btnState == "On"){
                //$(value).attr("checked", true);
                $(value).prop('checked', true);
            }else{
                //$(value).attr("checked", false);
                $(value).prop('checked', false);
            }
        });

        var seleccionarTodo = [];
        var crossSeleccionados = $("#crossSeleccionados").val();
        if(!_.isEmpty(crossSeleccionados)) {
            seleccionarTodo = JSON.parse(crossSeleccionados);
        }

        if($('.selected').prop("checked")) {
            $(this.cuentas).each(function (index, value) {
                seleccionarTodo.push(value.id);
            });
        }else{
            seleccionarTodo = [];
        }

        this.seleccionados = seleccionarTodo;
        $("#crossSeleccionados").val(JSON.stringify(this.seleccionados));
    },

    nextOffset: function(){
        var current_set = $("#offset_value").html();
        var from_set = $("#offset_value").attr("from_set");
        var next_from_set = parseInt(from_set) + 20;
        var to_set = $("#offset_value").attr("to_set");
        var next_to_set = parseInt(to_set) + 20;

        if(next_to_set > this.total){
            next_to_set = this.total;

            if(from_set > 0){
                next_from_set = from_set;
            }else{
                next_from_set = next_from_set;
            }
        }

        $("#offset_value").html(current_set);
        $("#offset_value").attr("from_set", next_from_set);
        $("#offset_value").attr("to_set", next_to_set);
        this.buscarCuentas();
    },

    previousOffset: function(){
        var current_set = $("#offset_value").html();
        var from_set = $("#offset_value").attr("from_set");
        var next_from_set = parseInt(from_set) - 20;
        var to_set = $("#offset_value").attr("to_set");
        var next_to_set = parseInt(to_set) - 20;

        if(next_from_set < 0){
            next_from_set = 0;
            next_to_set = 20;
        }

        $("#offset_value").html(current_set);
        $("#offset_value").attr("from_set", next_from_set);
        $("#offset_value").attr("to_set", next_to_set);
        this.buscarCuentas();
    },

    buscarCuentas: function(){
        var assigneUsr = this.model.get('users_accounts_1users_ida');
        //Condición para controlar la búsqueda cuando no se ha seleccionado Promotor, esto sucede cuando se da click en el icono con el tache
        //dentro del campo Asesor Actual con formato select2
        if(assigneUsr==""){
            assigneUsr=undefined;
        }
        var tipos_seleccionados=this.$(".tipo_cuenta").select2('val');
        if((_.isEmpty(assigneUsr) || _.isUndefined(assigneUsr) || assigneUsr == "") && (tipos_seleccionados.includes('Prospecto') || tipos_seleccionados.includes('Cliente') || tipos_seleccionados.includes('Lead'))) {
            var alertOptions = {
                title: "Por favor, seleccione un Asesor",
                level: "error"
            };
            app.alert.show('validation', alertOptions);
            return;
        }

        var producto_seleccionado = $("#Productos").val();
        var from_set = $("#offset_value").attr("from_set");
        var to_set = $("#offset_value").attr("to_set");
        var current_set = $("#offset_value").html();
        var from_set_num = parseInt(from_set);
        var filtroCliente = $("#filtroCliente").val();
        var crossSeleccionados = $("#crossSeleccionados").val();
        var filtroTipoCuenta=$("#tipo_de_cuenta").select2('val');

        if(_.isEmpty($("#tipo_de_cuenta").select2('val'))){

            var alertOptions = {
                title: "Por favor, seleccionar al menos un Tipo de Cuenta",
                level: "error"
            };
            app.alert.show('validation', alertOptions);
            return;

        }

        if(isNaN(from_set_num)){
            from_set_num = 0;
        }
        assigneUsr += "?PRODUCTO=" + producto_seleccionado + "?" + from_set_num + "?" + filtroCliente+"&tipos_cuenta="+filtroTipoCuenta.toString();

        if(!_.isEmpty(assigneUsr) && !_.isUndefined(assigneUsr) && assigneUsr != "") {
            this.seleccionados = [];
            $('#successful').hide();
            $('#processing').show();
            app.api.call("read", app.api.buildURL("ReasignaciondePromotoresBusqueda/" + assigneUsr, null, null, {}), null, {
                success: _.bind(function (data) {
                    console.log(typeof data);
                    console.log(data);
                    if (data.total <= 0) {
                        var alertOptions = {
                            title: "No se encontraron clientes para el usuario seleccionado del producto: " + producto_seleccionado,
                            level: "error"
                        };
                        app.alert.show('validation', alertOptions);
                        $('#processing').hide();
                        return;
                    }
                    $('#processing').hide();
                    this.cuentas = typeof data=="string"?null:data.cuentas;

                    this.total = data.total;
                    this.total_cuentas = data.total_cuentas;
                    //Controlar los checks deseleccionados para que persistan al volver a obtener valores de la petición al api
                    if(this.persistNoSeleccionados!=undefined && this.persistNoSeleccionados.length>0){

                        var tempArray=data.full_cuentas;
                        for(var i=0;i<this.persistNoSeleccionados.length;i++){
                            if(tempArray.includes(this.persistNoSeleccionados[i])){
                                var index = tempArray.indexOf(this.persistNoSeleccionados[i]);
                                if (index > -1) {
                                  tempArray.splice(index, 1);
                                }                                
                            }
                        }

                        this.full_cuentas=tempArray;

                    }else{
                        this.full_cuentas=data.full_cuentas;
                    }
                    //Se obtiene valor de Tipo de Cuenta, para que persista al aplicar render
                    var valores=$("#tipo_de_cuenta").select2('val');
                    this.render();
                    $("#tipo_de_cuenta").select2('val',valores);

                    if(this.flagSeleccionados==1){
                        $('#btn_STodo').attr('btnstate','On');
                        var context=this;
                        $('.selected').each(function (index, value) {
                            //Validación para persistir valores de los checks en caso de que se haya "Seleccionado Todo"
                            //y se hayan deseleccionado registros individualmente
                            if(context.persistNoSeleccionados!=undefined && context.persistNoSeleccionados.length>0){

                                if(context.persistNoSeleccionados.includes($(this).attr('value'))){
                                    $(value).prop("checked", false)
                                }else{
                                    $(value).prop("checked", true);
                                }
                            }else{

                                $(value).prop("checked", true);

                            }
                        });

                    }
                    $("#Productos").val(producto_seleccionado);

                    if(to_set > this.total){
                        to_set = this.total;
                    }else{
                        to_set = from_set_num + data.total_cuentas;
                    }

                    current_set = (parseInt(from_set) + 1) + " a " + to_set + " de " + this.total;
                    if(_.isEmpty(from_set)){
                        from_set = 0;
                        to_set = 20;

                        if(to_set > this.total){
                            to_set = this.total;
                        }

                        current_set = (parseInt(from_set) + 1) + " a " + to_set + " de " + this.total;
                    }
                    $("#offset_value").html(current_set);
                    $("#offset_value").attr("from_set", from_set);
                    $("#offset_value").attr("to_set", to_set);
                    $("#filtroCliente").val(filtroCliente);

                    if(!_.isEmpty(crossSeleccionados)) {
                        context=this;
                        this.seleccionados = JSON.parse(crossSeleccionados);
                        //Validar que los nuevos checks seleccionados no existen en crossSeleccionados
                        $('.selected').each(function (index, value) {
                            if( $(value).attr("checked")=="checked" && context.flagSeleccionados==1 || $(value).attr("checked")==true && context.flagSeleccionados==1){
                                if(!context.seleccionados.includes(value.value) && value.value!=0){
                                    context.seleccionados.push(value.value)
                                }

                            }
                        });
                        $("#crossSeleccionados").val(JSON.stringify(this.seleccionados));

                        $(this.seleccionados).each(function (index, selected) {
                            $('.selected').each(function (index, value) {

                                if(selected == value.value){
                                    $(value).prop("checked", true);
                                }

                            });

                        });
                    }
                }, this)
            });
        }else{
            var alertOptions = {
                title: "Por favor, seleccione un asesor",
                level: "error"
            };
            app.alert.show('validation', alertOptions);
        }
    },

    seleccionarCuentas: function(e){

        var seleccionarTodo = [];
        var crossSeleccionados = $("#crossSeleccionados").val();
        if(!_.isEmpty(crossSeleccionados)) {
            seleccionarTodo = JSON.parse(crossSeleccionados);
        }

        if($(e.target).is(':checked')){
            seleccionarTodo.push($(e.target).val());
            this.seleccionados = seleccionarTodo;
        }else{
            var itemToRemove = $(e.target).val();
            var seleccionadosClone = seleccionarTodo;
            var seleccionadosCleaned = [];
            this.seleccionados = [];
            $(seleccionadosClone).each(function( index,value ) {
                if(value != itemToRemove){
                    seleccionadosCleaned.push(value);
                }
            });
            this.seleccionados = seleccionadosCleaned;
        }

        //Validación para controlar checks seleccionados en caso de que se hayan seleccionado todos los registros
        //(Click en Selecionar Todo)
        if(this.full_cuentas.length >0 && this.full_cuentas != undefined){
            var idAccount=$(e.target).val();
            if(this.full_cuentas.includes(idAccount)){
                //Validar que el check ha sido seleccionado o no, en caso de que no se haya "activado", se elimina del arreglo de full_cuentas
                if($(e.target).prop("checked")==false){
                    var position=this.full_cuentas.indexOf(idAccount)
                    this.full_cuentas.splice(position,1);

                    this.persistNoSeleccionados.push(idAccount);

                }
            }else{

                if($(e.target).prop("checked")){
                    var position=this.full_cuentas.indexOf(idAccount)
                    this.full_cuentas.splice(position,0,idAccount);
                }

            }

        }

        $("#crossSeleccionados").val(JSON.stringify(this.seleccionados));
    },

    reAsignarCuentas: function(){
        var reAssignarA = this.model.get('asignar_a_promotor_id');
        var promoActual = this.model.get('users_accounts_1users_ida');

        var radioBl="";

        if($('#optRadioSig:checked').val()=='on'){
            radioBl="siguientes";

        }else{
            radioBl="actualSiguientes";
        }

        if(this.flagSeleccionados==1){
            this.seleccionados=this.full_cuentas;
        }
        if(!_.isEmpty(reAssignarA)) {
            var parametros = this.seleccionados;
            var producto_seleccionado = $("#Productos").val();
            if(!_.isEmpty(parametros)) {
                var Params = {
                    'optBl':radioBl,
                    'seleccionados': parametros,
                    'reAssignado': reAssignarA,
                    'producto_seleccionado': producto_seleccionado,
                    'promoActual': promoActual,
                };
                app.alert.show('reasignando', {
                    level: 'process',
                    title: 'Cargando...'
                });
                var dnbProfileUrl = app.api.buildURL("reAsignarCuentas", '', {}, {});
                app.api.call("create", dnbProfileUrl, {data: Params}, {
                    success: _.bind(function (data) {
                        console.log(typeof data);
                        if(data==true){
                            app.alert.dismiss('reasignando');
                            this.cuentas = [];
                            this.seleccionados = [];
                            this.render();
                            $('#successful').show();
                            this.model.set("users_accounts_1users_ida","");
                            this.model.set("users_accounts_1_name","");
                            this.model.set("asignar_a_promotor_id","");
                            this.model.set("asignar_a_promotor","");
                        }else{
                            app.alert.dismiss('reasignando');
                            var alertOptions = {
                                title: "El tipo de producto entre el asesor actual y reasignado debe ser el mismo",
                                level: "error"
                            };
                            app.alert.show('validation', alertOptions);
                        }
                    }, this)
                });
            }else{
                var alertOptions = {
                    title: "No hay clientes seleccionadas para reasignar",
                    level: "error"
                };
                app.alert.show('validation', alertOptions);
            }
        }else{
            var alertOptions = {
                title: "Por favor, seleccione un asesor Destino",
                level: "error"
            };
            app.alert.show('validation', alertOptions);
        }
    },

    obtenerProductosUsuario: function (){
        var userId = App.user.id;
        this.productos_list = [];
        var productos_label = app.lang.getAppListStrings('tipo_producto_list');

        app.api.call("read", app.api.buildURL("Users/" + userId, null, null, {}), null, {
            success: _.bind(function (data) {

                var list_html = '';
                _.each(data.productos_c, function(value, key) {
                    list_html += '<option value="' + productos_label[value] + '">' + productos_label[value] + '</option>';
                });

                this.productos_list = list_html;
                this.render();
            }, this)
        });
    },

})
