({
    extendsFrom: 'SelectionListView',

    initialize: function(options) {
        this._super('initialize', [options]);
    },

    _render: function (options) {
        this._super("_render");
        if((this.context.parent.get('module')=='Tasks' || this.context.parent.get('module')=='Accounts') && $('input[value="filterSolicitudTemplate"]').val()=='filterSolicitudTemplate'){
            //Ocultando ícono que elimina filtro
            $('.choice-filter-close').hide();
            $('.choice-filter-label').parent('.choice-filter-clickable').attr('style','pointer-events:none');
            $('.select2-choices').attr('style','pointer-events:none');
            $('[data-filter="operator"]').attr('style','pointer-events:none');
            $('[data-filter="field"]').attr('style','pointer-events:none');
            $(".select2").hide();
            $(".filter-definition-container").hide();
        }
    },

   _dispose: function() {
        this._super('_dispose');
        $(".select2").show();
        $("filter-definition-container").show();
        $('[name="parent_type"]').hide();
   },
})