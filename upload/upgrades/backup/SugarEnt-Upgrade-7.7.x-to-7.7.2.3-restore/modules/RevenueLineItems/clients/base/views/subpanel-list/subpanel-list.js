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
({extendsFrom:'SubpanelListView',parseFields:function(){var catalog=this._super('parseFields'),config=app.metadata.getModule('Forecasts','config'),isForecastSetup=(config&&config.is_setup);_.each(catalog,function(group,i){if(isForecastSetup){catalog[i]=_.filter(group,function(fieldMeta){if(fieldMeta.name.indexOf('_case')!=-1){var field='show_worksheet_'+fieldMeta.name.replace('_case','');return(config[field]==1);}
return true;});}else{catalog[i]=_.filter(group,function(fieldMeta){return(fieldMeta.name!='commit_stage');});}});return catalog;}})