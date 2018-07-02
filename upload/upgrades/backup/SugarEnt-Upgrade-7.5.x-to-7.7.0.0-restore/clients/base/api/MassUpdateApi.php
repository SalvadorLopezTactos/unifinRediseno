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


require_once('include/SugarQueue/jobs/SugarJobMassUpdate.php');
require_once('include/api/SugarApi.php');

/*
 * Mass Update API implementation
 */
class MassUpdateApi extends SugarApi {

    /**
     * This function registers the mass update Rest api
     */
    public function registerApiRest() {
        return array(
            'massUpdatePut' => array(
                'reqType' => 'PUT',
                'path' => array('<module>','MassUpdate'),
                'pathVars' => array('module',''),
                'jsonParams' => array('filter'),
                'method' => 'massUpdate',
                'shortHelp' => 'An API to handle mass update.',
                'longHelp' => 'include/api/help/module_massupdate_put_help.html',
            ),
            'massUpdateDelete' => array(
                'reqType' => 'DELETE',
                'path' => array('<module>','MassUpdate'),
                'pathVars' => array('module',''),
                'jsonParams' => array('filter'),
                'method' => 'massDelete',
                'shortHelp' => 'An API to handle mass delete.',
                'longHelp' => 'include/api/help/module_massupdate_delete_help.html',
            ),
        );
    }

    /**
     * @var bool to indicate whether this is a request to delete records
     */
    protected $delete = false;

    /**
     * @var string job id
     */
    protected $jobId = null;

    /**
     * To perform mass delete
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return String
     */
    public function massDelete($api, $args)
    {
        $this->requireArgs($args, array('massupdate_params', 'module'));
        $this->delete = true;
        $args['massupdate_params']['Delete'] = true;
        
        // SC-1021: add 'creation date' filter if 'delete all'
        if (!empty($args['massupdate_params']['entire'])) { 
            unset($args['massupdate_params']['uid']);

            if (empty($args['massupdate_params']['filter'])) {
                $args['massupdate_params']['filter'] = array();
            }

            $args['massupdate_params']['filter'][] = array('date_entered' => array('$lt' => TimeDate::getInstance()->getNow(true)));
        }

        return $this->massUpdate($api, $args);
    }

    /**
     * To perform massupdate, either update or delete, based on the args parameter
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return String
     */
    public function massUpdate($api, $args)
    {
        $this->requireArgs($args, array('massupdate_params', 'module'));

        $mu_params = $args['massupdate_params'];
        $mu_params['module'] = $args['module'];

        // should pass success status once uid is empty.
        if (empty($mu_params['uid']) && empty($mu_params['entire'])) {
            return array('status'=>'done');
        }

        if (isset($mu_params['entire']) && empty($mu_params['entire'])) {
            unset($mu_params['entire']);
        }

        if(isset($mu_params['team_name'])) {
            if(isset($mu_params['team_name_type']) && $mu_params['team_name_type'] === '1') {
                $mu_params['team_name_type'] = "add";
            } else {
                $mu_params['team_name_type'] = "replace";
            }
        }

        // check ACL
        $bean = BeanFactory::newBean($mu_params['module']);
        if (!$bean instanceof SugarBean) {
            throw new SugarApiExceptionInvalidParameter("Invalid bean, is module valid?");
        }
        $action = $this->delete? 'delete': 'save';
        if (!$bean->ACLAccess($action))
        {
            throw new SugarApiExceptionNotAuthorized('No access to mass update records for module: '.$mu_params['module']);
        }
        $mu_params['action'] = $action;

        $massUpdateJob = new SugarJobMassUpdate();
        $massUpdateJob->runUpdate($mu_params);
        
        return array('status'=>'done');
    }

    /**
     * This function returns job id.
     * @return String job id
     */
    public function getJobId()
    {
        return $this->jobId;
    }

}
