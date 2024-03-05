({
    extendsFrom: 'RecordView',

     initialize: function (options) {

        this._super("initialize", [options]);
        this.model.on('sync', this.evaluationHideFieldNameFile, this);

        this.model.addValidationTask('valida_solicitud_caso', _.bind(this.valida_solicitud_caso, this));
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

    },

    valida_solicitud_caso :function (fields, errors, callback) {

        if( this.model.get('tipo_documento_c') == "11" ){ //11 = Carta de Buró de Crédito
            var idDoc = this.model.get('id');
            //Obtiene casos relacionados
            var urlCasos = app.api.buildURL("Documents/" + idDoc + "/link/cases?order_by=date_entered:desc");
            app.api.call('read', urlCasos, null, {
                success: function (data) {
                    if( data.records.length > 0 ){

                        for (let index = 0; index < data.records.length; index++) {
                            //Toma el primer caso relacionado
                            if( index == 0 ){
                                var solicitud = data.records[index].opportunity_id_c;
                                if( solicitud == "" || solicitud == null ){
                                    app.alert.show('alert_solicitud', {
                                        level: 'info',
                                        title: 'Aviso',
                                        messages: 'Este documento no se enviará a Quantico ya que el caso relacionado no tiene una solicitud asociada',
                                        autoClose: false
                                    });
                                }
                            }
                            
                        }

                    }
                    callback(null, fields, errors);
                },
                error: function (e) {
                    throw e;
                }
            });

        }else{

            callback(null, fields, errors);
        }

    }

})