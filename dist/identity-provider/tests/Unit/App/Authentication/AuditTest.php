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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Authentication;

use Psr\Log\LoggerInterface;
use Sugarcrm\IdentityProvider\Authentication\Audit;
use Sugarcrm\IdentityProvider\Authentication\User;

class AuditTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $applicationSRN = 'srn:cloud:idp::1234567890:app:crm:00000001-0001-0001-0001-000000000001';

    /**
     * @var string
     */
    private $tenantSRN = 'srn:cloud:idp::1234567890:tenant';

    /**
     * @var LoggerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $logger;

    /**
     * @var Audit
     */
    private $audit;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->audit = new Audit($this->logger, $this->tenantSRN, $this->applicationSRN);
    }

    /**
     * @see testAudit
     * @return array
     */
    public function auditDataProvider(): array
    {
        $from = [
            'id' => '6f1f6421-6a77-409d-8a59-76308ee399df',
            'create_time' => '2019-09-06 15:39:49',
            'modify_time' => '2019-09-06 15:39:49',
            'created_by' => 'srn:cloud:idp::1234567890:app:crm:00000001-0001-0001-0001-000000000001',
            'modified_by' => 'srn:cloud:idp::1234567890:app:crm:00000001-0001-0001-0001-000000000001',
            'status' => User::STATUS_ACTIVE,
            'tenant_id' => 'srn:cloud:idp::1234567890:tenant',
            'user_type' => User::USER_TYPE_REGULAR_USER,
            'attributes' => [
                'given_name' => 'given_name1',
                'family_name' => 'family_name1',
                'middle_name' => 'middle_name1',
                'nickname' => 'nickname1',
                'email' => 'email1@email1.com',
                'phone_number' => 'phone_number1',
                'department' => 'department1',
                'title' => 'title1',
                'address' => [
                    'street_address' => 'street_address1',
                    'locality' => 'locality1',
                    'region' => 'region1',
                    'postal_code' => 'postal_code1',
                    'country' => 'country1',
                ],
            ],
            'custom_attributes' => [
                'custom_attributes1' => 'custom_attributes1v1',
                'custom_attributes2' => 'custom_attributes2v1',
            ],
        ];
        $to = [
            'id' => '6f1f6421-6a77-409d-8a59-76308ee399df',
            'create_time' => '2019-09-06 15:39:49',
            'modify_time' => '2019-09-06 15:39:49',
            'created_by' => 'srn:cloud:idp::1234567890:app:crm:00000001-0001-0001-0001-000000000002',
            'modified_by' => 'srn:cloud:idp::1234567890:app:crm:00000001-0001-0001-0001-000000000002',
            'status' => User::STATUS_INACTIVE,
            'tenant_id' => 'srn:cloud:idp::1234567890:tenant',
            'user_type' => User::USER_TYPE_ADMINISTRATOR,
            'attributes' => [
                'given_name' => 'given_name2',
                'family_name' => 'family_name2',
                'middle_name' => 'middle_name2',
                'nickname' => 'nickname2',
                'email' => 'email2@email2.com',
                'phone_number' => 'phone_number2',
                'department' => 'department2',
                'title' => 'title2',
                'address' => [
                    'street_address' => 'street_address2',
                    'locality' => 'locality2',
                    'region' => 'region2',
                    'postal_code' => 'postal_code2',
                    'country' => 'country2',
                ],
            ],
            'custom_attributes' => [
                'custom_attributes1' => 'custom_attributes1v2',
                'custom_attributes2' => 'custom_attributes2v2',
            ],
        ];

        $msgCreate = 'Create User';
        $msgUpdate = 'Update User';
        $msgDetele = 'Delete User';
        $userName = 'srn:cloud:iam::1234567890:user:6f1f6421-6a77-409d-8a59-76308ee399df';
        $subject = 'srn:cloud:idp::1234567890:app:crm:00000001-0001-0001-0001-000000000001';
        $client_id = 'srn:cloud:idp::1234567890:app:crm:00000001-0001-0001-0001-000000000001';

        return [
            'both not empty' => [
                'in' => [
                    'msg' => $msgUpdate,
                    'id' => $from['id'],
                    'from' => $from,
                    'to' => $to,
                ],
                'expects' => [
                    [
                        $msgUpdate,
                        [
                            'field' => 'status',
                            'form' => 'ACTIVE',
                            'to' => 'INACTIVE',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'user_type',
                            'form' => 'REGULAR_USER',
                            'to' => 'ADMINISTRATOR',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'Attributes.given_name',
                            'form' => 'given_name1',
                            'to' => 'given_name2',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'Attributes.family_name',
                            'form' => 'family_name1',
                            'to' => 'family_name2',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'Attributes.middle_name',
                            'form' => 'middle_name1',
                            'to' => 'middle_name2',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'Attributes.nickname',
                            'form' => 'nickname1',
                            'to' => 'nickname2',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'Attributes.email',
                            'form' => 'email1@email1.com',
                            'to' => 'email2@email2.com',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'Attributes.phone_number',
                            'form' => 'phone_number1',
                            'to' => 'phone_number2',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'Attributes.department',
                            'form' => 'department1',
                            'to' => 'department2',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'Attributes.title',
                            'form' => 'title1',
                            'to' => 'title2',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'Attributes.address.street_address',
                            'form' => 'street_address1',
                            'to' => 'street_address2',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'Attributes.address.locality',
                            'form' => 'locality1',
                            'to' => 'locality2',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'Attributes.address.region',
                            'form' => 'region1',
                            'to' => 'region2',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'Attributes.address.postal_code',
                            'form' => 'postal_code1',
                            'to' => 'postal_code2',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'Attributes.address.country',
                            'form' => 'country1',
                            'to' => 'country2',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'CustomAttributes.custom_attributes1',
                            'form' => 'custom_attributes1v1',
                            'to' => 'custom_attributes1v2',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgUpdate,
                        [
                            'field' => 'CustomAttributes.custom_attributes2',
                            'form' => 'custom_attributes2v1',
                            'to' => 'custom_attributes2v2',
                            'action' => $msgUpdate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                ],
            ],
            'from empty' => [
                'in' => [
                    'msg' => $msgCreate,
                    'id' => $to['id'],
                    'from' => [ ],
                    'to' => $to,
                ],
                'expects' => [
                    [
                        $msgCreate,
                        [
                            'field' => 'status',
                            'form' => '',
                            'to' => 'INACTIVE',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'user_type',
                            'form' => '',
                            'to' => 'ADMINISTRATOR',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'Attributes.given_name',
                            'form' => '',
                            'to' => 'given_name2',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'Attributes.family_name',
                            'form' => '',
                            'to' => 'family_name2',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'Attributes.middle_name',
                            'form' => '',
                            'to' => 'middle_name2',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'Attributes.nickname',
                            'form' => '',
                            'to' => 'nickname2',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'Attributes.email',
                            'form' => '',
                            'to' => 'email2@email2.com',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'Attributes.phone_number',
                            'form' => '',
                            'to' => 'phone_number2',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'Attributes.department',
                            'form' => '',
                            'to' => 'department2',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'Attributes.title',
                            'form' => '',
                            'to' => 'title2',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'Attributes.address.street_address',
                            'form' => '',
                            'to' => 'street_address2',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'Attributes.address.locality',
                            'form' => '',
                            'to' => 'locality2',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'Attributes.address.region',
                            'form' => '',
                            'to' => 'region2',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'Attributes.address.postal_code',
                            'form' => '',
                            'to' => 'postal_code2',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'Attributes.address.country',
                            'form' => '',
                            'to' => 'country2',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'CustomAttributes.custom_attributes1',
                            'form' => '',
                            'to' => 'custom_attributes1v2',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgCreate,
                        [
                            'field' => 'CustomAttributes.custom_attributes2',
                            'form' => '',
                            'to' => 'custom_attributes2v2',
                            'action' => $msgCreate,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                ],
            ],
            'to empty' => [
                'in' => [
                    'msg' => $msgDetele,
                    'id' => $from['id'],
                    'from' => $from,
                    'to' => [ ],
                ],
                'expects' => [
                    [
                        $msgDetele,
                        [
                            'field' => 'status',
                            'form' => 'ACTIVE',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'user_type',
                            'form' => 'REGULAR_USER',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'Attributes.given_name',
                            'form' => 'given_name1',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'Attributes.family_name',
                            'form' => 'family_name1',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'Attributes.middle_name',
                            'form' => 'middle_name1',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'Attributes.nickname',
                            'form' => 'nickname1',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'Attributes.email',
                            'form' => 'email1@email1.com',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'Attributes.phone_number',
                            'form' => 'phone_number1',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'Attributes.department',
                            'form' => 'department1',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'Attributes.title',
                            'form' => 'title1',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'Attributes.address.street_address',
                            'form' => 'street_address1',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'Attributes.address.locality',
                            'form' => 'locality1',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'Attributes.address.region',
                            'form' => 'region1',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'Attributes.address.postal_code',
                            'form' => 'postal_code1',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'Attributes.address.country',
                            'form' => 'country1',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'CustomAttributes.custom_attributes1',
                            'form' => 'custom_attributes1v1',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                    [
                        $msgDetele,
                        [
                            'field' => 'CustomAttributes.custom_attributes2',
                            'form' => 'custom_attributes2v1',
                            'to' => '',
                            'action' => $msgDetele,
                            'userName' => $userName,
                            'subject' => $subject,
                            'client_id' => $client_id,
                            'tags' => [Audit::auditTag],
                        ],
                    ],
                ],
            ],
            'both empty' => [
                'in' => [
                    'msg' => $msgDetele,
                    'id' => $from['id'],
                    'from' => [ ],
                    'to' => [ ],
                ],
                'expects' => [ ],
            ],
        ];
    }

    /**
     * @dataProvider auditDataProvider
     * @param array $in
     * @param array $expects
     */
    public function testAudit(array $in, array $expects): void
    {
        call_user_func_array(
            [$this->logger->expects($this->exactly(count($expects)))->method('info'), 'withConsecutive'],
            $expects
        );

        $this->audit->audit($in['msg'], $in['id'], $in['from'], $in['to']);
    }
}
