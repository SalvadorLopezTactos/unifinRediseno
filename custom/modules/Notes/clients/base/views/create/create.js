({
    extendsFrom: 'CreateView',

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);
        this.on('render',this.disableparentsfields,this);
        this.on('render', this.showMinutarel, this);

    },

    _render: function () {
        this._super("_render");


    },
    
    showMinutarel:function(){
        if(this.model.get('relacion_nota_minuta_c')=='' || this.model.get('relacion_nota_minuta_c')==undefined
            || this.model.get('relacion_nota_minuta_c')=='Sin Datos'){
            $('div[data-name=relacion_nota_minuta_c]').hide();
        }
    },

    /* @Alvador Lopez Y Adrian Arauz
    Oculta los campos relacionados
    */
    disableparentsfields:function () {
        if(this.createMode){//Evalua si es la vista de creacion
            if(this.model.get('parent_id')!=undefined){
                this.$('[data-name="parent_name"]').attr('style','pointer-events:none;')
            }
        }
    },


})