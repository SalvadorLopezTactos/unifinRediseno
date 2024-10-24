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

namespace Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Token\OIDC;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

/**
 * Class RefreshToken
 * Provides token that can perform refresh OIDC operation
 */
class RefreshToken extends AbstractToken
{
    /**
     * @var string
     */
    protected $credentials;

    /**
     * @param string $credentials OAuth2 token
     * @param array $roles
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $credentials, array $roles = [])
    {
        parent::__construct($roles);

        $this->credentials = $credentials;
    }

    /**
     * @inheritdoc
     */
    public function getCredentials(): string
    {
        return $this->credentials;
    }
}
