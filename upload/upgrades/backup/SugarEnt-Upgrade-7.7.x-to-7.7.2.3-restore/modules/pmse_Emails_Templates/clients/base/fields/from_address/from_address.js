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
({plugins:['Tooltip'],'events':{'keyup input[name=name]':'handleKeyup',"click .btn":"_showVarBook"},fieldTag:'input.inherit-width',_render:function(){if(this.view.name==='record'){this.def.link=false;}else if(this.view.name==='preview'){this.def.link=true;}
this._super('_render');},getFieldElement:function(){return this.$(this.fieldTag);},_showVarBook:function(){var addEmails=_.bind(function(emails){if(emails&&emails.length>0){this.model.set(this.name,this.buildVariablesString(emails));}},this);app.drawer.open({layout:"compose-addressbook",context:{module:"Emails",mixed:true}},function(emails){addEmails(emails);});},buildVariablesString:function(recipients){var result='',newExpression='',i=0;_.each(recipients.models,function(model){newExpression+=(i>0)?', ':'';newExpression+=model.attributes.email;i+=1;});result=newExpression;return result;},handleKeyup:_.throttle(function(){var searchedValue=this.$('input.inherit-width').val();if(searchedValue&&searchedValue.length>=3){this.context.trigger('input:name:keyup',searchedValue);}},1000,{leading:false})})