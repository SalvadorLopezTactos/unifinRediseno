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
 * @class View.Fields.Base.VisualPipeline.HeaderValuesField
 * @alias SUGAR.App.view.fields.BaseVisualPipelineHeaderValuesField
 * @extends View.Fields.Base.BaseField
 */
({
    extendsFrom: 'BaseField',

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this.model.on('change:table_header', this.render, this);
    },

    /**
     * @inheritdoc
     */
    _render: function() {
        if (!_.isEmpty(this.context)) {
            this.context.set('selectedValues', {});
        }

        this.populateHeaderValues();
        this._super('_render');
        this.handleDraggableActions();
    },

    /**
     * Populates the whitelist and blacklist sections based on the hidden_values config
     */
    populateHeaderValues: function() {
        var tableHeader = this.model.get('table_header');
        var module = this.model.get('enabled_module');
        var fields = app.metadata.getModule(module, 'fields');
        var translated = app.lang.getAppListStrings((fields[tableHeader] || {}).options);

        if (!_.isEmpty(tableHeader) && _.isEmpty(translated)) {
            // call enum api
            app.api.enumOptions(module, tableHeader, {
                success: _.bind(function(data) {
                    if (!this.disposed) {
                        this._createHeaderValueLists(tableHeader, data);
                        this._super('_render');
                        this.handleDraggableActions();
                    }
                }, this)
            });
        }

        this._createHeaderValueLists(tableHeader, translated);
    },

    /**
     * Creates whitelist and blacklist of header values.
     *
     * @param {string} tableHeader Header name
     * @param {Array} translated List of options
     */
    _createHeaderValueLists: function(tableHeader, translated) {
        var whiteListed = [];
        var blackListed = [];
        var availableValues = {};

        if (!_.isEmpty(tableHeader) && !_.isEmpty(translated)) {
            var hiddenValues = this.getBlackListedArray();
            var availableValues = this.model.get('available_columns') ? this.model.get('available_columns') : {};

            if (!_.isUndefined(availableValues[tableHeader])) {
                // if availableColumns is defined for the table header
                // Check for any new custom column added
                if (Object.keys(translated).length >
                    (hiddenValues.length + Object.keys(availableValues[tableHeader]).length)) {
                    // get missing columns
                    var diffArr = _.difference(Object.keys(translated),
                        _.union(Object.keys(availableValues[tableHeader]), hiddenValues));

                    if (!_.isUndefined(diffArr)) {
                        // show the new values with the hidden columns
                        hiddenValues = _.union(hiddenValues, diffArr);
                    }
                }

                for (var prop in availableValues[tableHeader]) {
                    if (translated.hasOwnProperty(prop) && !_.isEmpty(prop)) {
                        var item = {};
                        item.key = prop;
                        item.translatedLabel = translated[prop];
                        whiteListed.push(item);
                    }
                }

                if (!_.isEmpty(hiddenValues)) {
                    _.each(hiddenValues, function(prop) {
                        if (translated.hasOwnProperty(prop) && !_.isEmpty(prop)) {
                            var item = {};
                            item.key = prop;
                            item.translatedLabel = translated[prop];
                            blackListed.push(item);
                        }
                    }, this);
                }
            } else {
                // if availableColumns is not defined then load from the translated object
                for (var prop in translated) {
                    if (translated.hasOwnProperty(prop) && !_.isEmpty(prop)) {
                        var item = {};
                        item.key = prop;
                        item.translatedLabel = translated[prop];

                        if (_.indexOf(hiddenValues, prop) === -1) {
                            whiteListed.push(item);
                        } else {
                            blackListed.push(item);
                        }
                    }
                }
            }
        }

        this.model.set({
            'white_listed_header_vals': whiteListed,
            'black_listed_header_vals': blackListed
        });
    },

    /**
     * Handles the dragging of the items from the white list to the black list section
     */
    handleDraggableActions: function() {
        this.$('#pipeline-sortable-1, #pipeline-sortable-2').sortable({
            connectWith: '.connectedSortable',
            receive: _.bind(function(event, ui) {
                var $item = $(ui.item);
                var movedItem = $item.data('headervalue');
                var movedInColumn = $item.parent().data('columnname');
                var moduleName = $item.closest('.header-values-wrapper').data('modulename');
                var model = _.find(this.collection.models, function(item) {
                    if (item.get('enabled_module') === moduleName) {
                        return item;
                    }
                });
                var blackListed = this.getBlackListedArray();

                if (movedInColumn === 'black_list') {
                    blackListed.push(movedItem);
                }

                if (movedInColumn === 'white_list') {
                    var index = _.indexOf(blackListed, movedItem);
                    if (index > -1) {
                        blackListed.splice(index, 1);
                    }
                }

                if (blackListed instanceof Array) {
                    model.set('hidden_values', blackListed);
                }

            }, this)
        });
    },

    /**
     * Return the list of fields that are black listed based on the hidden_value config
     * @return {Array} The black listed fields
     */
    getBlackListedArray: function() {
        var blackListed = this.model.get('hidden_values');
        if (_.isEmpty(blackListed)) {
            blackListed = [];
        }
        if (!(blackListed instanceof Array)) {
            blackListed = JSON.parse(blackListed);
        }

        return blackListed;
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        this.model.off('change:table_header', null, this);

        this._super('_dispose');
    }
});
