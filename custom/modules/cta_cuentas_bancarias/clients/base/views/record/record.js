({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
        
        this.model.on('sync', this.noEdita, this);
        //this.model.on('sync', this._HideSaveButton, this);  //Función ocultar botón guardar cuando Oportunidad perdida tiene un valor TRUE 18/07/18
        this.model.addValidationTask('validaClabe', _.bind(this.validaClabe, this));
        
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

    validaClabe: function (fields, errors, callback) {

        var clabe = this.model.get('clabe');

        var regex = /^\d{18}$/;

        if( !regex.test(clabe) && clabe != "" ){
            app.alert.show("errorClabe", {
              level: "error",
              title: "Clabe interbancaria no válida",
              messages:"Formato incorrecto, favor de ingresar los 18 dígitos de la Clabe Interbancaria",
              autoClose: false,
            });

            errors["clabe"] = errors["tipo_producto_c"] || {};
            errors["clabe"].required = true;
        }

        callback(null, fields, errors);
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
