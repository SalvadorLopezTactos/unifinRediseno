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
 * @class View.Views.Base.DashboardFabView
 * @alias SUGAR.App.view.views.BaseDashboardFabView
 * @extends View.Views.Base.HeaderpaneView
 */
({
    extendsFrom: 'HeaderpaneView',

    events: {
        'click [name=duplicate_button]': 'duplicateClicked',
        'click [name=delete_button]': 'deleteClicked',
        'click [name=add_button]': 'addClicked',
        'click [name=collapse_button]': 'collapseClicked',
        'click [name=expand_button]': 'expandClicked',
        'click [name=edit_module_tabs_button]': 'editModuleTabsClicked',

        'click .dfab-content .dfab-icon, .dfab-content .dfab-label': 'closeFABs',
        'click .dfab-pin': 'togglePinPosition',
        'click .dfab-title': 'toggleFAB'
    },

    /**
     * Indicator showing where the button is pinned (default: bottom).
     *
     * @property {string}
     */
    pinnedTo: 'bottom',

    /**
     * The height of the buttons. It is used in calculating the animation position.
     *
     * @property {number}
     */
    baseHeight: 40,

    /**
     * The margin in between the buttons.
     *
     * @property {number}
     */
    interButtonMargin: 15,

    /**
     * The icon used when the button is expanded.
     */
    defaultCloseIcon: 'close-icon',

    /**
     * Floating action buttons by default will load the metadata described in the Home module.
     * To load any module specific metadata, the loadModule property should updated accordingly.
     * The parent module does not matter in this regard.
     * For more details please see: {@link View.Views.Dashboards.DashboardHeaderpaneView}.
     *
     * @param {Object} options Standard options for initializing a component.
     * @return {Object} The initialization options with the context metadata.
     */
    overrideOptions: function(options) {
        if (options.context.parent) {
            var ctxParentModule = options.context.parent.get('module');
            options.meta = app.metadata.getView(ctxParentModule, options.type, options.loadModule);
            options.template = app.template.getView(options.type);
        }
        return options;
    },

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        options = this.overrideOptions(options);
        this._super('initialize', [options]);
        this.bindEvents();
        this.fabCloseHandler = _.bind(this.closeFABsOnWindowClick, this);
    },

    /**
     * On metadata update and on changing the active tab of the tabbed dsahboard
     * change the visibility of buttons.
     */
    bindEvents: function() {
        if (this.layout && this.layout.model) {
            this.layout.model.on('change:metadata', this.render, this);
        }
        this.context.on('tabbed-dashboard:update', this.updateButtonVisibilities, this);
        this.context.on('tabbed-dashboard:switch-tab', this.updateButtonVisibilities, this);
    },

    /**
     * Do not render the component if there is no metadata. Otherwise set the buttons visibilities.
     * Attach an event handler to the window.
     */
    render: function() {
        if (!this.layout.model.get('metadata') || this.context.get('create')) {
            return;
        }

        this.pinnedTo = this.getCachePinnedTo() || this.pinnedTo;

        this._super('render');

        this._setButtons();
        this.setButtonStates(this.context.get('create') ? 'create' : 'view');
        this.toggleMainButton();
        $(window).on('mousedown', this.fabCloseHandler);
    },

    /**
     * Shows/hides the main floating action button depending on
     * if there are any action buttons held inside.
     */
    toggleMainButton: function() {
        this.updateButtonVisibilities();

        var hasVisibleButtons = _.any(this.buttons, function(button) {
            return button.isVisible && button.isVisible();
        });

        this.$el.toggle(hasVisibleButtons);
    },

    /**
     * Pin top/bottom action. Clicking on the Pin to Top button will move the
     * floatin action control button to the top.
     */
    togglePinPosition: function() {
        var contentWrapper = this.$el.find('.dfab');

        if (this.pinnedTo === 'bottom') {
            this.pinnedTo = 'top';
            contentWrapper.toggleClass('top bottom');
        } else {
            this.pinnedTo = 'bottom';
            contentWrapper.toggleClass('bottom top');
        }

        this.setCachePinnedTo(this.pinnedTo);
    },

    /**
     * Switch between the expanded/collapsed state of the floating action button.
     */
    toggleFAB: function() {
        var contentWrapper = this.$el.find('.dfab');
        if (contentWrapper.hasClass('expanded')) {
            this.closeFABs();
            return;
        }
        this.openFABs();
    },

    /**
     * Collapse the floating action button.
     * It will set the inner buttons to the initial state and reset the classes.
     */
    closeFABs: function() {
        var contentWrapper = this.$el.find('.dfab');
        var items = contentWrapper.find('.dfab-content > *');

        _.each(items, function(item) {
            $(item).css('transform', 'translateY(0px)');
        });

        contentWrapper.removeClass('expanded');
        var mainIcon = this.$el.find('.dfab-title .dfab-icon');
        mainIcon.removeClass(this.defaultCloseIcon).addClass(this.meta.icon);
    },

    /**
     * Expand the floating action button.
     * It will change css classes on elements to realize the animation.
     * Based on the pinned position it will calculate the individual position of each inner button.
     */
    openFABs: function() {
        var nrOfVisibleItems = 0;
        var contentWrapper = this.$el.find('.dfab');
        var items = contentWrapper.find('.dfab-content > *').get().reverse();
        var direction = this.pinnedTo === 'bottom' ? -1 : 1;

        _.each(items, function(item) {
            var child = $($(item).find('> *'));
            if (child.length && !child.hasClass('hide') && !child.hasClass('disabled')) {
                nrOfVisibleItems++;
                var value = direction * (this.baseHeight + this.interButtonMargin) * nrOfVisibleItems;
                $(item).css('transform', 'translateY(' + value + 'px)');
            }
        }, this);

        contentWrapper.addClass('expanded');
        var mainIcon = this.$el.find('.dfab-title .dfab-icon');
        mainIcon.removeClass(this.meta.icon).addClass(this.defaultCloseIcon);
    },

    /**
     * Clicking anywhere on the document will close the fab.
     * In order to cover a dragging action this handler will listen to mousedown.
     *
     * @param {Object} event The mousedown event object.
     */
    closeFABsOnWindowClick: function(event) {
        if (this.disposed) {
            return;
        }

        var eTarget = $(event.target);
        var isLabel = eTarget.hasClass('dfab-label') || eTarget.parent('.dfab-label').length;
        var isIcon = eTarget.hasClass('dfab-icon');

        if (isIcon || isLabel) {
            return;
        }

        this.closeFABs();
    },

    /**
     * Create a duplicate of current dashboard and assign it to the user,
     * so that the user can make own modification on top of existing dashboards
     *
     * Some attributes are changed during the duplication:
     *  id, name, assigned_user_id, assigned_user_name, team, default_dashboard, my_favorite
     */
    duplicateClicked: function() {
        var newModel = app.data.createBean('Dashboards');
        newModel.copy(this.model);

        var oldName = app.lang.get(newModel.get('name'), newModel.get('dashboard_module'));
        var newName = app.lang.get('LBL_COPY_OF', 'Dashboards', {name: oldName});
        var newAttributes = {
            name: newName,
            my_favorite: true
        };
        // Using void 0 to follow the convention in backbone.js
        var clearAttributes = {
            id: void 0,
            assigned_user_id: void 0,
            assigned_user_name: void 0,
            team_name: void 0,
            default_dashboard: void 0
        };

        newModel.unset(clearAttributes, {silent: true});
        newModel.save(newAttributes, {
            error: this.handleFailedSave,
            success: _.bind(this.handleSuccessfulSave, this, 'add', newModel)
        });
    },

    /**
     * Find the name of the current dashboard.
     *
     * @return {string} The dashboard name.
     */
    getDashboardName: function() {
        var label = this.model.get('name');
        var module = this.model.get('dashboard_module');
        return app.lang.get(label, module);
    },

    /**
     * This method handles the deletion of a dashboard. It alerts the user
     * before deleting the dashboard, and if the user chooses to delete the
     * dashboard, it handles the deletion logic as well.
     */
    deleteClicked: function() {
        var messages = app.lang.get('LBL_DELETE_DASHBOARD_CONFIRM', 'Dashboards', {name: this.getDashboardName()});

        app.alert.show('delete_confirmation', {
            level: 'confirmation',
            messages: messages,
            onConfirm: _.bind(this.deleteDashboard, this)
        });
    },

    /**
     * Deletes the current active dashboard.
     */
    deleteDashboard: function() {
        var message = app.lang.get('LBL_DELETE_DASHBOARD_SUCCESS', this.module, {
            name: this.getDashboardName()
        });

        this.model.destroy({
            success: _.bind(this.handleSuccessfulSave, this, 'delete', this.model),
            error: this.handleFailedSave,
            showAlerts: {
                'process': true,
                'success': {
                    messages: message
                }
            }
        });
    },

    /**
     * It will navigate to the dashboard create layout.
     */
    addClicked: function() {
        if (this.context.parent) {
            this.layout.navigateLayout('create');
        } else {
            var route = app.router.buildRoute(this.module, null, 'create');
            app.router.navigate(route, {trigger: true});
        }
    },

    /**
     * It will trigger an event for collapsing all dashlets.
     */
    collapseClicked: function() {
        this.context.trigger('dashboard:collapse:fire', true);
    },

    /**
     * It will trigger an event for expanding all dashlets.
     */
    expandClicked: function() {
        this.context.trigger('dashboard:collapse:fire', false);
    },

    /**
     * Event handler for button 'Edit Module Tabs'.
     */
    editModuleTabsClicked: function() {
        app.drawer.open({
            layout: 'config-drawer',
            context: {
                module: 'ConsoleConfiguration',
            }
        });
    },

    /**
     * Handler for saving success, it navigates to the layout or
     * the page based on the context
     *
     * @param {string} change The change that's made to the model
     *  This is either 'delete' or 'add'.
     * @param {Data.Bean} model The model that's changed.
     */
    handleSuccessfulSave: function(change, model) {
        if (this.disposed) {
            return;
        }
        // If we don't have a this.context.parent, that means we are
        // navigating to a Home Dashboard, otherwise it's a RHS Dashboard
        if (!this.context || !this.context.parent) {
            var id = change === 'add' ? model.get('id') : null;
            var route = app.router.buildRoute(this.module, id);
            app.router.navigate(route, {trigger: true});
            return;
        }

        var contextBro = this.context.parent;
        if (!_.contains(['multi-line', 'focus'], contextBro.get('layout'))) {
            contextBro = contextBro.getChildContext({module: 'Home'});
        }

        if (change === 'delete') {
            contextBro.get('collection').remove(model);
            this.layout.navigateLayout('list');
        } else if (change === 'add') {
            contextBro.get('collection').add(model);
            this.layout.navigateLayout(model.get('id'));
        }
    },

    /**
     * Error handler for Dashboard saving
     */
    handleFailedSave: function() {
        app.alert.show('error_while_save', {
            level: 'error',
            title: app.lang.get('ERR_INTERNAL_ERR_MSG'),
            messages: ['ERR_HTTP_500_TEXT_LINE1', 'ERR_HTTP_500_TEXT_LINE2']
        });
    },

    /**
     * Check if this is a tabbed dashboard and active tab is a dashboard.
     *
     * @return {bool} True if this is not a tabbed dashboard
     * or active tab is a dashboard, false otherwise.
     */
    isDashboard: function() {
        var tabs = this.context.get('tabs');

        if (!tabs) {
            return true;
        }

        var tabIndex = this.context.get('activeTab') || 0;

        if (!tabs[tabIndex]) {
            return true;
        }

        var isStandardDashboard = !!tabs[tabIndex].dashlets;
        var isConsoleDashboard = !!(tabs[tabIndex].components && tabs[tabIndex].components[0].rows);

        return isStandardDashboard || isConsoleDashboard;
    },

    /**
     * Show/hide add dashlet button.
     *
     * @param {bool} state True to show, false to hide
     */
    toggleAddDashletButton: function(state) {
        var button = _.find(this.fields, function(field) {
            return field.name === 'add_dashlet_button';
        });
        if (button) {
            button.setDisabled(!state);
            button.isHidden = !state;
        }
    },

    /**
     * Trigger the logic responsible for the visibility of certain inner buttons.
     */
    updateButtonVisibilities: function() {
        this.toggleAddDashletButton(this.isDashboard());
    },

    /**
     * Detach window event handler.
     *
     * @inheritdoc
     */
    dispose: function() {
        $(window).off('mousedown', this.fabCloseHandler);
        this._super('dispose');
    },

    /**
     * Get fixed position ('pinnedTo') of current
     * dashboard menu from cache (Local Storage)
     */
    getCachePinnedTo: function() {
        var cache = app.cache.get('dashboardsMenuPinnedTo');
        if (!cache) {
            return null;
        }

        cache = JSON.parse(cache);
        var dashboardModelName = this.model.get('name');

        return cache[dashboardModelName] || null;
    },

    /**
     * Set position ('pinnedTo') of current
     * dashboard menu in cache (Local Storage)
     *
     * @param {string}
     */
    setCachePinnedTo: function(value) {
        var cache = app.cache.get('dashboardsMenuPinnedTo');
        cache = (cache) ? JSON.parse(cache) : {};

        var dashboardModelName = this.model.get('name');
        cache[dashboardModelName] = value;

        app.cache.set('dashboardsMenuPinnedTo', JSON.stringify(cache));
    }

});
