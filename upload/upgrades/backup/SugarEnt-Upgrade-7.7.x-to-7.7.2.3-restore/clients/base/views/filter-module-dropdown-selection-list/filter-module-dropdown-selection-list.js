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
({extendsFrom:'FilterModuleDropdownView',initialize:function(options){options.template=app.template.get('filter-module-dropdown');this._super('initialize',[options]);},getFilterList:function(){var filterList=this.context.get('filterList');if(this.layout.showingActivities){filterList=this._super('getFilterList');}
return filterList;},shouldDisableFilter:function(){return false;},_renderDropdown:function(){this._super('_renderDropdown');if(this.filterNode){this.filterNode.select2('val',this.module);}},handleChange:function(linkModuleName,linkName,silent){if(!silent){this.context.trigger('selection-list:reload',linkModuleName);}},getSelectionLabel:function(){return app.lang.get('LBL_MODULE')+'<i class="fa fa-caret-down"></i>';}})