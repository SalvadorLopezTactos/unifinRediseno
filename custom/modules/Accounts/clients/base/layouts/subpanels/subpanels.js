/**
 * Created by Levementum on 6/07/2017.
 * User: jgarcia@levementum.com
 */

({    extendsFrom: 'SubpanelsLayout',

    hide_subpanels: [],

    initialize: function (options)
    {
        this._super("initialize", [options]);
    },
    /**
     * Show the subpanel for the given linkName and hide all others
     * @param {String} linkName name of subpanel link
     */
    showSubpanel: function(linkName)
    {
        var self = this,
            //this.layout is the filter layout which subpanels is child of; we
            //use it here as it has a last_state key in its meta
            cacheKey = app.user.lastState.key('subpanels-last', this.layout);

        // wait for the model to load
        self.model.on("change", function()
        {
            // fetch the value from the model of our targeted field
            self.check_field_value = this.get( self.check_field );

            if (linkName)
            {
                app.user.lastState.set( cacheKey, linkName );
            }

            _.each(self._components, function( component )
            {
                var hide_subpanel = self._checkIfHideSubpanel( component.label );

                var link = component.context.get('link');
                if( !hide_subpanel &&
                    ( !linkName || linkName === link ) )
                {
                    component.context.set("hidden", false);
                    component.show();
                }
                else
                {
                    component.context.set("hidden", true);
                    component.hide();
                }
            });

        });
    },

    /**
     * Check if the subpanel is on the hiding list and if the watched field has a specific value.
     * @param {Boolean} subpanel name of the module for the subpanel
     */
    _checkIfHideSubpanel: function( subpanel )
    {
        var self = this;
        var hide_subpanel =  false;
        self.hide_subpanels =  [];
        if(subpanel == 'LBL_REL_RELACIONES_ACCOUNTS_FROM_REL_RELACIONES_TITLE' || subpanel == 'LBL_ACCOUNTS_OPPORTUNITIES_1_FROM_OPPORTUNITIES_TITLE'){
            self.hide_subpanels.push(subpanel);
        }

        if (( jQuery.inArray( subpanel, self.hide_subpanels ) !== -1 ))
        {
            hide_subpanel = true;
        }
        return hide_subpanel;
    },
})