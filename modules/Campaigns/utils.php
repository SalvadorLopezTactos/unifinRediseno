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

/*********************************************************************************
 * Description:  Defines the English language pack for the base application.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

use Doctrine\DBAL\Exception as DBALException;

/**
 * Returns a list of objects a message can be scoped by, the list contacts the current campaign
 * name and list of all prospects associated with this campaign..
 * @param string $campaign_id
 * @return array
 * @throws DBALException
 */
function get_message_scope_dom($campaign_id): array
{

    //find prospect list attached to this campaign..
    $query = 'SELECT prospect_list_id, prospect_lists.name'
        . ' FROM prospect_list_campaigns '
        . ' INNER JOIN prospect_lists'
        . ' ON prospect_lists.id = prospect_list_campaigns.prospect_list_id ';
    // We need to confirm that the user is a member of the team of the item.
    $bean = new SugarBean();
    $bean->disable_row_level_security = false;
    $bean->add_team_security_where_clause($query, 'prospect_lists');
    $query .= ' WHERE prospect_lists.deleted = 0'
        . ' AND prospect_list_campaigns.deleted=0'
        . ' AND campaign_id=? '
        . " AND prospect_lists.list_type NOT LIKE 'exempt%'";

    $result = $bean->db->getConnection()
        ->executeQuery($query, [$campaign_id]);
    $list = [];
    foreach ($result->iterateAssociative() as $row) {
        $list[$row['prospect_list_id']] = $row['name'];
    }
    return $list;
}

/**
 * Return bounce handling mailboxes for campaign.
 *
 * @param unknown_type $emails
 * @param unknown_type $get_box_name , Set it to false if want to get "From Name" other than the InboundEmail Name.
 * @return $get_name=true, bounce handling mailboxes' name; $get_name=false, bounce handling mailboxes' from name.
 */
function get_campaign_mailboxes(&$emails, $get_name = true)
{
    $return_array = [];
    if (!class_exists('InboundEmail')) {
        require 'modules/InboundEmail/InboundEmail.php';
    }
    $query = "select id,name,stored_options from inbound_email where mailbox_type='bounce' and status='Active' and deleted='0'";
    $db = DBManagerFactory::getInstance();
    $result = $db->query($query);
    while (($row = $db->fetchByAssoc($result)) != null) {
        if ($get_name) {
            $return_array[$row['id']] = $row['name'];
        } else {
            $return_array[$row['id']] = InboundEmail::decode_stored_option(
                $row['stored_options'],
                'from_name',
                $row['name']
            );
        }
        $emails[$row['id']] = InboundEmail::decode_stored_option(
            $row['stored_options'],
            'from_addr',
            'nobody@example.com'
        );
    }

    if (empty($return_array)) {
        $return_array = ['' => ''];
    }
    return $return_array;
}

function get_campaign_mailboxes_with_stored_options()
{
    $ret = [];

    if (!class_exists('InboundEmail')) {
        require 'modules/InboundEmail/InboundEmail.php';
    }

    $q = "SELECT id, name, stored_options FROM inbound_email WHERE mailbox_type='bounce' AND status='Active' AND deleted='0'";
    $db = DBManagerFactory::getInstance();
    $r = $db->query($q);

    while ($a = $db->fetchByAssoc($r)) {
        $stored_options = unserialize(base64_decode($a['stored_options']), ['allowed_classes' => false]);
        if (!empty($stored_options)) {
            $ret[$a['id']] = $stored_options;
        }
    }
    return $ret;
}

/**
 * Gets campaign type
 * @param string $track
 * @return string
 */
function getCampaignType($track)
{
    $db = DBManagerFactory::getInstance();
    $query = 'select c.campaign_type from campaign_trkrs ct, campaigns c where c.id = ct.campaign_id and ct.id = ' .
        $db->quoted($track) . ' and ct.deleted = 0 and c.deleted = 0';
    return $db->getOne($query);
}

/**
 * Checks if eamils have been sent for a campaign
 * @param string $track
 * @return boolean
 */
function hasSentCampaignEmail($track)
{
    $db = DBManagerFactory::getInstance();
    // when a campaign email is sent, a log entry is also created with activity_type = targeted
    // more_information contains the email address
    $query = 'select count(cl.more_information) from campaign_log cl, campaign_trkrs ct' .
        ' where ct.campaign_id = cl.campaign_id and ct.id = ' . $db->quoted($track) . ' and ct.deleted = 0' .
        " and cl.activity_type = 'targeted' and cl.more_information is not null and cl.deleted = 0";
    return $db->getOne($query) > 0;
}

