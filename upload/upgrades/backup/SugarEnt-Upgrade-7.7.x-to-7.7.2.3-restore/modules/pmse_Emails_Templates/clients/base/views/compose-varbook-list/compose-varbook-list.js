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
({extendsFrom:'FlexListView',plugins:['ListColumnEllipsis','ListRemoveLinks','Pagination','MassCollection'],unbindData:function(){var massCollection=this.context.get('mass_collection');if(massCollection){massCollection.off(null,null,this);}
this._super("unbindData");},getFieldNames:function(module){return['name','email'];},_render:function(){this._super("_render");var massCollection=this.context.get('mass_collection'),selectedRecipientsFieldName='compose_varbook_selected_variables';if(massCollection){massCollection.off(null,null,this);massCollection.on('add',function(model){var existingRecipients=this.model.get(selectedRecipientsFieldName);if(model.id&&existingRecipients instanceof Backbone.Collection){existingRecipients.add(model);}},this);massCollection.on('remove',function(model){var existingRecipients=this.model.get(selectedRecipientsFieldName);if(model.id&&existingRecipients instanceof Backbone.Collection){existingRecipients.remove(model);}},this);massCollection.on('reset',function(newCollection,prevCollection){var existingRecipients=this.model.get(selectedRecipientsFieldName);if(existingRecipients instanceof Backbone.Collection){if(newCollection.length>0){newCollection.add(prevCollection.previousModels);}else{newCollection.add(_.difference(prevCollection.previousModels,this.collection.models));}
existingRecipients.reset(newCollection.models);}},this);var existingRecipients=this.model.get(selectedRecipientsFieldName);if(existingRecipients instanceof Backbone.Collection&&existingRecipients.length>0){var recipientsToPreselect=existingRecipients.filter(_.bind(function(recipient){return(this.collection.where({id:recipient.get('id')}).length>0);},this));if(recipientsToPreselect.length>0){massCollection.add(recipientsToPreselect);}}}},_renderField:function(field){if(field.name=='_module'){field.model.set(field.name,app.lang.get('LBL_MODULE_NAME',field.module));}
this._super("_renderField",[field]);}})