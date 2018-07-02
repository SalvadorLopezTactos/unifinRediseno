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
(function(app){app.events.on('app:init',function(){app.plugins.register('QuickSearchFilter',['layout','view','field'],{getModuleQuickSearchMeta:function(searchModule){app.logger.warn('Plugins.QuickSearchFilter.getModuleQuickSearchMeta is deprecated since 7.6. '+'Please update your code to use Data.FiltersBean.getModuleQuickSearchMeta');var filtersBeanPrototype=app.data.getBeanClass('Filters').prototype;return filtersBeanPrototype.getModuleQuickSearchMeta(searchModule);},getModuleQuickSearchFields:function(searchModule){app.logger.warn('Plugins.QuickSearchFilter.getModuleQuickSearchFields is deprecated since 7.6. '+'Please update your code to use Data.FiltersBean.getModuleQuickSearchMeta');var filtersBeanPrototype=app.data.getBeanClass('Filters').prototype;return filtersBeanPrototype.getModuleQuickSearchMeta(searchModule).fieldNames;},getFilterDef:function(searchModule,searchTerm){app.logger.warn('Plugins.QuickSearchFilter.getFilterDef is deprecated since 7.6. '+'Please update your code to use Data.FiltersBean.buildSearchTermFilter');var filtersBeanPrototype=app.data.getBeanClass('Filters').prototype;return filtersBeanPrototype.buildSearchTermFilter(searchModule,searchTerm);}});});})(SUGAR.App);