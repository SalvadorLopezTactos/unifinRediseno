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
    plugins: ['ShortcutSession'],

    shortcuts: ['Shortcuts:Help:Close'],

    events: {
        'click [name=cancel_button]': 'close'
    },

    shortcutsHelpTableTemplate: '',

    initialize: function(options) {
        app.view.Layout.prototype.initialize.call(this, options);

        // get templates
        this.shortcutsHelpTableTemplate = app.template.getLayout(this.name + '.shortcuts-help-table');

        // populate help tables
        this.$('[data-display=global]').append(this.buildGlobalHelpTable().children());
        this.$('[data-display=contextual]').append(this.buildContextualHelpTable().children());

        app.shortcuts.register('Shortcuts:Help:Close', ['esc', 'ctrl+alt+l'], function() {
            this.close();
        }, this);
    },

    /**
     * Close drawer.
     */
    close: function() {
        app.drawer.close();
    },

    /**
     * Build the help table for global shortcuts.
     * @return {jQuery}
     */
    buildGlobalHelpTable: function() {
        var $html = $('<div></div>'),
            globalShortcuts = app.shortcuts.getRegisteredGlobalShortcuts(),
            help = this.prepareShorcutsHelpDataForDisplay(globalShortcuts);

        $html.append(this.shortcutsHelpTableTemplate(help));

        return $html;
    },

    /**
     * Build the help table for contextual shortcuts.
     * @return {jQuery}
     */
    buildContextualHelpTable: function() {
        var $html = $('<div></div>'),
            lastShortcutSession = app.shortcuts.getLastSavedSession(),
            contextualShortcuts,
            help;

        if (lastShortcutSession) {
            contextualShortcuts = lastShortcutSession.getRegisteredShortcuts();
            if (contextualShortcuts) {
                help = this.prepareShorcutsHelpDataForDisplay(contextualShortcuts);
                $html.append(this.shortcutsHelpTableTemplate(help));
            }
        }

        return $html;
    },

    /**
     * Take the available shortcuts data and transform it for displaying the data
     * in a help table.
     * @param {Array} shortcuts
     * @return {Array}
     */
    prepareShorcutsHelpDataForDisplay: function(shortcuts) {
        // FIXME SC-5196: deprecate me, I'm misspelled
        var help = [];

        _.each(shortcuts, function(shortcut) {
            help.push({
                keys: this.getKeyString(shortcut.keys),
                help: this.getHelpString(shortcut.id)
            });
        }, this);

        return help;
    },

    /**
     * Build text for keys needed to perform shortcut action.
     * @param {Array} keys
     * @return {string}
     */
    getKeyString: function(keys) {
        return keys.join(', ');
    },

    /**
     * Build the help text for what the shortcut does.
     * @param {String} shortcutId
     * @return {string}
     */
    getHelpString: function(shortcutId) {
        if (this.meta.help && this.meta.help[shortcutId]) {
            return app.lang.get(this.meta.help[shortcutId]);
        } else {
            return '';
        }
    },

    loadData: function(options) {}
})
