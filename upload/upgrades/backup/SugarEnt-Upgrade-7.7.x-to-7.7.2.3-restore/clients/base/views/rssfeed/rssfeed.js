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
({plugins:['Dashlet'],_defaultOptions:{limit:5,auto_refresh:0},initialize:function(options){options.meta=options.meta||{};this._super('initialize',[options]);this.loadData(options.meta);},initDashlet:function(){if(!this.meta.config){var options={};var self=this;var refreshRate;options.limit=this.settings.get('limit')||this._defaultOptions.limit;this.settings.set('limit',options.limit);options.auto_refresh=this.settings.get('auto_refresh')||this._defaultOptions.auto_refresh;this.settings.set('auto_refresh',options.auto_refresh);options.feed_url=this.settings.get('feed_url');refreshRate=options.auto_refresh*60000;if(refreshRate>0){if(this.timerId){clearInterval(this.timerId);}
this.timerId=setInterval(_.bind(function(){if(self.context){self.context.resetLoadFlag();self.loadData(options);}},this),refreshRate);}}
this.layout.before('dashletconfig:save',function(){var fields=_.flatten(_.pluck(this.meta.panels,'fields'));var notValid=_.filter(fields,function(field){return field.required&&!this.dashModel.get(field.name);},this);if(notValid.length===0){return true;}
_.each(notValid,function(field){var fieldOnView=_.find(this.fields,function(comp,cid){return comp.name===field.name;});fieldOnView.model.trigger('error:validation:'+field.name,{required:true});},this);return false;},this);},handleFeed:function(data){if(this.disposed){return;}
_.extend(this,data);this.render();},loadData:function(options){if(options&&options.feed_url){var callbacks={success:_.bind(this.handleFeed,this),error:_.bind(this.handleFeed,this)},limit=options.limit||this._defaultOptions.limit,params={feed_url:options.feed_url,limit:limit},apiUrl=app.api.buildURL('rssfeed','read','',params);app.api.call('read',apiUrl,{},callbacks);}},_renderHtml:function(){if(this.meta.config){this._super('_renderHtml');return;}
this._super('_renderHtml');}})