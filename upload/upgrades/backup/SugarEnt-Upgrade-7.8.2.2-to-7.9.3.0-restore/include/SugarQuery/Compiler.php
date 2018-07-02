<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

require_once('include/SugarQuery/Compiler/SQL.php');

/**
 * SugarQuery compiler
 *
 * @internal Should be only used by SugarQuery
 * @deprecated Use the actual compiler instead
 */
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
