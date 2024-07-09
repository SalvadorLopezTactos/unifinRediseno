({
    extendsFrom: 'SidebarNavLayout',

    _render: function() {
        this._super('_render');
        this.replaceActiveDirectory();
    },

    replaceActiveDirectory: function( ){
        if( !_.isEmpty(App.user.attributes) ){

            //Reemplazando idActiveDirectory de route principal 
            var currentRouteQuantico = this.meta.components[3].layout.components[0].view.route;
            var newRouteQuantico = currentRouteQuantico.replace('AD_REPLACE', App.user.attributes.id_active_directory_c);
            this.meta.components[3].layout.components[0].view.route = newRouteQuantico;

            if( this.meta.components[3].layout.components[0].view.flyoutComponents.length > 0 ){
                for (let index = 0; index < this.meta.components[3].layout.components[0].view.flyoutComponents.length; index++) {
                    var currentRoute = this.meta.components[3].layout.components[0].view.flyoutComponents[index].view.actions[0].route;
                    
                    var newRoute = currentRoute.replace('AD_REPLACE', App.user.attributes.id_active_directory_c);
                    this.meta.components[3].layout.components[0].view.flyoutComponents[index].view.actions[0].route = newRoute;
                    
                }
            }
        }


    }
})