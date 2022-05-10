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

use Sugarcrm\Apis\Iam\App\V1alpha\ListAppsRequest;
use Sugarcrm\Apis\Iam\App\V1alpha\ListAppsResponse;
use Sugarcrm\Apis\Iam\App\V1alpha\App;
use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Authentication\AuthProviderManagerBuilder;
use Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentToken;
use Sugarcrm\IdentityProvider\App\Repository\Exception\TenantInDifferentRegionException;
use Sugarcrm\IdentityProvider\App\Repository\Exception\TenantNotActiveException;
use Sugarcrm\IdentityProvider\App\Repository\Exception\TenantNotExistsException;
use Sugarcrm\IdentityProvider\App\Constraints as CustomAssert;
use Sugarcrm\IdentityProvider\App\Provider\TenantConfigInitializer;
use Sugarcrm\IdentityProvider\Srn;
use Sugarcrm\IdentityProvider\Authentication\Token\SAML\ResultToken as SAMLResultToken;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * Class MainController.
 */
class MainController
{
    /**
     * @param Application $app Silex application instance.
     * @param Request $request
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function loginEndPointAction(Application $app, Request $request)
    {
        $redirectResponse = self::redirectToTenantCrm($app, $request->get('tid'));
        if (!is_null($redirectResponse)) {
            return $redirectResponse;
        }

        $providersTitle = [
            AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL => 'Local',
            AuthProviderManagerBuilder::PROVIDER_KEY_LDAP => 'LDAP',
        ];
        $params = [
            'tid' => $request->get('tid'),
            'user_name' => $request->get('user_name'),
            'provider' => $providersTitle[$request->get('provider')],
        ];
        $app->getLogger()->debug('Successfully authentication status page render', [
            'params' => $params,
            'tags' => ['IdM.main'],
        ]);
        return $app->getTwigService()->render('main/status.html.twig', $params);
    }

    /**
     * Redirect user to crm if it provisioned
     *
     * @param Application $app
     * @param string $tid
     * @return RedirectResponse|null
     */
    public static function redirectToTenantCrm(Application $app, string $tid): ?RedirectResponse
    {
        if ($app->getConfig()['grpc']['disabled']) {
            return null;
        }

        if (empty($tid)) {
            return null;
        }

        $appApi = $app->getGrpcAppApi();

        $listAppsRequest = new ListAppsRequest();
        $listAppsRequest->setTenant($tid);
        $listAppsRequest->setPageSize(1);
        $listAppsRequest->setFilter('type=crm');

        /** @var ListAppsResponse $response */
        [$response, $status] = $appApi->ListApps($listAppsRequest)->wait();
        if ($status && $status->code === \Grpc\CALL_OK) {
            $crmAppList = $response->getApps();
            if (count($crmAppList) > 0) {
                /** @var App $app */
                $crmApp = $crmAppList[0];
                $redirectUri = $crmApp->getRedirectUris()[0];
                if ($redirectUri) {
                    $crmUrlArr = parse_url($redirectUri);
                    $crmUrl = $crmUrlArr['scheme'] . '://'
                        . $crmUrlArr['host']
                        . (isset($crmUrlArr['port']) ? ':' . $crmUrlArr['port'] : '')
                        . (isset($crmUrlArr['path']) ? $crmUrlArr['path'] : '');
                    $app->getLogger()->debug(
                        'Redirecting to crm authenticated user',
                        [
                            'tid' => $tid,
                            'crmUrl' => $crmUrl,
                            'tags' => ['IdM.main'],
                        ]
                    );
                    return new RedirectResponse($crmUrl);
                }
            }
        } else {
            $app->getLogger()->warning(
                sprintf(
                    'Wrong answer from APP API, code: %s, details: %s. Trying get a list of tenant crm app.',
                    $status->code,
                    $status->details
                ),
                [
                    'tid' => $tid,
                    'tags' => ['IdM.main'],
                ]
            );
        }
        return null;
    }

