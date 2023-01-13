({
    initialize: function(options) {
        this._super('initialize', [options]);
        Oproductos = this;
        Oproductos.productos = [];
    },

    _render: function () {
        this._super("_render");
  
        if($('[data-fieldname="cuenta_productos"] > span').length >0){
          $('[data-fieldname="cuenta_productos"] > span').show();
        }
    },
})