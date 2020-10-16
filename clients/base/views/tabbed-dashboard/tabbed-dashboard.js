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
 * @class View.Views.Base.TabbedDashboardView
 * @alias SUGAR.App.view.views.BaseTabbedDashboardView
 * @extends View.View
 */
({
    events: {
        'click [data-toggle=tab]': 'tabClicked',
    },

    activeTab: 0,
    tabs: [],

    /**
     * Hash key for stickness.
     * @property {string}
     */
    lastStateKey: '',

    /**
     * Initialize this component.
     * @param {Object} options Initialization options.
     * @param {Object} options.meta Metadata.
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this._initTabs(options.meta);
    },

    /**
     * Build the cache key for last visited tab.
     *
     * @return {string} hash key.
     */
    getLastStateKey: function() {
        if (this.lastStateKey) {
            return this.lastStateKey;
        }

        var modelId = this.model.get('id');
        this.lastStateKey = modelId ? modelId + '.' + 'last_tab' : '';
        return this.lastStateKey;
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this.context.on('tabbed-dashboard:update', this._setTabs, this);
        this.model.on('setMode', this._setMode, this);
    },

    /**
     * Check if a tab is dashboard.
     *
     * @param {number} tabIndex The tab's index
     * @return {bool} True if tab is a dashboard, otherwise false
     * @private
     */
    _isDashboardTab: function(tabIndex) {
        if (_.isEmpty(this.tabs)) {
            return true;
        }
        tabIndex = _.isUndefined(tabIndex) ? this.activeTab : tabIndex;
        return !_.isUndefined(this.tabs[tabIndex].components.rows);
    },

    /**
     * Switch the active dashboard based on the clicked tab.
     * @param {Event} event Click event.
     */
    tabClicked: function(event) {
        var index = this.$(event.currentTarget).data('index');
        if (index === this.activeTab) {
            return;
        }
        // can't edit a non-dashboard tab
        if (this.model.mode === 'edit' && !this._isDashboardTab(index)) {
            event.stopPropagation();
            return;
        }
        this.context.trigger('tabbed-dashboard:switch-tab', index);
    },

    /**
     * Handle button events.
     *
     * @param {string} state Button state
     * @private
     */
    _setMode: function(state) {
        if (_.isEmpty(this.tabs)) {
            return;
        }
        _.each(this.tabs, function(tab, index) {
            if (index !== this.activeTab && !this._isDashboardTab(index)) {
                var $tab = this.$('a[data-index="' + index + '"]').closest('.tab');
                if (state === 'edit') {
                    // disable non-dahsboard tabs
                    $tab.addClass('disabled');
                } else if (state === 'view') {
                    // enable non-dahsboard tabs
                    $tab.removeClass('disabled');
                }
            }
        }, this);
    },

    /**
     * Initialize tabs.
     * @param {Object} [options={}] Tab options.
     * @private
     */
    _initTabs: function(options) {
        options = options || {};
        var lastStateKey = this.getLastStateKey();
        var lastVisitTab = lastStateKey ? app.user.lastState.get(lastStateKey) : 0;

        if (!_.isUndefined(options.activeTab)) {
            this.activeTab = options.activeTab;
            if (lastStateKey) {
                app.user.lastState.set(lastStateKey, this.activeTab);
            }
        } else if (!_.isUndefined(lastVisitTab)) {
            this.activeTab = lastVisitTab;
        }

        if (!_.isUndefined(options.tabs)) {
            this.tabs = options.tabs;
            this.context.set('tabs', this.tabs);
            this.context.set('activeTab', this.activeTab);
            this._initTabBadges();
        }
    },

    /**
     * Initialize tab badges.
     * @private
     */
    _initTabBadges: function() {
        var modelId = this.context.get('modelId');
        var configMeta = app.metadata.getModule('ConsoleConfiguration');

        if (this.tabs && configMeta) {
            _.each(this.tabs, function(tab) {
                if (!_.isUndefined(tab.badges)) {
                    _.each(tab.badges, function(badge) {
                        if (badge.type === 'record-count' && badge.module === 'Cases') {
                            badge.filter = _.union(
                                [
                                    {follow_up_datetime: _.first(_.pluck(badge.filter, 'follow_up_datetime'))}
                                ],
                                configMeta.config.filter_def[modelId][badge.module]
                            );
                        }
                    });
                }
            });
        }
    },

    /**
     * Set tab options, then re-render.
     * @param {Object} [options] Tab options.
     * @private
     */
    _setTabs: function(options) {
        this._initTabs(options);
        this.render();
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        this._super('_render');
        if (this.model.mode === 'edit') {
            this._setMode('edit');
        }
    }
})
