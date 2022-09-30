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
                contextoRanking.posicion_operativa=App.user.attributes.posicion_operativa_c;

                contextoRanking.directorEquipo=null;
                contextoRanking.directorRegional=null;

                contextoRanking.posicion_operativa.includes('^1^') ? contextoRanking.directorEquipo=true : contextoRanking.directorEquipo=null;
                contextoRanking.posicion_operativa.includes('^2^') ? contextoRanking.directorRegional=true : contextoRanking.directorRegional=null;

                contextoRanking.render();
            },
            error: function (e) {
                throw e;
            }
        });
    }

})