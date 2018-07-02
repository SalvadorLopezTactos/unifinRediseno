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
({_render:function(){if(this.name==='type'){this._ensureSelectedValueInItems();}
this._super('_render');},_ensureSelectedValueInItems:function(){var value=this.model.get(this.name),meetingTypeLabels;if(!this.items||_.isEmpty(this.items)||_.isEmpty(value)){return;}
meetingTypeLabels=app.lang.getAppListStrings('eapm_list');if(_.isEmpty(this.items[value])&&!_.isEmpty(meetingTypeLabels[value])){this.items[value]=meetingTypeLabels[value];}},loadEnumOptions:function(fetch,callback){if(this.name==='type'){this.def.options='';}
this._super('loadEnumOptions',[fetch,callback]);}})