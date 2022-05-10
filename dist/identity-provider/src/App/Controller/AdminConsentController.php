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

use Sugarcrm\Apis\Iam\App\V1alpha as AppApi;
use Sugarcrm\Apis\Iam\Consent\V1alpha\Consent;
use Sugarcrm\Apis\Iam\Consent\V1alpha\DeleteConsentRequest;
use Sugarcrm\Apis\Iam\Consent\V1alpha\RegisterConsentRequest;
use Sugarcrm\IdentityProvider\App\Application;

use Sugarcrm\IdentityProvider\App\Provider\TenantConfigInitializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sugarcrm\IdentityProvider\Authentication\User;
use \Google\Protobuf\GPBEmpty;

/**
 * Class AdminConsentController
 * @package Sugarcrm\IdentityProvider\App\Controller
 */
class AdminConsentController
{
    /**
     * AdminConsentController constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->sessionService = $app['session'];
    }

    /**
     * Pre-checks for admin consent
     * @param Request $request
     * @param Application $app
     * @return RedirectResponse|null
     */
    public function preCheck(Request $request, Application $app): ?RedirectResponse
    {
        $token = $app->getRememberMeService()->retrieve();

        if (is_null($token)) {
            $app->getSession()->getFlashBag()->add('error', 'Only authorized users');
            return $app->redirect($app->getUrlGeneratorService()->generate('loginRender'));
        }

        if (!$token->getUser() instanceof User) {
            $app->getSession()->getFlashBag()->add('error', 'No user is found');
            return $app->redirect($app->getUrlGeneratorService()->generate('loginRender'));
        }

        $user = $token->getUser();

        $isAdmin = $user->getAttribute('user_type');

        if ($isAdmin != 1) {
            throw new AuthenticationCredentialsNotFoundException('User does not have admin credentials');
        }

        return null;
    }