    /**
     * @param Application $app Silex application instance.
     * @param Request $request
     * @return string
     */
    public function renderFormAction(Application $app, Request $request)
    {
        $token = $app->getRememberMeService()->retrieve();
        $session = $app->getSession();
        if ($token) {
            $session->set(TenantConfigInitializer::SESSION_KEY, $token->getAttribute('tenantSrn'));
            return $this->redirectAuthenticatedUser($app, $token);
        }

        $tenantConfigInitializer = new TenantConfigInitializer($app);
        $params = ['tid' => '', 'user_name' => '', 'ssoLogin' => false];

        if ($request->query->has('login_hint')) {
            $params['user_name'] = $request->query->get('login_hint');
        }

        if ($tenantConfigInitializer->hasTenant($request)) {

            // handle invalid tenant hint
            try {
                $tenantConfigInitializer->initConfig($request);
            } catch (TenantNotExistsException $e) {
                $app->getLogger()->info('Invalid tenant id', [
                    'errors' => $e->getMessage(),
                    'tags' => ['IdM.main'],
                ]);
                return $this->processNotExistsTenant($app, $e->getMessage());
            } catch (TenantNotActiveException $e) {
                $app->getLogger()->info('Inactive tenant id', [
                    'errors' => $e->getMessage(),
                    'tags' => ['IdM.main'],
                ]);
                return $this->processInactiveTenant($app, $e->getMessage());
            } catch (TenantInDifferentRegionException $e) {
                $app->getLogger()->debug('Different region, redirecting', [
                    'region' => $e->getTenantRegion(),
                    'tenant' => $e->getTenantId(),
                    'errors' => $e->getMessage(),
                    'tags' => ['IdM.main'],
                ]);
                return $app->getRegionChecker()->redirectToRegion(
                    $request,
                    $e->getTenantRegion(),
                    $e->getTenantId()
                );
            }

            $config = $app->getConfig();

            $tenant = Srn\Converter::fromString($session->get(TenantConfigInitializer::SESSION_KEY));
            $params['tid'] = $tenant->getTenantId();

            if (!empty($config['saml'])) {
                $params['ssoLogin'] = true;
            }
        } else {
            $tid = $app->getCookieService()->getTenantCookie($request);
            if (!empty($tid)) {
                $tenant = Srn\Converter::fromString($tid);
                $params['tid'] = $tenant->getTenantId();
            }
            return $this->renderTenantForm($app, $params);
        }

        return $this->renderLoginForm($app, $params);
    }

