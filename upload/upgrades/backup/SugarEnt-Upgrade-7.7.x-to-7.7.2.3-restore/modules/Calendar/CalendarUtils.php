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

class CalendarUtils
{
	/**
	 * Find first day of week according to user's settings
	 * @param SugarDateTime $date
	 * @return SugarDateTime $date
	 */
	static function get_first_day_of_week(SugarDateTime $date){
		$fdow = $GLOBALS['current_user']->get_first_day_of_week();
		if($date->day_of_week < $fdow)
				$date = $date->get('-7 days');
		return $date->get_day_by_index_this_week($fdow);
	}


	/**
	 * Get list of needed fields for modules
	 * @return array
	 */
	static function get_fields(){
		return array(
			'Meetings' => array(
				'name',
				'duration_hours',
				'duration_minutes',
				'status',
				'related_to',
			),
			'Calls' => array(
				'name',
				'duration_hours',
				'duration_minutes',
				'status',
				'related_to',
			),
			'Tasks' => array(
				'name',
				'status',
				'related_to',
			),
		);
	}

	/**
	 * Get array of needed time data
	 * @param SugarBean $bean
	 * @return array
	 */
	static function get_time_data(SugarBean $bean){
					$arr = array();

					$start_field = "date_start";
					$end_field = "date_end";

					if($bean->object_name == 'Task')
						$start_field = $end_field = "date_due";
					if(empty($bean->$start_field))
						return array();
					if(empty($bean->$end_field))
						$bean->$end_field = $bean->$start_field;

					$timestamp = SugarDateTime::createFromFormat($GLOBALS['timedate']->get_date_time_format(),$bean->$start_field,new DateTimeZone('UTC'))->format('U');
					$arr['timestamp'] = $timestamp;
					$arr['time_start'] = $GLOBALS['timedate']->fromTimestamp($arr['timestamp'])->format($GLOBALS['timedate']->get_time_format());
					$date_start = SugarDateTime::createFromFormat($GLOBALS['timedate']->get_date_time_format(),$bean->$start_field,new DateTimeZone('UTC'));
					$arr['ts_start'] = $date_start->get("-".$date_start->format("H")." hours -".$date_start->format("i")." minutes -".$date_start->format("s")." seconds")->format('U');
					$arr['offset'] = $date_start->format('H') * 3600 + $date_start->format('i') * 60;
					$date_end = SugarDateTime::createFromFormat($GLOBALS['timedate']->get_date_time_format(),$bean->$end_field,new DateTimeZone('UTC'));
					if($bean->object_name != 'Task')
						$date_end->modify("-1 minute");
					$arr['ts_end'] = $date_end->get("+1 day")->get("-".$date_end->format("H")." hours -".$date_end->format("i")." minutes -".$date_end->format("s")." seconds")->format('U');
					$arr['days'] = ($arr['ts_end'] - $arr['ts_start']) / (3600*24);

					return $arr;
	}


	/**
	 * Get array that will be sent back to ajax frontend
	 * @param SugarBean $bean
	 * @return array
	 */
	static function getBeanDataArray(SugarBean $bean)
	{
			if(isset($bean->parent_name) && isset($_REQUEST['parent_name']))
				$bean->parent_name = $_REQUEST['parent_name'];

			$users = array();
			if($bean->object_name == 'Call')
				$users = $bean->get_call_users();
			else if($bean->object_name == 'Meeting')
				$users = $bean->get_meeting_users();
			$user_ids = array();
			foreach($users as $u)
				$user_ids[] = $u->id;

			$field_list = CalendarUtils::get_fields();
			$field_arr = array();
			foreach($field_list[$bean->module_dir] as $field){
			    if ($field == 'related_to')
			    {
			        $focus = BeanFactory::getBean($bean->parent_type, $bean->parent_id);
			        $field_arr[$field] = $focus->name;
			    }
			    else
			    {
			        $field_arr[$field] = $bean->$field;
			    }
			}

			$date_field = "date_start";
			if($bean->object_name == 'Task')
				$date_field = "date_due";

			$arr = array(
				'access' => 'yes',
				'type' => strtolower($bean->object_name),
				'module_name' => $bean->module_dir,
				'user_id' => $GLOBALS['current_user']->id,
				'detail' => 1,
				'edit' => 1,
				'name' => $bean->name,
				'record' => $bean->id,
				'users' => $user_ids,
			);
			if(!empty($bean->repeat_parent_id))
				$arr['repeat_parent_id'] = $bean->repeat_parent_id;
			$arr = array_merge($arr,$field_arr);
			$arr = array_merge($arr,CalendarUtils::get_time_data($bean));

			return $arr;
	}

