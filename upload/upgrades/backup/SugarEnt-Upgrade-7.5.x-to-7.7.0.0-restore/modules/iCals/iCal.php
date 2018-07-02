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

require_once('modules/Calendar/Calendar.php');
require_once('modules/vCals/vCal.php');

/**
* Class for constructing the iCal response string for the current user.
*
* @see vCal
*/
class iCal extends vCal {

    const UTC_FORMAT = 'Ymd\THi00\Z';

    public $lineEnding = "\r\n";

    /**
     * This is a depreciated method, please start using __construct() as this method will be removed in a future version
     *
     * @see __construct
     * @deprecated
     */
    public function iCal()
    {
        self::__construct();
    }

    /**
    * Constructor for the iCal class.
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Escapes special chars for iCal in the given string.
    *
    * @param string $text the original text
    * @return string the string with new lines properly escaped
    */
    protected function escapeText($text)
    {
        $replace = array(
            '"' => '\"',
            "\\" => "\\\\",
            "," => "\,",
            ":" => "\:",
            ";" => "\;",
            "\n" => "\\n",
        );
        $text = str_replace(array_keys($replace), array_values($replace), $text);
        return $text;
    }

    /**
    * Gets a UTC formatted string from the given dateTime
    *
    * @param SugarDateTime $dateTime the dateTime to format
    * @return string the UTC formatted dateTime
    */
    protected function getUtcDateTime($dateTime)
    {
        return $dateTime->format(self::UTC_FORMAT);
    }

    /**
    * Gets the UTC formatted dateTime from the given timestamp.
    *
    * Checks the version of Sugar to see if user timezone adjustments are needed.
    *
    * @param integer $ts the timestamp to format
    * @return string the UTC formatted dateTime
    */
    protected function getUtcTime($ts)
    {
        global $timedate, $sugar_version;
        $timestamp = ($ts+(date('Z')-$timedate->adjustmentForUserTimeZone()*60));
        return $this->getUtcDateTime(new SugarDateTime("@" . $ts));
    }

    /**
    * Converts the given number of minutes to formatted number of hours and remaining minutes.
    *
    * @param integer $minutes the number of minutes to format
    * @return string the formatted hours and minutes
    */
    protected function convertMinsToHoursAndMins($minutes)
    {
        $hrs = floor(abs($minutes) / 60);
        $remainderMinutes = abs($minutes) - ($hrs * 60);
        $sign = (($minutes < 0) ? "-" : "+");
        return $sign . str_pad($hrs, 2, "0", STR_PAD_LEFT) . str_pad($remainderMinutes, 2, "0", STR_PAD_LEFT);
    }

