<?php

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Authentication\ConsentRequest;

use Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentRestService;
use Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentToken;
use Sugarcrm\IdentityProvider\App\Authentication\OAuth2Service;
use Symfony\Component\Translation\Translator;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Authentication\ConsentRequest\ConsentRestService
 */
class ConsentRestServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var OAuth2Service | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $oAuth2Service;

    /**
     * @var ConsentRestService
     */
    protected $service;

    protected function setUp()
    {
        $this->oAuth2Service = $this->createMock(OAuth2Service::class);
        $this->service = new ConsentRestService($this->oAuth2Service, new Translator('en'));
    }

    /**
     * @covers ::getToken
     */
    public function testGetToken()
    {
        $requestId = 'test_consent_id';
        $this->oAuth2Service->expects($this->once())
            ->method('getConsentRequestData')
            ->willReturn([
                'id' => $requestId,
                'requestedScopes' => ['offline', 'openid', 'hydra.*'],
                'clientId' => 'testLocal1',
                'redirectUrl' => 'http://test/?tenant_hint=srn:cloud:idp:eu:2000000001:tenant&login_hint=max',
            ]);

        /** @var ConsentToken $token */
        $token = $this->service->getToken($requestId);
        $this->assertEquals('srn:cloud:idp:eu:2000000001:tenant', $token->getTenantSRN());
        $this->assertEquals('max', $token->getUsername());
    }

    /**
     * @covers ::mapScopes
     */
    public function testMapScopes()
    {
        $result = $this->service->mapScopes([
            'offline',
            'https://apis.sugarcrm.com/auth/crm',
            'profile',
            'email',
            'address',
            'phone',
        ]);
        $this->assertEquals('View email, address, phone number', $result[0]);
        $this->assertEquals(
            'View and update any Sugar data (Accounts, Contacts, Leads, etc.) that you are permitted to access',
            $result[1]
        );
        $this->assertEquals('View your Sugar profile which includes first and last name', $result[2]);
        $this->assertEquals('Access all the above information at any time', $result[3]);
    }
}
