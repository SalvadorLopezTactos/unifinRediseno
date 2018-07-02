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

/**
 * @var CalendarEvents
 */

class CalendarEvents
{
    public static $old_assigned_user_id = '';

    /**
     * Schedulable calendar events (modules) supported
     * @var array
     */
    public $calendarEventModules = array(
        'Meetings',
        'Calls',
        'Tasks',
    );
    /**
     * @param SugarBean $bean
     * @return bool
     * @throws SugarException
     */
    public function isEventRecurring(SugarBean $bean)
    {
        if (!in_array($bean->module_name, $this->calendarEventModules)) {
            $logmsg = 'Recurring Calendar Event - Module Unexpected: ' . $bean->module_name;
            $GLOBALS['log']->error($logmsg);
            throw new SugarException('LBL_CALENDAR_EVENT_RECURRENCE_MODULE_NOT_SUPPORTED', array($bean->module_name));
        }

        return (!empty($bean->repeat_type) && !empty($bean->date_start));
    }

    /**
     * Return Configured recurrence limit.
     * @return int
     */
    public function getRecurringLimit()
    {
        return SugarConfig::getInstance()->get('calendar.max_repeat_count', 1000);
    }

    /**
     * Rebuild the FreeBusy Vcal Cache for specified user
     */
    public function rebuildFreeBusyCache(User $user)
    {
        vCal::cache_sugar_vcal($user);
    }

    /**
     * @param SugarBean $parentBean
     * @return array events saved
     * @throws SugarException
     */
    public function saveRecurringEvents(SugarBean $parentBean)
    {
        if (!$this->isEventRecurring($parentBean)) {
            $logmsg = 'SaveRecurringEvents() : Event is not a Recurring Event';
            $GLOBALS['log']->error($logmsg);
            throw new SugarException('LBL_CALENDAR_EVENT_NOT_A_RECURRING_EVENT', array($parentBean->object_name));
        }

        if (!empty($parentBean->repeat_parent_id)) {
            $logmsg = 'SaveRecurringEvents() : Event received is not the Parent Occcurrence';
            $GLOBALS['log']->error($logmsg);
            throw new SugarException('LBL_CALENDAR_EVENT_IS_NOT_A_PARENT_OCCURRENCE', array($parentBean->object_name));
        }

        $dateStart = $this->formatDateTime('datetime', $parentBean->date_start, 'user');

        $params = array();
        $params['type'] = $parentBean->repeat_type;
        $params['interval'] = $parentBean->repeat_interval;
        $params['count'] = $parentBean->repeat_count;
        $params['until'] = $this->formatDateTime('date', $parentBean->repeat_until, 'user');
        $params['dow'] = $parentBean->repeat_dow;

        $repeatDateTimeArray = $this->buildRecurringSequence($dateStart, $params);

        $limit = $this->getRecurringLimit();
        if (count($repeatDateTimeArray) > ($limit - 1)) {
            $logMessage = sprintf(
                'Calendar Events (%d) exceed Event Limit: (%d)',
                count($repeatDateTimeArray),
                $limit
            );
            $GLOBALS['log']->warning($logMessage);
        }

        // Turn off The Cache Updates while deleting the multiple recurrences.
        // The current Cache Enabled status is returned so it can be appropriately
        // restored when all the recurrences have been deleted.
        $cacheEnabled = vCal::setCacheUpdateEnabled(false);
        $this->markRepeatDeleted($parentBean);
        // Restore the Cache Enabled status to its previous state
        vCal::setCacheUpdateEnabled($cacheEnabled);

        return $this->saveRecurring($parentBean, $repeatDateTimeArray);
    }

    /**
     * Reconcile Tags on Child Bean to Match Parent
     * @param array Tag Beans on the Parent Calendar Event
     * @param SugarBean Child Calendar Event Bean
     * @param array Tag Beans currently existing on Child (optional - defaults to empty array)
     */
    public function reconcileTags(array $parentTagBeans, SugarBean $childBean, $childTagBeans = array())
    {
        $sf = new SugarFieldTag('tag');
        $parentTags = $sf->getOriginalTags($parentTagBeans);
        $childTags = $sf->getOriginalTags($childTagBeans);
        list($addTags, $removeTags) = $sf->getChangedValues($childTags, $parentTags);

        // Handle removal of tags
        $sf->removeTagsFromBean($childBean, $childTagBeans, 'tag_link', $removeTags);

        // Handle addition of new tags
        $sf->addTagsToBean($childBean, $parentTagBeans, 'tag_link', $addTags);
    }

