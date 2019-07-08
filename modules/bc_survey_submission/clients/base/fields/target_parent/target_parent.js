({
    minChars: 1,
    extendsFrom: 'RelateField',
    fieldTag: 'input.select2[name=target_parent_name]',
    typeFieldTag: 'select.select2[name=target_parent_type]',
    initialize: function (options) {
        this._super('initialize', [options]);
        var self = this;
        if (self.module == 'bc_survey_submission')
        {
            // get target related to field value
            var url = App.api.buildURL("bc_survey", "getTargetRelatedtoForSubmission", "", {submission_id: self.model.id});
            App.api.call('GET', url, {}, {
                success: function (result) {
                     
                    if (result)
                    {
                        self.model.attributes.target_parent_id = result['target_parent_id'];
                        self.model.attributes.target_parent_name = result['target_parent_name'];
                        
                        self.model.attributes.parent_type = result['origin_type'];
                        self.model.attributes.target_parent_type = result['target_type'];
                        self._render();
                    }
                }
            });
        }
    },
    _render: function () {
         
        var result, self = this;

        var allowedTpls = ['edit', 'massupdate'];
        if (self.module == 'bc_survey_submission')
        {
            // get target related to field value
            var url = App.api.buildURL("bc_survey", "getTargetRelatedtoForSubmission", "", {submission_id: self.model.id});
            App.api.call('GET', url, {}, {
                success: function (result) {
                     
                    if (result)
                    {
                        self.model.attributes.target_parent_id = result['target_parent_id'];
                        self.model.attributes.target_parent_name = result['target_parent_name'];
                        
                        self.model.attributes.parent_type = result['origin_type'];
                        self.model.attributes.target_parent_type = result['target_type'];
                        
                        self._super("_render");
                        if (_.contains(allowedTpls, self.tplName)) {

                            self.checkAcl('access', self.model.get('target_parent_type'));
                            var inList = (self.view.name === 'recordlist') ? true : false;
                            self.$(self.typeFieldTag).select2({
                                dropdownCssClass: inList ? 'select2-narrow' : '',
                                containerCssClass: inList ? 'select2-narrow' : '',
                                width: inList ? 'off' : '100%',
                                minimumResultsForSearch: 5
                            }).on("change", function (e) {
                                var module = e.val;
                                self.checkAcl.call(self, 'edit', module);
                                self.setValue({
                                    id: '',
                                    value: '',
                                    module: module
                                });
                                self.$(self.fieldTag).select2('val', '');
                            });
                            var plugin = self.$(self.typeFieldTag).data('select2');
                            if (plugin && plugin.focusser) {
                                plugin.focusser.on('select2-focus', _.bind(_.debounce(self.handleFocus, 0), self));
                            }
                            var domParentTypeVal = self.$(self.typeFieldTag).val();
                            if (self.model.get(self.def.type_name) !== domParentTypeVal) {
                                self.model.setDefault(self.def.type_name, domParentTypeVal);
                                self._createFiltersCollection();
                            }
                            if (app.acl.hasAccessToModel('edit', self.model, self.name) === false) {
                                self.$(self.typeFieldTag).select2("disable");
                            } else {
                                self.$(self.typeFieldTag).select2("enable");
                            }
                        } else if (self.tplName === 'disabled') {
                            self.$(self.typeFieldTag).select2('disable');
                        }
                        return result;
                    }
                }
            });
        } else {
            if (_.contains(allowedTpls, self.tplName)) {

                self.checkAcl('access', self.model.get('target_parent_type'));
                var inList = (self.view.name === 'recordlist') ? true : false;
                self.$(self.typeFieldTag).select2({
                    dropdownCssClass: inList ? 'select2-narrow' : '',
                    containerCssClass: inList ? 'select2-narrow' : '',
                    width: inList ? 'off' : '100%',
                    minimumResultsForSearch: 5
                }).on("change", function (e) {
                    var module = e.val;
                    self.checkAcl.call(self, 'edit', module);
                    self.setValue({
                        id: '',
                        value: '',
                        module: module
                    });
                    self.$(self.fieldTag).select2('val', '');
                });
                var plugin = self.$(self.typeFieldTag).data('select2');
                if (plugin && plugin.focusser) {
                    plugin.focusser.on('select2-focus', _.bind(_.debounce(self.handleFocus, 0), self));
                }
                var domParentTypeVal = self.$(self.typeFieldTag).val();
                if (self.model.get(self.def.type_name) !== domParentTypeVal) {
                    self.model.setDefault(self.def.type_name, domParentTypeVal);
                    self._createFiltersCollection();
                }
                if (app.acl.hasAccessToModel('edit', self.model, self.name) === false) {
                    self.$(self.typeFieldTag).select2("disable");
                } else {
                    self.$(self.typeFieldTag).select2("enable");
                }
            } else if (self.tplName === 'disabled') {
                self.$(self.typeFieldTag).select2('disable');
            }
            return result;
        }

    },
    _getRelateId: function () {
        return this.model.get("target_parent_id");
    },
    format: function (value) {
        var module;
        this.def.module = this.getSearchModule();
        if (this.def.module) {
            module = app.lang.getModuleName(this.def.module);
        }
        this.context.set('record_label', {
            field: this.name,
            label: (this.tplName === 'detail') ? module : app.lang.get(this.def.label, this.module)
        });
        var parentCtx = this.context && this.context.parent,
                setFromCtx;
        setFromCtx = !value && parentCtx && this.view instanceof app.view.views.BaseCreateView && _.contains(_.keys(app.lang.getAppListStrings(this.def.target_parent_type)), parentCtx.get('module')) && this.module !== this.def.module;
        if (setFromCtx) {
            var model = parentCtx.get('model');
            var attributes = model.toJSON();
            attributes.silent = true;
            this.setValue(attributes);
            value = this.model.get(this.name);
        }
        return this._super('format', [value]);
    },
    checkAcl: function (action, module) {
        if (app.acl.hasAccess(action, module) === false) {
            this.$(this.typeFieldTag).select2("disable");
        } else {
            this.$(this.typeFieldTag).select2("enable");
        }
    },
    setValue: function (model) {
         
        if (!model) {
            return;
        }
        var silent = model.silent || false,
                module = model.module || model._module;
        this._createFiltersCollection();
        if (app.acl.hasAccessToModel(this.action, this.model, this.name)) {
            if (module) {
                this.model.set('target_parent_type', module, {
                    silent: silent
                });
            }
            if (!_.isUndefined(model.id)) {
                this.model.set('target_parent_id', model.id, {
                    silent: silent
                });
                var value = model.value || model[this.def.rname || 'name'] || model['full_name'];
                this.model.set('target_parent_name', value, {
                    silent: silent
                });
            }
        }
    },
    isAvailableParentType: function (module) {
        var moduleFound = _.find(this.$(this.typeFieldTag).find('option'), function (dom) {
            return $(dom).val() === module;
        });
        return !!moduleFound;
    },
    getSearchModule: function () {
        return this.model.get('target_parent_type') || this.$(this.typeFieldTag).val();
    },
    getPlaceHolder: function () {
        return app.lang.get('LBL_SEARCH_SELECT', this.module);
    },
    unbindDom: function () {
        this.$(this.typeFieldTag).select2('destroy');
        this._super("unbindDom");
    },
    bindDataChange: function () {
        this._super('bindDataChange');
        if (this.model) {
            this.model.on('change:target_parent_type', function () {
                if (_.isEmpty(this.$(this.typeFieldTag).data('select2'))) {
                    this.render();
                } else {
                    this.$(this.typeFieldTag).select2('val', this.model.get('target_parent_type'));
                }
            }, this);
        }
    }
})