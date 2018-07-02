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

require_once('include/Sugarpdf/Sugarpdf.php');

class SugarpdfFactory{
    /**
     * load the correct Tcpdf
     * @param string $type Tcpdf Type
     * @return valid Tcpdf
     */
    function loadSugarpdf($type = 'default', $module, $bean = null, $sugarpdf_object_map = array())
    {
        $type = strtolower(basename($type));
        //first let's check if the module handles this Tcpdf
        $sugarpdf = null;
        $path = '/sugarpdf/sugarpdf.'.$type.'.php';
        $pdf_file = SugarAutoLoader::existingCustomOne('include/Sugarpdf'.$path, 'modules/'.$module.$path);
        if($pdf_file) {
            $sugarpdf = SugarpdfFactory::_buildFromFile($pdf_file, $bean, $sugarpdf_object_map, $type, $module);
        }

        // Default to Sugarpdf if still nothing found/built
        if (!isset($sugarpdf))
            $sugarpdf = new Sugarpdf($bean, $sugarpdf_object_map);
        return $sugarpdf;
    }

    /**
     * This is a private function which just helps the getSugarpdf function generate the
     * proper Tcpdf object
     *
     * @return a valid Sugarpdf
     */
    function _buildFromFile($file, &$bean, $sugarpdf_object_map, $type, $module)
    {
        require_once($file);
        //try ModuleSugarpdfType first then try SugarpdfType if that fails then use Sugarpdf
        $class = ucfirst($module).'Sugarpdf'.ucfirst($type);
        if(!class_exists($class)){
            $class = 'Sugarpdf'.ucfirst($type);
            if(!class_exists($class)){
                return new Sugarpdf($bean, $sugarpdf_object_map);
            }
        }
        return SugarpdfFactory::_buildClass($class, $bean, $sugarpdf_object_map);
    }

    /**
     * instantiate the correct Tcpdf and call init to pass on any obejcts we need to
     * from the controller.
     *
     * @param string class - the name of the class to instantiate
     * @param object bean = the bean to pass to the Sugarpdf
     * @param array Sugarpdf_object_map - the array which holds obejcts to pass between the
     *                                controller and the tcpdf.
     *
     * @return Sugarpdf
     */
    function _buildClass($class, &$bean, $sugarpdf_object_map)
    {
        $sugarpdf = new $class($bean, $sugarpdf_object_map);
        if($sugarpdf instanceof Sugarpdf) {
            return $sugarpdf;
        } else {
            return new Sugarpdf($bean, $sugarpdf_object_map);
        }
    }
}
