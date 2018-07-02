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
({extendsFrom:'SelectionListView',initialize:function(options){this.plugins=_.union(this.plugins,['MassCollection']);this.maxSelectedRecords=options.context.get('maxSelectedRecords');this.independentMassCollection=options.context.get('independentMassCollection')||true;options.meta=_.extend({},app.metadata.getView(options.module,'selection-list'),options.meta);this._super('initialize',[options]);},setSelectionMeta:function(options){options.meta.selection={type:'multi',isSearchAndSelectAction:true,disable_select_all_alert:!!this.maxSelectedRecords};},initializeEvents:function(){this.context.on('selection:select:fire',this._validateSelection,this);},_validateSelection:function(){var selectedModels=this.context.get('mass_collection');if(selectedModels.length>this.maxSelectedRecords){this._showMaxSelectedRecordsAlert();return;}
app.drawer.close(this._getCollectionAttributes(selectedModels));},_showMaxSelectedRecordsAlert:function(){var msg=app.lang.get('TPL_FILTER_MAX_NUMBER_RECORDS',this.module,{maxRecords:this.maxSelectedRecords});app.alert.show('too-many-selected-records',{level:'error',messages:msg,autoClose:false});},_getCollectionAttributes:function(collection){var attributes=_.map(collection.models,this._getModelAttributes,this);return attributes;}})