    /**
     * @param Application $app Silex application instance.
     * @param Request $request
     * @return string
     */
    public function postFormAction(Application $app, Request $request)
    {
        /** @var Session $sessionService */
        $sessionService = $app->getSession();
        $flashBag = $sessionService->getFlashBag();

        // collect data
        $data = [
            'tid' => $request->get('tid'),
            'user_name' => $request->get('user_name'),
            'password' => $request->get('password'),
            'csrf_token' => $request->get('csrf_token'),
        ];

        $dataToLog = $data;
        $dataToLog['password'] = '***obfuscated***';

        $app->getLogger()->debug('Validation form data', [
            'data' => $dataToLog,
            'tags' => ['IdM.main'],
        ]);
        $constraint = new Assert\Collection([
            'tid' => [new Assert\NotBlank()],
            'user_name' => [new Assert\NotBlank()],
            'password' => [new Assert\NotBlank()],
            'csrf_token' => [new CustomAssert\Csrf($app->getCsrfTokenManager())],
        ]);
        $violations = $app->getValidatorService()->validate($data, $constraint);
        if (count($violations) > 0) {
            $errors = array_map(function (ConstraintViolation $violation) {
                return $violation->getMessage();
            }, iterator_to_array($violations));
            $app->getLogger()->debug('Invalid form with errors', [
                'errors' => $errors,
                'tags' => ['IdM.main'],
            ]);
            $flashBag->add('error', 'All fields are required');
            return new RedirectResponse($app->getUrlGeneratorService()->generate('loginRender', [
                TenantConfigInitializer::REQUEST_KEY => $data['tid'],
                'login_hint' => $data['user_name'],
            ]));
        }

        try {
            $tenantConfigInitializer = new TenantConfigInitializer($app);
            $tenantConfigInitializer($request);

            $token = $app->getUsernamePasswordTokenFactory(
                $data['user_name'],
                $data['password']
            )->createAuthenticationToken();

            $userName = $token->getUsername();
            $tenant = $sessionService->get(TenantConfigInitializer::SESSION_KEY);

            $app->getLogger()->info('Trying to authenticate user:{user_name} in tenant:{tid}', [
                'user_name' => $userName,
                'tid' => $tenant,
                'tags' => ['IdM.main'],
            ]);

            $token = $app->getAuthManagerService()->authenticate($token);

            if (!empty($token) && $token->isAuthenticated()) {
                $tenantSrn = Srn\Converter::fromString($tenant);
                $userIdentity = $token->getUser()->getLocalUser()->getAttribute('id');
                $userSrn = $app->getSrnManager($tenantSrn->getRegion())
                    ->createUserSrn($tenantSrn->getTenantId(), $userIdentity);
                $user = Srn\Converter::toString($userSrn);
                $token->setAttribute('srn', $user);
                $token->setAttribute('tenantSrn', $tenant);
                $app->getRememberMeService()->store($token);
    
                $app->getLogger()->info(
                    'Authentication success for user {user_name} with SRN {user_srn} and {tenant} from {ip}',
                    [
                        'user_name' => $userName,
                        'user_srn' => $user,
                        'tenant' => $tenant,
                        'ip' => $request->getClientIp(),
                        'tags' => ['IdM.main'],
                        'event' => 'after_login',
                    ]
                );
    
                return $this->redirectAuthenticatedUser($app, $token);
            }
        } catch (BadCredentialsException $e) {
            $flashBag->add('error', 'Invalid credentials');

            $app->getLogger()->notice(
                'Bad credentials occurred for user:{user_name} with SRN {user_srn} in tenant:{tid}',
                [
                    'user_name' => $data['user_name'],
                    'user_srn' => $user ?? 'unknown',
                    'tid' => $data['tid'],
                    'tags' => ['IdM.main'],
                    'event' => 'login_failed',
                ]
            );
        } catch (AuthenticationException $e) {
            $message = empty($e->getMessage()) ? $e->getMessageKey() : $e->getMessage();
            $flashBag->add('error', $message);

            $app->getLogger()->warning(
                'Authentication Exception occurred for user:{user_name} with SRN {user_srn} in tenant:{tid}',
                [
                    'user_name' => $data['user_name'],
                    'user_srn' => $user ?? 'unknown',
                    'tid' => $data['tid'],
                    'exception' => $e,
                    'tags' => ['IdM.main'],
                    'event' => 'login_failed',
                ]
            );
        } catch (\InvalidArgumentException $e) {
            $flashBag->add('error', 'Invalid credentials');

            $app->getLogger()->warning(
                'User:{user_name} with SRN {user_srn} try login with invalid tenant:{tid}',
                [
                    'user_name' => $data['user_name'],
                    'user_srn' => $user ?? 'unknown',
                    'tid' => $data['tid'],
                    'exception' => $e,
                    'tags' => ['IdM.main'],
                    'event' => 'login_failed',
                ]
            );
        } catch (\RuntimeException $e) {
            $flashBag->add('error', 'Invalid credentials');

            $app->getLogger()->warning(
                'User:{user_name} with SRN {user_srn} try login with not existing tenant:{tid}',
                [
                    'user_name' => $data['user_name'],
                    'user_srn' => $user ?? 'unknown',
                    'tid' => $data['tid'],
                    'exception' => $e,
                    'tags' => ['IdM.main'],
                    'event' => 'login_failed',
                ]
            );
        } catch (\Exception $e) {
            $flashBag->add('error', 'APP ERROR: ' . $e->getMessage());

            $app->getLogger()->error(
                'Exception occurred for user:{user_name} with SRN {user_srn} in tenant:{tid}',
                [
                    'user_name' => $data['user_name'],
                    'user_srn' => $user ?? 'unknown',
                    'tid' => $sessionService->get(TenantConfigInitializer::SESSION_KEY),
                    'exception' => $e,
                    'tags' => ['IdM.main'],
                    'event' => 'login_failed',
                ]
            );
        }

        return new RedirectResponse($app->getUrlGeneratorService()->generate('loginRender', [
            TenantConfigInitializer::REQUEST_KEY => $sessionService->get(TenantConfigInitializer::SESSION_KEY),
            'login_hint' => $data['user_name'],
        ]));
    }

