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
({extendsFrom:'ConfigPanelView',currentOppsViewBySetting:undefined,waitingForFieldItems:false,initialize:function(options){this._super('initialize',[options]);this.currentOppsViewBySetting=this.model.get('opps_view_by');},bindDataChange:function(){this.model.on('change:opps_view_by',function(){this.showRollupOptions();},this);},showRollupOptions:function(){if(this.currentOppsViewBySetting==='RevenueLineItems'&&this.model.get('opps_view_by')==='Opportunities'){this.getField('opps_closedate_rollup').show();this.$('[for=opps_closedate_rollup]').show();this.$('#sales-stage-text').show();if(!this.model.has('opps_closedate_rollup')){this.$('input[value="latest"]').prop('checked',true);}}else{this.getField('opps_closedate_rollup').hide();this.$('[for=opps_closedate_rollup]').hide();this.$('#sales-stage-text').hide();}
this.updateTitle();},_render:function(options){this._super('_render',[options]);this.showRollupOptions();},_updateTitleValues:function(){var items=this._getFieldOptions();if(items){var title='';if(items&&_.isObject(items)){title=items[this.model.get('opps_view_by')];}
this.titleSelectedValues=title;}},_getFieldOptions:function(){var f=this.getField('opps_view_by');if(_.isUndefined(f.items)){if(this.waitingForFieldItems===false){this.waitingForFieldItems=true;f.once('render',function(){this.waitingForFieldItems=false;this.updateTitle();},this);}
return false;}else{return f.items;}}})