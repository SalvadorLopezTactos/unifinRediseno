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

namespace Sugarcrm\IdentityProvider\Authentication\Provider;

use Jose\Loader as JWTLoader;
use Jose\LoaderInterface;
use Sugarcrm\IdentityProvider\Authentication\Provider\OIDC;
use Sugarcrm\IdentityProvider\Authentication\Token\OIDC\OIDCCodeToken;
use Sugarcrm\IdentityProvider\Authentication\Token\OIDC\ResultToken;
use Sugarcrm\IdentityProvider\Authentication\UserMapping\OIDCUserMapping;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class OIDCAuthenticationProvider implements AuthenticationProviderInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var OIDCExternalService
     */
    private $oidcService;

    /**
     * @var JWTLoader
     */
    private $jwtLoader;

    /**
     * @var UserProviderInterface
     */
    private $userProvider;

    /**
     * @var OIDCUserMapping
     */
    private $mapper;

    /**
     * @var UserCheckerInterface
     */
    private $userChecker;

    /**
     * List of handlers that can be used to handle tokens.
     * @var array
     */
    protected $handlers = [
        OIDCCodeToken::class => 'oidcCodeAuthenticate',
    ];

    /**
     * OIDCAuthenticationProvider constructor.
     * @param array $config
     * @param UserProviderInterface $userProvider
     * @param OIDCUserMapping $mapper
     * @param UserCheckerInterface $userChecker
     * @param OIDC\ExternalServiceInterface $oidcService
     * @param LoaderInterface $jwtLoader
     */
    public function __construct(
        array $config,
        UserProviderInterface $userProvider,
        OIDCUserMapping $mapper,
        UserCheckerInterface $userChecker,
        OIDC\ExternalServiceInterface $oidcService,
        LoaderInterface $jwtLoader
    ) {
        $this->config = $config;
        $this->oidcService = $oidcService;
        $this->jwtLoader = $jwtLoader;
        $this->userProvider = $userProvider;
        $this->userChecker = $userChecker;
        $this->mapper = $mapper;
    }

    /**
     * @param TokenInterface $token
     * @return ResultToken|TokenInterface
     */
    public function authenticate(TokenInterface $token): TokenInterface
    {
        $handlerMethod = $this->handlers[get_class($token)] ?? null;
        if (!$handlerMethod) {
            throw new AuthenticationServiceException('There is no authentication handler for ' . get_class($token));
        }

        try {
            return $this->{$handlerMethod}($token);
        } catch (AuthenticationException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new AuthenticationException($e->getMessage());
        }
    }

    /**
     * @param TokenInterface $token
     */
    protected function oidcCodeAuthenticate(TokenInterface $token)
    {
        $accessToken = $this->oidcService->getAccessToken(['code' => $token->getCredentials()]);
        $claims = $this->oidcService->getUserInfo($accessToken);
        if (empty($claims) && in_array('openid', $this->config['scope']) != false) {
            $idTokenString = $accessToken->getValues()['id_token'];
            $idToken = $this->jwtLoader->load($idTokenString);
            $claims = $idToken->getClaims();
        }

        if (empty($claims['sub'])) {
            throw new AuthenticationException('Subject not found in token');
        }

        //Special handling for name, given_name and family_name claims
        if (!empty($claims['name']) && empty($claims['given_name']) && empty($claims['family_name'])) {
            $claims['family_name'] = $claims['name'];
        }

        $resultToken = new ResultToken($token->getCredentials(), $token->getAttributes());
        $user = $this->userProvider->loadUserByUsername($claims['sub']);

        $identityMap = $this->mapper->mapIdentity($claims);
        $user->setAttribute('sub', $claims['sub']);
        $user->setAttribute('provision', $this->config['provisionUser']);
        $user->setAttribute('identityField', $identityMap['field']);
        $user->setAttribute('identityValue', $identityMap['value']);

        $mappedResponse = $this->mapper->map($claims);
        $user->setAttribute('attributes', $mappedResponse['attributes'] ?? []);
        if (array_key_exists('custom_attributes', $mappedResponse)) {
            $user->setAttribute('custom_attributes', $mappedResponse['custom_attributes']);
        }

        $this->userChecker->checkPostAuth($user);
        $resultToken->setUser($user);

        $resultToken->setAuthenticated(true);

        return $resultToken;
    }

    /**
     * @param TokenInterface $token
     * @return bool
     */
    public function supports(TokenInterface $token)
    {
        return isset($this->handlers[get_class($token)]);
    }
}
