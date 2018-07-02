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
    extendsFrom: 'DnbView',

    plugins: ['ErrorDecoration', 'Tooltip'],

    events: {
        'change [name="dnb_bal_sale"]': 'toggleFormControls',
        'change [name="dnb_bal_founding"]': 'toggleFormControls',
        'change [name="dnb_bal_offer_amt"]': 'toggleFormControls',
        'change [name="dnb_bal_ipo_price_range"]': 'toggleFormControls',
        'change [name="dnb_bal_ipo_date"]': 'toggleFormControls',
        'change [name="dnb_bal_emp_cnt"]': 'toggleFormControls',
        'change [name="dnb_bal_net_income"]': 'toggleFormControls',
        'change [name="dnb_bal_net_income_growth"]': 'toggleFormControls',
        'change [name="dnb_bal_assets"]': 'toggleFormControls',
        'change [name="dnb_bal_emp_grwth"]': 'toggleFormControls',
        'change [name="dnb_bal_mkt_cap"]': 'toggleFormControls',
        'change [name="dnb_bal_ipo_date_option_bef_aft"]': 'toggleFormControls',
        'click .dnb-bal-add-btn': 'populateTagContainer',
        'click .tagcontainer .select2-search-choice-close': 'removeTag',
        'change [name="dnb_bal_ctry"]': 'mapSelect2Params',
        'change [name="dnb_bal_prescreen_score"]': 'mapSelect2Params',
        'change [name="dnb_bal_job_fn"]': 'mapSelect2Params',
        'change [name="dnb_bal_ind_code_type"]': 'modifyIndustryModel',
        'change [name="dnb_bal_cntct_filter"]': 'setBalFilter',
        'shown #dnb_bal_accordian': 'handlePanelShown',
        'hidden #dnb_bal_accordian': 'handlePanelHidden',
        'mouseenter [rel="tooltip"]': 'showTooltip',
        'mouseleave [rel="tooltip"]': 'hideTooltip'
    },

    /**
     * @override
     * @param {Object} options
     */
    initialize: function(options) {
        this._super('initialize', [options]);
        this.balSelector = options.meta.balSelector;
        this.balParamGroups = options.meta.balParamGroups;
        app.events.register('dnbbal:invoke', this);
        app.error.errorName2Keys['comparison'] = 'ERR_DNB_BAL_COMPARISON';
        app.error.errorName2Keys['taglimit'] = 'LBL_DNB_BAL_PARAM_LIMIT_ERR';
        this.modelAttr = _.pluck(this.balSelector, 'modelKey');
        //add validation
        this.model.addValidationTask('comparison_check', _.bind(this._doValidateComparison, this));
        var fields = {};
        _.each(_.pluck(options.meta.panels,'rows'), function(rowObj) {
            _.each(rowObj, function(fieldsList) {
                _.each(_.flatten(fieldsList.fields), function(fieldObj) {
                    fields[fieldObj.name] = fieldObj;
                    if (!_.isUndefined(fieldObj.tooltip)) {
                        fieldObj.tooltip = app.lang.get(fieldObj.tooltip);
                    }
                });
            });
        });
        this.moduleFields = fields;
        var moduleNumber = 1;
        _.each(options.meta.panels, function(panelItem) {
            panelItem.moduleNumber = moduleNumber++;
        }, this);
        app.events.register('dnbbal:param:add', this);
        app.events.register('dnbbal:param:remove', this);
        app.events.register('dnbbal:param:err', this);
        this.layout.on('dnbbal:param:add', this.setPanelComplete, this);
        this.layout.on('dnbbal:param:remove', this.setPanelIncomplete, this);
        this.layout.on('dnbbal:param:err', this.alertValidationError, this);
        this.layout.on('dnbbal:param:clear', this.clearParams, this);
        //initializing tag templates
        this.tagTmpl1 = app.template.get(this.name + '.tagtmpl1');
        this.tagTmpl2 = app.template.get(this.name + '.tagtmpl2');
    },

    loadData: function() {
        this.title = this.meta.title;
        this.render();
    },

    /**
     * when opening a panel make it active
     * @param {Object} event
     */
    handlePanelShown: function(event) {
        this.$(event.target).siblings('div').addClass('active');
        var paramHeader = this.$(event.target).siblings('div').children('.dnb-params-header');
        this.$(paramHeader).addClass('hide');
    },

    /**
     * when closing a panel:
     * @param {Object} event
     * 1. Remove class active from accordion-heading
     * 2. If parameters are set display them in panel header
     */
    handlePanelHidden: function(event) {
        this.$(event.target).siblings('div').removeClass('active');
        var paramGrpKey = this.$(event.target).data('paramgrp');
        if (this.balParamGroups[paramGrpKey]) {
            var paramGrp = this.balParamGroups[paramGrpKey],
                panelHeader = [],
                tempStr;
            //get only this parameters that are set to the model
            var setParamKeys = _.filter(_.keys(paramGrp), function(paramKey) {
                return this.model.has(paramKey);
            }, this);
            _.each(setParamKeys, function(paramKey) {
                //if id is present it must be a tagContainer
                if (paramGrp[paramKey].id) {
                    if (paramGrp[paramKey].label) {
                        tempStr = app.lang.get(paramGrp[paramKey].label) + ':' + this.model.get(paramKey + 'Tags');
                    } else {
                        //if label is not set we need to set it based on user selection for industry
                        var industryCodeType = this.model.get(paramKey).IndustryCodeTypeCode,
                            industryLabel;
                        //If industryCodeType is 3599 then mark it as SIC Industry Code or if it is 700 mark it as NAICS code
                        if (industryCodeType === '3599') {
                            industryLabel = app.lang.get('LBL_DNB_BAL_SIC');
                        } else if (industryCodeType === '700') {
                            industryLabel = app.lang.get('LBL_DNB_BAL_NAICS');
                        }
                        tempStr = industryLabel + ':' + this.model.get(paramKey + 'Tags');
                    }
                } else if (paramGrp[paramKey].select2) {
                    //if select2 is present then get the tags
                    var selector = '[name="' + paramGrp[paramKey].select2 + '"]';
                    var select2Data = this.$(selector).select2('data'),
                        selectedData;
                    //this is when we have a drop down with multiple selection options
                    if (_.isArray(select2Data)) {
                        selectedData = _.map(select2Data, function(selectedObj) {
                            return selectedObj.text;
                        }, this);
                        tempStr = app.lang.get(paramGrp[paramKey].label) + ':' + selectedData.join(',');
                    } else {
                        //this is when we have a drop down with a single select options
                        selectedData = select2Data.text;
                        tempStr = app.lang.get(paramGrp[paramKey].label) + ':' + selectedData;
                    }
                }
                panelHeader.push(tempStr);
            }, this);
            if (panelHeader.length > 0) {
                var panelHeaderStr = ' : ' + panelHeader.join(' , '),
                    paramHeader = this.$(event.target).siblings('div').children('.dnb-params-header');
                this.$(paramHeader).removeClass('hide').text(panelHeaderStr);
            }
        }
    },

    /**
     * show / hide input box when the 'between' value of
     * drop down is selected
     * @param {Object} event
     */
    toggleFormControls: function(event) {
        var selector = event.currentTarget.name;
        if (selector) {
            var formControls = this.$('[name="' + selector + '"]').closest('.record-cell').siblings('.toggleCandidate');
            _.each(formControls, function(frmCntrl) {
               //Remove or hide class if "Between" is selected or unselected in the dropdown
                if (event.val === 'btw') {
                    this.$(frmCntrl).removeClass('hide');
                } else {
                    this.$(frmCntrl).addClass('hide');
                }
            }, this);
        }
    },

    /**
     * populates the tagcontainer with user criteria
     * @param {Object} event
     */
    populateTagContainer: function(event) {
        //get the balSelector key from the data-event property
        //balSelector key has all the meta information
        var balSelectorName = this.$(event.currentTarget).data('event');
        if (balSelectorName) {
            var paramMeta = this.balSelector[balSelectorName];
            //this loop is for greater than equal to like operators
            if (_.isString(paramMeta.operator)) {
                //this is for greater than equal to like operators
                this.handleComparisonOperator(paramMeta);
            } else if (_.isString(paramMeta.modelSubKey)) {
                //this loop is for parameter that are free form text like
                //DUNS, zip codes etc
                this.handleFreeFormTags(paramMeta);
            } else if (_.isArray(paramMeta.operator)) {
                this.handleMiscOperators(paramMeta);
            }
        }
    },

    /**
     * Append tags to container
     * //TODO: use select2 instead
     * @param {String} tagId
     * @param {String} tagText
     * @param {String} contSlct tagcontainer selector
     * @param {String} tmpl hbs template
     * @param {String} tagParent
     */
    appendTag: function(tagId, tagText, contSlct, tmpl, tagParent) {
        var compiledTmpl = tmpl({
            'tagText': tagText,
            'tagId': tagId,
            'tagParent': tagParent
        });
        this.$(contSlct).append(compiledTmpl);
    },

    /**
     * Enable green check box on panel
     * @param {String} selector
     */
    setPanelComplete: function(selector) {
        if (!this.$(selector).hasClass('complete')) {
            this.$(selector).addClass('complete');
        }
    },

    /**
     * Remove tags from the tag container
     * //TODO: use select2 instead
     * @param {Object} event
     */
    removeTag: function(event) {
        var selector = event.currentTarget,
            tagContainer = '#' + this.$(selector).closest('ul').attr('id');
        var modelKey = this.$(selector).siblings('div').attr('id'),
            parentKey = this.$(selector).siblings('div').data('parentkey'),
            triggerParam;
        if (selector) {
            this.$(selector).closest('li').remove();
        }
        if (this.model.has(modelKey)) {
            this.model.unset(modelKey);
            triggerParam = modelKey;
        } else {
            //this part of the code is to handle the case where the model
            // is an object with multiple attributes
            //each model key is an attribute
            var modelAttr = _.clone(this.model.get(parentKey));
            var tagCount = this.$(tagContainer).children().length;
            if (tagCount === 0) {
                this.model.unset(parentKey);
                triggerParam = parentKey;
            } else {
                delete modelAttr[modelKey];
                this.model.set(parentKey, modelAttr);
                triggerParam = modelKey;
            }
        }
        var tags = _.map(this.$(tagContainer).children(), function(tag) {
            return this.$(tag).children('div').text().trim();
        }, this);
        if (tags.length > 0) {
            this.model.set(parentKey + 'Tags', tags.join(','));
        } else {
            this.model.unset(parentKey + 'Tags');
        }
        this.triggerBAL();
        this.layout.trigger('dnbbal:param:remove', triggerParam);
    },

    /**
     * Disable green check box on panel
     * @param {String} modelKey
     */
    setPanelIncomplete: function(modelKey) {
        var disablePanelFlag = false, selector;
        //iterate thru the parameter groups and identify
        //which group the modelKey belongs to
        var paramGrp = _.find(_.keys(this.balParamGroups), function(paramGrpKey) {
            return _.has(this.balParamGroups[paramGrpKey], modelKey);
        }, this);
        if (this.balParamGroups[paramGrp]) {
            //within that paramGrp check if the
            //other parameters are set on the model
            //if no then set the panel as incomplete
            disablePanelFlag = _.find(_.keys(this.balParamGroups[paramGrp]), function(paramKey) {
                return this.model.has(paramKey);
            }, this);
            var balParamMeta = this.balParamGroups[paramGrp][modelKey];
            if (balParamMeta.id) {
                selector = this.$('#' + balParamMeta.id).closest('.accordion-body').siblings('div').children('.step-circle');
            } else if (balParamMeta.select2) {
                var select2Selector = '[name="' + balParamMeta.select2 + '"]';
                selector = this.$(select2Selector).closest('.accordion-body').siblings('div').children('.step-circle');
            }
            //if there are no other parameters in this param group set to model
            //then treat that accordion as incomplete
            if (_.isUndefined(disablePanelFlag) && this.$(selector).hasClass('complete')) {
                this.$(selector).removeClass('complete');
            }
        }
    },

    /**
     * Maps the select2 parameters to API request parameters
     * @param {Object} event
     */
    mapSelect2Params: function(event) {
        var modelMeta = this.balSelector[$(event.target).attr('name')] || {};
        var modelKey = modelMeta.modelKey,
            modelSubKey = modelMeta.modelSubKey,
            modelAttr;
        if (this.model.has(modelKey)) {
            modelAttr = _.clone(this.model.get(modelKey));
        } else {
            modelAttr = {};
        }
        if (event.added) {
            var paramIndex;
            //check if model has modelKey
            if (_.isEmpty(modelAttr)) {
                paramIndex = 1;
            } else {
                paramIndex = _.keys(modelAttr).length + 1;
            }
            //add data to modelKey
            if (modelMeta.multiple) {
                modelAttr[modelSubKey + paramIndex] = event.added.id;
            } else {
                modelAttr[modelSubKey] = event.added.id;
            }
        } else if (event.removed) {
            //remove the data from model
            var removedData = event.removed.id;
            //to do make this code more efficient
            _.each(modelAttr, function(value, key) {
                if (value === removedData) {
                    delete modelAttr[key];
                }
            }, this);
        }
        var accordionHeader = this.$(event.target).closest('.accordion-body').siblings('.accordion-heading').children('.step-circle');
        if (!_.isEmpty(modelAttr)) {
            this.model.set(modelKey, modelAttr);
            this.layout.trigger('dnbbal:param:add', accordionHeader);
        } else {
            this.model.unset(modelKey);
            this.layout.trigger('dnbbal:param:remove', modelKey);
        }
        this.triggerBAL();
        this.showSidePanel();
    },

    /**
     * Get user confirmation to change industry type code
     */
    modifyIndustryModel: function() {
        //check if model has industryCode
        if (this.model.has('industryCode')) {
            //warn user
            app.alert.show('dnb-industry-warning', {
                level: 'confirmation',
                title: 'LBL_WARNING',
                messages: 'LBL_DNB_BAL_INDUSTRY_WARN',
                onConfirm: _.bind(function() {
                    //if user says yes clear earlier parameters and tagcontainer
                    //clear the industryCode from model
                    this.model.unset('industryCode');
                    //clear the industryCode tags
                    this.model.unset('industryCodeTags');
                    this.$('#dnb-ind-code-tags').empty();
                }, this),
                onCancel: _.bind(function() {
                    //else do not allow the industryCode to be changed
                    var changedIndustryCode = this.model.get('dnb_bal_ind_code_type');
                    //If industryCodeType is 3599 then mark it as SIC Industry Code or if it is 700 mark it as NAICS code
                    if (changedIndustryCode === '3599') {
                        this.model.set('dnb_bal_ind_code_type', '700');
                    } else if (changedIndustryCode === '700') {
                        this.model.set('dnb_bal_ind_code_type', '3599');
                    }
                }, this)
            });
        }
    },

    /**
     * Validate and handle comparison operators
     * this is for greater than equal to like operators
     * @param {Object} paramMeta
     */
    handleComparisonOperator: function(paramMeta) {
        var tagCount = this.$(paramMeta.container).children().length;
        if (tagCount < paramMeta.tagLimit) {
            var fields = {};
            var operatorKey = paramMeta.operator;
            fields[operatorKey] = this.moduleFields[operatorKey];
            fields[operatorKey].objType = 'operator';
            fields[paramMeta.upperLimit] = this.moduleFields[paramMeta.upperLimit];
            fields[paramMeta.upperLimit].objType = 'upperLimit';
            fields[paramMeta.upperLimit].required = true;
            if (this.model.get(operatorKey) === 'btw') {
                fields[paramMeta.lowerLimit] = this.moduleFields[paramMeta.lowerLimit];
                fields[paramMeta.lowerLimit].required = true;
                fields[paramMeta.lowerLimit].objType = 'lowerLimit';
            }
            this.model.doValidate(fields, _.bind(function(isValid) {
                if (isValid) {
                    this.mapComparisonToApi(paramMeta);
                } else {
                    this.layout.trigger('dnbbal:param:err');
                }
            }, this));
        } else {
            //throw tag limit error
            this.layout.trigger('dnbbal:param:err', 'taglimit');
        }
    },

    /**
     * called post validation
     * Maps comparison operator inputs to D&B API parameters
     * @param {Object} paramMeta meta data of paramters
     */
    mapComparisonToApi: function(paramMeta) {
        var modelAttr = {}, modelKey = paramMeta.modelKey;
        this.clearValidationErrors(this.moduleFields);
        //if validation succeeds add it to model
        var operator = this.model.get(paramMeta.operator),
            upperLimit = this.model.get(paramMeta.upperLimit),
            lowerLimit = this.model.get(paramMeta.lowerLimit),
            operatorSelector = '[name="' + paramMeta.operator + '"]',
            lowKey, highKey;
        if (paramMeta.keyType) {
            var keyType = this.model.get(paramMeta.keyType);
            lowKey = paramMeta[keyType].lowKey;
            highKey = paramMeta[keyType].highKey;
        } else {
            lowKey = paramMeta.lowKey;
            highKey = paramMeta.highKey;
        }
        var tagText = this.$(operatorSelector).select2('data').text;
        // Check operator for gte => 'Greater than or Equal to' or lte => 'Lesser than or Equal to' or btw => 'Between'
        if (operator === 'btw') {
            tagText = tagText + ' ' + lowerLimit + ' ' + app.lang.get('LBL_DNB_AND') + ' ' + upperLimit;
            modelAttr[lowKey] = lowerLimit;
            modelAttr[highKey] = upperLimit;
        } else {
            tagText = tagText + ' ' + upperLimit;
            if (operator === 'lte') {
                modelAttr[highKey] = upperLimit;
            } else if (operator === 'gte') {
                modelAttr[lowKey] = upperLimit;
            }
        }
        this.model.set(modelKey + 'Tags', tagText);
        this.appendTag(modelKey, tagText, paramMeta.container, this.tagTmpl1);
        this.model.set(modelKey, modelAttr);
        this.triggerBAL();
        this.showSidePanel();
        var accordionHeader = this.$(paramMeta.container).closest('.accordion-body').siblings('.accordion-heading').children('.step-circle');
        this.layout.trigger('dnbbal:param:add', accordionHeader);
        this.model.unset(paramMeta.upperLimit);
        this.model.unset(paramMeta.lowerLimit);
    },

    /**
     * Validate comparison operators
     * @param {Object} fields
     * @param {Object} errors
     * @param {Function} callback
     */
    _doValidateComparison: function(fields, errors, callback) {
        errors = {};
        var comparisonField = _.find(fields, function(fieldObj) {
            return fieldObj.objType === 'operator';
        });
        if (!_.isUndefined(comparisonField)) {
            var comparisonType = this.model.get(comparisonField.name);
            var upperLimitField = _.find(fields, function(fieldObj) {
                return fieldObj.objType === 'upperLimit';
            });
            var upperLimit = this.model.get(upperLimitField.name);
            //check for empty field
            if (_.isUndefined(upperLimit)) {
                errors[upperLimitField.name] = errors[upperLimitField.name] || {};
            }
            if (comparisonType === 'btw') {
                //if operator === btw (between)
                var lowerLimitField = _.find(fields, function(fieldObj) {
                    return fieldObj.objType === 'lowerLimit';
                });
                var lowerLimit = this.model.get(lowerLimitField.name);
                //check for empty field
                if (_.isUndefined(lowerLimit)) {
                    errors[lowerLimitField.name] = errors[lowerLimitField.name] || {};
                } else if (lowerLimit >= upperLimit) {
                    errors[lowerLimitField.name] = errors[lowerLimitField.name] || {};
                    errors[lowerLimitField.name].comparison = true;
                }
            }
        }
        callback(null, fields, errors);
    },

    /**
     * Validate and handle free form text operators
     * @param {Object} paramMeta
     */
    handleFreeFormTags: function(paramMeta) {
        //this loop is for parameter that are free form text like
        //DUNS, zip codes etc
        var tagCount = this.$(paramMeta.container).children().length;
        if (tagCount < paramMeta.tagLimit) {
            var fields = {};
            fields[paramMeta.inputKey] = this.moduleFields[paramMeta.inputKey];
            fields[paramMeta.inputKey].objType = 'freeform';
            this.model.doValidate(fields, _.bind(function(isValid) {
                if (isValid) {
                    this.mapFreeFormToApi(paramMeta, tagCount);
                } else {
                    this.layout.trigger('dnbbal:param:err');
                }
            }, this));
        } else {
            //throw tag limit error
            this.layout.trigger('dnbbal:param:err', 'taglimit');
        }
    },

    /**
     * Post validation maps free form tags to api parameters
     * @param {Object} paramMeta
     * @param {Number} tagCount
     */
    mapFreeFormToApi: function(paramMeta, tagCount) {
        var modelAttr = {}, tagText, modelKey = paramMeta.modelKey, tagIndex;
        this.clearValidationErrors(this.moduleFields);
        //setting tagIndex to tagCount + 1
        tagIndex = tagCount + 1;
        //obtain user input
        tagText = this.model.get(paramMeta.inputKey);
        var tagId = paramMeta.tagLimit > 1 ? paramMeta.modelSubKey + tagIndex : paramMeta.modelSubKey;
        //add tag with tag id to tag container
        this.appendTag(tagId, tagText, paramMeta.container, this.tagTmpl2, modelKey);
        //clearing the input box
        this.model.unset(paramMeta.inputKey);
        //get the list of tags in the tag container
        var tags = _.map(this.$(paramMeta.container).children(), function(tag) {
            return this.$(tag).children('div').text().trim();
        }, this);
        //set it to model
        // this will be used to summarize the criteria selected by user
        // when panel is collapsed
        this.model.set(modelKey + 'Tags', tags.join(','));
        //translates the user tags to D&B api parameters
        _.each(tags, function(tagItem, index) {
            var tagIndex = index + 1;
            if(paramMeta.tagLimit > 1) {
                modelAttr[paramMeta.modelSubKey + tagIndex] = tagItem;
            } else {
                modelAttr[paramMeta.modelSubKey] = tagItem;
            }
        }, this);
        this.model.set(modelKey, modelAttr);
        this.triggerBAL();
        this.showSidePanel();
        //setting the panel header as completer
        var accordionHeader = this.$(paramMeta.container).closest('.accordion-body').siblings('.accordion-heading').children('.step-circle');
        //triggering bal
        this.layout.trigger('dnbbal:param:add', accordionHeader);
    },

    /**
     * Trigger BAL event
     */
    triggerBAL: function() {
        var balAttr = _.intersection(this.modelAttr, _.keys(this.model.attributes)),
            balParams = {};
        if (balAttr.length === 1 && balAttr[0] === 'balFilter') {
            return;
        }
        _.each(balAttr, function(paramName) {
            var tmpAttr = this.model.get(paramName);
            if (!_.isUndefined(tmpAttr)) {
                _.each(_.keys(tmpAttr), function(key) {
                    balParams[key] = tmpAttr[key];
                });
            }
        }, this);
        this.trigger('dnbbal:invoke', balParams);
    },

    /**
     * Validate and handle free form text operators
     * @param {Object} paramMeta
     */
    handleMiscOperators: function(paramMeta) {
        //this loop is for parameter that are free form text like
        //DUNS, zip codes etc
        var tagCount = this.$(paramMeta.container).children().length;
        if (tagCount < paramMeta.tagLimit) {
            var fields = {};
            _.each(paramMeta.operator, function(operatorKey) {
                fields[operatorKey] = this.moduleFields[operatorKey];
            }, this);
            if (paramMeta.tagSource) {
                fields[paramMeta.tagSource] = this.moduleFields[paramMeta.tagSource];
            }
            this.model.doValidate(fields, _.bind(function(isValid) {
                if (isValid) {
                    this.mapMiscOperatorToApi(paramMeta, tagCount);
                } else {
                    this.layout.trigger('dnbbal:param:err');
                }
            },this));
        } else {
            //throw tag limit error
            this.layout.trigger('dnbbal:param:err', 'taglimit');
        }
    },

    /**
     * Maps misc operators to D&B api parameters
     * @param {Object} paramMeta
     * @param {Number} tagCount
     */
    mapMiscOperatorToApi: function(paramMeta, tagCount) {
        var modelAttr = {}, tagText, modelKey = paramMeta.modelKey, tagIndex;
        this.clearValidationErrors(this.moduleFields);
        //this loop is to handle cases where there are multiple
        //drop downs like sic code, postal radius, employee number
        //map operator selections to model subkeys
        _.each(paramMeta.operator, function(operatorKey, index) {
            modelAttr[paramMeta.modelSubKey[index]] = this.model.get(operatorKey);
        }, this);
        //if tagSource exists then we have to create multiple tags
        var tagSource, tagId;
        if (paramMeta.tagSource) {
            tagSource = paramMeta.tagSource;
            tagIndex = tagCount + 1;
            //get the data entered by the user
            tagText = this.model.get(tagSource);
            //creating an id for the tag
            //this will help in detecting if a tag is deleted
            tagId = paramMeta.tagDest + tagIndex;
        } else {
            tagSource = _.last(paramMeta.operator);
            tagText = this.model.get(tagSource);
            tagId = modelKey;
            //need different text for postal radius search
            if (modelKey === 'radiusSearch') {
                var tagTextParts = [];
                tagTextParts.push(this.model.get('dnb_bal_distance'));
                tagTextParts.push(this.$('[name="dnb_bal_distance_units"]').select2('data').text);
                tagTextParts.push(app.lang.get('LBL_DNB_FROM'));
                tagTextParts.push(tagText);
                tagText = tagTextParts.join(' ');
                this.model.unset('dnb_bal_distance');
            }
        }
        this.appendTag(tagId, tagText, paramMeta.container, this.tagTmpl2, modelKey);
        //clearing the input box
        this.model.unset(tagSource);
        var tags = _.map(this.$(paramMeta.container).children(), function(tag) {
            return this.$(tag).children('div').text().trim();
        }, this);
        //adding the list of tags to model
        //this is used to display when accordion is collapsed
        if (modelKey === 'radiusSearch') {
            this.model.set(modelKey + 'Tags', tagText);
        } else {
            this.model.set(modelKey + 'Tags', tags.join(','));
        }
        //this is for the case where the criteria can have multiple tags
        if (paramMeta.tagDest) {
            _.each(tags, function(tagItem, index) {
                var tagIndex = index + 1;
                //for industry codes we need to add a wildcard
                if (paramMeta.tagDest === 'IndustryCode-') {
                    tagItem = tagItem + '*';
                }
                modelAttr[paramMeta.tagDest + tagIndex] = tagItem;
            }, this);
        }
        this.model.set(modelKey, modelAttr);
        this.triggerBAL();
        this.showSidePanel();
        var accordionHeader = this.$(paramMeta.container).closest('.accordion-body').siblings('.accordion-heading').children('.step-circle');
        this.layout.trigger('dnbbal:param:add', accordionHeader);
    },

    /**
     * Alert validation errors
     * @param {String} errorType
     */
    alertValidationError: function(errorType) {
        var msg;
        if (_.isUndefined(errorType)) {
            //generic error message
            msg = app.lang.get('ERR_RESOLVE_ERRORS');
        } else {
            //specific error message
            msg = app.lang.get(app.error.errorName2Keys[errorType]);
        }
        app.alert.show('dnb-bal-param-warning', {
            level: 'error',
            messages: msg
        });
    },

    showTooltip: function(e) {
        this.$(e.currentTarget).tooltip('show');
    },

    hideTooltip: function(e) {
        this.$(e.currentTarget).tooltip('hide');
    },

    unbindDom: function() {
        // Unbind all tooltips on page
        this.$('[rel="tooltip"]').each(function() {
            $(this).tooltip('destroy');
        });
        unbindTooltips('[rel="tooltip"]');
        this._super('unbindDom');
    },

    /**
     * Clear all the parameters from model and tagContainers
     */
    clearParams: function() {
        _.each(this.balSelector, function(balSlctObj) {
            //clear tag containers
            if (balSlctObj.container) {
                this.$(balSlctObj.container).empty();
            }
        }, this);
        this.clearValidationErrors(this.moduleFields);
        this.$('.step-circle').removeClass('complete');
        //remove the summarized parameters from all panels
        this.$('.dnb-params-header').empty();
        this.model.clear();
        this.triggerBAL();
        this.loadData();
    },

    /**
     * To open side-pane in BAL page
     */
    showSidePanel: function(event) {
        var defaultLayout = this.closestComponent('sidebar');
        if (defaultLayout) {
	        defaultLayout.trigger('sidebar:toggle', true);
        }
    },

    /**
     * Set filters on BAL
     * @param {Object} event
     */
    setBalFilter: function(event) {
        var name = $(event.target).attr('name');
        if (name) {
            //meta data for filter
            var modelMeta = this.balSelector[name] || {};
            //modelKey  = key to be set on model eb. balFilter
            //modelSubKey = name of property on object set to modelKey on model eg. InclusionDataDescription-1
            //model will look like {'balFilter': {'InclusionDataDescription-1': 'filterValue'}}
            var modelKey = modelMeta.modelKey || null,
                modelSubKey = modelMeta.modelSubKey || null,
                modelAttr;
            //if the model already has the modelKey
            //then clone the object so that it can be modified
            if (!_.isNull(modelKey) && this.model.has(modelKey)) {
                modelAttr = _.clone(this.model.get(modelKey));
            } else {
                modelAttr = {};
            }
            //add the newly added filter
            if (event.added.id) {
                //try to lookup if the event.added.id is a valid value in the filter lookup
                var filterValue = modelMeta.lookup[event.added.id];
                if (_.isUndefined(filterValue)) {
                    //this loop aims at clearing the filter
                    _.each(modelAttr, function(value, key) {
                        if (key.indexOf(modelSubKey) !== -1) {
                            delete modelAttr[key];
                        }
                    });
                } else {
                    //add data to modelKey
                    //modelKeys can have multiple values
                    //eg. InclusionDataDescription-1, InclusionDataDescription-2 .. InclusionDataDescription-n
                    if (modelMeta.multiple) {
                        var paramIndex = 1;
                        //check if model has modelKey
                        if (!_.isEmpty(modelAttr)) {
                            _.each(modelAttr, function(value, key) {
                                if (key.indexOf(modelSubKey) !== -1) {
                                    paramIndex++;
                                }
                            });
                        }
                        modelAttr[modelSubKey + paramIndex] = filterValue;
                    } else {
                        modelAttr[modelSubKey] = filterValue;
                    }
                }
            } else if (event.removed.id) {
                //remove the data from model
                var removedData = event.removed.id;
                //to do make this code more efficient
                _.each(modelAttr, function(value, key) {
                    if (value === removedData) {
                        delete modelAttr[key];
                    }
                }, this);
            }
            if (!_.isEmpty(modelAttr)) {
                //modify the bal panel heading based on the change in model
                var accordionHeader = this.$(event.target).closest('.accordion-body').siblings('.accordion-heading').children('.step-circle');
                this.model.set(modelKey, modelAttr);
                this.layout.trigger('dnbbal:param:add', accordionHeader);
            } else {
                this.model.unset(modelKey);
                this.layout.trigger('dnbbal:param:remove', modelKey);
            }
            //check if parameters apart from the filter are set before triggering bal
            this.triggerBAL();
        }
    }
})
