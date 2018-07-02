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
 * @class View.Views.Base.SelectionListView
 * @alias SUGAR.App.view.views.BaseSelectionListView
 * @extends View.Views.Base.FlexListView
 */
({
    extendsFrom: 'FlexListView',

    initialize: function(options) {
        this.plugins = _.union(this.plugins, ['ListColumnEllipsis', 'ListRemoveLinks']);
        //setting skipFetch to true so that loadData will not run on initial load and the filter load the view.
        options.context.set('skipFetch', true);
        options.meta = options.meta || {};

        this.oneToMany = options.context.get('recLink') ?
                app.data.canHaveMany(app.controller.context.get('module'), options.context.get('recLink')) :
                false;

        //One to Multi relationship; allow multi linking
        if (this.oneToMany) {
            options.meta.selection = {
                type: 'multi',
                isLinkAction: true
            };
        } else {
            options.meta.selection = {
                type: 'single',
                label: 'LBL_LINK_SELECT',
                isLinkAction: true
            };
        }

        this._super('initialize', [options]);

        this.events = _.extend({}, this.events, {
            'click .search-and-select .single': 'triggerCheck'
        });

        if (this.oneToMany) {
            //Set up mass linker component
            var pageComponent = this.layout.getComponent('mass-link');
            if (!pageComponent) {
                pageComponent = app.view.createView({
                    context: this.context,
                    name: 'mass-link',
                    module: this.module,
                    primary: false,
                    layout: this.layout
                });
                this.layout.addComponent(pageComponent);
            }
            pageComponent.render();
        }
        this.initializeEvents();
    },

    /**
     * check the checkbox when the row is clicked
     * @param {object} event
     */
    triggerCheck: function(event) {
        //Ignore inputs and links/icons, because those already have defined effects
        if (!($(event.target).is('a,i,input'))) {
            if (this.oneToMany) {
                //simulate click on the input for this row
                var checkbox = $(event.currentTarget).find('input[name="check"]');
                checkbox[0].click();
            } else {
                var radioButton = $(event.currentTarget).find('.selection[type="radio"]');
                radioButton[0].click();
            }
        }
    },

    /**
     * Override to setup events for subclasses
     */
    initializeEvents: function() {
        if (this.oneToMany) {
            this.context.on('selection-list:link:multi', this._selectMultipleAndClose, this);
            this.context.on('selection-list:select', this._refreshList, this);
        } else {
            this.context.on('change:selection_model', this._selectAndClose, this);
            this.context.on('selection-list:select', this._selectAndCloseImmediately, this);
        }
    },

    /**
     * After a model is selected, refresh the list view and add the model to selections
     * @private
     */
    _refreshList: function(model) {
        this.context.reloadData({
            recursive: false,
            error: function(error) {
                app.alert.show('server-error', {
                    level: 'error',
                    messages: 'ERR_GENERIC_SERVER_ERROR'
                });
            }
        });
    },

    /**
     * Select multiple models to link and fire the mass link event
     * @private
     */
    _selectMultipleAndClose: function() {
        var selections = this.context.get('mass_collection');
        if (selections) {
            this.layout.once('list:masslink:complete', this._closeDrawer, this);
            this.layout.trigger('list:masslink:fire');
        }
    },

    /**
     * Close drawer and then refresh record page with new links
     * @private
     */
    _closeDrawer: function(model, data, response) {
        app.drawer.close();

        var context = this.options.context.get('recContext'),
            view = this.options.context.get('recView'),
            collectionOptions = context.get('collectionOptions') || {};

        if (context.has('parentModel')) {
            var parentModel = context.get('parentModel'),
                syncedAttributes = parentModel.getSyncedAttributes(),
                updatedAttributes = _.reduce(data.record, function(memo, val, key) {
                    if (!_.isEqual(syncedAttributes[key], val)) {
                        memo[key] = val;
                    }
                    return memo;
                }, {});
            parentModel.set(updatedAttributes);
            //Once parent model is reset, reset internal synced attributes as well
            parentModel.setSyncedAttributes(data.record);
        }

        context.get('collection').resetPagination();
        context.resetLoadFlag();
        context.set('skipFetch', false);
        //Reset limit on context so we don't 'over fetch' (lose pagination)
        if (collectionOptions.limit) {
            context.set('limit', collectionOptions.limit);
        }
        context.loadData({
            success: function() {
                view.layout.trigger('filter:record:linked');
            },
            error: function(error) {
                app.alert.show('server-error', {
                    level: 'error',
                    messages: 'ERR_GENERIC_SERVER_ERROR'
                });
            }
        });
    },

    /**
     * Selected from list. Close the drawer.
     *
     * @param {object} context
     * @param {object} selectionModel
     * @private
     */
    _selectAndClose: function(context, selectionModel) {
        if (selectionModel) {
            this.context.unset('selection_model', {silent: true});
            app.drawer.close(this._getModelAttributes(selectionModel));
        }
    },

    /**
     * Select the given model and close the drawer immediately.
     *
     * @param {object} model
     * @private
     */
    _selectAndCloseImmediately: function(model) {
        if (model) {
            app.drawer.closeImmediately(this._getModelAttributes(model));
        }
    },

    /**
     * Return attributes given a model with ACL check
     *
     * @param {object} model
     * @return {object} attributes
     * @private
     */
    _getModelAttributes: function(model) {
        var attributes = {
            id: model.id,
            value: model.get('name')
        };

        //only pass attributes if the user has view access
        _.each(model.attributes, function(value, field) {
            if (app.acl.hasAccessToModel('view', model, field)) {
                attributes[field] = attributes[field] || model.get(field);
            }
        }, this);

        return attributes;
    },

    /**
     * Add Preview button on the actions column on the right.
     */
    addActions: function() {
        this._super('addActions');
        if (this.meta.showPreview !== false) {
            this.rightColumns.push({
                type: 'preview-button',
                css_class: 'btn',
                tooltip: 'LBL_PREVIEW',
                event: 'list:preview:fire',
                icon: 'icon-eye-open'
            });
        } else {
            this.rightColumns.push({});
        }
    }
})
