({
    extendsFrom: 'RecordView',

    initialize: function (options) {
        self = this;
        this._super("initialize", [options]);

        /*@Jesus Carrillo
            Funcion que pinta de color los paneles relacionados
        */
        this.model.on('sync', this.fulminantcolor, this);

    },

    /*@Jesus Carrillo
        Funcion que pinta de color los paneles relacionados
    */
    fulminantcolor: function () {
        $( '#space' ).remove();
        $('.control-group').before('<div id="space" style="background-color:#000042"><br></div>');
        $('.control-group').css("background-color", "#e5e5e5");
        $('.a11y-wrapper').css("background-color", "#e5e5e5");
        //$('.a11y-wrapper').css("background-color", "#c6d9ff");
    },

})
