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
    extendsFrom: 'CreateView',

    /**
     * Used by the alert openRLICreate method
     */
    createdModel: undefined,

    /**
     * Used by the openRLICreate method
     */
    listContext: undefined,

    /**
     * The original success message to call from the new one we set in the getCustomSaveOptions method
     */
    originalSuccess: undefined,

    /**
     * Holds a reference to the alert this view triggers
     */
    alert: undefined,

    /**
     * {@inheritDoc}
     */
    initialize: function (options) {
        this.plugins = _.union(this.plugins, ['LinkedModel']);
        this._super('initialize', [options]);
    },

    /**
     * @override
     */
    getCustomSaveOptions: function(options) {
        this.createdModel = this.model;
        // since we are in a drawer
        this.listContext = this.context.parent || this.context;
        this.originalSuccess = options.success;

        var success = _.bind(function(model) {
            this.originalSuccess(model);
            if (options.lastSaveAction != 'saveAndCreate') {
                this.showRLIWarningMessage(this.listContext.get('module'));
            }
        }, this);

        return {
            success: success
        };
    },

    /**
     * Display the warning message about missing RLIs
     * @param string module     The module that we are currently on.
     */
    showRLIWarningMessage: function(module) {
        // add a callback to close the alert if users navigate from the page
        app.routing.before('route', this.dismissAlert, undefined, this);

        var message = app.lang.get('TPL_RLI_CREATE', 'Opportunities')
            + '  <a href="javascript:void(0);" id="createRLI">'
            + app.lang.get('TPL_RLI_CREATE_LINK_TEXT', 'Opportunities') + '</a>';

        this.alert = app.alert.show('opp-rli-create', {
            level: 'warning',
            autoClose: false,
            title: app.lang.get('LBL_ALERT_TITLE_WARNING') + ':',
            messages: message,
            onLinkClick: _.bind(function() {
                app.alert.dismiss('create-success');
                this.openRLICreate();
            }, this),
            onClose: _.bind(function() {
                app.routing.offBefore('route', this.dismissAlert, this);
            }, this)
        });
    },

    /**
     * Handle dismissing the RLI create alert
     */
    dismissAlert: function(data) {
        // if we are not navigating to the Opps list view, dismiss the alert
        if(data && !(data.args && data.args[0] == 'Opportunities' && data.route == 'list')) {
            app.alert.dismiss('opp-rli-create');
            // close RLI warning alert
            // remove before route event listener
            app.routing.offBefore('route', this.dismissAlert, this);
        }
    },

    /**
     * Open a new Drawer with the RLI Create Form
     */
    openRLICreate: function() {
        // close RLI warning alert
        this.dismissAlert(true);

        var model = this.createLinkModel(this.createdModel || this.model, 'revenuelineitems');

        app.drawer.open({
            layout: 'create-actions',
            context: {
                create: true,
                module: model.module,
                model: model
            }
        }, _.bind(function(model) {
            if (!model) {
                return;
            }

            var ctx = this.listContext || this.context;

            ctx.reloadData({recursive: false});

            // reload opportunities and RLIs subpanels
            ctx.trigger('subpanel:reload', {links: ['opportunities', 'revenuelineitems']});
        }, this));
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        if(this.alert){
            this.alert.getCloseSelector().off('click');
        }

        this._super('_dispose', []);
    }
})
