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
({direction:'ltr',initialize:function(options){options=options||{};options.def=options.def||{};if(_.isUndefined(options.def.link)){options.def.link=true;}
this._super('initialize',[options]);},format:function(value){if(_.isArray(value)){var primaryEmail=_.find(value,function(email){return email.primary_address&&email.primary_address!=="0";});return primaryEmail?primaryEmail.email_address:'';}
return value;},unformat:function(value){var self=this,emails=this.model.get('email'),changed=false;if(!_.isArray(emails)){emails=[];}
_.each(emails,function(email,index){if(email.primary_address&&email.primary_address!=="0"&&email.email_address!==value)
{changed=true;emails[index].email_address=value;}},this);if(emails.length==0){emails.push({email_address:value,primary_address:"1",hasAnchor:false,_wasNotArray:true});changed=true;}
if(changed){this.model.set(this.name,emails);this.model.trigger('change:'+this.name,this,emails);}
return emails;}})