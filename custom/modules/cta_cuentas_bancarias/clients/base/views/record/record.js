({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
        
        this.model.on('sync', this.noEdita, this);
        //this.model.on('sync', this._HideSaveButton, this);  //Función ocultar botón guardar cuando Oportunidad perdida tiene un valor TRUE 18/07/18
        
    },

    cancelClicked: function () {
        this._super('cancelClicked');
    },

    editClicked: function () {
        this._super('editClicked');
    },
    _render: function () {
        this._super("_render");
        this.noEdita();
    },
    /*Valida que solo algunos roles puedan editar la solicitud
    * Victor Martinez Lopez
    * */
    noEdita: function () {
        
        //Definir si puede o no editar
        var editar = true;

        if(self.model.get('validada_c')==1){
            editar = false;
        }
        
        //Ocultar edición
        if (editar == false) {
            $('.record').attr('style','pointer-events:none')
			$('.subpanel').attr('style', 'pointer-events:none');
            
            $('[name="save_button"]').eq(0).hide();
            $('[name="edit_button"]').eq(0).hide();
            $(".noEdit").hide();
        }
    },

    _dispose: function () {
        this._super('_dispose', []);
    },
    //Funcion que evita el guardado de la oportunidad si esta tiene status Cancelada y el chk = TRUE
    _HideSaveButton: function () {
        if (this.model.get('tct_oportunidad_perdida_chk_c') && this.model.get('estatus_c') == 'K') {
            this.$(".record-edit-link-wrapper").attr('style', 'pointer-events:none');
            var editButton = self.getField('edit_button');
            editButton.setDisabled(true);
            $('[name="save_button"]').eq(0).hide();
        }
        //else {$('[name="save_button"]').eq(0).show();}
    },
    handleCancel: function () {
        this._super("handleCancel");
    },


})
