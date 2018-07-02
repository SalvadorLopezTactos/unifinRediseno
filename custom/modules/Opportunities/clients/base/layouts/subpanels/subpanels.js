({
    extendsFrom: 'SubpanelsLayout',
    /**
     * @override
     */
    initialize: function(opts) {
        this._super('initialize', [opts]);
    },

    /**
     * override to hide the subpanel
     * @param {String} linkName name of subpanel link
     */
    showSubpanel: function(linkName) {

        this._super('showSubpanel', [linkName]);

        _.each(this._components, function(component) {

            var link = component.context.get('link');

            if (link == 'revenuelineitems')
            {
                component.context.set("hidden", true);
                component.hide();
            }
        });
    }

})
