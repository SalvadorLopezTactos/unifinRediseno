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
({extendsFrom:'EditablelistbuttonField',getCustomSaveOptions:function(options){var origSuccess=options.success;return{success:_.bind(function(){if(_.isFunction(origSuccess)){origSuccess.apply(this,arguments);}
if(this.model&&!_.isEmpty(this.model.get('quote_id'))){app.alert.show('save_rli_quote_notice',{level:'info',messages:app.lang.get('SAVE_RLI_QUOTE_NOTICE','RevenueLineItems'),autoClose:true});}
if(this.context.parent){this.context.parent.trigger('editablelist:save',this.model);}},this)};}});