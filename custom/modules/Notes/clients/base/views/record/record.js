({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
        this.events['click .record-edit-link-wrapper'] = 'handleEdit';
        this.model.on('sync',this.disableparentsfields,this);
        this.model.on('sync',this.enableparentname,this);
        this.on('render', this.disableparentsfields, this);
        this.model.on('sync', this.showMinutarel, this);

        /*@Jesus Carrillo
            Funcion que pinta de color los paneles relacionados
        */
        this.model.on('sync', this.fulminantcolor, this);

        this.model.addValidationTask('valida_cuenta_no_contactar', _.bind(this.valida_cuenta_no_contactar, this));
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
                            messages: "Unifin ha decidido NO trabajar con la cuenta relacionada a esta llamada.<br>Cualquier duda o aclaraci\u00F3n, favor de contactar al \u00E1rea de <b>Administraci\u00F3n de cartera</b>",
                            autoClose: false
                        });

                        //Bloquear el registro completo y mostrar alerta
                        $('.record').attr('style','pointer-events:none')
                    }
                }, this)
            });

        }

    },
    
    showMinutarel:function(){
        if(this.model.get('relacion_nota_minuta_c')=='' || this.model.get('relacion_nota_minuta_c')==undefined){
            $('div[data-name=relacion_nota_minuta_c]').hide();
        }
    },
    
    /*Victor Martinez Lopez
    *20-11-2018
    *El campo parent_name se habilita cuando esta vacio
    */
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
    },
    
    cancelClicked: function() {
        this._super("cancelClicked");
        this.$('[data-name="parent_name"]').attr('style', '');
    },
    
    saveClicked:function(){
        this._super("saveClicked");
        this.$('[data-name="parent_name"]').attr('style', '');
    },

    disableparentsfields: function () {
        //Elimina ícono de lápiz para editar parent_name*
        $('[data-name="parent_name"]').find('.fa-pencil').remove();
    },
    
    enableparentname:function(){
    if (this.model.get('parent_name') !=='' && this.model.get('parent_name')!==undefined){
            var self = this;
            self.noEditFields.push('parent_name');
        }
        else {
        this.$('[data-name="parent_name"]').attr('style', '');
        }
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
                            messages: "Unifin ha decidido NO trabajar con la cuenta relacionada a esta nota.<br>Cualquier duda o aclaraci\u00F3n, favor de contactar al \u00E1rea de <b>Administraci\u00F3n de cartera</b>",
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

    /* @Salvador Lopez Y Adrian Arauz
    Oculta los campos relacionados
    
    disableparentsfields:function () {
        if (this.model.get('parent_name') !=='' && this.model.get('parent_name')!==undefined){
            var self = this;
            self.noEditFields.push('parent_name');
        }
    },*/
})
