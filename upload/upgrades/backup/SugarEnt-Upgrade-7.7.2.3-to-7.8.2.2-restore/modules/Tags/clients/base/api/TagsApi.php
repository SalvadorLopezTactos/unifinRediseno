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

require_once('clients/base/api/ModuleApi.php');

/**
 * Extends ModuleApi for Tags specific work
 *
 * Class TagsApi
 */
class TagsApi extends ModuleApi
{
    /**
     * Set up the endpoint for Tags
     *
     * @return array
     */
    public function registerApiRest()
    {
        return array(
            'update' => array(
                'reqType' => 'PUT',
                'path' => array('Tags','?'),
                'pathVars' => array('module','record'),
                'method' => 'updateRecord',
                'shortHelp' => 'This method updates a record of the specified type',
                'longHelp' => 'include/api/help/module_record_put_help.html',
            ),
        );
    }

    /**
     * Fetches data from the $args array and updates the bean with that data
     *
     * @param $bean SugarBean The bean to be updated
     * @param $api ServiceBase The API class of the request, used in cases
     *      where the API changes how the fields are pulled from the args array.
     * @param $args array The arguments array passed in from the API
     * @return id Bean id
     */
    public function updateBean($bean, $api, $args)
    {
        //Set verfiedUnique from args
        $bean->verifiedUnique = !empty($args['verifiedUnique']);
        return parent::updateBean($bean, $api, $args);
    }
}
