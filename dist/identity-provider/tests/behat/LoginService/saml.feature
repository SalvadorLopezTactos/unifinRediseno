# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
#
# Copyright (C) SugarCRM Inc. All rights reserved.

@loginService @login @saml
Feature: SAML
  SAML login form. New SAML user tries to login if provision is enabled
  Regular login form. SAML user tries to login
  SAML login form. Can switch to regular login form and login as local user
  User sees an error in case of empty tenant
  User sees an error in case of invalid tenant
  User sees an error in case of tenant with not configured SAML
  User sees an error in case of tenant with wrong configured SAML
  SAML disabled user tries to login if provision is enabled

  Scenario: SAML login form. New SAML user tries to login if provision is enabled
    Given I am on "/?tenant_hint=srn:cloud:iam:eu:2000000004:tenant"
    Then I wait for the element "a[name=external_login_button]"
    Then I click "a[name=external_login_button]"
    Then I wait for the page to be loaded
    Then I should see "Enter your username and password"
    When I fill in "user5" for "username"
    And I fill in "user5pass" for "password"
    And I press "Login"
    Then I should see "user5@example.com"
    And I should see "You are logged in"
    Then I should see "Authentication provider - Saml"
    Then I click "#logout_btn"
    And I should see a "#tenant_hint" element
    And the "tenant_hint" field should contain "2000000004"

  Scenario: SAML login form. SAML disabled user tries to login if provision is enabled
    Given I am on "/?tenant_hint=srn:cloud:iam:eu:2000000004:tenant"
    Then I wait for the element "a[name=external_login_button]"
    Then I click "a[name=external_login_button]"
    Then I wait for the page to be loaded
    Then I should see "Enter your username and password"
    When I fill in "user8" for "username"
    And I fill in "user8pass" for "password"
    And I press "Login"
    Then I should see "User account is disabled"
    And I should see "Show log in form"
    Then I am on "/saml/logout/init"

  Scenario: Regular login form. SAML user tries to login
    Given I am on "/"
    Then I wait for the element "input[name=tenant_hint]"
    Then I fill in "tenant_hint" with "srn:cloud:iam:eu:2000000004:tenant"
    And I click "input[type=submit]"
    Then I wait for the element "a[name=external_login_button]"
    Then I click "a[name=external_login_button]"
    Then I wait for the page to be loaded
    Then I should see "Enter your username and password"
    When I fill in "user5" for "username"
    And I fill in "user5pass" for "password"
    And I press "Login"
    Then I should see "user5@example.com"
    And I should see "You are logged in"
    Then I should see "Authentication provider - Saml"
    Then I click "#logout_btn"

  Scenario: SAML login form. Can switch to regular login form and login as local user
    Given I am on "/?tenant_hint=srn:cloud:iam:eu:2000000004:tenant"
    Then I wait for the element "a[name=login_form_button]"
    Then I click "a[name=login_form_button]"
    Then I wait for the element "input[name=user_name]"
    Then I should not see "Tenant"
    And I should not see a "#tid" element
    When I fill in "user_name" with "sally"
    When I fill in "password" with "sally"
    Then I click "#submit_btn"
    And I wait for the page to be loaded
    Then I should see "You are logged in as sally"
    Then I should see "Your tenant id is srn:cloud:iam:eu:2000000004:tenant"
    Then I should see "Authentication provider - Local"
    Then I do logout

  Scenario: User sees an error in case of tenant with wrong configured SAML
    Given I am on "/?tenant_hint=srn:cloud:iam:eu:2000000005:tenant"
    Then I wait for the element "a[name=external_login_button]"
    Then I click "a[name=external_login_button]"
    Then I wait for the page to be loaded
    Then I should see "Enter your username and password"
    When I fill in "user1" for "username"
    And I fill in "user1pass" for "password"
    And I press "Login"
    Then I wait for the page to be loaded
    And I should not see "You are logged in"
    And I should see "Login using SAML"
    And I should see a "#sso_btn" element
    And I go to "/logout"
