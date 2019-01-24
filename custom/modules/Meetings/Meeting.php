<?php
/**
 * Created by PhpStorm.
 * User: salvadorlopez
 * Date: 22/01/19
 * Time: 10:44
 */
require_once("modules/Meetings/Meeting.php");
class MeetingCustom extends Meeting{

    // save date_end by calculating user input
    public function save($check_notify = false)
    {
        global $timedate, $current_user;

        $isUpdate = $this->isUpdate();

        if (isset($this->date_start)) {
            $td = $timedate->fromDb($this->date_start);
            if (!$td) {
                $this->date_start = $timedate->to_db($this->date_start);
                $td = $timedate->fromDb($this->date_start);
            }
            if ($td) {
                $calEvent = new CalendarEvents();
                $calEvent->setStartAndEndDateTime($this, $td);
            }
        }

        if ($this->repeat_type && $this->repeat_type != 'Weekly') {
            $this->repeat_dow = '';
        }

        if ($this->repeat_selector == 'None') {
            $this->repeat_unit = '';
            $this->repeat_ordinal = '';
            $this->repeat_days = '';
        }

        $check_notify = $this->send_invites;
        if ($this->send_invites == false && $this->isEmailNotificationNeeded()) {
            $this->special_notification = true;
            $check_notify = true;
            CalendarEvents::setOldAssignedUserValue($this->assigned_user_id);
            if (isset($_REQUEST['assigned_user_name'])) {
                $this->new_assigned_user_name = $_REQUEST['assigned_user_name'];
            }
        }

        // prevent a mass mailing for recurring meetings created in Calendar module
        $isRecurringInCalendar = empty($this->id) && !empty($_REQUEST['module']) && $_REQUEST['module'] == "Calendar" &&
            !empty($_REQUEST['repeat_type']) && !empty($this->repeat_parent_id);
        if ($isRecurringInCalendar) {
            $check_notify = false;
        }

        if (empty($this->status) ) {
            $this->status = $this->getDefaultStatus();
        }

        // Do any external API saving
        // Clear out the old external API stuff if we have changed types
        if (isset($this->fetched_row) && $this->fetched_row['type'] != $this->type ) {
            $this->join_url = null;
            $this->host_url = null;
            $this->external_id = null;
            $this->creator = null;
        }

        if (!empty($this->type) && $this->type != 'Sugar' ) {
            $api = ExternalAPIFactory::loadAPI($this->type);
        }

        if (empty($this->type)) {
            $this->type = 'Sugar';
        }

        if ( isset($api) && is_a($api,'WebMeeting') && empty($this->in_relationship_update) ) {
            // Make sure the API initialized and it supports Web Meetings
            // Also make sure we have an ID, the external site needs something to reference
            if (!isset($this->id) || empty($this->id)) {
                $this->id = create_guid();
                $this->new_with_id = true;
            }
            // formatting fix required because our schedule meeting APIs expect data in a specific format
            $this->fixUpFormatting();
            $response = $api->scheduleMeeting($this);
            if ( $response['success'] == TRUE ) {
                // Need to send out notifications
                if ( $api->canInvite ) {
                    $notifyList = $this->get_notification_recipients();
                    foreach($notifyList as $person) {
                        $api->inviteAttendee($this,$person,$check_notify);
                    }

                }
            } else {
                // Generic Message Provides no value to End User - Log the issue with message detail and continue
                // SugarApplication::appendErrorMessage($GLOBALS['app_strings']['ERR_EXTERNAL_API_SAVE_FAIL']);
                $GLOBALS['log']->warn('ERR_EXTERNAL_API_SAVE_FAIL' . ": " . $this->type . " - " .  $response['errorMessage']);
            }

            $api->logoff();
        }

        $return_id = parent::save($check_notify);

        // This function requires that the ID be set and therefore must come after parent::save()
        $this->handleInviteesForUserAssign($isUpdate);

        if ($this->update_vcal) {
            $assigned_user = BeanFactory::getBean('Users', $this->assigned_user_id);
            vCal::cache_sugar_vcal($assigned_user);
            if ($this->assigned_user_id != $GLOBALS['current_user']->id) {
                vCal::cache_sugar_vcal($current_user);
            }
        }

        // CCL - Comment out call to set $current_user as invitee
        // set organizer to auto-accept
        // if there isn't a fetched row its new
        if (!$isUpdate) {
            $organizer = ($this->assigned_user_id == $GLOBALS['current_user']->id) ?
                $GLOBALS['current_user'] : BeanFactory::getBean('Users', $this->assigned_user_id);
            $this->set_accept_status($organizer, 'accept');
        }

        return $return_id;
    }

}