({
        extendsFrom: 'CreateView',

        initialize: function (options) {
            self = this;
            this._super("initialize", [options]);
            this.on('render',this.disableparentsfields,this);

        },

        _render: function () {
            this._super("_render");
            this.hide_subpanel();
        },

        /* @Jesus Carrillo
           Oculta el subpanel del boton dropdow
         */
        hide_subpanel: function () {
            var subpanel = this.getField("save_invite_button");
            if (subpanel) {
                subpanel.listenTo(subpanel, "render", function () {
                    subpanel.hide();
                });
            }
        },

        /* @Alvador Lopez Y Adrian Arauz
           Oculta los campos relacionados
         */
        disableparentsfields:function () {
            if(this.createMode){//Evalua si es la vista  de creacion
                if(this.model.get('parent_id')!=undefined){
                    this.$('[data-name="parent_name"]').attr('style','pointer-events:none;')
                }
            }
        },
})