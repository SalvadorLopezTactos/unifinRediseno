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
({showNoData:false,'events':{'click .fa-favorite':'toggle'},plugins:['Tooltip'],initialize:function(options){options.def.readonly=true;app.view.Field.prototype.initialize.call(this,options);},_render:function(){if(!this.model.get('id')){return null;}
if(!app.metadata.getModule(this.model.module).favoritesEnabled){app.logger.error("Trying to use favorite field on a module that doesn't support it: '"+this.model.module+"'.");return null;}
return app.view.Field.prototype._render.call(this);},toggle:function(evt){var self=this,star=$(evt.currentTarget);var options={silent:true,alerts:false};if(self.view&&self.view.action==='list'){options.success=function(){self._refreshListView();};}
if(this.model.favorite(!this.model.isFavorite(),options)===false){app.logger.error("Unable to set '"+this.model.module+"' record '"+this.model.id+"' as favorite");return;}
if(this.model.isFavorite()){star.addClass('active');this.model.trigger("favorite:active");}
else{star.removeClass('active');}},format:function(){return this.model.isFavorite();},_refreshListView:function(){var filterPanelLayout=this.view;while(filterPanelLayout&&filterPanelLayout.name!=='filterpanel'){filterPanelLayout=filterPanelLayout.layout;}
if(filterPanelLayout&&!filterPanelLayout.disposed&&this.collection){filterPanelLayout.applyLastFilter(this.collection,'favorite');}}})