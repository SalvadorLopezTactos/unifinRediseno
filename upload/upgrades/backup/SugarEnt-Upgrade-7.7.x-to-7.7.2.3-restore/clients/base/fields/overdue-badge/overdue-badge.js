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
({_render:function(){var now=new Date(),due_date=this.model.get(this.name),date=new Date(due_date);this.model.set('overdue',!_.isNull(due_date)&&date<now);this._super('_render');}})