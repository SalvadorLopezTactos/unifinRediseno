({
    plugins: ['Dashlet'],

    initialize: function (options) {
        this._super("initialize", [options]);
        contextoDetalleGrafica=this;
    },

    _render: function () {
        this._super("_render");
    },

})