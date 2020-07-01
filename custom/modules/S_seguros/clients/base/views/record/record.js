({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        this._super("initialize", [options]);
    },

    _render: function() {
        this._super("_render");

        //Oculta campos de etapa y subetapa
        $('[data-name="seguro_pipeline"]').attr('style', 'pointer-events:none');

        //Oculta etiqueta del campo custom pipeline_opp
        $("div.record-label[data-name='seguro_pipeline']").attr('style', 'display:none;');
        //Desabilita edicion campo pipeline
        this.noEditFields.push('seguro_pipeline');
    },


})