    /**
    * Create a todo entry for the given task.
    *
    * @param UserBean $user_bean the current UserBean
    * @param Task $task the task for the todo entry
    * @param string $moduleName the name of the task module
    * @param string $dtstamp the current timestamp
    * @return string the todo entry for the task
    */
    protected function createSugarIcalTodo($user_bean, $task, $moduleName, $dtstamp)
    {
        global $sugar_config;
        $str = "";
        $str .= "BEGIN:VTODO$this->lineEnding";
        $validDueDate = (isset($task->date_due) && $task->date_due != "" && $task->date_due != "0000-00-00");
        $validDueTime = (isset($task->time_due) && $task->time_due != "");
        $dueYear = 1970;
        $dueMonth = 1;
        $dueDay = 1;
        $dueHour = 0;
        $dueMin = 0;
        if ($validDueDate) {
            $dateDueArr = explode("-", $task->date_due);
            $dueYear = (int)$dateDueArr[0];
            $dueMonth = (int)$dateDueArr[1];
            $dueDay = (int)$dateDueArr[2];

            if ($validDueTime) {
                $timeDueArr = explode(":", $task->time_due);
                $dueHour = (int)$timeDueArr[0];
                $dueMin = (int)$timeDueArr[1];
            }
        }
        $date_arr = array(
             'day'=>$dueDay,
             'month'=>$dueMonth,
             'hour'=>$dueHour,
             'min'=>$dueMin,
             'year'=>$dueYear);
        $due_date_time = new SugarDateTime();
        $due_date_time->setDate($dueYear, $dueMonth, $dueDay);
        $due_date_time->setTime($dueHour, $dueMin);
        $str .= "DTSTART;TZID=" . $user_bean->getPreference('timezone') . ":" .
                    str_replace("Z", "", $this->getUtcDateTime($due_date_time)) . $this->lineEnding;
        $str .= "DTSTAMP:" . $dtstamp . $this->lineEnding;
        $str .= "SUMMARY:" . $this->escapeText($task->name) . $this->lineEnding;
        $str .= "UID:" . $task->id . $this->lineEnding;
        if ($validDueDate) {
            $iCalDueDate = str_replace("-", "", $task->date_due);
            if (strlen($iCalDueDate) > 8) {
                $iCalDueDate = substr($iCalDueDate, 0, 8);
            }
            $str .= "DUE;VALUE=DATE:" . $iCalDueDate . $this->lineEnding;
        }
        if ($moduleName == "ProjectTask") {
            $str .= "DESCRIPTION:Project: " . $task->project_name. "\\n\\n" .
                $this->escapeText($task->description). $this->lineEnding;
        } else {
            $str .= "DESCRIPTION:" . $this->escapeText($task->description). $this->lineEnding;
        }
        $str .= "URL;VALUE=URI:" . $sugar_config['site_url'].
            "/index.php?module=".$moduleName."&action=DetailView&record=". $task->id. $this->lineEnding;
        if ($task->status == 'Completed') {
            $str .= "STATUS:COMPLETED$this->lineEnding";
            $str .= "PERCENT-COMPLETE:100$this->lineEnding";
            $str .= "COMPLETED:" . $this->getUtcDateTime($due_date_time) . $this->lineEnding;
        } else if (!empty($task->percent_complete)) {
            $str .= "PERCENT-COMPLETE:" . $task->percent_complete . $this->lineEnding;
        }
        if ($task->priority == "Low") {
            $str .= "PRIORITY:9$this->lineEnding";
        } else if ($task->priority == "Medium") {
                $str .= "PRIORITY:5$this->lineEnding";
        } else if ($task->priority == "High") {
                $str .= "PRIORITY:1$this->lineEnding";
        }
        $str .= "END:VTODO$this->lineEnding";
        return $str;
    }

