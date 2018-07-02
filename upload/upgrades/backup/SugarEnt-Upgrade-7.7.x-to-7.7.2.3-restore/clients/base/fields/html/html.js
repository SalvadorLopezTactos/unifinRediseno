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
({fieldSelector:'.htmlareafield',direction:'ltr',initialize:function(options){options.def.readonly=true;this._super('initialize',[options]);},_render:function(){app.view.Field.prototype._render.call(this);this._getFieldElement().attr('name',this.name);this.setViewContent();},setViewContent:function(){var value=this.value||this.def.default_value;var field=this._getFieldElement();if(field&&field.get(0)&&!_.isEmpty(field.get(0).contentDocument)){if(field.contents().find('body').length>0){field.contents().find('body').html(value);}}},_getFieldElement:function(){return this.$el.find(this.fieldSelector);}})