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
 * Header section for Subpanel layouts.
 *
 * @class View.Views.Base.PanelTopView
 * @alias SUGAR.App.view.views.BasePanelTopView
 * @extends View.View
 */
({
    /**
     * @inheritDoc
     */
    className: 'subpanel-header',

    /**
     * @inheritDoc
     */
    attributes: {
        'data-sortable-subpanel': 'true'
    },

    /**
     * @inheritDoc
     */
    events: {
        'click': 'togglePanel',
        'click a[name=create_button]:not(".disabled")': 'createRelatedClicked',
    },

    plugins: ['LinkedModel'],

    /**
     * @override
     * @param opts
     */
    initialize: function(opts) {
        app.view.View.prototype.initialize.call(this, opts);
        var context = this.context;
        // This is in place to get the lang strings from the right module. See
        // if there is a better way to do this later.
        this.parentModule = context.parent.get('module');
        context.parent.on('panel-top:refresh', function(link) {
            if (context.get('link') === link) {
                context.get('collection').fetch();
            }
        });
    },

    /**
     * Event handler for the create button.
     *
     * @param {Event} event The click event.
     */
    createRelatedClicked: function(event) {
        this.createRelatedRecord(this.module)
    },

    /**
    * Event handler that closes the subpanel layout when the SubpanelHeader is clicked
    * @param e DOM event
    */
    togglePanel: function(e) {
        // Make sure we aren't toggling the panel when the user clicks on a dropdown action.
        var toggleSubpanel = !$(e.target).parents("span.actions").length;
        if (toggleSubpanel) {
            this._toggleSubpanel();
        }
    },

    _toggleSubpanel: function() {
        if(!this.layout.disposed) {
            var isHidden = this.layout.$(".subpanel").hasClass('closed');
            this.layout.trigger('panel:toggle', isHidden);
        }
    },

    /**
     * @override
     */
    bindDataChange: function() {
        if (this.collection) {
            this.listenTo(this.collection, 'reset', this.render);
        }
    }
})
