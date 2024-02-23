({

    initialize: function (options) {
        this._super('initialize', [options]);

        this.model.on('sync', this.getFileQuantico, this);
        this.base64Doc = null;
        this.nameFile = null;
        this.extFile = null;
        this.errorCall = null;
    },

    _render: function() {
        this._super('_render');

        //Muestra campo y oculta símbolo +  correspondiente a la etiqueta
        $('[data-name="document_download_quantico"]').find('.normal.index').children().show();
        $('[data-name="document_download_quantico"]').find('.label-plus').hide()

        //En caso de no tener información del documento de Quantico, el campo de descarga se oculta
        if( this.model.get('data_document_quantico_c') == "" ){
            this.$el.hide();
        }
    },

    getFileQuantico: function(){
        selfDocQuantico = this;
        var dataQuantico = this.model.get('data_document_quantico_c');

        if( dataQuantico != "" ){

            var arrData = dataQuantico.split(" ");
            var idDoc = arrData[0];
            var version = arrData[1];
    
            var valUrl = app.api.buildURL("DownloadDocumentQuantico?idDoc=" + idDoc + "&version=" + version, '', {}, {});
    
            App.alert.show('downloadDocQuantico', {
                    level: 'process',
                });
    
            app.api.call("read", valUrl, null, {
                success: _.bind(function (response) {
                    app.alert.dismiss("downloadDocQuantico");
                    if (response.data.content != undefined) {
                        selfDocQuantico.base64Doc = response.data.content;
                        selfDocQuantico.nameFile = response.data.fileName;
                        selfDocQuantico.extFile = response.data.FileExtension;
    
                    }else{
                        selfDocQuantico.errorCall = "Error";
                    }
                    
                    selfDocQuantico.render();
                }, this)
            });
        }

    }
})