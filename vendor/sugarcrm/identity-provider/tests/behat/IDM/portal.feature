@login @idm @portal
Feature: User can login to portal if access is permitted.
  Scenario: Access granted
    Given I logged in SugarCRM as administrator
    When I create contact portal with password Admin123!b and grant access to portal
    And I logout
    And I am on portal login page
    And I login to portal as portal with password Admin123!b
    And I accept use cookies in portal
    Then I should logged in portal
    And I logout portal

  Scenario: Access denied
    Given I logged in SugarCRM as administrator
    When I create contact dportal with password Admin123!b and deny access to portal
    And I logout
    And I am on portal login page
    And I login to portal as dportal with password Admin123!b
    Then I should see message "Invalid Credentials"
