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
(function(app){app.events.on('app:init',function(){app.plugins.register('Tooltip',['layout','view','field'],{_$pluginTooltips:null,_pluginTooltipCssSelector:'[rel=tooltip]',onAttach:function(){if(app.utils.isTouchDevice()){return;}
if((this instanceof app.view.View)||(this instanceof app.view.Field)){this.before('render',function(){this.destroyAllPluginTooltips();},this);this.on('render',function(){this.initializeAllPluginTooltips();},this);this.on('dismiss',this.removePluginTooltips,this);}else if(this instanceof app.view.Layout){this.on('init',function(){this.initializeAllPluginTooltips();},this);}},onDetach:function(){this.destroyAllPluginTooltips();},initializeAllPluginTooltips:function(){this.removePluginTooltips();this.addPluginTooltips();},destroyAllPluginTooltips:function(){this.removePluginTooltips();this._$pluginTooltips=null;},addPluginTooltips:function($element){var $tooltips=this._getPluginTooltips($element);if($tooltips.length>0){this._$pluginTooltips=(this._$pluginTooltips||$()).add(app.utils.tooltip.initialize($tooltips));$tooltips.on('click.tooltip',function(){var element=this,tooltip=app.utils.tooltip.get(element);if(tooltip&&tooltip.options&&tooltip.options.trigger.indexOf('click')===-1){app.utils.tooltip.hide(element);}});app.accessibility.run($tooltips,'click');}},removePluginTooltips:function($element){var $tooltips;if($element){$tooltips=this._getPluginTooltips($element);}else{$tooltips=this._$pluginTooltips;}
if($tooltips&&$tooltips.length>0){app.utils.tooltip.destroy($tooltips);}},_getPluginTooltips:function($element){var selector=this.pluginTooltipCssSelector||this._pluginTooltipCssSelector;return $element?$element.find(selector):this.$(selector);}});});})(SUGAR.App);(function($){$(function(){if(!Modernizr.touch){return;}
$.fn.tooltip=function(){return this;};});})(jQuery);