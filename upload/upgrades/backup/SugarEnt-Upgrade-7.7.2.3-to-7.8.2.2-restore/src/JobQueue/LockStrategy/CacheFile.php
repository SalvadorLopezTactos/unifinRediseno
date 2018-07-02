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
 * Class CacheFile
 * @package JobQueue
 */
class CacheFile implements LockStrategyInterface
{
    /**
     * Lock key in external storage.
     */
    const LOCK_KEY = 'queueManager.lock';

    /**
     * @var int $lockTime Timestamp. Time when the strategy locked.
     */
    protected $lockTime = null;

    /**
     * Check object's value with a value from the file in cache.
     * {@inheritdoc}
     */
    public function isActual()
    {
        if ($this->hasLock()) {
            if ($this->getLock() != $this->lockTime) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check file existence.
     * {@inheritdoc}
     */
    public function hasLock()
    {
        return file_exists(sugar_cached(self::LOCK_KEY));
    }

    /**
     * Get value from cached file.
     * {@inheritdoc}
     */
    public function getLock()
    {
        if (!$this->hasLock()) {
            return false;
        }
        return sugar_file_get_contents(sugar_cached(self::LOCK_KEY));
    }

    /**
     * Save cache lock.
     * {@inheritdoc}
     * @param int $timestamp Unix timestamp.
     */
    public function setLock($timestamp)
    {
        $this->lockTime = $timestamp;
        sugar_file_put_contents(sugar_cached(self::LOCK_KEY), $timestamp);
    }

    /**
     * Unlink the cache file.
     * {@inheritdoc}
     */
    public function clearLock()
    {
        $this->lockTime = null;
        if ($this->hasLock()) {
            return unlink(sugar_cached(self::LOCK_KEY));
        }
        return true;
    }
}
