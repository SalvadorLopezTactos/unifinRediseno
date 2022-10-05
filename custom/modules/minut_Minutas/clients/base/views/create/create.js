({
    extendsFrom: 'CreateView',

    latitude :0,
    longitude:0,
    urlEncuesta: null,
    flagPuesto:false,
    parent_type:"",
    parent_type_true:true,
    tipo_lead:false,
    tipo_account:false,
    puesto_usuario:"",
    leasingPuestos: null,

    initialize: function (options) {
        //this.plugins = _.union(this.plugins || [], ['AddAsInvitee', 'ReminderTimeDefaults']);
        self = this;
        this._super("initialize", [options]);

        this.padre();
        this.Lead_Account_options();

        this.model.addValidationTask('checkcompromisos', _.bind(this.checkcompromisos, this));
        this.model.addValidationTask('validaFecha', _.bind(this.validaFechaReunion, this));
        //this.model.addValidationTask('validaEncuesta', _.bind(this.validaEncuesta, this));
        this.model.addValidationTask('save_Asistencia_Parti', _.bind(this.saveAsistencia, this));
        this.model.addValidationTask('save_Referencias', _.bind(this.saveReferencias, this));
        //this.model.addValidationTask('validaObjetivosmarcados', _.bind(this.validaObjetivosmarcados,this));
        this.model.addValidationTask('save_Reuunion_Llamada',_.bind(this.saveReuionLlamada, this));
        this.model.addValidationTask('valida_requeridos',_.bind(this.valida_requeridos, this));
        //Mantener como último VT a savestatusandlocation
        this.model.addValidationTask('save_meetings_status_and_location', _.bind(this.savestatusandlocation, this));
        this.context.on('button:view_document:click', this.view_document, this);
        //Evento para contestar encuesta
        //this.context.on('button:survey_minuta:click', this.open_survey_minuta, this);

        //this.model.on("change:resultado_c", this.changeColorSurveyButton, this);


        this.puesto_usuario=App.user.attributes.puestousuario_c;
        this.leasingPuestos = ['1','2','3','4','5','6','20','33','44','55','27'];

        this.sin_accion = ['9','10','11','12','13','14','15','16','17','22','24'];

        var idUser = this.context.parent.attributes.model.attributes.created_by;
        var url = app.api.buildURL("Users/"+idUser, '', {}, {});

        app.api.call("read", url, null, {
            success: _.bind(function (data) {

              /*
              Condiciones
                puesto
                  27- Agente teléfonico
                  31 - Coordinador CP
                Usuario OmarVenegas: eeae5860-bb05-4ae5-3579-56ddd8a85c31
              */
                if (data.puestousuario_c == '27' || data.puestousuario_c == '31' || data.id == 'eeae5860-bb05-4ae5-3579-56ddd8a85c31') {

                    this.flagPuesto=true;
                }
            }, this)
        });
    },

    _render: function(){
        this._super("_render");
        //Quita etiquetas de campos custom
        $('[data-name=minuta_participantes]').find('.record-label').addClass('hide');
        $('[data-name=minuta_objetivos]').find('.record-label').addClass('hide');
        $('[data-name=minuta_compromisos]').find('.record-label').addClass('hide');
        $('[data-name=minuta_division]').find('.record-label').addClass('hide');

        //Oculta panel con campos de checkin en minuta
        $('[data-panelname="LBL_RECORDVIEW_PANEL4"]').addClass('hide');

        //Bloquea campo de ReuniÃ³n relacionada
        if(this.model.get('minut_minutas_meetingsmeetings_idb')!=undefined){

            $('[data-name="minut_minutas_meetings_name"]').attr('style','pointer-events:none');

        }
        this.$('.record-panel[data-panelname="LBL_RECORDVIEW_PANEL1"]').children().eq(0).removeClass('panel-inactive');
        this.$('.record-panel[data-panelname="LBL_RECORDVIEW_PANEL1"]').children().eq(0).addClass('panel-active');
        this.$('.record-panel[data-panelname="LBL_RECORDVIEW_PANEL1"]').children().eq(1).attr("style","display:block");

        //Oculta panel con campos de lead
        $('[data-panelname="LBL_RECORDVIEW_PANEL7"]').addClass('hide');
        $('[data-panelname="LBL_RECORDVIEW_PANEL8"]').addClass('hide');
    },

    /* F. Javier G. Solar 9-10-2018
     * Valida asistencia de almenos un participante tipo Cuenta
     */
    saveAsistencia: function (fields, errors, callback) {
        var objParticipantes = selfData.mParticipantes["participantes"];
        banderaAsistencia = 0;
        banderaCorreo = 0;
        for (var i = 0; i < objParticipantes.length; i++) {
            if (objParticipantes[i].asistencia == 1 && objParticipantes[i].unifin != 1) {
                banderaAsistencia++;
            }
            if (!objParticipantes[i].correo && objParticipantes[i].asistencia ==1 && objParticipantes[i].unifin != 1) {
                banderaCorreo++;
            }
        }
        // Valida Asistencias
        if (this.model.get('resultado_c') != '24' || this.model.get('resultado_c') != '25') {
            if (banderaAsistencia < 1) {
                app.alert.show("Asistencia", {
                    level: "error",
                    messages: "Debes marcar <b>asistencia</b> por lo menos a un <b>Participante</b> tipo Cuenta.",
                    autoClose: false,
                    return: false,
                });
                errors['xd'] = errors['xd'] || {};
                errors['xd'].required = true;
            }
        }
        // Valida Correos
        if (banderaCorreo > 0 && banderaAsistencia >= 1) {
            app.alert.show("Correo", {
                level: "error",
                messages: "Todos los <b>Participantes</b> tipo Cuenta marcados con asistencia deben contar con <b>correo</b>.",
                autoClose: false,
                return: false,
            });
            errors['correo'] = errors['correo'] || {};
            errors['correo'].required = true;
        }
        callback(null, fields, errors);
    },

    validaObjetivosmarcados:function(fields,errors,callback){
        var objetivoesp=self.myobjmin;
        var check=false;
        for( i=0 ; i<objetivoesp.records.length; i++){
            if(objetivoesp.records[i].cumplimiento==1 && objetivoesp.records[i].description=="1"){
                check=true;
            }
        }
        if(check==false){
            app.alert.show("Objetivo especifico requerido", {
                level: "error",
                title: "Al menos un un objetivo espec\u00EDfico debe estar marcado",
                autoClose: false
            });
            errors['objetivoespecificos'] = "Al menos un un objetivo espec\u00EDfico debe estar marcado";
        }
        callback(null, fields, errors);
    },

    /*Actualiza el estado de la reunion además de guardar fecha y lugar de Check-Out
    *Victor Martínez 23-10-2018
    */
    savestatusandlocation:function(fields, errors, callback){
        var userprod = (app.user.attributes.productos_c).replace(/\^/g, "");
        var userprodprin = App.user.attributes.tipodeproducto_c;
        var keyselect = null;
		    var idProdM='';
        var idCuenta = this.model.get('parent_id');
        var userprod = (app.user.attributes.productos_c).replace(/\^/g, "");
        var userprodprin = App.user.attributes.tipodeproducto_c;
        smeet = this;

        var puesto_usuario=App.user.attributes.puestousuario_c;
        var leasingPuestos = ['1','2','3','4','5','6','20','33','44','55'];

        if (Object.keys(errors).length == 0) {
          try {
            self=this;
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(this.showPosition);
            }else {
                alert("No se pudo encontrar tu ubicacion");
            }

            var today= new Date();
            //self.model.set('check_in_time_c', today);
            var moduleid = app.data.createBean('Meetings',{id:this.model.get('minut_minutas_meetingsmeetings_idb')});
            moduleid.fetch({
                success:_.bind(function(modelo){
                    this.estado = modelo.get('status');
                    this.checkoutad=modelo.get('check_out_address_c');
                    this.checkoutime=modelo.get('check_out_time_c');
                    this.checkoutlat=modelo.get('check_out_latitude_c');
                    this.checkoutlong=modelo.get('check_out_longitude_c');
                    this.checkoutplat=modelo.get('check_out_platform_c');
                    this.resultado=modelo.get('resultado_c');
                    modelo.set('status', 'Held');
                    modelo.set('check_out_address_c');
                    modelo.set('check_out_time_c', today);
                    modelo.set('check_out_latitude_c',self.latitude);
                    modelo.set('check_out_longitude_c',self.longitude);
                    modelo.set('check_out_platform_c', self.GetPlatform());
                    modelo.set('resultado_c', self.model.get('resultado_c'));

                    var parent_meet = modelo.get('parent_type');
                    var parent_id_acc = modelo.get('parent_id');
                    /*if(parent_meet == "Accounts"  &&  this.leasingPuestos.includes(  this.puesto_usuario ) && !(this.sin_accion.includes( self.model.get('resultado_c'))) ){
                    var account = app.data.createBean('Accounts', {id:parent_id_acc});
			              account.fetch({
			              success: _.bind(function (modelAcconut) {
                            if(modelAcconut.attributes.tipo_registro_cuenta_c == '2' && (modelAcconut.attributes.subtipo_registro_cuenta_c == '1' || modelAcconut.attributes.subtipo_registro_cuenta_c == '2')) {
                                if(this.$('#cancelado')[0].checked != true &&  this.$('#presolicitud')[0].checked != true){
                                    app.alert.show("Motivo de Cancelación", {
                                        level: "error",
                                        title: "Debe seleccionar alguna opción de Lead Management para continuar.",
                                        autoClose: false
                                    });
                                    //$('[data-panelname="LBL_RECORDVIEW_PANEL7"]').children().eq(1).removeAttr("style");
                                    $('#opciones').css('color', '#bb0e1b');
                                    $('#opciones').css('border-style', 'solid');
                                    $('#opciones').css('border-color', '#bb0e1b');

                                    errors['MotivoCancelacion'] = errors['MotivoCancelacion'] || {};
                                    errors['MotivoCancelacion'].required = true;
                                    $('[data-panelname="LBL_RECORDVIEW_PANEL7"]').removeClass('hide');
                                    callback(null, fields, errors);
                                }else{
                                    if(this.$('#presolicitud')[0].checked == true){
                                        //modelo.save();
                                        modelo.save([],{
                                            dataType:"text",
                                            complete:function() {
                                                //app.router.navigate(module_name , {trigger: true});
                                                $('a[name=new_minuta]').hide()
                                                SUGAR.App.controller.context.reloadData({});
                                                $('[data-name="minut_minutas_meetings_name"]').removeAttr("style");
                                                $('[data-name="assigned_user_name"]').removeAttr("style");
                                            }
                                        });
                                        callback(null, fields, errors);

                                        var urla = window.location.href;
                                        urla = urla.substring(0,urla.indexOf('#'))
                                        app.alert.show("Creación Solicitud", {
                                            level: "info",
                                            title: "Se redirigió a la vista de creación de solicitudes.<br> Cuenta con lo que resta del día en curso para registrar una pre solicitud",
                                            autoClose: false
                                        });

                                        app.api.call("read", app.api.buildURL("Accounts/"+parent_id_acc, null, null, {
                                            fields: "name",
                                        }), null, {
                                            success: _.bind(function (data) {
                                                var objOpp = {
                                                    action: 'edit',
                                                    copy: true,
                                                    create: true,
                                                    layout: 'create',
                                                    module: 'Opportunities',
                                                    idAccount: parent_id_acc,
                                                    idNameAccount: data.name
                                                };
                                                app.controller.loadView(objOpp);
                                                // update the browser URL with the proper
                                                app.router.navigate('#Opportunities/create', {trigger: false});
                                            }, this)
                                        });
                                    }else if(this.$('#cancelado')[0].checked == true){
                                        keyselect = this.$('#RazonNoViable').val();
                                        if(keyselect == "0" || keyselect == "" || keyselect == null){
                                            app.alert.show("Motivo de Cancelación", {
                                            level: "error",
                                            title: "Debe seleccionar Razón No Viable para Lead Management.",
                                            autoClose: false
                                            });
                                            $('#opciones').css('color', 'black');
                                            $('#opciones').css('border-style', 'none');
                                            //$('[data-panelname="LBL_RECORDVIEW_PANEL7"]').children().eq(1).removeAttr("style");
                                            $('#RazonNoViable').css('border-color', '#bb0e1b');
                                            $('#razon_noviable').css('color', '#bb0e1b');
                                            errors['razon_noviable'] = errors['razon_noviable'] || {};
                                            errors['razon_noviable'].required = true;
                                            callback(null, fields, errors);
                                        }else if(keyselect != "" && keyselect != null && keyselect != "0"){
                                            var emptynoviable = 0;
                                            $('#razon_noviable').css('color', 'black');
                                            $('#RazonNoViable').css('border-color', '');
                                            //Se obtiene los valores de los campos seleccionados en el modal
                                            if ($("#RazonNoViable").val() == "" || $("#RazonNoViable").val() == "0") {
                                                $('#RazonNoViable').css('border-color', 'red');
                                                emptynoviable += 1;
                                            }
                                            if ($("#RazonNoViable").val() == "1" && ($("#FueradePerfil").val() == "" || $("#FueradePerfil").val() == "0")) {
                                                $('#FueradePerfil').css('border-color', 'red');
                                                emptynoviable += 1;
                                            }
                                            if ($("#RazonNoViable").val() == "2" && ($("#condFinancieras").val() == "" || $("#condFinancieras").val() == "0")) {
                                                 $('#condFinancieras').css('border-color', 'red');
                                                 emptynoviable += 1;
                                            }
                                            if ($("#RazonNoViable").val() == "3" && $('#comp_quien').val().trim() == "" && $('#comp_porque').val().trim() == "") {
                                                $('#comp_quien').css('border-color', 'red');
                                                $('#comp_porque').css('border-color', 'red');
                                                emptynoviable += 1;
                                            }
                                            if ($("#RazonNoViable").val() == "3" && $('#comp_quien').val().trim() == "" && $('#comp_porque').val().trim() != "") {
                                                $('#comp_quien').css('border-color', 'red');
                                                emptynoviable += 1;
                                            }
                                            if ($("#RazonNoViable").val() == "3" && $('#comp_porque').val().trim() == "" && $('#comp_quien').val().trim() != "") {
                                                $('#comp_porque').css('border-color', 'red');
                                                emptynoviable += 1;
                                            }
                                            if ($("#RazonNoViable").val() == "4" && ($("#noProducto").val() == "" || $("#noProducto").val() == "0")) {
                                                $('#noProducto').css('border-color', 'red');
                                                emptynoviable += 1;
                                            }
                                            if ($("#RazonNoViable").val() == "4" && $("#noProducto").val() == "4" && $("#otroProducto").val() == "") {
                                                $('#otroProducto').css('border-color', 'red');
                                                emptynoviable += 1;
                                            }
                                            if ($("#RazonNoViable").val() == "7" && ($("#noInteresado").val() == "" || $("#noInteresado").val() == "0")) {
                                                $('#noInteresado').css('border-color', 'red');
                                                emptynoviable += 1;
                                            }

                                            if (emptynoviable > 0) {
                                                app.alert.show("Falta-campos-no-viable", {
                                                    level: "error",
                                                    title: 'Debe seleccionar los campos faltantes para cancelación',
                                                    autoClose: false
                                                });
                                                errors['MotivoCancelacion'] = errors['MotivoCancelacion'] || {};
                                                errors['MotivoCancelacion'].required = true;
                                                callback(null, fields, errors);
                                            }else{

                                                //Valor de la lista de Razon no viable
	                                             if ($("#RazonNoViable").val() != "" || $("#RazonNoViable").val() != "0") {
	                                                 var KeyRazonNV = $("#RazonNoViable").val();
	                                             }
	                                             //Se obtiene los valores de los campos seleccionados en el modal
	                                             if ($("#FueradePerfil").val() != "" || $("#FueradePerfil").val() != "0") {
	                                                 var keyfueradePerfil = $("#FueradePerfil").val();
	                                             }
	                                             if ($("#condFinancieras").val() != "" || $("#condFinancieras").val() != "0") {
	                                                  var keycondFinancieras = $("#condFinancieras").val();
	                                             }
	                                             if ($("#comp_quien").val() != "") {
	                                                 var txtcomp_quien = $("#comp_quien").val();
	                                             }
	                                             if ($("#comp_porque").val() != "") {
	                                                 var txtcomp_porque = $("#comp_porque").val();
	                                             }
	                                             if ($("#noProducto").val() != "" || $("#noProducto").val() != "0") {
	                                                 var keynoProducto = $("#noProducto").val();
	                                             }
	                                             if ($("#otroProducto").val() != "") {
	                                                 var txtotroProducto = $("#otroProducto").val();
	                                             }
	                                             if ($("#noInteresado").val() != "" || $("#noInteresado").val() != "0") {
	                                                 var keynoInteresado = $("#noInteresado").val();
	                                             }
		                                        keyselect = this.$('#RazonNoViable').val();
                                                app.api.call('GET', app.api.buildURL('GetProductosCuentas/' + parent_id_acc), null, {
                                                    success: function (data) {
                                                        Productos = data;
                                                        ResumenProductos = [];
                                                        _.each(Productos, function (value, key) {
                                                            var tipoProducto = Productos[key].tipo_producto;
                                                            if(tipoProducto == userprodprin){
                                                                idProdM = Productos[key].id;
                                                                var producto = app.data.createBean('uni_Productos', {id:idProdM});
                                                                producto.fetch({
                                                                    success: _.bind(function (model) {
                                                                        model.set('no_viable', true); //CHECK NO VIABLE
                                                                        model.set('status_management_c', '3'); //ESTATUS PRODUCTO CANCELADO
                                                                        model.set('no_viable_razon', KeyRazonNV); //RAZON NO VIABLE
                                                                        model.set('no_viable_razon_fp', keyfueradePerfil); //FUERA DE PERFIL
                                                                        model.set('no_viable_razon_cf', keycondFinancieras); //CONDICIONES FINANCIERAS
                                                                        model.set('no_viable_quien', txtcomp_quien); //YA ESTA CON LA COMPETENCIA - ¿QUIEN? TEXTO
                                                                        model.set('no_viable_porque', txtcomp_porque); //YA ESTA CON LA COMPETENCIA -¿POR QUE? TEXTO
                                                                        model.set('no_viable_producto', keynoProducto); //NO TENEMOS EL PRODUCTO - ¿QUE PRODUCTO?
                                                                        model.set('no_viable_otro_c', txtotroProducto); //NO TENEMOS EL PRODUCTO - ¿QUE PRODUCTO? TEXTO
                                                                        model.set('no_viable_razon_ni', keynoInteresado); //NO SE ENCUENTRA INTERESADO
                                                                        model.save();

                                                                        app.alert.show('message-id', {
                                                                            level: 'success',
                                                                            messages: 'Cuenta Cancelada',
                                                                            autoClose: true
                                                                        });

                                                                    }, this)
                                                                });
                                                                                         //modelo.save();
                                                                modelo.save([],{
                                                                    dataType:"text",
                                                                    complete:function() {
                                                                        //app.router.navigate(module_name , {trigger: true});
                                                                        $('a[name=new_minuta]').hide()
                                                                        SUGAR.App.controller.context.reloadData({});
                                                                        $('[data-name="minut_minutas_meetings_name"]').removeAttr("style");
                                                                        $('[data-name="assigned_user_name"]').removeAttr("style");
                                                                    }
                                                                });
                                                                callback(null, fields, errors);
                                                            }
                                                        });
                                                    },
                                                    error: function (e) {
                                                        throw e;
                                                    }
                                                });

                                            }
                                        }
                                    }

                                }
                            }else{
                                modelo.save();
                                callback(null, fields, errors);
                            }
                          }, this)
                        });
                    }else if(parent_meet == "Leads"  &&  this.leasingPuestos.includes(  this.puesto_usuario ) ){
                        var keyselect = null;
                        keyselect = this.$('#motivocancelacionCuenta').val();
                        var subkeysqlct = this.$('#submotivocancelacion').val();
                        if((keyselect == "" || keyselect == null) &&
                        (self.model.get('resultado_c')=='2' ||self.model.get('resultado_c')=='18' || self.model.get('resultado_c')=='21' || self.model.get('resultado_c')=='25'))
                        {
                            app.alert.show("Motivo de Cancelación", {
                                level: "error",
                                title: "Debe seleccionar el motivo cancelación para Lead Management.",
                                autoClose: false
                            });
                            $('#motivocancelacionCuenta').css('border-color', '#bb0e1b');
                            $('#motivo_cancelacion_Cuenta').css('color', '#bb0e1b');
                            $('#MotivoCancelacionLead').focus();
                            $('[data-panelname="LBL_RECORDVIEW_PANEL8"]').children().eq(1).removeAttr("style");
                            errors['motivocancelacionCuenta'] = errors['motivocancelacionCuenta'] || {};
                            errors['motivocancelacionCuenta'].required = true;
                            callback(null, fields, errors);
                        }else if((keyselect == "2" || keyselect == "5" ) && (subkeysqlct == '' || subkeysqlct == null) &&
                        (self.model.get('resultado_c')=='2' ||self.model.get('resultado_c')=='18' || self.model.get('resultado_c')=='21' || self.model.get('resultado_c')=='25'))
                        {
                            app.alert.show("Submotivo de Cancelación", {
                                level: "error",
                                title: "Debe seleccionar el submotivo cancelación para Lead Management.",
                                autoClose: false
                            });
                            $('#motivocancelacionCuenta').css('border-color', '');
                            $('#motivo_cancelacion_Cuenta').css('color', 'black');
                            $('#submotivocancelacion').css('border-color', '#bb0e1b');
                            $('#submotivo_cancelacion').css('border-color', '#bb0e1b');
                            $('#submotivo_cancelacion').css('color', '#bb0e1b');
                            $('[data-panelname="LBL_RECORDVIEW_PANEL8"]').children().eq(1).removeAttr("style");
                            errors['submotivocancelacion'] = errors['submotivocancelacion'] || {};
                            errors['submotivocancelacion'].required = true;
                            callback(null, fields, errors);
                        }else{
                            var lead = app.data.createBean('Leads', {id:parent_id_acc});
			                lead.fetch({
			                success: _.bind(function (modelLead) {
                                if(modelLead.get('subtipo_registro_c')=='1' || modelLead.get('subtipo_registro_c')=='2'){
                                    if(self.model.get('resultado_c')=='2' ||self.model.get('resultado_c')=='18' || self.model.get('resultado_c')=='21' || self.model.get('resultado_c')=='25'){
                                        //NO esta interesado
                                        //No viable
                                        //No interezado, cita forzada
                                        //Cancelada por el prospecto, no le interesa
                                        modelLead.set('motivo_cancelacion_c',this.$('#motivocancelacionCuenta').val());
                                        modelLead.set('submotivo_cancelacion_c',this.$('#submotivocancelacion').val());
                                        modelLead.set('subtipo_registro_c', "3");
                                        modelLead.set('lead_cancelado_c', true);
                                        modelLead.save();
                                        app.alert.show('message-id', {
                                            level: 'success',
                                            messages: 'Lead Cancelado',
                                            autoClose: true
                                        });
                                        modelo.save();
                                        callback(null, fields, errors);
                                        //modelo.save([],{
                                        //    dataType:"text",
                                        //    complete:function() {
                                        //        //app.router.navigate(module_name , {trigger: true});
                                        //        $('a[name=new_minuta]').hide()
                                        //        SUGAR.App.controller.context.reloadData({});
                                        //        $('[data-name="minut_minutas_meetings_name"]').removeAttr("style");
                                        //        $('[data-name="assigned_user_name"]').removeAttr("style");
                                        //    }
                                        //});
                                    }else if(self.model.get('resultado_c')=='4' ||self.model.get('resultado_c')=='5' || self.model.get('resultado_c')=='19' || self.model.get('resultado_c')=='20'
                                    || self.model.get('resultado_c')=='6' || self.model.get('resultado_c')=='7' || self.model.get('resultado_c')=='23'){
                                        // Está Interesado. Se procede a generar expediente
                                        // Está Interesado. Se agendó otra visita
                                        // Está interesado. Se agendó otra llamada
                                        // Está Interesado. Se recogió información
                                        // Se cerró una venta
                                        // Se procede a generar expediente
                                        // Está interesado solicita cotización para proceder
                                        var filter_arguments = {
                                            "id": parent_id_acc
                                        };
/*                                        app.api.call("create", app.api.buildURL("existsLeadAccounts", null, null, filter_arguments), null, {
                                            success: _.bind(function (data) {
                                                console.log(data);
                                                //app.alert.dismiss('upload');
                                                //app.controller.context.reloadData({});
                                                if (data.idCuenta === "") {
                                                    app.alert.show("Conversión", {
                                                        level: "error",
                                                        messages: data.mensaje,
                                                        autoClose: false
                                                    });
                                                    errors['conversion'] = errors['conversion'] || {};
                                                    errors['conversion'].required = true;
                                                    callback(null, fields, errors);
                                                } else {
                                                    app.alert.show("Conversión", {
                                                        level: "success",
                                                        messages: data.mensaje,
                                                        autoClose: false
                                                    });
                                                    modelLead.set('subtipo_registro_c', "4");
                                                    modelLead.set('account_id',data.idCuenta);
                                                    modelLead.save();
                                                    //this._disableActionsSubpanel();
                                                    //modelo.save();
                                                    modelo.save([],{
                                                        dataType:"text",
                                                        complete:function() {
                                                            //app.router.navigate(module_name , {trigger: true});
                                                            $('a[name=new_minuta]').hide()
                                                            SUGAR.App.controller.context.reloadData({});
                                                            $('[data-name="minut_minutas_meetings_name"]').removeAttr("style");
                                                            $('[data-name="assigned_user_name"]').removeAttr("style");
                                                        }
                                                    });
                                                    callback(null, fields, errors);
                                                }
                                                //callback(null, fields, errors);
                                            }, this),
                                            failure: _.bind(function (data) {
                                                app.alert.dismiss('upload');
                                                errors['status'] = errors['status'] || {};
                                                errors['status'].required = true;
                                                callback(null, fields, errors);
                                            }, this),
                                            error: _.bind(function (data) {
                                                errors['status'] = errors['status'] || {};
                                                errors['status'].required = true;
                                                app.alert.dismiss('upload');
                                                callback(null, fields, errors);
                                            }, this),
                                        }); //
										modelo.save([],{
                                            dataType:"text",
                                            complete:function() {
                                                //app.router.navigate(module_name , {trigger: true});
                                                $('a[name=new_minuta]').hide()
                                                SUGAR.App.controller.context.reloadData({});
                                                $('[data-name="minut_minutas_meetings_name"]').removeAttr("style");
                                                $('[data-name="assigned_user_name"]').removeAttr("style");
                                            }
                                        });
                                        callback(null, fields, errors);
                                    }else if(self.model.get('resultado_c')=='3'){
                                        modelLead.set('subtipo_registro_c', "2");
                                        modelLead.set('status_management_c', "2");
                                        modelLead.save();
                                        modelo.save();
                                        callback(null, fields, errors);
                                        //modelo.save([],{
                                        //dataType:"text",
                                        //complete:function() {
                                        //        //app.router.navigate(module_name , {trigger: true});
                                        //        $('a[name=new_minuta]').hide()
                                        //        SUGAR.App.controller.context.reloadData({});
                                        //        $('[data-name="minut_minutas_meetings_name"]').removeAttr("style");
                                        //        $('[data-name="assigned_user_name"]').removeAttr("style");
                                        //    }
                                        //});
                                    }else{
                                        modelLead.set('subtipo_registro_c', "2");
                                        modelLead.save();
                                        modelo.save();
                                        callback(null, fields, errors);
                                        //    dataType:"text",
                                        //    complete:function() {
                                        //            //app.router.navigate(module_name , {trigger: true});
                                        //            $('a[name=new_minuta]').hide()
                                        //            SUGAR.App.controller.context.reloadData({});
                                        //            $('[data-name="minut_minutas_meetings_name"]').removeAttr("style");
                                        //            $('[data-name="assigned_user_name"]').removeAttr("style");
                                        //        }
                                        //    });
                                    }
                                    //callback(null, fields, errors);
                                }else{
                                    callback(null, fields, errors);
                                }
                                //callback(null, fields, errors);
                            }, this)
                            });
                        }
                    }else{*/

                        modelo.save([],{
                        dataType:"text",
                        complete:function() {
                                //app.router.navigate(module_name , {trigger: true});
                                $('a[name=new_minuta]').hide()
                                SUGAR.App.controller.context.reloadData({});
                                $('[data-name="minut_minutas_meetings_name"]').removeAttr("style");
                                $('[data-name="assigned_user_name"]').removeAttr("style");
                            }
                        });
                        callback(null, fields, errors);
                    //}
                    //callback(null, fields, errors);
                }, this)
            });
          } catch (e) {
              console.log("Error: al recuperar ubicación para unifin proceso")
          }
      }else{
         callback(null,fields,errors);
      }

    },

    showPosition:function(position) {
        self.longitude=position.coords.longitude;
        self.latitude=position.coords.latitude;
    },

    //Obienete la plataforma del usuario en la cual haya hecho check-in
    GetPlatform: function(){
        var plataforma=navigator.platform;
        if(plataforma!='iPad'){
            return 'Pc';
        }else{
            return 'iPad';
        }
    },

    checkcompromisos:function(fields, errors, callback){
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10) {
            dd = '0'+dd
        }
        if(mm<10) {
            mm = '0'+mm
        }
        today = yyyy+'-'+mm+'-'+dd;

        $('.existingcompromiso').each(function(index,item){
            if($(item).val().trim()!=''){
                $('.existingcompromiso').eq(index).css('border-color', '');
            }else{
                $('.existingcompromiso').eq(index).css('border-color', 'red');
                app.alert.show("empty_compromiso", {
                    level: "error",
                    title: "Existen compromisos <b>sin nombre</b>, favor de verificar",
                    autoClose: false
                });
                errors['comp_comp'] = errors['comp_comp'] || {};
                errors['comp_comp'].required = true;
            }
        });
        $('.existingdate').each(function(index,item){
            if($(item).val().trim()!=''){
                if($(item).val().trim()<today){
                    $('.existingdate').eq(index).css('border-color', 'red');
                    app.alert.show("datecomp_invalid", {
                        level: "error",
                        title: "La fechas de los compromisos deben ser mayor al d\u00EDa de hoy",
                        autoClose: false
                    });
                    errors['comp_date'] = errors['comp_date'] || {};
                    errors['comp_date'].required = true;
                }else {
                    $('.existingdate').eq(index).css('border-color', '');
                }
            }else{
                $('.existingdate').eq(index).css('border-color', 'red');
                app.alert.show("empty_date", {
                    level: "error",
                    title: "Existen compromisos <b>sin fecha</b>, favor de verificar",
                    autoClose: false
                });
                errors['comp_date'] = errors['comp_date'] || {};
                errors['comp_date'].required = true;
            }
        });
        $('.existingresponsable').each(function(index,item){
            if($(item).text().trim()!=''){
                $('.existingresponsable').eq(index).css('border-color', '');
            }else{
                $('.existingresponsable').eq(index).css('border-color', 'red');
                app.alert.show("empty_resp", {
                    level: "error",
                    title: "Existen compromisos <b>sin responsable</b>, favor de verificar",
                    autoClose: false
                });
                errors['comp_resp'] = errors['comp_resp'] || {};
                errors['comp_resp'].required = true;
            }
        });
        callback(null,fields,errors);
    },

    validaFechaReunion: function(fields, errors, callback){

        //Validar fecha de reunión únicamente cuando el campo sea visible
        if (!$('[data-fieldname="fecha_y_hora_c"]').children().eq(0).hasClass("vis_action_hidden")) {

            var startDate = new Date(this.model.get('fecha_y_hora_c'));
            var startMonth = startDate.getMonth() + 1;
            var startDay = startDate.getDate();
            var startYear = startDate.getFullYear();
            var startDateText = startMonth + "/" + startDay + "/" + startYear;
            // FECHA ACTUAL
            var dateActual = new Date();
            var d1 = dateActual.getDate();
            var m1 = dateActual.getMonth() + 1;
            var y1 = dateActual.getFullYear();
            var dateActualFormat = [m1, d1, y1].join('/');

            var fechaActual = Date.parse(dateActualFormat);
            var startToDate = Date.parse(startDateText);
            if(startToDate < fechaActual)
            {
                app.alert.show("invalid_date_reunion", {
                    level: "error",
                    title: "No se puede agendar reuni\u00F3n para una fecha anterior a la actual",
                    autoClose: false
                });
                errors['fecha_y_hora_c'] = "No se puede agendar reuni\u00F3n para una fecha anterior a la actual";
                errors['fecha_y_hora_c'].required = true;
            }

        }

        callback(null, fields, errors);
    },

    /*
    * Validacón para evitar guardar una minuta si no se ha contestado Encuesta
    */
    validaEncuesta:function(fields, errors, callback){
        if (this.flagPuesto && this.model.get('resultado_c') != "22" && this.model.get('resultado_c') != "24" && this.model.get('resultado_c') != "25") {
            var id_meeting=this.model.get('minut_minutas_meetingsmeetings_idb');
            if(id_meeting!= undefined && !window.encuesta){
                app.alert.show("survey_required", {
                    level: "error",
                    messages: "Para guardar la minuta es necesario contestar la <b>Encuesta de Calidad</b>",
                    autoClose: false
                });
                errors['encuesta'] = errors['encuesta'] || {};
                errors['encuesta'].required = true;
			}
            callback(null, fields, errors);
        }else{
            callback(null, fields, errors);
        }
    },

    view_document: function(){
		var pdf = window.location.origin+window.location.pathname+"/custom/pdf/proceso_unifin.pdf";
		window.open(pdf,'_blank');
		self.model.set('tct_proceso_unifin_time_c',this.model.get('tct_today_c'));
		self.model.set('tct_proceso_unifin_platfom_c', this.GetPlatform());
        navigator.geolocation.getCurrentPosition(function(position) {
          var lat = position.coords.latitude;
          var lng = position.coords.longitude;
		  var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lng+"&key=1234";
          /*$.getJSON(url, function(data) {
          	var address = data.results[0]['formatted_address'];
			      self.model.set('tct_proceso_unifin_address_c',address);
          });*/
		  self.model.set('tct_proceso_unifin_address_c',lat+lng);
		});
    },

    valida_requeridos: function(fields, errors, callback) {
        var campos = "";
        _.each(errors, function(value, key) {
            _.each(this.model.fields, function(field) {
                if(_.isEqual(field.name,key)) {
                    if(field.vname) {
                        campos = campos + '<b>' + app.lang.get(field.vname, "minut_Minutas") + '</b><br>';
                    }
          		  }
       	    }, this);
        }, this);
        if(campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                messages: "Hace falta completar la siguiente información en la <b>Minuta:</b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },

    saveReferencias: function (fields, errors, callback) {
        var objReferencias = selfRef.mReferencias["referencias"];
        banderaRef = 0;
        var escritos =[];
        Array.prototype.unique=function(a){
            return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
        });

        for (var i = 0; i < objReferencias.length; i++) {
            var clean_name_moral='';
            if(objReferencias[i].regimen_fiscal=='Persona Moral'){
                clean_name_moral=objReferencias[i].razon_social.trim();
                var list_check = app.lang.getAppListStrings('validacion_duplicados_list');
                var simbolos = app.lang.getAppListStrings('validacion_simbolos_list');
                //Define arreglos para guardar nombre de cuenta
                var clean_name_split = [];
                var clean_name_split_full = [];
                clean_name_split = clean_name_moral.split(" ");
                //Elimina simbolos: Ej. . , -
                _.each(clean_name_split, function (value, key) {
                    _.each(simbolos, function (simbolo, index) {
                        var clean_value = value.split(simbolo).join('');
                        if (clean_value != value) {
                            clean_name_split[key] = clean_value;
                        }
                    });
                });
                clean_name_split_full = App.utils.deepCopy(clean_name_split);
                //Elimina tipos de sociedad: Ej. SA, de , CV...
                var totalVacio = 0;
                _.each(clean_name_split, function (value, key) {
                    _.each(list_check, function (index, nomenclatura) {
                        var upper_value = value.toUpperCase();
                        if (upper_value == nomenclatura) {
                            var clean_value = upper_value.replace(nomenclatura, "");
                            clean_name_split[key] = clean_value;
                        }
                    });
                });
                //Genera clean_name con arreglo limpio
                var clean_name = "";
                _.each(clean_name_split, function (value, key) {
                    clean_name += value;
                    //Cuenta elementos vacíos
                    if (value == "") {
                        totalVacio++;
                    }
                });

                //Valida que exista más de un elemento, caso contrario se establece para clean_name valores con tipo de sociedad
                if ((clean_name_split.length - totalVacio) <= 1) {
                    clean_name = "";
                    _.each(clean_name_split_full, function (value, key) {
                        clean_name += value;
                    });
                }
                clean_name = clean_name.toUpperCase();
                objReferencias[i].clean_name_moral= clean_name;
            }
            var iteradas='';
            iteradas= objReferencias[i].nombres.trim() + objReferencias[i].apaterno.trim() + objReferencias[i].amaterno.trim();

            if(objReferencias[i].nombres.trim()=="" || objReferencias[i].apaterno.trim()==""){
                banderaRef++;
            }

            iteradas = iteradas.replace(/\s+/gi,'');
            iteradas = iteradas.toUpperCase();
            objReferencias[i].clean_name= iteradas;
            if (iteradas=="" || (objReferencias[i].telefono == "" && objReferencias[i].correo == "")) {
                banderaRef++;
            }
            escritos.push(iteradas);
        }
        $('td.filareferencia').attr('style','');
        var escritosunicos=escritos.unique();
        if (escritosunicos.length != escritos.length) {
           var escritos_copia=escritos;

            escritos_copia.forEach(function(element, key){
                escritos.forEach(function (elementA,keyA) {
                    if (element==elementA && key!=keyA){
                        $('td.filareferencia').eq(key).attr('style','border: 2px solid red;');
                    }
                });

            });
            app.alert.show("Referenciaduplicada", {
                level: "error",
                title: "Alguna referencia est\u00E1 duplicada. <br> Favor de validar.",
                autoClose: false,
            });
            errors['referncias_duplicadas'] = errors['referncias_duplciadas'] || {};
            errors['referncias_duplicadas'].required = true;
        }
        if (banderaRef >= 1) {
            app.alert.show("ReferenciaVacia", {
                level: "error",
                title: "Alguna referencia est\u00E1 incompleta. <br> Favor de completar los campos.",
                autoClose: false,
            });
            errors['referncias_vacias'] = errors['referncias_vacias'] || {};
            errors['referncias_vacias'].required = true;
        }

        if (objReferencias.length > 0) {
            //Valida si la referencia añadida existe en la db de accounts
            var contadorR = 0;
            for (var i = 0; i < objReferencias.length; i++) {
                //Valida si la referencia añadida existe en la db de accounts
                var nombrecompleto='';
                if(objReferencias[i].regimen_fiscal=='Persona Moral'){

                    nombrecompleto= objReferencias[i].razon_social.trim();

                }else{
                    nombrecompleto = objReferencias[i].nombres.trim() + objReferencias[i].apaterno.trim() + objReferencias[i].amaterno.trim();
                }
                nombrecompleto = nombrecompleto.replace(/\s+/gi,'');


                if (nombrecompleto != "") {


                    var campos = ["primernombre_c", "apellidopaterno_c", "apellidomaterno_c"];
                    app.api.call("read", app.api.buildURL("Accounts/", null, null, {
                        campos: campos.join(','),
                        max_num: 4,
                        "filter": [
                            {
                                "clean_name": nombrecompleto,
                            }
                        ]
                    }), null, {
                        success: _.bind(function (cuenta) {
                            if (cuenta.records.length > 0) {
                                $('td.filareferencia').eq(contadorR).attr('style', 'border: 2px solid red;');
                                app.alert.show("ReferenciaDuplicada", {
                                    level: "error",
                                    title: "Ya existe una cuenta registrada. <br> Favor de verificar.",
                                    autoClose: false
                                });
                                errors['Referenciabuscada'] = errors['Referenciabuscada'] || {};
                                errors['Referenciabuscada'].required = true;
                            }
                            contadorR++;
                            if (contadorR == objReferencias.length) {
                                callback(null, fields, errors);
                            }
                        }, this)
                    });
                }else{
                    errors['Referenciaañadidavacia'] = errors['Referenciaañadidavacia'] || {};
                    errors['Referenciaañadidavacia'].required = true;

                    callback(null, fields, errors);
                }
            }
        }else{
            callback(null, fields, errors);
        }
    },

    saveReuionLlamada: function (fields, errors, callback) {
      //Limpia campos
      var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10) {
            dd = '0'+dd
        }
        if(mm<10) {
            mm = '0'+mm
        }
        today = yyyy+'-'+mm+'-'+dd;

      var necesarios="";
      $('.newCampo1A').css('border-color', '');
      $('.newDate').css('border-color', '');
      $('.newTime1').css('border-color', '');
      $('.newDate2').css('border-color', '');
      $('.newTime2').css('border-color', '');
      $('.objetivoG').find('.select2-choice').css('border-color','');
      $('.newObjetivoE1').css('border-color', '');

      //Campos necesarios para Reunion y llamada
      if(this.model.get('resultado_c')==5 || this.model.get('resultado_c')==19){
        var necesarios="";
        if($('.newCampo1A').val().trim()=='' || $('.newCampo1A').val()==null){
          necesarios=necesarios  + '<br><b>Asunto</b>'
          $('.newCampo1A').css('border-color', 'red');
        }

        if($('.newDate').val()=='' || $('.newDate').val()==null || $('.newDate').val()==undefined || $('.newTime1').val()=='' || $().val('.newTime1')==null || $().val('.newTime1')==undefined){
          necesarios=necesarios + '<br><b>Fecha inicial</b>'
          $('.newDate').css('border-color', 'red');
          $('.newTime1').css('border-color', 'red');
        }

        var registro="";
        if(this.model.get('resultado_c')==5){
            registro="Reunión";
        }
        if(this.model.get('resultado_c')==19){
            registro="Llamada";
        }

        if($('.newDate').val()<today){
            $('.newDate').css('border-color', 'red');
            app.alert.show("requeridos_reunion_llamada", {
            level: "error",
            messages: "No se pueden agendar la "+registro+" con fecha de inicio menor a la actual",
            autoClose: false
        });
        errors['.newDate'] = errors['.newDate'] || {};
        errors['.newDate'].required = true;
        }

        var fechain=$('.newDate').val();
        var hora_ini=this.validaTiempo($('.newTime1').val());
        var fechafin=$('.newDate2').val();
        var hora_fin=this.validaTiempo($('.newTime2').val());

        var fecha_ini_formateada=new Date(fechain + ' '+hora_ini);
        var fecha_fin_formateada= new Date(fechafin + ' '+hora_fin);

        if(fecha_fin_formateada<fecha_ini_formateada){
            $('.newDate2').css('border-color', 'red');
            $('.newTime2').css('border-color', 'red');
            app.alert.show("Fecha", {
            level: "error",
            messages: "La fecha de fin en la "+registro+" no puede ser menor a la fecha de inicio",
            autoClose: false
        });
        errors['.newDate2'] = errors['.newDate2'] || {};
        errors['.newDate2'].required = true;
        }

        if($('.newDate2').val()=='' || $('.newDate2').val()==null || $('.newDate2').val()==undefined || $('.newTime2').val()=='' || $('.newTime2').val()==null){
          necesarios=necesarios + '<br><b>Fecha Final</b>'
          $('.newDate2').css('border-color', 'red');
          $('.newTime2').css('border-color', 'red');
        }
      }
      //Campos Requeridos para reunión
      if(this.model.get('resultado_c')==5){
        if($('.objetivoG').select2('val')=='' || $('.objetivoG').select2('val')==null || $('.objetivoG').select2('val')==undefined){
          necesarios=necesarios  + '<br><b>Objetivo General</b>'
          $('.objetivoG').find('.select2-choice').css('border-color','red');
        }
        /*if($('.objetivoEselect').eq(0).find('input').val()=='' || $('.objetivoEselect').eq(0).find('input').val()==null || $('.objetivoEselect').eq(0).find('input').val()==undefined){
          necesarios=necesarios  + '<br><b>Objetivos Especificos</b>'
          $('.newObjetivoE1').css('border-color', 'red');
        }*/
      }
      if (necesarios != "") {
        app.alert.show("requeridos_reunion_llamada", {
            level: "error",
            messages: "Hace falta completar la siguiente información para la <b>Reunión/Llamada:</b>" + necesarios,
            autoClose: false
        });
        errors['reunion_llamada'] = errors['reunion_llamada'] || {};
        errors['reunion_llamada'].required = true;
      }
      callback(null,fields,errors);
    },

    ////Función para cambiar el formato de la hora y poder cambiar
    validaTiempo:function(time){
        if(time!="" && time!=null && time!=undefined){
            time = time.replace("pm", " PM");
            time = time.replace("am", " AM");
            var hours = Number(time.match(/^(\d+)/)[1]);
            var minutes = Number(time.match(/:(\d+)/)[1]);
            var AMPM = time.match(/\s(.*)$/)[1];
            if(AMPM == "PM" && hours<12) hours = hours+12;
            if(AMPM == "AM" && hours==12) hours = hours-12;
            var sHours = hours.toString();
            var sMinutes = minutes.toString();
            if(hours<10) sHours = "0" + sHours;
            if(minutes<10) sMinutes = "0" + sMinutes;
            return sHours + ":" + sMinutes;
        }
    },
    open_survey_minuta: function(){

        //Valida que reunión haya sido generada por usuario Agente Teléfonico o Coordinador
        var idUser = this.context.parent.attributes.model.attributes.created_by;
        var url = app.api.buildURL("Users/"+idUser, '', {}, {});

        //Valida resultado vacío
        if (this.model.get('resultado_c') == "") {
            App.alert.show("survey_no_result", {
                level: "info",
                messages: "Favor de indicar resultado de la cita previo a contestar encuesta",
                autoClose: true,
            });
            return;
        }

        //Valida resultado diferente a: "Cancelada por el prospecto ...".
        if (this.model.get('resultado_c') == "24") {
            App.alert.show("survey_no_result", {
                level: "info",
                messages: "No se puede contestar encuesta para resultado <b>Cancelada por el prospecto, se reagendo</b>",
                autoClose: true,
            });
            return;
        }

        if (this.model.get('resultado_c') == "25") {
            App.alert.show("survey_no_result", {
                level: "info",
                messages: "No se puede contestar encuesta para resultado <b>Cancelada por el prospecto, no le interesa</b>",
                autoClose: true,
            });
            return;
        }

        //Valida resultado diferente a: "No se pudo contactar al Prospecto para confirmar cita".
        if (this.model.get('resultado_c') == "22") {
            App.alert.show("survey_no_result_2", {
                level: "info",
                messages: "No se puede contestar encuesta para resultado <b>No se pudo contactar al Prospecto para confirmar cita</b>",
                autoClose: true,
            });
            return;
        }

        app.api.call("read", url, null, {
            success: _.bind(function (data) {
                /*
                Condiciones:
                  puesto
                    27- Agente teléfonico
                    31 - Coordinador CP
                  Usuario OmarVenegas: eeae5860-bb05-4ae5-3579-56ddd8a85c31
                */
                if (data.puestousuario_c == '27' || data.puestousuario_c == '31' || data.id == 'eeae5860-bb05-4ae5-3579-56ddd8a85c31') {
					// Obtiene URL de Encuesta de QuestionPro
                    var campos = ["id", "name", "url"];
                    app.api.call("read", app.api.buildURL("QPRO_Gestion_Encuestas/", null, null, {
                        campos: campos.join(','),
                        max_num: 4,
                        "filter": [
                            {
								"name": "Calidad de cita",
                            }
                        ]
                    }), null, {
                        success: _.bind(function (encuesta) {
                            if (encuesta.records.length > 0 && !window.encuesta) {
								//Guarda registro en Encuestas
								var qpencuesta = app.data.createBean('QPRO_Encuestas');
								qpencuesta.set("name", app.user.attributes.full_name);
								qpencuesta.set("related_module", "Users");
								qpencuesta.set("user_id_c", app.user.id);
								qpencuesta.set("assigned_user_id", app.user.id);
								qpencuesta.set("qpro_gestion_encuestas_qpro_encuestasqpro_gestion_encuestas_ida", encuesta.records[0].id);
								qpencuesta.save(null,{
									success:function() {
										var url = encuesta.records[0].url+"?idpersona="+app.user.id+"&idencuesta="+qpencuesta.get("id");
										window.open(url, 'Noticias', 'width=450, height=500, top=85, left=50', true);
										window.encuesta = qpencuesta.get("id");
									},
									error:function() {}
								});
                            }
							else {
							    app.alert.show("survey_open", {
									level: "info",
									messages: "Ya se cuenta con un registro para contestar la encuesta",
									autoClose: true,
								});
							}
                        }, this)
                    });
                }else {
                    app.alert.show("survey_no_access", {
                        level: "info",
                        messages: "No cuenta con permiso para contestar encuesta",
                        autoClose: true,
                    });
                    return;
                }
            }, this)
        });
    },

    changeColorSurveyButton:function (evt) {

        if(this.flagPuesto && this.model.get('resultado_c') != "22" && this.model.get('resultado_c') != "24" && this.model.get('resultado_c') != "25" && this.model.get('resultado_c') != ""){
            $('[name="survey_minuta"]').addClass('btn-success');

        }else{
            $('[name="survey_minuta"]').removeClass('btn-success');
        }

        /*if( this.leasingPuestos.includes( this.puesto_usuario )){
            var moduleid = app.data.createBean('Meetings',{id:this.model.get('minut_minutas_meetingsmeetings_idb')});
            moduleid.fetch({
                success:_.bind(function(modelo){
                    var parent_type1 = modelo.get('parent_type');
                    parent_id_acc = modelo.get('parent_id');
                    //console.log(parent_id_acc);
                    if(parent_type1== "Leads"){
                        if(self.model.get('resultado_c')=='2' ||self.model.get('resultado_c')=='18' || self.model.get('resultado_c')=='21' || self.model.get('resultado_c')=='25'){
                            $('[data-panelname="LBL_RECORDVIEW_PANEL8"]').removeClass('hide');

                        }else{
                            $('[data-panelname="LBL_RECORDVIEW_PANEL8"]').addClass('hide');

                        }
                    }else{

                        if( !(this.sin_accion.includes( self.model.get('resultado_c'))) ){

                            app.api.call("read", app.api.buildURL("Accounts/"+parent_id_acc, null, null, {
                                fields: "tipo_registro_cuenta_c",
                            }), null, {
                                success: _.bind(function (data) {
                                    if(data.tipo_registro_cuenta_c == '1' || data.tipo_registro_cuenta_c == '2'){
                                        app.api.call('get', app.api.buildURL('getallcallmeetAccount/?id_Account=' + parent_id_acc), null, {
                                            success: _.bind(function (data) {
                                                obj = JSON.parse(data);
                                                if(parent_type1== "Accounts" && obj.total > 0){
                                                    if( this.model.get('resultado_c') != "" ){
                                                        $('[data-panelname="LBL_RECORDVIEW_PANEL7"]').removeClass('hide');
                                                        self.render();
                                                    }else{
                                                        $('[data-panelname="LBL_RECORDVIEW_PANEL7"]').addClass('hide');
                                                        self.render();
                                                    }
                                                }
                                            }, this),
                                        });
                                    }
                                }, this)
                            });
                        }
                    }
                }, this)
            });
        }*/

    },

    padre:function(){
        var moduleid = app.data.createBean('Meetings',{id:this.model.get('minut_minutas_meetingsmeetings_idb')});
        moduleid.fetch({
            success:_.bind(function(modelo){
                self.parent_type = modelo.get('parent_type');
            }, this)
        });
    },

    Lead_Account_options: function(){
        /**************************************** */
        var moduleid = app.data.createBean('Meetings',{id:this.model.get('minut_minutas_meetingsmeetings_idb')});
        moduleid.fetch({
            success:_.bind(function(modelo){
                parent_meet = modelo.get('parent_type');
                parent_id_acc = modelo.get('parent_id');
                if(parent_id_acc != "" && parent_meet == "Accounts"){
                    /*********************************** */
                    //console.log(parent_id_acc);
                    app.api.call('get', app.api.buildURL('getallcallmeetAccount/?id_Account=' + parent_id_acc), null, {
                        success: _.bind(function (data) {
                            obj = JSON.parse(data);
                            if(obj.total > 0){
                                //$('[data-panelname="LBL_RECORDVIEW_PANEL4"]').removeClass('hide');
                                self.tipo_account = true;
                                //self.render();
                            }
                            //else{
                            //    $('[data-panelname="LBL_RECORDVIEW_PANEL4"]').addClass('hide');
                            //}
                        }, this),
                    });
                    /**************************************** */
                   // $("div.record-label[data-name='MotivoCancelacion']").attr('style', 'display:none;');

                }else if(parent_id_acc != "" && parent_meet == "Leads"){
                    //$("div.record-label[data-name='SegundaReunion']").attr('style', 'display:none;');
                    self.tipo_lead = true;
                    //self.render();
                }
            }, this)
        });
    },

    /*
    * Función habilitada para prevenir que la clase del botón Contestar Minuta se cambie al dar click en el botón Guardar
    * *
    enableButtons: function () {
        this._super("enableButtons");
        if(this.flagPuesto && this.model.get('resultado_c') != "22" && this.model.get('resultado_c') != "24" && this.model.get('resultado_c') != "25" && this.model.get('resultado_c') != ""){
            $('[name="survey_minuta"]').addClass('btn-success');
        }else{
            $('[name="survey_minuta"]').removeClass('btn-success');
        }
    },*/

})
