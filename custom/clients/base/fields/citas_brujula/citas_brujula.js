/**
 * Created by Levementum on 9/13/2016.
 * User: jgarcia@levementum.com
 */

({
    events: {
        'click  .remove_btn': 'removerCita',
        'click  #agregar_cita_btn': 'agregarCita',
        'click  .edit_acompanante_link': 'showClienteField',
        'change  .edit_acompanante': 'editarCliente',
        'click  .removerUsuario': 'removerAcompanante',
        'change  #nuevo_objetivo': 'resultadosListPopUp',

        'change  .referenciada_check': 'editarRow',
        'change  .objetivo_list': 'editarRow',
        'change  .estatus_cita': 'editarRow',
        'change  .resultado_list': 'editarRow',

        'change  .duration_minutes': 'editarRow',
        'change  .traslado_edit': 'editarRow',
        'keypress  .duration_minutes': 'isNumberKey',
        'keypress  .traslado_edit': 'isNumberKey',
    },

    initialize: function (options) {

        self = this;
        options = options || {};
        options.def = options.def || {};

        this._super('initialize', [options]);
        this.model.on('change:fecha_reporte', this.getCitas, this);
        this.model.on('change:assigned_user_name', this.getCitas, this);

        this.citas = [];
        this.citas_clientes = [];
        this.popupdisplay = "none";

        var objetivo_list = app.lang.getAppListStrings('objetivo_list');
        var objetivo_keys = app.lang.getAppListKeys('objetivo_list');
        this.objetivo = self.obtenerLista(objetivo_list, objetivo_keys);

        var estatus_list = app.lang.getAppListStrings('estatus_cita');
        var estatus_keys = app.lang.getAppListKeys('estatus_cita');
        this.estatus = self.obtenerLista(estatus_list, estatus_keys);

        var resultado_list = app.lang.getAppListStrings('resultado_list');
        var resultado_keys = app.lang.getAppListKeys('resultado_list');
        this.resultado = self.obtenerLista(resultado_list, resultado_keys);
        this.model.addValidationTask('Revalidafecha', _.bind(this.tercerafecha, this));

        var api_params = {
            'brujula_id': this.model.id,
        };

        var Url = app.api.buildURL("Citas_brujula_detail", '', {}, {});
        app.api.call('create', Url, {data: api_params}, {
            success: function (data) {
                var citasCleaned = [];
                _.each(data, function(key, value) {

                    var referenciada = "";
                    var account_name = "";
                    if(key.referenciada_controller == 0){
                        referenciada = "No";
                    }else{
                        referenciada = "Si";
                    }

                    var cita_existente = {
                        id_existente: key.id,
                        parent_id_existente: key.account_id1_c,
                        parent_name_existente: key.account_name,
                        duration_minutes_existente: key.duracion_cita_controller,
                        traslado_existente: key.duracion_traslado_controller,
                        referenciada_existente: referenciada,
                        acompanante_existente: key.acompanante,
                        acompanante_id_existente: key.user_id1_c,
                        objetivo_existente: key.objetivo_controller,
                        estatus_existente: key.estatus_controller,
                        resultado_existente: key.resultado_controller,
                    };
                    citasCleaned.push(cita_existente);
                });

                self.citas_existentes = citasCleaned;
                self.render();
            }
        });
        /*
            AF. - 2018-10-02
            Ejecuta recuperaci�n de citas
        */
        this.getCitas();
    },

    getCitas: function(){
        if(this.action == "view"){
            return;
        }

        var fecha = this.model.get("fecha_reporte");
        var Params = {
            'promotor': this.model.get("assigned_user_id"),
            'fecha': fecha,
        };
        var Url = app.api.buildURL("Citas_brujula", '', {}, {});
        app.api.call("create", Url, {data: Params}, {
            success: _.bind(function (data) {
                if (self.disposed) {
                    return;
                }

                if(data == "Existente"){
                    app.alert.show('registro Existente', {
                        level: 'error',
                        messages: 'Ya existe un registro para el promotor seleccionado con la fecha ' + fecha,
                        autoClose: true
                    });
                    self.model.set("fecha_reporte", "");
                    return;
                }

                var citasCleaned = [];
                _.each(data, function(key, value) {

                    var acompaniante = "";
                    var estatus = "";
                    var referenciada = "";
                    acompaniante = key.acompanante;

                    if(key.status == "Held"){
                        estatus = "1";
                    }
                    else{
                        estatus = "";
                    }

                    if(key.referenciada_c == 1){
                        referenciada = "checked";
                    }

                    var duration_minutes = +key.duration_minutes;
                    if(key.duration_hours != 0){
                        var duration_hours =  +key.duration_hours * 60;

                        duration_minutes += duration_hours;
                    }

                    var nueva_cita = {
                        id: key.id,
                        parent_id: key.parent_id,
                        parent_name: key.cliente,
                        duration_minutes: duration_minutes,
                        //nuevo_traslado: duration_minutes,
                        nuevo_traslado: 0,
                        nuevo_referenciada: referenciada,
                        nuevo_acompanante: acompaniante,
                        nuevo_acompanante_id: key.user_id_c,
                        nuevo_objetivo: key.objetivo_c,
                        nuevo_estatus: estatus,
                        nuevo_resultado: key.resultado_c,
                    };
                    citasCleaned.push(nueva_cita);
                });

                self.model.set("citas_originales", citasCleaned.length);
                self.citas = citasCleaned;
                self.model.set("citas_brujula",self.citas);
                self.render();
                //$(".estatus_cita").change(); //provocamos un change event en el estatus para que se recalculen los resultados
                $(".objetivo_list").change();
            })
        });

        if(this.model.get("fecha_reporte")=="" ||this.model.get("fecha_reporte")==null){
            /*app.alert.show('citas_sync_alert', {
                level: 'error',
                messages: 'El campo esta vacio.',

            });*/
            return;

        }
    },

    removerCita: function(e){

        var row_id = $(e.target).closest("td").attr("id");
        var citasClone = this.citas;
        var citasCleaned = [];

        var citasRemovidas = [];
        if(!_.isEmpty(this.model.get("citas_brujula_removidas"))){
            citasRemovidas = this.model.get("citas_brujula_removidas");
        }

        this.citas = [];
        _.each(citasClone, function(key, value) {
            if(key['id'] != row_id){
                citasCleaned.push(key);
            }else{
                citasRemovidas.push(key);
            }
        });

        this.citas = citasCleaned;
        this.model.set("citas_brujula",this.citas);
        this.model.set("citas_brujula_removidas",citasRemovidas);
        this.render();
        this.calculaTiempo();
    },

    agregarCita: function(){

        var acompaniante = "";
        var acompanianteId = "";
        var cliente = "";
        var clienteId = "";
        var referenciada = "";

        if(_.isEmpty($("#nuevo_duracion").val())){
            app.alert.show('Duracion requerido', {
                level: 'error',
                messages: 'El campo de duracion es requerido.',
                autoClose: true
            });
            return;
        }else{
		if(parseInt($("#nuevo_duracion").val()) < 0){
			app.alert.show('Valor de duracion incorrecto', {
                	level: 'error',
                	messages: 'El campo de duracion no es valido.',
                	autoClose: true
            	});
            	return;
		}
	}

	if(parseInt($("#nuevo_traslado").val()) < 0){
		app.alert.show('Valor de traslado incorrecto', {
                level: 'error',
                messages: 'El campo de traslado no es valido.',
                autoClose: true
            });
            return;
	}

        if(_.isEmpty($("#hora_cita").val())){
            app.alert.show('hora requerido', {
                level: 'error',
                messages: 'El campo de Hora es requerido.',
                autoClose: true
            });
            return;
        }

        if(_.isEmpty($("#nuevo_objetivo").val())){
            app.alert.show('Objetivo requerido', {
                level: 'error',
                messages: 'El campo de Objetivo es requerido.',
                autoClose: true
            });
            return;
        }

        if(_.isEmpty($("#nuevo_estatus").val())){
            app.alert.show('Estatus requerido', {
                level: 'error',
                messages: 'El campo de Estatus es requerido.',
                autoClose: true
            });
            return;
        }

        if(_.isEmpty($("#nuevo_resultado").val())){
            app.alert.show('Resultado requerido', {
                level: 'error',
                messages: 'El campo de Resultado es requerido.',
                autoClose: true
            });
            return;
        }

        if(_.isEmpty($("#search_clientes").select2('data'))){
            app.alert.show('Cliente requerido', {
                level: 'error',
                messages: 'Seleccione un cliente.',
                autoClose: true
            });
            return;
        }else{
            cliente = $("#search_clientes").select2('data').text;
            clienteId = $("#search_clientes").select2('data').id;
        }

        if(!_.isEmpty($(".nuevo_acompanante").select2('data'))){
            acompaniante = $(".nuevo_acompanante").select2('data').text;
            acompanianteId = $(".nuevo_acompanante").select2('data').id;
        }else{
            acompaniante = "Editar";
        }

        if($("#nuevo_referenciada").prop("checked")){
            referenciada = "checked";
        }

        var cita = this;
        var citasClone = [];
        citasClone = cita.citas;
        cita.citas = [];

        var nueva_cita = {
            id: Date.now(),
            parent_id: clienteId,
            parent_name: cliente,
            duration_minutes: $("#nuevo_duracion").val(),
            nuevo_traslado: $("#nuevo_traslado").val(),
            nuevo_referenciada: referenciada,
            nuevo_acompanante: acompaniante,
            nuevo_acompanante_id: acompanianteId,
            nuevo_objetivo: $("#nuevo_objetivo").val(),
            nuevo_estatus: $("#nuevo_estatus").val(),
            nuevo_resultado: $("#nuevo_resultado").val(),
            hora_cita: $("#hora_cita").val(),
        };

        citasClone.push(nueva_cita);
        cita.citas = citasClone;
        cita.popupdisplay = "none";
        cita.render();
        $(".estatus_cita").change(); //provocamos un change event en el estatus para que se recalculen los resultados
        cita.calculaTiempo();
    },

    showClienteField: function(e){

        //$(e.target).parent().children("div").css("display","inline");
    },

    removerAcompanante: function (e){
        var rowId = $(e.target).closest("tr").attr("id");

        _.each(this.citas, function(key, value) {
            if(key['id'] == rowId){
                key['nuevo_acompanante'] = "Editar";
                key['nuevo_acompanante_id'] = "";
            }
        });
        this.render();
    },

    editarCliente: function(e){
        var rowId = $(e.target).closest("tr").attr("id");
        var acompanante = $(e.target).select2('data').text;
        var acompananteId = $(e.target).select2('data').id;

        _.each(this.citas, function(key, value) {
            if(key['id'] == rowId){
                key['nuevo_acompanante'] = acompanante;
                key['nuevo_acompanante_id'] = acompananteId;
            }
        });

        this.render();
    },

    editarRow: function(e){

        var rowId = $(e.target).closest("tr").attr("id");
        var campo = $(e.target)[0].className;

        if(campo == "objetivo_list"){
            console.log('Cambio Objetivo.');
            this.resultadosList(e);
            $("#resultado" + rowId).change();
        }

        var key_campo = campo.substring(0, campo.indexOf('_'));

        _.each(this.citas, function(key, value) {
            if(key['id'] == rowId){

                if(campo == "referenciada_check"){
                    key['nuevo_' + key_campo] = $(e.target)[0].checked;

                } else if(campo == "duration_minutes"){
                    key[campo] = $(e.target)[0].value;

                } else{
                    key['nuevo_' + key_campo] = $(e.target)[0].value;
                }
            }
        });

        this.model.set("citas_brujula",this.citas);

        if(campo == "estatus_cita" || campo == "duration_minutes" || campo == "traslado_edit"){
            this.calculaTiempo();
        }
    },

    /*
    * Función para aceptar únicamente caracteres numéricos en los campos de Duración y Traslado
    * */
    isNumberKey: function (e) {
        var charCode = (e.which) ? e.which : e.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;

    },

    resultadosList: function(e){

        var rowId = $(e.target).closest("tr").attr("id");
        var rowId_resultado="";

        $("#resultado" + rowId).empty();
        $("#resultado" + rowId).append(self.resultado);

        for(var i=0;i<self.citas.length;i++){
            if(self.citas[i].id==rowId){
                rowId_resultado=self.citas[i].nuevo_resultado;
            }
        }

        $("#resultado" + rowId+ " option[value="+rowId_resultado+"]").prop("selected", "selected");

        
    },

    resultadosListPopUp: function(){
        $("#nuevo_resultado").empty();
        $("#nuevo_resultado").append(self.resultado);

        //Presentaci�n, Expediente, Incremento o Renovaci�n
        if($("#nuevo_objetivo").val()==1 || $("#nuevo_objetivo").val()==2 || $("#nuevo_objetivo").val()==5 || $("#nuevo_objetivo").val()==6 || $("#nuevo_objetivo").val()==9){
            $("#nuevo_resultado option").each(function(){
                if (parseInt($(this).val()) > 7 && !_.isEmpty($(this).val())) {
                    console.log('Elimina valor de resultado list pop-up.');
                    $(this).remove();
                }
            });
        }

        //Visita ocular
        else if ($("#nuevo_objetivo").val()==7){
            $("#nuevo_resultado option").each(function(){
                if (parseInt($(this).val()) != 1 && parseInt($(this).val()) != 9 && parseInt($(this).val()) != 10 && !_.isEmpty($(this).val())) {
                    console.log('Elimina valor de resultado list pop-up.');
                    $(this).remove();
                }
            });
        }

        //Cotejo
        else if ($("#nuevo_objetivo").val()==8){
            $("#nuevo_resultado option").each(function(){
                if (parseInt($(this).val()) != 1 && parseInt($(this).val()) != 11 && parseInt($(this).val()) != 12 && !_.isEmpty($(this).val())) {
                    console.log('Elimina valor de resultado list pop-up.');
                    $(this).remove();
                }
            });
        }

        //Contrato
        else if ($("#nuevo_objetivo").val()==10){
            $("#nuevo_resultado option").each(function(){
                if (parseInt($(this).val()) != 1 && parseInt($(this).val()) != 15 && parseInt($(this).val()) != 13 && !_.isEmpty($(this).val())) {
                    console.log('Elimina valor de resultado list pop-up.');
                    $(this).remove();
                }
            });
        }

        //Cobranza
        else if ($("#nuevo_objetivo").val()==4){
            $("#nuevo_resultado option").each(function(){
                if (parseInt($(this).val()) != 1 && parseInt($(this).val()) != 14 && parseInt($(this).val()) != 16 && !_.isEmpty($(this).val())) {
                    console.log('Elimina valor de resultado list pop-up.');
                    $(this).remove();
                }
            });
        }

        //Otro
        else if ($("#nuevo_objetivo").val()==9){
            $("#nuevo_resultado option").each(function(){
                if (parseInt($(this).val()) >= 1 && !_.isEmpty($(this).val())) {
                    console.log('Elimina valor de resultado list pop-up.');
                    $(this).remove();
                }
            });
        }
    },

    obtenerLista: function(lista, keys){
        var list_html = '';
        for (keys in lista) {
            list_html += '<option value="' + keys + '">' + lista[keys] + '</option>'
        }
        return list_html;
    },

    calculaTiempo: function(){

        var total = 0;
        var citas_brujula = this.model.get("citas_brujula");
        var contactos_duracion = this.model.get("contactos_duracion");

        if(contactos_duracion > 0){
            total = +contactos_duracion;
        }

        _.each(citas_brujula, function(key, value) {

            if(key["nuevo_estatus"] == "1") {
                var minutos = +key["duration_minutes"] + +key["nuevo_traslado"];
                if (minutos > 0) {
                    total += minutos;
                }
            }
        });

        total = total / 60;
        this.model.set("tiempo_prospeccion", total);
    },

    bindDataChange: function () {
        this.model.on('change:' + this.name, function () {
            if (this.action !== 'edit') {
                this.render();
            }
        }, this);
    },

    bindDomChange: function () {
        if (this.tplName === 'list-edit') {
            this._super("bindDomChange");
        }
    },
    tercerafecha:function(fields, errors, callback) {
    if(this.model.get("fecha_reporte")=="" ||this.model.get("fecha_reporte")==null) {

        errors['fecha_reporte'] = errors['fecha_reporte'] || {};
        errors['fecha_reporte'].required = true;

    }
        callback(null, fields, errors);
    },

})
