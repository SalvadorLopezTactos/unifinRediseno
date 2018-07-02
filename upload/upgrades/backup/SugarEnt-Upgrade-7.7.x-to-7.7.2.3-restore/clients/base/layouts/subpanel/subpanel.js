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
({extendsFrom:'PanelLayout',dataView:'subpanel-list',initialize:function(options){options.type='panel';if(options.meta&&options.def&&options.def.override_subpanel_list_view){_.each(options.meta.components,function(def){if(def.view&&def.view.indexOf('subpanel-list')!==-1){def.view=options.def.override_subpanel_list_view;}});this.dataView=options.def.override_subpanel_list_view;if(options.meta.last_state.id){options.meta.last_state.id=options.def.override_subpanel_list_view;}}
if(options.meta&&options.def&&options.def.override_paneltop_view){_.each(options.meta.components,function(def){if(def.view&&def.view=='panel-top'){def.view=options.def.override_paneltop_view;}});}
this._super('initialize',[options]);if(this.dataView!=='subpanel-list'){this.context.set('dataView',this.dataView);}
var ignoreRole=this.context.get('ignore_role');if(ignoreRole){var collection=this.collection;var options=collection.getOption()||{};var params=options.params||{};params.ignore_role=ignoreRole;collection.setOption('params',params);}
if(this.context.parent){this.context.parent.on('subpanel:reload',function(args){app.logger.warn('`subpanel:reload` is deprecated. Use `context.reloadData()` to reload and expand.');if(!_.isUndefined(args)&&_.isArray(args.links)&&_.contains(args.links,this.context.get('link'))){this.context.reloadData({recursive:false});}},this);}},show:function(){this.context.set('hidden',false);this._super('show');},hide:function(){this.context.set('hidden',true);this._super('hide');}})