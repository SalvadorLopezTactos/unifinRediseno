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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Controller;

use Google\Protobuf\GPBEmpty;
use Sugarcrm\Apis\Iam\App\V1alpha as AppApi;
use Sugarcrm\Apis\Iam\Consent\V1alpha as ConsentApi;

use Grpc\UnaryCall;
use \Google\Protobuf\Internal\RepeatedField;

use Psr\Log\LoggerInterface;
use Sugarcrm\IdentityProvider\App\Provider\TenantConfigInitializer;
use Sugarcrm\IdentityProvider\App\Authentication\AuthProviderManagerBuilder;
use Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentRestService;
use Sugarcrm\IdentityProvider\App\Authentication\RedirectURLService;
use Sugarcrm\IdentityProvider\App\Authentication\RevokeAccessTokensService;
use Sugarcrm\IdentityProvider\App\Controller\ChangePasswordController;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\IdentityProvider\Authentication\RememberMe\Service;
use Sugarcrm\IdentityProvider\App\Controller\AdminConsentController;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Controller\AdminConsentController
 */
class AdminConsentControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Application
     */
    protected $application;

    /**
     * @var Session | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $sessionService;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Request
     */
    protected $request;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Service
     */
    protected $rememberMeService;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | FlashBagInterface
     */
    protected $flashBag;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | UrlGenerator
     */
    protected $urlGenerator;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | \Twig\Environment
     */
    protected $twig;

    /**
     * @var ParameterBag | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestQueryBag;

    /**
     * @var User||PHPUnit_Framework_MockObject_MockObject
     */
    private $user;
    /**
     * @var UsernamePasswordToken||PHPUnit_Framework_MockObject_MockObject
     */
    protected $token;

    /**
     * @var ChangePasswordController
     */
    protected $controller;

    /**
     * @var LoggerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $logger;

    /**
     * @var AppApi\AppAPIClient | \PHPUnit_Framework_MockObject_MockObject
     */
    private $grpcAppApi;

    /**
     * @var ConsentApi\ConsentAPIClient | \PHPUnit_Framework_MockObject_MockObject
     */
    private $grpcConsentApi;

    /**
     * @var UnaryCall | \PHPUnit_Framework_MockObject_MockObject
     */
    private $unaryCall;

    /**
     * @var ConsentUnaryCall | \PHPUnit_Framework_MockObject_MockObject
     */
    private $consentUnaryCall;

    /**
     * @var ApiApp | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $apiApp;

    /**
     * @var UnaryCall | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $apiConsent;

    /**
     * @var RedirectURLService | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $redirectURLService;

    /**
     * @var ConsentRestService | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $consentRestService;

    /**
     * @var RevokeAccessTokensService | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $revokeAccessTokensService;

    protected function setUp()
    {
        $this->application = $this->createMock(Application::class);

        $this->request = $this->createMock(Request::class);
        $this->requestQueryBag = $this->createMock(ParameterBag::class);
        $this->request->query = $this->requestQueryBag;

        $this->rememberMeService = $this->createMock(Service::class);
        $this->application->expects($this->any())->method('getRememberMeService')->willReturn($this->rememberMeService);

        $this->flashBag = $this->createMock(FlashBagInterface::class);
        $this->sessionService = $this->createMock(Session::class);
        $this->sessionService->expects($this->any())->method('getFlashBag')->willReturn($this->flashBag);
        $this->application->expects($this->any())->method('getSession')->willReturn($this->sessionService);

        $this->urlGenerator = $this->createMock(UrlGenerator::class);
        $this->application->expects($this->any())->method('getUrlGeneratorService')->willReturn($this->urlGenerator);

        $this->twig = $this->createMock(\Twig\Environment::class);
        $this->application->expects($this->any())->method('getTwigService')->willReturn($this->twig);

        $this->grpcAppApi = $this->createMock(AppApi\AppAPIClient::class);
        $this->unaryCall = $this->createMock(UnaryCall::class);
        $this->apiApp = $this->createMock(AppApi\App::class);

        $this->grpcConsentApi = $this->createMock(ConsentApi\ConsentAPIClient::class);
        $this->apiConsent = $this->createMock(ConsentApi\Consent::class);
        $this->consentUnaryCall = $this->createMock(UnaryCall::class);

        $this->logger = $this->createMock(LoggerInterface::class);
        $this->redirectURLService = $this->createMock(RedirectURLService::class);

        $this->application->method('getLogger')->willReturn($this->logger);
        $this->application->method('getRedirectURLService')->willReturn($this->redirectURLService);
        $this->application->method('getGrpcAppApi')->willReturn($this->grpcAppApi);
        $this->application->method('getGrpcConsentApi')->willReturn($this->grpcConsentApi);
        $this->application->method('getConfig')->willReturn(['grpc' => ['disabled' => false]]);

        $this->consentRestService = $this->createMock(ConsentRestService::class);
        $this->application->method('getConsentRestService')
            ->willReturn($this->consentRestService);

        $this->application->method('offsetGet')
            ->willReturnMap(
                [
                    ['session', $this->sessionService],
                ]
            );

        $this->controller = new AdminConsentController($this->application);

        $this->token = $this->createMock(UsernamePasswordToken::class);

        $this->user = $this->createMock(User::class);
    }

    /**
     * @covers ::preCheck
     */
    public function testPreCheckWithoutToken()
    {
        $this->rememberMeService->expects($this->once())
            ->method('retrieve')
            ->willReturn(null);
        $this->flashBag->expects($this->once())
            ->method('add')
            ->with('error', 'Only authorized users');

        $this->urlGenerator->expects($this->once())
            ->method('generate')
            ->with('loginRender')
            ->willReturn($url = 'http://login.test.url');
        $this->application->expects($this->once())
            ->method('redirect')
            ->with($url)
            ->willReturn(RedirectResponse::create($url));

        $this->controller->preCheck($this->request, $this->application);
    }

    /**
     * @covers ::preCheck
     */
    public function testPreCheckWrongToken()
    {
        $token = $this->createMock(TokenInterface::class);
        $this->rememberMeService->expects($this->once())
            ->method('retrieve')
            ->willReturn($token);

        $this->flashBag->expects($this->once())
            ->method('add')
            ->with('error', 'No user is found');

        $this->urlGenerator->expects($this->once())
            ->method('generate')
            ->with('loginRender')
            ->willReturn($url = 'http://login.test.url');
        $this->application->expects($this->once())
            ->method('redirect')
            ->with($url)
            ->willReturn(RedirectResponse::create($url));

        $this->controller->preCheck($this->request, $this->application);
    }

    /**
     * @covers ::preCheck
     * @expectedException \Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException
     */
    public function testPreCheckWrongUser()
    {
        $token = new UsernamePasswordToken(
            new User('test', 'user', ['user_type' => 0,]),
            '',
            AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL
        );


        $this->rememberMeService->expects($this->once())
            ->method('retrieve')
            ->willReturn($token);

        $this->controller->preCheck($this->request, $this->application);
    }

    /**
     * @covers ::preCheck
     */
    public function testPreCheck()
    {
        $token = new UsernamePasswordToken(
            new User('test', 'user', ['user_type' => 1,]),
            '',
            AuthProviderManagerBuilder::PROVIDER_KEY_LOCAL
        );
        $this->rememberMeService->expects($this->once())
            ->method('retrieve')
            ->willReturn($token);

        $this->assertNull($this->controller->preCheck($this->request, $this->application));
    }

    /**
     * @covers ::adminConsentAction
     */
    public function testAdminConsentAction(): void
    {
        $redirectUrl = 'http://sugarcrm.io';
        $clientId = 'srn:staging:iam:na:1000000001:app:mfe';

        $this->sessionService->expects($this->at(0))
            ->method('set')
            ->with($this->equalTo('adm_consent_client_id'))
            ->willReturn($clientId);

        $this->sessionService->expects($this->at(1))
            ->method('set')
            ->with($this->equalTo('adm_consent_redirect'))
            ->willReturn($redirectUrl);

        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('get')
            ->with(TenantConfigInitializer::SESSION_KEY)
            ->willReturn('srn:cloud:iam:eu:1000000001:tenant');

        $this->request->expects($this->any())->method('getSession')->willReturn($session);

        $this->requestQueryBag->expects($this->at(0))
            ->method('has')
            ->with($this->equalTo('client_id'))
            ->willReturn($clientId);

        $this->requestQueryBag->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo('client_id'))
            ->willReturn($clientId);

        $this->redirectURLService->expects($this->once())
            ->method('getRedirectUrl')
            ->willReturn('http://oauth.server/?state=123&consent=encodedToken');

        $status = new \StdClass();
        $status->code = \Grpc\CALL_OK;

        $scopes = new RepeatedField(\Google\Protobuf\Internal\GPBType::STRING);
        $scopes[] = 'iam';
        $scopes[] = 'signin';

        $this->apiApp->expects($this->once())
            ->method('getScopes')
            ->willReturn($scopes);

        $this->consentRestService->expects($this->once())
            ->method('mapScopes');

        $this->grpcAppApi->expects($this->once())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class))
            ->willReturn($this->unaryCall);

        $this->unaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([$this->apiApp, $status]);

        $this->twig->expects($this->once())
            ->method('render')
            ->with('consent/app_consent_admin_confirmation.html.twig')
            ->willReturn('html');

        $this->controller->adminConsentAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentAction
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testAdminConsentAction_MissingClientId_ThrowsException(): void
    {
        $this->sessionService->expects($this->never())
            ->method('set')
            ->with($this->equalTo('adm_consent_client_id'));

        $this->requestQueryBag->expects($this->at(0))
            ->method('has')
            ->with($this->equalTo('client_id'))
            ->willReturn(null);

        $this->requestQueryBag->expects($this->never())
            ->method('get')
            ->with($this->equalTo('client_id'));

        $this->apiApp->expects($this->never())
            ->method('getScopes');

        $this->consentRestService->expects($this->never())
            ->method('mapScopes');

        $this->grpcAppApi->expects($this->never())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class));

        $this->unaryCall->expects($this->never())
            ->method('wait');

        $this->twig->expects($this->never())
            ->method('render')
            ->with('consent/app_consent_admin_confirmation.html.twig');

        $this->controller->adminConsentAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentAction
     * @expectedException \Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException
     */
    public function testAdminConsentAction_WrongGrpcResponseStatus(): void
    {
        $redirectUrl = 'http://sugarcrm.io';
        $clientId = 'srn:staging:iam:na:1000000001:app:mfe';

        $this->sessionService->expects($this->at(0))
            ->method('set')
            ->with($this->equalTo('adm_consent_client_id'))
            ->willReturn($clientId);

        $this->sessionService->expects($this->at(1))
            ->method('set')
            ->with($this->equalTo('adm_consent_redirect'))
            ->willReturn($redirectUrl);

        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('get')
            ->with(TenantConfigInitializer::SESSION_KEY)
            ->willReturn('srn:cloud:iam:eu:1000000001:tenant');

        $this->request->expects($this->any())->method('getSession')->willReturn($session);

        $this->requestQueryBag->expects($this->at(0))
            ->method('has')
            ->with($this->equalTo('client_id'))
            ->willReturn($clientId);

        $this->requestQueryBag->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo('client_id'))
            ->willReturn($clientId);

        $this->redirectURLService->expects($this->once())
            ->method('getRedirectUrl')
            ->willReturn('http://oauth.server/?state=123&consent=encodedToken');

        $status = new \StdClass();
        $status->code = \Grpc\CALL_ERROR;

        $this->consentRestService->expects($this->never())
            ->method('mapScopes')
            ->willReturn(['iam']);

        $this->grpcAppApi->expects($this->once())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class))
            ->willReturn($this->unaryCall);

        $this->unaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([$this->apiApp, $status]);

        $this->twig->expects($this->never())
            ->method('render')
            ->with('consent/app_consent_admin_confirmation.html.twig')
            ->willReturn('html');

        $this->controller->adminConsentAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentFinishAction
     */
    public function testAdminConsentFinishAction(): void
    {
        $redirectUrl = 'http://sugarcrm.io';
        $clientId = 'srn:staging:iam:na:1000000001:app:mfe';
        $tenaniId = 'srn:cloud:iam:eu:1000000001:tenant';

        $this->sessionService->expects($this->at(0))
            ->method('get')
            ->with($this->equalTo('adm_consent_client_id'))
            ->willReturn($clientId);

        $this->sessionService->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo('adm_consent_redirect'))
            ->willReturn($redirectUrl);

        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('get')
            ->with(TenantConfigInitializer::SESSION_KEY)
            ->willReturn($tenaniId);

        $this->request->expects($this->any())->method('getSession')->willReturn($session);

        $status = new \StdClass();
        $status->code = \Grpc\CALL_OK;

        $this->apiApp->expects($this->once())
            ->method('getScopes')
            ->willReturn(['iam']);

        $this->unaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([$this->apiApp, $status]);

        //Call to retrieve the application information
        $this->grpcAppApi->expects($this->once())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class))
            ->willReturn($this->unaryCall);

        $this->consentUnaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([$this->apiConsent, $status]);

        //Call to register the consent
        $this->grpcConsentApi->expects($this->once())
            ->method('RegisterConsent')
            ->with($this->isInstanceOf(ConsentApi\RegisterConsentRequest::class))
            ->willReturn($this->consentUnaryCall);

        $this->application
            ->expects($this->once())
            ->method('redirect')
            ->with($redirectUrl);

        $this->controller->adminConsentFinishAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentFinishAction
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testAdminConsentFinishAction_MissingClientId_ThrowsException(): void
    {
        $this->sessionService->expects($this->at(0))
            ->method('get')
            ->with($this->equalTo('adm_consent_client_id'))
            ->willReturn(null);

        $session = $this->createMock(Session::class);
        $session->expects($this->never())
            ->method('get')
            ->with(TenantConfigInitializer::SESSION_KEY);

        $this->request->expects($this->never())->method('getSession')->willReturn($session);

        $this->apiApp->expects($this->never())
            ->method('getScopes');

        $this->unaryCall->expects($this->never())
            ->method('wait');

        //Call to retrieve the application information
        $this->grpcAppApi->expects($this->never())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class));

        $this->consentUnaryCall->expects($this->never())
            ->method('wait');

        //Call to register the consent
        $this->grpcConsentApi->expects($this->never())
            ->method('RegisterConsent')
            ->with($this->isInstanceOf(ConsentApi\RegisterConsentRequest::class));

        $this->application
            ->expects($this->never())
            ->method('redirect');

        $this->controller->adminConsentFinishAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentFinishAction
     * @expectedException \Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException
     */
    public function testAdminConsentFinishAction_WrongGrpcResponseForAppStatus(): void
    {
        $redirectUrl = 'http://sugarcrm.io';
        $clientId = 'srn:staging:iam:na:1000000001:app:mfe';
        $tenaniId = 'srn:cloud:iam:eu:1000000001:tenant';

        $this->sessionService->expects($this->at(0))
            ->method('get')
            ->with($this->equalTo('adm_consent_client_id'))
            ->willReturn($clientId);

        $this->sessionService->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo('adm_consent_redirect'))
            ->willReturn($redirectUrl);

        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('get')
            ->with(TenantConfigInitializer::SESSION_KEY)
            ->willReturn($tenaniId);

        $this->request->expects($this->any())->method('getSession')->willReturn($session);

        $status = new \StdClass();
        $status->code = \Grpc\CALL_ERROR;

        $this->apiApp->expects($this->never())
            ->method('getScopes')
            ->willReturn(['iam']);

        $this->unaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([$this->apiApp, $status]);

        //Call to retrieve the application information
        $this->grpcAppApi->expects($this->once())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class))
            ->willReturn($this->unaryCall);

        $this->consentUnaryCall->expects($this->never())
            ->method('wait');

        //Call to register the consent
        $this->grpcConsentApi->expects($this->never())
            ->method('RegisterConsent')
            ->with($this->isInstanceOf(ConsentApi\RegisterConsentRequest::class))
            ->willReturn($this->consentUnaryCall);

        $this->application
            ->expects($this->never())
            ->method('redirect')
            ->with($redirectUrl);

        $this->twig->expects($this->never())
            ->method('render');

        $this->controller->adminConsentFinishAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentFinishAction
     * @expectedException \Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException
     */
    public function testAdminConsentFinishAction_WrongGrpcResponseForRegisterStatus(): void
    {
        $redirectUrl = 'http://sugarcrm.io';
        $clientId = 'srn:staging:iam:na:1000000001:app:mfe';
        $tenaniId = 'srn:cloud:iam:eu:1000000001:tenant';

        $this->sessionService->expects($this->at(0))
            ->method('get')
            ->with($this->equalTo('adm_consent_client_id'))
            ->willReturn($clientId);

        $this->sessionService->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo('adm_consent_redirect'))
            ->willReturn($redirectUrl);

        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('get')
            ->with(TenantConfigInitializer::SESSION_KEY)
            ->willReturn($tenaniId);

        $this->request->expects($this->any())->method('getSession')->willReturn($session);

        $status = new \StdClass();
        $status->code = \Grpc\CALL_OK;

        $this->apiApp->expects($this->once())
            ->method('getScopes')
            ->willReturn(['iam']);

        $this->unaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([$this->apiApp, $status]);

        //Call to retrieve the application information
        $this->grpcAppApi->expects($this->once())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class))
            ->willReturn($this->unaryCall);

        $consentStatus = new \StdClass();
        $consentStatus->code = \Grpc\CALL_ERROR;

        $this->consentUnaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([$this->apiConsent, $consentStatus]);

        //Call to register the consent
        $this->grpcConsentApi->expects($this->once())
            ->method('RegisterConsent')
            ->with($this->isInstanceOf(ConsentApi\RegisterConsentRequest::class))
            ->willReturn($this->consentUnaryCall);

        $this->application
            ->expects($this->never())
            ->method('redirect')
            ->with($redirectUrl);

        $this->twig->expects($this->never())
            ->method('render');

        $this->controller->adminConsentFinishAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentRemoveAction
     */
    public function testAdminConsentRemoveAction(): void
    {
        $redirectUrl = 'http://sugarcrm.io';
        $clientId = 'srn:staging:iam:na:1000000001:app:mfe';

        $this->sessionService->expects($this->at(0))
            ->method('set')
            ->with($this->equalTo('adm_consent_client_id'))
            ->willReturn($clientId);

        $this->sessionService->expects($this->at(1))
            ->method('set')
            ->with($this->equalTo('adm_consent_redirect'))
            ->willReturn($redirectUrl);

        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('get')
            ->with(TenantConfigInitializer::SESSION_KEY)
            ->willReturn('srn:cloud:iam:eu:1000000001:tenant');

        $this->request->expects($this->any())->method('getSession')->willReturn($session);

        $this->requestQueryBag->expects($this->at(0))
            ->method('has')
            ->with($this->equalTo('client_id'))
            ->willReturn($clientId);

        $this->requestQueryBag->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo('client_id'))
            ->willReturn($clientId);

        $this->redirectURLService->expects($this->once())
            ->method('getRedirectUrl')
            ->willReturn('http://oauth.server/?state=123&consent=encodedToken');

        $status = new \StdClass();
        $status->code = \Grpc\CALL_OK;

        $scopes = new RepeatedField(\Google\Protobuf\Internal\GPBType::STRING);
        $scopes[] = 'iam';
        $scopes[] = 'signin';

        $this->apiApp->expects($this->once())
            ->method('getScopes')
            ->willReturn($scopes);

        $this->consentRestService->expects($this->once())
            ->method('mapScopes');

        $this->grpcAppApi->expects($this->once())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class))
            ->willReturn($this->unaryCall);

        $this->unaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([$this->apiApp, $status]);

        $this->twig->expects($this->once())
            ->method('render')
            ->with('consent/app_consent_admin_revoke.html.twig')
            ->willReturn('html');

        $this->controller->adminConsentRemoveAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentRemoveAction
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testAdminConsentRemoveAction_MissingClientId_ThrowsException(): void
    {
        $this->sessionService->expects($this->never())
            ->method('set')
            ->with($this->equalTo('adm_consent_client_id'));

        $this->requestQueryBag->expects($this->at(0))
            ->method('has')
            ->with($this->equalTo('client_id'))
            ->willReturn(null);

        $this->requestQueryBag->expects($this->never())
            ->method('get')
            ->with($this->equalTo('client_id'));

        $this->apiApp->expects($this->never())
            ->method('getScopes');

        $this->consentRestService->expects($this->never())
            ->method('mapScopes');

        $this->grpcAppApi->expects($this->never())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class));

        $this->unaryCall->expects($this->never())
            ->method('wait');

        $this->twig->expects($this->never())
            ->method('render')
            ->with('consent/app_consent_admin_revoke.html.twig');

        $this->controller->adminConsentRemoveAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentRemoveAction
     * @expectedException \Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException
     */
    public function testAdminConsentRemoveAction_WrongGrpcResponseStatus(): void
    {
        $redirectUrl = 'http://sugarcrm.io';
        $clientId = 'srn:staging:iam:na:1000000001:app:mfe';

        $this->sessionService->expects($this->at(0))
            ->method('set')
            ->with($this->equalTo('adm_consent_client_id'))
            ->willReturn($clientId);

        $this->sessionService->expects($this->at(1))
            ->method('set')
            ->with($this->equalTo('adm_consent_redirect'))
            ->willReturn($redirectUrl);

        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('get')
            ->with(TenantConfigInitializer::SESSION_KEY)
            ->willReturn('srn:cloud:iam:eu:1000000001:tenant');

        $this->request->expects($this->any())->method('getSession')->willReturn($session);

        $this->requestQueryBag->expects($this->at(0))
            ->method('has')
            ->with($this->equalTo('client_id'))
            ->willReturn($clientId);

        $this->requestQueryBag->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo('client_id'))
            ->willReturn($clientId);

        $this->redirectURLService->expects($this->once())
            ->method('getRedirectUrl')
            ->willReturn('http://oauth.server/?state=123&consent=encodedToken');

        $status = new \StdClass();
        $status->code = \Grpc\CALL_ERROR;

        $this->consentRestService->expects($this->never())
            ->method('mapScopes')
            ->willReturn(['iam']);

        $this->grpcAppApi->expects($this->once())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class))
            ->willReturn($this->unaryCall);

        $this->unaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([$this->apiApp, $status]);

        $this->twig->expects($this->never())
            ->method('render')
            ->with('consent/app_consent_admin_revoke.html.twig');

        $this->controller->adminConsentRemoveAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentRemoveFinishAction
     */
    public function testAdminConsentRemoveFinishAction(): void
    {
        $redirectUrl = 'http://sugarcrm.io';
        $clientId = 'srn:staging:iam:na:1000000001:app:mfe';
        $tenaniId = 'srn:cloud:iam:eu:1000000001:tenant';

        $this->sessionService->expects($this->at(0))
            ->method('get')
            ->with($this->equalTo('adm_consent_client_id'))
            ->willReturn($clientId);

        $this->sessionService->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo('adm_consent_redirect'))
            ->willReturn($redirectUrl);

        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('get')
            ->with(TenantConfigInitializer::SESSION_KEY)
            ->willReturn($tenaniId);

        $this->request->expects($this->any())->method('getSession')->willReturn($session);

        $status = new \StdClass();
        $status->code = \Grpc\CALL_OK;

        $this->unaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([$this->apiApp, $status]);

        //Call to retrieve the application information
        $this->grpcAppApi->expects($this->once())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class))
            ->willReturn($this->unaryCall);

        $this->consentUnaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([new GPBEmpty(), $status]);

        //Call to register the consent
        $this->grpcConsentApi->expects($this->once())
            ->method('DeleteConsent')
            ->with($this->isInstanceOf(ConsentApi\DeleteConsentRequest::class))
            ->willReturn($this->consentUnaryCall);

        $this->application
            ->expects($this->once())
            ->method('redirect')
            ->with($redirectUrl);

        $this->twig->expects($this->never())
            ->method('render');

        $this->controller->adminConsentRemoveFinishAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentRemoveFinishAction
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testAdminConsentRemoveFinishAction_MissingClientId_ThrowsException(): void
    {
        $this->sessionService->expects($this->at(0))
            ->method('get')
            ->with($this->equalTo('adm_consent_client_id'))
            ->willReturn(null);

        $session = $this->createMock(Session::class);
        $session->expects($this->never())
            ->method('get')
            ->with(TenantConfigInitializer::SESSION_KEY);

        $this->request->expects($this->never())->method('getSession')->willReturn($session);

        $this->apiApp->expects($this->never())
            ->method('getScopes');

        $this->unaryCall->expects($this->never())
            ->method('wait');

        //Call to retrieve the application information
        $this->grpcAppApi->expects($this->never())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class));

        $this->consentUnaryCall->expects($this->never())
            ->method('wait');

        //Call to register the consent
        $this->grpcConsentApi->expects($this->never())
            ->method('DeleteConsent')
            ->with($this->isInstanceOf(ConsentApi\DeleteConsentRequest::class));

        $this->application
            ->expects($this->never())
            ->method('redirect');

        $this->controller->adminConsentRemoveFinishAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentRemoveFinishAction
     * @expectedException \Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException
     */
    public function testAdminConsentRemoveFinishActionn_WrongGrpcResponseForAppStatus(): void
    {
        $redirectUrl = 'http://sugarcrm.io';
        $clientId = 'srn:staging:iam:na:1000000001:app:mfe';
        $tenaniId = 'srn:cloud:iam:eu:1000000001:tenant';

        $this->sessionService->expects($this->at(0))
            ->method('get')
            ->with($this->equalTo('adm_consent_client_id'))
            ->willReturn($clientId);

        $this->sessionService->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo('adm_consent_redirect'))
            ->willReturn($redirectUrl);

        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('get')
            ->with(TenantConfigInitializer::SESSION_KEY)
            ->willReturn($tenaniId);

        $this->request->expects($this->any())->method('getSession')->willReturn($session);

        $status = new \StdClass();
        $status->code = \Grpc\CALL_ERROR;

        $this->unaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([$this->apiApp, $status]);

        //Call to retrieve the application information
        $this->grpcAppApi->expects($this->once())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class))
            ->willReturn($this->unaryCall);

        $this->consentUnaryCall->expects($this->never())
            ->method('wait');

        //Call to register the consent
        $this->grpcConsentApi->expects($this->never())
            ->method('DeleteConsent')
            ->with($this->isInstanceOf(ConsentApi\DeleteConsentRequest::class));

        $this->application
            ->expects($this->never())
            ->method('redirect');

        $this->twig->expects($this->never())
            ->method('render');

        $this->controller->adminConsentRemoveFinishAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentRemoveFinishAction
     * @expectedException \Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException
     */
    public function testAdminConsentRemoveFinishAction_WrongGrpcResponseForDeleteStatus(): void
    {
        $redirectUrl = 'http://sugarcrm.io';
        $clientId = 'srn:staging:iam:na:1000000001:app:mfe';
        $tenaniId = 'srn:cloud:iam:eu:1000000001:tenant';

        $this->sessionService->expects($this->at(0))
            ->method('get')
            ->with($this->equalTo('adm_consent_client_id'))
            ->willReturn($clientId);

        $this->sessionService->expects($this->at(1))
            ->method('get')
            ->with($this->equalTo('adm_consent_redirect'))
            ->willReturn($redirectUrl);

        $session = $this->createMock(Session::class);
        $session->expects($this->once())
            ->method('get')
            ->with(TenantConfigInitializer::SESSION_KEY)
            ->willReturn($tenaniId);

        $this->request->expects($this->any())->method('getSession')->willReturn($session);

        $status = new \StdClass();
        $status->code = \Grpc\CALL_OK;

        $this->unaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([$this->apiApp, $status]);

        //Call to retrieve the application information
        $this->grpcAppApi->expects($this->once())
            ->method('GetApp')
            ->with($this->isInstanceOf(AppApi\GetAppRequest::class))
            ->willReturn($this->unaryCall);

        $consentStatus = new \StdClass();
        $consentStatus->code = \Grpc\CALL_ERROR;

        $this->consentUnaryCall->expects($this->once())
            ->method('wait')
            ->willReturn([$this->apiConsent, $consentStatus]);

        //Call to register the consent
        $this->grpcConsentApi->expects($this->once())
            ->method('DeleteConsent')
            ->with($this->isInstanceOf(ConsentApi\DeleteConsentRequest::class))
            ->willReturn($this->consentUnaryCall);

        $this->application
            ->expects($this->never())
            ->method('redirect')
            ->with($redirectUrl);

        $this->twig->expects($this->never())
            ->method('render');

        $this->controller->adminConsentRemoveFinishAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentCancelAction
     */
    public function testAdminConsentCancelAction(): void
    {
        $redirectUrl = 'http://sugarcrm.io';

        $this->sessionService->expects($this->once())
            ->method('get')
            ->with($this->equalTo('adm_consent_redirect'))
            ->willReturn($redirectUrl);

        $this->application
            ->expects($this->once())
            ->method('redirect')
            ->with($redirectUrl);

        $this->controller->adminConsentCancelAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentCancelAction
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testAdminConsentCancelAction_MissingRedirectUrl_ThrowsException(): void
    {
        $this->sessionService->expects($this->once())
            ->method('get')
            ->with($this->equalTo('adm_consent_redirect'))
            ->willReturn(null);

        $this->application
            ->expects($this->never())
            ->method('redirect');

        $this->controller->adminConsentCancelAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentRemoveCancelAction
     */
    public function testAdminConsentRemoveCancelAction(): void
    {
        $redirectUrl = 'http://sugarcrm.io';

        $this->sessionService->expects($this->once())
            ->method('get')
            ->with($this->equalTo('adm_consent_redirect'))
            ->willReturn($redirectUrl);

        $this->application
            ->expects($this->once())
            ->method('redirect')
            ->with($redirectUrl);

        $this->controller->adminConsentRemoveCancelAction($this->application, $this->request);
    }

    /**
     * @covers ::adminConsentRemoveCancelAction
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    public function testAdminConsentRemoveCancelAction_MissingRedirectUrl_ThrowsException(): void
    {
        $this->sessionService->expects($this->once())
            ->method('get')
            ->with($this->equalTo('adm_consent_redirect'))
            ->willReturn(null);

        $this->application
            ->expects($this->never())
            ->method('redirect');

        $this->controller->adminConsentRemoveCancelAction($this->application, $this->request);
    }
}
