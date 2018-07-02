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
({extendsFrom:'HeaderpaneView',initialize:function(options){this._super('initialize',[options]);this.context.on('change:searchTerm change:tagParams',function(model,value){var tagParams=this.context.get('tagParams')||[];this.searchTerm={term:this.context.get('searchTerm'),tags:tagParams.join(', ')};this.render();},this);var tagParams=this.context.get('tagParams')||[];this.searchTerm={term:this.context.get('searchTerm'),tags:tagParams.join(', ')};},_formatTitle:function(title){if(!title){return'';}
return app.lang.get(title,this.module,{searchTerm:new Handlebars.SafeString(this.searchTerm)});},unbind:function(){this._super('unbind');$(window).off('resize.searchheader');this.layout.off('headerpane:adjust_fields',this.adjustTitle);}})