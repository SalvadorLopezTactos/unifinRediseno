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

class pmse_InboxController extends SugarController
{
    public function __construct()
    {
        parent::SugarController();
    }

    public function action_studio_configuration()
    {
        $this->view = 'studio_configuration';
    }

    public function action_showCase()
    {
        $this->view = 'showCase';
    }

    public function action_noShowCase()
    {
        $this->view = 'noShowCase';
    }

    /**
     *
     * @global type $beanList
     * @global type $current_user
     * @global type $beanFiles
     * @deprecated since version pmse2
     * @codeCoverageIgnore
     */
    public function action_routeCase()
    {
        require_once 'modules/pmse_Inbox/clients/base/api/PMSEEngineApi.php';
        $data = $_REQUEST;
        $data['frm_action'] = $data['Type'];
        $data['taskName'] = '';
        $engineApi = new PMSEEngineApi();
        $result = $engineApi->engineRoute(array(), $data);
        header('Location: index.php');
    }
    
    public function action_showPNG()
    {
        require_once 'modules/pmse_Inbox/clients/base/api/PMSEImageGeneratorApi.php';
        header('Content-Type: image/png');
        $img = new PMSEImageGeneratorApi();
        $img->getProcessImage(null, array('record' => $_REQUEST['case']));
    }

    public function action_showHistoryEntries()
    {
        $this->view = 'showHistoryEntries';
    }

    public function action_showNotes()
    {
        $this->view = 'showNotes';
    }
}
