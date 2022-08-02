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

namespace Sugarcrm\Sugarcrm\Entitlements;

// This section of code is a portion of the code referred
// to as Critical Control Software under the End User
// License Agreement.  Neither the Company nor the Users
// may modify any portion of the Critical Control Software.
use Sugarcrm\Sugarcrm\inc\Entitlements\Exception\SubscriptionException;

/**
 * Class Subscription
 *
 * sugar subscription object, it parses raw subscription data and provides APIs to access those data
 */
class Subscription
{
    /**
     * license keys or types
     */
    const SUGAR_SELL_KEY = 'SUGAR_SELL';
    const SUGAR_SERVE_KEY = 'SUGAR_SERVE';
    const SUGAR_BASIC_KEY = 'CURRENT';
    const SUGAR_HINT_KEY = 'HINT';

    /**
     * unknown type
     */
    const UNKNOWN_TYPE = 'UNKNOWN';

    /**
     * current supported keys
     */
    const SUPPORTED_KEYS = [
        self::SUGAR_BASIC_KEY,
        self::SUGAR_SELL_KEY,
        self::SUGAR_SERVE_KEY,
        self::SUGAR_HINT_KEY,
    ];

    /**
     * mapping product codes to internal keys
     */
    const PRODUCT_CODE_MAPPING = [
        'ENT' => self::SUGAR_BASIC_KEY,
        'PRO' => self::SUGAR_BASIC_KEY,
        'ULT' => self::SUGAR_BASIC_KEY,
        'SELL' => self::SUGAR_SELL_KEY,
        'SERVE' => self::SUGAR_SERVE_KEY,
        'HINT' => self::SUGAR_HINT_KEY,
    ];

    /**
     * internal data
     * @var array
     */
    protected $data = [];

    /**
     * parsed subscription data
     * @var array
     */
    protected $subscriptions = [];

    /**
     * @var array of Addons
     */
    protected $addons = [];

    /**
     * use default value from license config
     * @var bool
     */
    protected $useDefault = false;

    /**
     * private Subscription constructor.
     * @param mixed $jsonData
     */
    public function __construct($jsonData)
    {
        if ($jsonData === false || $jsonData === '') {
            $this->useDefault = true;
            $this->subscriptions[self::SUGAR_BASIC_KEY] = $this->getDefaultSubscription();
        } else {
            $this->parse($jsonData);
        }
    }

    /**
     * parse the raw subscription data
     * @param string $jsonData
     */
    protected function parse(string $jsonData)
    {
        $decodedData = json_decode($jsonData, true);
        if ($decodedData === null) {
            throw new SubscriptionException('Invalid subscription json data');
        }
        
        if (empty($decodedData['subscription'])) {
            return;
        }

        foreach ($decodedData['subscription'] as $key => $value) {
            if ($key === 'addons' && count($decodedData['subscription'][$key]) > 0) {
                foreach ($decodedData['subscription'][$key] as $addonId => $addonData) {
                    $this->addons[$addonId] = new Addon($addonId, $addonData);
                }
            } else {
                $this->data[$key] = $value;
            }
        }
        $this->data['addons'] = $this->addons;
    }

    /**
     * access method
     * @param string $name
     * @return mixed|null
     */
    public function __get(string $name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        return null;
    }