function log_campaign_activity($identifier, $activity, $update = true, $clicked_url_key = null)
{

    $sugar_config = [];
    $data = [];
    $return_array = [];

    $db = DBManagerFactory::getInstance();


    //check to see if the identifier has been replaced with Banner string
    if ($identifier == 'BANNER' && isset($clicked_url_key) && !empty($clicked_url_key)) {
        // create md5 encrypted string using the client ip, this will be used for tracker id purposes
        $enc_id = 'BNR' . md5($_SERVER['REMOTE_ADDR']);

        //default the identifier to ip address
        $identifier = $enc_id;

        //if user has chosen to not use this mode of id generation, then replace identifier with plain guid.
        //difference is that guid will generate a new campaign log for EACH CLICK!!
        //encrypted generation will generate 1 campaign log and update the hit counter for each click
        if (isset($sugar_config['campaign_banner_id_generation']) && $sugar_config['campaign_banner_id_generation'] != 'md5') {
            $identifier = create_guid();
        }

        //retrieve campaign log.
        $trkr_query = 'select * from campaign_log where target_tracker_key= ' .
            $db->quoted($identifier) . ' and related_id = ' . $db->quoted($clicked_url_key);
        $current_trkr = $db->query($trkr_query);
        $row = $db->fetchByAssoc($current_trkr);

        //if campaign log is not retrieved (this is a new ip address or we have chosen to create
        //unique entries for each click
        if ($row == null || empty($row)) {
            //retrieve campaign id
            $trkr_query = 'select ct.campaign_id from campaign_trkrs ct, campaigns c
                    where c.id = ct.campaign_id and ct.id = ' . $db->quoted($clicked_url_key);
            $current_trkr = $db->query($trkr_query);
            $row = $db->fetchByAssoc($current_trkr);


            //create new campaign log with minimal info.  Note that we are creating new unique id
            //as target id, since we do not link banner/web campaigns to any users

            $data['target_id'] = create_guid();
            $data['target_type'] = 'Prospects';
            $data['id'] = create_guid();
            $data['campaign_id'] = $row['campaign_id'];
            $data['target_tracker_key'] = $identifier;
            $data['activity_type'] = $activity;
            $data['activity_date'] = TimeDate::getInstance()->nowDb();
            $data['hits'] = 1;
            $data['deleted'] = 0;
            if (!empty($clicked_url_key)) {
                $data['related_id'] = $clicked_url_key;
                $data['related_type'] = 'CampaignTrackers';
            }

            //values for return array..
            $return_array['target_id'] = $data['target_id'];
            $return_array['target_type'] = $data['target_type'];

            $db->getConnection()->insert('campaign_log', $data);
        } else {
            //campaign log already exists, so just set the return array and update hits column
            $return_array['target_id'] = $row['target_id'];
            $return_array['target_type'] = $row['target_type'];
            $query1 = 'update campaign_log set hits=hits+1 where id=' . $db->quoted($row['id']);
            $current = $db->query($query1);
        }

        //return array and exit
        return $return_array;
    }


    $query1 = 'select * from campaign_log where target_tracker_key= ' . $db->quoted($identifier) . ' and activity_type=' .
        $db->quoted($activity);
    if (!empty($clicked_url_key)) {
        $query1 .= ' AND related_id=' . $db->quoted($clicked_url_key);
    }
    $current = $db->query($query1);
    $row = $db->fetchByAssoc($current);

    if ($row == null) {
        $query = 'select * from campaign_log where target_tracker_key=' . $db->quoted($identifier) .
            " and activity_type='targeted'";
        $targeted = $db->query($query);
        $row = $db->fetchByAssoc($targeted);

        //if activity is removed and target type is users, then a user is trying to opt out
        //of emails.  This is not possible as Users Table does not have opt out column.
        if ($row && (strtolower($row['target_type']) == 'users' && $activity == 'removed')) {
            $return_array['target_id'] = $row['target_id'];
            $return_array['target_type'] = $row['target_type'];
            return $return_array;
        } elseif ($row) {
            $data['id'] = create_guid();
            $data['campaign_id'] = $row['campaign_id'];
            $data['target_tracker_key'] = $identifier;
            $data['target_id'] = $row['target_id'];
            $data['target_type'] = $row['target_type'];
            $data['activity_type'] = $activity;
            $data['activity_date'] = TimeDate::getInstance()->nowDb();
            $data['list_id'] = $row['list_id'];
            $data['marketing_id'] = $row['marketing_id'];
            $data['hits'] = 1;
            $data['deleted'] = 0;
            if (!empty($clicked_url_key)) {
                $data['related_id'] = $clicked_url_key;
                $data['related_type'] = 'CampaignTrackers';
            }

            //populate the primary email address into the more_info field
            if (!empty($row['target_id']) && !empty($row['target_type'])) {
                $sugarEmailAddress = BeanFactory::newBean('EmailAddresses');
                $primeEmail = $sugarEmailAddress->getPrimaryAddress(null, $row['target_id'], $row['target_type']);
                if (!empty($primeEmail)) {
                    $data['more_information'] = $primeEmail;
                }
            }

            //values for return array..
            $return_array['target_id'] = $row['target_id'];
            $return_array['target_type'] = $row['target_type'];
            $db->getConnection()->insert('campaign_log', $data);
        }
    } else {
        $return_array['target_id'] = $row['target_id'];
        $return_array['target_type'] = $row['target_type'];

        $query1 = 'update campaign_log set hits=hits+1 where id=' . $db->quoted($row['id']);
        $current = $db->query($query1);
    }
    //check to see if this is a removal action
    if ($row && $activity == 'removed') {
        //retrieve campaign and check it's type, we are looking for newsletter Campaigns
        $query = 'SELECT campaigns.* FROM campaigns WHERE campaigns.id = ' . $db->quoted($row['campaign_id']);
        $result = $db->query($query);
        if (!empty($result)) {
            $c_row = $db->fetchByAssoc($result);

            //if type is newsletter, then add campaign id to return_array for further processing.
            if (isset($c_row['campaign_type']) && $c_row['campaign_type'] == 'NewsLetter') {
                $return_array['campaign_id'] = $c_row['id'];
            }
        }
    }
    return $return_array;
}


