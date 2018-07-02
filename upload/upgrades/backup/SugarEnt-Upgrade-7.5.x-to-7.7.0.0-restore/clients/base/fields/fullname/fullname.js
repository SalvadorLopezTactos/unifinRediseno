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
 * @class View.Fields.Base.FullnameField
 * @alias SUGAR.App.view.fields.BaseFullnameField
 * @extends View.Fields.Base.FieldsetField
 */
({
    extendsFrom: 'FieldsetField',

    plugins: ['EllipsisInline'],

    /**
     * Mapping name field name to format initial
     *
     * @property {Object}
     */
    formatMap: {
        'f': 'first_name',
        'l': 'last_name',
        's': 'salutation',
    },

    /**
     * {@inheritDoc}
     * Sort the dependant fields by the user locale format order.
     */
    initialize: function(options) {
    	var context = options.view.context,
    		module = context.get("module");
    	
    	if(module) {
    		var meta = app.metadata.getModule(module);
    		if(meta && meta.nameFormat) {
    			this.formatMap = meta.nameFormat;
    		}
    	}
        var formatPlaceholder = app.user.getPreference('default_locale_name_format') || '';
        // extract fields list from format
        options.def.fields = _.reduce(formatPlaceholder.split(''), function(fields, letter) {
    		// only letters a-z may be significant in the format, 
    		// everything else is translated verbatim
        	if(letter >= 'a' && letter <= 'z' && this.formatMap[letter]) {
        		// clone because we'd rewrite it later and we don't want to mess with actual metadata
        		fields.push(_.clone(meta.fields[this.formatMap[letter]] || this.formatMap[letter]));
        	}
        	return fields;
        }, [], this);
        options.def.fields = app.metadata._patchFields(module, meta, options.def.fields);

        this._super('initialize',[options]);

        if (!app.acl.hasAccessToModel('view', this.model) && this.def) {
            this.def.link = false;
        }
    },

    _loadTemplate: function() {
        this._super('_loadTemplate');

        //Bug: SP-1273 - Fixes Contacts subpanel record links to home page
        //(where expectation was to go to the corresponding Contact record)
        if (this.def.link) {
            var action = this.def.route && this.def.route.action ? this.def.route.action : '';
            //If `this.template` resolves to `base/list.hbs`, that template expects an
            //initialized `this.href`. That's normally handled by the `base.js` controller,
            //but, in this case, since `fullname.js` is controller, we must handle here.
            this.href = '#' + app.router.buildRoute(this.module||this.context.get('module'), this.model.id, action, this.def.bwcLink);
        }
        var template = app.template.getField(
            this.type,
            this.view.name + '-' + this.tplName,
            this.model.module);
        //SP-1719: The view-combined template should also follow the view's custom template.
        if (!template && this.view.meta && this.view.meta.template) {
            template = app.template.getField(
                this.type,
                this.view.meta.template + '-' + this.tplName,
                this.model.module);
        }
        this.template = template || this.template;
    },

    /**
     * {@inheritDoc}
     * Returns a single placeholder instead of fieldset placeholder
     * since fullname field generates children placeholder on render.
     */
    getPlaceholder: function() {
        return app.view.Field.prototype.getPlaceholder.call(this);
    },

    /**
     * {@inheritDoc}
     * Since fullname field generates children field components
     * each rendering time, it should dispose the previous generated items
     * before it renders children placeholders.
     */
    _render: function() {
        _.each(this.fields, function(field) {
            field.dispose();
            delete this.view.fields[field.sfId];
        }, this);
        this.fields = [];

        app.view.Field.prototype._render.call(this);

        // this.fields will have been updated from the childField hbs-helper during _render
        _.each(this.fields, function(field) {
            field.setElement(this.$("span[sfuuid='" + field.sfId + "']"));
            field.render();
        }, this);

        return this;
    },

    /**
     * {@inheritDoc}
     * Format name parts to current user locale.
     */
    format: function(name) {
        return app.utils.formatNameModel(this.model.module, this.model.attributes);
    },

    /**
     * @override
     * Note that the parent bindDataChange (from FieldsetField) is an empty function
     */
    bindDataChange: function() {
        if (this.model) {
            // As detail templates don't contain Sidecar Fields,
            // we need to rerender this field in order to visualize the changes
            this.model.on("change:" + this.name, function() {
                if (this.fields.length === 0) {
                    this.render();
                }
            }, this);
            // When a child field changes, we need to update the full_name value
            _.each(this.def.fields, function(field) {
                this.model.on("change:" + field.name, this.updateValue, this);
            }, this);
        }
    },

    /**
     * Update the value of this parent field when a child changes
     */
    updateValue: function() {
        this.model.set(this.name, this.format());
    },

    /**
     * Called by record view to set max width of inner record-cell div
     * to prevent long names from overflowing the outer record-cell container
     */
    setMaxWidth: function(width) {
        this.$('.record-cell').css({'max-width': width});
    },

    /**
     * Return the width of padding on inner record-cell
     */
    getCellPadding: function() {
        var padding = 0,
            $cell = this.$('.record-cell');

        if (!_.isEmpty($cell)) {
            padding = parseInt($cell.css('padding-left'), 10) + parseInt($cell.css('padding-right'), 10);
        }

        return padding;
    }
})
