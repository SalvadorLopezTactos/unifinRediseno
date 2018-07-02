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

require_once 'modules/pmse_Inbox/engine/PMSELicenseManager.php';

/**
 * The access Manager class evaluates and processes the license data in order
 * to provide or deny access to some module features based on the data
 * stored in the database
 *
 */
class PMSEAccessManager
{
    /**
     * The license manager attribute
     * @var \ADAMLicenseManager
     */
    protected $licenseManager;

    /**
     * The decrypt key attribute
     * @var string
     */
    protected $decryptKey;

    /**
     * The license data array
     * @var array
     */
    protected $licenseData;

    /**
     * The license activation data array
     * @var array
     */
    protected $licenseActivationData;

    /**
     * The license permission array
     * @var array
     */
    protected $licensePermissions;

    /**
     * The user preference object that is used to search the number of assigned dashlets
     * @var \UserPreference
     */
    protected $preferenceRetriever;

    /**
     * The user dashlets array.
     * @var array
     */
    protected $userDashlets;

    /**
     * The list of admin dashlets assigned.
     * @var array
     */
    protected $adminDashlets;

    /**
     * The cases Bean
     * @var \BpmInbox
     */
    protected $casesBean;

    /**
     * The Access Management bean in which is stored the license data.
     * @var \BpmAccessManagement
     */
    protected $accessManager;


    /**
     * The constructor method intializes all the object attributes
     */
    public function __construct()
    {
        $this->licenseManager = new PMSELicenseManager();
        $this->accessManager = BeanFactory::getBean('pmse_BpmAccessManagement'); //new BpmAccessManagement();
        $this->licenseData = array();
        $this->licensePermissions = array();
        $this->preferenceRetriever = new UserPreference();
        $this->userDashlets = array('ProcessMakerDashlet');
        $this->adminDashlets = array(
            'BpmnProjectDashlet',
            'CasesByProcessChartDashlet',
            'CasesByUserChartDashlet',
            'BusinessRulesListDashlet',
            'EmailTemplateDashlet'
        );
        $this->casesBean = BeanFactory::newBean('pmse_Inbox'); //new BpmInbox();
    }

    /**
     * Get the AccessManager attribute
     * @codeCoverageIgnore
     *
     * @return \ADAMAccessManager
     */
    public function getAccessManager()
    {
        return $this->accessManager;
    }

    /**
     * Set the AccessManager attribute
     * @codeCoverageIgnore
     *
     * @param \BpmAccessManagement $accessManager
     */
    public function setAccessManager($accessManager)
    {
        $this->accessManager = $accessManager;
    }

    /**
     * Get The cases attribute.
     * @codeCoverageIgnore
     *
     * @return \BpmInbox
     */
    public function getCasesBean()
    {
        return $this->casesBean;
    }

    /**
     * set the cases bean attribute.
     * @codeCoverageIgnore
     *
     * @param \BpmInbox $casesBean
     */
    public function setCasesBean($casesBean)
    {
        $this->casesBean = $casesBean;
    }

    /**
     * Get the license manager attribute wich is an instance of the ADAMLicenseManager class
     * @codeCoverageIgnore
     *
     * @return \ADAMLicenseManager
     */
    public function getLicenseManager()
    {
        if (empty($this->licenseManager)) {
            $this->licenseManager = new ADAMLicenseManager();
        }
        return $this->licenseManager;
    }

    /**
     * Set the license manager attribute wich is an instance of the ADAMLicenseManager class
     * @codeCoverageIgnore
     *
     * @param ADAMLicenseManager $licenseManager
     */
    public function setLicenseManager(PMSELicenseManager $licenseManager)
    {
        $this->licenseManager = $licenseManager;
    }

    /**
     * Get the preference retriever attribute wich is an instance of the UserPreference class
     * @codeCoverageIgnore
     *
     * @return \UserPreference
     */
    public function getPreferenceRetriever()
    {
        if (empty($this->preferenceRetriever)) {
            $this->preferenceRetriever = new UserPreference();
        }
        return $this->preferenceRetriever;
    }

    /**
     * Get the DecryptKey attribute wich is the result of calling the BlowFish key ProcessMaker
     * @codeCoverageIgnore
     * @return string
     */
    public function getDecryptKey()
    {
        if (empty($this->decryptKey)) {
            $this->decryptKey = blowfishGetKey('ProcessMaker');
        }
        return $this->decryptKey;
    }

    /**
     * Set the DecryptKey attribute
     * @codeCoverageIgnore
     *
     * @param string $decryptKey
     */
    public function setDecryptKey($decryptKey)
    {
        $this->decryptKey = $decryptKey;
    }

    /**
     * Get the preference retriever attribute wich is an instance of the UserPreference class
     * @codeCoverageIgnore
     *
     * @param \UserPreference $preferenceRetriever
     */
    public function setPreferenceRetriever($preferenceRetriever)
    {
        $this->preferenceRetriever = $preferenceRetriever;
    }