/**
 *
 * This method is deprecated
 * @deprecated 62_Joneses - June 24, 2011
 * @see campaign_log_lead_or_contact_entry()
 */
function campaign_log_lead_entry($campaign_id, $parent_bean, $child_bean, $activity_type)
{
    campaign_log_lead_or_contact_entry($campaign_id, $parent_bean, $child_bean, $activity_type);
}


function campaign_log_lead_or_contact_entry($campaign_id, $parent_bean, $child_bean, $activity_type)
{
    global $timedate;

    //create campaign tracker id and retrieve related bio bean
    $tracker_id = create_guid();
    //create new campaign log record.
    $campaign_log = BeanFactory::newBean('CampaignLog');
    $campaign_log->campaign_id = $campaign_id;
    $campaign_log->target_tracker_key = $tracker_id;
    $campaign_log->related_id = $parent_bean->id;
    $campaign_log->related_type = $parent_bean->module_dir;
    $campaign_log->target_id = $child_bean->id;
    $campaign_log->target_type = $child_bean->module_dir;
    $campaign_log->activity_date = $timedate->now();
    $campaign_log->activity_type = $activity_type;
    //save the campaign log entry
    $campaign_log->save();
}


function get_campaign_urls($campaign_id)
{
    $return_array = [];

    if (!empty($campaign_id)) {
        $db = DBManagerFactory::getInstance();

        $query = 'SELECT * FROM campaign_trkrs WHERE campaign_id = ? AND deleted = 0';
        $conn = $db->getConnection();
        $stmt = $conn->executeQuery($query, [$campaign_id]);

        while ($row = $stmt->fetchAssociative()) {
            $return_array['{' . $row['tracker_name'] . '}'] = $row['tracker_name'] . ' : ' . $row['tracker_url'];
        }
    }
    return $return_array;
}

/**
 * Queries for the list
 */
function get_subscription_lists_query($focus, $additional_fields = null)
{
    //get all prospect lists belonging to Campaigns of type newsletter
    $all_news_type_pl_query = 'select c.name, pl.list_type, plc.campaign_id, plc.prospect_list_id';
    if (is_array($additional_fields) && !empty($additional_fields)) {
        $all_news_type_pl_query .= ', ' . implode(', ', $additional_fields);
    }
    $all_news_type_pl_query .= ' from prospect_list_campaigns plc , prospect_lists pl, campaigns c ';

    // We need to confirm that the user is a member of the team of the item.
    global $current_user;
    $bean = BeanFactory::newBean('Campaigns');

    //In the event of portal user, retrieve subscriptions with Global team access
    if ($current_user->portal_only) {
        $bean->disable_row_level_security = true;
        $all_news_type_pl_query .= " INNER JOIN (select tst.team_set_id from team_sets_teams tst INNER JOIN team_memberships team_membershipsc ON tst.team_id = team_membershipsc.team_id
				                    AND team_membershipsc.user_id = '1' AND team_membershipsc.deleted=0 group by tst.team_set_id) c_tf on c_tf.team_set_id  = c.team_set_id ";
    }

    $bean->add_team_security_where_clause($all_news_type_pl_query, 'c');

    $all_news_type_pl_query .= 'where plc.campaign_id = c.id ';
    $all_news_type_pl_query .= 'and plc.prospect_list_id = pl.id ';
    $all_news_type_pl_query .= "and c.campaign_type = 'NewsLetter'  and pl.deleted = 0 and c.deleted=0 and plc.deleted=0 ";
    $all_news_type_pl_query .= "and (pl.list_type like 'exempt%' or pl.list_type ='default') ";
    $all_news_type_pl_query .= 'ORDER BY pl.list_type ASC ';

    $all_news_type_list = $focus->db->query($all_news_type_pl_query);

    //build array of all newsletter campaigns
    $news_type_list_arr = [];
    while ($row = $focus->db->fetchByAssoc($all_news_type_list)) {
        $news_type_list_arr[] = $row;
    }

    //now get all the campaigns that the current user is assigned to
    $all_plp_current = "select prospect_list_id from prospect_lists_prospects where related_id = '$focus->id' and deleted = 0 ";

    //build array of prospect lists that this user belongs to
    $current_plp = $focus->db->query($all_plp_current);
    $current_plp_arr = [];
    while ($row = $focus->db->fetchByAssoc($current_plp)) {
        $current_plp_arr[] = $row;
    }

    return ['current_plp_arr' => $current_plp_arr, 'news_type_list_arr' => $news_type_list_arr];
}

/*
 * This function takes in a bean from a lead, prospect, or contact and returns an array containing
 * all subscription lists that the bean is a part of, and all the subscriptions that the bean is not
 * a part of.  The array elements have the key names of "subscribed" and "unsusbscribed".  These elements contain an array
 * of the corresponding list.  In other words, the "subscribed" element holds another array that holds the subscription information.
 *
 * The subscription information is a concatenated string that holds the prospect list id and the campaign id, separated by at "@" character.
 * To parse these information string into something more usable, use the "process subscriptions()" function
 *
 * */
