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

namespace Unit\Authentication\Provider;

use Jose\Loader as JWTLoader;
use Jose\LoaderInterface;
use Jose\Object\JWEInterface;
use League\OAuth2\Client\Token\AccessToken;
use Sugarcrm\IdentityProvider\Authentication\Provider\OIDC;
use Sugarcrm\IdentityProvider\Authentication\Provider\OIDCAuthenticationProvider;
use Sugarcrm\IdentityProvider\Authentication\Token\OIDC\OIDCCodeToken;
use Sugarcrm\IdentityProvider\Authentication\Token\SAML\ResultToken;
use Sugarcrm\IdentityProvider\Authentication\User;
use Sugarcrm\IdentityProvider\Authentication\UserMapping\OIDCUserMapping;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\Authentication\Provider\OIDCAuthenticationProvider
 */
class OIDCAuthenticationProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OIDC\ExternalServiceInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $oidcService;

    /**
     * @var JWTLoader | \PHPUnit_Framework_MockObject_MockObject
     */
    private $jwtLoader;

    /**
     * @var UserProviderInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $userProvider;

    /**
     * @var OIDCUserMapping | \PHPUnit_Framework_MockObject_MockObject
     */
    private $mapper;

    /**
     * @var UserCheckerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $userChecker;

    /**
     * @var AccessToken | \PHPUnit_Framework_MockObject_MockObject
     */
    private $accessToken;

    /**
     * @var OIDCAuthenticationProvider
     */
    private $provider;

    /**
     * @var JWEInterface
     */
    private $jwt;

    /**
     * @var User
     */
    private $user;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->oidcService = $this->createMock(OIDC\ExternalServiceInterface::class);
        $this->jwtLoader = $this->createMock(LoaderInterface::class);
        $this->userProvider = $this->createMock(UserProviderInterface::class);
        $this->mapper = new OIDCUserMapping(
            [
                'given_name' => 'attributes.given_name',
                'family_name' => 'attributes.family_name',
                'email' => 'attributes.email',
            ]
        );
        $this->userChecker = $this->getMockBuilder(UserCheckerInterface::class)->getMock();
        $this->accessToken = $this->createMock(AccessToken::class);
        $this->jwt = $this->createMock(JWEInterface::class);
        $this->user = new User();

        $this->provider = new OIDCAuthenticationProvider(
            [
                'urlAuthorize' => 'https://site/auth',
                'urlAccessToken' => 'https://site/oauth/token',
                'urlResourceOwnerDetails' => 'https://site/oauth/token',
                'urlUserInfo' => 'https://site/oauth/info',
                'clientId' => 'id',
                'clientSecret' => 'secret',
                'scope' => ['openid'],
                'provisionUser' => true,
            ],
            $this->userProvider,
            $this->mapper,
            $this->userChecker,
            $this->oidcService,
            $this->jwtLoader
        );
    }

    /**
     * @return array
     */
    public function supportsProvider(): array
    {
        return [
            'notSupportedToken' => [
                'token' => new ResultToken('test', []),
                'expected' => false,
            ],
            'supportedToken' => [
                'token' => new OIDCCodeToken('test', []),
                'expected' => true,
            ],
        ];
    }

    /**
     * @param TokenInterface $token
     * @param bool $expected
     *
     * @covers ::supports
     *
     * @dataProvider supportsProvider
     */
    public function testSupports(TokenInterface $token, bool $expected): void
    {
        $this->assertEquals($expected, $this->provider->supports($token));
    }

    /**
     * @covers ::authenticate
     */
    public function testAuthenticateWithNotSupportedToken(): void
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('There is no authentication handler for ' . ResultToken::class);
        $this->provider->authenticate(new ResultToken('test', []));
    }

    /**
     * @covers ::authenticate
     */
    public function testAuthenticateWithoutSubjectInToken(): void
    {
        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage('Subject not found in token');

        $this->oidcService->expects($this->once())
            ->method('getAccessToken')
            ->with(['code' => 'code'])
            ->willReturn($this->accessToken);

        $this->accessToken->method('getValues')->willReturn(['id_token' => 'id_token']);
        $this->jwtLoader->method('load')->with('id_token')->willReturn($this->jwt);

        $this->provider->authenticate(new OIDCCodeToken('code', []));
    }

    /**
     * @return array
     */
    public function authenticateProvider(): array
    {
        return [
            'notEmptyUserInfoName' => [
                'userInfoClaims' => [
                    'sub' => 'subject1',
                    'given_name' => 'test',
                    'family_name' => 'name',
                    'email' => 'test1@email',
                ],
                'jwtClaims' => [],
                'claimsToSet' => [
                    'sub' => 'subject1',
                    'given_name' => 'test',
                    'family_name' => 'name',
                    'email' => 'test1@email',
                ],
                'expectedAttributes' => [
                    'attributes' => [
                        'given_name' => 'test',
                        'family_name' => 'name',
                        'email' => 'test1@email',
                    ],
                    'sub' => 'subject1',
                    'provision' => true,
                    'identityField' => 'sub',
                    'identityValue' => 'subject1',
                ]
            ],
            'emptyUserInfoNameClaimsInJWT' => [
                'userInfoClaims' => [],
                'jwtClaims' => [
                    'sub' => 'subject',
                    'name' => 'test name',
                    'email' => 'test@email',
                ],
                'claimsToSet' => [
                    'sub' => 'subject',
                    'family_name' => 'test name',
                    'email' => 'test@email',
                ],
                'expectedAttributes' => [
                    'attributes' => [
                        'family_name' => 'test name',
                        'email' => 'test@email',
                    ],
                    'sub' => 'subject',
                    'provision' => true,
                    'identityField' => 'sub',
                    'identityValue' => 'subject',
                ]
            ]
        ];
    }

    /**
     * @param array $userInfoClaims
     * @param array $jwtClaims
     * @param array $claimsToSet
     * @param array $expectedAttributes
     *
     * @covers ::authenticate
     * @dataProvider authenticateProvider
     */
    public function testAuthenticate(
        array $userInfoClaims,
        array $jwtClaims,
        array $claimsToSet,
        array $expectedAttributes
    ): void {
        $this->oidcService->expects($this->once())
            ->method('getAccessToken')
            ->with(['code' => 'code'])
            ->willReturn($this->accessToken);

        $this->oidcService->expects($this->once())
            ->method('getUserInfo')
            ->with($this->accessToken)
            ->willReturn($userInfoClaims);

        $this->accessToken->method('getValues')->willReturn(['id_token' => 'id_token']);

        $this->jwtLoader->method('load')->with('id_token')->willReturn($this->jwt);
        $this->jwt->method('getClaims')->willReturn($jwtClaims);

        $this->userProvider->expects($this->once())
            ->method('loadUserByUsername')
            ->with($claimsToSet['sub'])
            ->willReturn($this->user);

        $this->userChecker->expects($this->once())->method('checkPostAuth')->with($this->user);

        $token = $this->provider->authenticate(new OIDCCodeToken('code', []));
        $this->assertTrue($token->isAuthenticated());

        $user = $token->getUser();
        foreach ($expectedAttributes as $key => $value) {
            $this->assertEquals($value, $user->getAttribute($key));
        }
    }
}
