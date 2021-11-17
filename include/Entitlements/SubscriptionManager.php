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
use Sugarcrm\Sugarcrm\Util\Arrays\ArrayFunctions\ArrayFunctions;

/**
 * Class SubscriptionManager
 *
 * Sugar subscription manager:
 * It can talk to license server to download subscription data and save to DB.config table
 * It will not talk to license server unless license is modified
 *
 */
class SubscriptionManager
{
    protected $subscriptionRestApiEndPoint = 'rest/subscription/';

    /**
     * internal subscription data
     * @var subscription
     */
    protected $subscription;

    /**
     * subscription or license id
     * @string
     */
    protected $licenseKey;

    /**
     * system subscription keys
     * @var array
     */
    protected $systemSubscriptionKeys = [];

    /**
     * array of license types which exceed the limit
     * @var array
     */
    protected $exceededLimitTypes = [];

    /**
     * flag to check limits
     */
    protected $hasCheckedLimit = false;

    /**
     * instance
     * @var subscriptionmanager
     */
    protected static $instance;

    /**
     * flag to ignore do metadata diff
     * @var bool
     */
    protected $ignoreMedatdataDiff = false;

    /**
     * timeout for the request
     */
    const REQUEST_TIMEOUT = 10;

    /**
     * no data from license server, using default setting
     */
    const USE_DEFAULT_SETTING = 'use_default';

    /**
     * no public ctor
     * subscriptionmanager constructor.
     */
    private function __construct()
    {
    }

    /**
     * singleton implementation
     * @return subscriptionmanager
     */
    public static function instance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * get instance of http client for license server
     * @return \sugarlicensing
     */
    protected function getSugarLicensingClient()
    {
        return new \SugarLicensing();
    }

    /**
     * get subscription, either go to db or license server to get subscription content
     *
     * @param null|string $licenseKey
     * @return null|Subscription
     */
    protected function getSubscription(?string $licenseKey)
    {
        if (empty($licenseKey)) {
            return null;
        }

        if (!empty($this->subscription) && $this->licenseKey === $licenseKey) {
            return $this->subscription;
        }

        $this->subscription = null;
        $content = $this->getSubscriptionContent($licenseKey, true);
        $this->subscription = new Subscription($content);
        $this->licenseKey = $licenseKey;

        return $this->subscription;
    }

    /**
     * get content of subscription, if $useDb is false, it will ignore database and retrieve directly from license server
     *
     * @param string $licenseKey license key
     * @param bool $useDb if false, it will ignore local DB and retrieve data directly from license server
     * @return bool|string
     */
    protected function getSubscriptionContent(string $licenseKey, bool $useDb)
    {
        $admin = \BeanFactory::newBean('Administration');
        $admin->retrieveSettings('license');
        $data = null;
        if (isset($admin->settings['license_subscription'])) {
            $data = $admin->settings['license_subscription'];
            if (is_array($data)) {
                $data = json_encode($admin->settings['license_subscription']);
            }
        }

        if ($useDb && !empty($data)) {
            if ($data === self::USE_DEFAULT_SETTING) {
                return false;
            }
            return $data;
        }

        if ($data === self::USE_DEFAULT_SETTING) {
            $data = false;
        }
            // go to license server to retrieve data
        $endpoint = $this->subscriptionRestApiEndPoint . $licenseKey;
        $subscriptionClient = $this->getSugarLicensingClient();
        $GLOBALS['log']->info('download new sunscription data');
        $response = $subscriptionClient->request($endpoint, [], false, self::REQUEST_TIMEOUT);

        // try to parse and valid the content
        $this->subscription = new Subscription($response);
        $subscriptionClient = null;

        if (empty($this->subscription)) {
            // something is wrong
            return '';
        }

        if ($response !== false) {
            // save to config table
            $admin->saveSetting('license', 'subscription', $response);
        } else {
            $admin->saveSetting('license', 'subscription', self::USE_DEFAULT_SETTING);
        }

        // refresh metadata cache if not in installation stage and subscription has changed
        if ((!(isset($GLOBALS['installing'])) || $GLOBALS['installing'] != true)
            && !$this->ignoreMedatdataDiff
            && !($data === false && $response === false)
            && $this->isSubscriptionChanged($data)) {
            $this->refreshMetadataCache();
        }

        return $response;
    }

