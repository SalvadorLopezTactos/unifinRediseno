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
({events:{'click .accordion-toggle':'onAccordionToggleClicked'},collapseDivId:'config-accordion',selectedPanel:'',currentHowToData:undefined,initialize:function(options){this._super('initialize',[options]);this.currentHowToData={};this._initHowTo();},_render:function(){this._super('_render');this.$el.addClass('accordion');this.$el.attr('id',this.collapseDivId);this.$('.collapse').collapse({toggle:false,parent:'#'+this.collapseDivId});this.selectPanel(_.first(this.meta.components).view);},selectPanel:function(panelName){this.selectedPanel=panelName;this.$('#'+panelName+'Collapse').collapse('show');this.onAccordionToggleClicked();},onAccordionToggleClicked:function(evt){var helpId=(evt)?$(evt.currentTarget).data('help-id'):this.selectedPanel;this._switchHowToData(helpId);this.context.trigger('config:howtoData:change',this.currentHowToData);},_initHowTo:function(){},_switchHowToData:function(helpId){},changeHowToData:function(title,text){this.currentHowToData.title=title;this.currentHowToData.text=text;this.context.trigger('config:howtoData:change',this.currentHowToData);}})