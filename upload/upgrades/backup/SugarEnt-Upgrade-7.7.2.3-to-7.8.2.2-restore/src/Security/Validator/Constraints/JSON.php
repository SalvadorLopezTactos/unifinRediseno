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

namespace Sugarcrm\Sugarcrm\Security\Validator\Constraints;

use Sugarcrm\Sugarcrm\Security\Validator\ConstraintReturnValue;

/**
 *
 * @see JSONValidator
 *
 */
class JSON extends ConstraintReturnValue
{
    const ERROR_JSON_DECODE = 1;

    protected static $errorNames = array(
        self::ERROR_JSON_DECODE => 'ERROR_JSON_DECODE',
    );

    public $message = 'JSON decode data violation: %msg%';
    public $htmlDecode = false;
    public $assoc = true;
}
