({
    plugins: ['Dashlet'],

    initialize: function (options) {
        this._super("initialize", [options]);
        self=this;
        //this.idAsesor="16ff1b17-a063-6fff-970f-5628f6e851a4";
        this.idAsesor=App.user.id;
        this.urlDisposiciones=App.config.url_micro_disposiciones;
    },

    _render: function () {
        this._super("_render");
    }
})