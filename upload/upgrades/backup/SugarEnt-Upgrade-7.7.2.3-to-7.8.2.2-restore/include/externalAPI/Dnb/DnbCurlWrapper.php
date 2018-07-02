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

class DnbCurlWrapper
{
    /**
     * @var resource curl handle
     */
    private $curlHandle;

    public function __construct() {
        $this->curlHandle = curl_init();
    }

    /**
     * Set curl options
     * @param array $curlOptions
     */
    public function setCurlOptions($curlOptions) {
        curl_setopt_array($this->curlHandle, $curlOptions);
    }

    /**
     * Sets the proxy options
     * @param array $curlOptions
     * @return array $curlOptions
     */
    public function setProxyOptions($curlOptions) {
        //detects if the sugar proxy setting is on
        //if yes we need to append it to the curlOptions
        /* CURL SET PROXY CONFIG USING SUGAR SYSTEM SETTINGS */
        $proxy_config = Administration::getSettings('proxy');
        if (!empty($proxy_config) &&
            !empty($proxy_config->settings['proxy_on']) &&
            $proxy_config->settings['proxy_on'] === 1) {
            $curlOptions[CURLOPT_PROXY] = $proxy_config->settings['proxy_host'];
            $curlOptions[CURLOPT_PROXYPORT] = $proxy_config->settings['proxy_port'];
            if (!empty($proxy_settings['proxy_auth'])) {
                $curlOptions[CURLOPT_PROXYUSERPWD] = $proxy_settings['proxy_username'] . ':' . $proxy_settings['proxy_password'];
            }
        }
        return $curlOptions;
    }

    /**
     * @param array $curlOptions
     * @return mixed
     */
    public function execute($curlOptions) {
        //set the proxy
        $curlOptions = $this->setProxyOptions($curlOptions);
        $this->setCurlOptions($curlOptions);
        $curlResponse = curl_exec($this->curlHandle);
        $httpStatus = $this->getInfo(CURLINFO_HTTP_CODE);
        return array(
            'httpStatus' => $httpStatus,
            'curlResponse' => $curlResponse
        );
    }

    /**
     * Get cURL information on $option
     * @param string $option
     * @return mixed
     */
    public function getInfo($option) {
        return curl_getinfo($this->curlHandle, $option);
    }

    /**
     * @return int
     */
    public function getErrorNo() {
        return curl_errno($this->curlHandle);
    }

    /**
     * @return string
     */
    public function getError() {
        return curl_error($this->curlHandle);
    }
}