	/**
	 * Get array of repeat data
	 * @param SugarBean $bean
	 * @return array
	 */
	 static function getRepeatData(SugarBean $bean, $editAllRecurrences = false, $dateStart = false)
	 {
	 	if ($bean->module_dir == "Meetings" || $bean->module_dir == "Calls") {
	 		if (!empty($bean->repeat_parent_id) || (!empty($bean->repeat_type) && empty($editAllRecurrences))) {
				if (!empty($bean->repeat_parent_id)) {
					$repeat_parent_id = $bean->repeat_parent_id;
				} else {
					$repeat_parent_id = $bean->id;
				}
	 			return array("repeat_parent_id" => $repeat_parent_id);
	 		}

	 		$arr = array();
	 		if (!empty($bean->repeat_type)) {
	 			$arr = array(
	 				'repeat_type' => $bean->repeat_type,
	 				'repeat_interval' => $bean->repeat_interval,
	 				'repeat_dow' => $bean->repeat_dow,
	 				'repeat_until' => $bean->repeat_until,
	 				'repeat_count' => $bean->repeat_count,
	 			);
	 		}

	 		if (empty($dateStart)) {
	 			$dateStart = $bean->date_start;
	 		}

            $date = SugarDateTime::createFromFormat($GLOBALS['timedate']->get_date_time_format(), $dateStart);
            if (empty($date)) {
                $date = $GLOBALS['timedate']->getNow(true);
            }
            $arr = array_merge($arr,array(
                'current_dow' => $date->format("w"),
                'default_repeat_until' => $date->get("+1 Month")->format($GLOBALS['timedate']->get_date_format()),
            ));

		 	return $arr;
		}
	 	return false;
	 }

	/**
	 * Build array of datetimes for recurring meetings
	 * @param string $date_start
	 * @param array $params
	 * @return array
	 */
	static function buildRecurringSequence($date_start, $params)
	{
		$arr = array();

		$type = $params['type'];
		$interval = intval($params['interval']);
		if($interval < 1)
			$interval = 1;

		if(!empty($params['count'])){
			$count = $params['count'];
			if($count < 1)
				$count = 1;
		}else
			$count = 0;

		if(!empty($params['until'])){
			$until = $params['until'];
		}else
			$until = $date_start;

		if($type == "Weekly"){
			$dow = $params['dow'];
			if($dow == ""){
				return array();
			}
		}

		/** 
		 * @var SugarDateTime $start Recurrence start date.
		 */
		$start = SugarDateTime::createFromFormat($GLOBALS['timedate']->get_date_time_format(),$date_start);
        $current = clone $start;

		/** 
		 * @var SugarDateTime $end Recurrence end date. Used if recurrence ends by date.
         * To Make the RepeatUntil Date Inclusive, we need to Add 1 Day to End
		 */
		if (!empty($params['until'])) {
			$end = SugarDateTime::createFromFormat($GLOBALS['timedate']->get_date_format(), $until);
            $end->setTime(23, 59, 59);   // inclusive
		} else {
			$end = $start;
		}

		$i = 1; // skip the first iteration
		$w = $interval; // for week iteration
		$last_dow = $start->format("w");

		$limit = SugarConfig::getInstance()->get('calendar.max_repeat_count',1000);

		while($i < $count || ($count == 0 && $current->format("U") <= $end->format("U"))){
			$skip = false;
			switch($type){
				case "Daily":
					$current->modify("+{$interval} Days");
					break;
				case "Weekly":
					$day_index = $last_dow;
					for($d = $last_dow + 1; $d <= $last_dow + 7; $d++){
						$day_index = $d % 7;
						if(strpos($dow,(string)($day_index)) !== false){
							break;
						}
					}
					$step = $day_index - $last_dow;
					$last_dow = $day_index;
					if($step <= 0){
						$step += 7;
						$w++;
					}
					if($w % $interval != 0)
						$skip = true;

					$current->modify("+{$step} Days");
					break;
				case "Monthly":
					$current->modify("+{$interval} Months");
					break;
				case "Yearly":
					$current->modify("+{$interval} Years");
					break;
				default:
					return array();
			}

			if($skip)
				continue;

			if ($i < $count || ($count == 0 && $current->format("U") <= $end->format("U"))) {
				$arr[] = $current->format($GLOBALS['timedate']->get_date_time_format());
			}
			$i++;

			if($i > $limit + 100)
				break;
		}
		return $arr;
	}