function get_subscription_lists($focus, $descriptions = false)
{
    $return_array = [];
    $subs_arr = [];
    $unsubs_arr = [];

    $results = get_subscription_lists_query($focus, $descriptions);

    $news_type_list_arr = $results['news_type_list_arr'];
    $current_plp_arr = $results['current_plp_arr'];

    //For each  prospect list of type 'NewsLetter', check to see if current user is already in list,
    foreach ($news_type_list_arr as $news_list) {
        $match = 'false';

        //perform this check against each prospect list this user belongs to
        foreach ($current_plp_arr as $current_list_key => $current_list) {//echo " new entry from current lists user is subscribed to-------------";
            //compare current user list id against newsletter id
            if ($news_list['prospect_list_id'] == $current_list['prospect_list_id']) {
                //if id's match, user is subscribed to this list, check to see if this is an exempt list,
                if (strpos($news_list['list_type'], 'exempt') !== false) {
                    //this is an exempt list, so process
                    if (array_key_exists($news_list['name'], $subs_arr)) {
                        //first, add to unsubscribed array
                        $unsubs_arr[$news_list['name']] = $subs_arr[$news_list['name']];
                        //now remove from exempt subscription list
                        unset($subs_arr[$news_list['name']]);
                    } else {
                        //we know this is an exempt list the user belongs to, but the
                        //non exempt list has not been processed yet, so just add to exempt array
                        $unsubs_arr[$news_list['name']] = 'prospect_list@' . $news_list['prospect_list_id'] . '@campaign@' . $news_list['campaign_id'];
                    }
                    $match = 'false';//although match is false, this is an exempt array, so
                    //it will not be added a second time down below
                } else {
                    //this list is not exempt, and user is subscribed, so add to subscribed array, and unset from the unsubs_arr
                    //as long as this list is not in exempt array
                    $temp = 'prospect_list@' . $news_list['prospect_list_id'] . '@campaign@' . $news_list['campaign_id'];
                    if (!array_search($temp, $unsubs_arr)) {
                        $subs_arr[$news_list['name']] = 'prospect_list@' . $news_list['prospect_list_id'] . '@campaign@' . $news_list['campaign_id'];
                        $match = 'true';
                        unset($unsubs_arr[$news_list['name']]);
                    }
                }
            } else {
                //do nothing, there is no match
            }
        }
        //if this newsletter id never matched a user subscription..
        //..then add to available(unsubscribed) NewsLetters if list is not of type exempt
        if (($match == 'false') && (strpos($news_list['list_type'], 'exempt') === false) && (!array_key_exists($news_list['name'], $subs_arr))) {
            $unsubs_arr[$news_list['name']] = 'prospect_list@' . $news_list['prospect_list_id'] . '@campaign@' . $news_list['campaign_id'];
        }
    }
    $return_array['unsubscribed'] = $unsubs_arr;
    $return_array['subscribed'] = $subs_arr;
    return $return_array;
}

/**
 * same function as get_subscription_lists, but with the data separated in an associated array
 */
function get_subscription_lists_keyed($focus)
{
    $return_array = [];
    $subs_arr = [];
    $unsubs_arr = [];

    $results = get_subscription_lists_query($focus, ['c.content', 'c.frequency']);

    $news_type_list_arr = $results['news_type_list_arr'];
    $current_plp_arr = $results['current_plp_arr'];

    //For each  prospect list of type 'NewsLetter', check to see if current user is already in list,
    foreach ($news_type_list_arr as $news_list) {
        $match = false;

        $news_list_data = ['prospect_list_id' => $news_list['prospect_list_id'],
            'campaign_id' => $news_list['campaign_id'],
            'description' => $news_list['content'],
            'frequency' => $news_list['frequency']];

        //perform this check against each prospect list this user belongs to
        foreach ($current_plp_arr as $current_list_key => $current_list) {//echo " new entry from current lists user is subscribed to-------------";
            //compare current user list id against newsletter id
            if ($news_list['prospect_list_id'] == $current_list['prospect_list_id']) {
                //if id's match, user is subscribed to this list, check to see if this is an exempt list,

                if ($news_list['list_type'] == 'exempt') {
                    //this is an exempt list, so process
                    if (array_key_exists($news_list['name'], $subs_arr)) {
                        //first, add to unsubscribed array
                        $unsubs_arr[$news_list['name']] = $subs_arr[$news_list['name']];
                        //now remove from exempt subscription list
                        unset($subs_arr[$news_list['name']]);
                    } else {
                        //we know this is an exempt list the user belongs to, but the
                        //non exempt list has not been processed yet, so just add to exempt array
                        $unsubs_arr[$news_list['name']] = $news_list_data;
                    }
                    $match = false;//although match is false, this is an exempt array, so
                    //it will not be added a second time down below
                } else {
                    //this list is not exempt, and user is subscribed, so add to subscribed array
                    //as long as this list is not in exempt array
                    if (!array_key_exists($news_list['name'], $unsubs_arr)) {
                        $subs_arr[$news_list['name']] = $news_list_data;
                        $match = 'true';
                    }
                }
            } else {
                //do nothing, there is no match
            }
        }
        //if this newsletter id never matched a user subscription..
        //..then add to available(unsubscribed) NewsLetters if list is not of type exempt
        if (($match == false) && ($news_list['list_type'] != 'exempt')) {
            $unsubs_arr[$news_list['name']] = $news_list_data;
        }
    }

    $return_array['unsubscribed'] = $unsubs_arr;
    $return_array['subscribed'] = $subs_arr;
    return $return_array;
}


