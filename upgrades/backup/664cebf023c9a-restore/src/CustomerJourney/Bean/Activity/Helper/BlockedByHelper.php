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
namespace Sugarcrm\Sugarcrm\CustomerJourney\Bean\Activity\Helper;

use Sugarcrm\Sugarcrm\CustomerJourney\Bean\Activity\ActivityHandlerFactory;

/**
 * This class here to provide functions for the
 * block by activities
 */
class BlockedByHelper
{

    /**
     * @var Sugarcrm\Sugarcrm\CustomerJourney\Bean\Activity\Helper\stageHelper
     */
    private $stageHelper;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stageHelper = new StageHelper();
    }

     /**
     * Checks if a activity is blocked by another activity in the journey
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function isBlocked(\SugarBean $activity)
    {
        if (!$this->hasBlockedBy($activity)) {
            return false;
        }

        $blockedBy = $this->getBlockedBy($activity);

        return !empty($blockedBy);
    }

    /**
     * Checks if a activity is blocked by another stage in the journey
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function isBlockedByStage(\SugarBean $activity)
    {
        if (!$this->hasBlockedByStages($activity)) {
            return false;
        }

        $blockedByStages = $this->getNotCompletedBlockedByStages($activity);

        return !empty($blockedByStages);
    }

    /**
     * Checks if a activity template is configured with a blocked activity
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function hasBlockedBy(\SugarBean $activity)
    {
        return count($this->getBlockedByIds($activity)) > 0;
    }

    /**
     * Checks if a activity template is configured with a blocked stage
     *
     * @param \SugarBean $activity
     * @return bool
     */
    public function hasBlockedByStages(\SugarBean $activity)
    {
        return count($this->getBlockedByStageIds($activity)) > 0;
    }

    /**
     * Retrieves the activities in the journey that given activity is blocked by
     *
     * @param \SugarBean $activity
     * @return \SugarBean[]
     */
    public function getBlockedBy(\SugarBean $activity)
    {
        if (!$this->hasBlockedBy($activity)) {
            return [];
        }

        $stage = $this->stageHelper->getStage($activity);
        $journey = $stage->getJourney();

        $blockedBy = [];
        foreach ($this->getBlockedByIds($activity) as $id) {
            $bean = $journey->getActivityByTemplateId($id);

            if ($bean) {
                $handler = ActivityHandlerFactory::factory($bean->module_dir);

                if (!$handler->isCompleted($bean)) {
                    $blockedBy[] = $bean;
                }
            }
        }

        return $blockedBy;
    }

    /**
     * Retrieves the activity template ids in the journey that given activity is blocked by
     *
     * @param \SugarBean $activity
     * @return string[]
     */
    public function getBlockedByIds(\SugarBean $activity)
    {
        if (empty($activity->customer_journey_blocked_by)) {
            return [];
        }
        if (is_string($activity->customer_journey_blocked_by)) {
            return json_decode($activity->customer_journey_blocked_by, true);
        } else {
            if (is_array($activity->customer_journey_blocked_by)) {
                return $activity->customer_journey_blocked_by;
            }
        }
        return [];
    }

    /**
     * Retrieves the stage ids in the journey that given activity is blocked by
     *
     * @param \SugarBean $activity
     * @return string[]
     */
    public function getBlockedByStageIds(\SugarBean $activity)
    {
        if (empty($activity->cj_blocked_by_stages)) {
            return [];
        }

        if (is_string($activity->cj_blocked_by_stages)) {
            return json_decode($activity->cj_blocked_by_stages, true);
        } elseif (is_array($activity->cj_blocked_by_stages)) {
            return $activity->cj_blocked_by_stages;
        } else {
            return [];
        }
    }

    /**
     * Retrieves the activity ids in the journey that given activity is blocked by
     *
     * @param \SugarBean $activity
     * @return string[]
     */
    public function getBlockedByActivityIds(\SugarBean $activity, &$moduleName = [])
    {
        $ids = [];

        foreach ($this->getBlockedBy($activity) as $bean) {
            $ids[] = $bean->id;
            $moduleName[$bean->id] = $bean->module_dir;
        }

        return $ids;
    }

    /**
     * Retrieves the not completed stage ids in the journey
     * that are blocked
     *
     * @param \SugarBean $activity
     * @return string[]
     */
    public function getNotCompletedBlockedByStageIds(\SugarBean $activity)
    {
        $ids = [];

        foreach ($this->getNotCompletedBlockedByStages($activity) as $bean) {
            $ids[] = $bean->id;
        }

        return $ids;
    }

    /**
     * Retrieves the not completed stage beans that are blocked
     *
     * @param \SugarBean $activity
     * @return object[]
     */
    public function getNotCompletedBlockedByStages(\SugarBean $activity)
    {
        if (!$this->hasBlockedByStages($activity)) {
            return [];
        }

        $stage = $this->stageHelper->getStage($activity);
        $journey = $stage->getJourney();

        $blockedByStages = [];
        foreach ($this->getBlockedByStageIds($activity) as $id) {
            $stageBean = $journey->getStageByStageTemplateId($id);

            if (!empty($stageBean->id)) {
                if ($stageBean->state !== "completed") {
                    $blockedByStages[] = $stageBean;
                }
            }
        }

        return $blockedByStages;
    }
}
