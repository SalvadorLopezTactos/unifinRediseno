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
({extendsFrom:'FilterRowsView',loadFilterFields:function(module){this._super('loadFilterFields',[module]);if(this.context.get('layout')==='records'){var bodyField=this.model.fields['kbdocument_body'];this.fieldList[bodyField.name]=bodyField;this.filterFields[bodyField.name]=app.lang.get(bodyField.vname,this.module);}}})