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
 * @class View.Views.Base.Quotes.RecordView
 * @alias SUGAR.App.view.views.BaseQuotesRecordView
 * @extends View.Views.Base.RecordView
 */
({
    extendsFrom: 'RecordView',

    /**
     * Track the calculated fields from the model to be used when checking for unsaved changes
     *
     * @type {Array}
     */
    calculatedFields: [],

    /**
     * Track the number of items in edit mode.
     * @type {number}
     */
    editCount: 0,

    /**
     * Hashtable to keep track of id's in edit mode
     * @type {Object}
     */
    editIds: {},

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this.plugins = _.union(this.plugins || [], ['HistoricalSummary', 'QuotesViewSaveHelper']);
        this._super('initialize', [options]);

        // get all the calculated fields from the model
        this.calculatedFields = _.chain(this.model.fields)
            .where({calculated: true})
            .pluck('name')
            .value();
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this._super('bindDataChange');

        this.context.on('editable:handleEdit', this._handleEditShippingField, this);

        this.context.on('quotes:editableFields:add', function(field) {
            this.editableFields.push(field);
        }, this);

        this.context.on('quotes:item:toggle', this._handleItemToggled, this);
        this.context.on('quotes:item:toggle:reset', this._handleToggleReset, this);
    },

    /**
     * handles keeping track how many items are in edit mode.
     * @param {boolean} isEdit
     * @param {number} id id of the row being toggled
     * @private
     */
    _handleItemToggled: function(isEdit, id) {
        if (isEdit) {
            if (_.isUndefined(this.editIds[id])) {
                this.editIds[id] = true;
                this.editCount++;
            }
        } else if (!isEdit && this.editCount > 0) {
            delete this.editIds[id];
            this.editCount--;
        }
    },

    /**
     * override the save clicked function to check if things are in edit mode before saving.
     * @override
     */
    saveClicked: function() {
        //if we don't have any qlis in edit mode, save.  If we do, show a warning.
        if (this.editCount == 0) {
            this._super('saveClicked');
        } else {
            app.alert.show('quotes_qli_editmode', {
                level: 'error',
                title: '',
                messages: [app.lang.get('LBL_SAVE_LINE_ITEMS', 'Quotes')]
            });
        }

    },

    /**
     * override the cancel clicked function to retrigger sugarlogic.
     * @override
     */
    cancelClicked: function() {
        this._super('cancelClicked');
        this.context.trigger('list:editrow:fire');
    },

    /**
     * This is only when the Shipping field is clicked to handle toggling
     * it to Edit mode since it's outside of this view's element. This is
     * exactly the same as record.handleEdit except it grabs the jQuery
     * event target from the full page instead of this.el and also uses the
     * `this.editableFields` instead of this.getField to find the shipping field.
     *
     * @param {jQuery.Event} e The jQuery Click Event
     * @private
     */
    _handleEditShippingField: function(e) {
        var $target;
        var cellData;
        var field;
        var cell;

        if (e) {
            // having to open this to full page $ instead of this.$
            $target = $(e.target);
            cell = $target.parents('.record-cell');
        }

        cellData = cell.data();
        field = _.find(this.editableFields, function(field) {
            return field.name === cellData.name;
        });

        // Set Editing mode to on.
        this.inlineEditMode = true;

        this.setButtonStates(this.STATE.EDIT);

        this.toggleField(field);

        if (cell.closest('.headerpane').length > 0) {
            this.toggleViewButtons(true);
            this.adjustHeaderpaneFields();
        }
    },

    /**
     * @inheritdoc
     */
    getCustomSaveOptions: function(options) {
        options = options || {};
        var returnObject = {};

        // get the value that the server sent back
        var syncedValue = this.model.getSynced('currency_id');

        // has the currency_id changed?
        if (this.model.get('currency_id') !== syncedValue) {
            // make copy of original function we are extending
            var origSuccess = options.success;
            // only do this if the currency_id field actually changes
            returnObject = {
                success: _.bind(function() {
                    if (_.isFunction(origSuccess)) {
                        origSuccess.apply(this, arguments);
                    }
                    // create the payload
                    var bulkSaveRequests = this._createBulkBundlesPayload();
                    // send the payload
                    this._sendBulkBundlesUpdate(bulkSaveRequests);
                }, this)
            };
        }

        return returnObject;
    },

    /**
     * Utility method to create the payload that will be send to the server via the bulk api call
     * to update all the product bundles currencies
     * @private
     */
    _createBulkBundlesPayload: function() {
        // loop over all the bundles and create the requests
        var bundles = this.model.get('bundles');
        var bulkSaveRequests = [];
        var url;
        bundles.each(function(bundle) {
            // if the bundle is new, don't try and save it
            if (!bundle.isNew()) {
                // create the update url
                url = app.api.buildURL(bundle.module, 'update', {
                    id: bundle.get('id')
                });

                // save the request with the two fields that need to be updated
                // on the product bundle
                bulkSaveRequests.unshift({
                    url: url.substr(4),
                    method: 'PUT',
                    data: {
                        currency_id: bundle.get('currency_id'),
                        base_rate: bundle.get('base_rate')
                    }
                });
            }
        });

        return bulkSaveRequests;
    },

    /**
     * Send the payload via the bulk api
     * @param {Array} bulkSaveRequests
     * @private
     */
    _sendBulkBundlesUpdate: function(bulkSaveRequests) {
        if (!_.isEmpty(bulkSaveRequests)) {
            app.api.call(
                'create',
                app.api.buildURL(null, 'bulk'),
                {
                    requests: bulkSaveRequests
                },
                {
                    success: _.bind(this._onBulkBundlesUpdateSuccess, this)
                }
            );
        }
    },

    /**
     * Update the bundles when the results from the bulk api call
     * @param {Array} bulkResponses
     * @private
     */
    _onBulkBundlesUpdateSuccess: function(bulkResponses) {
        var bundles = this.model.get('bundles');
        var bundle;
        _.each(bulkResponses, function(record) {
            bundle = bundles.get(record.contents.id);
            if (bundle) {
                bundle.setSyncedAttributes(record.contents);
                bundle.set(record.contents);
            }
        }, this);
    },

    /**
     * @inheritdoc
     */
    hasUnsavedChanges: function() {
        return this.hasUnsavedQuoteChanges();
    }
})
