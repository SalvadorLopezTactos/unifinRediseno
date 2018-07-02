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
({extendsFrom:'MergeDuplicatesView',_savePrimary:function(){var self=this;var primaryRecordName=this.primaryRecord.get('name');var tagCollection=app.data.createBeanCollection('Tags');tagCollection.filterDef={'filter':[{'name_lower':{'$equals':primaryRecordName.toLowerCase()}}]};tagCollection.fetch({success:function(tags){if(tags.length>0&&_.isEmpty(_.intersection(_.keys(self.rowFields),_.pluck(tags.models,'id')))){app.alert.show('tag_duplicate',{level:'warning',messages:app.lang.get('LBL_EDIT_DUPLICATE_FOUND','Tags')});}else{var fields=self.getFieldNames().filter(function(field){return app.acl.hasAccessToModel('edit',self.primaryRecord,field);},self);self.primaryRecord.trigger('duplicate:unformat:field');self.primaryRecord.save({},{fieldsToValidate:fields,success:function(){self.primaryRecord.trigger('duplicate:format:field');self.primaryRecord.trigger('mergeduplicates:primary:saved');},error:function(error){if(error.status===409){app.utils.resolve409Conflict(error,self.primaryRecord,function(model,isDatabaseData){if(model){if(isDatabaseData){self.resetRadioSelection(model.id);}else{self._savePrimary();}}});}},lastModified:self.primaryRecord.get('date_modified'),showAlerts:true,viewed:true,params:{verifiedUnique:true}});}}});}})