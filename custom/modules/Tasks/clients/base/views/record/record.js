({
    extendsFrom: 'RecordView',

    events: {
        'click .record-edit-link-wrapper': 'handleEdit',
    },

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);

        this.on('render',this.disableparentsfields,this);
        //this.model.addValidationTask('checkdate', _.bind(this.checkdate, this));

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
        $( '#space' ).remove();
        $('.control-group').before('<div id="space" style="background-color:#000042"><br></div>');
        $('.control-group').css("background-color", "#e5e5e5");
        $('.a11y-wrapper').css("background-color", "#e5e5e5");
        //$('.a11y-wrapper').css("background-color", "#c6d9ff");
    },

    loadprevdate: function(){
        this.temp_startdate= new Date(this.model.get('date_start'));
        _.extend(this,this.temp_startdate);
        this.temp_duedate= new Date(this.model.get('date_due'));
        _.extend(this,this.temp_duedate);
    },

    checkdate: function (fields, errors, callback) {
        var start_date = new Date(this.model.get('date_start'));
        var due_date = new Date(this.model.get('date_due'));
        var now = new Date();
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
    /*
    disableparentsfields:function () {
        this.$('[data-name="parent_name"]').attr('style', 'pointer-events:none;');
        $('.record-cell[data-type="relate"]').removeAttr("style");
    },
     */
})
