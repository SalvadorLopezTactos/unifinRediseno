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
 * The dashboard container of the Omnichannel console.
 *
 * @class View.Layouts.Base.OmnichannelDashboardLayout
 * @alias SUGAR.App.view.layouts.BaseOmnichannelDashboardLayout
 * @extends View.Layout
 */
({
    className: 'omni-dashboard dashboard-pane',

    /**
     * Maps the module to the appropriate tab index
     */
    moduleTabIndex: {
        Contacts: 1,
        Cases: 2,
    },

    /**
     * Context models for tabs.
     * @property {Array}
     */
    tabModels: [],

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.tabModels = [];
        // this tells dashboard controller which dashboard to load
        this.context.set('layout', 'omnichannel');
        this.context.set('module', 'Dashboards');
        this.context = this._getContext();

        this.before('tabbed-dashboard:switch-tab', function(params) {
            return this.triggerBefore('omni-dashboard:content-changed', {callback: params.callback});
        }, this);
    },

    /**
     * Util method to get context for layout
     *
     * @return {Object} context for layout
     * @private
     */
    _getContext: function() {
        return this.context.getChildContext({
            forceNew: true,
            layout: 'omnichannel',
            module: 'Dashboards',
            readonly: true
        });
    },

    /**
     * Override dashboard.js to remove dashboard header.
     * @inheritdoc
     */
    initComponents: function(components, context, module) {
        if (_.isArray(components) && components[0] && components[0].layout && components[0].layout.type &&
            components[0].layout.type === 'dashboard') {
            components[0].layout.components = this._getDashboardComponents();
        }
        return this._super('initComponents', [components, context, module]);
    },

    /**
     * Util to get dashboard components
     * @return {Array} Array of components representing dashboard metadata
     * @private
     */
    _getDashboardComponents: function() {
        return [
            {
                view: {
                    name: 'tabbed-dashboard',
                    type: 'tabbed-dashboard',
                    sticky: false
                }
            },
            {
                layout: 'dashlet-main'
            }
        ];
    },

    /**
     * Set context model for a tab.
     * @param {number} tabIndex
     * @param {Object} model The new model
     */
    setModel: function(tabIndex, model) {
        this.tabModels[tabIndex] = model;
        // enable tab
        var tabbedDashboard = this._getTabbedDashboard();
        if (tabbedDashboard) {
            tabbedDashboard.setTabMode(tabIndex, true);
        }
    },

    /**
     * Change context model.
     * @param {number} tabIndex
     */
    switchModel: function(tabIndex) {
        if (this.tabModels[tabIndex]) {
            if (this.context.parent) {
                this.context.parent.set('rowModel', this.tabModels[tabIndex]);
            }
            this.context.set('module', this.context.children[tabIndex].get('module'));
            // for interaction dashlets
            this.context.set('rowModel', this.tabModels[tabIndex]);
        }
    },

    /**
     * Change active tab.
     * @param {number} tabIndex
     */
    switchTab: function(tabIndex) {
        var tabbedDashboard = this._getTabbedDashboard();
        if (tabbedDashboard) {
            this.switchModel(tabIndex);
            tabbedDashboard.switchTab(tabIndex);
        }
    },

    /**
     * Enable/disable tabs.
     */
    setTabModes: function() {
        var tabbedDashboard = this._getTabbedDashboard();
        if (tabbedDashboard && _.isArray(tabbedDashboard.tabs)) {
            var len = tabbedDashboard.tabs.length;
            for (let i = 1; i < len; i++) {
                // enable tab if tabModel is set, otherwise disable it
                tabbedDashboard.setTabMode(i, !_.isUndefined(this.tabModels[i]));
            }
        }
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        this._super('_render');
        var tabbedDashboard = this._getTabbedDashboard();
        if (tabbedDashboard && !this._onTabEvent) {
            if (tabbedDashboard.context) {
                tabbedDashboard.context.on('change:activeTab', function(ctx) {
                    this.switchModel(ctx.get('activeTab'));
                }, this);
            }
            tabbedDashboard.on('render', this.setTabModes, this);
            this._onTabEvent = true;
        }
    },

    /**
     * Get 'tabbed-dashboard' component.
     * @return {View.View|null}
     * @private
     */
    _getTabbedDashboard: function() {
        var tabbedDashboard = null;
        var dashboard = this.getComponent('dashboard');
        if (dashboard) {
            tabbedDashboard = dashboard.getComponent('tabbed-dashboard');
        }
        return tabbedDashboard;
    },
})