    /**
     * LogOut action
     * @param Application $app
     * @param Request $request
     * @return RedirectResponse
     */
    public function logoutAction(Application $app, Request $request): RedirectResponse
    {
        $token = $app->getRememberMeService()->retrieve();
        if ($token instanceof SAMLResultToken) {
            $user = $token->getUser();
            $url = $app->getUrlGeneratorService()->generate(
                'samlLogoutInit',
                [
                    'nameId' => $user->getAttribute('identityValue'),
                    'redirect_uri' => $app->getRedirectURLService()->getRedirectUrl($request),
                    'sessionIndex' => $token->getAttribute('IdPSessionIndex'),
                ]
            );
            return RedirectResponse::create($url);
        }
        $response = $app->getLogoutService()->logout($request);

        if (!is_null($token)) {
            $app->getLogger()->info('Logout for user {user_name} with SRN {user_srn}', [
                'user_name' => $token->getUsername(),
                'user_srn' => $token->hasAttribute('srn') ? $token->getAttribute('srn') : 'unknown',
                'tags' => ['IdM.main'],
                'event' => 'after_logout',
            ]);
        }
        $app->getCookieService()->clearRegionCookie($response);
        return $response;
    }

    /**
     * Redirect user to consent or landing page
     *
     * @param Application $app
     * @param TokenInterface $token Authenticated result token
     * @return RedirectResponse
     */
    protected function redirectAuthenticatedUser(Application $app, TokenInterface $token): RedirectResponse
    {
        if ($app->getUserPasswordChecker()->isPasswordExpired($token)) {
            return $app->redirect($app->getUrlGeneratorService()->generate('showChangePasswordForm'));
        }

        $sessionService = $app->getSession();

        $response = null;
        $route = '';
        if ($sessionService->get('consent')) {
            /** @var ConsentToken $consentToken */
            $consentToken = $sessionService->get('consent');
            $consentToken->setTenantSRN($token->getAttribute('tenantSrn'));

            $sessionService->set('authenticatedUser', $token);
            $response = $app->redirect($app->getUrlGeneratorService()->generate('consentConfirmation'));
            $route = 'consentConfirmation';
        }

        if (is_null($response)) {
            $route = 'loginEndPoint';
            $response = RedirectResponse::create($app->getUrlGeneratorService()->generate(
                'loginEndPoint',
                [
                    'tid' => $sessionService->get(TenantConfigInitializer::SESSION_KEY),
                    'user_name' => $token->getUsername(),
                    'provider' => $token->getProviderKey(),
                ]
            ));
        }

        $app->getLogger()->debug('Redirect user:{user_name} with SRN {user_srn} in tenant:{tid} to route:{route}', [
            'user_name' => $token->getUsername(),
            'user_srn' => $token->getAttribute('srn'),
            'tid' => $sessionService->get(TenantConfigInitializer::SESSION_KEY),
            'route' => $route,
            'tags' => ['IdM.main'],
        ]);
        $app->getCookieService()->setTenantCookie(
            $response,
            $sessionService->get(TenantConfigInitializer::SESSION_KEY)
        );

        $tenantSrn = Srn\Converter::fromString($sessionService->get(TenantConfigInitializer::SESSION_KEY));
        $app->getCookieService()->setRegionCookie($response, $tenantSrn->getRegion());
        return $response;
    }

    /**
     * @param Application $app
     * @param $error
     * @return string|RedirectResponse
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    protected function processNotExistsTenant(Application $app, $error)
    {
        $session = $app->getSession();
        $session->getFlashBag()->add('error', $error);

        return $this->renderTenantForm($app, ['user_name' => '']);
    }

    /**
     * @param Application $app
     * @param $error
     * @return string|RedirectResponse
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    protected function processInactiveTenant(Application $app, $error)
    {
        $session = $app->getSession();
        $session->getFlashBag()->add('error', $error);
        if ($session->get('consent')) {
            return $app->redirect($app->getUrlGeneratorService()->generate('consentCancel'));
        }

        return $this->renderTenantForm($app, ['user_name' => '']);
    }

    /**
     * @param Application $app
     * @param array $params
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    protected function renderTenantForm(Application $app, array $params = []): string
    {
        $app->getLogger()->debug('Render tenant form', [
            'params' => $params,
            'tags' => ['IdM.main'],
        ]);

        if (!isset($params['tid'])) {
            $params['tid'] = '';
        }

        return $app->getTwigService()->render('main/tenant.html.twig', $params);
    }

    /**
     * @param Application $app
     * @param array $params
     * @return string
     */
    protected function renderLoginForm(Application $app, array $params = [])
    {
        $app->getLogger()->debug('Render login form', [
            'params' => $params,
            'tags' => ['IdM.main'],
        ]);
        $params = array_merge($params, [
            'csrf_token' => $app->getCsrfTokenManager()->getToken(CustomAssert\Csrf::FORM_TOKEN_ID)
        ]);
        return $app->getTwigService()->render('main/login.html.twig', $params);
    }
}