/*
 * This function will take an array of strings that have been created by the "get_subscription_lists()" method
 * and parses it into an array.  The returned array has it's key's labeled in a specific fashion.
 *
 * Each string produces a campaign and a prospect id.  The keys are appended with a number specifying the order
 * it was process in.  So an input array containing 3 strings will have the following key values:
 * "prospect_list0", "campaign0"
 * "prospect_list1", "campaign1"
 * "prospect_list2", "campaign2"
 *
 * */
function process_subscriptions($subscription_string_to_parse)
{
    $subs_change = [];

    //parse through and build list of id's'.  We are retrieving the campaign_id and
    //the prospect_list id from the selected subscriptions
    $i = 0;
    foreach ($subscription_string_to_parse as $subs_changes) {
        $subs_changes = trim($subs_changes);
        if (!empty($subs_changes)) {
            $ids_arr = explode('@', $subs_changes);
            $subs_change[$ids_arr[0] . $i] = $ids_arr[1];
            $subs_change[$ids_arr[2] . $i] = $ids_arr[3];
            $i = $i + 1;
        }
    }
    return $subs_change;
}


/***
 * This function is used by the Manage Subscriptions page in order to add the user
 * to the default prospect lists of the passed in campaign
 * Takes in campaign and prospect list id's we are subscribing to.
 * It also takes in a bean of the user (lead,target,prospect) we are subscribing
 *
 * @param string $campaign
 * @param string $prospect_list
 * @param SugarBean $focus
 * @param bool $default_list
 * @throws DBALException
 */
function subscribe($campaign, $prospect_list, SugarBean $focus, $default_list = false)
{
    $exempt_array = [];
    $relationship = strtolower($focus->getObjectName()) . 's';

    $prospectListsQuery = <<<SQL
SELECT id, list_type
FROM prospect_lists
WHERE id IN (
  SELECT prospect_list_id 
  FROM prospect_list_campaigns
  WHERE campaign_id = ?
) AND deleted = 0 
SQL;

    $prospectsListResult = $focus->db->getConnection()
        ->executeQuery($prospectListsQuery, [$campaign]);

    //retrieve lists that this user belongs to
    $userProspectsListQuery = <<<SQL
SELECT prospect_list_id, related_id  
FROM prospect_lists_prospects 
WHERE related_id = ?  AND deleted = 0 
SQL;

    $userProspectsList = $focus->db->getConnection()
        ->executeQuery($userProspectsListQuery, [$focus->id])
        ->fetchAllAssociative();

    //search through prospect lists for this campaign and identifiy the "unsubscription list"
    $exempt_id = '';
    foreach ($prospectsListResult->iterateAssociative() as $subscription_list) {
        if (strpos($subscription_list['list_type'], 'exempt') !== false) {
            $exempt_id = $subscription_list['id'];
        }

        if ($subscription_list['list_type'] == 'default' && $default_list) {
            $prospect_list = $subscription_list['id'];
        }
    }

    //now that we have exempt (unsubscription) list id, compare against user list id's
    if (!empty($exempt_id)) {
        $exempt_array['exempt_id'] = $exempt_id;

        foreach ($userProspectsList as $curr_subscription_list) {
            if ($curr_subscription_list['prospect_list_id'] == $exempt_id) {
                //--if we are in here then user is subscribing to a list in which they are exempt.
                // we need to remove the user from this unsubscription list.
                //Begin by retrieving unsubscription prospect list
                $exempt_subscription_list = BeanFactory::newBean('ProspectLists');
                if ($GLOBALS['current_user']->portal_only) {
                    $exempt_subscription_list->disable_row_level_security = true;
                }
                $exempt_result = $exempt_subscription_list->retrieve($exempt_id);
                if ($exempt_result == null) {//error happened while retrieving this list
                    return;
                }
                //load realationships and delete user from unsubscription list
                $exempt_subscription_list->load_relationship($relationship);
                $exempt_subscription_list->$relationship->delete($exempt_id, $focus->id);
            }
        }
    }

    //Now we need to check if user is already in subscription list
    $already_here = false;
    //for each list user is subscribed to, compare id's with current list id'
    foreach ($userProspectsList as $user_list) {
        if (safeInArray($prospect_list, $user_list)) {
            //if user already exists, then set flag to true
            $already_here = true;
            break;
        }
    }
    if (!$already_here) {
        //user is not subscribed already, so add to subscription list
        $subscription_list = BeanFactory::newBean('ProspectLists');
        if ($GLOBALS['current_user']->portal_only) {
            $subscription_list->disable_row_level_security = true;
        }
        $subs_result = $subscription_list->retrieve($prospect_list);
        if ($subs_result == null) {//error happened while retrieving this list, iterate and continue
            return;
        }
        //load subscription list and add this user
        $GLOBALS['log']->debug('In Campaigns Util, loading relationship: ' . $relationship);
        $subscription_list->load_relationship($relationship);
        $subscription_list->$relationship->add($focus->id);
    }
}


