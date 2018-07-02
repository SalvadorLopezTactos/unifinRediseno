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
(function(app){app.events.on("app:init",function(){app.plugins.register('EllipsisInline',['view','field'],{events:{'mouseenter .ellipsis_inline':'_showEllipsisTooltip','mouseleave .ellipsis_inline':'_hideEllipsisTooltip'},_$ellipsisTooltips:null,onAttach:function(){this.before('render',function(){this.destroyEllipsisTooltips();},this);this.on('render',function(){this.initializeEllipsisTooltips();},this);},onDetach:function(){this.destroyEllipsisTooltips();},initializeEllipsisTooltips:function(){var self=this;if(this._$ellipsisTooltips){app.utils.tooltip.destroy(this._$ellipsisTooltips);}
_.defer(function($element,options,direction){self._$ellipsisTooltips=app.utils.tooltip.initialize($element,options,direction);},this.$('.ellipsis_inline'),{trigger:'manual'},this.dir);},destroyEllipsisTooltips:function(){if(this._$ellipsisTooltips){app.utils.tooltip.destroy(this._$ellipsisTooltips);}
this._$ellipsisTooltips=null;},_showEllipsisTooltip:function(event){var target=event.currentTarget;if(this._shouldShowEllipsisTooltip(target)){app.utils.tooltip.show(target);}},_hideEllipsisTooltip:function(event){var target=event.currentTarget;if(this._shouldHideEllipsisTooltip(target)){app.utils.tooltip.hide(target);}},_shouldShowEllipsisTooltip:function(target){return app.utils.tooltip.has(target)&&(target.offsetWidth<target.scrollWidth);},_shouldHideEllipsisTooltip:function(target){var plugin=app.utils.tooltip.get(target);return plugin&&plugin.tip().hasClass('in');}});});})(SUGAR.App);