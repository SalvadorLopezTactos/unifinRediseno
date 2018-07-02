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
({extendsFrom:'FieldsetField',plugins:['EllipsisInline'],formatMap:{'f':'first_name','l':'last_name','s':'salutation'},initialize:function(options){var formatPlaceholder=app.user.getPreference('default_locale_name_format')||'';this._super('initialize',[options]);if(!this.module){app.logger.error('Fullname field requires a module');this.dispose();return;}
var meta=app.metadata.getModule(this.module);this.formatMap=meta.formatMap||this.formatMap;this.def.fields=_.reduce(formatPlaceholder.split(''),function(fields,letter){if(letter>='a'&&letter<='z'&&this.formatMap[letter]){var fieldMeta=meta.fields[this.formatMap[letter]];if(fieldMeta){fields.push(_.clone(fieldMeta));}}
return fields;},[],this);this.def.fields=app.metadata._patchFields(this.module,meta,this.def.fields);if(this.def&&this.def.link&&app.acl.hasAccessToModel('view',this.model)){var action=this.def.route&&this.def.route.action?this.def.route.action:'';this.href='#'+app.router.buildRoute(this.module||this.context,this.model.id,action,this.def.bwcLink);}},_loadTemplate:function(){this._super('_loadTemplate');var template=app.template.getField(this.type,this.view.name+'-'+this.tplName,this.model.module);if(!template&&this.view.meta&&this.view.meta.template){template=app.template.getField(this.type,this.view.meta.template+'-'+this.tplName,this.model.module);}
this.template=template||this.template;},format:function(){return app.utils.formatNameModel(this.model.module,this.model.attributes);},bindDataChange:function(){if(this.model){this.model.on("change:"+this.name,function(){if(this.action!=='edit'){this.render();}},this);_.each(this.def.fields,function(field){this.model.on("change:"+field.name,this.updateValue,this);},this);}},updateValue:function(){this.model.set(this.name,this.format());},setMaxWidth:function(width){this.$('.record-cell').children().css({'max-width':width});},getCellPadding:function(){var padding=0,$cell=this.$('.record-cell');if(!_.isEmpty($cell)){padding=parseInt($cell.css('padding-left'),10)+parseInt($cell.css('padding-right'),10);}
return padding;}})