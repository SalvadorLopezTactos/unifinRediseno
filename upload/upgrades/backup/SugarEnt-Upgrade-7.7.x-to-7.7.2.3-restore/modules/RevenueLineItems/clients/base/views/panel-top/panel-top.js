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
({extendsFrom:'PanelTopView',initialize:function(options){this._super("initialize",[options]);if(this.parentModule=="Accounts"){this.context.parent.on('editablelist:save',this._reloadOpportunities,this);this.meta.buttons=_.filter(this.meta.buttons,function(item){if(item.type!="actiondropdown"){return true;}
return false;});}},_reloadOpportunities:function(){var $oppsSubpanel=$('div[data-subpanel-link="opportunities"]');if($('li.subpanel',$oppsSubpanel).hasClass('closed')){if($('table.dataTable',$oppsSubpanel).length){this.context.parent.trigger('subpanel:reload',{links:['opportunities']});}else{this.context.parent.trigger('subpanel:reload');}}
else{this.context.parent.trigger('subpanel:reload',{links:['opportunities']});}},bindDataChange:function(){this._super('bindDataChange');this.context.parent.on('subpanel:reload',function(args){if(!_.isUndefined(args)&&_.isArray(args.links)&&_.contains(args.links,this.context.get('link'))){this.context.set('skipFetch',false);this.context.reloadData({recursive:false});}},this);},createRelatedClicked:function(event){app.alert.dismiss('opp-rli-create');this._super("createRelatedClicked",[event]);}})