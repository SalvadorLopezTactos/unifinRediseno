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

require_once "clients/base/api/ModuleApi.php";
require_once "modules/OutboundEmailConfiguration/OutboundEmailConfigurationPeer.php"; // also imports
                                                                                      // OutboundEmailConfiguration and
                                                                                      // OutboundSmtpEmailConfiguration

class OutboundEmailConfigurationApi extends ModuleApi
{
    public function registerApiRest() {
        $api = array(
            "outboundEmailConfigurationList" => array(
                "reqType"   => "GET",
                "path"      => array("OutboundEmailConfiguration", "list"),
                "pathVars"  => array("", ""),
                "method"    => "listConfigurations",
                "shortHelp" => "A list of outbound email configurations",
                "longHelp"  => "include/api/html/modules/OutboundEmailConfiguration/OutboundEmailConfiguration.html#listConfigurations"
            ),
        );

        return $api;
    }

    /**
     * @param $api
     * @param $args
     * @return array
     */
    public function listConfigurations($api, $args) {
        $list = array();

        $configs = OutboundEmailConfigurationPeer::listValidMailConfigurations($GLOBALS["current_user"]);

        foreach ($configs as $config) {
            $inboxId    = $config->getInboxId();
            $configType = $config->getConfigType();

            $list[] = array(
                "id"      => (is_null($inboxId)) ? $config->getConfigId() : $inboxId,
                "display" => $config->getDisplayName(),
                "type"    => $configType,
                "default" => ($configType == "system"),
            );
        }

        return $list;
    }
}