/**
 * This function is used by the Manage Subscriptions page in order to add the user
 * to the exempt prospect lists of the passed in campaign
 * Takes in campaign and focus parameters.
 *
 * @param string $campaign
 * @param SugarBean $focus
 * @throws DBALException
 */
function unsubscribe($campaign, SugarBean $focus)
{
    $exempt_list = null;
    $relationship = strtolower($focus->getObjectName()) . 's';
    //--grab all the list for this campaign id
    $prospectListsQuery = <<<SQL
SELECT id, list_type
FROM prospect_lists
WHERE id IN (
  SELECT prospect_list_id 
  FROM prospect_list_campaigns
  WHERE campaign_id = ?
) AND deleted = 0 
SQL;

    $prospectsList = $focus->db->getConnection()
        ->executeQuery($prospectListsQuery, [$campaign])
        ->fetchAllAssociative();

    //retrieve lists that this user belongs to
    $userProspectsListQuery = <<<SQL
SELECT prospect_list_id, related_id  
FROM prospect_lists_prospects 
WHERE related_id = ?  AND deleted = 0 
SQL;

    $userProspectsListResult = $focus->db->getConnection()
        ->executeQuery($userProspectsListQuery, [$focus->id]);

    //check to see if user is already there in prospect list
    $already_here = false;
    $exempt_id = '';

    foreach ($userProspectsListResult->iterateAssociative() as $user_list) {
        foreach ($prospectsList as $v) {
            //if list is exempt list
            if ($v['list_type'] == 'exempt') {
                //save the exempt list id for later use
                $exempt_id = $v['id'];
                //check to see if user is already in this exempt list
                if (safeInArray($v['id'], $user_list)) {
                    $already_here = true;
                }

                break 2;
            }
        }
    }

    //unsubscribe subscripted newsletter
    foreach ($prospectsList as $subscription_list) {
        //create a new instance of the prospect list
        $exempt_list = BeanFactory::getBean('ProspectLists', $subscription_list['id']);
        $exempt_list->load_relationship($relationship);
        //if list type is default, then delete the relationship
        //if list type is exempt, then add the relationship to unsubscription list
        if ($subscription_list['list_type'] == 'exempt') {
            $exempt_list->$relationship->add($focus->id);
        }
    }

    if (!$already_here) {
        //user is not exempted yet , so add to unsubscription list
        $tmp_security = $exempt_list->disable_row_level_security;
        $exempt_list->disable_row_level_security = 1;
        $exempt_result = $exempt_list->retrieve($exempt_id);
        $exempt_list->disable_row_level_security = $tmp_security;
        if ($exempt_result == null) {//error happened while retrieving this list
            return;
        }
        $GLOBALS['log']->debug('In Campaigns Util, loading relationship: ' . $relationship);
        $exempt_list->load_relationship($relationship);
        $exempt_list->$relationship->add($focus->id);
    }
}

/**
 *This function will return a string to the newsletter wizard if campaign check
 *does not return 100% healthy.
 */