    /**
     * check if there is any entitlement changes, it'll ignore any expiration date and quantity changes
     * @param bool|string $oldSubscrptionData
     * @return bool
     */
    protected function isSubscriptionChanged($oldSubscrptionData)
    {
        if (empty($oldSubscrptionData)) {
            return true;
        }
        $oldSubscrptionData = new Subscription($oldSubscrptionData);
        $this->ignoreMedatdataDiff = true;
        $currentKeys = $this->getSystemSubscriptionKeys();
        $this->ignoreMedatdataDiff = false;
        $oldKeys = $oldSubscrptionData->getSubscriptionKeys();
        return $currentKeys != $oldKeys;
    }

    /**
     * refresh metadata cache
     *
     */
    protected function refreshMetadataCache()
    {
        \MetaDataManager::refreshCache();
    }

    /**
     * get total number of Mango users, doesn't include hint
     * @return int
     */
    public function getTotalNumberOfMangoUsers() : int
    {
        $total = 0;
        foreach ($this->getSystemSubscriptions() as $key => $subscripion) {
            if (Subscription::isMangoKey($key)) {
                $total += $subscripion['quantity'];
            }
        }
        return $total;
    }

    /**
     * get license key
     * @return string/null
     */
    protected function getLicenseKey()
    {
        if (!empty($this->licenseKey)) {
            return $this->licenseKey;
        }

        $admin = \Administration::getSettings('license');
        if (isset($admin->settings['license_key'])) {
            return $admin->settings['license_key'];
        }
        return null;
    }

    /**
     * set a new license key, it will trigger to access license server to download new subscription content and save to db
     * @param null|string $licenseKey
     */
    public function downloadSubscriptionContent(?string $licenseKey)
    {
        if (empty($licenseKey)) {
            $this->licenseKey = null;
            return;
        }

        // reset internal data
        $this->subscription = null;
        $this->systemSubscriptionKeys = [];
        $this->licenseKey = $licenseKey;

        // need to go to license server to get subscription data
        $this->getSubscriptionContent($licenseKey, false);
    }

    /**
     * get list of subscriptions
     * @return array
     */
    public function getSystemSubscriptions() : array
    {
        $licenseKey = $this->getLicenseKey();
        if (empty($licenseKey)) {
            return [];
        }
        $subscription = $this->getSubscription($licenseKey);
        return !empty($subscription) ? $subscription->getSubscriptions() : [];
    }

    /**
     * get subscription keys
     *
     * @return array
     */
    public function getSystemSubscriptionKeys() : array
    {
        if (!empty($this->systemSubscriptionKeys)) {
            return $this->systemSubscriptionKeys;
        }

        $licenseKey = $this->getLicenseKey();
        if (empty($licenseKey)) {
            return [];
        }
        $subscription = $this->getSubscription($licenseKey);
        if (empty($subscription)) {
            return [];
        }

        $this->systemSubscriptionKeys = $subscription->getSubscriptionKeys();
        return $this->systemSubscriptionKeys;
    }

    /**
     * get subscription keys in value-sorted array
     * @return array
     */
    public function getSystemSubscriptionKeysInSortedValueArray() : array
    {
        $results = array_keys($this->getSystemSubscriptionKeys());
        $this->sortSubscriptionKeys($results);
        return $results;
    }

    /**
     * get valid subscription seats by type
     * @param string $type
     * @return int
     */
    public function getSystemSubscriptionSeatsByType(string $type) : int
    {
        $systemSubscriptions = $this->getSystemSubscriptions();
        if (isset($systemSubscriptions[$type])) {
            return $systemSubscriptions[$type]['quantity'];
        }
        return 0;
    }

    /**
     * get all subscription seats by types
     * @return array
     */
    public function getSystemSubscriptionSeats() : array
    {
        $systemSubscriptions = $this->getSystemSubscriptions();
        $results = [];
        foreach ($systemSubscriptions as $key => $value) {
            $results[$key] = $value['quantity'];
        }

        return $results;
    }

    /**
     * get user's subscriptions, it compares system subscriptions with user's license type
     * @param null|\User $user
     * @return array
     */
    public function getUserSubscriptions(?\User $user) : array
    {
        if (empty($user)) {
            return [];
        }
        // get system subscriptions
        $systemSubscriptionKeys = $this->getSystemSubscriptionKeys();

        if (empty($systemSubscriptionKeys)) {
            return [];
        }

        $userLicenseTypes = $user->getLicenseTypes();
        // one prod subscription, license type = current or empty will be using current product
        if (count($systemSubscriptionKeys) === 1) {
            if (empty($userLicenseTypes)) {
                // never assigned before
                return array_keys($systemSubscriptionKeys);
            }
            // check if user has current license type
            foreach ($userLicenseTypes as $type) {
                if (Subscription::SUGAR_BASIC_KEY === $type) {
                    return array_keys($systemSubscriptionKeys);
                }
            }
        }

        // pick up a license type
        if (empty($userLicenseTypes)) {
            // never assigned before, pick up one based on the order in getAllSupportedProducts()
            return [$this->getUserDefaultLicenseType()];
        }

        // loop through the license keys
        $userSubscriptions = [];
        foreach ($userLicenseTypes as $type) {
            if (isset($systemSubscriptionKeys[$type])) {
                $userSubscriptions[] = $type;
            }
        }

        // assign admin user to default license type, otherwise, an ENT user will get blank license types
        if (empty($userSubscriptions) && is_admin($user)) {
            return [$this->getUserDefaultLicenseType()];
        }

        $this->sortSubscriptionKeys($userSubscriptions);
        return $userSubscriptions;
    }

