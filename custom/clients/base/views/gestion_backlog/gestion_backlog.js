/**
 * Created by salvadorlopez salvador.lopez@tactos.com.mx
 */
({
    meses_list_html : null,
    anio_list_html_filter : null,
    etapa_list_html : null,
    producto_list_html : null,

    initialize: function(options){
        self=this;

        this._super("initialize", [options]);

        this.etapa_list_html = app.lang.getAppListStrings('etapa_c_list');
        this.etapa_list_html[''] = "";

        this.producto_list_html = {};
		this.producto_list_html["0"] = "Todos";
        this.producto_list_html["1"] = "Leasing";
		this.producto_list_html["2"] = "Crédito Simple";
    },

    _render: function () {
        this._super("_render");
    },

    loadData: function (options) {
        if (_.isUndefined(this.model)) {
            return;
        }
        var self = this;
        this.meses_list_html = app.lang.getAppListStrings('mes_list');
        this.meses_list_html[""]="Todos";
        var anio_list = app.lang.getAppListStrings('anio_list');
        var currentYear = new Date().getFullYear();
        Object.keys(anio_list).forEach(function(key){
          if(key < currentYear-2) {
            delete anio_list[key];
          }
        });
        this.anio_list_html_filter = anio_list;
        var anio_actual = (new Date).getFullYear();
        
    },
})
