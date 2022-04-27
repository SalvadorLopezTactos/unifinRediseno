# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.
@login @rest @userMapping
Feature: Checks credentials for the user and replies.

  Scenario: Check unauthenticated request
    Given I send a POST request to "authenticate" with body:
     """
        tid=srn:cloud:iam:eu:2000000001:tenant&user_name=user2&password=user2pass
     """
    Then the JSON should be equal to:
        """
        {"status":"error", "error":"Empty Authorization token received"}
        """
    And the response status code should be 401

  Scenario: Check request with invalid token scope
    Given I get access_token for "offline" scope
    Then I add access_token to header
    Then I send a POST request to "authenticate" with body:
     """
        tid=srn:cloud:iam:eu:2000000001:tenant&user_name=user2&password=user2pass
     """
    Then the JSON should be equal to:
        """
        {"status":"error","error":"Invalid scope"}
        """
    And the response status code should be 401

  Scenario Outline: Send authenticated requests and check responses
    Given I get access_token for "<scope>" scope
    Then I add access_token to header
    Then I send a POST request to "authenticate" with body:
        """
        <request>
        """
    Then the JSON should be equal to:
        """
        <result>
        """
    And the response status code should be <statusCode>
    Examples:
      | request                                                                           | scope                                       | statusCode | result                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
      |                                                                                   | https://apis.sugarcrm.com/auth/iam.password | 401        | {"status":"error","error":"Field tid is required. Field user_name is required. Field password is required."}                                                                                                                                                                                                                                                                                                                                                                                                                            |
      | tid=                                                                              | https://apis.sugarcrm.com/auth/iam.password | 401        | {"status":"error","error":"Field tid is required. Field user_name is required. Field password is required."}                                                                                                                                                                                                                                                                                                                                                                                                                            |
      | tid=&user_name=                                                                   | https://apis.sugarcrm.com/auth/iam.password | 401        | {"status":"error","error":"Field tid is required. Field user_name is required. Field password is required."}                                                                                                                                                                                                                                                                                                                                                                                                                            |
      | tid=&user_name=&password=                                                         | https://apis.sugarcrm.com/auth/iam.password | 401        | {"status":"error","error":"Field tid is required. Field user_name is required. Field password is required."}                                                                                                                                                                                                                                                                                                                                                                                                                            |
      | tid=tid&user_name=user_name                                                       | https://apis.sugarcrm.com/auth/iam.password | 401        | {"status":"error","error":"Field password is required."}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
      | tid=invalid-tid&user_name=invalidUser&password=invalidPass                        | https://apis.sugarcrm.com/auth/iam.password | 401        | {"status":"error","error":"APP ERROR: Tenant not found"}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
      | tid=srn:cloud:iam:eu:0000000000:tenant&user_name=invalidUser&password=invalidPass | https://apis.sugarcrm.com/auth/iam.password | 401        | {"status":"error","error":"APP ERROR: Tenant not found"}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
      | tid=srn:cloud:iam:eu:2000000001:tenant&user_name=invalidUser&password=invalidPass | https://apis.sugarcrm.com/auth/iam.password | 401        | {"status":"error","error":"Invalid credentials"}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        |
      | tid=srn:cloud:iam:us:2000000001:tenant&user_name=user1&password=user1pass         | https://apis.sugarcrm.com/auth/iam.password | 200        | {"status":"success","user":{"sub":"srn:cloud:iam::2000000001:user:6f1f6421-6a77-409d-8a59-76308ee399df","id_ext":{"preferred_username":"user1","created_at":1519227589,"updated_at":1519227589,"locale":"en-US","status":"0","user_type":"0","family_name":"user1","email":"user1@ex.com","tid":"srn:cloud:iam:us:2000000001:tenant"}}}                                                                                                                                                                                                 |
      | tid=srn:cloud:iam:eu:2000000001:tenant&user_name=user3&password=user3pass         | https://apis.sugarcrm.com/auth/iam.password | 401        | {"status":"error","error":"Invalid credentials"}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        |
      | tid=srn:cloud:iam:eu:2000000001:tenant&user_name=sally&password=sally             | https://apis.sugarcrm.com/auth/iam.password | 200        | {"status":"success","user":{"sub":"srn:cloud:iam::2000000001:user:seed_sally_id","id_ext":{"preferred_username":"sally","created_at":1519227589,"updated_at":1519227589,"locale":"en-US","status":"0","user_type":"0","given_name":"sally","family_name":"sally_family","nickname":"max","email":"sally@example.lh","phone_number":"+1234567890","address":{"street_address":"teststreet","locality":"testlocality","region":"testregion","postal_code":"123456","country":"testcountry"},"tid":"srn:cloud:iam:eu:2000000001:tenant"}}} |
      | tid=2000000001&user_name=sally&password=sally                                     | https://apis.sugarcrm.com/auth/iam.password | 200        | {"status":"success","user":{"sub":"srn:cloud:iam::2000000001:user:seed_sally_id","id_ext":{"preferred_username":"sally","created_at":1519227589,"updated_at":1519227589,"locale":"en-US","status":"0","user_type":"0","given_name":"sally","family_name":"sally_family","nickname":"max","email":"sally@example.lh","phone_number":"+1234567890","address":{"street_address":"teststreet","locality":"testlocality","region":"testregion","postal_code":"123456","country":"testcountry"},"tid":"srn:cloud:iam:eu:2000000001:tenant"}}} |
      | tid=2000000001&user_name=sally&password=sally                                     | https://apis.sugarcrm.com/auth/iam.password | 200        | {"status":"success","user":{"sub":"srn:cloud:iam::2000000001:user:seed_sally_id","id_ext":{"preferred_username":"sally","created_at":1519227589,"updated_at":1519227589,"locale":"en-US","status":"0","user_type":"0","given_name":"sally","family_name":"sally_family","nickname":"max","email":"sally@example.lh","phone_number":"+1234567890","address":{"street_address":"teststreet","locality":"testlocality","region":"testregion","postal_code":"123456","country":"testcountry"},"tid":"srn:cloud:iam:eu:2000000001:tenant"}}} |
      | tid=srn:cloud:iam:eu:2000000001:tenant&user_name=admin&password=admin             | https://apis.sugarcrm.com/auth/iam.password | 200        | {"status":"success","user":{"sub":"srn:cloud:iam::2000000001:user:1","id_ext":{"preferred_username":"admin","created_at":1519227589,"updated_at":1519227589,"locale":"en-US","status":"0","user_type":"1","tid":"srn:cloud:iam:eu:2000000001:tenant"}}}                                                                                                                                                                                                                                                                                 |
      | tid=srn:cloud:iam:eu:2000000001:tenant&user_name=abey&password=abey               | https://apis.sugarcrm.com/auth/iam.password | 200        | {"status":"success","user":{"sub":"srn:cloud:iam::2000000001:user:8cefa54e-4567-4073-bc1e-c97e4d6eba9e","id_ext":{"preferred_username":"abey","created_at":1519227589,"updated_at":1519227589,"locale":"en-US","status":"0","user_type":"0","family_name":"abey","email":"abey@ex.com","tid":"srn:cloud:iam:eu:2000000001:tenant"}}}                                                                                                                                                                                                    |
      | tid=srn:cloud:iam:us:2000000001:tenant&user_name=user1&password=user1pass         | idp.auth.password                           | 200        | {"status":"success","user":{"sub":"srn:cloud:iam::2000000001:user:6f1f6421-6a77-409d-8a59-76308ee399df","id_ext":{"preferred_username":"user1","created_at":1519227589,"updated_at":1519227589,"locale":"en-US","status":"0","user_type":"0","family_name":"user1","email":"user1@ex.com","tid":"srn:cloud:iam:us:2000000001:tenant"}}}                                                                                                                                                                                                 |
      | tid=srn:cloud:iam:eu:2000000001:tenant&user_name=sally&password=sally             | idp.auth.password                           | 200        | {"status":"success","user":{"sub":"srn:cloud:iam::2000000001:user:seed_sally_id","id_ext":{"preferred_username":"sally","created_at":1519227589,"updated_at":1519227589,"locale":"en-US","status":"0","user_type":"0","given_name":"sally","family_name":"sally_family","nickname":"max","email":"sally@example.lh","phone_number":"+1234567890","address":{"street_address":"teststreet","locality":"testlocality","region":"testregion","postal_code":"123456","country":"testcountry"},"tid":"srn:cloud:iam:eu:2000000001:tenant"}}} |
      | tid=2000000001&user_name=sally&password=sally                                     | idp.auth.password                           | 200        | {"status":"success","user":{"sub":"srn:cloud:iam::2000000001:user:seed_sally_id","id_ext":{"preferred_username":"sally","created_at":1519227589,"updated_at":1519227589,"locale":"en-US","status":"0","user_type":"0","given_name":"sally","family_name":"sally_family","nickname":"max","email":"sally@example.lh","phone_number":"+1234567890","address":{"street_address":"teststreet","locality":"testlocality","region":"testregion","postal_code":"123456","country":"testcountry"},"tid":"srn:cloud:iam:eu:2000000001:tenant"}}} |
      | tid=2000000001&user_name=sally&password=sally                                     | idp.auth.password                           | 200        | {"status":"success","user":{"sub":"srn:cloud:iam::2000000001:user:seed_sally_id","id_ext":{"preferred_username":"sally","created_at":1519227589,"updated_at":1519227589,"locale":"en-US","status":"0","user_type":"0","given_name":"sally","family_name":"sally_family","nickname":"max","email":"sally@example.lh","phone_number":"+1234567890","address":{"street_address":"teststreet","locality":"testlocality","region":"testregion","postal_code":"123456","country":"testcountry"},"tid":"srn:cloud:iam:eu:2000000001:tenant"}}} |
      | tid=srn:cloud:iam:eu:2000000001:tenant&user_name=admin&password=admin             | idp.auth.password                           | 200        | {"status":"success","user":{"sub":"srn:cloud:iam::2000000001:user:1","id_ext":{"preferred_username":"admin","created_at":1519227589,"updated_at":1519227589,"locale":"en-US","status":"0","user_type":"1","tid":"srn:cloud:iam:eu:2000000001:tenant"}}}                                                                                                                                                                                                                                                                                 |
      | tid=srn:cloud:iam:eu:2000000001:tenant&user_name=abey&password=abey               | idp.auth.password                           | 200        | {"status":"success","user":{"sub":"srn:cloud:iam::2000000001:user:8cefa54e-4567-4073-bc1e-c97e4d6eba9e","id_ext":{"preferred_username":"abey","created_at":1519227589,"updated_at":1519227589,"locale":"en-US","status":"0","user_type":"0","family_name":"abey","email":"abey@ex.com","tid":"srn:cloud:iam:eu:2000000001:tenant"}}}                                                                                                                                                                                                    |

  Scenario: Check mapping for LDAP attributes
    Given I get access_token for "https://apis.sugarcrm.com/auth/iam.password" scope
    Then I add access_token to header
    Then I send a POST request to "authenticate" with body:
        """
        tid=srn:cloud:iam:eu:2000000001:tenant&user_name=david&password=david
        """
    Then the response status code should be 200
    Then the JSON node "status" should be equal to "success"
    Then the JSON node "user.id_ext.preferred_username" should be equal to "david"
    Then the JSON node "user.id_ext.given_name" should be equal to "David"
    Then the JSON node "user.id_ext.family_name" should be equal to "Olliver"
    Then the JSON node "user.id_ext.email" should be equal to "david@example.com"
    Then the JSON node "user.id_ext.phone_number" should be equal to "315-565-3072"
    Then the JSON node "user.id_ext.tid" should be equal to "srn:cloud:iam:eu:2000000001:tenant"
    Then the JSON node "user.id_ext.address.street_address" should be equal to "Wall Street"
    Then the JSON node "user.id_ext.address.locality" should be equal to "NYC"
    Then the JSON node "user.id_ext.address.region" should be equal to "NY"
    Then the JSON node "user.id_ext.address.postal_code" should be equal to "11219"
