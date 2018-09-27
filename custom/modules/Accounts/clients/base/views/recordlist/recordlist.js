({
    extendsFrom: 'RecordlistView',

    /**
     * @author F. Javier G. Solar
     * @date 20-09-2018
     * javier.garcia@tactos.com.mx
     */


    events: {
        // 'click [className=choice-filter] ': 'test',
       // "click button.choice-filter.choice-filter-clickable": "prueba",
    },

    initialize: function (options) {
        this._super("initialize", [options]);
        // this.listenTo(this.layout, "filter:promotorAccounts", this.test);
        //this.events['click [.choice-filter.choice-filter-clickable]'] = this.test;

        // this.listenTo(this.layout, "filter:create:open", this.test);
    },


    _render: function (fields, errors, callback) {
        this._super("_render");
        filtroPromotor = [5,11,16];
        var puesto=App.user.attributes.puestousuario_c;

        if ($.inArray(puesto,filtroPromotor))
        {
            $(".choice-filter-close").attr('style', 'display:none;');
            $("#s2id_autogen1").attr('style', 'pointer-events:none;');
            $("[data-action=filter-delete]").attr('style', 'display:none;');
        }






    },


})
