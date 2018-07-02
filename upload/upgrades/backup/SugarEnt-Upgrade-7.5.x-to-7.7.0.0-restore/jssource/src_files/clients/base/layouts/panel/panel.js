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
 * @class View.Layouts.Base.PanelLayout
 * @alias SUGAR.App.view.layouts.BasePanelLayout
 * @extends View.Layout
 */
({
    /**
     * @inheritDoc
     */
    className: 'filtered tabbable tabs-left',

    /**
     * @inheritDoc
     */
    attributes: function() {
        return {
            'data-subpanel-link': this.options.context.get('link')
        };
    },

    // "Hide/Show" state per panel
    HIDE_SHOW_KEY: 'hide-show',
    HIDE_SHOW: {
        HIDE: 'hide',
        SHOW: 'show'
    },

    /**
     * @override
     * @param {Object} opts
     */
    initialize: function(opts) {
        app.view.Layout.prototype.initialize.call(this, opts);

        this.hideShowLastStateKey = app.user.lastState.key(this.HIDE_SHOW_KEY, this);

        this.on("panel:toggle", this.togglePanel, this);
        this.listenTo(this.collection, "reset", function() {
            //Update the subpanel to be open or closed depending on how user left it last
            var hideShowLastState = app.user.lastState.get(this.hideShowLastStateKey);
            if(_.isUndefined(hideShowLastState)) {
                this.togglePanel(this.collection.length > 0, false);
            } else {
                this.togglePanel(hideShowLastState === this.HIDE_SHOW.SHOW, false);
            }
        });
        //Decorate the subpanel based on if the collection is empty or not
        this.listenTo(this.collection, "reset add remove", this._checkIfSubpanelEmpty, this);
    },
    /**
     * Check if subpanel collection is empty and decorate subpanel header appropriately
     * @private
     */
    _checkIfSubpanelEmpty: function(){
        this.$(".subpanel").toggleClass("empty", this.collection.length === 0);
    },
    /**
     * Places layout component in the DOM.
     * @override
     * @param {Component} component
     */
    _placeComponent: function(component) {
        this.$(".subpanel").append(component.el);
        this._hideComponent(component, false);
    },
    /**
     * Toggles panel
     * @param {Boolean} show TRUE to show, FALSE to hide
     * @param {Boolean} saveState(optional) TRUE to save the current state
     */
    togglePanel: function(show, saveState) {
        this.$(".subpanel").toggleClass("closed", !show);
        //check if there's second param then check it and save show/hide to user state
        if(arguments.length === 1 || saveState) {
            app.user.lastState.set(this.hideShowLastStateKey, show ? this.HIDE_SHOW.SHOW : this.HIDE_SHOW.HIDE);
        }
        _.each(this._components, function(component) {
            this._hideComponent(component, show);
        }, this);
    },
    /**
     * Show or hide component except `panel-top`(subpanel-header) component.
     * @param {Component} component
     */
    _hideComponent: function(component, show) {
        if (!component.$el.hasClass('subpanel-header')) {
            if (show) {
                component.show();
            } else {
                component.hide();
            }
        }
    }
})
