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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Listener\Success;

use Sugarcrm\IdentityProvider\App\Application;
use Sugarcrm\IdentityProvider\App\Authentication\CookieService;
use Sugarcrm\IdentityProvider\App\Subscriber\TranslationSubscriber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Subscriber\TranslationSubscriber
 */
class TranslationSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Application
     */
    protected $application;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Request
     */
    protected $request;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | Response
     */
    protected $response;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | ParameterBag
     */
    protected $requestQuery;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | ParameterBag
     */
    protected $requestCookies;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | ResponseHeaderBag
     */
    protected $responseHeaders;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | GetResponseEvent
     */
    protected $getResponseEvent;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject | FilterResponseEvent
     */
    protected $filterResponseEvent;

    /**
     * @var CookieService | \PHPUnit_Framework_MockObject_MockObject
     */
    private $cookieService;

    /**
     * @var string
     */
    private $paramName = 'locale';

    /**
     * @var TranslationSubscriber
     */
    private $subscriber;

    protected function setUp()
    {
        $this->cookieService = $this->createMock(CookieService::class);

        $this->application =  $this->createMock(Application::class);
        $this->application->method('getCookieService')->willReturn($this->cookieService);
        $this->application->method('offsetGet')->willReturnMap([
            ['locale', 'en-US'],
        ]);

        $this->request = $this->createMock(Request::class);

        $this->requestQuery = $this->createMock(ParameterBag::class);
        $this->request->query = $this->requestQuery;

        $this->requestCookies = $this->createMock(ParameterBag::class);
        $this->request->cookies = $this->requestCookies;

        $this->getResponseEvent = $this->createMock(GetResponseEvent::class);
        $this->getResponseEvent->expects($this->any())->method('getRequest')->willReturn($this->request);

        $this->responseHeaders = $this->createMock(ResponseHeaderBag::class);

        $this->response = $this->createMock(Response::class);
        $this->response->headers = $this->responseHeaders;

        $this->filterResponseEvent = $this->createMock(FilterResponseEvent::class);
        $this->filterResponseEvent->expects($this->any())->method('getResponse')->willReturn($this->response);
        $this->filterResponseEvent->expects($this->any())->method('getRequest')->willReturn($this->request);

        $this->subscriber = new TranslationSubscriber($this->application, $this->paramName);

        parent::setUp();
    }

    /**
     * @covers ::onKernelRequest
     */
    public function testOnKernelRequestDefaultLocale()
    {
        $this->requestQuery->expects($this->once())
            ->method('has')
            ->with($this->paramName)
            ->willReturn(false);
        $this->cookieService->expects($this->atLeastOnce())
            ->method('getLocaleCookie')
            ->with($this->request)
            ->willReturn('');

        $this->application
            ->expects($this->atLeastOnce())
            ->method('offsetSet')
            ->with('locale', 'en-US');

        $this->subscriber->onKernelRequest($this->getResponseEvent);
    }

    /**
     * @covers ::onKernelRequest
     */
    public function testOnKernelRequestQueryLocale()
    {
        $this->requestQuery->expects($this->once())
            ->method('has')
            ->with($this->paramName)
            ->willReturn(true);
        $this->requestQuery->expects($this->once())
            ->method('get')
            ->with($this->paramName)
            ->willReturn('de-DE');
        $this->cookieService->expects($this->never())
            ->method('getLocaleCookie');

        $this->application
            ->expects($this->atLeastOnce())
            ->method('offsetSet')
            ->with('locale', 'de-DE');

        $this->subscriber->onKernelRequest($this->getResponseEvent);
    }

    /**
     * @covers ::onKernelRequest
     */
    public function testOnKernelRequestCookieLocale()
    {
        $this->requestQuery->expects($this->once())
            ->method('has')
            ->with($this->paramName)
            ->willReturn(false);

        $this->cookieService->expects($this->atLeastOnce())
            ->method('getLocaleCookie')
            ->with($this->request)
            ->willReturn('fr-FR');

        $this->application
            ->expects($this->atLeastOnce())
            ->method('offsetSet')
            ->with('locale', 'fr-FR');

        $this->subscriber->onKernelRequest($this->getResponseEvent);
    }

    /**
     * @covers ::onKernelResponse
     */
    public function testOnKernelResponse()
    {
        $this->cookieService->expects($this->once())
            ->method('setLocaleCookie')
            ->with($this->response, 'en-US');

        $this->subscriber->onKernelResponse($this->filterResponseEvent);
    }
}
