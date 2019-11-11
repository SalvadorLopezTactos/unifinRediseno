/**
 * Created by salvadorlopez salvador.lopez@tactos.com.mx
 */
({
    events: {
        'click #btn_Cuentas': 'buscarCuentasNoContactar',
    },

    initialize: function(options){
        this._super("initialize", [options]);

        this.tipo_cuenta= App.lang.getAppListStrings('tipo_registro_list');

        this.loadView = false;
        if(app.user.attributes.tct_no_contactar_chk_c=='1'){
            this.loadView = true;
            this.render();
        }else{
            var route = app.router.buildRoute(this.module, null, '');
            app.router.navigate(route, {trigger: true});
        }

    },

    _render: function () {
        this._super("_render");

        var tipos_cuenta=[];
        this.$('#tipo_de_cuenta').select2({
            width:'250px',
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

    buscarCuentasNoContactar:function () {

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

        var from_set = $("#offset_value").attr("from_set");
        var to_set = $("#offset_value").attr("to_set");
        var current_set = $("#offset_value").html();
        var from_set_num = parseInt(from_set);
        var filtroCliente = $("#filtroCliente").val();
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
    }

})
