<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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

require_once('include/api/SugarApi.php');
require_once('modules/ExpressionEngine/formulaHelper.php');

/**
 * Used to evaluate related expressions on the front end for arbitrary (possibly unsaved) records.
 */
class RelatedValueApi extends SugarApi
{
    /**
     * Rest Api Registration Method
     *
     * @return array
     */
    public function registerApiRest()
    {
        $parentApi = array(
            'related_value' => array(
                'reqType' => 'GET',
                'path' => array('ExpressionEngine', '?', 'related'),
                'pathVars' => array('', 'record', ''),
                'method' => 'getRelatedValues',
                'shortHelp' => 'Retrieve the Chart data for the given data in the Forecast Module',
                'longHelp' => 'modules/Forecasts/clients/base/api/help/ForecastChartApi.html',
            ),
        );
        return $parentApi;
    }

    /**
     * Used by the dependency manager to pre-load all the related fields required
     * to load an entire view.
     */
    public function getRelatedValues($api, $args)
    {
        if (empty($args['module']) || empty($args['fields'])) {
            return;
        }
        $fields = json_decode(html_entity_decode($args['fields']), true);
        $focus = $this->loadBean($api, $args);
        $ret = array();
        foreach ($fields as $rfDef) {
            if (!isset($rfDef['link']) || !isset($rfDef['type'])) {
                continue;
            }
            $link = $rfDef['link'];
            $type = $rfDef['type'];
            $rField = '';
            if (!isset($ret[$link])) {
                $ret[$link] = array();
            }
            if (empty($ret[$link][$type])) {
                $ret[$link][$type] = array();
            }
            // count formulas don't have a relate attribute
            if (isset($rfDef['relate'])) {
                $rField = $rfDef['relate'];
            }

            switch ($type) {
                //The Related function is used for pulling a sing field from a related record
                case "related":
                    //Default it to a blank value
                    $ret[$link]['related'][$rfDef['relate']] = "";

                    //If we have neither a focus id nor a related record id, we can't retrieve anything
                    $relBean = null;
                    if (empty($rfDef['relId']) || empty($rfDef['relModule'])) {
                        //If the relationship is invalid, just move onto another field
                        if (!$focus->load_relationship($link)) {
                            break;
                        }

                        $beans = $focus->$link->getBeans(array("enforce_teams" => true));
                        //No related beans means no value
                        if (empty($beans)) {
                            break;
                        }
                        //Grab the first bean on the list
                        reset($beans);
                        $relBean = current($beans);
                    } else {
                        $relBean = BeanFactory::getBean($rfDef['relModule'], $rfDef['relId']);
                    }
                    //If we found a bean and the current user has access to the related field, grab a value from it
                    if (!empty($relBean) && ACLField::hasAccess($rfDef['relate'], $relBean->module_dir, $GLOBALS['current_user']->id, true)) {
                        $validFields = FormulaHelper::cleanFields($relBean->field_defs, false, true, true);
                        if (isset($validFields[$rfDef['relate']])) {
                            $ret[$link]['relId'] = $relBean->id;
                            $ret[$link]['related'][$rfDef['relate']] =
                                FormulaHelper::getFieldValue($relBean, $rfDef['relate']);
                        }
                    }

                    break;
                case "count":
                    if ($focus->load_relationship($link)) {
                        $ret[$link][$type] = count($focus->$link->get());
                    } else {
                        $ret[$link][$type] = 0;
                    }
                    break;
                case "rollupSum":
                case "rollupAve":
                case "rollupMin":
                case "rollupMax":
                    //If we are going to calculate one rollup, calculate all the rollups since there is so little cost
                    if ($focus->load_relationship($link)) {
                        $relBeans = $focus->$link->getBeans(array("enforce_teams" => true));
                        $sum = 0;
                        $count = 0;
                        $min = false;
                        $max = false;
                        if (!empty($relBeans)) {
                            //Check if the related record vardef has banned this field from formulas
                            $relBean = reset($relBeans);
                            $validFields = FormulaHelper::cleanFields($relBean->field_defs, false, true, true);
                            if (!isset($validFields[$rField])) {
                                $ret[$link][$type][$rField] = 0;
                                break;
                            }
                        }
                        foreach ($relBeans as $bean) {
                            if (isset($bean->$rField) && is_numeric($bean->$rField) &&
                                //ensure the user can access the fields we are using.
                                ACLField::hasAccess($rField, $bean->module_dir, $GLOBALS['current_user']->id, true)
                            ) {
                                $count++;
                                $sum += floatval($bean->$rField);
                                if ($min === false || $bean->$rField < $min) {
                                    $min = floatval($bean->$rField);
                                }
                                if ($max === false || $bean->$rField > $max) {
                                    $max = floatval($bean->$rField);
                                }
                            }
                        }
                        if ($type == "rollupSum") {
                            $ret[$link][$type][$rField] = $sum;
                        }
                        if ($type == "rollupAve") {
                            $ret[$link][$type][$rField] = $count == 0 ? 0 : $sum / $count;
                        }
                        if ($type == "rollupMin") {
                            $ret[$link][$type][$rField] = $min;
                        }
                        if ($type == "rollupMax") {
                            $ret[$link][$type][$rField] = $max;
                        }
                    } else {
                        $ret[$link][$type][$rField] = 0;
                    }
                    break;

                case "rollupCurrencySum":
                    $ret[$link][$type][$rField] = 0;
                    if ($focus->load_relationship($link)) {
                        $toRate = isset($focus->base_rate) ? $focus->base_rate : null;
                        $relBeans = $focus->$link->getBeans(array("enforce_teams" => true));
                        $sum = 0;
                        foreach ($relBeans as $bean) {
                            if (!empty($bean->$rField) && is_numeric($bean->$rField) &&
                                //ensure the user can access the fields we are using.
                                ACLField::hasAccess($rField, $bean->module_dir, $GLOBALS['current_user']->id, true)
                            ) {
                                $sum = SugarMath::init($sum)->add(
                                    SugarCurrency::convertWithRate($bean->$rField, $bean->base_rate, $toRate)
                                )->result();
                            }
                        }
                        $ret[$link][$type][$rField] = $sum;
                    }
                    break;
            }
        }

        return $ret;
    }
}
