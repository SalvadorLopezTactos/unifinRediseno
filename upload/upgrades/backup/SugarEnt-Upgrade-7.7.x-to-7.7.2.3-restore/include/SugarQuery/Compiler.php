<?php
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

require_once('include/SugarQuery/Compiler/SQL.php');

class SugarQuery_Compiler
{
	function __construct() {}

    /**
     * Compile a SugarQuery Object
     * Currently this only compiles SQL
     * @param SugarQuery $sugar_query
     * @return string
     */
    public function compile(SugarQuery $sugar_query, $db) {
		$compiler = new SugarQuery_Compiler_SQL($db);
		return $compiler->compile($sugar_query);
	}
}