<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

/*********************************************************************************
 * This resolves SugarCRM Bug # 52929
 * http://www.sugarcrm.com/support/bugs.html#issue_52929
 *
 * Jeff Bickart
 * Twitter: @bickart
 * Email: jeff @ neposystems.com
 * Blog: http://sugarcrm-dev.blogspot.com
 ********************************************************************************/

class SugarWidgetFieldLong extends SugarWidgetFieldDecimal
{
    /**
     * @deprecated Use __construct() instead
     */
    public function SugarWidgetFieldLong(&$layout_manager)
    {
        self::__construct($layout_manager);
    }

    public function __construct(&$layout_manager)
    {
        parent::__construct($layout_manager);
    }
}