function diagnose()
{
    global $mod_strings;
    global $current_user;
    $msg = " <table class='detail view small' width='100%'><tr><td> " . $mod_strings['LNK_CAMPAIGN_DIGNOSTIC_LINK'] . '</td></tr>';
    //Start with email components
    //monitored mailbox section
    $focus = Administration::getSettings(); //retrieve all admin settings.


    //run query for mail boxes of type 'bounce'
    $email_health = 0;
    $mbox_qry = "select * from inbound_email where deleted ='0' and mailbox_type = 'bounce'";
    $mbox_res = $focus->db->query($mbox_qry);

    $mbox = [];
    while ($mbox_row = $focus->db->fetchByAssoc($mbox_res)) {
        $mbox[] = $mbox_row;
    }
    if (!isset($mbox) || safeCount($mbox) <= 0) {
        // if array is empty, then increment health counter and set error message
        $email_health = $email_health + 1;
        $msg .= "<tr><td ><font color='red'><b>" . $mod_strings['LBL_MAILBOX_CHECK1_BAD'] . '</b></font>';
        if (is_admin($current_user)) {
            $msg .= "&nbsp;<a href='index.php?module=InboundEmail&action=index'>" .
                $mod_strings['LBL_INBOUND_EMAIL_SETTINGS'] .
                '</a>';
        }
        $msg .= '</td></tr>';
    }

    if (strstr($focus->settings['notify_fromaddress'], 'example.com')) {
        //if "from_address" is the default, then set "bad" message and increment health counter
        $email_health = $email_health + 1;
        $msg .= "<tr><td ><font color='red'><b> " . $mod_strings['LBL_MAILBOX_CHECK2_BAD'] . ' </b></font>';
        if (is_admin($current_user)) {
            $msg .= "&nbsp;<a href='index.php?module=EmailMan&action=config'>" .
                $mod_strings['LBL_SYSTEM_EMAIL_SETTINGS'] .
                '</a>';
        }
        $msg .= '</td></tr>';
    }

    // If user isn't an admin, give them the appropriate warning message
    if (!is_admin($current_user)) {
        $msg .= '<tr><td >' . $mod_strings['LBL_NON_ADMIN_ERROR_MSG'] . '</td></tr>';
    }

    // proceed with scheduler components

    //create and run the scheduler queries
    $sched_qry = "select job, name, status from schedulers where deleted = 0 and status = 'Active'";
    $sched_res = $focus->db->query($sched_qry);
    $sched_health = 0;
    $sched = [];
    $check_sched1 = 'function::runMassEmailCampaign';
    $check_sched2 = 'function::pollMonitoredInboxesForBouncedCampaignEmails';
    $sched_mes = '';
    $sched_mes_body = '';
    $scheds = [];

    while ($sched_row = $focus->db->fetchByAssoc($sched_res)) {
        $scheds[] = $sched_row;
    }
    //iterate through and see which jobs were found
    foreach ($scheds as $funct) {
        if (($funct['job'] == $check_sched1) || ($funct['job'] == $check_sched2)) {
            if ($funct['job'] == $check_sched1) {
                $check_sched1 = 'found';
            } else {
                $check_sched2 = 'found';
            }
        }
    }
    //determine if error messages need to be displayed for schedulers
    if ($check_sched2 != 'found') {
        $sched_health = $sched_health + 1;
        $msg .= "<tr><td><font color='red'><b>" . $mod_strings['LBL_SCHEDULER_CHECK1_BAD'] . '</b></font></td></tr>';
    }
    if ($check_sched1 != 'found') {
        $sched_health = $sched_health + 1;
        $msg .= "<tr><td><font color='red'><b>" . $mod_strings['LBL_SCHEDULER_CHECK2_BAD'] . '</b></font></td></tr>';
    }
    //if health counter is above 1, then show admin link
    if ($sched_health > 0) {
        global $current_user;
        if (is_admin($current_user)) {
            $msg .= "<tr><td ><a href='index.php?module=Schedulers&action=index'>" . $mod_strings['LBL_SCHEDULER_LINK'] . '</a></td></tr>';
        } else {
            $msg .= '<tr><td >' . $mod_strings['LBL_NON_ADMIN_ERROR_MSG'] . '</td></tr>';
        }
    }

    //determine whether message should be returned
    if (($sched_health + $email_health) > 0) {
        $msg .= '</table> ';
    } else {
        $msg = '';
    }
    return $msg;
}


/**
 * Handle campaign log entry creation for mail-merge activity. The function will be called by the soap component.
 *
 * @param String campaign_id Primary key of the campaign
 * @param array targets List of keys for entries from prospect_lists_prosects table
 */
function campaign_log_mail_merge($campaign_id, $targets)
{

    $campaign = BeanFactory::getBean('Campaigns', $campaign_id);

    if (empty($campaign->id)) {
        $GLOBALS['log']->debug('set_campaign_merge: Invalid campaign id' . $campaign_id);
    } else {
        foreach ($targets as $target_list_id) {
            $pl_query = "select * from prospect_lists_prospects where id='" . $GLOBALS['db']->quote($target_list_id) . "'";
            $result = $GLOBALS['db']->query($pl_query);
            $row = $GLOBALS['db']->fetchByAssoc($result);
            if (!empty($row)) {
                write_mail_merge_log_entry($campaign_id, $row);
            }
        }
    }
}

/**
 * Function creates a campaign_log entry for campaigns processesed using the mail-merge feature. If any entry
 * exist the hit counter is updated. target_tracker_key is used to locate duplicate entries.
 * @param string campaign_id Primary key of the campaign
 * @param array $pl_row A row of data from prospect_lists_prospects table.
 */
function write_mail_merge_log_entry($campaign_id, $pl_row)
{

    //Update the log entry if it exists.
    $update = "update campaign_log set hits=hits+1 where campaign_id='" . $GLOBALS['db']->quote($campaign_id) . "' and target_tracker_key='" . $GLOBALS['db']->quote($pl_row['id']) . "'";
    $result = $GLOBALS['db']->query($update);

    //get affected row count...
    $count = $GLOBALS['db']->getAffectedRowCount();
    if ($count == 0) {
        $data = [];

        $data['id'] = "'" . create_guid() . "'";
        $data['campaign_id'] = "'" . $GLOBALS['db']->quote($campaign_id) . "'";
        $data['target_tracker_key'] = "'" . $GLOBALS['db']->quote($pl_row['id']) . "'";
        $data['target_id'] = "'" . $GLOBALS['db']->quote($pl_row['related_id']) . "'";
        $data['target_type'] = "'" . $GLOBALS['db']->quote($pl_row['related_type']) . "'";
        $data['activity_type'] = "'targeted'";
        $data['activity_date'] = "'" . TimeDate::getInstance()->nowDb() . "'";
        $data['list_id'] = "'" . $GLOBALS['db']->quote($pl_row['prospect_list_id']) . "'";
        $data['hits'] = 1;
        $data['deleted'] = 0;
        $insert_query = 'INSERT into campaign_log (' . implode(',', array_keys($data)) . ')';
        $insert_query .= ' VALUES  (' . implode(',', array_values($data)) . ')';
        $GLOBALS['db']->query($insert_query);
    }
}

