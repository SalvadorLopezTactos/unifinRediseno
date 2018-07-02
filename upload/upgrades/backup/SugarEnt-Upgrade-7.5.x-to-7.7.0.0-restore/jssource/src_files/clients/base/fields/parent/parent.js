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
 * @class View.Fields.Base.ParentField
 * @alias SUGAR.App.view.fields.BaseParentField
 * @extends View.Fields.Base.RelateField
 */
({
    minChars: 1,
    extendsFrom: 'RelateField',
    fieldTag: 'input.select2[name=parent_name]',
    typeFieldTag: 'select.select2[name=parent_type]',

    _render: function() {
        var result, self = this;
        this._super("_render");

        /**
         * Only allow modification of the select2 functionality under the specified templates
         */
        var allowedTpls = ['edit', 'massupdate'];
        if (_.contains(allowedTpls, this.tplName)) {
            this.checkAcl('access', this.model.get('parent_type'));

            var inList = (this.view.name === 'recordlist') ? true : false;

            this.$(this.typeFieldTag).select2({
                dropdownCssClass: inList?'select2-narrow':'',
                containerCssClass: inList?'select2-narrow':'',
                width: inList?'off':'100%',
                minimumResultsForSearch: 5
            }).on("change", function(e) {
                var module = e.val;
                self.checkAcl.call(self, 'edit', module);
                self.setValue({
                    id: '',
                    value: '',
                    module: module
                });
                self.$(self.fieldTag).select2('val', '');
            });

            var plugin = this.$(this.typeFieldTag).data('select2');
            if (plugin && plugin.focusser) {
                plugin.focusser.on('select2-focus', _.bind(_.debounce(this.handleFocus, 0), this));
            }
            var domParentTypeVal = this.$(this.typeFieldTag).val();
            if(this.model.get(this.def.type_name) !== domParentTypeVal) {
                //SP-1654: Prevents quickcreate from incorrectly considering model changed
                this.model.set(this.def.type_name, domParentTypeVal, {silent: true});
                this.model.setDefaultAttribute(this.def.type_name, domParentTypeVal);
                this._createFiltersCollection();
            }

            if(app.acl.hasAccessToModel('edit', this.model, this.name) === false) {
                this.$(this.typeFieldTag).select2("disable");
            } else {
                this.$(this.typeFieldTag).select2("enable");
            }
        } else if(this.tplName === 'disabled'){
            this.$(this.typeFieldTag).select2('disable');
        }
        return result;
    },
    _getRelateId: function() {
        return this.model.get("parent_id");
    },
    format: function(value) {

        this.def.module = this.getSearchModule();
        var moduleString = app.lang.getAppListStrings('moduleListSingular'),
            module;
        if (this.def.module) {
            if (!moduleString[this.def.module]) {
                app.logger.error("Module '" + this.def.module + "' doesn't have singular translation.");
                // graceful fallback
                module = this.def.module;
            } else {
                module = moduleString[this.def.module];
            }
        }

        this.context.set('record_label', {
            field: this.name,
            label: (this.tplName === 'detail') ? module : app.lang.get(this.def.label, this.module)
        });

        var parentCtx = this.context && this.context.parent,
            setFromCtx;

        setFromCtx = !value && parentCtx &&
            this.view instanceof app.view.views.BaseCreateView &&
            _.contains(_.keys(app.lang.getAppListStrings(this.def.parent_type)), parentCtx.get('module')) &&
            this.module !== this.def.module;

        if (setFromCtx) {
            var model = parentCtx.get('model');
            // FIXME we need a method to prevent us from doing this
            // FIXME the setValue receives a model but not a backbone model...
            var attributes = model.toJSON();
            attributes.silent = true;
            this.setValue(attributes);
            value = this.model.get(this.name);

            // FIXME we need to iterate over the populated_ that isn't working now
        }

        return this._super('format', [value]);

    },
    checkAcl: function(action, module) {
        if(app.acl.hasAccess(action, module) === false) {
            this.$(this.typeFieldTag).select2("disable");
        } else {
            this.$(this.typeFieldTag).select2("enable");
        }
    },
    setValue: function(model) {
        if (!model) {
            return;
        }
        var silent = model.silent || false,
            // FIXME we shouldn't make this assumption and this method should
            // receive a true Backbone.Model or Data.Bean
            module = model.module || model._module;

        this._createFiltersCollection();

        if (app.acl.hasAccessToModel(this.action, this.model, this.name)) {
            if (module) {
                this.model.set('parent_type', module, {silent: silent});
                this.model.removeDefaultAttribute('parent_type');
            }
            // only set when we have an id on the model, as setting undefined
            // is causing issues with the warnUnsavedChanges() method
            if (!_.isUndefined(model.id)) {
                this.model.set('parent_id', model.id, {silent: silent});
                // FIXME we shouldn't rely on model.value... and hack the full_name here until we fix it properly
                var value = model.value || model[this.def.rname || 'name'] || model['full_name'];
                this.model.set('parent_name', value, {silent: silent});
            }
        }
        // TODO we should support the auto populate of other fields like we do on normal relate.js
    },
    /**
     * Is this module available as an option to be set as parent type?
     * @param module {string}
     * @returns {boolean}
     */
    isAvailableParentType: function(module) {
        var moduleFound = _.find(this.$(this.typeFieldTag).find('option'), function(dom) {
            return $(dom).val() === module;
        });
        return !!moduleFound;
    },
    getSearchModule: function() {
        return this.model.get('parent_type') || this.$(this.typeFieldTag).val();
    },
    getPlaceHolder: function() {
        return  app.lang.get('LBL_SEARCH_SELECT', this.module);
    },
    unbindDom: function() {
        this.$(this.typeFieldTag).select2('destroy');
        this._super("unbindDom");
    },

    /**
     * {@inheritDoc}
     * Avoid rendering process on select2 change in order to keep focus.
     */
    bindDataChange: function() {
        this._super('bindDataChange');
        if (this.model) {
            this.model.on('change:parent_type', function() {
                if (_.isEmpty(this.$(this.typeFieldTag).data('select2'))) {
                    this.render();
                } else {
                    this.$(this.typeFieldTag).select2('val', this.model.get('parent_type'));
                }
            }, this);
        }
    }
})
