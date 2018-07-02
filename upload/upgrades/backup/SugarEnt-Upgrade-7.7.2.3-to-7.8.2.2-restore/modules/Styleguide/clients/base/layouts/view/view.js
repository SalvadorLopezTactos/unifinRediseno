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
    plugins: ['Prettify'],
    className: 'row-fluid',
    data: [],
    page_name: '',
    page_doc: {},
    section: {},

    initialize: function(options) {
        this._super('initialize', [options]);
        this.page_name = this.options.context.get('page_name').split('_')[1];
        this.section.title = 'Default Views';
        // load up the styleguide css if not already loaded
        //TODO: cleanup styleguide.css and add to main file
        if ($('head #styleguide_css').length === 0) {
            $('<link>')
                .attr({
                    rel: 'stylesheet',
                    href: 'styleguide/assets/css/styleguide.css',
                    id: 'styleguide_css'
                })
                .appendTo('head');
        }
    },

    _render: function() {
        this._super('_render');

        var page_content = app.template.getView( this.page_name + '.' + this.page_name + '-doc', 'Styleguide');

        this.page_doc = app.view.createView({
                context: this.context,
                name: this.page_name,
                module: 'Styleguide',
                layout: this,
                model: this.model,
                readonly: true
            });

        this.$('.styleguide .container-fluid').append(page_content(this));
        this.$('#exampleView').append(this.page_doc.el);

        this.page_doc.render();
    },

    _placeComponent: function(component) {
        this.$('.styleguide').append(component.$el);
    }
})
