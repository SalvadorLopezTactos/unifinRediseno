({
    plugins: ['Dashlet'],

    events: {
        'click .fa-star':'setFavorite',
    },

    registrosKanbanClientes:null,

    initialize: function (options) {
        this._super("initialize", [options]);
        contextoKanbanClientes=this;
    },

    _render: function () {
        this._super("_render");
    },

    setFavorite:function(e){
        var id=$(e.currentTarget).attr('data-id');
        var estilo=$(e.currentTarget).attr('style');
        var modulo=$(e.currentTarget).attr('data-modulo');

        if(estilo==undefined){//Establece como favorito
            $(e.currentTarget).attr('style','color: #3399FF');
            App.alert.show('setFavorite', {
                level: 'process',
                title: 'Estableciendo favorito',
            });
    
            app.api.call('update', app.api.buildURL(modulo+'/'+id+'/favorite'), null, {
                success: function (data) {
                    App.alert.dismiss('setFavorite');    
                    //self.render();
                },
                error: function (e) {
                    throw e;
                }
            });
            
        }else{//Quita favorito
            $(e.currentTarget).removeAttr('style');
            App.alert.show('quitFavorite', {
                level: 'process',
                title: 'Quitando favorito',
            });
    
            app.api.call('update', app.api.buildURL(modulo+'/'+id+'/unfavorite'), null, {
                success: function (data) {
                    App.alert.dismiss('quitFavorite');
                    //self.render();
                },
                error: function (e) {
                    throw e;
                }
            });
        }
        

    }

})