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
({initialize:function(options){var dSubpanels=app.utils.getDynamicSubpanelMetadata(this.options.module);if(dSubpanels.components){_.each(dSubpanels.components,function(sub){if(sub.layout){sub['override_paneltop_view']='panel-top-readonly';}},this);}
options.meta=_.extend(options.meta||{},dSubpanels);this._super('initialize',[options]);}})