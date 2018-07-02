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
({extendsFrom:'ButtonField',plugins:['EmailClientLaunch'],initialize:function(options){this._super('initialize',[options]);this._initEmailOptions();},_initEmailOptions:function(){var context=this.context.parent||this.context,parentModel=context.get('model');if(parentModel instanceof Backbone.Model){this._updateEmailOptions(parentModel);parentModel.on('change',function(model){this._updateEmailOptions(model);this.render();},this);}},_updateEmailOptions:function(parentModel){if(this.def.set_recipient_to_parent){this.addEmailOptions({to_addresses:[{bean:parentModel}]});}
if(this.def.set_related_to_parent){this.addEmailOptions({related:parentModel});}}})