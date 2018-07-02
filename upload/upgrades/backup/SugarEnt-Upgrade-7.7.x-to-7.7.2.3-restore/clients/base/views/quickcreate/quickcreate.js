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
({plugins:['Dropdown','Tooltip'],initialize:function(options){app.events.on("app:sync:complete",this.render,this);app.view.View.prototype.initialize.call(this,options);app.shortcuts.register(app.shortcuts.GLOBAL+'Create','c',function(){this.$('[data-toggle=dropdown]').click();},this);},_renderHtml:function(){if(!app.api.isAuthenticated()||app.config.appStatus=='offline'){return;}
if(app.isSynced){this.createMenuItems=this._getMenuMeta(app.metadata.getModuleNames({filter:['visible','quick_create'],access:'create'}));app.view.View.prototype._renderHtml.call(this);}},_getMenuMeta:function(modules){var returnList=[];_.each(modules,function(name){var meta=app.metadata.getModule(name);if(meta&&meta.menu&&meta.menu.quickcreate){var menuItem=_.clone(meta.menu.quickcreate.meta);if(menuItem.visible===true){menuItem.module=name;menuItem.type=menuItem.type||'quickcreate';if(!("icon"in menuItem)){menuItem.icon="fa fa-plus";}
menuItem.model=app.data.createBean(name);returnList.push(menuItem);}}},this);return this._sortByOrder(returnList);},_sortByOrder:function(moduleList){return moduleList.sort(function(a,b){var order=a['order']-b['order'];return(order==0)?(a['label']>b['label']):order;});}})