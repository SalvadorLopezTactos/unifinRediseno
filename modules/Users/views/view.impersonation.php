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

use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\AuthProviderBasicManagerBuilder;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Config;
use Sugarcrm\Sugarcrm\IdentityProvider\Authentication\Token\OIDC\IntrospectToken;
use Sugarcrm\Sugarcrm\inc\Entitlements\Exception\SubscriptionException;

class UsersViewImpersonation extends SidecarView
{
    use IdmModeAuthTrait;

    /**
     * @var User
     */
    protected $issuer = null;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        parent::__construct();
        $this->options['show_header'] = false;
        $this->options['show_javascript'] = false;
    }

    public function preDisplay($params = array())
    {
        if (!$this->getIdpConfig()->isIDMModeEnabled()) {
            $this->redirect();
        }

        $platform = $this->request->getValidInputGet('platform');
        if (!empty($platform)) {
            $this->platform = $platform;
        }

        try {
            $this->ensureIssuer();

            $this->setupUser();
        } catch (SubscriptionException $e) {
            SugarApplication::redirect('./#licenseSeats');
        } catch (\Exception $e) {
            $this->redirect();
        }

        parent::preDisplay($params);
    }

    protected function setupUser(): void
    {
        $accessToken = $this->request->getValidInputPost('access_token');
        $refreshToken = $this->request->getValidInputPost('refresh_token');

        if (empty($accessToken)) {
            $this->redirect();
        }
        /** @var SugarOAuth2ServerOIDC $oAuthServer */
        $oAuthServer = $this->getOAuth2Server();

        $GLOBALS['logic_hook']->call_custom_logic('Users', 'before_login');

        $tokenInfo = $oAuthServer->verifyAccessToken($accessToken);
        if (!$tokenInfo) {
            $this->redirect();
        }

        /** @var User $user */
        $user = BeanFactory::getBean('Users', $tokenInfo['user_id']);
        if (!$user) {
            $this->redirect();
        }
        $user->call_custom_logic('after_login');

        $this->ensureLoginStatus($user);

        $expires_in = intval($tokenInfo['expires'] - time());
        $this->setupDownloadToken($accessToken, $expires_in);

        $this->setupBWCImpersonationSession();

        $this->authorization = [
            'access_token' => $accessToken,
            'expires_in' => $expires_in,
            'refresh_token' => $refreshToken,
            'impersonation_for' => $this->issuer->id,
        ];
    }

    protected function ensureIssuer(): void
    {
        $token = $this->grabIssuerToken();
        if (empty($token)) {
            $this->redirect();
        }

        $idmModeConfig = $this->getIdpConfig()->getIDMModeConfig();
        $authManager = (new AuthProviderBasicManagerBuilder($this->getIdpConfig()))->buildAuthProviders();

        $introspectToken = new IntrospectToken($token, $idmModeConfig['tid'], $idmModeConfig['crmOAuthScope']);
        $introspectToken->setAttribute('platform', $this->platform);

        $issuerToken = $authManager->authenticate($introspectToken);

        if (!$issuerToken) {
            $this->redirect();
        }

        if (!$issuerToken->isAuthenticated()) {
            $this->redirect();
        }

        if (!$issuerToken->getUser()) {
            $this->redirect();
        }

        $issuer = $issuerToken->getUser()->getSugarUser();
        if (!$issuer) {
            $this->redirect();
        }

        if (!$issuer->isAdmin()) {
            $this->redirect();
        }
        $this->issuer = $issuer;
    }

    protected function grabIssuerToken(): ?string
    {
        if (array_key_exists('HTTP_OAUTH_TOKEN', $_SERVER)) {
            return $_SERVER['HTTP_OAUTH_TOKEN'];
        }
        return $this->request->getValidInputPost('issuer');
    }

    protected function getOAuth2Server(): SugarOAuth2Server
    {
        return \SugarOAuth2Server::getOAuth2Server($this->platform);
    }

    /**
     * Redirects to the main page.
     */
    protected function redirect(): void
    {
        $GLOBALS['logic_hook']->call_custom_logic('Users', 'login_failed');
        SugarApplication::redirect('./#stsAuthError');
    }

    protected function getIdpConfig(): Config
    {
        return new Config(\SugarConfig::getInstance());
    }
}
