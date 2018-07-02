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
({availableToggles:{},defaultToggle:null,initialize:function(options){this.toggleComponents=[];this.componentsList={};this.availableToggles=this.options.meta.available_toggles||this.availableToggles;this.defaultToggle=this.options.meta.default_toggle||this.defaultToggle;this._super('initialize',[options]);},initComponents:function(components,context,module){this._super('initComponents',[components,context,module]);_.each(this.componentsList,function(comp){if(_.isFunction(comp.initComponents)){comp.initComponents();}});if(this.defaultToggle){this.showComponent(this.defaultToggle);}
this.on('toggle:showcomponent',this.showComponent,this);},_placeComponent:function(component){if(!_.isUndefined(this.availableToggles[component.name])){this.toggleComponents.push(component);this.componentsList[component.name]=component;this._components.splice(this._components.indexOf(component),1);}else{component.render();this.getContainer(component).append(component.el);}},getContainer:function(component){return this.$el;},showComponent:function(name){var oldToggle=this.currentToggle;_.each(this.toggleComponents,function(component){if(component.name===name){component.show();}else{component.hide();}},this);if(this.componentsList[name]){this.componentsList[name].render();this._components.push(this.componentsList[name]);this.getContainer(this.componentsList[name]).append(this.componentsList[name].el);this.componentsList[name].trigger("append");this.componentsList[name]=null;}
this.currentToggle=name;this.trigger('toggle:change',name,oldToggle);},_dispose:function(){_.each(this.componentsList,function(component){if(component){component.dispose();}});this.componentsList={};this.toggleComponents=null;app.view.Layout.prototype._dispose.call(this);}})