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
({initialize:function(options){app.view.Layout.prototype.initialize.call(this,options);this.on('header:update:route',this.resize,this);app.events.on('app:view:change',this.resize,this);app.events.on('app:login',this.hide,this);app.events.on('app:login:success',this.show,this);var resize=_.bind(this.resize,this);$(window).off('resize.header').on('resize.header',resize);},_placeComponent:function(component){this.$el.find('.nav-collapse').append(component.$el);},resize:function(){var resizeWidth=this.getModuleListWidth();this.trigger('view:resize',resizeWidth);},getModuleListWidth:function(){var maxMenuWidth=$(window).width();var totalWidth=0;_.each(this._components,function(component){if(component.name!=='module-list'){if(component.$el.is(':visible')){totalWidth+=component.$el.outerWidth(true);}}});return maxMenuWidth-totalWidth;},getModuleListMinWidth:function(){var moduleListView=this.getComponent('module-list');if(moduleListView){return moduleListView.computeMinWidth();}},setModuleListResize:function(resize){this.getComponent('module-list').toggleResize(resize);},_render:function(){this._super('_render');if(app.api.isAuthenticated()){this.show();}else{this.hide();}},show:function(){this._super('show');this.resize();},showMenu:function(){app.logger.warn('showMenu is deprecated, please use show instead.');this.show();},hideMenu:function(){app.logger.warn('hideMenu is deprecated, please use hide instead.');this.hide();}})