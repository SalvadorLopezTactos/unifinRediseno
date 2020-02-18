({
    extendsFrom: 'RecordView',

    events: {
        'click .record-edit-link-wrapper': 'handleEdit',
    },

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);

        this.on('render',this.disableparentsfields,this);
		this.model.on('change:ayuda_asesor_cp_c', this._ValoresPredetAsesor, this);
		this.model.on('change:parent_name', this._ValoresPredetAsesor, this);
		

		
        this.model.addValidationTask('valida_cuenta_no_contactar', _.bind(this.valida_cuenta_no_contactar, this));
        this.model.addValidationTask('checkdate', _.bind(this.checkdate, this));
		this.model.addValidationTask('valida_asignado', _.bind(this.valida_asignado, this));

        /*@Jesus Carrillo
            Funcion que pinta de color los paneles relacionados
        */
        this.model.on('sync', this.fulminantcolor, this);
        this.model.on('sync', this.loadprevdate, this);


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

    _render: function () {
        this._super("_render");
    },

    /*@Jesus Carrillo
        Funcion que pinta de color los paneles relacionados
    */
    fulminantcolor: function () {
        this.blockRecordNoContactar();
        $( '#space' ).remove();
        $('.control-group').before('<div id="space" style="background-color:#000042"><br></div>');
        $('.control-group').css("background-color", "#e5e5e5");
        $('.a11y-wrapper').css("background-color", "#e5e5e5");
        //$('.a11y-wrapper').css("background-color", "#c6d9ff");
    },

    blockRecordNoContactar:function () {

        var id_cuenta=this.model.get('parent_id');

        if(id_cuenta!='' && id_cuenta != undefined && this.model.get('parent_type') == "Accounts" ){

            var account = app.data.createBean('Accounts', {id:this.model.get('parent_id')});
            account.fetch({
                success: _.bind(function (model) {

                    if(model.get('tct_no_contactar_chk_c')==true){

                        app.alert.show("cuentas_no_contactar", {
                            level: "error",
                            title: "Cuenta No Contactable<br>",
                            messages: "Cualquier duda o aclaraci\u00F3n, favor de contactar al \u00E1rea de <b>Administraci\u00F3n de cartera</b>",
                            autoClose: false
                        });

                        //Bloquear el registro completo y mostrar alerta
                        $('.record').attr('style','pointer-events:none')
                    }
                }, this)
            });

        }

    },

    loadprevdate: function(){
        var temp1=this.model.get('date_start');
        var temp2=temp1.split('T');
        this.temp_startdate = temp2[0];
        _.extend(this,this.temp_startdate);
        var temp3=this.model.get('date_due');
        var temp4=temp3.split('T');
        this.temp_duedate = temp4[0];
        _.extend(this,this.temp_duedate);
    },

    valida_cuenta_no_contactar:function (fields, errors, callback) {

        if (this.model.get('parent_id') && this.model.get('parent_type') == "Accounts") {
            var account = app.data.createBean('Accounts', {id:this.model.get('parent_id')});
            account.fetch({
                success: _.bind(function (model) {
                    if(model.get('tct_no_contactar_chk_c')==true){

                        app.alert.show("cuentas_no_contactar", {
                            level: "error",
                            title: "Cuenta No Contactable<br>",
                            messages: "Unifin ha decidido NO trabajar con la cuenta relacionada a esta tarea.<br>Cualquier duda o aclaraci\u00F3n, favor de contactar al \u00E1rea de <b>Administraci\u00F3n de cartera</b>",
                            autoClose: false
                        });

                        errors['parent_name'] = errors['parent_name'] || {};
                        errors['parent_name'].required = true;

                    }
                    callback(null, fields, errors);
                }, this)
            });
        }else {
            callback(null, fields, errors);
        }

    },

    checkdate: function (fields, errors, callback) {
        var temp1=this.model.get('date_start');
        var temp2=temp1.split('T');
        var start_date = temp2[0];
        var temp3=this.model.get('date_due');
        var temp4=temp3.split('T');
        var due_date = temp4[0];
        if(start_date<this.temp_startdate ){
            app.alert.show("start_invalid", {
                level: "error",
                title: "La fecha de inicio actual no puede ser menor a la que estaba guardada",
                autoClose: false
            });
            errors['date_start'] = errors['date_start'] || {};
            errors['date_start'].datetime = true;
        }
        if(due_date<this.temp_duedate ){
            app.alert.show("due_invalid", {
                level: "error",
                title: "La fecha de vencimiento actual no puede ser menor a la que estaba guardada",
                autoClose: false
            });
            errors['date_due'] = errors['date_due'] || {};
            errors['date_due'].datetime = true;
        }
        callback(null,fields,errors);
    },

    /* @Salvador Lopez Y Adrian Arauz
    Oculta los campos relacionados
    */
    
    disableparentsfields:function () {
        //this.$('[data-name="parent_name"]').attr('style', 'pointer-events:none;');
        //$('.record-cell[data-type="relate"]').removeAttr("style");
		if (App.user.attributes.puestousuario_c=='27'||App.user.attributes.puestousuario_c=='31') {
			//Oculta Check ayuda
			this.$('[data-name=ayuda_asesor_cp_c]').hide(); 
        }
    },
	
	/*
	Erick de Jesus check ayuda CP 
	*/
	_ValoresPredetAsesor: function () {
		var parent_nombre="";
		var fechaini = "";
		var tomorrow = new Date();
		var puesto = App.user.attributes.puestousuario_c; //27=> Agente Tel, 31=> Coordinador CP,
		
        if(this.model.get('ayuda_asesor_cp_c') == '1') {
			
			var module = this.model.get('parent_type');
			var parent_id = this.model.get('parent_id');
				
			if((module == "Accounts" || module == "Leads") && (parent_id != "" && parent_id != null && parent_id != 'undefined')){
			
				this.model.set('name', "AYUDA CP");
				var reg_parent = app.data.createBean(module, {id:this.model.get('parent_id')});
				reg_parent.fetch({
					success: _.bind(function (model) {
						//parent_nombre = model.get('name');
						this.model.set('name', "AYUDA CP - "+model.get('name'));
					}, this)
				});
				
			}else{
				this.model.set('name', "AYUDA CP");
			}
        }else{
            this.model.set('name', '');
			this.model.set('date_due', '');
        }
    },
	
	/*
	Erick de Jesus valida usuario asesor telefonico asignado cuando el check de ayuda esta activo 
	*/
	valida_asignado:function (fields, errors, callback) {        
		if (this.model.get('ayuda_asesor_cp_c') == '1'){
			
			var user = app.data.createBean('Users', {id:this.model.get('assigned_user_id')});
            user.fetch({
                success: _.bind(function (model) {
                    if(model.get('puestousuario_c')!= '27'){

                        app.alert.show("El usuario asignado debe ser Agente Telefónico", {
                            level: "error",
                            title: "Usuario asignado",
                            messages: "El usuario asignado debe ser Agente Telefónico",
                            autoClose: false
                        });

                        errors['assigned_user_id'] = errors['assigned_user_id'] || {};
						errors['assigned_user_id'].required = true;
                    }
					callback(null, fields, errors);
                }, this)
            });
        }else{
			callback(null, fields, errors);
		}       
    },     
})
