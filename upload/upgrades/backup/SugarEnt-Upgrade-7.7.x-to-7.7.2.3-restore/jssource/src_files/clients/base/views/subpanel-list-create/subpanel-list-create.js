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
 * Custom RecordlistView used for SubpanelCreate layouts.
 *
 * @class View.Views.Base.SubpanelListCreateView
 * @alias SUGAR.App.view.views.BaseSubpanelListCreateView
 * @extends View.Views.Base.SubpanelListView
 */
({
    extendsFrom: 'SubpanelListView',

    contextEvents: {
        'list:deleterow:fire': 'onDeleteRow',
        'list:addrow:fire': 'onAddRow'
    },

    /**
     * Flag if the view has all valid models
     */
    hasValidModels: true,

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this._super('initialize', [options]);

        // undo flex-list's hardcoding and re-hardcode to use the subpanel-list-create.hbs
        this.template = app.template.getView('subpanel-list-create');

        this.dataView = 'subpanel-list-create';
        this.context.set({
            dataView: this.dataView,
            isCreateSubpanel: true
        });
    },

    /**
     * @inheritdoc
     */
    bindDataChange: function() {
        this._super('bindDataChange');

        var link = this.context.get('link');

        // listen to revalidate the collection
        this.context.parent.on('subpanel:validateCollection:' + link, this.validateModels, this);

        // listen to reset the collection
        this.context.parent.on('subpanel:resetCollection:' + link, this.resetSubpanel, this);

        this.collection.on('add remove', this.render, this);

        this.resetSubpanel();
    },

    /**
     * Resets the subpanel's collection and adds a new bean to the list
     */
    resetSubpanel: function() {
        this.collection.reset();
        this._addBeanToList(true);
    },

    /**
     * @inheritdoc
     *
     * Toggles all fields in the SubpanelList to Edit view
     */
    render: function() {
        this._super('render');

        // toggle fields to edit view
        this._toggleFields(true);

        _.defer(_.bind(function() {
            this.checkButtons();
        }, this));
    },

    /**
     * Handles toggling collection fields to edit or detail
     *
     * @param {Boolean} isEdit If we're toggling fields TO Edit view or not
     * @private
     */
    _toggleFields: function(isEdit) {
        isEdit = isEdit || false;

        // toggle the fields in the list to be in edit mode
        _.each(this.collection.models, function(model) {
            this.toggleFields(this.rowFields[model.get('id')], isEdit)
            if (isEdit) {
                // this is a subpanel specific logic: when the subpanel is back to edit mode,
                // manually fire the dependency trigger on all its models
                this.context.trigger("list:editrow:fire", model, {def: {}});
            }
        }, this);
    },

    /**
     * Checks the -/+ buttons to enable/disable
     */
    checkButtons: function() {
        var delBtns = this.$('.deleteBtn'),
            addBtns = this.$('.addBtn');
        if (delBtns && delBtns.length === 1 && !delBtns.hasClass('disabled')) {
            // if we have only one button, disable it, otherwise leave them all open
            delBtns.addClass('disabled');
        }

        if (addBtns && addBtns.length > 1) {
            // disable all add buttons except the last row
            _.each(addBtns, function(btn, index) {
                if (index < addBtns.length - 1) {
                    $(btn).addClass('disabled');
                }
            });
        }
    },

    /**
     * @inheritdoc
     *
     * Overriding RecordList/FlexList addActions to use actionmenu-create for the left column
     *
     * @override
     */
    addActions: function() {
        if (this.actionsAdded) {
            return;
        }

        // just need the right-side actions
        if (this.meta && _.isObject(this.meta.rowactions)) {
            // add the fieldset and init rightColumns
            this.addRowActions();
        }

        this.actionsAdded = true;
    },

    /**
     * @inheritdoc
     *
     * Overriding flex-list addRowActions to make the rowactions-create type
     *
     * @override
     */
    addRowActions: function() {
        var _generateMeta = function(label, css_class, buttons) {
            return {
                'type': 'fieldset',
                'fields': [
                    {
                        'type': 'rowactions-create',
                        'label': label || '',
                        'css_class': css_class,
                        'buttons': buttons || [],
                        'no_default_action': true
                    }
                ],
                'value': false,
                'sortable': false
            };
        };
        var def = this.meta.rowactions;
        this.rightColumns.push(_generateMeta(def.label, def.css_class, def.actions));
    },

    /**
     * Validates the models in the subpanel
     *
     * @param {Function} callback The callback function to call after validation
     * @param {undefined|Boolean} [fromCreateView] If this function is being called from Create view or not
     */
    validateModels: function(callback, fromCreateView) {
        fromCreateView = fromCreateView || false;

        var returnCt = 0;
        this.hasValidModels = true;

        _.each(this.collection.models, function(model) {
            // loop through all models and call doValidate on each model
            model.doValidate(this.getFields(this.module), _.bind(function(isValid) {
                returnCt++;

                if (this.hasValidModels && !isValid) {
                    // hasValidModels was true, but a model returned false from validation
                    this.hasValidModels = isValid;
                }

                // check if all model validations have occurred
                if (returnCt === this.collection.length) {
                    if (fromCreateView) {
                        // the create waterfall wants the opposite of if this is validated
                        callback(!this.hasValidModels);
                    } else {
                        // this view wants if the models are valid or not
                        callback(this.hasValidModels);
                    }
                }
            }, this));
        }, this);
    },

    /**
     * Click handler for the Add (+) button.
     * Validates each model on the collection and if they all validate, calls
     */
    onAddRow: function() {
        this.validateModels(_.bind(this._addBeanToList, this));
    },

    /**
     * Handler for when the delete button is clicked
     *
     * @param model
     */
    onDeleteRow: function(model) {
        this.context.get('collection').remove(model);
        this.checkButtons();
    },

    /**
     * Adds a bean for this.module to the collection
     *
     * @param {Boolean} hasValidModels If this collection has validated models
     * @private
     */
    _addBeanToList: function(hasValidModels) {
        if (hasValidModels) {
            var beanId = app.utils.generateUUID(),
                bean = app.data.createBean(this.module);

            bean.set({
                id: beanId
            });
            bean._module = this.module;

            // check the parent record to see if an assigned user ID/name has been set
            if (this.context.parent && this.context.parent.has('model')) {
                var parentModel = this.context.parent.get('model'),
                    userId = parentModel.get('assigned_user_id'),
                    userName = parentModel.get('assigned_user_name');

                if (userId) {
                    bean.setDefault('assigned_user_id', userId);
                }

                if (userName) {
                    bean.setDefault('assigned_user_name', userName);
                }
            }

            bean = this._addCustomFieldsToBean(bean);

            // must add to this.collection so the bean shows up in the subpanel list
            this.collection.add(bean);
        }

        this.checkButtons();
    },

    /**
     * Allows child functions to override and add module-specific properties to the bean
     * before it gets added to the collection
     *
     * @param {Data.Bean} bean The bean to add new properties to
     * @return {Data.Bean}
     * @private
     */
    _addCustomFieldsToBean: function(bean) {
        return bean;
    },

    /**
     * @inheritdoc
     */
    _dispose: function() {
        this.context.parent.off(null, null, this);
        this._super('_dispose');
    }
})