    /**
     * get user's invalid subscriptions, it compares system subscriptions with user's license type
     *
     * @param null|\User $user
     * @return array
     */
    public function getUserInvalidSubscriptions(?\User $user) : array
    {
        if (empty($user)) {
            return [];
        }
        // get system subscriptions
        $systemSubscriptionKeys = $this->getSystemSubscriptionKeys();

        $userLicenseTypes = $user->getLicenseTypes();
        if (empty($systemSubscriptionKeys)) {
            return $userLicenseTypes;
        }

        if (empty($userLicenseTypes)) {
            return [];
        }

        $invalidTypes = [];
        foreach ($userLicenseTypes as $type) {
            if (!isset($systemSubscriptionKeys[$type])) {
                $invalidTypes[] = $type;
            }
        }
        return $invalidTypes;
    }

    /**
     * Get user's license types which either exceed limit or  is invalid
     * @param null|\User $user
     * @return array
     */
    public function getUserExceededAndInvalidLicenseTypes(?\User $user) : array
    {
        if (empty($user)) {
            return [];
        }

        $license_seats_needed = 0;
        $exceededLicenseTypes = $this->getSystemLicenseTypesExceededLimit($license_seats_needed);

        $userLicenseTypesOverLimit = [];
        // check current user's license types against $exceededLicenseTypes
        $userLicenseTypes = $this->getUserSubscriptions($user);
        if (!empty($userLicenseTypes)) {
            foreach ($userLicenseTypes as $type) {
                if (isset($exceededLicenseTypes[$type])) {
                    $userLicenseTypesOverLimit[] = $type;
                }
            }
        }

        // merge with invalid types
        $invalidLicenseTypes = $this->getUserInvalidSubscriptions($user);
        foreach ($invalidLicenseTypes as $type) {
            $userLicenseTypesOverLimit[] = $type;
        }
        return $userLicenseTypesOverLimit;
    }

    /**
     * all supported types, keep the order
     * @return array
     */
    public function getAllSupportedProducts()
    {
        // The order of this array determines the default license type if user's license_type is empty
        return [
            Subscription::SUGAR_BASIC_KEY,
            Subscription::SUGAR_SERVE_KEY,
            Subscription::SUGAR_SELL_KEY,
            Subscription::SUGAR_HINT_KEY,
        ];
    }

    /**
     * get default license type
     *
     * @return string
     */
    public function getUserDefaultLicenseType() : string
    {
        // Warning to Dev: if modifying logic here, you must notify MTS team!
        // MTS team needs to do corresponding changes on their user reports
        $systemSubscriptionKeys = $this->getSystemSubscriptionKeys();
        $allProducts = $this->getAllSupportedProducts();
        foreach ($allProducts as $type) {
            if (isset($systemSubscriptionKeys[$type])) {
                // The first valid key in AllSupportedProducts array will be the default license type
                return $type;
            }
        }
        return '';
    }

    /**
     * sort keys
     * @param array $keys
     */
    protected function sortSubscriptionKeys(array &$keys)
    {
        sort($keys);
    }

    /**
     *
     * get all subsets of system subscriptions
     *
     * @return array
     */
    public function getAllSubsetsOfSystemSubscriptions() : array
    {
        $systemSubscriptions = $this->getSystemSubscriptionKeysInSortedValueArray();
        $allSubsets = ArrayFunctions::powerSet($systemSubscriptions);

        $subsets = [];
        foreach ($allSubsets as $subset) {
            if (!empty($subset)) {
                $this->sortSubscriptionKeys($subset);
                $subsets[] = $subset;
            }
        }
        return $subsets;
    }

