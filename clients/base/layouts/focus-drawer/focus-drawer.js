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
 * @class View.Layouts.Base.FocusDrawerLayout
 * @alias SUGAR.App.view.layouts.BaseFocusDrawerLayout
 * @extends View.Layouts.Base.SideDrawerLayout
 */
({
    extendsFrom: 'SideDrawerLayout',

    /**
     * @inheritdoc
     * Add actions.
     */
    events: {
        'click [data-action=close]': 'close',
    },

    /**
     * Flag indicating if close and edit actions may be performed or not at the moment.
     * @property {boolean}
     */
    areActionsEnabled: true,

    /**
     * Stores the context loaded in the drawer
     */
    currentContextDef: null,

    /**
     * {@inheritdoc}
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.bindEvents();
    },

    /**
     * Initiates listening to application events.
     */
    bindEvents: function() {
        app.events.on('drawer:enable:actions', this.enableButtonActions, this);
    },

    /**
     * @inheritdoc
     *
     */
    open: function(def, onClose) {
        this._super('open', [def, onClose]);
        this.currentContextDef = def;
    },

    /**
     * Close only if the action is enabled.
     */
    close: function() {
        if (this.areActionsEnabled) {
            this._super('close');
            this.currentContextDef = null;
        }
    },
})
