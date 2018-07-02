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

require_once('include/connectors/sources/default/source.php');

class ext_eapm_google extends source {
	protected $_enable_in_wizard = false;
	protected $_enable_in_hover = false;
	protected $_has_testing_enabled = false;
    protected $_gdClient = null;

    private function loadGdClient()
    {
        if($this->_gdClient == null)
        {
            $this->_eapm->getClient("contacts");
            $this->_gdClient = $this->_eapm->gdClient;
            $maxResults = $GLOBALS['sugar_config']['list_max_entries_per_page'];
            $this->_gdClient->setMaxResults($maxResults);
        }
    }

	public function getItem($args=array(), $module=null)
    {
        if( !isset($args['id']) )
            throw new Exception("Unable to return google contact entry with missing id.");
        
        $this->loadGdClient();

        $entry = FALSE;
        try
        {
            $entry = $this->_gdClient->getContactEntry( $args['id'] );
        }
        catch(Zend_Gdata_App_HttpException $e)
        {
            $GLOBALS['log']->fatal("Received exception while trying to retrieve google contact item:" .  $e->getResponse());
        }
        catch(Exception $e)
        {
            $GLOBALS['log']->fatal("Unable to retrieve single item " . var_export($e, TRUE));
        }

        return $entry;

    }
	public function getList($args=array(), $module=null)
    {
        $feed = FALSE;
        $this->loadGdClient();

        if( !empty($args['maxResults']) )
        {
            $this->_gdClient->setMaxResults($args['maxResults']);
        }

        if( !empty($args['startIndex']) )
        {
            $this->_gdClient->setStartIndex($args['startIndex']);
        }

        $results = array('totalResults' => 0, 'records' => array());
        try
        {
            $feed = $this->_gdClient->getContactListFeed($args);
            $results['totalResults'] = $feed->totalResults->getText();

            $rows = array();
            foreach ($feed->entries as $entry)
            {
                $rows[] = $entry->toArray();
            }
            $results['records'] = $rows;
        }
        catch(Zend_Gdata_App_HttpException $e)
        {
            $GLOBALS['log']->fatal("Received exception while trying to retrieve google contact list:" .  $e->getResponse());
        }
        catch(Exception $e)
        {
            $GLOBALS['log']->fatal("Unable to retrieve item list for google contact connector.");
        }

        return $results;
    }
}
