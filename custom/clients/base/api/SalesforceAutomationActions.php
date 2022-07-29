<?php
/**
 * Created by PhpStorm.
 * User: Jorge
 * Date: 8/1/2015
 * Time: 10:50 PM
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/Levementum/SFA_Helper.php');
class SalesforceAutomationActions extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'POSTSalesforceAutomationActions' => array(
                'reqType' => 'POST',
                'path' => array('SalesforceAutomationActions'),
                'pathVars' => array(''),
                'method' => 'setForecast',
                'shortHelp' => 'Mueve el forecast a pipeline o backlog desde un dashlet',
            ),
        );
    }

    public function setForecast($api, $args)
    {
        global $current_user;
        try
        {
            $oppId = $args['data']['oppId'];
            $forecast = $args['data']['forecastSelected'];
            $assignedOppId = $args['data']['assignedOppId'];
            $descriptionNotification = $args['data']['description'];
            $oppName = $args['data']['oppName'];
            if($oppId != null && $forecast != null) {
                $opp = BeanFactory::getBean('Opportunities', $oppId);
                if($forecast == 'Pipeline' || $forecast == 'Backlog') {
                    $opp->forecast_c = $forecast;
                }else{
                    $opp->forecast_c = "QuitarBoP";
                    $opp->forecast_time_c = $forecast;
                }

                $opp->save();
            }

            if($assignedOppId != null && $descriptionNotification != null){
                $noti = BeanFactory::getBean('Notifications');
                $noti->assigned_user_id = $assignedOppId;
                $noti->name = $oppName;
                $noti->description = $descriptionNotification;
                $noti->save();

                $user_director = new SFA_Helper();
                $manager = $user_director->userReportsTo($assignedOppId);

                $notiManager = BeanFactory::getBean('Notifications');
                $notiManager->assigned_user_id = $manager;
                $notiManager->name = $oppName;
                $notiManager->description = $descriptionNotification;
                $notiManager->save();
            }
        }catch (Exception $e){
            error_log(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> : Error: ".$e->getMessage());
            $GLOBALS['log']->fatal(__FILE__." - ".__CLASS__."->".__FUNCTION__." <".$current_user->user_name."> :  Error ".$e->getMessage());
        }
    }
}