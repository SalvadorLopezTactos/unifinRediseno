({
    plugins: ['Dashlet'],

    events: {
        
    },

    initialize: function (options) {
        this._super("initialize", [options]);
        contextoRanking=this;
        this.getRankingBL();
    },

    _render: function () {
        this._super("_render");
    },

    getRankingBL:function(){
        contextoKanban=this;
        App.alert.show('getRankingBL', {
            level: 'process',
            title: 'Cargando',
        });

        app.api.call('GET', app.api.buildURL('getBacklogDirector'), null, {
            success: function (data) {
                App.alert.dismiss('getRankingBL');
                contextoRanking.registrosRankingBL=data;

                contextoRanking.render();
            },
            error: function (e) {
                throw e;
            }
        });
    }

})