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

namespace Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest;

use Sugarcrm\IdentityProvider\App\Authentication\OAuth2Service;
use Symfony\Component\Translation\Translator;

class ConsentRestService implements ConsentTokenServiceInterface
{
    /**
     * list of allowed scope mapping
     */
    protected const SCOPE_MAPPING = [
        'group' => [
            'email_address_phone' => [
                'start_text' => 'View',
                'scopes' => [
                    'email' => 'email',
                    'address' => 'address',
                    'phone' => 'phone number',
                ],
            ],
        ],
        'single' => [
            'https://apis.sugarcrm.com/auth/crm' => 'View and update any Sugar data (Accounts, Contacts, Leads, etc.)'
                . ' that you are permitted to access',
            'profile' => 'View your Sugar profile which includes first and last name',
            'https://apis.sugarcrm.com/auth/iam' => 'View and manage your Identity and Access Management (IAM) objects',
            'openid' => 'Authenticate using OpenID Connect',
            'offline' => 'Access all the above information at any time',
        ],
    ];

    /**
     * @var OAuth2Service
     */
    protected $oAuth2Service;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * ConsentRequestParser constructor.
     * @param OAuth2Service $oAuth2Service
     * @param Translator $translator
     */
    public function __construct(OAuth2Service $oAuth2Service, Translator $translator)
    {
        $this->oAuth2Service = $oAuth2Service;
        $this->translator = $translator;
    }

    /**
     * Return consent Pay Load.
     * @param string $identifier
     * @return ConsentToken
     */
    public function getToken($identifier)
    {
        return (new ConsentToken())->fillByConsentRequestData(
            $this->oAuth2Service->getConsentRequestData($identifier)
        );
    }

    /**
     * map requested scopes
     * @param array $scopes
     * @return array
     */
    public function mapScopes(array $scopes): array
    {
        $mappedScopes = [];
        $scopes = array_flip($scopes);
        foreach (self::SCOPE_MAPPING['group'] as $groupName => $data) {
            foreach ($data['scopes'] as $scope => $description) {
                if (array_key_exists($scope, $scopes)) {
                    $description = $this->translator->trans($description);
                    if (empty($mappedScopes[$groupName])) {
                        $startText = $this->translator->trans($data['start_text']);
                        $mappedScopes[$groupName] = sprintf('%s %s', $startText, $description);
                    } else {
                        $mappedScopes[$groupName] .= ', ' . $description;
                    }
                    unset($scopes[$scope]);
                }
            }
        }
        $mappedScopes = array_values($mappedScopes);

        $singleMapping = array_keys(self::SCOPE_MAPPING['single']);

        // Sorting scopes in specific order for output
        uksort(
            $scopes,
            function ($a, $b) use ($singleMapping) {
                return array_search($a, $singleMapping) - array_search($b, $singleMapping);
            }
        );

        foreach ($scopes as $scope => $value) {
            $mappedScopes[] = array_key_exists($scope, self::SCOPE_MAPPING['single'])
                ? $this->translator->trans(self::SCOPE_MAPPING['single'][$scope]) : $scope;
        }
        return $mappedScopes;
    }
}
