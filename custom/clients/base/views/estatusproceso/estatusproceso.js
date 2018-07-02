({
    plugins: ['Dashlet'],

    process: function(){
        return this.model.get("id_process_c");
    },
    user: function(){
        return app.user.get('user_name');
    },
    initialize: function(options){
        this._super("initialize", [options]);

    },

    loadData: function (options) {
        if(_.isUndefined(this.model)){
            return;
        }
        var ticker = this.model.get("id_process");
        var operacion = this.model.toJSON();
        if (_.isEmpty(ticker)) {
            return;
        }
        this.render();
    },

    _renderHtml: function(){
        app.view.View.prototype._renderHtml.call(this);
        carga();
    }
})