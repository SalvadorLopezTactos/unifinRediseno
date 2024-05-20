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
 * @class View.Fields.Base.CalendarHtmleditableTinymceField
 * @alias SUGAR.App.view.fields.BaseCalendarHtmleditableTinymceField
 * @extends View.Fields.Base.BaseHtmleditableTinymceField
 */
 ({
    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        // The plugin 'insertfield' needs to be aplied again to show fields of the current module
        this.listenTo(this.model, 'change:calendar_module', _.bind(this.render, this));
    },

    /**
     * @override
     */
    getTinyMCEConfig: function() {
        var getConfig = this._super('getTinyMCEConfig') || {};

        getConfig.plugins += ',insertfield_calendar';
        getConfig.toolbar += ' insertfield_calendar';
        getConfig.sugarField = this;

        if (getConfig.sugarField.fieldDefs.name == 'ical_event_template') {
            getConfig.toolbar = 'insertfield_calendar';
        }
        return getConfig;
    }
});
