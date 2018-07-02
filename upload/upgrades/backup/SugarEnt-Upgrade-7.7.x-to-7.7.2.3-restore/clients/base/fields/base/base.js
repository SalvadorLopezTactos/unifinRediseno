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
({plugins:['EllipsisInline','Tooltip','MetadataEventDriven'],initialize:function(options){this.events=_.extend({},this.events,options.def.events);this._super('initialize',arguments);this.ellipsis=_.isUndefined(this.def.ellipsis)||this.def.ellipsis;},_render:function(){var action='view';if(this.def.link&&this.def.route){action=this.def.route.action;}
if(this.def.link&&app.acl.hasAccessToModel(action,this.model)){this.href=this.buildHref();}
app.view.Field.prototype._render.call(this);},buildHref:function(){var defRoute=this.def.route?this.def.route:{},module=this.model.module||this.context.get('module');return'#'+app.router.buildRoute(module,this.model.get('id'),defRoute.action,this.def.bwcLink);},unformat:function(value){return _.isString(value)?value.trim():value;}})