({
    extendsFrom: 'CreateView',

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
    },

    _render: function() {
        this._super("_render");
        //Oculta etiqueta del campo custom pipeline
        $("div.record-label[data-name='seguro_pipeline']").attr('style', 'display:none;');
        //Oculta campo seguro_pipeline
        this.$('div[data-name=seguro_pipeline]').hide();
    },





})