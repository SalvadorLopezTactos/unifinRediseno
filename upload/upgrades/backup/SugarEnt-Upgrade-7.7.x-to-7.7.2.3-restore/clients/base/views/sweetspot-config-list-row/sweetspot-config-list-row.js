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
({tagName:'tr',className:'config-list-row',events:{'click [data-action=add]':'addRow','click [data-action=remove]':'removeRow'},initialize:function(options){options.model=app.data.createBean();this._super('initialize',[options]);this.prepareActionDropdown();this.collection.add(options.model);},prepareActionDropdown:function(){var field=_.find(this.meta.fields,function(field){return field.name==='action';});var actions=app.metadata.getSweetspotActions();var options={};_.each(actions,function(action,id){options[id]=action.name;});field.options=options;},addRow:function(){this.context.trigger('sweetspot:config:addRow',this);},removeRow:function(){this.context.trigger('sweetspot:config:removeRow',this);}})