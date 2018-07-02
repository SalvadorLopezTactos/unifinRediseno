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
({extendsFrom:"WizardPageView",wizardName:"",initialize:function(options){this.events=_.extend({},this.events,{"click a.thumbnail":"linkClicked","click [name=start_sugar_button]:not(.disabled)":"next"});this._super("initialize",[options]);this.wizardName=this.context.get("wizardName")||"user";},isPageComplete:function(){return true;},linkClicked:function(ev){var href,redirectUrl,target=this.$(ev.currentTarget);if(this.$(target).attr("target")!=="_blank"){app.user.unset('show_wizard');ev.preventDefault();$("#header").show();href=this.$(target).attr("href");if(href.indexOf('#bwc/')===0){redirectUrl=href.split('#bwc/')[1];app.bwc.login(redirectUrl);}else{app.router.navigate($(ev.currentTarget).attr("href"),{trigger:true});}}},_dispose:function(){this._super('_dispose');app.user.unset('show_wizard');}})