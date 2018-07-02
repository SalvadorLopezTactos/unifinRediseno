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
 * This is the base field and all of other fields extend from it.
 *
 * @class View.Fields.Base.BaseField
 * @alias SUGAR.App.view.fields.BaseBaseField
 * @extends View.Field
 */
({
    plugins: ['EllipsisInline', 'Tooltip', 'MetadataEventDriven'],

    /**
     * {@inheritDoc}
     *
     * Some plugins use events which prevents {@link View.Field#delegateEvents}
     * to fallback to metadata defined events.
     * This will make sure we merge metadata events with the ones provided by
     * the plugins.
     */
    initialize: function(options) {

        this.events = _.extend({}, this.events, options.def.events);

        this._super('initialize', arguments);
    },

    /**
     * {@inheritDoc}
     */
    _render: function() {
        var action = 'view';
        if (this.def.link && this.def.route) {
            action = this.def.route.action;
        }
        if (!app.acl.hasAccessToModel(action, this.model)) {
            this.def.link = false;
        }
        if (this.def.link) {
            this.href = this.buildHref();
        }
        app.view.Field.prototype._render.call(this);
    },

    /**
     * Takes care of building href for when there's a def.link and also if is
     * bwc enabled.
     *
     * Deprecated functionality:
     * If `this.def.bwcLink` is set to `true` on metadata, we force the href
     * to be in BWC.
     *
     * TODO remove this from the base field
     */
    buildHref: function() {
        var defRoute = this.def.route ? this.def.route : {},
            module = this.model.module || this.context.get('module');
        // FIXME remove this.def.bwcLink functionality (not yet removed due to Portal need for Documents)
        return '#' + app.router.buildRoute(module, this.model.id, defRoute.action, this.def.bwcLink);
    },

    /**
     * {@inheritDoc}
     *
     * Trim whitespace from value if it is a String.
     */
    unformat: function(value) {
        return _.isString(value) ? value.trim() : value;
    }
})
