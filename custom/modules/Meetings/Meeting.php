<?php
//Entensión de Meeting.php 
require_once("modules/Meetings/Meeting.php");
class CustomMeeting extends Meeting {
    // save date_end by calculating user input
    function set_accept_status($user,$status)
    {
        if($user->object_name == 'User')
        {   //Solo si el usuario asignado es el usuario loggeado se modificará status a aceptado. 
            if($this->assigned_user_id == $GLOBALS['current_user']->id){
                $relate_values = array('user_id'=>$user->id,'meeting_id'=>$this->id);
                $data_values = array('accept_status'=>$status);
                $this->set_relationship($this->rel_users_table, $relate_values, true, true,$data_values);

            }
            global $current_user;

            if($this->update_vcal)
            {
                vCal::cache_sugar_vcal($user);
            }
        }
        else if($user->object_name == 'Contact')
        {
            $relate_values = array('contact_id'=>$user->id,'meeting_id'=>$this->id);
            $data_values = array('accept_status'=>$status);
            $this->set_relationship($this->rel_contacts_table, $relate_values, true, true,$data_values);
        }
        else if($user->object_name == 'Lead')
        {
            $relate_values = array('lead_id'=>$user->id,'meeting_id'=>$this->id);
            $data_values = array('accept_status'=>$status);
            $this->set_relationship($this->rel_leads_table, $relate_values, true, true,$data_values);
        }
    }
}