# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
# Copyright (C) SugarCRM Inc. All rights reserved.

@modules @portal_user_provisioning
Feature: Portal user signup and login verification.
  As a Sugar portal user, I need to be able to sign up and create new account,
  login to portal with new created user name and password.

  Scenario: Portal_user_provisioning > verify that new portal user is able to sign up and create account
    Given Portal app is enabled
    Given I launch the Portal app
    Given I open the Portal login page view

    When click "Create Account" link on portal login page
    When I provide input for "create account" view
      | *first_name | last_name | company_name | email         | portal_name | password | confirm_password |
      | Rene        | Bondi     | ABC          | rene@abc.com  | Rene        | Rene     | Rene             |
    When I click "Create Account" button on create account page view
    Then I verify message on an interstitial page
      | fieldName | value                                                                      |
      | message   | Thank you for signing up We will inform you after we confirm your details. |

    When I click "log In" link
    Then I should see the portal login page

  Scenario: Portal_user_provisioning > Verify that new contact record is created after new portal user is signed up
    Given I launch App
    Given I am logged in

    When I choose Contacts in modules menu
    Then I should see #ContactsList.ListView view
    When I select *Rene in #ContactsList.ListView
    Then I should see #ReneRecord view
    Then I verify fields on the Contact Record view
      | fieldName                 | value         |
      | name                      | Rene Bondi    |
      | email                     | rene@abc.com  |
      | portal_user_company_name  | ABC           |
      | portal_name               | Rene          |
      | portal_active             | false         |

  Scenario: Portal_user_provisioning > verify that if username already exists for portal, then signup will fail
    Given Portal app is enabled
    Given I launch the Portal app

    When I click "Create Account" link on portal login page view
    When I provide input for "create account" view
      | first_name | last_name | company_name | email         | portal_name | password | confirm_password |
      | Rene       | Bondi     | ABC          | rene@abc.com  | Rene        | Rene     | Rene             |
    When I click "Create Account" button on create account page view
    Then I verify message on the create account page
      | fieldName | value                                                                                                         |
      | message   | Username is already registered in the system. Either request a forgotten password or select another username. |

  Scenario: Portal_user_provisioning > verify that if the portal username is not activated, then login will fail
    Given Portal app is enabled
    Given I launch the Portal app
    When I provide input for portal login page view
      | portal_name | password |
      | Rene        | Rene     |

    # If the portal is not activated for the user name
    Then I verify message on login page
      | fieldName | value                                                                |
      | message   | Invalid Credentials Your login was not successful. Please try again. |

  Scenario: Portal_user_provisioning > verify that activate a new portal user
    Given I launch the Sugar base app
    Given I am logged in

    When I choose Contacts in modules menu
    Then I should see #ContactsList.ListView view
    When I select *Rene in #ContactsList.ListView
    Then I should see #ReneRecord view
    When I provide input for #ReneRecord.RecordView view
      | *    | portal_active  |
      | Rene | true           |
    When I click Save button on #ContactsRecord header
    When I close alert

    Then I verify fields on the Contact Record view
      | fieldName      | value   |
      | portal_active  | true    |

  Scenario: Portal_user_provisioning > verify that portal user is able to login
    Given I launch the Portal app

    # If portal user name and password do not match
    When I provide input for portal login page view
      | portal_name | password |
      | Rene        | Rene1    |
    Then I verify message on login page
      | fieldName | value                                                                |
      | message   | Invalid Credentials Your login was not successful. Please try again. |

    # If portal user name and password match
    When I provide input for portal login page view
      | portal_name | password |
      | Rene        | Rene     |
    Then I should see the portal home page and Home Dashboard

