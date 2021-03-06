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
    extendsFrom: 'BaseField',

    plugins: [
        'EllipsisInline',
        'Tooltip'
    ],

    initialize: function(options) {
        this._super('initialize', arguments);
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        var action = 'view';
        if (this.def.link && this.def.route) {
            action = this.def.route.action;
        }
        if (((!app.acl.hasAccess('developer', this.model.get('cas_sugar_module')) || this.model.get('prj_deleted') == '1')
            && this.def.name == 'pro_title') ||
            (!app.acl.hasAccess(action, this.model.get('cas_sugar_module')) && this.def.name == 'cas_title')) {
            this.def.link = false;
        }
        if (this.def.link) {
            this.href = this.buildHref();
        }
        app.view.Field.prototype._render.call(this);
    },


    buildHref: function() {
        var defRoute = this.def.route ? this.def.route : {},
            module = this.model.module || this.context.get('module');
        switch (this.def.name) {
            case 'pro_title':
                return '#' + app.router.buildRoute('pmse_Project', this.model.attributes.prj_id, defRoute.action, this.def.bwcLink);
                break;
            case 'cas_title':
                return '#' + app.router.buildRoute(this.model.attributes.cas_sugar_module, this.model.attributes.cas_sugar_object_id, defRoute.action, this.def.bwcLink);
                break;
        }
    },

    unformat: function(value) {
        return _.isString(value) ? value.trim() : value;
    }
})