    /**
    * Creates the string for the user's events and todos between the given start
    * and end times
    *
    * @param UserBean $user_bean the current UserBean
    * @param DateTime $start_date_time the start date to search from
    * @param DateTime $end_date_time the end date to search to
    * @param string $dtstamp the current timestamp
    * @return string the entries for events and todos
    */
    protected function createSugarIcal(&$user_bean,&$start_date_time,&$end_date_time, $dtstamp)
    {
        $str = '';
        global $DO_USER_TIME_OFFSET, $sugar_config, $current_user, $timedate;

        $hide_calls = false;
        if (!empty($_REQUEST['hide_calls']) && $_REQUEST['hide_calls'] == "true")
        {
            $hide_calls = true;
        }

        $taskAsVTODO = true;
        if (!empty($_REQUEST['show_tasks_as_events']) && ($_REQUEST['show_tasks_as_events'] == "1"  || $_REQUEST['show_tasks_as_events'] == "true"))
        {
            $taskAsVTODO = false;
        }

        $acts_arr = CalendarActivity::get_activities($user_bean->id,
            !$taskAsVTODO,
            $start_date_time,
            $end_date_time,
            'month',
            !$hide_calls);


        // loop thru each activity, get start/end time in UTC, and return iCal strings
        foreach($acts_arr as $act)
        {

            $event = $act->sugar_bean;
            if (!$hide_calls || ($hide_calls && $event->object_name != "Call"))
            {
                $str .= "BEGIN:VEVENT$this->lineEnding";
                $str .= "SUMMARY:" . $this->escapeText($event->name) . $this->lineEnding;
                $str .= "DTSTART;TZID=" . $user_bean->getPreference('timezone') . ":" .
                        str_replace("Z", "", $timedate->tzUser($act->start_time, $current_user)->format(self::UTC_FORMAT)) . $this->lineEnding;
                $str .= "DTEND;TZID=" . $user_bean->getPreference('timezone') . ":" .
                        str_replace("Z", "", $timedate->tzUser($act->end_time, $current_user)->format(self::UTC_FORMAT)) . $this->lineEnding;
                $str .= "DTSTAMP:" . $dtstamp . $this->lineEnding;
                $str .= "DESCRIPTION:" . $this->escapeText($event->description) . $this->lineEnding;
                $str .= "URL;VALUE=URI:" . $sugar_config['site_url'].
                    "/index.php?module=".$event->module_dir."&action=DetailView&record=". $event->id. $this->lineEnding;
                $str .= "UID:" . $event->id . $this->lineEnding;
                if ($event->object_name == "Meeting") {
                    $str .= "LOCATION:" . $this->escapeText($event->location) . $this->lineEnding;
                    $eventUsers = $event->get_meeting_users();
                    $query = "SELECT contact_id as id from meetings_contacts where meeting_id='$event->id' AND deleted=0";
                    $eventContacts = $event->build_related_list($query, BeanFactory::getBean('Contacts'));
                    $eventAttendees = array_merge($eventUsers, $eventContacts);
                    if (is_array($eventAttendees))
                    {
                        foreach($eventAttendees as $attendee)
                        {
                            if ($attendee->id != $user_bean->id && !empty($attendee->email1))
                            {
                                // Define the participant status
                                $participant_status = '';
                                if (!empty($attendee->accept_status)) {
                                    switch ($attendee->accept_status) {
                                        case 'accept':
                                            $participant_status = ';PARTSTAT=ACCEPTED';
                                            break;
                                        case 'decline':
                                            $participant_status = ';PARTSTAT=DECLINED';
                                            break;
                                        case 'tentative':
                                            $participant_status = ';PARTSTAT=TENTATIVE';
                                            break;
                                    }
                                }
                                $str .= 'ATTENDEE'.$participant_status.';CN="'.$attendee->get_summary_text().'":mailto:'. $attendee->email1 . $this->lineEnding;
                            }
                        }
                    }
                }
                if ($event->object_name == "Call")
                {
                    $eventUsers = $event->get_call_users();
                    $eventContacts = $event->get_contacts();
                    $eventAttendees = array_merge($eventUsers, $eventContacts);
                    if (is_array($eventAttendees))
                    {
                        foreach($eventAttendees as $attendee)
                        {
                            if ($attendee->id != $user_bean->id && !empty($attendee->email1))
                            {
                                // Define the participant status
                                $participant_status = '';
                                if (!empty($attendee->accept_status)) {
                                    switch ($attendee->accept_status) {
                                        case 'accept':
                                            $participant_status = ';PARTSTAT=ACCEPTED';
                                            break;
                                        case 'decline':
                                            $participant_status = ';PARTSTAT=DECLINED';
                                            break;
                                        case 'tentative':
                                            $participant_status = ';PARTSTAT=TENTATIVE';
                                            break;
                                    }
                                }
                                $str .= 'ATTENDEE'.$participant_status.';CN="'.$attendee->get_summary_text().'":mailto:'. $attendee->email1 . $this->lineEnding;
                            }
                        }
                    }
                }
                if (isset($event->reminder_time) && $event->reminder_time > 0 && $event->status != "Held")
                {
                    $str .= "BEGIN:VALARM$this->lineEnding";
                    $str .= "TRIGGER:-PT" . $event->reminder_time/60 . "M$this->lineEnding";
                    $str .= "ACTION:DISPLAY$this->lineEnding";
                    $str .= "DESCRIPTION:" . $event->name . "$this->lineEnding";
                    $str .= "END:VALARM$this->lineEnding";
                }
                $str .= "END:VEVENT$this->lineEnding";
            }

        }

        require_once('include/TimeDate.php');
        $timedate = new TimeDate();
        $today = gmdate("Y-m-d");
        $today = $timedate->handle_offset($today, $timedate->dbDayFormat, false);

        require_once('modules/ProjectTask/ProjectTask.php');
        $where = "project_task.assigned_user_id='{$user_bean->id}' ".
            "AND (project_task.status IS NULL OR (project_task.status!='Deferred')) ".
            "AND (project_task.date_start IS NULL OR " . CalendarActivity::get_occurs_within_where_clause('project_task', '', $start_date_time, $end_date_time, 'date_start', 'month') . ")";
        $seedProjectTask = BeanFactory::getBean('ProjectTask');
        $projectTaskList = $seedProjectTask->get_full_list("", $where);
        if (is_array($projectTaskList))
        {
            foreach($projectTaskList as $projectTask)
            {
                $str .= $this->createSugarIcalTodo($user_bean, $projectTask, "ProjectTask", $dtstamp);
            }
        }

        if ($taskAsVTODO) {
            $where = "tasks.assigned_user_id='{$user_bean->id}' ".
                "AND (tasks.status IS NULL OR (tasks.status!='Deferred')) ".
                "AND (tasks.date_start IS NULL OR " . CalendarActivity::get_occurs_within_where_clause('tasks', '', $start_date_time, $end_date_time, 'date_start', 'month') . ")";
            $seedTask = BeanFactory::getBean('Tasks');
            $taskList = $seedTask->get_full_list("", $where);
            if (is_array($taskList))
            {
                foreach($taskList as $task)
                {
                    $str .= $this->createSugarIcalTodo($user_bean, $task, "Tasks", $dtstamp);
                }
            }
        }

        return $str;
    }

