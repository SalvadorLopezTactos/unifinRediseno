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

require_once 'modules/pmse_Inbox/engine/Crypt.php';
require_once 'modules/pmse_Inbox/engine/PMSEEngineUtils.php';
require_once 'modules/pmse_Inbox/engine/PMSEHandlers/PMSECaseFlowHandler.php';
require_once 'modules/pmse_Inbox/engine/PMSEFlowRouter.php';

/**
 * The License Manager class, validates licenses, establish connections to the license server,
 * but also retrieve and process the returned license data.
 * @codeCoverageIgnore
 */
class PMSELicenseManager
{
    /**
     * @deprecated since version 1.0.4
     * @var type
     */
    protected $connectionGateway;

    /**
     * Key attribute
     * @var string
     */
    protected $key;

    /**
     * Access Manager Bean
     * @var \ADAMAccessManager
     */
    protected $amBean;

    /**
     * PMSE configuration object
     * @var \PMSE
     */
    protected $pmse;

    /**
     * module path
     * @var string
     */
    protected $modulePath;

    /**
     * module name
     * @var string
     */
    protected $moduleName;

    /**
     * Crypt class object
     * @var \Crypt
     */
    protected $crypt;

    /**
     * Database Manager instance.
     * @var \DBManager
     */
    protected $db;

    /**
     * Class constructor
     * @global \DBManager $db
     */
    public function __construct()
    {
        //$this->connectionGateway = new ADAMConnectionGateway();
        $this->amBean = BeanFactory::getBean('pmse_BpmAccessManagement'); //BpmAccessManagement();
        $this->key = '1234567890';
        $this->crypt = new Crypt();
        global $db;
        $this->db = isset($GLOBALS["db"]) ? $GLOBALS["db"] : $db;

        $this->pmse = PMSE::getInstance();
        $this->moduleName = $this->pmse->getModuleName();
    }

    /**
     * Get the Crypt attribute
     * @return \Crypt
     * @codeCoverageIgnore
     */
    public function getCrypt()
    {
        return $this->crypt;
    }

    /**
     * Set the Crypt attribute
     * @param \Crypt $crypt
     * @codeCoverageIgnore
     */
    public function setCrypt($crypt)
    {
        $this->crypt = $crypt;
    }

    /**
     * Get the DB Manager attribute
     * @return \DBManager
     * @codeCoverageIgnore
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * Set the DB Manager attribute
     * @param \DBManager $db
     * @codeCoverageIgnore
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     * Get the Access Manager Bean
     * @codeCoverageIgnore
     *
     * @return \ADAMAccessManager
     */
    public function getAmBean()
    {
        return $this->amBean;
    }

    /**
     * Set the access manager bean
     * @param \ADAMAccessManager $amBean
     * @codeCoverageIgnore
     */
    public function setAmBean($amBean)
    {
        $this->amBean = $amBean;
    }

    /**
     * get the active license
     * @codeCoverageIgnore
     * @return boolean
     */
    public function getActiveLicense()
    {
        return false;
    }

