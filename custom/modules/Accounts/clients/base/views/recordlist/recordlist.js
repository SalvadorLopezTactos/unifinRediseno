({
    extendsFrom: 'RecordlistView',

    /**
     * @author F. Javier G. Solar
     * @date 20-09-2018
     * javier.garcia@tactos.com.mx
     */

    initialize: function (options) {
        this._super("initialize", [options]);

    },

    _render: function (fields, errors, callback) {
        this._super("_render");

        $(".choice-filter-close").attr('style', 'display:none;');
        $("#s2id_autogen1").attr('style', 'pointer-events:none;');
        $("[data-action=filter-delete]").attr('style', 'display:none;');
    },


})
