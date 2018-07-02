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
({initialize:function(options){this._super('initialize',[options]);this.collection=app.data.createMixedBeanCollection();app.shortcuts.register(app.shortcuts.GLOBAL+'Sweetspot','mod+shift+space',this.toggle,this,true);app.events.on('app:logout app:login',this.hide,this);app.events.on('app:sync:complete sweetspot:reset',this._setTheme,this);this.on('sweetspot:config',this.openConfigPanel,this);this.on('sweetspot:calc:resultsHeight',this.calculateResultsHeight,this);this._isVisible=false;},_render:function(){if(!this.isReady()){return;}
this._super('_render');this._setTheme();},_setTheme:function(){var prefs=app.user.getPreference('sweetspot');var theme=prefs&&prefs.theme;this.$el.removeAttr('data-theme');if(theme){this.$el.attr('data-theme',theme);}},_bindEvents:function(){this.createShortcuts();this.bindOutsideClick();this.bindResize();},_unbindEvents:function(){this.removeShortcuts();this.unbindOutsideClick();this.unbindResize();},bindOutsideClick:function(){$('body').bind('click.'+this.cid,_.bind(function(e){if($(e.target).closest('#sweetspot').length===0){this.hide();}},this));},unbindOutsideClick:function(){$('body').unbind('click.'+this.cid);},createShortcuts:function(){app.shortcuts.saveSession();app.shortcuts.createSession(['SweetSpot:Toggle:Off'],this);app.shortcuts.register('SweetSpot:Toggle:Off','esc',this.hide,this,true);},removeShortcuts:function(){app.shortcuts.restoreSession();},bindResize:function(){$(window).on('resize.sweetspot-'+this.cid,_.bind(this.calculateResultsHeight,this));},unbindResize:function(){$(window).off('resize.sweetspot-'+this.cid);},isReady:function(){return app.api.isAuthenticated()&&app.isSynced&&app.additionalComponents.header.isVisible();},isVisible:function(){return this._isVisible;},show:function(){if(this.isVisible()){return;}
if(!this.triggerBefore('show')){return false;}
if(!this.isReady()){return;}
this._isVisible=true;this.$('input').val('');this.$el.fadeToggle(50,'linear',_.bind(this.focusInput,this));this.trigger('show');this.calculateResultsHeight();this._bindEvents();},hide:function(){if(!this.isVisible()){return;}
if(!this.triggerBefore('hide')){return false;}
this._isVisible=false;this._unbindEvents();this.$el.fadeToggle(50,'linear');this.$el.removeClass('has-results');this.trigger('hide');},toggle:function(){if(this.isVisible()){this.hide();}else{this.show();}},focusInput:function(){this.$('input').focus();},openConfigPanel:function(){var activeDrawerLayout=app.drawer.getActive();if(activeDrawerLayout&&activeDrawerLayout.type==='sweetspot-config'){return;}
app.drawer.open({layout:'sweetspot-config',context:{skipFetch:true,forceNew:true}});},triggerSystemAction:function(method){if(!_.isFunction(this._systemActions[method])){return;}
this._systemActions[method].call(this);},_systemActions:{openConfig:function(){this.openConfigPanel();}},calculateResultsHeight:function(){var distanceToFooter=80;var resultsMaxHeight=$(window).height()-this.$el.offset().top-$('footer').height()-distanceToFooter;if(resultsMaxHeight>460){resultsMaxHeight=460;}
this.trigger('sweetspot:results:adjustMaxHeight',resultsMaxHeight);},_dispose:function(){this._unbindEvents();this._super('_dispose');}})