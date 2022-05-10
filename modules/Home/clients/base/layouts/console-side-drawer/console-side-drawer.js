/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
/**
 * @class View.Layouts.Home.ConsoleSideDrawerLayout
 * @alias SUGAR.App.view.layouts.HomeConsoleSideDrawerLayout
 * @extends View.Layouts.Base.SideDrawerLayout
 */
({
    extendsFrom: 'SideDrawerLayout',

    /**
     * @inheritdoc
     * Add actions.
     */
    events: {
        'click [data-action=close]': 'close'
    },

    /**
     * Flag indicating if close and edit actions may be performed or not at the moment.
     * @property {boolean}
     */
    areActionsEnabled: true,

    /**
     * Flag indicating that Focus Drawer icons shouldn't show in this layout
     */
    disableFocusDrawer: true,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.initComponentVariables();
        this.bindEvents();
    },

    /**
     * Stores the close and dashlet buttons on the component so they would be accessible easier.
     */
    initComponentVariables: function() {
        this.$closeButton = $(this.$el.children()[1]);
    },

    /**
     * Initiates listening to application events.
     */
    bindEvents: function() {
        app.events.on('drawer:enable:actions', this.enableButtonActions, this);
    },

    /**
     * Close only if the action is enabled.
     */
    close: function() {
        if (this.areActionsEnabled) {
            this._super('close');
        }
    },
})
