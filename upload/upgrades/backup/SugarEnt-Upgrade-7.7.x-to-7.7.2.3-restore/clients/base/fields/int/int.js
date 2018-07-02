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
({direction:'ltr',unformat:function(value){return app.utils.unformatNumberStringLocale(value,true);},format:function(value){var numberGroupSeparator='',decimalSeparator='';if(!this.def.disable_num_format){numberGroupSeparator=app.user.getPreference('number_grouping_separator')||',';decimalSeparator=app.user.getPreference('decimal_separator')||'.';}
return app.utils.formatNumber(value,0,0,numberGroupSeparator,decimalSeparator);}})