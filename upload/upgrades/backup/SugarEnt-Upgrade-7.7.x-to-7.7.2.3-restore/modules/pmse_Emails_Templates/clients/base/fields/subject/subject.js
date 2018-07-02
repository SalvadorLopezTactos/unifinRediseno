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
({plugins:['EllipsisInline'],'events':{'keyup input[name=name]':'handleKeyup',"click .btn":"_showVarBook"},fieldTag:'input.inherit-width',_render:function(){if(this.view.name==='record'){this.def.link=false;}else if(this.view.name==='preview'){this.def.link=true;}
this._super('_render');},getFieldElement:function(){return this.$(this.fieldTag);},_showVarBook:function(){var addVariables=_.bind(function(variables){if(variables&&variables.length>0){this.model.set(this.name,this.buildVariablesString(variables));}},this);app.drawer.open({layout:"compose-varbook",context:{module:"pmse_Emails_Templates",mixed:true}},function(variables){addVariables(variables);});},buildVariablesString:function(recipients){var result='',newExpression='',currentValue,i,aux,aux2;_.each(recipients.models,function(model){newExpression+='{::'+App.lang.getModuleName(model.attributes.rhs_module,{plural:true})+'::'+model.attributes.id+'::}'});var input=this.getFieldElement().get(0);;currentValue=input.value;i=input.selectionStart;result=currentValue.substr(0,i)+newExpression+currentValue.substr(i);return result;},handleKeyup:_.throttle(function(){var searchedValue=this.$('input.inherit-width').val();if(searchedValue&&searchedValue.length>=3){this.context.trigger('input:name:keyup',searchedValue);}},1000,{leading:false})})