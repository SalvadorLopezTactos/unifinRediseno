<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

require_once 'include/MVC/View/SidecarView.php';
require_once "include/api/RestService.php";
require_once 'clients/base/api/OAuth2Api.php';
require_once 'include/SugarOAuth2/SugarOAuth2Server.php';

use Sugarcrm\Sugarcrm\Session\SessionStorage;

class UsersViewAuthenticate extends SidecarView
{
    /**
     * Do we need only data for parent window or the whole Sidecar?
     * @var bool
     */
    protected $dataOnly = false;

    public function preDisplay()
    {
        $sess = SessionStorage::getInstance();
        if ($sess->getId()) {
            // kill old session
            $sess->destroy();
        };

        SugarAutoLoader::load('custom/include/RestService.php');
        $restServiceClass = SugarAutoLoader::customClass('RestService');
        $service = new $restServiceClass();
        SugarOAuth2Server::getOAuth2Server(); // to load necessary classes

        SugarAutoLoader::requireWithCustom('clients/base/api/OAuth2Api.php');
        $oapiClassName = SugarAutoLoader::customClass('OAuth2Api');
        $oapi = new $oapiClassName();
        $args = $_REQUEST;
        $args['client_id'] = 'sugar';
        $args['client_secret'] = '';
        if (!empty($_REQUEST['SAMLResponse'])) {
            $args['grant_type'] = SugarOAuth2Storage::SAML_GRANT_TYPE;
            $args['assertion'] = $_REQUEST['SAMLResponse'];
        }
        if (!empty($_REQUEST['MSID'])) {
            $args['grant_type'] = SugarOAuth2Storage::SEAMLESS_GRANT_TYPE;
        } else {
            if(empty($args['grant_type'])) {
                $args['grant_type'] = OAuth2::GRANT_TYPE_USER_CREDENTIALS;
                if(!empty($args['user_name']) && isset($args['user_password'])) {
                    // old-style login, let's translate it
                    $args['username'] = $args['user_name'];
                    $args['password'] = $args['user_password'];
                }
            }
        }
        try {
            $this->authorization = $oapi->token($service, $args);
        } catch (Exception $e) {
            $GLOBALS['log']->error("Login exception: " . $e->getMessage());
            sugar_die($e->getMessage());
        }
        if (!empty($_REQUEST['dataOnly'])) {
            $this->dataOnly = true;
        }
        if (!empty($_REQUEST['platform'])) {
            $this->platform = $_REQUEST['platform'];
        }
        parent::preDisplay();
    }

    public function display()
    {
        if($this->dataOnly) {
            $this->ss->assign("siteUrl", $GLOBALS['sugar_config']['site_url']);
            $template = $this->getAuthenticateTemplate();
            $this->ss->display($template);
        } else {
            parent::display();
        }
    }

    /**
     * Returns Smarty template for authenticating the application with the data
     * obtained from external identity provider
     *
     * @return string
     */
    protected function getAuthenticateTemplate()
    {
        if (isset($this->platform)) {
            $platforms = MetaDataManager::getPlatformList();
            if (in_array($this->platform, $platforms, true)) {
                $platformTemplate = SugarAutoLoader::existingCustomOne(
                    'modules/Users/tpls/Authenticate' . ucfirst($this->platform) . '.tpl'
                );
                if ($platformTemplate) {
                    return $platformTemplate;
                }
            }
        }

        return SugarAutoLoader::existingCustomOne('modules/Users/tpls/AuthenticateParent.tpl');
    }
}
