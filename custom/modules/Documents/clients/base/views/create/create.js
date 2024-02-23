({
    extendsFrom: 'CreateView',

     initialize: function (options) {

        this._super("initialize", [options]);
    },

    _render: function (fields, errors, callback) {
        this._super("_render");

        //Ocultar campo que descarga Documento Quantico
        $('[data-type="document_download_quantico"]').hide();

    },

})