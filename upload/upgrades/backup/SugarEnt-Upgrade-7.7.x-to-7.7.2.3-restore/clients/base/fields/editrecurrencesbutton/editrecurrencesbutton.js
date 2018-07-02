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
({extendsFrom:'RowactionField',initialize:function(options){this._super('initialize',[options]);this.type='rowaction';},_render:function(){if(_.isEmpty(this.model.get('repeat_type'))){this.hide();}else{this._super('_render');}},bindDataChange:function(){if(this.model){this.model.on('change:repeat_type',this.render,this);}},rowActionSelect:function(){this.context.trigger('all_recurrences:edit');}})