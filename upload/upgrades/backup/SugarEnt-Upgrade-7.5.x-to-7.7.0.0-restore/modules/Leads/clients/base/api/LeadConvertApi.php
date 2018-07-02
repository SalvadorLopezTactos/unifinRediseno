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

require_once('clients/base/api/ModuleApi.php');
require_once('modules/Leads/LeadConvert.php');

class LeadConvertApi extends ModuleApi {

    public function registerApiRest()
    {
        //Extend with test method
        $api= array (
            'convertLead' => array(
                'reqType' => 'POST',
                'path' => array('Leads', '?', 'convert'),
                'pathVars' => array('','leadId',''),
                'method' => 'convertLead',
                'shortHelp' => 'Convert Lead to a Contact and optionally link it to a new or existing module such as an Account or Opportunity',
                'longHelp' => 'modules/Leads/clients/base/api/help/LeadConvertApi.html',
            ),
        );

        return $api;
    }

    /**
     * This method handles the /Lead/:id/convert REST endpoint
     *
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return Array of worksheet data entries
     * @throws SugarApiExceptionNotAuthorized
     */
    public function convertLead($api, $args)
    {
        $leadConvert = new LeadConvert($args['leadId']);
        $modules = $this->loadModules($api, $leadConvert->getAvailableModules(), $args['modules']);
        $modules = $leadConvert->convertLead($modules);

        return array (
            'modules' => $this->formatBeans($api, $args, $modules)
        );
    }

    /**
     * This method loads a bean from posted data through api
     *
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $module The module name to be loaded/created.
     * @param $data The posted data
     * @return SugarBean The loaded bean
     * @throws SugarApiExceptionInvalidParameter
     */
    protected function loadModule($api, $module, $data) {
        if (isset($data['id'])) {
            $moduleDef = array (
                'module' => $module,
                'record' => $data['id']
            );
            $bean = $this->loadBean($api, $moduleDef);
        }
        else {
            $bean = BeanFactory::newBean($module);
            //populate bean
            $result = $this->populateFromApi($api, $bean, $data);
            if ($result !== true) {
                $GLOBALS['log']->error("Failure attempting to load up {$module} bean from given data. Error: {$result}");
                throw new SugarApiExceptionInvalidParameter("Unable to convert lead. There were validation errors on the submitted data.");
            }
        }
        return $bean;
    }

    /**
     * This method loads an array of beans based on available modules for lead convert
     *
     * @param $api ServiceBase The API class of the request, used in cases where the API changes how the fields are pulled from the args array.
     * @param $modulesToConvert Array The modules that will be loaded/created.
     * @param $data The posted data
     * @return Array SugarBean The loaded beans
     */
    protected function loadModules($api, $modulesToConvert, $data) {
        $beans = array();

        foreach ($modulesToConvert as $moduleName) {
            if (!isset($data[$moduleName])) {
                continue;
            }
            $beans[$moduleName] = $this->loadModule($api, $moduleName, $data[$moduleName]);
        }
        return $beans;
    }

    /**
     * Populate the given bean from the args passed into the api
     *
     * @param $api
     * @param $bean
     * @param $args
     * @param array $options
     * @return mixed
     */
    protected function populateFromApi($api, $bean, $args, $options=array())
    {
        return ApiHelper::getHelper($api,$bean)->populateFromApi($bean,$args,$options);
    }

}
