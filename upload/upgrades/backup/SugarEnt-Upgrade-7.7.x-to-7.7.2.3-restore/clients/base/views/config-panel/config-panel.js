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
({titleSelectedValues:'',titleViewNameTitle:'',toggleTitleTpl:{},titleTemplateVars:{},initialize:function(options){this._super('initialize',[options]);this.toggleTitleTpl=app.template.getView('config-panel.title');if(this.meta.label){this.titleViewNameTitle=app.lang.get(this.meta.label,this.module);}},_render:function(){this._super('_render');this.$el.addClass('accordion-group');this.updateTitle();},updateTitle:function(){this._updateTitleValues();this._updateTitleTemplateVars();this.$('#'+this.name+'Title').html(this.toggleTitleTpl(this.titleTemplateVars));},_updateTitleValues:function(){this.titleSelectedValues=this.model.get(this.name);},_updateTitleTemplateVars:function(){this.titleTemplateVars={title:this.titleViewNameTitle,selectedValues:this.titleSelectedValues,viewName:this.name};}})