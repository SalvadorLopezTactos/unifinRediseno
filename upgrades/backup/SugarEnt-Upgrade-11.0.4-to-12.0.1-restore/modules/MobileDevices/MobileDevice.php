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

use Sugarcrm\Sugarcrm\PushNotification\ServiceFactory;

/**
 * Class MobileDevice
 */
class MobileDevice extends Basic
{
    public $module_dir = 'MobileDevices';
    public $object_name = 'MobileDevice';
    public $table_name = 'mobile_devices';
    public $module_name = 'MobileDevices';
    public $importable = false;

    /**
     * @var bool | \Sugarcrm\Sugarcrm\PushNotification\Service
     */
    protected $service = false;

    /**
     * @param false $check_notify
     * @return string
     */
    public function save($check_notify = false)
    {
        global $current_user;

        if (empty($this->assigned_user_id)) {
            $this->assigned_user_id = $current_user->id;
        }

        // ensure uniqueness of assigned_user_id, platform and device_id combination
        // avoiding use of db unique key since we are using soft delete
        $id = $this->getIdOfSameCombo();
        if (!empty($id)) {
            // don't proceed if
            // 1. we are creating a new record, or
            // 2. we are updating, and the existing one with the same combination is not the one we are updating
            if (!$this->isUpdate() || $this->id != $id) {
                return null;
            }
        }

        if (!$this->relayRequest()) {
            return null;
        }

        return parent::save($check_notify);
    }

    /**
     * {@inheritDoc}
     */
    public function mark_deleted($id)
    {
        $service = $this->getService();
        if (!$service || $service->delete($this->platform, $this->device_id) === false) {
            return;
        }
        parent::mark_deleted($id);
    }

    /**
     * @return false|mixed|\Sugarcrm\Sugarcrm\PushNotification\Service
     */
    protected function getService()
    {
        if (empty($this->service)) {
            $this->service = ServiceFactory::getService();
        }
        return $this->service;
    }

    /**
     * Relays the register/update request to the SugarPush service
     * @return bool
     */
    protected function relayRequest() : bool
    {
        $ret = false;
        $service = $this->getService();
        if ($service) {
            if ($this->isUpdate()) {
                $ret = $service->update($this->platform, $this->fetched_row['device_id'], $this->device_id);
            } else {
                $ret = $service->register($this->platform, $this->device_id);
            }
        }
        return $ret;
    }

    /**
     * @return string
     * @throws SugarQueryException
     */
    protected function getIdOfSameCombo() : string
    {
        $query = new SugarQuery();
        $query->select(['id']);
        $bean = BeanFactory::newBean('MobileDevices');

        $query->from($bean, ['team_security' => false, 'add_deleted' => true]);

        $query->where()->queryAnd()
            ->equals('assigned_user_id', $this->assigned_user_id)
            ->equals('device_id', $this->device_id)
            ->equals('platform', $this->platform);
        $query->limit(1);

        $rows = $query->execute();

        return empty($rows[0]['id']) ? '' : $rows[0]['id'];
    }
}