function track_campaign_prospects($focus)
{
    $campaign_id = $GLOBALS['db']->quote($focus->id);
    $delete_query = "delete from campaign_log where campaign_id='" . $campaign_id . "' and activity_type='targeted'";
    $focus->db->query($delete_query);

    $current_date = $focus->db->now();
    $guidSQL = $focus->db->getGuidSQL();

    $insert_query = 'INSERT INTO campaign_log (id,activity_date, campaign_id, target_tracker_key,list_id, target_id, target_type, activity_type, deleted';
    $insert_query .= ')';
    $insert_query .= "SELECT {$guidSQL}, $current_date, plc.campaign_id,{$guidSQL},plp.prospect_list_id, plp.related_id, plp.related_type,'targeted',0 ";
    $insert_query .= 'FROM prospect_lists INNER JOIN prospect_lists_prospects plp ON plp.prospect_list_id = prospect_lists.id';
    $insert_query .= ' INNER JOIN prospect_list_campaigns plc ON plc.prospect_list_id = prospect_lists.id';
    $insert_query .= " WHERE plc.campaign_id='" . $GLOBALS['db']->quote($focus->id) . "'";
    $insert_query .= ' AND prospect_lists.deleted=0';
    $insert_query .= ' AND plc.deleted=0';
    $insert_query .= ' AND plp.deleted=0';
    $insert_query .= " AND prospect_lists.list_type!='test'";
    $insert_query .= ' AND plp.related_id NOT IN';
    $insert_query .= ' (SELECT related_id FROM prospect_lists_prospects plp1';
    $insert_query .= '  INNER JOIN prospect_lists pl1 ON plp1.prospect_list_id = pl1.id';
    $insert_query .= "  WHERE pl1.list_type LIKE 'exempt%')";
    $focus->db->query($insert_query);

    global $mod_strings;
    //return success message
    return $mod_strings['LBL_DEFAULT_LIST_ENTRIES_WERE_PROCESSED'];
}

function create_campaign_log_entry($campaign_id, $focus, $rel_name, $rel_bean, $target_id = '')
{
    global $timedate;

    $target_ids = [];
    //check if this is specified for one target/contact/prospect/lead (from contact/lead detail subpanel)
    if (!empty($target_id)) {
        $target_ids[] = $target_id;
    } else {
        //this is specified for all, so load target/prospect relationships (mark as sent button)
        $focus->load_relationship($rel_name);
        $target_ids = $focus->$rel_name->get();
    }
    if (safeCount($target_ids) > 0) {
        //retrieve the target beans and create campaign log entry
        foreach ($target_ids as $id) {
            //perform duplicate check
            $dup_query = 'select id from campaign_log where campaign_id = ' . $focus->db->quoted($campaign_id) .
                ' and target_id = ' . $focus->db->quoted($id);
            $dup_result = $focus->db->query($dup_query);
            $row = $focus->db->fetchByAssoc($dup_result);

            //process if this is not a duplicate campaign log entry
            if (empty($row)) {
                //create campaign tracker id and retrieve related bio bean
                $tracker_id = create_guid();
                $rel_bean->retrieve($id);

                //create new campaign log record.
                $campaign_log = BeanFactory::newBean('CampaignLog');
                $campaign_log->campaign_id = $campaign_id;
                $campaign_log->target_tracker_key = $tracker_id;
                $campaign_log->target_id = $rel_bean->id;
                $campaign_log->target_type = $rel_bean->module_dir;
                $campaign_log->activity_type = 'targeted';
                $campaign_log->activity_date = $timedate->now();
                //save the campaign log entry
                $campaign_log->save();
            }
        }
    }
}

/*
 * This function will return an array that has been formatted to work as a Quick Search Object for prospect lists
 */
function getProspectListQSObjects($source = '', $return_field_name = 'name', $return_field_id = 'id')
{
    global $app_strings;
    //if source has not been specified, then search across all prospect lists
    if (empty($source)) {
        $qsProspectList = ['method' => 'query',
            'modules' => ['ProspectLists'],
            'group' => 'and',
            'field_list' => ['name', 'id'],
            'populate_list' => ['prospect_list_name', 'prospect_list_id'],
            'conditions' => [['name' => 'name', 'op' => 'like_custom', 'end' => '%', 'value' => '']],
            'order' => 'name',
            'limit' => '30',
            'no_match_text' => $app_strings['ERR_SQS_NO_MATCH']];
    } else {
        //source has been specified use it to tell quicksearch.js which html input to use to get filter value
        $qsProspectList = ['method' => 'query',
            'modules' => ['ProspectLists'],
            'group' => 'and',
            'field_list' => ['name', 'id'],
            'populate_list' => [$return_field_name, $return_field_id],
            'conditions' => [
                ['name' => 'name', 'op' => 'like_custom', 'end' => '%', 'value' => ''],
                //this condition has the source parameter defined, meaning the query will take the value specified below
                ['name' => 'list_type', 'op' => 'like_custom', 'end' => '%', 'value' => '', 'source' => $source],
            ],
            'order' => 'name',
            'limit' => '30',
            'no_match_text' => $app_strings['ERR_SQS_NO_MATCH']];
    }

    return $qsProspectList;
}