    /**
     * Process The license Permissions based on the active license data,
     * if this data doesn't exists a default configuration is used instead, this one doesn't have any permissions
     * @return array
     */
    public function getLicensePermissions()
    {
        $this->licensePermissions = new stdClass();
        if (!isset($_SESSION['PMSE'])) {
            $this->licenseData = $this->licenseManager->getActiveLicenseData();
            $this->licenseActivationData = $this->getLicenseActivationData();

            $this->licenseData->lic_max_cases = isset($this->licenseData->lic_max_cases) ? $this->licenseData->lic_max_cases : 0;
            $this->licenseData->lic_max_users = isset($this->licenseData->lic_max_users) ? $this->licenseData->lic_max_users : 0;
            $this->licenseData->lic_max_admins = isset($this->licenseData->lic_max_admins) ? $this->licenseData->lic_max_admins : 0;
            $this->licenseData->lic_product_expiration_date = isset($this->licenseData->lic_product_expiration_date) ? $this->licenseData->lic_product_expiration_date : '1900-01-01';
            $this->licenseData->lic_enabled_br = isset($this->licenseData->lic_enabled_br) ? $this->licenseData->lic_enabled_br : false;

            $this->licensePermissions->canExecuteCases = false;
            $this->licensePermissions->canStartCases = false;
            $this->licensePermissions->canAssignUserDashlets = false;
            $this->licensePermissions->canAssignAdminDashlets = false;
            $this->licensePermissions->canExecuteBusinessRules = false;

            if ($this->licenseData->lic_max_cases > $this->licenseActivationData->casesNumber) {
                $this->licensePermissions->canStartCases = true;
            }

            if ($this->licenseData->lic_max_users > $this->licenseActivationData->assignedUserDashlets) {
                $this->licensePermissions->canAssignUserDashlets = true;
            }

            if ($this->licenseData->lic_max_admins > $this->licenseActivationData->assignedAdminDashlets) {
                $this->licensePermissions->canAssignAdminDashlets = true;
            }
            $expirationDate = new DateTime($this->licenseData->lic_product_expiration_date);
            if ($expirationDate > $this->licenseActivationData->actualDate) {
                $this->licensePermissions->canExecuteCases = true;
            }

            $this->licensePermissions->canExecuteBusinessRules = $this->licenseData->lic_enabled_br;
            $_SESSION['PMSE'] = blowfishEncode(blowfishGetKey('ProcessMaker'),
                base64_encode(serialize($this->licensePermissions)));
        } else {
            $this->licensePermissions = unserialize(base64_decode(blowfishDecode(blowfishGetKey('ProcessMaker'),
                        $_SESSION['PMSE'])));
        }
        return $this->licensePermissions;
    }

    /**
     * Get the licensePermissions attribute canExecuteCases, the attribute is a
     * boolean that indicates if cases coulde be executed or not
     * @codeCoverageIgnore
     * @return boolean
     */
    public function casesCanBeExecuted()
    {
        $this->getLicensePermissions();
        return $this->licensePermissions->canExecuteCases;
    }

    /**
     * Get the licensePermissions attribute canStartCases, the attribute is a
     * boolean that indicates if a case coulde be started or not
     * @codeCoverageIgnore
     * @return boolean
     */
    public function casesCanBeStarted()
    {
        //TODO DELETE THIS LINE
        return true;

        $this->getLicensePermissions();
        return $this->licensePermissions->canStartCases;
    }

    /**
     * Get the licensePermissions attribute canAssignUserDashlets, the attribute is a
     * boolean that indicates if a dashlet could be assigned to a non administrative user
     * or not.
     * @codeCoverageIgnore
     * @return boolean
     */
    public function canAssignUserDashlets()
    {
        $this->getLicensePermissions();
        return $this->licensePermissions->canAssignUserDashlets;
    }

    /**
     * Get the licensePermissions attribute canAssignAdminDashlets, the attribute is a
     * boolean that indicates if if a dashlet could be assigned to an administrative user
     * or not.
     * @codeCoverageIgnore
     * @return boolean
     */
    public function canAssignAdminDashlets()
    {
        $this->getLicensePermissions();
        $array = $this->getCurrentUserDashlets();
        foreach ($array as $user) {
            foreach ($user->dashlets as $dashlet) {
                if (in_array($dashlet, $this->adminDashlets)) {
                    return true;
                }
            }
        }
        return $this->licensePermissions->canAssignAdminDashlets;
    }

    /**
     * Get the licensePermissions attribute canExecuteBusinessRules, the attribute is a
     * boolean that indicates if business rules could be executed, created and modified
     * or not.
     * @codeCoverageIgnore
     * @return boolean
     */
    public function canExecuteBusinessRules()
    {
        $this->getLicensePermissions();
        return $this->licensePermissions->canExecuteBusinessRules;
    }

