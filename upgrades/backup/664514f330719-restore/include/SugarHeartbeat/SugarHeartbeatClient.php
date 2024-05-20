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

/**
 * Class SugarHeartbeatClient
 *
 * SoapClient for Sugar's heartbeat server. Currently we are using soap
 * because SoapClient is not a required extension for SugarCRM.
 */
class SugarHeartbeatClient extends \SoapClient
{
    /**
     * We don't use WSDL mode to avoid more traffic to the heartbeat server.
     *
     * @var string Endpoint url
     */
    const DEFAULT_ENDPOINT = 'https://updates.sugarcrm.com/heartbeat/soap.php';
    /**
     * @var array SoapClient options
     */
    protected $defaultOptions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->defaultOptions = array(
            'location' => $this->getEndpoint(),
            'uri' => $this->getEndpoint(),
            'soap_version' => SOAP_1_1,
            'exceptions' => 0,
        );
        $options = $this->getOptions();
        parent::__construct(null, $options);
    }

    /**
     * Returns endpoint
     * reads $sugar_config['heartbeat']['endpoint']
     * default is SugarHeartbeatClient::DEFAULT_ENDPOINT
     *
     * @return string
     */
    protected function getEndpoint()
    {
        return SugarConfig::getInstance()->get('heartbeat.endpoint', self::DEFAULT_ENDPOINT);
    }

    /**
     * Returns Soap Options
     * reads $sugar_config['heartbeat']['options']
     * default is SugarHeartbeatClient::$defaultOptions
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge($this->defaultOptions, SugarConfig::getInstance()->get('heartbeat.options', array()));
    }

    /**
     * Proxy to sugarPing WSDL method
     *
     * @return mixed
     */
    public function sugarPing()
    {
        return $this->__soapCall('sugarPing', array());
    }

    /**
     * Proxy to sugarHome WSDL method
     * Encodes $info
     *
     * @param string $key License key
     * @param array $info
     * @return mixed
     */
    public function sugarHome(string $key, array $info)
    {
        $data = base64_encode(serialize($info));
        return $this->__soapCall('sugarHome', array('key' => $key, 'data' => $data));
    }

    public function getError()
    {
        if (is_soap_fault($this)) {
            return $this->__getLastResponse();
        } else {
            return false;
        }
    }
}