    /**
     * to get subscriptions
     * only gets the subscriptions with quantity > 0 and not expired.
     *
     * return in array format
     * [
     *      'quantity' => ...,
     *      'expiration_date' => ...,
     * ];
     * @return array
     */
    public function getSubscriptions() : array
    {
        if ($this->subscriptions || $this->useDefault) {
            return $this->subscriptions;
        }

        $subscriptions = [];
        if (empty($this->data)) {
            return [];
        }

        if (!empty($this->error)) {
            $GLOBALS['log']->fatal("there is an error in license server response: " . $this->error);
            return [];
        }

        // will skip top level of the subscription
        // initiate quantity count
        foreach (self::SUPPORTED_KEYS as $type) {
            $subscriptions[$type]['quantity'] = 0;
        }

        // check addons, only interested in 'SELL', 'SERVE' and Legacy product codes such as 'ENT', 'PRO' and 'ULT'.
        // ignore any other addons for now
        foreach ($this->addons as $addonId => $addon) {
            $quantity = (int)$addon->quantity;
            $expirationDate = $addon->expiration_date;
            if (isset($quantity) && $quantity > 0 && isset($expirationDate) && $expirationDate - time() > 0) {
                // using product code to find out subscription types
                $productCode = $addon->product_code_c;
                if (!empty($productCode) && !empty(self::PRODUCT_CODE_MAPPING[strtoupper($productCode)])) {
                    $key = self::PRODUCT_CODE_MAPPING[strtoupper($productCode)];
                    // calculate the expiration date, using the min date as expiration date
                    if (!empty($subscriptions[$key]['expiration_date'])
                        && $expirationDate > $subscriptions[$key]['expiration_date']
                    ) {
                        $expirationDate = $subscriptions[$key]['expiration_date'];
                    }
                    $subscriptions[$key] = [
                        'quantity' => $subscriptions[$key]['quantity'] + $quantity,
                        'expiration_date' => $expirationDate,
                    ];
                }
            }
        }

        // remove 0 quantity keys
        foreach ($subscriptions as $key => $value) {
            if ($subscriptions[$key]['quantity'] === 0) {
                unset($subscriptions[$key]);
            }
        }
        $this->subscriptions = $subscriptions;

        return $subscriptions;
    }

    /**
     * get keys for subscriptions
     *
     * need to take care of ENT, PRO, etc
     */
    public function getSubscriptionKeys() : array
    {
        $subscriptions = $this->getSubscriptions();
        if (empty($subscriptions)) {
            return [];
        }

        $keys = [];
        foreach ($subscriptions as $key => $value) {
            if (!in_array($key, $this->getAddonProducts())) {
                $keys[self::SUGAR_BASIC_KEY] = true;
            } else {
                $keys[$key] = true;
            }
        }
        return $keys;
    }

    /**
     * get current addon products,
     * @return array
     */
    public function getAddonProducts() : array
    {
        return [
            Subscription::SUGAR_SELL_KEY,
            Subscription::SUGAR_SERVE_KEY,
            Subscription::SUGAR_HINT_KEY,
        ];
    }

    /**
     * check if a key is Mango key
     * @return array
     */
    public static function isMangoKey(?string $key) : bool
    {
        $mangoKeys = [
            Subscription::SUGAR_BASIC_KEY,
            Subscription::SUGAR_SELL_KEY,
            Subscription::SUGAR_SERVE_KEY,
        ];
        return in_array($key, $mangoKeys);
    }

    /**
     * get default subscription in case of offline, client is not able to download from license server
     * @return array
     */
    protected function getDefaultSubscription() : array
    {

        $expiredDate = $this->getLicenseSettingByKey('license_expire_date', '+12 months');
        if (strtotime($expiredDate) - time() < 0) {
            if (!empty($GLOBALS['log'])) {
                $GLOBALS['log']->fatal("license was expired at " . $expiredDate);
            }
            return [];
        }

        return [
            'quantity' => $this->getLicenseSettingByKey('license_users', 1),
            'expiration_date' => strtotime($expiredDate),
        ];
    }

    /**
     * get license setting values, it will take the default value if it is during installation
     * @param string $key
     * @param $defaultValue
     */
    protected function getLicenseSettingByKey(string $key, $defaultValue)
    {
        if (isset($GLOBALS['installing']) && $GLOBALS['installing'] === true) {
            return $defaultValue;
        }

        if (!isset($GLOBALS['license'])) {
            loadLicense(true);
        }

        if (!empty($GLOBALS['license']->settings[$key])) {
            return $GLOBALS['license']->settings[$key];
        }
        return $defaultValue;
    }
}
//END REQUIRED CODE DO NOT MODIFY
