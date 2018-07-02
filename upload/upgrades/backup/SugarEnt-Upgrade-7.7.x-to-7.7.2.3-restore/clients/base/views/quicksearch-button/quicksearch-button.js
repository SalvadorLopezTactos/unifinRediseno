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
({className:'quicksearch-button-wrapper',events:{'click [data-action=search_icon]':'searchIconClickHandler'},initialize:function(options){this._super('initialize',[options]);this.collection=this.layout.collection||app.data.createMixedBeanCollection();this.layout.on('quicksearch:close',function(){if(!this.context.get('search')){this.toggleSearchIcon(true);}},this);this.isFocusable=false;this.searchButtonIcon=true;this.layout.on('quicksearch:button:toggle',this.toggleSearchIcon,this);},toggleSearchIcon:function(searchButtonIcon){if(this.searchButtonIcon===searchButtonIcon){return;}
var iconEl=this.$('[data-action=search_icon] .fa').first();this.searchButtonIcon=searchButtonIcon;if(searchButtonIcon){iconEl.removeClass('fa-times');iconEl.addClass('fa-search');}else{iconEl.removeClass('fa-search');iconEl.addClass('fa-times');}},searchIconClickHandler:function(){if(this.searchButtonIcon){if(this.layout.isResponsiveMode){this.layout.trigger('quicksearch:expand');}else{this.layout.trigger('quicksearch:bar:search');}}else{this.layout.trigger('quicksearch:bar:clear');this.layout.trigger('quicksearch:close');}}})