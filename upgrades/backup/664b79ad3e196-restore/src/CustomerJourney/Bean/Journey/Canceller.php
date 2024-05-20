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

namespace Sugarcrm\Sugarcrm\CustomerJourney\Bean\Journey;

use Sugarcrm\Sugarcrm\CustomerJourney\Bean\Activity\ActivityHandlerFactory;
use Sugarcrm\Sugarcrm\CustomerJourney\Exception as CJException;

class Canceller
{

    /**
     * Cancel all activities against the Journey
     *
     * @param \DRI_Workflow $journey
     * @throws CJException\NotFoundException
     */
    public function cancel(\DRI_Workflow $journey)
    {
        try {
            $template = \DRI_Workflow_Template::getById($journey->dri_workflow_template_id);

            if ($template->cancel_action === 'remove_open_activities') {
                $this->cancelActionRemoveAllActivities($journey);
            } else {
                $this->cancelActionSetNotApplicable($journey);
            }

            $journey = $journey->retrieve($journey->id);

            if ($journey->state !== \DRI_Workflow::STATE_CANCELLED) {
                $journey->state = \DRI_Workflow::STATE_CANCELLED;
                $journey->save();
            }
        } catch (CJException\NotFoundException $e) {
            throw $e;
        }
    }

    /**
     * Remove all the In-Progress and Not Started Activities
     * @param \DRI_Workflow $journey
     */
    private function cancelActionRemoveAllActivities(\DRI_Workflow $journey)
    {
        foreach ($journey->getStages() as $stage) {
            foreach ($stage->getActivities() as $activity) {
                $activityHandler = ActivityHandlerFactory::factory($activity->module_dir);

                if ($activityHandler->isParent($activity)) {
                    foreach ($activityHandler->getChildren($activity) as $child) {
                        $childHandler = ActivityHandlerFactory::factory($child->module_dir);
                        if (!$childHandler->isCompleted($child)) {
                            $child->mark_deleted($child->id);
                        }
                    }
                    $activityHandler->resetChildren();

                    //If no child found then need to delete the parent as well
                    if (empty($activityHandler->getChildren($activity))) {
                        $activity->mark_deleted($activity->id);
                    }
                } elseif (!$activityHandler->isCompleted($activity)) {
                    $activity->mark_deleted($activity->id);
                }
            }
            $stage = $stage->retrieve($stage->id);
            $stage->state = \DRI_SubWorkflow::STATE_COMPLETED;
            $stage->save();
        }
    }

    /**
     * Set activities deffered on Cancel Action.
     *
     * @param \DRI_Workflow $journey
     */
    private function cancelActionSetNotApplicable(\DRI_Workflow $journey)
    {
        $blocked = [];
        $blockedByStage = [];

        foreach ($journey->getStages() as $stage) {
            $isCompleted = true;

            if ($stage->state !== \DRI_SubWorkflow::STATE_COMPLETED) {
                $isCompleted = false;
            }

            foreach ($stage->getActivities() as $activity) {
                $activityHandler = ActivityHandlerFactory::factory($activity->module_dir);

                if ($activityHandler->isParent($activity)) {
                    [$blocked, $blockedByStage] = $this->prepareBlockedArrayForParentActivity($activity, $activityHandler);
                } elseif (!$activityHandler->isCompleted($activity)) {
                    if ($activityHandler->isBlocked($activity)) {
                        $blocked[$activity->id] = $activity;
                    }
                    if ($activityHandler->isBlockedByStage($activity)) {
                        $blockedByStage[$activity->id] = $activity;
                    }
                    if (!$activityHandler->isBlocked($activity) && !$activityHandler->isBlockedByStage($activity)) {
                        $activityHandler->setStatus($activity, $activityHandler->getNotApplicableStatus($activity));
                        $activity->save();
                    }
                }
            }

            if (!$isCompleted) {
                $stage->state = \DRI_SubWorkflow::STATE_CANCELLED;
                $stage->save();
            }
        }

        if (!empty($blockedByStage)) {
            $this->resolveBlockByStages($blockedByStage);
        }

        foreach ($blocked as $activity) {
            $this->resolveBlock($activity, $blocked);
        }

        //Mark activities as "Not Applicable" which were blocked by stages
        foreach ($blockedByStage as $id => $activity) {
            $activity->retrieve($activity->id);
            $activityHandler = ActivityHandlerFactory::factory($activity->module_dir);
            $activityHandler->setStatus($activity, $activityHandler->getNotApplicableStatus($activity));
            $activity->save();
        }
    }

