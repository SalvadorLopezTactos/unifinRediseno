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
({extendsFrom:'ButtonField',initialize:function(options){this.options.def.events=_.extend({},this.options.def.events,{'click .rowaction':'rowActionSelect'});this._super('initialize',[options]);},rowActionSelect:function(evt){var eventName=$(evt.currentTarget).data('event')||this.def.event;if(eventName){this.getTarget().trigger(eventName,this.model,this,evt);}},getTarget:function(){var target;switch(this.def.target){case'view':target=this.view;break;case'layout':target=this.view.layout;break;default:target=this.view.context;}
return target;}})