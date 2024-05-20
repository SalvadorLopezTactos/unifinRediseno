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

class ExternalUsersApi extends ModuleApi
{
    public function registerApiRest()
    {
        return [
            'create' => [
                'reqType' => 'POST',
                'path' => array('ExternalUsers'),
                'pathVars' => array('module'),
                'method' => 'createRecord',
                'shortHelp' => 'This method creates a new record of the specified type',
                'longHelp' => 'include/api/help/module_post_help.html',
                'minVersion' => '11.8',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function createRecord(ServiceBase $api, array $args)
    {
        $duplicateCheckApi = new DuplicateCheckApi();
        $result = $duplicateCheckApi->checkForDuplicates($api, $args);
        if (!empty($result['records'])) {
            throw new SugarApiExceptionInvalidParameter('Duplicates detected');
        }
        return parent::createRecord($api, $args);
    }
}
