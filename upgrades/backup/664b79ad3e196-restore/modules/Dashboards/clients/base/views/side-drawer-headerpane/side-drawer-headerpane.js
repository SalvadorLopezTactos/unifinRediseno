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
 * @class View.Views.Dashboards.SideDrawerHeaderpaneView
 * @alias SUGAR.App.view.views.DashboardsSideDrawerHeaderpaneView
 * @extends View.Views.Dashboards.DashboardHeaderpaneView
 */
({
    /**
     * This is a special header for side drawers that contain a dashlet.
     */
    extendsFrom: 'DashboardsDashboardHeaderpaneView',

    events: {
        'click [name=edit_button]': 'editClicked',
        'click [name=save_button]': 'saveClicked',
        'click [name=cancel_button]': 'cancelClicked',
        'click [name=create_cancel_button]': 'createCancelClicked',
        'click [name=edit_overview_tab_button]': 'editOverviewTabClicked',
        'click div.bread:not(:last-child), li.bread': 'breadcrumbClicked',
    },

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._setBreadcrumbs();
        this._super('initialize', [options]);
        $(window).on('resize.' + this.cid, _.bind(_.debounce(this._resetBreadcrumbs, 100), this));
        app.events.on('breadcrumbs:reset', _.bind(this._resetBreadcrumbs, this));
    },

    /**
     * Re-render header when window size changes
     * @private
     */
    _resetBreadcrumbs: function() {
        if (this.disposed || app.drawer.isOpening() || app.drawer.isClosing()) {
            return;
        }
        this.truncatedBreadcrumbs = [];
        this.breadcrumbLastModels = [];
        this._setBreadcrumbs();
        this._renderHeader();
    },

    /**
     * Function to handle the breadcrumb click
     * @param event
     */
    breadcrumbClicked: function(event) {
        var index = parseInt(event.currentTarget.getAttribute('data-index'));
        var contextDef = app.sideDrawer._breadcrumbs.find(breadcrumb => breadcrumb.id === index);
        app.sideDrawer._breadcrumbs = app.sideDrawer._breadcrumbs.slice(0, index - 1);
        app.sideDrawer.open(contextDef, null, true);
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        if (this.context.get('create') && !this.context.get('emptyDashboard')) {
            this.createView = true;
            this.action = 'edit';
        } else {
            this.createView = false;
            this.dashboardTitle = !this.context.get('emptyDashboard');
            this.action = 'view';
        }
        this._super('_render');
    },

    /**
     * Set breadcrumbs in different arrays depending upon the size and number of breadcrumbs.
     *
     * @private
     */
    _setBreadcrumbs: function() {
        if (!app.sideDrawer.isOpen() || _.isNull(this.options.layout.$el)) {
            return;
        }
        var breadcrumbs = app.sideDrawer._breadcrumbs;
        breadcrumbs.forEach((breadcrumb, i) => {
            breadcrumb.id = i + 1;
        });
        var breadcrumbsWidth = breadcrumbs.length * 140;
        var headerWidth = this.options.layout.$el.width() / 2;
        this.breadcrumbModels = breadcrumbs;
        this.singleBreadcrumb = this.breadcrumbModels.length === 1;
        if (breadcrumbs.length > 1) {
            if (headerWidth < 450) {
                this.breadcrumbModels = [_.first(breadcrumbs)];
                this.breadcrumbLastModels = breadcrumbs.slice(breadcrumbs.length - 1);
                if (breadcrumbs.length > 2) {
                    this.truncatedBreadcrumbs = breadcrumbs.slice(1, breadcrumbs.length - 1);
                }
            } else if (breadcrumbsWidth > headerWidth) {
                this.breadcrumbModels = [_.first(breadcrumbs)];
                this.breadcrumbLastModels = breadcrumbs.slice(breadcrumbs.length - 2);
                this.truncatedBreadcrumbs = breadcrumbs.slice(1, breadcrumbs.length - 2);
            }
        }
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        $(window).off('resize.' + this.cid);
        app.events.off('breadcrumbs:reset', _.bind(this._resetBreadcrumbs, this));
        this._super('_dispose');
    },
})