    /**
     * Generate the Start and End Dates for each event occurrence.
     * @param string Start Date
     * @param array  Repeat Occurrence Fields: 'type', 'interval', 'count' 'until' 'dow'
     * @return array Start DateTimes
     */
    protected function buildRecurringSequence($dateStart, array $params)
    {
        return CalendarUtils::buildRecurringSequence($dateStart, $params);
    }

    /**
     * Mark recurring event deleted
     * @param SugarBean parent Bean
     */
    protected function markRepeatDeleted(SugarBean $parentBean)
    {
        CalendarUtils::markRepeatDeleted($parentBean);
    }

    /**
     * @param SugarBean $parentBean
     * @param array $repeatDateTimeArray
     * @return array events saved
     */
    protected function saveRecurring(SugarBean $parentBean, array $repeatDateTimeArray)
    {
        // Load the user relationship so the child events that are created will
        // have the users added via bean->save (which has special auto-accept
        // logic)
        if ($parentBean->load_relationship('users')) {
            $parentBean->users_arr = $parentBean->users->get();
        }
        return CalendarUtils::saveRecurring($parentBean, $repeatDateTimeArray);
    }

    /**
     * Convert A Date, Time  or DateTime String from one format to Another
     * @param string type of the second argument : one of 'date', 'time', 'datetime', 'datetimecombo'
     * @param string formatted date, time or datetime field in DB, ISO, or User Format
     * @param string output format - one of: 'db', 'iso' or 'user'
     * @return string formatted result
     */
    public function formatDateTime($type, $dtm, $toFormat)
    {
        $result = '';
        $sugarDateTime = $this->getSugarDateTime($type, $dtm);
        if (!empty($sugarDateTime)) {
            $result = $sugarDateTime->formatDateTime($type, $toFormat, $GLOBALS['current_user']);
        }
        return $result;
    }

    /**
     * Return a SugarDateTime Object given any Date to Time Format
     * @param string type of the second argument : one of 'date', 'time', 'datetime', 'datetimecombo'
     * @param string  formatted date, time or datetime field in DB, ISO, or User Format
     * @return SugarDateTime
     */
    public function getSugarDateTime($type, $dtm)
    {
        global $timedate;
        $sugarDateTime = null;
        if (!empty($dtm)) {
            $sugarDateTime = $timedate->fromUserType($dtm, $type);
            if (empty($sugarDateTime)) {
                $sugarDateTime = $timedate->fromDBType($dtm, $type);
            }
            if (empty($sugarDateTime)) {
                switch($type) {
                    case 'time':
                        $sugarDateTime = $timedate->fromIsoTime($dtm);
                        break;
                    case 'date':
                    case 'datetime':
                    case 'datetimecombo':
                    default:
                        $sugarDateTime = $timedate->fromIso($dtm);
                        break;
                }
            }
        }
        return $sugarDateTime;
    }

    /**
     * Store Current Assignee Id or blank if New Bean (Create)
     */
    public function setOldAssignedUser($module, $id = null)
    {
        static::$old_assigned_user_id = '';
        if (!empty($module) && !empty($id)) {
            $old_record = BeanFactory::retrieveBean($module, $id);
            if (!empty($old_record->assigned_user_id)) {
                static::$old_assigned_user_id = $old_record->assigned_user_id;
            }
        }
    }

    /**
     * Add record defined by parent field as an invitee if it is a Contact or Lead record
     *
     * @param $bean
     * @param $parentType
     * @param $parentId
     */
    public function inviteParent($bean, $parentType, $parentId)
    {
        $inviteeRelationships = array(
            'Contacts' => 'contacts',
            'Leads' => 'leads',
        );

        foreach($inviteeRelationships as $module => $relationship) {
            if ($parentType == $module) {
                $bean->load_relationship($relationship);
                if (!$bean->$relationship->relationship_exists($relationship, array('id' => $parentId))) {
                    $bean->$relationship->add($parentId);
                }
            }
        }
    }


}
