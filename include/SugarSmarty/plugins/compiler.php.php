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

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
function smarty_compiler_php($tag_arg, &$smarty)
{
    return '<?php';
}

function smarty_compiler_phpclose($tag_arg, &$smarty)
{
    return '?>';
}
