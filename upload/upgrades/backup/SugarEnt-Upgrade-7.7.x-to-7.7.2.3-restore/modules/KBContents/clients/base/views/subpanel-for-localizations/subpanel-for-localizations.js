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
({extendsFrom:'SubpanelListView',initialize:function(options){this._super('initialize',[options]);if(!app.acl.hasAccessToModel('edit',this.model)){this.context.set('requiredFilter','records-noedit');}
this.context.set('dataView','subpanel-for-localizations');},parseFieldMetadata:function(options){options=this._super('parseFieldMetadata',[options]);if(app.acl.hasAccess('edit',options.module)){return options;}
_.each(options.meta.panels,function(panel,panelIdx){_.each(panel.fields,function(field,fieldIdx){if(field.name==='status'){delete panel.fields[fieldIdx];}},this);},this);return options;}})