    /**
    * Gets the time zone for the given user.
    *
    * @param User $current_user the user
    * @return DateTimeZone the user's timezone
    */
    protected function getUserTimezone($current_user)
    {
        $gmtTZ = new DateTimeZone("UTC");
        $userTZName = TimeDate::userTimezone($current_user);
        if (!empty($userTZName))
        {
            $tz = new DateTimeZone($userTZName);
        } else
        {
            $tz = $gmtTZ;
        }
        return $tz;
    }

    /**
    * Gets the daylight savings range for the given user.
    *
    * @param User $current_user the user
    * @param integer $year the year
    * @return array the start and end transitions of daylight savings
    */
    protected function getDSTRange($current_user, $year)
    {
        $tz = $this->getUserTimezone($current_user);
        $idx = 0;
        $result = array();

        if (version_compare(PHP_VERSION, '5.3.0') >= 0)
        {
            $year_date = SugarDateTime::createFromFormat("Y", $year, new DateTimeZone("UTC"));
            $year_end = clone $year_date;
            $year_end->setDate((int) $year, 12, 31);
            $year_end->setTime(23, 59, 59);
            $year_date->setDate((int) $year, 1, 1);
            $year_date->setTime(0, 0, 0);

            $transitions = $tz->getTransitions($year_date->getTimestamp(), $year_end->getTimestamp());
            foreach($transitions as $transition) {
                if($transition['isdst']) {
                    break;
                }
                $idx++;
            }
        } else {
            $transitions = $tz->getTransitions();

            $idx = 0;
            foreach($transitions as $transition) {
                if($transition['isdst'] && intval(substr($transition["time"], 0, 4)) == intval(date("Y"))) {
                    break;
                }
                $idx++;
            }
        }

        if (empty($transitions[$idx]["isdst"])) {
            // No DST transitions found
            return $result;
        }
        $result["start"] = $transitions[$idx]; // DST begins here
        // scan till DST ends
        while (isset($transitions[$idx]) && $transitions[$idx]["isdst"]) $idx++;
        if(isset($transitions[$idx])) {
            $result["end"] = $transitions[$idx];
        }
        return $result;
    }

