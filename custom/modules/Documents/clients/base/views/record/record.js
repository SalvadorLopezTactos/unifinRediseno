({
    extendsFrom: 'RecordView',

     initialize: function (options) {

        this._super("initialize", [options]);
        this.model.on('sync', this.evaluationHideFieldNameFile, this);
    },

    _render: function (fields, errors, callback) {
        this._super("_render");

        //Ocultar campo que descarga Documento Quantico
        $('[data-type="document_download_quantico"]').hide();

        //Oculta campo que guarda información del Documento de Quantico
        $('[data-name="data_document_quantico_c"]').hide();
    },

    evaluationHideFieldNameFile: function(){

        //El campo de caja de nombre se oculta cuando el campo que guarda información de Quantico tiene información para poder habilitar descarga del documento
        var valorDataQuantico = this.model.get('data_document_quantico_c');
        if( valorDataQuantico != "" ){
            $('[data-type="file"]').hide();
            $('[data-type="document_download_quantico"]').show();
        }

    }

})