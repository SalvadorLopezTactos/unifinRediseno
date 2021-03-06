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

require_once('include/SugarForecasting/AbstractForecast.php');
class SugarForecasting_Individual extends SugarForecasting_AbstractForecast implements SugarForecasting_ForecastSaveInterface
{
    /**
     * Where we store the data we want to use
     *
     * @var array
     */
    protected $dataArray = array();

    /**
     * Run all the tasks we need to process get the data back
     *
     * @deprecated
     * @see ForecastWorksheetsFilterApi
     * @return array|string
     */
    public function process()
    {
        return array();
    }


    /**
     * getQuery
     * @deprecated
     * This is a helper function to allow for the query function to be used in ForecastWorksheet->create_export_query
     */
    public function getQuery()
    {
        return '';
    }

    /**
     * Save the Individual Worksheet
     *
     * @return ForecastWorksheet
     * @throws SugarApiException
     */
    public function save()
    {
        require_once('include/SugarFields/SugarFieldHandler.php');
        /* @var $seed ForecastWorksheet */
        $seed = BeanFactory::getBean("ForecastWorksheets");
        $seed->loadFromRow($this->args);
        $sfh = new SugarFieldHandler();

        foreach ($seed->field_defs as $properties) {
            $fieldName = $properties['name'];

            if(!isset($this->args[$fieldName])) {
               continue;
            }

            if (!$seed->ACLFieldAccess($fieldName,'save') ) {
                // No write access to this field, but they tried to edit it
                global $app_strings;
                throw new SugarApiException(string_format($app_strings['SUGAR_API_EXCEPTION_NOT_AUTHORIZED'], array($fieldName, $this->args['module'])));
            }

            $type = !empty($properties['custom_type']) ? $properties['custom_type'] : $properties['type'];
            $field = $sfh->getSugarField($type);

            if(!is_null($field)) {
               $field->save($seed, $this->args, $fieldName, $properties);
            }
        }

        // Check if this is the first commit, then save has_commits true to the config table
        $admin = BeanFactory::getBean('Administration');
        $settings = $admin->getConfigForModule('Forecasts');
        if (!isset($settings['has_commits']) || !$settings['has_commits']) {
            $admin->saveSetting('Forecasts', 'has_commits', true, 'base');
        }

        $seed->setWorksheetArgs($this->args);
        // we need to set the parent_type and parent_id so it finds it when we try and retrieve the old records
        $seed->parent_type = $this->getArg('parent_type');
        $seed->parent_id = $this->getArg('parent_id');
        $seed->saveWorksheet();

        // we have the id, just retrieve the record again
        $seed = BeanFactory::getBean("ForecastWorksheets", $this->getArg('record'));

        return $seed;
    }
}
