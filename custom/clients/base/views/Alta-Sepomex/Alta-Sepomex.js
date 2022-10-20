({

    className: 'Alta-Sepomex',

    events: {
        'click .openModalCheckCP': 'openModalCheckCP',
        'click .closemodalCheckCP': 'closeModalCheckCP',
    },

    initialize: function(options){
        this._super("initialize", [options]);

    },

    _render: function () {
        this._super("_render");
        $(".openModalCheckCP").trigger('click');
    },

    openModalCheckCP:function(){
        var modal = $('#modalCheckCP');
        if (modal) {
            modal.show();
        }
    },

    closeModalCheckCP:function(){
        var modal = $('#modalCheckCP');
        if (modal) {
            modal.hide();
        }
    }


})
