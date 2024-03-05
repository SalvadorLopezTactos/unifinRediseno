({
    extendsFrom: 'CreateView',

     initialize: function (options) {

        this._super("initialize", [options]);

        this.model.addValidationTask('valida_solicitud_caso', _.bind(this.valida_solicitud_caso, this));
    },

    _render: function (fields, errors, callback) {
        this._super("_render");

        //Ocultar campo que descarga Documento Quantico
        $('[data-type="document_download_quantico"]').hide();

        //Oculta campo que guarda información del Documento de Quantico
        $('[data-name="data_document_quantico_c"]').hide();
    },

    valida_solicitud_caso :function (fields, errors, callback) {
        var moduloPadre = this.context.parent.get('module');
        if( this.model.get('tipo_documento_c') == "11" && moduloPadre == 'Cases' ){ //11 = Carta de Buró de Crédito

            var solicitud = this.context.parent.get('model').get('opportunity_id_c');

            if( solicitud == "" || solicitud == null ){

                app.alert.show('alert_solicitud', {
                    level: 'info',
                    title: 'Aviso',
                    messages: 'Este documento no se enviará a Quantico ya que el caso relacionado no tiene una solicitud asociada',
                    autoClose: false
                });
            }

        }

        callback(null, fields, errors);

    }

})