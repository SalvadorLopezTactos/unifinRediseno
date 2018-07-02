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

require_once 'include/api/SugarApi.php';

/**
 * Meetings module API
 */
class MeetingsApi extends SugarApi
{
    /**
     * {@inheritdoc}
     */
    public function registerApiRest()
    {

        return array(
            'getAgenda' => array(
                'reqType' => 'GET',
                'path' => array('Meetings','Agenda'),
                'pathVars' => array('',''),
                'method' => 'getAgenda',
                'shortHelp' => 'Fetch an agenda for a user',
                'longHelp' => 'include/api/html/meetings_agenda_get_help',
            ),
        );

    }

    public function getAgenda($api, $args) {
        // Fetch the next 14 days worth of meetings (limited to 20)
        $end_time = new SugarDateTime("+14 days");
        $start_time = new SugarDateTime("-1 hour");


        $meeting = BeanFactory::newBean('Meetings');
        $meetingList = $meeting->get_list('date_start', "date_start > " . $GLOBALS['db']->convert($GLOBALS['db']->quoted($start_time->asDb()), 'datetime') . " AND date_start < " . $GLOBALS['db']->convert($GLOBALS['db']->quoted($end_time->asDb()), 'datetime'));

        // Setup the breaks for the various time periods
        $datetime = new SugarDateTime();
        $today_stamp = $datetime->get_day_end()->getTimestamp();
        $tomorrow_stamp = $datetime->setDate($datetime->year,$datetime->month,$datetime->day+1)->get_day_end()->getTimestamp();


        $timeDate = TimeDate::getInstance();

        $returnedMeetings = array('today'=>array(),'tomorrow'=>array(),'upcoming'=>array());
        foreach ( $meetingList['list'] as $meetingBean ) {
            $meetingStamp = $timeDate->fromUser($meetingBean->date_start)->getTimestamp();
            $meetingData = $this->formatBean($api,$args,$meetingBean);

            if ( $meetingStamp < $today_stamp ) {
                $returnedMeetings['today'][] = $meetingData;
            } else if ( $meetingStamp < $tomorrow_stamp ) {
                $returnedMeetings['tomorrow'][] = $meetingData;
            } else {
                $returnedMeetings['upcoming'][] = $meetingData;
            }
        }

        return $returnedMeetings;
    }
}
