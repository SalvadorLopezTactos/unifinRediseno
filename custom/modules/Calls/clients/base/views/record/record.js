({
    extendsFrom: 'RecordView',

    fechaInicioTemp: "",

    events: {
        'click .record-edit-link-wrapper': 'handleEdit',
    },

    initialize: function (options) {
            self = this;
            this._super("initialize", [options]);
            this.on('render',this.disableparentsfields,this);
            this.on('render', this.noEditStatus,this);
            //this.model.on('sync', this.bloqueaTodo, this);
            //Habilita el campo parent_name cuando esta vacio y lo deshabilta cuando ya tiene una cuenta
            this.model.on('sync',this.enableparentname,this);
            this.model.on('sync', this.cambioFecha, this);
            this.model.addValidationTask('VaildaFechaPermitida', _.bind(this.validaFechaInicial2Call, this));
            this.model.addValidationTask('VaildaConferencia', _.bind(this.validaConferencia, this));
            this.model.addValidationTask('VaildaFecha', _.bind(this.VaildaFecha, this));
            this.model.addValidationTask('valida_requeridos',_.bind(this.valida_requeridos, this));
            /*@Jesus Carrillo
                Funcion que pinta de color los paneles relacionados
            */
            this.model.on('sync', this.fulminantcolor, this);
            
            $('[data-name="status"]').find('.fa-pencil').remove();
            $('.record-edit-link-wrapper[data-name=status]').remove();

            this.model.on('sync', this.disablestatus1, this);
            this.model.on('sync', this.disableFieldsTime,this);
            this.model.addValidationTask('resultCallReq',_.bind(this.resultCallRequerido, this));
            this.events['click a[name=edit_button]'] = 'fechascallsymeet';
    },
    
    _render: function (options) {
        this._super("_render");
        this.enableparentname();
    },

    bloqueaTodo:function()
    {
        //this._super("_renderHtml");
        var self=this;

        if(this.model.get('status')=='Held' || this.model.get('status')=='Not Held') {

            _.each(this.model.fields, function (field) {
                self.noEditFields.push(field.name);
            }, self);

        }

    },

    resultCallRequerido:function (fields, errors, callback) {
        if(this.model.get('status')=='Held' || this.model.get('status')=='Not Held'){
            if (this.model.get('tct_resultado_llamada_ddw_c')=='') {

                app.error.errorName2Keys['requResultCall'] = 'El resultado de la Llamada es requerido';
                errors['tct_resultado_llamada_ddw_c'] = errors['tct_resultado_llamada_ddw_c'] || {};
                errors['tct_resultado_llamada_ddw_c'].requResultCall = true;
                errors['tct_resultado_llamada_ddw_c'].required = true;
            }
        }
        callback(null, fields, errors);
    },

    /*
    * F. Javier G. Solar 13/09/2018
    * Se bloquea el campo estatus si aun no se ha cumplido la fecha y hora cumplida**/
    disablestatus1: function () {

      if(Date.parse(this.model.get('date_end'))>Date.now() || this.model.get('status') == 'Held' || this.model.get('status') == 'Not Held'){
            $('span[data-name=status]').css("pointer-events", "none");
        }else{
            $('span[data-name=status]').css("pointer-events", "auto");
        }

    },

    /**
     * @author Salvador Lopez	
     * Se habilita handleEdit, editClicked y cancelClicked para dejar habilitado el campo parent_name y solo se bloquea al
     * dar click en el campo e intentar editar
    * */
    handleEdit: function(e, cell) {
        var target,
            cellData,
            field;
        if (e) { // If result of click event, extract target and cell.
            target = this.$(e.target);
            cell = target.parents('.record-cell');
        }

        if(e.currentTarget.dataset['name']=='parent_name'){

            this.inlineEditMode = false;

        }else{

            cellData = cell.data();
            field = this.getField(cellData.name);

            // Set Editing mode to on.
            this.inlineEditMode = true;

            this.setButtonStates(this.STATE.EDIT);

            this.toggleField(field);

            if (cell.closest('.headerpane').length > 0) {
                this.toggleViewButtons(true);
                this.adjustHeaderpaneFields();
            }

        }


    },

    editClicked: function() {
        this._super("editClicked");

        if(this.model.get('status')=='Held' || this.model.get('status')=='Not Held'){
            this.setButtonStates(this.STATE.VIEW);
            this.action = 'detail';
            this.toggleEdit(false);
            this.setRoute('');

        }

    },
    
    cancelClicked: function() {

        this._super("cancelClicked");

        this.$('[data-name="parent_name"]').attr('style', '');

        this.setButtonStates(this.STATE.VIEW);
        this.action = 'detail';
        this.handleCancel();
        this.clearValidationErrors(this.editableFields);
        this.setRoute();
        this.unsetContextAction();
    },

    /*Victor Martinez Lopez
    *25-09-2018
    *El campo parent_name se habilita cuando esta vacio
    */
    enableparentname:function(){
    if (this.model.get('parent_name') !=='' && this.model.get('parent_name')!==undefined){
            var self = this;
            self.noEditFields.push('parent_name');
        }
        else {
        this.$('[data-name="parent_name"]').attr('style', '');
        //this.setButtonStates(this.STATE.EDIT);
        this.action = 'detail';
        this.toggleEdit(false);
        //this.setRoute('edit');
        }
    },

    VaildaFecha: function(fields, errors, callback)
    {
        var startDate = new Date(this.model.get('date_start'));
      	var startMonth = startDate.getMonth() + 1;
      	var startDay = startDate.getDate();
      	var startYear = startDate.getFullYear();
      	var startDateText = startDay + "/" + startMonth + "/" + startYear;
      	var conferDate = new Date(this.model.get('tct_conferencia_fecha_dat_c'));
      	var conferMonth = conferDate.getMonth() + 1;
      	var conferDay = conferDate.getDate();
      	var conferYear = conferDate.getFullYear();
      	var conferDateText = conferDay + "/" + conferMonth + "/" + conferYear;
        var startToDate = Date.parse(startDateText);
        var inputToDate = Date.parse(conferDateText);
	      if(inputToDate < startToDate)
      	{
          app.alert.show("Fecha Incorrecta", {
            level: "error",
            title: "La fecha a contactar debe ser mayor a la fecha actual",
            autoClose: false
          });
    	    errors['tct_conferencia_fecha_dat_c'] = "La fecha a contactar debe ser mayor a la fecha actual";
          errors['tct_conferencia_fecha_dat_c'].required = true;
        }
    	callback(null, fields, errors);
    },

    validaConferencia: function(fields, errors, callback)
    {
      if(this.model.get('tct_conferencia_chk_c') && this.model.get('tct_calificacion_conferencia_c') === "")
    	{
          /*app.alert.show("Calificacion Requerida", {
            level: "error",
            title: "El campo Calificaci&oacuten de la Conferencia es requerido",
            autoClose: false
          });*/
    	    errors['tct_calificacion_conferencia_c'] = "El campo Calificaci&oacuten de la Conferencia es requerido";
          errors['tct_calificacion_conferencia_c'].required = true;
      }

        if (this.model.get('tct_conferencia_chk_c') && this.model.get('tct_conferencia_fecha_dat_c') != '') {
            //var todayDate = new Date();
            var dateStart = Date.parse(this.model.get('date_start'));
            var inputToDate = Date.parse(this.model.get('tct_conferencia_fecha_dat_c'));
            if(dateStart > inputToDate)
            {
                app.alert.show("Fecha_Incorrecta_Conferencia", {
                   level: "error",
                    title: "La fecha a contactar debe ser mayor a la fecha de inicio",
                    autoClose: false
                });

                errors['tct_conferencia_fecha_dat_c'] = "La fecha a contactar debe ser mayor a la fecha de inicio";
                errors['tct_conferencia_fecha_dat_c'].required = true;
            }
        }

    	callback(null, fields, errors);
    },

    /* @Salvador Lopez Y Adrian Arauz
        Oculta los campos relacionados
    */
    disableparentsfields:function () {

        //this.$('[data-name="parent_name"]').attr('style', 'pointer-events:none;');

        //Elimina �cono de l�piz para editar parent_name
        $('[data-name="parent_name"]').find('.fa-pencil').remove();
        
        },

        /*Victor Martinez Lopez
        *El estado no es editable de manera directa al dar click, solo cuando se presiona el boton editar
        */
    noEditStatus:function(){
        $('[data-name="status"]').find('.fa-pencil').remove();
        $('.record-edit-link-wrapper[data-name=status]').remove();
        },

    cambioFecha: function () {
        this.fechaInicioTemp = Date.parse(this.model.get("date_start"));
       // console.log("Fechas: " + this.fechaInicioTemp);
        //Coloca solo lectura el campo Conferencia
    		if(this.model.get('tct_conferencia_chk_c'))
      	{
    	    var self = this;
     			self.noEditFields.push('tct_conferencia_chk_c');
          $('.record-edit-link-wrapper[data-name=tct_conferencia_chk_c]').remove();
      	}
    },

    /* @F. Javier G. Solar
     * Valida que la Fecha Inicial no sea menor que la actual
     * 14/08/2018
     */
    validaFechaInicial2Call: function (fields, errors, callback) {

        // FECHA ACTUAL
        var dateActual = new Date();
        var d1 = dateActual.getDate();
        var m1 = dateActual.getMonth() + 1;
        var y1 = dateActual.getFullYear();
        var dateActualFormat = [m1, d1, y1].join('/');
        var fechaActual = Date.parse(dateActualFormat);

        // FECHA INICIO ANTES DE CAMBIAR
        var dateInicioTmp = new Date(this.fechaInicioTemp);
        var d = dateInicioTmp.getDate();
        var m = dateInicioTmp.getMonth() + 1;
        var y = dateInicioTmp.getFullYear();
        var fechaCompletaTmp = [m, d, y].join('/');
        var fechaInicioTmp = Date.parse(fechaCompletaTmp);

        // FECHA INICIO EN CAMPO
        var dateInicio = new Date(this.model.get("date_start"));
        var d = dateInicio.getDate();
        var m = dateInicio.getMonth() + 1;
        var y = dateInicio.getFullYear();
        var fechaCompleta = [m, d, y].join('/');
        var fechaInicioNueva = Date.parse(fechaCompleta);

        if (fechaInicioTmp != fechaInicioNueva) {
            if (fechaInicioTmp < fechaActual) {
                if (fechaInicioNueva >= fechaInicioTmp) {
                    console.log("Guarda por opcion 1");
                }
                else {
                    app.alert.show("Fecha no valida", {
                        level: "error",
                        title: "No puedes guardar una Llamada con fecha menor a la que se habia establecido",
                        autoClose: false
                    });

                    app.error.errorName2Keys['custom_message_date_init0'] = 'No puedes guardar una Llamada con fecha menor a la que se habia establecido';
                    errors['date_start'] = errors['date_start'] || {};
                    errors['date_start'].custom_message_date_init0 = true;
                }

                //callback(null, fields, errors);
            }
            if (fechaInicioTmp >= fechaActual) {
                if (fechaInicioNueva >= fechaActual) {
                    console.log("Guarda por opcion 2")
                }
                else {
                    app.alert.show("Fecha no valida", {
                        level: "error",
                        title: "No puedes agendar Llamada con fecha menor al d&Iacutea de hoy",
                        autoClose: false
                    });

                    app.error.errorName2Keys['custom_message_date_init1'] = 'No puedes agendar Llamada con fecha menor al d&Iacutea de hoy';
                    errors['date_start'] = errors['date_start'] || {};
                    errors['date_start'].custom_message_date_init1 = true;
                }

                //callback(null, fields, errors);
            }
        }
        callback(null, fields, errors);
    },

    /*@Jesus Carrillo
        Funcion que pinta de color los paneles relacionados
    */
    fulminantcolor: function () {
        $( '#space' ).remove();
        $('.control-group').before('<div id="space" style="background-color:#000042"><br></div>');
        $('.control-group').css("background-color", "#e5e5e5");
        $('.a11y-wrapper').css("background-color", "#e5e5e5");
        //$('.a11y-wrapper').css("background-color", "#c6d9ff");
    },

    /*Victor Martinez López
    * Duración y recordatorios no son editables cuando la reunión esta como realizada
    * */
    disableFieldsTime: function(){
        $('.record-edit-link-wrapper[data-name=duration]').remove();
        $('.record-edit-link-wrapper[data-name=reminders]').remove();
        if (this.model.get('tct_resultado_llamada_ddw_c')==''){
            this.$("[data-name='tct_resultado_llamada_ddw_c']").prop("enable", true);
        }else {
            $('.record-edit-link-wrapper[data-name=tct_resultado_llamada_ddw_c]').remove();
        }

        //Establece campo dependientes de resultado de llamada como editables mientras sea planeado
        if (this.model.get('status')=='Planned'  ){
            this.$("[data-name='tct_motivo_ilocalizable_ddw_c']").prop("enable", true);
            this.$("[data-name='tct_usuario_cita_rel_c']").prop("enable", true);
            this.$("[data-name='tct_fecha_cita_dat_c']").prop("enable", true);
            this.$("[data-name='tct_fecha_seguimiento_dat_c']").prop("enable", true);
            this.$("[data-name='tct_motivo_desinteres_ddw_c']").prop("enable", true);
        }else {
            $('.record-edit-link-wrapper[data-name=tct_motivo_ilocalizable_ddw_c]').remove();
            $('.record-edit-link-wrapper[data-name=tct_usuario_cita_rel_c]').remove();
            $('.record-edit-link-wrapper[data-name=tct_fecha_cita_dat_c]').remove();
            $('.record-edit-link-wrapper[data-name=tct_fecha_seguimiento_dat_c]').remove();
            $('.record-edit-link-wrapper[data-name=tct_motivo_desinteres_ddw_c]').remove();
        }

    },

    fechascallsymeet: function(){
        if(this.model.get('status')=='Held' || this.model.get('status')=='Not Held'){
            var self = this;
            self.noEditFields.push('date_start');
            self.noEditFields.push('date_end');
            self.render();

        }
    },
    
    valida_requeridos: function(fields, errors, callback) {
        var campos = "";
        _.each(errors, function(value, key) {
            _.each(this.model.fields, function(field) {
                if(_.isEqual(field.name,key)) {
                    if(field.vname) {
                        campos = campos + '<b>' + app.lang.get(field.vname, "Calls") + '<br></b>';
                    }
          		  }
       	    }, this);
        }, this);
        if(campos) {
            app.alert.show("Campos Requeridos", {
                level: "error",
                title: "<b>ERROR</b> Hace falta completar la siguiente información en la <b>Llamada:</b><br>" + campos,
                autoClose: false
            });
        }
        callback(null, fields, errors);
    },
})