    /**
     * Prepare the blocked activites data for parent activity
     *
     * @param object $activity
     * @param object $activityHandler
     * @return array
     */
    private function prepareBlockedArrayForParentActivity($activity, $activityHandler)
    {
        $blocked = [];
        $blockedByStage = [];

        if ($activityHandler->isBlocked($activity) && !$activityHandler->isCompleted($activity)) {
            $blocked[$activity->id] = $activity;
        }
        if ($activityHandler->isBlockedByStage($activity) && !$activityHandler->isCompleted($activity)) {
            $blockedByStage[$activity->id] = $activity;
        }
        foreach ($activityHandler->getChildren($activity) as $child) {
            $childHandler = ActivityHandlerFactory::factory($child->module_dir);

            if (!$childHandler->isCompleted($child)) {
                if ($childHandler->isBlocked($child)) {
                    $blocked[$child->id] = $child;
                }
                if ($childHandler->isBlockedByStage($child)) {
                    $blockedByStage[$child->id] = $child;
                }
                if ((!$activityHandler->isBlocked($activity) && !$childHandler->isBlocked($child)) &&
                        (!$activityHandler->isBlockedByStage($activity) && !$childHandler->isBlockedByStage($child))) {
                    $childHandler->setStatus($child, $childHandler->getNotApplicableStatus($child));
                    $child->save();
                }
            }
        }

        return [$blocked, $blockedByStage];
    }

    /**
     * Resolve the block activities and it's children
     *
     * @param SugarBean $activity
     * @param SugarBean[] $blocked
     */
    private function resolveBlock(\SugarBean $activity, array $blocked)
    {
        $activityHandler = ActivityHandlerFactory::factory($activity->module_dir);
        if (!$activityHandler->isCompleted($activity)) {
            $blockedByModuleNames = [];
            $blockedByList = $activityHandler->getBlockedByActivityIds($activity, $blockedByModuleNames);
            foreach ($activityHandler->getBlockedByActivityIds($activity) as $blockedById) {
                $moduleName=$blockedByModuleNames[$blockedById];
                $blockedByHandler = ActivityHandlerFactory::factory($moduleName);
                if (!$blockedByHandler->isBlocked($activity)) {
                    $blockedByHandler->setStatus($blockedBy, $blockedByHandler->getNotApplicableStatus($blockedBy));
                    $blockedBy->save();
                } elseif ($blockedBy instanceof \SugarBean) {
                    $this->resolveBlock($blockedBy, $blocked);
                }
            }

            $activityHandler->setStatus($activity, $activityHandler->getNotApplicableStatus($activity));
            $activity->save();
            $this->markChildrenCompletedWhenBlockedParentCompleted($activity, $activityHandler);
        }
    }

    /**
     * Resolve those activities which are blocked by stages
     *
     * @param array $blockedByStage
     */
    private function resolveBlockByStages($blockedByStage)
    {
        if (empty($blockedByStage)) {
            return;
        }

        global $db;
        foreach ($blockedByStage as $id => $activity) {
            $table = $activity->getTableName();

            $sql = <<<SQL
                    UPDATE
                        {$table}
                    SET
                        cj_blocked_by_stages = ?
                    WHERE
                        id = ?
SQL;
            $db->getConnection()->executeUpdate($sql, ['', $id]);
        }
    }

    /**
     * Mark the Children Activities as Completed when The Blocked Parent Activity Completed
     *
     * @param object $activity
     * @param object $activityHandler
     */
    private function markChildrenCompletedWhenBlockedParentCompleted($activity, $activityHandler)
    {
        if ($activityHandler->isParent($activity)) {
            foreach ($activityHandler->getChildren($activity) as $child) {
                $childHandler = ActivityHandlerFactory::factory($child->module_dir);
                if (!$childHandler->isCompleted($child) && !$childHandler->isBlocked($child)) {
                    $childHandler->setStatus($child, $childHandler->getNotApplicableStatus($child));
                    $child->save();
                }
            }
        }
    }

    /**
     * Mark the activities as not applicable
     *
     * @param \SugarBean $activity
     */
    public function notApplicableActivity(\SugarBean $activity)
    {
        $blocked = [];
        $hasChild = false;
        $activityHandler = ActivityHandlerFactory::factory($activity->module_dir);

        if ($activityHandler->isParent($activity)) {
            foreach ($activityHandler->getChildren($activity) as $child) {
                $hasChild = true;
                $childHandler = ActivityHandlerFactory::factory($child->module_dir);
                if (!$childHandler->isCompleted($child)) {
                    if ($childHandler->isBlocked($child)) {
                        $blocked[$child->id] = $child;
                    } else {
                        $childHandler->setStatus($child, $childHandler->getNotApplicableStatus($child));
                        $child->save();
                    }
                }
            }
        }

        if ($hasChild == false) {
            $activityHandler->setStatus($activity, $activityHandler->getNotApplicableStatus($activity));
            $activity->save();
        }
        foreach ($blocked as $activity) {
            $this->resolveBlock($activity, $blocked);
        }
    }
}
