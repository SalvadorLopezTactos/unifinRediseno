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
 * @class View.Fields.Base.ActionmenuField
 * @alias SUGAR.App.view.fields.BaseActionmenuField
 * @extends View.Field
 */
({
    events: {
        'click .checkall': 'checkAll',
        'click input[name="check"]': 'check'
    },

    plugins: ['Tooltip'],

    fieldTag: 'input[name=check]',

    /**
     * The list of fields/actions to show in the dropdown. Applies for
     * `list-header` only.
     *
     * @type {Array}
     */
    fields: null,

    /**
     * Tag to identify an action item in the dropdown.
     *
     * @type {String}
     */
    actionDropDownTag: '[data-toggle=dropdown]',

    /**
     * @inheritDoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        var massCollection = this.context.get('mass_collection');
        if (!massCollection) {
            var MassCollection = app.BeanCollection.extend({
                reset: function(models, options) {
                    this.filterDef = null;
                    this.entire = false;
                    Backbone.Collection.prototype.reset.call(this, models, options);
                }
            });
            massCollection = new MassCollection();
            this.context.set('mass_collection', massCollection);
        }
        this.def.disable_select_all_alert = !!this.def.disable_select_all_alert;
        this._initTemplates();

        if (this.options.viewName === 'list-header') {
            app.shortcuts.register('SelectAll:Checkbox', 'ctrl+a', function() {
                if (!this.isDisabled()) {
                    this.$('.checkall:visible').click();
                }
            }, this);
            app.shortcuts.register('SelectAll:Dropdown', 'm', function() {
                var $dropdown = this.$('[data-toggle=dropdown]');
                if ($dropdown.is(':visible') && !$dropdown.hasClass('disabled')) {
                    $dropdown.click();
                }
            }, this);
        }
    },

    /**
     * Select or unselect a record.
     *
     * @param {Event} event The `click` event.
     */
    check: function(event) {
        this.toggleSelect(this.$(this.fieldTag).is(':checked'));
    },

    /**
     * Select or unselect all records.
     *
     * @param {Event} event The `click` event.
     */
    checkAll: function(event) {
        var checkbox = this.$(this.fieldTag);

        if (checkbox && event.currentTarget === event.target) {
            var isChecked = checkbox.is(':checked');
            checkbox.attr('checked', !isChecked);
            this.toggleSelect(!isChecked);
        }
    },

    /**
     * Takes a specific record and add it or remove it from the mass update
     * collection.
     *
     * @param {Boolean} checked `true` to add it, `false` to remove it.
     */
    toggleSelect: function(checked) {
        var massCollection = this.context.get('mass_collection');
        if (!massCollection) {
            return;
        }

        if (checked) {
            if (this.model.id) { //each selection
                massCollection.add(this.model);
            } else {
                //entire selection
                massCollection.reset(this.collection.models);
                massCollection.filterDef = this.collection.filterDef;
            }
        } else {
            if (this.model.id) { //each selection
                if (massCollection.entire) {
                    massCollection.reset(this.collection.models);
                    massCollection.remove(this.model);
                } else {
                    massCollection.remove(this.model);
                }
            } else { //entire selection
                massCollection.reset();
            }
        }
    },

    /**
     * @inheritDoc
     *
     * Listen to events on the collection, and update the checkboxes
     * consequently.
     */
    bindDataChange: function() {
        var massCollection = this.context.get('mass_collection');

        if (!massCollection) {
            return;
        }
        if (this.model.id) { //listeners for each record selection
            massCollection.on('add', function(model) {
                if (this.model && model.id === this.model.id) {
                    this.$(this.fieldTag).attr('checked', true);
                }
            }, this);
            massCollection.on('remove', function(model) {
                if (this.model && model.id === this.model.id) {
                    this.$(this.fieldTag).attr('checked', false);
                }
            }, this);
            massCollection.on('reset', function() {
                this.$(this.fieldTag).attr('checked', !!massCollection.get(this.model.id));
            }, this);

            if (massCollection.get(this.model) || massCollection.entire) {
                this.$(this.fieldTag).attr('checked', true);
                this.selected = true;
            } else {
                delete this.selected;
            }

        } else { //listeners for entire selection
            if (this.collection) {
                this.collection.on('reset', function() {
                    if (massCollection.entire) {
                        massCollection.reset();
                    }
                }, this);
                this.collection.on('add', function() {
                    if (massCollection.length < this.collection.length) {
                        this.$(this.fieldTag).attr('checked', false);
                        this.view.layout.trigger('list:alert:hide');
                    }
                }, this);
            }

            this.on('render', this.toggleSelectAll, this);

            massCollection.on('add', function(model) {
                this.$(this.actionDropDownTag).removeClass('disabled');
                if (massCollection.length === this.collection.length) {
                    this.$(this.fieldTag).attr('checked', true);
                }
                this.toggleSelectAll();
            }, this);
            massCollection.on('remove reset', function(model) {
                if (massCollection.length === 0) {
                    this.$(this.actionDropDownTag).addClass('disabled');
                    this.$(this.fieldTag).attr('checked', false);
                } else if (massCollection.length === this.collection.length) {
                    this.$(this.actionDropDownTag).removeClass('disabled');
                    this.$(this.fieldTag).attr('checked', true);
                }
                this.toggleSelectAll();
            }, this);
            this.action_enabled = (massCollection.length > 0);
            this.selected = (massCollection.entire);
        }
    },

    /**
     * Fetch api to retrieve the entire filtered set.
     */
    getTotalRecords: function() {
        var massCollection = this.context && this.context.get('mass_collection'),
            filterDef,
            max_num,
            order,
            fields,
            params,
            url;

        if (!massCollection) {
            return;
        }

        filterDef = massCollection.filterDef || [];
        //if list view is for linking and link fetch size configuration exists, set it,
        //otherwise default to maxRecordFetchSize
        max_num = (this.def.isLinkAction && app.config.maxRecordLinkFetchSize) ?
            app.config.maxRecordLinkFetchSize :
            app.config.maxRecordFetchSize;
        order = this.context.get('collection').orderBy;

        if (!_.isArray(filterDef)) {
            filterDef = [filterDef];
        }

        fields = ['id'];
        // if any of the buttons require additional fields, add them to the list
        _.each(this.def.buttons, function(button) {
            if (_.isArray(button.related_fields)) {
                fields = _.union(fields, button.related_fields);
            }
        }, this);

        params = {
            fields: fields.join(','),
            max_num: max_num
        };

        if (order && order.field) {
            params.order_by = order.field + ':' + order.direction;
        }

        if (!_.isEmpty(filterDef)) {
            params.filter = filterDef;
        }

        url = app.api.buildURL(this.module, null, null, params);

        app.alert.show('totalrecord', {
            level: 'process',
            title: app.lang.getAppString('LBL_LOADING'),
            autoClose: false
        });

        massCollection.fetched = false;
        massCollection.trigger('massupdate:estimate');

        app.api.call('read', url, null, {
            success: _.bind(function(data) {
                if (this.disposed) {
                    return;
                }
                app.alert.dismiss('totalrecord');
                this._processTotalRecords(data.records);
                this._alertTotalRecords(data.next_offset);
            }, this)
        });
    },

    /**
     * Update total record set from api request.
     *
     * @param {Object} collection The list of JSON formatted list of model ids.
     * @private
     */
    _processTotalRecords: function(collection) {
        var massCollection = (this.context) ? this.context.get('mass_collection') : null;
        if (!massCollection) {
            return;
        }
        massCollection.reset(collection);
        massCollection.entire = false;
        massCollection.fetched = true;
        massCollection.trigger('massupdate:estimate');
    },

    /**
     * Alert the message for total record set.
     *
     * @param {Number} offset Next pagination offset.
     * @private
     */
    _alertTotalRecords: function(offset) {
        var massCollection = this.context && this.context.get('mass_collection');
        if (!massCollection) {
            return;
        }

        var allSelected = this._buildAlertForReset(massCollection, offset);
        this.view.layout.trigger('list:alert:show', allSelected);
    },

    /**
     * Toggles the actionmenu buttons when the min or max rows have been
     * selected.
     *
     * It is possible to prevent the `select all` alert from being shown by
     * passing `disable_select_all_alert => true` on the metadata.
     * is disabled.
     */
    toggleSelectAll: function() {
        var self = this,
            massCollection = this.context && this.context.get('mass_collection');
        if (!massCollection) {
            return;
        }

        /**
         * Shows or hides the appropriate alert based on the state of the mass collection.
         */
        var showAlert = function() {
            var alert;
            if (self.collection.length === 0) {
                return;
            }

            if (massCollection.length === self.collection.length) {
                if (self.collection.next_offset > 0) {
                    alert = self._buildAlertForEntire(massCollection);
                } else {
                    alert = self._buildAlertForReset(massCollection);
                }
            } else if (massCollection.entire) {
                alert = self._buildAlertForReset(massCollection);
            }
            if (alert) {
                self.view.layout.trigger('list:alert:show', alert);
            } else {
                self.view.layout.trigger('list:alert:hide');
            }
        };

        /**
         * Toggles the actionmenu buttons based on the state of the mass collection.
         *
         * @param {Object} fields List of the view's fields.
         */
        var setButtonsDisabled = function(fields) {
            _.each(fields, function(field) {
                if (field.def.minSelection || field.def.maxSelection) {
                    var min = field.def.minSelection || 0,
                        max = field.def.maxSelection || massCollection.length;
                    if (massCollection.length < min || massCollection.length > max) {
                        field.setDisabled(true);
                    } else {
                        field.setDisabled(false);
                    }
                }
            }, self);
        };

        if (!this.def.disable_select_all_alert) {
            showAlert();
        }
        setButtonsDisabled(this.fields);
    },

    /**
     * @inheritDoc
     */
    getPlaceholder: function() {
        var self = this,
            viewName = this.options.viewName || this.view.name;

        if (viewName === 'list-header' && !this.fields) {
            this.fields = [];
            var actionMenu = '<ul class="dropdown-menu" role="menu">';
            _.each(this.def.buttons, function(fieldDef) {
                var field = app.view.createField({
                    def: fieldDef,
                    view: self.view,
                    viewName: self.options.viewName,
                    model: self.model
                });
                field.on('show hide', self.setPlaceholder, self);
                self.fields.push(field);
                field.parent = self;
                actionMenu += '<li>' + field.getPlaceholder() + '</li>';

            });
            actionMenu += '</ul>';

            self.actionPlaceHolder = new Handlebars.SafeString(actionMenu);

            var massCollection = this.context.get('mass_collection');
            massCollection.on('massupdate:estimate', this.onTotalEstimate, this);
        }
        return this._super('getPlaceholder');
    },

    /**
     * @inheritDoc
     */
    _loadTemplate: function() {
        this._super('_loadTemplate');
        if (this.view.action === 'list' && this.action === 'edit') {
            this.template = app.template.empty;
        }
    },

    /**
     * @inheritDoc
     */
    setPlaceholder: function() {
        var index = 0;

        _.each(this.fields, function(field) {
            var fieldPlaceholder = this.$('span[sfuuid="' + field.sfId + '"]');
            if (!field.isVisible()) {
                fieldPlaceholder.toggleClass('hide', true);
                this.$el.append(fieldPlaceholder);
            } else {
                fieldPlaceholder.toggleClass('hide', false);
                this.$('.dropdown-menu').append($('<li>').append(fieldPlaceholder));
                index++;
            }
        }, this);


        if (index < 1) {
            this.$('.dropdown-toggle').hide();
        } else {
            this.$('.dropdown-toggle').show();
        }
        this.$('.dropdown-menu').children('li').each(function(index, el) {
            if ($(el).html() === '') {
                $(el).remove();
            }
        });
    },

    /**
     * Update the dropdown usability while the total count is estimating.
     */
    onTotalEstimate: function() {
        var collection = this.context.get('mass_collection');
        this.setDropdownDisabled(!collection.fetched);
    },

    /**
     * Disable the dropdown action.
     *
     * @param {Boolean} [disable] `true` to disable the dropdown action, `false`
     * to enable it.
     */
    setDropdownDisabled: function(disable) {
        this.$(this.actionDropDownTag).toggleClass('disabled', disable);
    },

    /**
     * @inheritDoc
     */
    unbindData: function() {
        var collection = this.context.get('mass_collection');
        if (collection) {
            var modelId = this.model.cid,
                cid = this.view.cid;
            collection.off(null, null, this);
            if (modelId) {
                collection.off(null, null, modelId);
            }
            if (cid) {
                collection.off(null, null, cid);
            }
        }
        if (this.collection) {
            this.collection.off('reset', null, this);
        }
        this.off('render', null, this);
        this._super('unbindData');
    },

    /**
     * @inheritDoc
     */
    _dispose: function() {
        _.each(this.fields, function(field) {
            field.parent = null;
            field.dispose();
        });
        this.fields = null;
        this._super('_dispose');
    },

    /**
     * @inheritDoc
     *
     * No data changes to bind.
     */
    bindDomChange: function() {
    },

    /**
     * @inheritDoc
     *
     * No need to unbind DOM changes to a model.
     */
    unbindDom: function() {
    },

    /**
     * Initialize templates.
     *
     * @return {Field.ActionMenuField} Instance of this field.
     * @template
     * @protected
     */
    _initTemplates: function() {
        this._selectedOffsetTpl = app.template.getView('list.selected-offset') ||
            app.template.getView('list.selected-offset', this.module);

        this._selectAllLinkTpl = new Handlebars.SafeString(
            '<button type="button" class="btn btn-link btn-inline" data-action="select-all">' +
                app.lang.get('LBL_LISTVIEW_SELECT_ALL_RECORDS') +
                '</button>'
        );
        this._selectAllTpl = app.template.compile(null, app.lang.get('TPL_LISTVIEW_SELECT_ALL_RECORDS'));

        return this;
    },

    /**
     * Builds the DOM alert with an event for resetting the mass collection.
     *
     * @param {Backbone.Collection} massCollection The mass update collection.
     * @param {Number} [offset] The collection offset.
     * @return {jQuery} The alert content.
     * @protected
     */
    _buildAlertForReset: function(massCollection, offset) {
        var alert = $('<span></span>').append(this._selectedOffsetTpl({
            offset: offset,
            num: massCollection.length
        }));
        alert.find('[data-action=clear]').each(function() {
            var $el = $(this);
            $el.on('click', function() {
                massCollection.reset();
            });
            app.accessibility.run($el, 'click');
        });
        return alert;
    },

    /**
     * Builds the DOM alert with event for selecting all records.
     *
     * @param {Backbone.Collection} massCollection The mass update collection.
     * @return {jQuery} The alert content.
     * @protected
     */
    _buildAlertForEntire: function(massCollection) {
        var self = this,
            alert = $('<span></span>').append(this._selectAllTpl({
            num: massCollection.length,
            link: this._selectAllLinkTpl
        }));
        alert.find('[data-action=select-all]').each(function() {
            var $el = $(this);
            $el.on('click', function() {
                massCollection.entire = true;
                self.getTotalRecords();
                $(this).off('click');
            });
            app.accessibility.run($el, 'click');
        });
        return alert;
    }
})
