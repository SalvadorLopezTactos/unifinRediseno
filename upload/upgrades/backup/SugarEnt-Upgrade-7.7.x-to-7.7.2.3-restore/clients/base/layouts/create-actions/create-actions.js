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
({plugins:['ShortcutSession'],shortcuts:['Sidebar:Toggle','Create:Save','Create:Cancel','Dropdown:More'],initialize:function(options){this._super('initialize',[options]);app.logger.warn('Warning: View.Layouts.Base.CreateActionsLayout is deprecated since 7.7.0 and will be '+'removed in 7.8.0. Use View.Layouts.Base.CreateLayout instead.');}})