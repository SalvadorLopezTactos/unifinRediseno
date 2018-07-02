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
({className:'row-fluid',initialize:function(options){this.HIDE_KEY='hide';this._defaultHide='0';this._hideLastStateKey=null;this._super('initialize',[options]);if(!_.isUndefined(this.meta.default_hide)){this._defaultHide=this.meta.default_hide;}
if(!_.isUndefined(this.meta.hide_key)){this.HIDE_KEY=this.meta.hide_key;}
this.on('sidebar:toggle',this.toggleSidePane,this);this.meta.last_state=this.meta.last_state||{id:'default'};this._hideLastStateKey=app.user.lastState.key(this.HIDE_KEY,this);this._toggleVisibility(this.isSidePaneVisible());},isSidePaneVisible:function(){var hideLastState=app.user.lastState.get(this._hideLastStateKey);var hidden=hideLastState||this._defaultHide;return!parseInt(hidden,10);},toggleSidePane:function(visible){var isVisible=this.isSidePaneVisible();visible=_.isUndefined(visible)?!isVisible:visible;if(isVisible===visible){return;}
app.user.lastState.set(this._hideLastStateKey,visible?'0':'1');this._toggleVisibility(visible);},_toggleVisibility:function(visible){this.$('.main-pane').toggleClass('span12',!visible).toggleClass('span8',visible);this.$('.side').toggleClass('side-collapsed',!visible);$(window).trigger('resize');this.trigger('sidebar:state:changed',visible?'open':'close');},_placeComponent:function(component){if(component.meta.name){this.$('.'+component.meta.name).append(component.$el);}},getPaneWidth:function(component){if(!this.$el){return 0;}
var paneSelectors=['.main-pane','.side'],pane=_.find(paneSelectors,function(selector){return($.contains(this.$(selector).get(0),component.el));},this);return this.$(pane).width()||0;}})