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
            this.model.on('sync', this.cambioFecha, this);
            this.model.addValidationTask('VaildaFechaPermitida', _.bind(this.validaFechaInicial2Call, this));
            this.model.addValidationTask('VaildaConferencia', _.bind(this.validaConferencia, this));

            /*@Jesus Carrillo
                Funcion que pinta de color los paneles relacionados
            */
            this.model.on('sync', this.fulminantcolor, this);
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
        this.$('[data-name="parent_name"]').attr('style', 'pointer-events:none;');
        this.setButtonStates(this.STATE.EDIT);
        this.action = 'edit';
        this.toggleEdit(true);
        this.setRoute('edit');

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

    validaConferencia: function(fields, errors, callback)
    {
        if(this.model.get('tct_conferencia_chk_c') && this.model.get('tct_calificacion_conferencia_c') === "")
    	  {
          app.alert.show("Calificacion Requerida", {
            level: "error",
            title: "El campo Calificaci&oacuten de la Conferencia es requerido",
            autoClose: false
          });
    	    errors['tct_calificacion_conferencia_c'] = "El campo Calificaci&oacuten de la Conferencia es requerido";
          errors['tct_calificacion_conferencia_c'].required = true;
        }
    	  callback(null, fields, errors);
    },

    /* @Salvador Lopez Y Adrian Arauz
        Oculta los campos relacionados
    */
    disableparentsfields:function () {

        //this.$('[data-name="parent_name"]').attr('style', 'pointer-events:none;');

        //Elimina ícono de lápiz para editar parent_name
        $('[data-name="parent_name"]').find('.fa-pencil').remove();

    },

    cambioFecha: function () {
        this.fechaInicioTemp = Date.parse(this.model.get("date_start"));
        console.log("Fechas: " + this.fechaInicioTemp);
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
})
