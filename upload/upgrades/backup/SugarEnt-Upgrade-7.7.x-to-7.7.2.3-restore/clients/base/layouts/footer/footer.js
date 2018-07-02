/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Layouts.Base.FooterLayout
 * @alias SUGAR.App.view.layouts.BaseFooterLayout
 * @extends View.Layout
 */
({
    events: {
        'click [data-action=home]': 'home'
    },
    /**
     * Places all components within this layout inside btn-toolbar div
     * @param component
     * @private
     */
    _placeComponent: function(component) {
        this.$el.find('.btn-toolbar').append(component.$el);
    },

    /**
     * @override
     * @private
     */
    _render: function() {
        this.logoUrl = app.metadata.getLogoUrl();
        //For a layout we need to
        this.$el.html(this.template(this));
        _.each(this._components, function(component) {
            this._placeComponent(component);
        }, this);
        app.view.Layout.prototype._render.call(this);
    },

    home: function() {
        app.router.navigate('#Home', {
            trigger: true
        });
    }
})
