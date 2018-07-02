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
({extendsFrom:'RecordView',initialize:function(options){this.plugins=_.union(this.plugins||[],['HistoricalSummary','CommittedDeleteWarning']);this._super('initialize',[options]);app.utils.hideForecastCommitStageField(this.meta.panels);},cancelClicked:function(){var changedAttributes=this.model.changedAttributes(this.model.getSynced());this.model.set(changedAttributes,{revert:true});this._super('cancelClicked');},getCustomSaveOptions:function(options){var origSuccess=options.success;return{success:_.bind(function(){if(_.isFunction(origSuccess)){origSuccess();}
if(!_.isEmpty(this.model.get('quote_id'))){app.alert.show('save_rli_quote_notice',{level:'info',messages:app.lang.get('SAVE_RLI_QUOTE_NOTICE','RevenueLineItems'),autoClose:true});}},this)};},bindDataChange:function(){this.model.on('duplicate:before',this._handleDuplicateBefore,this);this._super('bindDataChange');},_handleDuplicateBefore:function(new_model){new_model.unset('quote_id');new_model.unset('quote_name');}})