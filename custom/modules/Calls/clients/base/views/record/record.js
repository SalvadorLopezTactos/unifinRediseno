({
        extendsFrom: 'RecordView',

        initialize: function (options) {
            self = this;
            this._super("initialize", [options]);

            this.on('render',this.disableparentsfields,this);

        },

        _render: function () {
            this._super("_render");
        },

        /* @Alvador Lopez Y Adrian Arauz
           Oculta los campos relacionados
         */
        disableparentsfields:function () {
                this.$('[data-name="parent_name"]').attr('style', 'pointer-events:none;')
        },
})