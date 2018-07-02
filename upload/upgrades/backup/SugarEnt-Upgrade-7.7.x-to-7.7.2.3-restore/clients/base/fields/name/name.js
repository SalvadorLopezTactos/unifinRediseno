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
({plugins:['EllipsisInline','MetadataEventDriven'],initialize:function(options){this._super('initialize',[options]);this.ellipsis=_.isUndefined(this.def.ellipsis)||this.def.ellipsis;},_render:function(){if(this.view.name==='audit'){this.def.link=false;}else if(this.view.name==='preview'){this.def.link=_.isUndefined(this.def.link)?true:this.def.link;this.def.events=false;}
this._super('_render');}})