    /**
     * Process the activation code, and validate the license.
     * @param string $activationCode
     * @return \stdClass
     */
    public function processActivationCode($activationCode)
    {
        //        $smarty = new Sugar_Smarty();
        $result = new stdClass();
        $result->success = false;
        $getLicense = new stdClass();

        //Verify if activationCode exist in DB
        $rs = $this->amBean->retrieve_by_string_fields(array("acm_key" => $activationCode));
        if (!empty($rs)) {
            $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_MESSAGE_ALREADYINSTALLED', $this->moduleName);
            return $result;
        }


        //Get Server from activation code
        $decodeAC = $this->crypt->decodeActivationCode($activationCode);

        if ($decodeAC->success) {
            $host = 'http://' . $this->getServerName($decodeAC->server) . '/';
            $path = 'rest/generatelicense/' . $activationCode;
        } else {
            $result->message = $decodeAC->message;
            return $result;
        }

        $key = blowfishGetKey('ProcessMaker');

        $data = array();
        $data['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
        $data['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
        $data['SERVER_SOFTWARE'] = $_SERVER['SERVER_SOFTWARE'];
        $data['SERVER_NAME'] = $_SERVER['SERVER_NAME'];
        $data['SERVER_ADDR'] = $_SERVER['SERVER_ADDR'];
        $data['SERVER_PORT'] = $_SERVER['SERVER_PORT'];
        $data['ACTIVATION_CODE'] = $activationCode;
        $data['REMOTE_KEY'] = $key;
        $data['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
        $data['SCRIPT_FILENAME'] = $_SERVER['SCRIPT_FILENAME'];

        $strRequest = $this->crypt->generateRequest($this->key, json_encode($data));

        try {
            $getLicense = $this->httpRequest($host, $path, $strRequest);
        } catch (Exception $e) {
            $result->message = $e->getMessage();
            return $result;
        }

        if (empty($getLicense)) {
            $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_ERROR_LICENSESERVER', $this->moduleName);
            $result->request = $strRequest;
            return $result;
        }

        if (isset($getLicense->success) && $getLicense->success) {
            $license = json_decode($this->crypt->openLicense($key, $getLicense->license));
            $sql = "UPDATE pmse_bpm_access_management SET acm_status = 'INACTIVE'";
            $GLOBALS["db"]->query($sql);
            //Insert into DataBase
            $this->amBean->new_with_id = true;
            $this->amBean->acm_key = $license->lic_activation_code;
            $this->amBean->acm_type = $license->lic_type;
            $this->amBean->acm_status = 'ACTIVE';
            $this->amBean->acm_expiration_date = date("Y-m-d H:i:s", strtotime($license->lic_product_expiration_date));
            $this->amBean->acm_data = $getLicense->license;
            $this->amBean->acm_uid = PMSEEngineUtils::generateUniqueID();
            $this->amBean->save();
            if (!$this->amBean->in_save) {
                $result->success = true;
                $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_MESSAGE_INSTALLSUCCESSFULLY',
                    $this->moduleName);
                // call wakeUPFreezedFlows
                $this->wakeUpFreezedFlows();
            }
        } else {
            if (isset($getLicense->error)) {
                $result->message = $getLicense->error;
                $result->request = $strRequest;
            } else {
                if (isset($getLicense->message)) {
                    $result->message = $getLicense->message;
                } else {
                    $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_ERROR_LICENSESERVER', $this->moduleName);
                }
            }
        }
        //        $result->success = true;
        //        $smarty->assign("licenseData", array(array('label'=>'# Administrators', 'value'=>1), array('label'=>'# Inboxes','value'=>10), array('label'=>'# Cases','value'=>10000), array('label'=>'Expiration Date','value'=>'15-05-2015'), array('label'=>'Support Expiration Date','value'=>'15-05-2014')));
        //        $result->data    = $smarty->fetch('modules/ProcessMaker/tpls/licenseView.tpl');
        return $result;
    }

    /**
     * Process the content of a license string.
     * @param string $lic
     * @return \stdClass
     */
    public function processLicense($lic)
    {
        $result = new stdClass();
        $result->success = false;

        $key = blowfishGetKey('ProcessMaker');

        //        $lic = preg_replace('/\n|\r\n/', '', $lic);
        //        print_r($lic);
        try {
            $license = json_decode($this->crypt->openLicense($key, $lic));
        } catch (Exception $e) {
            $result->message = $e->getMessage();
            return $result;
        }

        if (empty($license)) {
            $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_MESSAGE_NOTVALID', $this->moduleName);
            return $result;
        } else {
            if (!isset($license->lic_activation_code)) {
                $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_MESSAGE_ACTIVATIONCODEMISSING' . $this->moduleName);
                return $result;
            }
        }

        //Verify if activationCode exist in DB
        $rs = $this->amBean->retrieve_by_string_fields(array('acm_key' => $license->lic_activation_code));
        if (empty($rs)) {
            $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_MESSAGE_ALREADYINSTALLED', $this->moduleName);
            return $result;
        }

        $sql = "UPDATE pmse_ bpm_access_management SET acm_status = 'INACTIVE'";
        $GLOBALS["db"]->query($sql);

        //Insert into DataBase
        $this->amBean->new_with_id = true;
        $this->amBean->acm_key = $license->lic_activation_code;
        $this->amBean->acm_type = $license->lic_type;
        $this->amBean->acm_status = 'ACTIVE'; //$license->lic_status;
        $this->amBean->acm_expiration_date = date("Y-m-d H:i:s", strtotime($license->lic_product_expiration_date));
        $this->amBean->acm_data = $lic;
        $this->amBean->acm_uid = PMSEEngineUtils::generateUniqueID();
        $this->amBean->save();
        if (!$this->amBean->in_save) {
            $result->success = true;
            $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_MESSAGE_INSTALLSUCCESSFULLY', $this->moduleName);
        }

        return $result;
    }

    /**
     * Get the already stored license data.
     * @param string $uid
     * @return \stdClass
     */
    public function getLicenseData($uid)
    {
        $result = new stdClass();
        $result->success = false;
        $key = blowfishGetKey('ProcessMaker');

        //TODO DELETE THIS LINE
        //$result->success = true;
        //return $result;

        //Verify if activationCode exist in DB
        $rs = $this->amBean->retrieve_by_string_fields(array("acm_uid" => $uid));
        if (empty($rs)) {
            $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_MESSAGE_IDFIELDMISSING', $this->moduleName);
            return $result;
        }

        try {
            $license = json_decode($this->crypt->openLicense($key, $rs->acm_data));
        } catch (Exception $e) {
            $result->message = $e->getMessage();
            return $result;
        }

        if (empty($license)) {
            $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_MESSAGE_NOTVALID', $this->moduleName);
            return $result;
        } else {
            if (!isset($license->lic_max_admins)) {
                $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_MESSAGE_ADMINISTRATORMISSING',
                    $this->moduleName);
                return $result;
            } else {
                $result->lic_max_admins = $license->lic_max_admins;
            }
            if (!isset($license->lic_max_users)) {
                $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_MESSAGE_USERSMISSING', $this->moduleName);
                return $result;
            } else {
                $result->lic_max_users = $license->lic_max_users;
            }
            if (!isset($license->lic_max_cases)) {
                $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_MESSAGE_CASESMISSING', $this->moduleName);
                return $result;
            } else {
                $result->lic_max_cases = $license->lic_max_cases;
            }
            if (!isset($license->lic_product_expiration_date)) {
                $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_MESSAGE_PRODUCTDATEMISSING',
                    $this->moduleName);
                return $result;
            } else {
                $result->lic_product_expiration_date = $license->lic_product_expiration_date;
            }
            if (!isset($license->lic_support_expiration_date)) {
                $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_MESSAGE_SUPPORTDATEMISSING',
                    $this->moduleName);
                return $result;
            } else {
                $result->lic_support_expiration_date = $license->lic_support_expiration_date;
            }
            if (!isset($license->lic_enabled_br)) {
                $result->message = translate('LBL_PMSE_ADAM_LICENSEMANAGER_MESSAGE_BUSSINESRULESMISSING',
                    $this->moduleName);
                return $result;
            } else {
                $result->lic_enabled_br = (bool)$license->lic_enabled_br;
            }
            $result->success = true;
        }
        return $result;
    }

    /**
     * Execute the httpRequest using the curl extension for php.
     * @param string $host
     * @param string $path
     * @param array $params
     * @param string $method
     * @return \stdClass
     * @codeCoverageIgnore
     */
    private function httpRequest($host, $path, $params, $method = 'POST')
    {
        $result = new stdClass();
        $result->success = false;
        try {
            //            $host = 'http://wwww.cualquiiercosjasjd.com/rest/';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $host . $path);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            $r = curl_exec($ch);
            if (!empty($r)) {
                $result = json_decode($r);
            } else {
                $result->error = translate('LBL_PMSE_ADAM_LICENSEMANAGER_ERROR_LICENSESERVER', $this->moduleName);
            }
        } catch (Exception $e) {
            $result->error = $e->getMessage();
        }
        return $result;
    }

    /**
     * Get the Active license record and process it in order to retrieve the license data.
     * @return array
     */
    public function getActiveLicenseData()
    {
        $this->amBean->retrieve_by_string_fields(array('acm_status' => 'ACTIVE'));
        $uid = isset($this->amBean->acm_uid) ? $this->amBean->acm_uid : '';
        $result = $this->getLicenseData($uid);
        return $result;
    }

    /**
     * Check which server should be called, this call is based in the activation code string.
     * @param string $serverCode
     * @return string
     * @codeCoverageIgnore
     */
    private function getServerName($serverCode)
    {
        switch ($serverCode) {
            case '11':
                $serverName = 'licensepmse.processmaker.com';
                break;
            case '21':
                $serverName = 'license.pmos3.colosa.net';
                break;
        }
        return $serverName;
    }

    /**
     *
     */
    public function wakeUpFreezedFlows()
    {
        //$this->bpmLog('DEBUG', "cron: checking flows with status freezed");
        $flowBean = BeanFactory::getBean('pmse_BpmFlow');
        $flows = $flowBean->get_list('', "cas_flow_status='FREEZE'");
        $n = 0;
        foreach ($flows['list'] as $flow) {
            $flowData = get_object_vars($flow);
            $bean = BeanFactory::getBean($flowData['cas_sugar_module'], $flowData['cas_sugar_object_id']);
            $caseHandler = new PMSECaseFlowHandler();
            $bpmnElement = $caseHandler->retrieveElementByType($flowData['bpmn_type']);
            $flowRouter = new PMSEFlowRouter();
            $executionResult = $bpmnElement->run($flowData, $bean);
            $executionResult['flow_action'] = 'UPDATE';
            $executionResult['flow_id'] = $flowData['id'];
            $flowRouter->wakeUpEngine($flowData, false, $bean, $executionResult);
            $n++;
        }

        // replace the bpmLog calls for the error handler classes
        if ($n == 0) {

            //$this->bpmLog('DEBUG', ": processed $n flows with status freezed");
        } else {
            //$this->bpmLog('INFO', "cron: processed $n flows with status freezed");
        }
    }
}
