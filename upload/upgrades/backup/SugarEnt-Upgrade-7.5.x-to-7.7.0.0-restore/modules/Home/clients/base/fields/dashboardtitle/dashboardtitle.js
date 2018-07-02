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
 * @class View.Fields.Base.Home.DashboardtitleField
 * @alias SUGAR.App.view.fields.BaseHomeDashboardtitleField
 * @extends View.Field
 */
({
    events: {
        'click .dropdown-toggle' : 'toggleClicked',
        'click a[data-id]' : 'navigateClicked'
    },
    dashboards: null,
    toggleClicked: function(evt) {
        var self = this;
        if (!_.isEmpty(this.dashboards)) {
            return;
        }
        this.collection.fetch({
            silent: true,
            success: function(collection) {
                var pattern = /^(LBL|TPL|NTC|MSG)_(_|[a-zA-Z0-9])*$/;
                collection.remove(self.model, {silent:true});
                _.each(collection.models, function(model) {
                    if (pattern.test(model.get('name'))) {
                        model.set('name',
                            app.lang.get(model.get('name'), collection.module || null)
                        );
                    }
                });
                self.dashboards = collection;
                var optionTemplate = app.template.getField(self.type, "options", self.module);
                self.$(".dropdown-menu").html(optionTemplate(collection));
            }
        });
    },
    /**
     * Handle the click from the UI
     * @param {Object} evt The jQuery Event Object
     */
    navigateClicked: function(evt) {
        var id = $(evt.currentTarget).data('id'),
            type = $(evt.currentTarget).data('type');
        this.navigate(id, type);
    },
    /**
     * Change the Dashboard
     * @param {String} id The ID of the Dashboard to load
     * @param {String} [type] The type of dashboard being loaded, default is undefined
     */
    navigate: function(id, type) {
        this.view.layout.navigateLayout(id, type);
    },
    /**
     * Inspect the dashlet's label and convert i18n string only if it's concerned
     *
     * @param {String} i18n string or user typed string
     * @return {String} Translated string
     */
    format: function(value) {
        var module = this.context.parent ? this.context.parent.get("module") : this.context.get("module"),
            pattern = /^(LBL|TPL|NTC|MSG)_(_|[a-zA-Z0-9])*$/;
        return pattern.test(value) ? app.lang.get(value, module) : value;
    },

    /**
     * {@inheritdoc}
     *
     * Override template for dashboard title on home page.
     * Need display it as label so use `f.base.detail` template.
     */
    _loadTemplate: function() {
        app.view.Field.prototype._loadTemplate.call(this);

        if (this.context && this.context.get('model') &&
            this.context.get('model').dashboardModule === 'Home'
        ) {
            this.template = app.template.getField('base', this.tplName) || this.template;
        }
    },

    /**
     * Called by record view to set max width of inner record-cell div
     * to prevent long names from overflowing the outer record-cell container
     */
    setMaxWidth: function(width) {
        this.$el.css({'max-width': width});
    },

    /**
     * Return the width of padding on inner record-cell
     */
    getCellPadding: function() {
        var padding = 0,
            $cell = this.$('.dropdown-toggle');

        if (!_.isEmpty($cell)) {
            padding = parseInt($cell.css('padding-left'), 10) + parseInt($cell.css('padding-right'), 10);
        }

        return padding;
    }
})
