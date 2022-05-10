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
({
    extendsFrom: 'ModuleMenuView',
    events: {
        'click [data-event]': 'handleMenuEvent',
        'click [data-route]': 'handleRouteEvent',
    },
    initialize: function (options) {
        
        this._super('initialize', [options]);
    },
    handleMenuEvent: function (evt) {
        this._super('handleMenuEvent', [evt]);
    },
    handleRouteEvent: function (evt) {
        if ($(evt.currentTarget).attr('data-navbar-menu-item') == 'LNK_LIST_POLL')
        {
            localStorage['isListPoll'] = true;
        }
        if ($(evt.currentTarget).attr('data-navbar-menu-item') == 'LNK_NEW_RECORD_POLL')
        {
            localStorage['isCreatePoll'] = true;
        }
        this._super('handleRouteEvent', [evt]);

    }
})