	/**
	 * Save repeat activities
     * Invites are sent once for a Recurring Series (only when the Parent was saved)
	 * @param SugarBean $bean
	 * @param array $timeArray array of datetimes
	 * @return array
	 */
	static function saveRecurring(SugarBean $bean, $timeArray)
	{
		// Here we will create single big inserting query for each invitee relationship
		// rather than using relationships framework due to performance issues.
		// Relationship framework runs very slowly

		$db = $GLOBALS['db'];
		$id = $bean->id;
		$date_modified = $GLOBALS['timedate']->nowDb();
		$lower_name = strtolower($bean->object_name);

		$qu = "SELECT * FROM {$bean->rel_users_table} WHERE deleted = 0 AND {$lower_name}_id = '{$id}'";
		$re = $db->query($qu);
		$users_rel_arr = array();
		// If the bean has a users_arr then related records for those ids will have
		// already been created. This prevents duplicates of those records for 
		// users, contacts and leads (handled below)
		$exclude_users = empty($bean->users_arr) ? array() : array_flip($bean->users_arr);
		
		while($ro = $db->fetchByAssoc($re)) {
			if (!isset($exclude_users[$ro['user_id']])) {
				$users_rel_arr[] = $ro['user_id'];
			}
		}

		$qu = "SELECT * FROM {$bean->rel_contacts_table} WHERE deleted = 0 AND {$lower_name}_id = '{$id}'";
		$re = $db->query($qu);
		$contacts_rel_arr = array();
		while($ro = $db->fetchByAssoc($re)) {
			$contacts_rel_arr[] = $ro['contact_id'];
		}

		$qu = "SELECT * FROM {$bean->rel_leads_table} WHERE deleted = 0 AND {$lower_name}_id = '{$id}'";
		$re = $db->query($qu);
		$leads_rel_arr = array();
		while($ro = $db->fetchByAssoc($re)) {
			$leads_rel_arr[] = $ro['lead_id'];
		}

		$qu_contacts = array();
		$qu_users = array();
		$qu_leads = array();
		$arr = array();
		$i = 0;

        Activity::disable();

        $calendarEvents = new CalendarEvents();
        $bean->load_relationship('tag_link');
        $parentTagBeans = $bean->tag_link->getBeans();

		$clone = clone $bean;

        //this is a new bean being created - so throw away cloned fetched_row
        //attribute that incorrectly makes it look like an existing bean
        $clone->fetched_row = false;

		foreach ($timeArray as $date_start) {
			$clone->id = "";
			$clone->date_start = $date_start;
			// TODO CHECK DATETIME VARIABLE
			$date = SugarDateTime::createFromFormat($GLOBALS['timedate']->get_date_time_format(),$date_start);
			$date = $date->get("+{$bean->duration_hours} Hours")->get("+{$bean->duration_minutes} Minutes");
			$date_end = $date->format($GLOBALS['timedate']->get_date_time_format());
			$clone->date_end = $date_end;
			$clone->recurring_source = "Sugar";
			$clone->repeat_parent_id = $id;
			$clone->update_vcal = false;
            $clone->send_invites = false;
			$clone->save(false);

			if($clone->id){
                $clone->load_relationship('tag_link');
                $calendarEvents->reconcileTags($parentTagBeans, $clone);
				foreach($users_rel_arr as $user_id){
                    $qu_users[] = array(
                        'id' => create_guid(),
                        'user_id' => $user_id,
                        $lower_name . '_id' => $clone->id,
                        'date_modified' => $date_modified,
                    );
				}
				foreach($contacts_rel_arr as $contact_id){
                    $qu_contacts[] = array(
                        'id' => create_guid(),
                        'contact_id' => $contact_id,
                        $lower_name . '_id' => $clone->id,
                        'date_modified' => $date_modified,
                    );
				}
				foreach($leads_rel_arr as $lead_id){
                    $qu_leads[] = array(
                        'id' => create_guid(),
                        'lead_id' => $lead_id,
                        $lower_name . '_id' => $clone->id,
                        'date_modified' => $date_modified,
                    );
				}
				if($i < 44){
					$clone->date_start = $date_start;
					$clone->date_end = $date_end;
					$arr[] = array_merge(array('id' => $clone->id),CalendarUtils::get_time_data($clone));
				}
				$i++;
			}
		}
		
        Activity::enable();

        if (!empty($qu_users)) {
            $fields = array(
                'id' => array('name' => 'id', 'type' => 'id'),
                'user_id' => array('name' => 'user_id', 'type' => 'id'),
                $lower_name . '_id' => array('name' => $lower_name . '_id', 'type' => 'id'),
                'date_modified' => array('name' => 'date_modified', 'type' => 'datetime'),
            );
            foreach ($qu_users as $qu_user) {
                $db->insertParams($bean->rel_users_table, $fields, $qu_user);
            }
        }
        if (!empty($qu_contacts)) {
            $fields = array(
                'id' => array('name' => 'id', 'type' => 'id'),
                'contact_id' => array('name' => 'contact_id', 'type' => 'id'),
                $lower_name . '_id' => array('name' => $lower_name . '_id', 'type' => 'id'),
                'date_modified' => array('name' => 'date_modified', 'type' => 'datetime'),
            );
            foreach ($qu_contacts as $qu_contact) {
                $db->insertParams($bean->rel_contacts_table, $fields, $qu_contact);
            }
        }
        if (!empty($qu_leads)) {
            $fields = array(
                'id' => array('name' => 'id', 'type' => 'id'),
                'lead_id' => array('name' => 'lead_id', 'type' => 'id'),
                $lower_name . '_id' => array('name' => $lower_name . '_id', 'type' => 'id'),
                'date_modified' => array('name' => 'date_modified', 'type' => 'datetime'),
            );
            foreach ($qu_leads as $qu_lead) {
                $db->insertParams($bean->rel_leads_table, $fields, $qu_lead);
            }
        }
		
		vCal::cache_sugar_vcal($GLOBALS['current_user']);
		return $arr;
	}

