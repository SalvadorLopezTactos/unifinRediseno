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
class ConnectorApi extends SugarApi
{
    /**
     * internal instance of connector manager
     * @var null
     */
    public $connectorManager = null;

    public function registerApiRest()
    {
        return array(
            'getConnectors' => array(
                'reqType' => 'GET',
                'path' => array('connectors'),
                'pathVars' => array('connectors'),
                'method' => 'getConnectors',
                'shortHelp' => 'Gets connector information',
                'longHelp' => 'include/api/help/connectors_get_help.html',
            ),
        );
    }

    /**
     * gets instance conenctor manager
     * @return ConnectorManager
     */
    public function getConnectorManager()
    {
        if (empty($this->connectorManger)) {
            require_once('include/connectors/ConnectorManager.php');
            $this->connectorManager = new ConnectorManager();
        }
        return $this->connectorManager;
    }

    /**
     * gets connector metadata
     * @param Object $api api object
     * @param Array $args arguments passed from api
     * @return array
     */
    public function getConnectors($api, $args)
    {
        $cm = $this->getConnectorManager();
        // build cache
        return $cm->getUserConnectors();
    }

    /**
     * handles if given connector hash is valid
     * @param Array $args arguments passed from api
     * @throws SugarApiExceptionInvalidHash
     */
    public function validateHash($args)
    {
        if (!empty($args['connectorHash'])) {
            $cm = $this->getConnectorManager();
            $valid = $cm->isHashValid($args['connectorHash']);
            if (!$valid) {
                // hash is invalid throw api error for 412
                throw new SugarApiExceptionInvalidHash(
                    'EXCEPTION_CONNECTORS_META_OUT_OF_DATE',
                    null,
                    null,
                    0,
                    'connectors_meta_out_of_date'
                );
            }
        }
    }

}
