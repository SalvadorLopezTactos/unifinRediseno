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

require_once 'modules/pmse_Inbox/engine/PMSEElements/PMSEActivity.php';

class PMSEScriptTask extends PMSEActivity
{
    protected $currentUser;

    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        global $current_user;
        $this->currentUser = $current_user;
        parent::__construct();
    }

    /**
     * @param mixed $currentUser
     * @codeCoverageIgnore
     */
    public function setCurrentUser($currentUser)
    {
        $this->currentUser = $currentUser;
    }

    /**
     * @return mixed
     * @codeCoverageIgnore
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * @param $value
     * @param $bean
     * @return string|type
     */
    public function getCustomUser($value, $bean)
    {
        switch ($value) {
            case 'currentuser':
                $newValue = $this->userAssignmentHandler->getCurrentUserId();
                break;
            case 'supervisor':
                $newValue = $this->userAssignmentHandler->getSupervisorId($this->currentUser->id);
                break;
            case 'owner':
                $newValue = $this->userAssignmentHandler->getRecordOwnerId($bean->id, $bean->module_dir);
                break;
            default:
                $newValue = $value;
                break;
        }
        return $newValue;
    }
}