	/**
	 * Delete recurring activities and their invitee relationships
	 * @param SugarBean $bean
	 */
	static function markRepeatDeleted(SugarBean $bean)
	{
		// we don't use mark_deleted method here because it runs very slowly
		global $db;
		$date_modified = $GLOBALS['timedate']->nowDb();
		if(!empty($GLOBALS['current_user']))
			$modified_user_id = $GLOBALS['current_user']->id;
		else
			$modified_user_id = 1;
		$lower_name = strtolower($bean->object_name);

		$qu = "SELECT id FROM {$bean->table_name} WHERE repeat_parent_id = '{$bean->id}' AND deleted = 0";
		$re = $db->query($qu);
		while( $ro = $db->fetchByAssoc($re)) {
			$id = $ro['id'];
			$date_modified = $GLOBALS['timedate']->nowDb();
			$db->query("UPDATE {$bean->table_name} SET deleted = 1, date_modified = " . $db->convert($db->quoted($date_modified), 'datetime') . ", modified_user_id = '{$modified_user_id}' WHERE id = '{$id}'");
			$db->query("UPDATE {$bean->rel_users_table} SET deleted = 1, date_modified = " . $db->convert($db->quoted($date_modified), 'datetime') . " WHERE {$lower_name}_id = '{$id}'");
			$db->query("UPDATE {$bean->rel_contacts_table} SET deleted = 1, date_modified = " . $db->convert($db->quoted($date_modified), 'datetime') . " WHERE {$lower_name}_id = '{$id}'");
			$db->query("UPDATE {$bean->rel_leads_table} SET deleted = 1, date_modified = " . $db->convert($db->quoted($date_modified), 'datetime') . " WHERE {$lower_name}_id = '{$id}'");
		}
		vCal::cache_sugar_vcal($GLOBALS['current_user']);
	}

	/**
	 * check if meeting has repeat children and pass repeat_parent over to the 2nd meeting in sequence
	 * @param SugarBean $bean
	 * @param string $beanId
	 */
	static function correctRecurrences(SugarBean $bean, $beanId)
	{
		global $db;

        if (empty($beanId) || trim($beanId) == '') {
            return;
        }

		$qu = "SELECT id FROM {$bean->table_name} WHERE repeat_parent_id = '{$beanId}' AND deleted = 0 ORDER BY date_start";
		$re = $db->query($qu);
		
		$date_modified = $GLOBALS['timedate']->nowDb();

		$i = 0;
		while ($ro = $db->fetchByAssoc($re)) {
			$id = $ro['id'];
			if($i == 0){
				$new_parent_id = $id;
				$qu = "UPDATE {$bean->table_name} SET repeat_parent_id = NULL, recurring_source = NULL, date_modified = " . $db->convert($db->quoted($date_modified), 'datetime') . " WHERE id = '{$id}'";
			}else{
				$qu = "UPDATE {$bean->table_name} SET repeat_parent_id = '{$new_parent_id}', date_modified = " . $db->convert($db->quoted($date_modified), 'datetime') . " WHERE id = '{$id}'";
			}
			$db->query($qu);
      		$i++;
		}
	}

}
