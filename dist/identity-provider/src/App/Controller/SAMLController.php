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

namespace Sugarcrm\IdentityProvider\App\Controller;

use OneLogin\Saml2\Error;
use OneLogin\Saml2\Settings;
use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Provider\TenantConfigInitializer;
use Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentToken;
use Sugarcrm\IdentityProvider\App\Repository\Exception\TenantInDifferentRegionException;
use Sugarcrm\IdentityProvider\App\Repository\Exception\TenantNotActiveException;
use Sugarcrm\IdentityProvider\App\Repository\Exception\TenantNotExistsException;
use Sugarcrm\IdentityProvider\Authentication\Exception\SAMLResponseException;
use Sugarcrm\IdentityProvider\Authentication\Provider\Providers;
use Sugarcrm\IdentityProvider\Authentication\Token\SAML\ConsumeLogoutToken;
use Sugarcrm\IdentityProvider\Authentication\Token\SAML\AcsToken;
use Sugarcrm\IdentityProvider\Authentication\Token\SAML\IdpLogoutToken;
use Sugarcrm\IdentityProvider\Authentication\Token\SAML\InitiateToken;
use Sugarcrm\IdentityProvider\Authentication\Token\SAML\InitiateLogoutToken;
use Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\IdentityProvider\Srn;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SAMLController
{
    /**
     * @param Application $app Silex application instance.
     * @param Request $request
     * @return string
     */
    public function loginEndPointAction(Application $app, Request $request)
    {
        $redirectResponse = MainController::redirectToTenantCrm($app, $request->get('tid'));
        if (!is_null($redirectResponse)) {
            return $redirectResponse;
        }

        return $app->getTwigService()->render('saml/status.html.twig', [
            'user_name' => $request->get('user_name'),
            'tid' => $request->get('tid'),
            'provider' => strtoupper(Providers::SAML),
            'IdPSessionIndex' => $request->get('IdPSessionIndex'),
        ]);
    }

    /**
     * @param Application $app Silex application instance.
     * @param Request $request
     * @return string
     */
    public function renderFormAction(Application $app, Request $request)
    {
        return $this->renderLoginForm($app);
    }

    /**
     * @param Application $app Silex application instance.
     * @param Request $request
     * @return string
     */
    public function initAction(Application $app, Request $request)
    {
        $messages = [];

        try {
            $initToken = new InitiateToken();
            $relayState = $request->get(
                'RelayState',
                $app->getUrlGeneratorService()->generate('samlLoginEndPoint', [], UrlGenerator::ABSOLUTE_URL)
            );
            $initToken->setAttribute('returnTo', $relayState);
            $token = $app->getAuthManagerService()->authenticate($initToken);

            $url = $token->getAttribute('url');
            if (!empty($url)) {
                $response = RedirectResponse::create($url);
                /** @var Session $sessionService */
                $sessionService = $app['session'];
                $app->getCookieService()->setSamlTenantCookie(
                    $response,
                    $sessionService->get(TenantConfigInitializer::SESSION_KEY)
                );
                return $response;
            }

            $messages[] = 'Cannot initiate SAML request';
        } catch (AuthenticationException $e) {
            $messages[] = $e->getMessage();
        }

        return $this->renderLoginForm($app, [
            'messages' => $messages,
        ]);
    }

    /**
     * @param Application $app Silex application instance.
     * @param Request $request
     * @return string
     */
    public function acsAction(Application $app, Request $request)
    {
        $tenantConfigInitializer = new TenantConfigInitializer($app);
        if ($tenantConfigInitializer->hasTenant($request)) {
            try {
                $tenantConfigInitializer->initConfig($request);
            } catch (TenantNotExistsException $e) {
                $app->getLogger()->info('Invalid tenant id', [
                    'errors' => $e->getMessage(),
                    'tags' => ['IdM.saml'],
                ]);
                return $this->renderLoginForm($app);
            } catch (TenantNotActiveException $e) {
                $app->getLogger()->info('Inactive tenant id', [
                    'errors' => $e->getMessage(),
                    'tags' => ['IdM.saml'],
                ]);
                return $this->renderLoginForm($app);
            } catch (TenantInDifferentRegionException $e) {
                $response = null;
                if ($request->getMethod() === Request::METHOD_GET) {
                    $response = $app->getRegionChecker()->redirectToSamlRegion(
                        $request,
                        $e->getTenantRegion(),
                        $e->getTenantId()
                    );
                } else {
                    $discoveryService = $app->getServiceDiscovery();
                    $loginUrl = $discoveryService->getServiceURL('login', $e->getTenantRegion(), 'web');
                    if (!empty($loginUrl)) {
                        $loginUrl .= $request->getRequestUri();
                        $logoutContent = $app->getTwigService()->render('saml/selfSubmitForm.html.twig', [
                            'url' => $loginUrl,
                            'method' => $request->getMethod(),
                            'params' => $request->request,
                        ]);
                        $response = new Response($logoutContent);
                    } else {
                        return $this->renderLoginForm($app);
                    }
                }
                $app->getCookieService()->clearSamlTenantCookie($response);
                return $response;
            }
        }

        $messages = [];

        /** @var Session $sessionService */
        $sessionService = $app['session'];

        try {
            $acsToken = new AcsToken($request->get('SAMLResponse'));
            $token = $app->getAuthManagerService()->authenticate($acsToken);
            if ($token->isAuthenticated()) {
                $user = $token->getUser();
                foreach ($app->getOIDCClaimsService()->getUserClaims($user) as $claimName => $value) {
                    if (!$user->hasAttribute($claimName)) {
                        $user->setAttribute($claimName, $value);
                    }
                }

                $tenant = $sessionService->get(TenantConfigInitializer::SESSION_KEY);
                $tenantSrn = Srn\Converter::fromString($tenant);
                $userIdentity = $token->getUser()->getLocalUser()->getAttribute('id');
                $userSrn = $app->getSrnManager($tenantSrn->getRegion())->createUserSrn(
                    $tenantSrn->getTenantId(),
                    $userIdentity
                );
                $user = Srn\Converter::toString($userSrn);
                $token->setAttribute('srn', $user);
                $token->setAttribute('tenantSrn', $tenant);

                $app->getRememberMeService()->store($token);
                $app->getLogger()->info(
                    'Authentication success for user {user_name} with SRN {user_srn} and {tenant} from {ip}',
                    [
                        'user_name' => $token->getUsername(),
                        'user_srn' => $user,
                        'tenant' => $tenant,
                        'ip' => $request->getClientIp(),
                        'tags' => ['IdM.saml'],
                        'event' => 'after_login',
                    ]
                );

                $response = null;
                if ($sessionService->get('consent')) {
                    /** @var ConsentToken $consentToken */
                    $consentToken = $sessionService->get('consent');
                    $consentToken->setTenantSRN(Srn\Converter::toString($tenantSrn));

                    $sessionService->set('authenticatedUser', $token);
                    $response = $app->redirect($app->getUrlGeneratorService()->generate('consentConfirmation'));
                }

                if (is_null($response)) {
                    $urlQuery = [
                        'user_name' => $token->getUsername(),
                        'tid' => $sessionService->get(TenantConfigInitializer::SESSION_KEY),
                        'IdPSessionIndex' => $token->getAttribute('IdPSessionIndex'),
                    ];

                    $url = $request->get('RelayState');
                    if (!empty($url)) {
                        $response = RedirectResponse::create($this->extendUrl($url, $urlQuery));
                    } else {
                        $response = RedirectResponse::create($app->getUrlGeneratorService()->generate(
                            'samlLoginEndPoint',
                            $urlQuery
                        ));
                    }
                }

                $app->getCookieService()->clearSamlTenantCookie($response);
                $app->getCookieService()->setTenantCookie(
                    $response,
                    $sessionService->get(TenantConfigInitializer::SESSION_KEY)
                );
                $app->getCookieService()->setRegionCookie($response, $tenantSrn->getRegion());
                return $response;
            }
        } catch (DisabledException $e) {
            $app->getSession()->getFlashBag()->add('error', $e->getMessage());
            return new RedirectResponse($app->getUrlGeneratorService()->generate('loginRender'));
        } catch (AuthenticationException $e) {
            $messages[] = empty($e->getMessage()) ? $e->getMessageKey() : $e->getMessage();
            $app->getLogger()->error(
                'SAML authentication exception occurred in tenant {tenant}, SAML response: {saml_response}',
                [
                    'tenant' => $sessionService->get(TenantConfigInitializer::SESSION_KEY),
                    'saml_response' => $request->get('SAMLResponse'),
                    'exception' => $e,
                    'tags' => ['IdM.saml'],
                    'event' => 'login_failed',
                ]
            );
        }

        return $this->renderLoginForm($app, [
            'messages' => $messages,
        ]);
    }

    /**
     * Logout init action for SAML.
     * @param Application $app
     * @param Request $request
     * @return string|\Symfony\Component\HttpFoundation\Response|static
     */
    public function logoutInitAction(Application $app, Request $request)
    {
        try {
            $logoutToken = new InitiateLogoutToken();
            $logoutToken->setAttributes(
                [
                    'sessionIndex' => $request->get('sessionIndex'),
                    'returnTo' => $app->getRedirectURLService()->getRedirectUrl($request),
                ]
            );
            $nameId = $request->get('nameId');
            if ($nameId) {
                $user = new User();
                $user->setAttribute('email', $nameId);
                $logoutToken->setAttribute('user', $user);
            }
            $resultToken = $app->getAuthManagerService()->authenticate($logoutToken);
            switch ($resultToken->getAttribute('method')) {
                case Request::METHOD_POST:
                    $logoutContent = $app->getTwigService()->render('saml/selfSubmitForm.html.twig', [
                        'url' => $resultToken->getAttribute('url'),
                        'method' => $resultToken->getAttribute('method'),
                        'params' => $resultToken->getAttribute('parameters'),
                    ]);
                    $logoutResponse = new Response($logoutContent);
                    break;
                default:
                    $logoutResponse = RedirectResponse::create($resultToken->getAttribute('url'));
                    break;
            }
            $app->getCookieService()->setLogoutCookie($logoutResponse);
            $app->getLogoutService()->logout($request);
            $app->getCookieService()->clearRegionCookie($logoutResponse);
            return $logoutResponse;
        } catch (AuthenticationException $e) {
            $response = $app->getLogoutService()->logout($request);
            $app->getCookieService()->clearRegionCookie($response);
            return $response;
        }
    }

    /**
     * SAML logout action handler.
     *
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response|static
     * @throws \HttpInvalidParamException
     */
    public function logoutAction(Application $app, Request $request)
    {
        $requestRelayState = $request->get('RelayState');
        if ($request->get('SAMLResponse')) {
            return new RedirectResponse($app->getRedirectURLService()->getRedirectUrl($request));
        }

        $initializer = new TenantConfigInitializer($app);
        $initializer->__invoke($request);
        if ($request->get('SAMLRequest')) {
            $logoutToken = new IdpLogoutToken($request->get('SAMLRequest'));
            if ($requestRelayState) {
                $logoutToken->setAttribute('RelayState', $requestRelayState);
            }
        } else {
            $messages = ['Invalid SAML logout data'];
            return $this->renderLoginForm($app, ['messages' => $messages]);
        }
        $logoutToken->setAuthenticated(true);

        try {
            $resultToken = $app->getAuthManagerService()->authenticate($logoutToken);
        } catch (SAMLResponseException $e) {
            $app->getLogger()->error($e->getMessage(), ['event' => 'login_failed']);
            return $app->getLogoutService()->logout($request);
        }

        if (!$resultToken->isAuthenticated()) {
            $url = $resultToken->hasAttribute('url') ? $resultToken->getAttribute('url') : $requestRelayState;
            $parameters = $resultToken->hasAttribute('parameters') ? $resultToken->getAttribute('parameters') : [];
            if (!empty($url)) {
                $url = $this->extendUrl($url, $parameters);
            }
            return $app->getLogoutService()->logout($request, $url);
        }

        $messages = ['Invalid SAML logout data'];
        return $this->renderLoginForm($app, ['messages' => $messages]);
    }

    /**
     * Default SAML logout endpoint page.
     *
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response|static
     */
    public function logoutEndPointAction(Application $app, Request $request)
    {
        return $app->getTwigService()->render('saml/logout.html.twig');
    }

    /**
     * Return SAML metadata
     *
     * @param Application $app
     * @param Request $request
     * @return Response
     */
    public function metadataAction(Application $app, Request $request)
    {
        try {
            $samlConfig = $app->getConfig()['saml'] ?? [];
            if (empty($samlConfig)) {
                throw new \RuntimeException('Invalid SAML configuration');
            }

            $settings = $this->getSamlSettings($samlConfig);
            $metadata = $settings->getSPMetadata();
            if (!empty($errors = $settings->validateMetadata($metadata))) {
                $msg = $app->getTranslator()->trans('SAML metadata validation failed:') . ' ' .  implode(', ', $errors);
                throw new \RuntimeException($msg);
            }

            $response = new Response($metadata);
            $disposition = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                'metadata.xml'
            );
            $response->headers->set('Content-Disposition', $disposition);

            return $response;
        } catch (\Exception $e) {
            $app->getLogger()->error($e->getMessage());
            return $app->redirect($app->getUrlGeneratorService()->generate('samlRender'));
        }
    }

    /**
     * create OneLogin Saml2 Settings
     * @param array $config
     * @return Settings
     * @throws Error
     */
    protected function getSamlSettings(array $config): Settings
    {
        return new Settings($config);
    }

    /**
     * Parses URL to add params into URL query
     * @param string $url
     * @param array $params
     * @return string
     */
    protected function extendUrl($url, array $params)
    {
        if (empty($params)) {
            return $url;
        }

        $urlParts = parse_url($url);

        $newUrl =
            $urlParts['scheme'] . '://'
            . $urlParts['host']
            . (!empty($urlParts['port']) ? ':' . $urlParts['port'] : '')
            . (!empty($urlParts['path']) ? $urlParts['path'] : '')
            . '?' . (!empty($urlParts['query']) ? $urlParts['query'] . '&' : '')
            . http_build_query($params);

        return $newUrl;
    }

    /**
     * @param Application $app
     * @param array $params
     * @return string
     */
    protected function renderLoginForm(Application $app, array $params = [])
    {
        $session = $app->getSession();
        $flashBag = $session->getFlashBag();

        if (empty($app['config']['saml'])) {
            $flashBag->add('error', 'SAML is not configured for given tenant');
            return $app->redirect($app->getUrlGeneratorService()->generate('loginRender'));
        }
        if (isset($params['messages'])) {
            $flashBag->setAll(['error'=> $params['messages']]);
        }

        return $app->getTwigService()->render('saml/form.html.twig');
    }
}
