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

namespace Sugarcrm\Sugarcrm\JobQueue\LockStrategy;

/**
 * Class LockStrategyInterface
 * @package JobQueue
 */
interface LockStrategyInterface
{
    /**
     * Check lock actuality.
     * Actual lock has no value or has it with own id.
     *
     * @return bool
     */
    public function isActual();

    /**
     * Check lock existence.
     *
     * @return bool
     */
    public function hasLock();

    /**
     * Get lock value.
     *
     * @return bool|string Returns data on success, false otherwise.
     */
    public function getLock();

    /**
     * Save lock.
     *
     * @param mixed $value
     */
    public function setLock($value);

    /**
     * Clear a value out of lock storage.
     *
     * @return bool true on success or false on failure.
     */
    public function clearLock();
}
