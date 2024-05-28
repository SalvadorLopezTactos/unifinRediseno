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
 * This class here to have functions for the
 * child activities of activity
 */
class ChildActivityHelper
{

    /**
     * @var mixed|null|mixed[]|\SugarBean|bool|\SugarBean[]
     */
    public $children;
    /**
     * @var Sugarcrm\Sugarcrm\CustomerJourney\Bean\Activity\Helper\parentHelper
     */
    private $parentHelper;

    /**
     * @var Sugarcrm\Sugarcrm\CustomerJourney\Bean\Activity\Helper\activityHelper
     */
    private $activityHelper;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parentHelper = new ParentHelper();
        $this->activityHelper = ActivityHelper::getInstance();
    }

    /**
     * @param \SugarBean $bean
     * @return \SugarBean[]
     */
    public function retrieveChildren(\SugarBean $bean, $module_name)
    {
        $query = new \SugarQuery();
        $query->from(\BeanFactory::newBean($module_name), ['team_security' => false]);
        $query->select('id');
        $query->where()
            ->equals('cj_parent_activity_id', $bean->id)
            ->equals('cj_parent_activity_type', $bean->module_dir);

        $activities = [];

        $results = $query->execute();

        foreach ($results as $result) {
            $activities[] = \BeanFactory::retrieveBean($module_name, $result['id']);
        }

        return $activities;
    }

    /**
     * Get the children of activity
     *
     * @param \SugarBean $bean
     * @return \SugarBean[]
     */
    public function getChildren(\SugarBean $bean)
    {
        $this->loadChildren($bean);
        return $this->children;
    }

    public function resetChildren()
    {
        $this->children = null;
    }

    /**
     * Load the children activities
     *
     * @param \SugarBean $bean
     */
    public function loadChildren(\SugarBean $bean)
    {
        $this->children = [];

        foreach (ActivityHandlerFactory::all() as $activityHandler) {
            $this->children = array_merge($this->children, $activityHandler->retrieveChildren($bean, $activityHandler->getModuleName()));
        }
        $this->children = $this->sortChildren($this->children);
    }

    /**
     * Inset the child activity record
     *
     * @param \SugarBean $activity
     * @param \SugarBean $child
     */
    public function insertChild(\SugarBean $activity, \SugarBean $child)
    {
        foreach ($this->getChildren($activity) as $id => $bean) {
            if ($bean->id === $child->id) {
                $this->children[$id] = $child;
            }
        }
    }

    /**
     * Sort the Child Activities
     *
     * @param \SugarBean $activity
     * @return \SugarBean|false
     */
    private function sortChildren($activities)
    {
        if ((is_countable($activities) ? count($activities) : 0) < 2) {
            return $activities;
        }

        $left = $right = [];
        $pivot_key = array_key_first($activities);
        $pivotActivity = array_shift($activities);
        $pivot = ActivityHandlerFactory::factory($pivotActivity->module_dir)->getChildOrder($pivotActivity);

        foreach ($activities as $k => $activity) {
            $order = ActivityHandlerFactory::factory($activity->module_dir)->getChildOrder($activity);
            if ($order < $pivot) {
                $left[$k] = $activity;
            } else {
                $right[$k] = $activity;
            }
        }

        return array_merge($this->sortChildren($left), [$pivot_key => $pivotActivity], $this->sortChildren($right));
    }

    /**
     * Get the children activity order
     *
     * @param \SugarBean $activity
     * @return int
     */
    public function getChildOrder(\SugarBean $activity)
    {
        $order = $this->activityHelper->getSortOrder($activity);

        if (false !== strpos($order, '.')) {
            [$_, $order] = explode('.', $order);
        }

        return (int) $order;
    }

    /**
     * Get the next child activity of parent activity
     *
     * @param \SugarBean $activity
     * @return \SugarBean|false
     */
    public function getNextChildActivity(\SugarBean $activity)
    {
        $parent = $this->parentHelper->getParent($activity);
        $parentHandler = ActivityHandlerFactory::factory($parent->module_dir);

        foreach ($parentHandler->getChildren($parent) as $next) {
            $nextHandler = ActivityHandlerFactory::factory($next->module_dir);
            if (!$next->deleted && $nextHandler->getChildOrder($next) > $this->getChildOrder($activity)) {
                return $next;
            }
        }

        return false;
    }
}
