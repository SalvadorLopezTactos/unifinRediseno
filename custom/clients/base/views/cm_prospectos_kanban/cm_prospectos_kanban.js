({
    plugins: ['Dashlet'],

    events: {
        'click .contenedor-item': 'muestraChecklist',
    },

    initialize: function (options) {
        this._super("initialize", [options]);
        self=this;
        this.getRegistrosKanban();
    },

    getRegistrosKanban: function () {

        App.alert.show('getRecordsKanban', {
            level: 'process',
            title: 'Cargando',
        });

        app.api.call('GET', app.api.buildURL('GetCMInfoKanban'), null, {
            success: function (data) {
                App.alert.dismiss('getRecordsKanban');
                self.registrosKanban=data;

                self.render();
            },
            error: function (e) {
                throw e;
            }
        });

    },

    _render: function () {
        this._super("_render");
        $('.contenedor-grid').attr('style','grid-template-columns: repeat(8, 1fr)')
    },

    muestraChecklist:function(e){
        $('.checklist-item').removeClass('hide');
    }


})