    /**
     * Wrapper method that obtains the list of administrative assigned dashlets.
     * @return array
     */
    public function getAssignedAdministrativeDashlets()
    {
        return $this->getAssignedDashletsByType('Admin');
    }

    /**
     * Wrapper method that obtains the list of non administrative assigned dashlets.
     * @return array
     */
    public function getAssignedUserDashlets()
    {
        return $this->getAssignedDashletsByType('User');
    }

    /**
     * Method that obtains the list of non administrative or administrative dashlets assigned.
     * @param string $type
     * @return array
     */
    public function getAssignedDashletsByType($type = 'User')
    {
        switch ($type) {
            case 'User':
                $dashletList = $this->userDashlets;
                break;
            case 'Admin':
                $dashletList = $this->adminDashlets;
                break;
        }

        $withUserDashlets = array();
        $allDashletAssigned = $this->getAssignedDashlets();
        $resultArray = array();
        foreach ($allDashletAssigned as $key => $dashletsByUser) {
            $tmpArray = array();
            foreach ($dashletList as $dashletName) {
                if (in_array($dashletName, $dashletsByUser->dashlets)) {
                    $tmpArray[] = $dashletName;
                }
            }
            $allDashletAssigned[$key]->dashlets = $tmpArray;
            if (!empty($tmpArray)) {
                $resultArray[] = $allDashletAssigned[$key];
            }
        }
        return $resultArray;
    }

    /**
     * get the total list of prefferences of the HOME category since in the preference contents is stored the list
     * of assigned dashlets for each user.
     * @return array
     */
    public function getAssignedDashlets()
    {
        $orderBy = "";
        $where = "category='HOME'";
        $preferences = $this->preferenceRetriever->get_full_list($orderBy, $where);
        $result = array();
        if (!empty($preferences)) {
            foreach ($preferences as $preference) {
                $result[] = $this->processDashletData($preference->assigned_user_id, $preference->contents);
            }
        }
        return $result;
    }

    /**
     * Get the number of created cases
     * @return integer
     */
    public function getCasesNumber()
    {
        $sql = "SELECT * FROM pmse_bpm_inbox";
        //$params = array('from' => ' FROM bpm_inbox ', 'where' => '');
        $casesNumber = (int)$this->casesBean->create_list_count_query($sql); //$this->casesBean->getCountRows($params);
        return $casesNumber;
    }

    /**
     * Get the number of registered Dashlets for the current user
     * @global \User $current_user
     * @return array
     * @codeCoverageIgnore
     */
    public function getCurrentUserDashlets()
    {
        global $current_user;
        return ($this->getDashletsByUser($current_user));
    }

    /**
     * Get the registered dashlet list of a determined user.
     * @param \User $user
     * @return array
     */
    public function getDashletsByUser($user)
    {
        $orderBy = "";
        $where = "category='HOME' AND assigned_user_id='{$user->id}'";
        $preferences = $this->preferenceRetriever->get_full_list($orderBy, $where);
        $result = array();
        if (!empty($preferences)) {
            foreach ($preferences as $preference) {
                $result[] = $this->processDashletData($preference->assigned_user_id, $preference->contents);
            }
        }
        return $result;
    }

    /**
     * process the dashlet datqa stored in the contents attribute of a user preference object.
     * @param string $id
     * @param string $dashletData
     * @return \stdClass
     */
    public function processDashletData($id, $dashletData)
    {
        $result = new stdClass();
        $result->id = $id;
        $result->dashlets = array();
        $dashletData = unserialize(base64_decode($dashletData));
        foreach ($dashletData['dashlets'] as $dashlet) {
            if ((in_array($dashlet['className'], $this->adminDashlets) || in_array($dashlet['className'],
                        $this->userDashlets)) && !in_array($dashlet['className'], $result->dashlets)
            ) {
                $result->dashlets[] = $dashlet['className'];
            }
        }
        return $result;
    }

    /**
     * Obtain the license data.
     * @codeCoverageIgnore
     * @return array
     */
    public function getLicenseData()
    {
        return $this->licenseData;
    }

    /**
     * Create a License Activation object based on the License Attributes of the installation of the PMSE module
     * @return \stdClass
     */
    public function getLicenseActivationData()
    {
        $licenseActivationData = new stdClass();
        $licenseActivationData->casesNumber = $this->getCasesNumber();
        $licenseActivationData->assignedUserDashlets = count($this->getAssignedUserDashlets());
        $licenseActivationData->assignedAdminDashlets = count($this->getAssignedAdministrativeDashlets());
        $licenseActivationData->actualDate = new DateTime();
        $string = base64_encode(serialize($licenseActivationData));
        $this->accessManager->retrieve_by_string_fields(array('acm_status' => 'ACTIVE'));
        $this->accessManager->acm_activation_data = $string;
        if (!empty($this->accessManager->fetched_row)) {
            $this->accessManager->save();
        }
        return $licenseActivationData;
    }
}
