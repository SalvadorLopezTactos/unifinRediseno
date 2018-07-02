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
 * Actions for {@link View.Views.Base.FilterRowsView}.
 *
 * Part of {@link View.Layouts.Base.FilterpanelLayout}.
 *
 * @class View.Views.Base.FilterActionsView
 * @alias SUGAR.App.view.views.BaseFilterActionsView
 * @extends View.View
 */
({
    events: {
        'change input': 'filterNameChanged',
        'keyup input': 'filterNameChanged',
        'click a.reset_button': 'triggerReset',
        'click a.filter-close': 'triggerClose',
        'click a.save_button:not(.disabled)': 'triggerSave',
        'click a.delete_button:not(.hide)': 'triggerDelete'
    },

    className: 'filter-header',

    /**
     * @type {Boolean} `true` if the button is enabled, `false` otherwise.
     */
    saveState: false,

    /**
     * @type {Boolean} Whether or not to display the filter action buttons.
     */
    showActions: true,

    /**
     * @{inheritDoc}
     */
    initialize: function(opts) {
        this._super('initialize', [opts]);

        this.layout.on('filter:create:open', function(model) {
            this.toggle(model);
            var name = model ? model.get('name') : '';
            this.setFilterName(name);

            //shortcut keys
            app.shortcuts.register(
                'Filter:Close',
                ['esc', 'ctrl+alt+l'],
                function() {
                    this.$('a.filter-close').click();
                },
                this,
                true
            );
            app.shortcuts.register(
                'Filter:Save',
                ['ctrl+s', 'ctrl+alt+a'],
                function() {
                    this.$('a.save_button:not(.disabled)').click();
                },
                this,
                true
            );
            app.shortcuts.register('Filter:Delete', 'd', function() {
                this.$('a.delete_button:not(.hide)').click();
            }, this);
            app.shortcuts.register('Filter:Reset', 'r', function() {
                this.$('a.reset_button').click();
            }, this);
        }, this);

        this.listenTo(this.layout, 'filter:toggle:savestate', this.toggleSave);
        this.listenTo(this.layout, 'filter:set:name', this.setFilterName);
        this.listenTo(this.context, 'change:filterOptions', this.render);

        this.before('render', this.setShowActions, null, this);
    },

    /**
     * This function sets the `showActions` object on the controller.
     * `true` when `show_actions` is set to `true` on the `filterOptions`
     * object on the context (originating from filterpanel metadata),
     * `false` otherwise.
     */
    setShowActions: function() {
        var filterOptions = this.context.get('filterOptions') || {};
        this.showActions = !!filterOptions.show_actions;
    },

    /**
     * Get the filter name.
     *
     * @return {String} The value of the input.
     */
    getFilterName: function() {
        return this.$('input').val();
    },

    /**
     * Shows or hides this view.
     *
     * This view will be hidden when the filter is a template that is populated
     * on the fly.
     *
     * @param {Data.Bean} filter The filter being edited.
     */
    toggle: function(filter) {
        this.$el.toggleClass('hide', !!filter.get('is_template'));
    },

    /**
     * Set input value and hide the delete button if we're clearing the name.
     *
     * @param {String} name The filter name.
     */
    setFilterName: function(name) {
        var input = this.$('input').val(name);
        //Call placeholder() because IE9 does not support placeholders.
        if (_.isFunction(input.placeholder)) {
            input.placeholder();
        }
        // We have this.context.editingFilter if we're setting the name.
        this.toggleDelete(!_.isEmpty(name));
    },

    /**
     * Fired when the filter name changed.
     *
     * @param {Event} event The `change` event.
     */
    filterNameChanged: _.debounce(function(event) {
        if (this.disposed || !this.context.editingFilter) {
            return;
        }

        var name = this.getFilterName();
        this.context.editingFilter.set('name', name);
        this.layout.trigger('filter:toggle:savestate', true);

        if (this.layout.getComponent('filter-rows')) {
            this.layout.getComponent('filter-rows').saveFilterEditState();
        }
    }, 200),

    /**
     * Toggle delete button.
     *
     * @param {Boolean} enable `true` to enable the button, `false` otherwise.
     */
    toggleDelete: function(enable) {
        this.$('.delete_button').toggleClass('hide', !enable);
    },

    /**
     * Toggle save button.
     *
     * @param {Boolean} enable `true` to enable the button, `false` otherwise.
     */
    toggleSave: function(enable) {
        this.saveState = _.isUndefined(enable) ? !this.saveState : !!enable;
        var isEnabled = this.getFilterName() && this.saveState;
        this.$('.save_button').toggleClass('disabled', !isEnabled);
    },

    /**
     * Handler for canceling form editing.
     *
     * First, it will revert model attributes (back to synced attributes), and
     * remove the current edit state.
     * Second,
     * - if the filter has changed, the collection is refreshed.
     * - if we were creating a new filter, the cached selected filter id is
     * cleared (so that we will get back to the default filter), otherwise we
     * just close the form.
     *
     * @triggers filter:apply to apply the previous filter definition.
     * @triggers filter:select:filter to switch back to the default filter.
     * @triggers filter:create:close to close the filter creation form.
     */
    triggerClose: function() {
        var filter = this.context.editingFilter,
            filterLayout = this.layout.getComponent('filter'),
            id = filter.get('id'),
            changedAttributes = filter.changedAttributes(filter.getSyncedAttributes());
            filter.revertAttributes();

        filterLayout.clearFilterEditState();

        //Apply the previous filter definition if something has changed meanwhile
        if (changedAttributes && changedAttributes.filter_definition) {
            this.layout.trigger(
                /**
                 * @event
                 * See {@link View.Layouts.Base.FilterPanelLayout#filter:apply}.
                 */
                'filter:apply', null, filter.get('filter_definition'));
        }
        if (!id) {
            filterLayout.clearLastFilter(this.layout.currentModule, filterLayout.layoutType);
            filterLayout.trigger(
                /**
                 * @event
                 * See {@link View.Layouts.Base.FilterLayout#filter:select:filter}.
                 */
                'filter:select:filter', filterLayout.filters.collection.defaultFilterFromMeta);
            return;
        }
        this.layout.trigger(
            /**
             * @event
             * See {@link View.Layouts.Base.FilterLayout#filter:create:close}.
             */
            'filter:create:close');
    },

    /**
     * Call a method on filter-rows to reset filter values.
     */
    triggerReset: function() {
        this.layout.getComponent('filter-rows').resetFilterValues();
    },

    /**
     * Trigger `filter:create:save` to save the created filter.
     */
    triggerSave: function() {
        var filterName = this.getFilterName();
        this.context.trigger('filter:create:save', filterName);
    },

    /**
     * Trigger `filter:create:delete` to delete the created filter.
     */
    triggerDelete: function() {
        this.layout.trigger('filter:create:delete');
    }
})
