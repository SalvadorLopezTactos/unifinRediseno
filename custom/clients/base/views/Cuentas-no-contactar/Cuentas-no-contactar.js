/**
 * Created by salvadorlopez salvador.lopez@tactos.com.mx
 */
({
    events: {
        'click #btn_Cuentas': 'buscarCuentasNoContactar',
        'click #next_offset': 'nextOffset',
        'click #previous_offset': 'previousOffset',
        'change .selected': 'selectedCheckbox',
        'click #btn_no_contactar':'btnNoContactar',
        'click #btn_read_csv':'procesarCSV'
    },

    ids_cuentas:[],

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

        this.ids_cuentas=[];

    },

    _render: function () {
        this._super("_render");

        var tipos_cuenta=[];
        this.$('#tipo_de_cuenta').select2({
            width:'450px',
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
        //Inicializar arreglo de cuentas cada que se busca por un filtro, para evitar actualizar cuentas que anteriormente se seleccionaron
        this.ids_cuentas=[];

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
        assigneUsr += "?from=" + from_set_num + "&cliente=" + filtroCliente+"&tipos_cuenta="+filtroTipoCuenta.toString();
        //"c57e811e-b81a-cde4-d6b4-5626c9961772?PRODUCTO=LEASING?0?&tipos_cuenta=Lead,Prospecto,Cliente,Persona,Proveedor"

        if(!_.isEmpty(assigneUsr) && !_.isUndefined(assigneUsr) && assigneUsr != "") {
            this.seleccionados = [];
            $('#successful').hide();
            $('#processing').show();
            app.api.call("read", app.api.buildURL("CuentasNoContactar/" + assigneUsr, null, null, {}), null, {
                success: _.bind(function (data) {
                    console.log(typeof data);
                    console.log(data);
                    if (data.total <= 0) {
                        var nombre_usuario=$('input[name="users_accounts_1_name"]').parent().find('div.ellipsis_inline').attr('title');
                        var alertOptions = {
                            title: "No se encontraron Cuentas de los tipos seleccionados para el usuario <b>"+nombre_usuario+"</b>",
                            level: "error"
                        };
                        app.alert.show('validation', alertOptions);
                        $('#processing').hide();
                        return;
                    }
                    $('#processing').hide();
                    this.cuentas = typeof data=="string"?null:data.cuentas;

                    /*Bloque de código únicamente utilizado para mostrar correctamente el valor de los checkbox en archivo hbs, basado directamente en la consulta a la bd*/
                    if(this.cuentas.length>0){
                        for(var i=0;i<this.cuentas.length;i++){

                            if(this.cuentas[i].tct_no_contactar_chk_c==0){
                                this.cuentas[i].tct_no_contactar_chk_c=null;
                            }

                        }
                    }

                    this.total = data.total;
                    this.total_cuentas = data.total_cuentas;

                    //Se obtiene valor de Tipo de Cuenta, para que persista al aplicar render
                    var valores=$("#tipo_de_cuenta").select2('val');
                    this.render();
                    $("#tipo_de_cuenta").select2('val',valores);

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
        this.buscarCuentasNoContactar();
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
        this.buscarCuentasNoContactar();
    },

    selectedCheckbox:function (e) {
        var id_cuenta=$(e.currentTarget).val();

        var indexFind=this.ids_cuentas.indexOf(id_cuenta);
        //Antes de agregar al arreglo, comprobar que existe, en caso positivo, se elimina
        if(this.ids_cuentas.length > 0 && indexFind != -1){

            this.ids_cuentas.splice(indexFind,1);

        }else{

            this.ids_cuentas.push($(e.currentTarget).val());

        }
        
        if(this.ids_cuentas.length>0){
            $('#btn_no_contactar').eq(0).removeClass('disabled')
            $('#btn_no_contactar').attr('style','');

        }else{
            $('#btn_no_contactar').eq(0).addClass('disabled')
            $('#btn_no_contactar').attr('style','pointer-events:none');
        }

    },

    btnNoContactar:function(){

        var Params = {
            'cuentas':this.ids_cuentas
        };

        var urlNoContactar = app.api.buildURL("ActualizarCuentasNoContactar", '', {}, {});
        $('#successful').hide();
        $('#processing').show();
        app.api.call("create", urlNoContactar, {data: Params}, {
            success: _.bind(function (data) {
                 $('#processing').hide();
                 this.render();
                 $('.cuentasContainer').hide();
                 $('#successful').show();
            }, this)
        });

    },

    procesarCSV:function () {
        //Validar que se haya seleccionado un archivo
        var fileInput = document.getElementById('csv_no_contactar');
        var archivo=fileInput.value;
        if(archivo=="" || archivo==undefined){
            app.alert.show('errorAlert', {
                level: 'error',
                messages: 'Favor de elegir un archivo',
                autoClose: true
            });
        }else{
            $('#successful').hide();
            $('#processing').show();
            app.alert.show('reasignandoCSV', {
              level: 'process',
              title: 'Cargando...'
            });
            $('.btn_read_csv').addClass('disabled');
            $('.btn_read_csv').attr('style', 'pointer-events:none;margin:10px');        
            var file = fileInput.files[0];
            var nombre = file.name;
            var textType = /text.*/;
            self=this;
            var reader = new FileReader();
            reader.onload = function(e) {
              var content = reader.result;
              var arr_ids=content.split('\n');
              var Params = {
                "documento":content,
                "archivo":nombre,
                "tipo":'nocontactar'
              };
              if(content.trim() == ""){
                $('.btn_read_csv').removeClass('disabled');
                $('.btn_read_csv').attr('style', 'margin:10px');
                app.alert.dismiss('reasignandoCSV');                    
                app.alert.show('csvVacio', {
                  level: 'error',
                  messages: 'Archivo sin contenido, favor de elegir un archivo v\u00E1lido',
                  autoClose: false
                });
              }
              else{
                var Url = app.api.buildURL("guardaCSV", '', {}, {});
                app.api.call("create", Url, {data: Params}, {
                  success: _.bind(function (data) {
                    app.alert.dismiss('reasignandoCSV');
                    $('.btn_read_csv').removeClass('disabled');
                    $('.btn_read_csv').attr('style', 'margin:10px');
                    app.alert.show('csvOK', {
                      level: 'success',
                      messages: 'Archivo cargado con éxito. Le llegará un correo con el resultado de la actualización',
                      autoClose: false
                    });
                    self.render();
                  },this),
                  error: function (e) {
                    throw e;
                  }
                });
              }
            }
            reader.readAsText(file);
        }
    }
})
