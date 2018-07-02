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
(function(app) {
    app.events.on('app:init', function() {
        var createDuplicateCollection = function(dupeCheckModel, module) {
            var collection = app.data.createBeanCollection(module || this.module),
                collectionSync = collection.sync;
            _.extend(collection, {
                /**
                 * Duplicate check model.
                 *
                 * @property
                 */
                dupeCheckModel: dupeCheckModel,

                /**
                 * {@inheritDoc}
                 *
                 * Override endpoint in order to fetch custom api.
                 */
                sync: function(method, model, options) {
                    options = options || {};
                    if (_.isEmpty(model.filterDef)) {
                        options.endpoint = _.bind(this.endpoint, this);
                    }
                    collectionSync(method, model, options);
                },

                /**
                 * {@inheritDoc}
                 *
                 * Custom endpoint for duplicate check.
                 */
                endpoint: function(method, model, options, callbacks) {
                    //Dupe Check API requires POST
                    var url = app.api.buildURL(this.module, 'duplicateCheck');
                    var data = app.data.getEditableFields(this.dupeCheckModel);
                    return app.api.call('create', url, data, callbacks);
                }
            });
            return collection;
        };

        app.plugins.register('FindDuplicates', ['view'], {
            /**
             * {@inheritDoc}
             *
             * Bind the find duplicate button handler.
             */
            onAttach: function(component, plugin) {
                this.on('init', function() {
                    this.context.on('button:find_duplicates_button:click', this.findDuplicatesClicked, this);
                });
            },

            /**
             * Handles the click event, and open the duplicate list view in the drawer.
             */
            findDuplicatesClicked: function() {
                this.findDuplicates(this.model);
            },

            /**
             * Open duplicate list view on drawer with duplicates collection.
             *
             * @param {Backbone.Model} dupeCheckModel Duplicate check model.
             */
            findDuplicates: function(dupeCheckModel) {
                app.drawer.open({
                    layout: 'find-duplicates',
                    context: {
                        layoutName: 'records',
                        dupelisttype: 'dupecheck-list-multiselect',
                        collection: this.createDuplicateCollection(dupeCheckModel),
                        model: app.data.createBean(this.module)
                    }
                }, _.bind(function(refresh, primaryRecord) {
                    if (refresh && dupeCheckModel.id === primaryRecord.id) {
                        app.router.refresh();
                    } else if (refresh) {
                        app.navigate(this.context, primaryRecord);
                    }
                }, this));
            },

            /**
             * Create Duplicates list collection.
             *
             * @param {Backbone.Model} dupeCheckModel Duplicate check model.
             * @return {Backbone.Collection} Duplicate check collection.
             */
            createDuplicateCollection: createDuplicateCollection,

            /**
             * {@inheritDoc}
             *
             * Clean up associated event handlers.
             */
            onDetach: function(component, plugin) {
                this.context.off('button:find_duplicates_button:click', this.findDuplicatesClicked, this);
            }
        });

        app.plugins.register('FindDuplicates', ['layout'], {
            /**
             * Create Duplicates list collection.
             *
             * @param {Backbone.Model} dupeCheckModel Duplicate check model.
             * @return {Backbone.Collection} Duplicate check collection.
             */
            createDuplicateCollection: createDuplicateCollection
        });
    });
})(SUGAR.App);