    /**
    * Gets the timezone string for the current user.
    *
    * @return string the full timezone definition including daylight savings for the iCal
    */
    protected function getTimezoneString()
    {
        global $current_user, $timedate;
        $timezoneName = $current_user->getPreference('timezone');

        $gmtTZ = new DateTimeZone("UTC");
        $tz = $this->getUserTimezone($current_user);
        $dstRange = $this->getDSTRange($current_user, date('Y'));

        $dstOffset = 0;
        $gmtOffset = 0;

        $timezoneString = "BEGIN:VTIMEZONE$this->lineEnding";
        $timezoneString .= "TZID:" . $timezoneName . $this->lineEnding;
        $timezoneString .= "X-LIC-LOCATION:" . $timezoneName . $this->lineEnding;

        if (array_key_exists('start', $dstRange))
        {
            $dstOffset = ($dstRange['start']['offset'] / 60);
            $startDate = new DateTime("@" . $dstRange["start"]["ts"], $gmtTZ);
            $startstamp = strtotime($timedate->asDb($startDate));
            $timezoneString .= "BEGIN:DAYLIGHT$this->lineEnding";
            $timezoneString .= "TZOFFSETFROM:" . $this->convertMinsToHoursAndMins($gmtOffset) . $this->lineEnding;
            $timezoneString .= "TZOFFSETTO:" . $this->convertMinsToHoursAndMins($dstOffset) . $this->lineEnding;
            $timezoneString .= "DTSTART:" . str_replace("Z", "", $this->getUtcTime($startstamp)) . $this->lineEnding;
            $timezoneString .= "END:DAYLIGHT$this->lineEnding";
        }

        if (array_key_exists('end', $dstRange))
        {
            $gmtOffset = ($dstRange['end']['offset'] / 60);
            $endDate = new DateTime("@" . $dstRange["end"]["ts"], $gmtTZ);
            $endstamp = strtotime($timedate->asDb($endDate));
            $timezoneString .= "BEGIN:STANDARD$this->lineEnding";
            $timezoneString .= "TZOFFSETFROM:" . $this->convertMinsToHoursAndMins($dstOffset) . $this->lineEnding;
            $timezoneString .= "TZOFFSETTO:" . $this->convertMinsToHoursAndMins($gmtOffset) . $this->lineEnding;
            $timezoneString .= "DTSTART:" . str_replace("Z", "", $this->getUtcTime($endstamp)) . $this->lineEnding;
            $timezoneString .= "END:STANDARD$this->lineEnding";
        }

        $timezoneString .= "END:VTIMEZONE$this->lineEnding";

        return $timezoneString;
    }

    /**
    * Generates the complete string for the calendar
    *
    * @param User $user_focus the user
    * @param integer $num_months the number of months to search before and after today
    * @return string the iCal calenar string
    */
    function getVcalIcal(&$user_focus, $num_months)
    {
        global $current_user, $timedate;
        $current_user = $user_focus;

        $cal_name = $user_focus->first_name. " ". $user_focus->last_name;

        $str = "BEGIN:VCALENDAR$this->lineEnding";
        $str .= "VERSION:2.0$this->lineEnding";
        $str .= "METHOD:PUBLISH$this->lineEnding";
        $str .= "X-WR-CALNAME:$cal_name (SugarCRM)$this->lineEnding";
        $str .= "PRODID:-//SugarCRM//SugarCRM Calendar//EN$this->lineEnding";
        $str .= $this->getTimezoneString();
        $str .= "CALSCALE:GREGORIAN$this->lineEnding";

        $now_date_time = $timedate->getNow(true);

        global $sugar_config;
        $timeOffset = 2;
        if (isset($sugar_config['vcal_time']) && $sugar_config['vcal_time'] != 0 && $sugar_config['vcal_time'] < 13)
        {
            $timeOffset = $sugar_config['vcal_time'];
        }
        if (!empty($num_months))
        {
            $timeOffset = $num_months;
        }
        $start_date_time = $now_date_time->get("-$timeOffset months");
        $end_date_time = $now_date_time->get("+$timeOffset months");

        $utc_now_time = $this->getUtcDateTime($now_date_time);

        $str .= $this->createSugarIcal($user_focus,$start_date_time,$end_date_time,$utc_now_time);

        $str .= "DTSTAMP:" . $utc_now_time . $this->lineEnding;
        $str .= "END:VCALENDAR$this->lineEnding";

        return $str;
    }

}
