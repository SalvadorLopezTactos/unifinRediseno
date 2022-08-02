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

* Description: The functionality of the abstract DBHelper class has been moved to DBManager and
* its database specific derivatives. This class is no longer used and no code should be added
* this file or reference anything in this class. The sole purpose of keeping this class as
* an empty, deprecated and final class is to cause a conflict when merging functionality or bug fixes
* from upstream projects. MERGE CONFLICTS should be resolved by inspecting DBManager and derivatives
* for similar fixes and if none exist by porting the changes from DBHelper to DBManager or its derivatives.
*
* Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
* All Rights Reserved.
* Contributor(s): ______________________________________..
********************************************************************************/

/**
 * @deprecated
 * @internal
 */
final class DBHelper
{
}

?>