    /**
     * Admin Consent Flow
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function adminConsentAction(Application $app, Request $request)
    {
        if (!$request->query->has('client_id')) {
            throw new BadRequestHttpException('Client ID not found', null, 400);
        }

        $clientId = $request->query->get('client_id');
        $requestUrl = $app->getRedirectURLService()->getRedirectUrl($request);

        $this->sessionService->set('adm_consent_client_id', $clientId);
        $this->sessionService->set('adm_consent_redirect', $requestUrl);

        $tenantSrn = $request->getSession()->get(TenantConfigInitializer::SESSION_KEY);

        $clientApp = $this->getClientApp($app, $clientId);
        if (empty($clientApp)) {
            throw new AuthenticationCredentialsNotFoundException('Application not found');
        }

        $scopes = iterator_to_array($clientApp->getScopes());
        $isEmpty = empty($scopes) || (count($scopes) == 1 && empty($scopes[0]));

        return $app->getTwigService()->render('consent/app_consent_admin_confirmation.html.twig', [
            'are_scopes_empty' => $isEmpty,
            'scopes' => $app->getConsentRestService()->mapScopes($scopes),
            'client' => $clientApp->getClientName(),
            'tenant' => $tenantSrn,
        ]);
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return RedirectResponse|string
     */
    public function adminConsentFinishAction(Application $app, Request $request)
    {
        $clientId = $this->sessionService->get('adm_consent_client_id');
        if (is_null($clientId)) {
            throw new BadRequestHttpException('Client ID not found', null, 400);
        }

        $redirectUrl = $this->sessionService->get('adm_consent_redirect');
        if (is_null($redirectUrl)) {
            throw new BadRequestHttpException('Redirect Url not found', null, 400);
        }

        $tenantSrn = $request->getSession()->get(TenantConfigInitializer::SESSION_KEY);

        $clientApp = $this->getClientApp($app, $clientId);
        if (empty($clientApp)) {
            throw new AuthenticationCredentialsNotFoundException('Application not found');
        }

        $consent = $this->registerConsent($app, $tenantSrn, $clientId, $clientApp->getScopes());
        if (empty($consent)) {
            throw new AuthenticationCredentialsNotFoundException('Unable to register Consent');
        }

        return $app->redirect($redirectUrl);
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function adminConsentCancelAction(Application $app, Request $request)
    {
        $redirectUrl = $this->sessionService->get('adm_consent_redirect');

        if (is_null($redirectUrl)) {
            throw new BadRequestHttpException('Redirect Url not found', null, 400);
        }

        return $app->redirect($redirectUrl);
    }

    /**
     * Admin Consent Revoke Flow
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function adminConsentRemoveAction(Application $app, Request $request)
    {
        if (!$request->query->has('client_id')) {
            throw new BadRequestHttpException('Client ID not found', null, 400);
        }

        $clientId = $request->query->get('client_id');
        $requestUrl = $app->getRedirectURLService()->getRedirectUrl($request);

        $this->sessionService->set('adm_consent_client_id', $clientId);
        $this->sessionService->set('adm_consent_redirect', $requestUrl);

        $tenantSrn = $request->getSession()->get(TenantConfigInitializer::SESSION_KEY);

        $clientApp = $this->getClientApp($app, $clientId);
        if (empty($clientApp)) {
            throw new AuthenticationCredentialsNotFoundException('Application not found');
        }

        $scopes = iterator_to_array($clientApp->getScopes());
        $isEmpty = empty($scopes) || (count($scopes) == 1 && empty($scopes[0]));

        return $app->getTwigService()->render('consent/app_consent_admin_revoke.html.twig', [
            'are_scopes_empty' => $isEmpty,
            'scopes' => $app->getConsentRestService()->mapScopes($scopes),
            'client' => $clientApp->getClientName(),
            'tenant' => $tenantSrn,
        ]);
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return RedirectResponse|string
     */
    public function adminConsentRemoveFinishAction(Application $app, Request $request)
    {
        $clientId = $this->sessionService->get('adm_consent_client_id');
        if (is_null($clientId)) {
            throw new BadRequestHttpException('Client ID not found', null, 400);
        }

        $redirectUrl = $this->sessionService->get('adm_consent_redirect');
        if (is_null($redirectUrl)) {
            throw new BadRequestHttpException('Redirect Url not found', null, 400);
        }

        $tenantSrn = $request->getSession()->get(TenantConfigInitializer::SESSION_KEY);

        $clientApp = $this->getClientApp($app, $clientId);
        if (empty($clientApp)) {
            throw new AuthenticationCredentialsNotFoundException('Application not found');
        }

        $response = $this->deleteConsent($app, $tenantSrn, $clientId);
        if (empty($response) || !$response instanceof GPBEmpty) {
            throw new AuthenticationCredentialsNotFoundException('Consent was not removed');
        }

        return $app->redirect($redirectUrl);
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function adminConsentRemoveCancelAction(Application $app, Request $request)
    {
        $redirectUrl = $this->sessionService->get('adm_consent_redirect');
        if (is_null($redirectUrl)) {
            throw new BadRequestHttpException('Redirect Url not found', null, 400);
        }

        return $app->redirect($redirectUrl);
    }

    /**
     * register consent for a tenant from CONSENT API
     * @param Application $app
     * @param $tenantId
     * @param $appId
     * @param $scopes
     * @return null|AppApi\App
     */
    protected function registerConsent(Application $app, $tenantId, $appId, $scopes): ?Consent
    {
        $consentApi = $app->getGrpcConsentApi();

        $consent = new Consent();
        $consent->setApp($appId);
        $consent->setTenant($tenantId);
        $consent->setScopes($scopes);

        $registerConsentRequest = new RegisterConsentRequest();
        $registerConsentRequest->setConsent($consent);

        [$consent, $status] = $consentApi->RegisterConsent($registerConsentRequest)->wait();
        if ($status && $status->code === \Grpc\CALL_OK) {
            $app->getLogger()->info(sprintf('Application %s has been consented for tenant %s ', $appId, $tenantId), ['admin-consent', 'consent-api']);
            return $consent;
        }

        $app->getLogger()->warning('Invalid consent-api response RegisterConsent', ['admin-consent', 'consent-api']);
        return null;
    }

    /**
     * deletes consent for a tenant from CONSENT API
     * @param Application $app
     * @param $tenantId
     * @param $appId
     * @return null|\Google\Protobuf\GPBEmpty
     */
    protected function deleteConsent(Application $app, $tenantId, $appId): ?\Google\Protobuf\GPBEmpty
    {
        $consentApi = $app->getGrpcConsentApi();

        $consent = new Consent();
        $consent->setApp($appId);
        $consent->setTenant($tenantId);

        $deleteConsentRequest = new DeleteConsentRequest();
        $deleteConsentRequest->setConsent($consent);

        [$gpbEmpty, $status] = $consentApi->deleteConsent($deleteConsentRequest)->wait();
        if ($status && $status->code === \Grpc\CALL_OK) {
            $app->getLogger()->info(sprintf('Application %s consent deleted for tenant %s ', $appId, $tenantId), ['consent', 'consent-api']);
            return $gpbEmpty;
        }

        $app->getLogger()->warning('Invalid consent-api response DeleteConsent', ['admin-consent', 'consent-api']);
        return null;
    }

    /**
     * get client application info from APP API
     * @param Application $app
     * @param $appId
     * @return null|AppApi\App
     */
    protected function getClientApp(Application $app, $appId): ?AppApi\App
    {
        $grpcAppApi = $app->getGrpcAppApi();
        $grpcGetAppRequest = new AppApi\GetAppRequest();
        $grpcGetAppRequest->setName($appId);
        [$clientApp, $status] = $grpcAppApi->GetApp($grpcGetAppRequest)->wait();
        if ($status && $status->code === \Grpc\CALL_OK) {
            $app->getLogger()->info(sprintf('Application %s information is received.', $appId), ['admin-consent', 'app-api']);
            return $clientApp;
        }
        $app->getLogger()->warning('Invalid app-api response GetApp', ['admin-consent', 'app-api']);
        return null;
    }
}
