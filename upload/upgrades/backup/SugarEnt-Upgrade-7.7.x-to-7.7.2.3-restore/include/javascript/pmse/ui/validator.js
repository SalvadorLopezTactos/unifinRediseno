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
var Validator=function(options,parent){Base.call(this,options);this.parent=null;this.criteria=null;this.validated=false;this.valid=null;this.errorMessage=null;Validator.prototype.initObject.call(this,options,parent);};Validator.prototype=new Base();Validator.prototype.type='Validator';Validator.prototype.family='Validator';Validator.prototype.initObject=function(options,parent){var defaults={criteria:null,errorMessage:'the validation has failed'};$.extend(true,defaults,options);this.setCriteria(defaults.criteria).setParent(parent).setErrorMessage(defaults.errorMessage);};Validator.prototype.setErrorMessage=function(errorMessage){this.errorMessage=errorMessage;return this;};Validator.prototype.getErrorMessage=function(){return this.errorMessage;};Validator.prototype.setCriteria=function(criteria){this.criteria=criteria;return this;};Validator.prototype.setParent=function(parent){this.parent=parent;return this;};Validator.prototype.validate=function(){this.valid=true;};Validator.prototype.isValid=function(){this.validate();this.updateTooltip();return this.valid;};Validator.prototype.updateTooltip=function(){if(this.parent&&this.parent.errorTooltip){if(this.valid){$(this.parent.errorTooltip.html).removeClass('adam-tooltip-error-on').addClass('adam-tooltip-error-off');}else{this.parent.errorTooltip.setMessage(this.errorMessage);$(this.parent.errorTooltip.html).removeClass('adam-tooltip-error-off').addClass('adam-tooltip-error-on');}}};