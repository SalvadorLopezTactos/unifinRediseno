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
 * View for doing a quick search.
 *
 * Part of {@link View.Layouts.Base.FilterLayout}.
 *
 * @class View.Views.Base.FilterQuicksearchView
 * @alias SUGAR.App.view.views.BaseFilterQuicksearchView
 * @extends View.View
 */
({
    events: {
        'keyup': 'throttledSearch',
        'paste': 'throttledSearch'
    },

    plugins: ['QuickSearchFilter'],

    className: 'table-cell full-width',

    /**
     * @override
     * @param {Object} opts
     */
    initialize: function(opts) {
        app.view.View.prototype.initialize.call(this, opts);
        this.listenTo(this.layout, 'filter:clear:quicksearch', this.clearInput);
        this.listenTo(this.layout, 'filter:change:module', this.updatePlaceholder);

        //shortcut keys
        app.shortcuts.register('Filter:Search', ['f i','ctrl+alt+9'], function() {
            if (this.$el.is(':visible')) {
                this.$el.focus();
            }
        }, this);
    },

    /**
     * @inheritdoc
     *
     * Changes `this.$el` to point to the `<input>` element.
     */
    _renderHtml: function() {
        this._super('_renderHtml');
        this.setElement(this.$('input'));
    },

    /**
     * For customers with large datasets, allow customization to disable
     * the automatic filtering in the omnibar.
     *
     * @inheritdoc
     */
    delegateEvents: function(events) {
        if (app.config.disableOmnibarTypeahead) {
            // Remove the keyup and paste events from this.events.
            // This is before the call to this._super('delegateEvents'),
            // so they have not been registered.
            delete this.events.keyup;
            delete this.events.paste;

            // On enter key press, apply the quicksearch.
            this.events.keydown = _.bind(function(evt) {
                // Enter key code is 13
                if (evt.keyCode === 13) {
                    this.applyQuickSearch();
                }
            }, this);
        }
        this._super('delegateEvents', [events]);
    },

    /**
     * Fires the quick search.
     * @param {Event} [event] A keyup event.
     */
    throttledSearch: _.debounce(function(event) {
        this.applyQuickSearch();
    }, 400),

    /**
     * Retrieves the labels for the fields that are searchable in the
     * quicksearch.
     *
     * @param {string} moduleName The module name the fields belong to.
     * @param {string[]} fields The list of searchable fields.
     * @return {string[]} The list of labels.
     */
    getFieldLabels: function(moduleName, fields) {
        var moduleMeta = app.metadata.getModule(moduleName);
        var labels = [];

        _.each(_.flatten(fields), function(fieldName) {
            var fieldMeta = moduleMeta.fields[fieldName];
            if (fieldMeta) {
                labels.push(app.lang.get(fieldMeta.vname, moduleName).toLowerCase());
            }
        });

        return labels;
    },

    /**
     * Update quick search placeholder to Search by Field1, Field2, Field3 when the module changes
     * @param string linkModuleName
     * @param string linkModule
     */
    updatePlaceholder: function(linkModuleName, linkModule) {
        var label;
        this.toggleInput();
        if (!this.$el.hasClass('hide') && linkModule !== 'all_modules') {
            var filtersBeanPrototype = app.data.getBeanClass('Filters').prototype,
                fields = filtersBeanPrototype.getModuleQuickSearchMeta(linkModuleName).fieldNames,
                fieldLabels = this.getFieldLabels(linkModuleName, fields);
            label = app.lang.get('LBL_SEARCH_BY') + ' ' + fieldLabels.join(', ') + '...';
        } else {
            label = app.lang.get('LBL_BASIC_QUICK_SEARCH');
        }
        var input = this.$el.attr('placeholder', label);
        //Call placeholder() because IE9 does not support placeholders.
        if (_.isFunction(input.placeholder)) {
            input.placeholder();
        }
    },

    /**
     * Hide input if on Activities
     */
    toggleInput: function() {
        this.$el.toggleClass('hide', !!this.layout.showingActivities);
    },

    /**
     * Clear input
     */
    clearInput: function() {
        this.toggleInput();
        var input = this.$el.val('');
        //Call placeholder() because IE9 does not support placeholders.
        if (_.isFunction(input.placeholder)) {
            input.placeholder();
        }
        this.applyQuickSearch(true);
    },

    /**
     * Invokes the `filter:apply` event with the current value on the
     * quicksearch field.
     *
     * @param {boolean} [force] `true` to always trigger the `filter:apply`
     *   event, `false` otherwise. Defaults to `false`.
     */
    applyQuickSearch: function(force) {
        force = !_.isUndefined(force) ? force : false;
        var newSearch = this.$el.val();
        if (force || this.currentSearch !== newSearch) {
            this.currentSearch = newSearch;
            this.layout.trigger('filter:apply', newSearch);
        }
    }
})