    /**
     * convert keys to a string
     * @param array|null $keys
     * @return mixed|string
     */
    public function getUserLicenseTypesInString(?\User $user)
    {
        if (empty($user)) {
            return '';
        }

        $userSubscriptions = $this->getUserSubscriptions($user);

        if (empty($userSubscriptions)) {
            return '';
        }

        return implode('_', $userSubscriptions);
    }


    /**
     * get number of users exceed limit by license type
     * @param int $license_seats_needed total number of license needed
     * @return array
     */
    public function getSystemLicenseTypesExceededLimit(int &$license_seats_needed) : array
    {
        if ($this->hasCheckedLimit) {
            return $this->exceededLimitTypes;
        }

        $this->hasCheckedLimit = true;

        $sysSubscriptions = $this->getSystemSubscriptions();
        $exceededLimitTypes = [];

        // no subscription
        if (empty($sysSubscriptions)) {
            $exceededLimitTypes[Subscription::SUGAR_BASIC_KEY] = 1;
            $license_seats_needed = 1;
            $this->exceededLimitTypes = $exceededLimitTypes;
            return $exceededLimitTypes;
        }

        $userCountByType = $this->getSystemUserCountByLicenseTypes();

        foreach ($userCountByType as $licenseType => $count) {
            if ($count > 0) {
                if (isset($sysSubscriptions[$licenseType])) {
                    if ($userCountByType[$licenseType] > $sysSubscriptions[$licenseType]['quantity']) {
                        $exceededLimitTypes[$licenseType] = $count - $sysSubscriptions[$licenseType]['quantity'];
                        $license_seats_needed += $exceededLimitTypes[$licenseType];
                    }
                } else {
                    // license expired or switched
                    $exceededLimitTypes[$licenseType] = $count;
                    $license_seats_needed += $count;
                }
            }
        }

        $this->exceededLimitTypes = $exceededLimitTypes;
        return $exceededLimitTypes;
    }

    /**
     * Check system types for free seats for user and return array of exceeded types
     * It should be used for user management only.
     * @param \User $user
     * @return array
     */
    public function getUserExceededLicenseTypes(\User $user): array
    {
        // ignore support users
        if (\User::isSupportUser($user)) {
            return [];
        }
        $usedSeats = $this->getSystemUserCountByLicenseTypes();
        $allowedSeats = $this->getSystemSubscriptions();
        $userTypes = $this->getUserSubscriptions($user);

        if (empty($allowedSeats)) {
            return $userTypes;
        }

        return array_filter($userTypes, function ($type) use ($allowedSeats, $usedSeats) {
            if (empty($allowedSeats[$type]) || $allowedSeats[$type]['quantity'] - $usedSeats[$type] <= 0) {
                return true;
            }
            return false;
        });
    }

    /**
     * Get system active users by license types
     * @return array
     */
    public function getSystemUserCountByLicenseTypes() : array
    {
        global $db;
        $query = "SELECT license_type from users WHERE " . \User::getLicensedUsersWhere();
        $result = $db->query($query, true, "Error filling in user array: ");
        $supportedTypes = $this->getAllSupportedProducts();
        $userCountByType = [];
        foreach ($supportedTypes as $type) {
            $userCountByType[$type] = 0;
        }
        $userCountByType[Subscription::UNKNOWN_TYPE] = 0;

        $foundUnknownType = false;
        $unknownTypes = '';
        while (($row=$db->fetchByAssoc($result, false)) != null) {
            if (empty($row['license_type'])) {
                $type = $this->getUserDefaultLicenseType();
                if (empty($type) || !in_array($type, $supportedTypes)) {
                    if (!empty($type)) {
                        $unknownTypes .= $type . ' ';
                    }
                    $foundUnknownType = true;
                } else {
                    $userCountByType[$type] += 1;
                }
            } else {
                $types = json_decode($row['license_type'], true);
                if (!is_array($types)) {
                    $GLOBALS['log']->fatal('invalid license_type format: ' . $row['license_type']);
                } else {
                    foreach ($types as $type) {
                        if (empty($type)) {
                            $type = $this->getUserDefaultLicenseType();
                        }
                        if (!in_array($type, $supportedTypes)) {
                            $foundUnknownType = true;
                            $unknownTypes .= $type . ' ';
                            $userCountByType[Subscription::UNKNOWN_TYPE] += 1;
                        } else {
                            $userCountByType[$type] += 1;
                        }
                    }
                }
            }
        }

        if ($foundUnknownType) {
            // don't know what to do, skip for now
            $GLOBALS['log']->fatal('Found unknown type: ' . $unknownTypes);
        }

        return $userCountByType;
    }
}
//END REQUIRED CODE DO NOT MODIFY
