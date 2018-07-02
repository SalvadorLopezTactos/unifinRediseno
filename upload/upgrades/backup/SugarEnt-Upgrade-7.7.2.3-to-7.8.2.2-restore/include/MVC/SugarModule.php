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

class SugarModule
{
    protected static $_instances = array();

    protected $_moduleName;

    public static function get(
        $moduleName
        )
    {
        if ( !isset(self::$_instances[$moduleName]) )
            self::$_instances[$moduleName] = new SugarModule($moduleName);

        return self::$_instances[$moduleName];
    }

    public function __construct(
        $moduleName
        )
    {
        $this->_moduleName = $moduleName;
    }

    /**
     * Returns true if the given module implements the indicated template
     *
     * @param  string $template
     * @return bool
     */
    public function moduleImplements(
        $template
        )
    {
        $focus = self::loadBean();

        if ( !$focus )
            return false;

        return is_a($focus,$template);
    }

    /**
     * Returns the bean object of the given module
     *
     * @return object
     */
    public function loadBean($beanList = null, $beanFiles = null, $returnObject = true)
    {
        return BeanFactory::getBean($this->_moduleName);
//         // Populate these reference arrays
//         if ( empty($beanList) ) {
//             global $beanList;
//         }
//         if ( empty($beanFiles) ) {
//             global $beanFiles;
//         }
//         if ( !isset($beanList) || !isset($beanFiles) ) {
//             require('include/modules.php');
//         }

//         if ( isset($beanList[$this->_moduleName]) ) {
//             $bean = $beanList[$this->_moduleName];
//             if (isset($beanFiles[$bean])) {
//                 if ( !$returnObject ) {
//                     return true;
//                 }
//                 if ( !sugar_is_file($beanFiles[$bean]) ) {
//                     return false;
//                 }
//                 require_once($beanFiles[$bean]);
//                 $focus = new $bean;
//             }
//             else {
//                 return false;
//             }
//         }
//         else {
//             return false;
//         }

//         return $focus;
    }
}
