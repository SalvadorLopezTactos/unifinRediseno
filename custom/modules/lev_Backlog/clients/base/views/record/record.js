/**
 * Created by Levementum on 3/2/2016.
 * User: jgarcia@levementum.com
 */
({
    extendsFrom: 'RecordView',

    events: {
        'keydown [name=dif_residuales_c]': 'checkInVentas',
        'keydown [name=tasa_c]': 'checkInVentas',
        'keydown [name=comision_c]': 'checkInVentas',
        'keydown [name=monto_comprometido]': 'checkInVentas',
        'keydown [name=porciento_ri]': 'checkInVentas',
        'keydown [name=renta_inicial_comprometida]': 'checkInVentas',

    },
    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);

        this.getCurrentYearMonth();
        this.model.on("change:anio", _.bind(this.getCurrentYearMonth, this));
        //this.model.on("change:cliente", _.bind(this.getTipoCliente, this));
        this.model.addValidationTask('check_monto_c', _.bind(this._ValidateAmount, this));
        this.model.addValidationTask('check_tipo_cliente', _.bind(this._ValidateTipo, this));
        this.model.on("change:porciento_ri", _.bind(this.calcularRI, this));
        this.model.on("change:monto_comprometido", _.bind(this.calcularRI, this));
        this.model.on("change:renta_inicial_comprometida", _.bind(this.calcularPorcientoRI, this));
        this.model.on("change:monto_final_comprometido_c", _.bind(this.setRI, this));
        //this.model.on("change:ri_final_comprometida_c", _.bind(this.setEtapa, this));
        this.model.addValidationTask('igualaMontosFinales', _.bind(this.igualaMontoFinalOpp, this));
    },

    _render: function() {
        this._super("_render");

        if (this.model.dataFetched) {
            this.$('[data-name=editar]').hide();
            self.model.set("editar", true);
            if (self.$('[data-fieldname=lev_backlog_opportunities_name]').children().children(['data-original-title']).html() != null &&
                self.$('[data-fieldname=lev_backlog_opportunities_name]').children().children(['data-original-title']).html() != "") {
                self.model.set("editar", false);
            }
        }

        var usuario = app.data.createBean('Users',{id:app.user.get('id')});
        usuario.fetch({
            success: _.bind(function(modelo) {

                this.productos = modelo.get('productos_c');
                this.productoUsuario = modelo.get('tipodeproducto_c');
                this.multiProducto = modelo.get('multiproducto_c');


                var op = app.lang.getAppListStrings('tipo_producto_list');
                var op2 = {};
                for (id in this.productos){
                    op2[this.productos[id]] = op[this.productos[id]];
                }
                var lista = this.getField('producto');  
                lista.items = op2;    
                lista.render();

                if(this.productos[0] == "4"){
                    this.model.set('producto','4');
                }else if(this.productos[0] == "1"){
                    this.model.set('producto','1');
                }else if(this.productos[0] == "3"){
                    this.model.set('producto','3');
                }else if(this.productos[0] == "2"){
                    this.model.set('producto','3');
                }
                else if(this.productos[0] == "5"){
                    this.model.set('producto','5');
                }

                //this.model.set("region", modelo.get("region_c"));
            },this)
        });
    },

    checkInVentas:function (evt) {
        var enteros=this.checkmoneyint(evt);
        var decimales=this.checkmoneydec(evt);
        $.fn.selectRange = function(start, end) {
            if(!end) end = start;
            return this.each(function() {
                if (this.setSelectionRange) {
                    this.focus();
                    this.setSelectionRange(start, end);
                } else if (this.createTextRange) {
                    var range = this.createTextRange();
                    range.collapse(true);
                    range.moveEnd('character', end);
                    range.moveStart('character', start);
                    range.select();
                }
            });
        };//funcion para posicionar cursor

        (function ($, undefined) {
            $.fn.getCursorPosition = function() {
                var el = $(this).get(0);
                var pos = [];
                if('selectionStart' in el) {
                    pos = [el.selectionStart,el.selectionEnd];
                } else if('selection' in document) {
                    el.focus();
                    var Sel = document.selection.createRange();
                    var SelLength = document.selection.createRange().text.length;
                    Sel.moveStart('character', -el.value.length);
                    pos = Sel.text.length - SelLength;
                }
                return pos;
            }
        })(jQuery); //funcion para obtener cursor
        var cursor=$(evt.handleObj.selector).getCursorPosition();//setear cursor


        if (enteros == "false" && decimales == "false") {
            if(cursor[0]==cursor[1]) {
                return false;
            }
        }else if (typeof enteros == "number" && decimales == "false") {
            if (cursor[0] < enteros) {
                $(evt.handleObj.selector).selectRange(cursor[0], cursor[1]);
            } else {
                $(evt.handleObj.selector).selectRange(enteros);
            }
        }

    },

    checkmoneyint: function (evt) {
        if (!evt) return;
        var $input = this.$(evt.currentTarget);
        var digitos = $input.val().split('.');
        if($input.val().includes('.')) {
            var justnum = /[\d]+/;
        }else{
            var justnum = /[\d.]+/;
        }
        var justint = /^[\d]{0,14}$/;

        if((justnum.test(evt.key))==false && evt.key!="Backspace" && evt.key!="Tab" && evt.key!="ArrowLeft" && evt.key!="ArrowRight"){
            app.alert.show('error_dinero', {
                level: 'error',
                autoClose: true,
                messages: 'El campo no acepta caracteres especiales.'
            });
            return "false";
        }

        if(typeof digitos[0]!="undefined") {
            if (justint.test(digitos[0]) == false && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
                console.log('no se cumplen enteros')
                if(!$input.val().includes('.')) {
                    $input.val($input.val()+'.')
                }
                return "false";

            } else {
                return digitos[0].length;
            }
        }
    },

    checkmoneydec: function (evt) {
        if (!evt) return;
        var $input = this.$(evt.currentTarget);
        var digitos = $input.val().split('.');
        if($input.val().includes('.')) {
            var justnum = /[\d]+/;
        }else{
            var justnum = /[\d.]+/;
        }
        var justdec = /^[\d]{0,1}$/;

        if((justnum.test(evt.key))==false && evt.key!="Backspace" && evt.key!="Tab" && evt.key!="ArrowLeft" && evt.key!="ArrowRight"){
            app.alert.show('error_dinero', {
                level: 'error',
                autoClose: true,
                messages: 'El campo no acepta caracteres especiales.'
            });
            return "false";
        }
        if(typeof digitos[1]!="undefined") {
            if (justdec.test(digitos[1]) == false && evt.key != "Backspace" && evt.key != "Tab" && evt.key != "ArrowLeft" && evt.key != "ArrowRight") {
                console.log('no se cumplen dec')
                return "false";
            } else {
                return "true";
            }
        }
    },


    getCurrentYearMonth: function(){

        var currentYear = (new Date).getFullYear();
        var currentMonth = (new Date).getMonth();
        var currentDay = (new Date).getDate();

        if(currentDay < 20){
            currentMonth += 1;
        }
        if(currentDay >= 20){
            currentMonth += 2;
        }

        var mes = this.model.get("mes");
        var opciones_year = app.lang.getAppListStrings('anio_list');
        Object.keys(opciones_year).forEach(function(key){
            if(key < currentYear && key != mes){
                delete opciones_year[key];
            }
        });
        this.model.fields['anio'].options = opciones_year;

        var opciones_mes = app.lang.getAppListStrings('mes_list');
        if(this.model.get("anio") <= currentYear){
            Object.keys(opciones_mes).forEach(function(key){
                if(key < currentMonth && key != mes){
                    delete opciones_mes[key];
                }
            });
        }

        this.model.fields['mes'].options = opciones_mes;
        //this.render();
    },

    getTipoCliente: function(){
        //console.log("getTipoCliente");
        app.api.call("read", app.api.buildURL("Accounts/" + this.model.get('account_id_c'), null, null, {
            fields: name,
        }), null, {
            success: _.bind(function (data) {
                if(data.tipo_registro_c == "Prospecto"){
                    this.model.set("tipo","Prospecto");
                    this.model.set("etapa_preliminar","Prospecto");
                    this.model.set("etapa","Prospecto");
                }else if(data.tipo_registro_c == "Cliente"){
                    //console.log("Valida lineas de credito autorizadas para leasing");
                    app.api.call("read", app.api.buildURL("Accounts/" + this.model.get('account_id_c') + "/link/opportunities", null, null, {
                        fields: name,
                        "filter": [
                            {
                                "tipo_operacion_c": "2",
                                "tipo_producto_c": "1",
                                "amount":{
                                    "$gt":"0"
                                }
                            }
                        ]
                    }), null, {
                        success: _.bind(function (data) {
                            var disponible = 0;
                            $.each(data.records,function() {
                                disponible += parseFloat(this.amount);
                                //console.log(disponible);
                            });
                            //console.log(data.records.length);
                            if (data.records.length > 0) {
                                this.model.set("tipo","Cliente");
                                this.model.set("etapa_preliminar","Con_linea");
                                this.model.set("etapa","Con_linea");
                                this.model.set("monto_original",disponible);
                            }else{
                                this.model.set("tipo","Prospecto");
                                this.model.set("etapa_preliminar","Prospecto");
                                this.model.set("etapa","Prospecto");
                                this.model.set("monto_original",0);
                            }
                        }, this)
                    });
                }else{
                    this.model.set("tipo","Persona");
                    this.model.set("etapa_preliminar","Prospecto");
                    this.model.set("etapa","Prospecto");
                }
                /*
                 if(data.tipo_registro_c == "Cliente" && data.estatus_c == "Integracion de Expediente"){
                 this.model.set("tipo","Prospecto");
                 this.model.set("etapa_preliminar","Prospecto");
                 this.model.set("etapa","Prospecto");
                 }*/
            }, this)
        });
    },

    _ValidateAmount: function (fields, errors, callback){
        if (parseFloat(this.model.get('monto_comprometido')) <= 0)
        {
            errors['monto_comprometido'] = errors['monto_comprometido'] || {};
            errors['monto_comprometido'].required = true;
        }

        /*if (parseFloat(this.model.get('renta_inicial_comprometida')) <= 0)
        {
            errors['renta_inicial_comprometida'] = errors['renta_inicial_comprometida'] || {};
            errors['renta_inicial_comprometida'].required = true;
        }*/

        callback(null, fields, errors);
    },

    _ValidateTipo: function(fields, errors, callback){
        if(this.model.get("tipo") == "Persona"){

            errors['tipo'] = errors['tipo'] || {};
            errors['tipo'].required = true;

            app.alert.show('tipo de persona', {
                level: 'error',
                messages: 'No se puede crear un Backlog para este tipo',
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    calcularRI: function(){
        var ElaborationBacklog = this.getElaborationBacklog();
        var currentDay = (new Date).getDate();
        var currentMonth = (new Date).getMonth() + 1;
        var mesBL = this.model.get("mes") - 2;

        //CVV se cambia la validaci�n para permitir actualizar el BL hasta antes dek d�a 20
        //if (this.model.get("estatus_de_la_operacion") != 'Comprometida') {
        if (this.model.get("mes") >= ElaborationBacklog && this.model.get("estatus_de_la_operacion") == 'Comprometida'){
            if(currentDay <= 20 || (currentMonth == mesBL && currentDay > 20) || this.model.get("mes") > ElaborationBacklog){
                if (!_.isEmpty(this.model.get("monto_comprometido")) && !_.isEmpty(this.model.get("porciento_ri"))) {
                    var percent = ((this.model.get("monto_comprometido") * this.model.get("porciento_ri")) / 100).toFixed(2);
                    this.model.set("renta_inicial_comprometida", percent);
                }
            }
        }
    },

    calcularPorcientoRI: function(){
        var ElaborationBacklog = this.getElaborationBacklog();
        var currentDay = (new Date).getDate();
        var currentMonth = (new Date).getMonth() + 1;
        var mesBL = this.model.get("mes") - 2;

        //CVV se cambia la validaci�n para permitir actualizar el BL hasta antes dek d�a 20
        //if (this.model.get("estatus_de_la_operacion") != 'Comprometida'){
        if (this.model.get("mes") >= ElaborationBacklog && this.model.get("estatus_de_la_operacion") == 'Comprometida'){
            if(currentDay <= 20 || (currentMonth == mesBL && currentDay > 20) || this.model.get("mes") > ElaborationBacklog){
                if (this.model.get("renta_inicial_comprometida") == 0){
                    this.model.set("porciento_ri", 0);
                }else{
                    if(!_.isEmpty(this.model.get("monto_comprometido")) && !_.isEmpty(this.model.get("renta_inicial_comprometida"))){
                        var percent = ((this.model.get("renta_inicial_comprometida") * 100) / this.model.get("monto_comprometido")).toFixed(2);
                        this.model.set("porciento_ri", percent);
                    }
                }
            }
        }
    },

    igualaMontoFinalOpp: function(fields, errors, callback){
        var ElaborationBacklog = this.getElaborationBacklog();
        var currentDay = (new Date).getDate();
        var currentMonth = (new Date).getMonth() + 1;
        var mesBL = this.model.get("mes") - 2;

        if (this.model.get("mes") >= ElaborationBacklog && this.model.get("estatus_de_la_operacion") == 'Comprometida'){
            if(currentDay <= 20 || (currentMonth == mesBL && currentDay > 20) || this.model.get("mes") > ElaborationBacklog){
                this.model.set("monto_comprometido",this.model.get("monto_final_comprometido_c"));
                this.model.set("renta_inicial_comprometida",this.model.get("ri_final_comprometida_c"));
                app.alert.show("Moto Modificado", {
                    level: "info",
                    title: "El Monto de Operacion se igualara al Monto Final ya que el Backlog aun esta en revisión.",
                    autoClose: false
                });
            }
        }
        this.setEtapa();
        callback(null, fields, errors);
    },


    getElaborationBacklog: function(){
        //Obtiene el Backlog en elaboraci�n
        var currentDay = (new Date).getDate();
        var BacklogCorriente = (new Date).getMonth()+1;

        if(currentDay > 20){ // Si ya cerro el periodo de elaboraci�n de promotor, el Backlog del siguiente mes (natural) se encuentra corriendo
            BacklogCorriente += 2;
        }else{
            BacklogCorriente += 1;
        }

        if (BacklogCorriente > 12){  //Si resulta mayor a diciembre
            BacklogCorriente = BacklogCorriente - 12;
        }

        return BacklogCorriente;
    },

    setEtapa: function(){
        //Se recalcula la distribuci�n de montos en cada etapa
        var RI = 0;
        if (parseFloat(this.model.get("monto_final_comprometido_c")) > 0){
            var RI = (parseFloat(this.model.get("ri_final_comprometida_c")) / parseFloat(this.model.get("monto_final_comprometido_c"))).toFixed(2);
        }
        //El monto en compras no se altera, el resto de lo comprometido se manda a Sin Solicitud
        var SinSolicitud = parseFloat(this.model.get("monto_final_comprometido_c")) - parseFloat(this.model.get("monto_con_solicitud_c"));
        var RISinSolicitud = SinSolicitud * RI;

        //Si el disponible NO alcanza para el resto de la operacion se manda el disponible a SinSolicitud y el resto a PROCESO
        if (parseFloat(this.model.get("monto_original")) < (SinSolicitud - RISinSolicitud)){
            SinSolicitud = parseFloat(this.model.get("monto_original"));
        }
        if(SinSolicitud < 0){
            SinSolicitud = 0;
        }
        RISinSolicitud = SinSolicitud * RI;

        //Asignamos montos Sin Solicitud al modelo
        this.model.set("monto_sin_solicitud_c", SinSolicitud);
        this.model.set("ri_sin_solicitud_c", RISinSolicitud);

        //El monto restante de la operacion se reparte en etapas de "Proceso"
        var MontoSolicitudes =  parseFloat(this.model.get("monto_final_comprometido_c")) - parseFloat(this.model.get("monto_con_solicitud_c")) - parseFloat(SinSolicitud);
        if (parseFloat(MontoSolicitudes) > 0){
            var RISolicitudes = parseFloat(MontoSolicitudes) * parseFloat(RI);
            if (parseFloat(this.model.get("monto_prospecto_c")) > 0){
                this.model.set("monto_prospecto_c",MontoSolicitudes);
                this.model.set("ri_prospecto_c", RISolicitudes);
                this.model.set("monto_credito_c",0);
                this.model.set("ri_credito_c", 0);
                this.model.set("monto_rechazado_c",0);
                this.model.set("ri_rechazada_c", 0);
            }
            if (parseFloat(this.model.get("monto_credito_c")) > 0){
                this.model.set("monto_credito_c",MontoSolicitudes);
                this.model.set("ri_credito_c", RISolicitudes);
                this.model.set("monto_prospecto_c",0);
                this.model.set("ri_prospecto_c", 0);
                this.model.set("monto_rechazado_c",0);
                this.model.set("ri_rechazada_c", 0);
            }
            if (parseFloat(this.model.get("monto_rechazado_c"),0) > 0){
                this.model.set("monto_rechazado_c",MontoSolicitudes);
                this.model.set("ri_rechazada_c", RISolicitudes);
                this.model.set("monto_prospecto_c",0);
                this.model.set("ri_prospecto_c", 0);
                this.model.set("monto_credito_c",0);
                this.model.set("ri_credito_c", 0);
            }
            if (parseFloat(this.model.get("monto_prospecto_c")) == 0 && parseFloat(this.model.get("monto_credito_c")) == 0 && parseFloat(this.model.get("monto_rechazado_c")) == 0){
                this.model.set("monto_prospecto_c",MontoSolicitudes);
                this.model.set("ri_prospecto_c", RISolicitudes);
                this.model.set("monto_credito_c",0);
                this.model.set("ri_credito_c", 0);
                this.model.set("monto_rechazado_c",0);
                this.model.set("ri_rechazada_c", 0);
            }
        }else{
            this.model.set("monto_prospecto_c",0);
            this.model.set("ri_prospecto_c", 0);
            this.model.set("monto_credito_c",0);
            this.model.set("ri_credito_c", 0);
            this.model.set("monto_rechazado_c",0);
            this.model.set("ri_rechazada_c", 0);
        }

        //Calcula la etapa del Backlog
        //Si no tiene solicitud de compra se puede evaluar
        if (this.model.get("progreso") == 2 && this.model.get("etapa") == "Prospecto" && this.model.get("monto_original") > 0){
            var MontoOperar = parseFloat(this.model.get("monto_final_comprometido_c")) - parseFloat(this.model.get("ri_final_comprometida_c"));
            if(parseFloat(this.model.get("monto_original")) >= MontoOperar){
                this.model.set("etapa","Autorizada");
                if (this.model.get("estatus_de_la_operacion") == 'Comprometida'){
                    this.model.set("etapa_preliminar","Autorizada");
                }
            }else{
                this.model.set("etapa","Prospecto");
                if (this.model.get("estatus_de_la_operacion") == 'Comprometida'){
                    this.model.set("etapa_preliminar","Prospecto");
                }
            }
        }
    },

    setRI: function(){
        if(this.model.get("monto_final_comprometido_c") == 1){
            this.model.set("ri_final_comprometida_c", 0);
        }
    },
})