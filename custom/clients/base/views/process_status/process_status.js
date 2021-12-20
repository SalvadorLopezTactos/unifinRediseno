/**
 * Created by salvadorlopez on 02/03/18.
 */
({
    plugins: ['Dashlet'],

    initialize: function(options){
        this._super("initialize", [options]);

    },

    process: function(){
        return this.model.get("id_process_c");
    },

    user: function(){
        return app.user.get('user_name');
    },

});
