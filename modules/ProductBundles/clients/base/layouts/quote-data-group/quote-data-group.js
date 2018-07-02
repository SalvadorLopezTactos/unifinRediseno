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
 * @class View.Layouts.Base.ProductBundles.QuoteDataGroupLayout
 * @alias SUGAR.App.view.layouts.BaseProductBundlesQuoteDataGroupLayout
 * @extends View.Views.Base.Layout
 */
({
    /**
     * @inheritdoc
     */
    tagName: 'tbody',

    /**
     * @inheritdoc
     */
    className: 'quote-data-group',

    /**
     * The colspan value for the list
     */
    listColSpan: 0,

    /**
     * This is the ProductBundle ID from the model set here on the component
     * for easier access by parent layouts
     */
    groupId: undefined,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        if (options.model.get('default_group')) {
            // for the default group, we only want the quote-data-group-list component
            options.meta = _.clone(options.meta);
            options.meta.components = [{
                view: 'quote-data-group-list'
            }];
        }

        this._super('initialize', [options]);

        // set the groupID to the model ID
        this.groupId = this.model.cid;
        // set this collection to the product_bundle_items collection
        this.collection = this.model.get('product_bundle_items');
        // add comparator so the collection can sort
        this.collection.comparator = function(model) {
            return model.get('position');
        };

        var listMeta = app.metadata.getView('Products', 'quote-data-group-list');
        if (listMeta && listMeta.panels && listMeta.panels[0].fields) {
            this.listColSpan = listMeta.panels[0].fields.length;
        }
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this.model.on('change:product_bundle_items', this.render, this);
        // listen for the currency id to change on the parent record
        this.context.parent.get('model').on('change:currency_id', function(model, value, options) {
            this.model.set({
                currency_id: model.get('currency_id'),
                base_rate: model.get('base_rate')
            });
        }, this);
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        this._super('_render');

        // add the group id to the bundle level tbody
        this.$el.attr('data-group-id', this.groupId);

        // set the product bundle ID on all the QLI/Notes rows
        this.$('tr.quote-data-group-list').attr('data-group-id', this.groupId);
    },

    /**
     * Adds a row model to this layout's collection and, if the row is in edit mode, it adds
     * the row model to the QuoteDataGroupListView's toggledModels object
     *
     * @param {Data.Bean} model The row model that needs to be added to the collection
     * @param {boolean} isRowInEdit Is the row currently in edit mode?
     */
    addRowModel: function(model, isRowInEdit) {
        var listComp;

        if (isRowInEdit) {
            listComp = this.getGroupListComponent();
            listComp.toggledModels[model.cid] = model;
        }

        this.collection.add(model, {at: model.get('position')});
    },

    /**
     * Removes a row model from this layout's collection and, if the row is in edit mode, it removes
     * the row model from the QuoteDataGroupListView's toggledModels object
     *
     * @param {Data.Bean} model The row model that needs to be removed from the collection
     * @param {boolean} isRowInEdit Is the row currently in edit mode?
     */
    removeRowModel: function(model, isRowInEdit) {
        var listComp;
        var modelId;

        if (isRowInEdit) {
            modelId = model.get('id');
            listComp = this.getGroupListComponent();
            if (listComp.toggledModels[modelId]) {
                delete listComp.toggledModels[modelId];
            }
            if (listComp.toggledModels[model.cid]) {
                delete listComp.toggledModels[model.cid];
            }
        }

        this.collection.remove(model);
    },

    /**
     * Returns the QuoteDataGroupListView in this layout
     */
    getGroupListComponent: function() {
        return _.find(this._components, function(comp) {
            return comp.name === 'quote-data-group-list';
        });
    }
})
