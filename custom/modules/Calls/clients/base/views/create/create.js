({
        extendsFrom: 'CreateView',

        initialize: function (options) {
		    this.plugins = _.union(this.plugins || [], ['AddAsInvitee', 'ReminderTimeDefaults']);
            self = this;
            this._super("initialize", [options]);
            this.on('render',this.disableparentsfields,this);
           // this.on('render',this.disabledates,this);
        },

        _render: function () {
            this._super("_render");
            this.hide_subpanel();
            this.disabledates();
        },

        /* @Jesus Carrillo
           Oculta el subpanel del boton dropdown y campos de fechas
         */
        hide_subpanel: function () {
            var subpanel = this.getField("save_invite_button");
            if (subpanel) {
                subpanel.listenTo(subpanel, "render", function () {
                    subpanel.hide();
                });
            }
        },
        disabledates:function () {
            console.log(App.user.attributes.puestousuario_c);
            if(App.user.attributes.puestousuario_c!='27' && App.user.attributes.puestousuario_c!='31' ) {
               this.$('div[data-name="tct_fecha_cita_dat_c"]').hide();
               $('div[data-name="tct_usuario_cita_rel_c"]').hide();
                console.log('SE ocultaron');
            }else{
                this.$('div[data-name="tct_fecha_cita_dat_c"]').show();
                $('div[data-name="tct_usuario_cita_rel_c"]').show();
                console.log('SE mostraron');
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