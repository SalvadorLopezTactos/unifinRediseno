# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
# Copyright (C) SugarCRM Inc. All rights reserved.

@modules @portal_forgot_password
Feature: Portal user forgot password and reset password verification.
  As a Sugar portal user, I want the ability to reset my own password

  Scenario: Portal_forgot_password > verify that hide reset password if no outgoing email is configured
    Given Portal app is enabled
    Given Contacts records exist:
      | first_name | last_name |  portal_name | portal_password | portal_active |
      | Rene       | Bondi     |  Rene        | Rene            | True          |

    When I launch the Portal app
    Then I should not see a Forgot password link on the login page

  Scenario: Portal_forgot_password > verify that the email setting is configured on sugar base
    Given I launch the Sugar base app
    Given I am logged in
    When I go to email setting on admin page
    When I provide the input for email and save
    Then I should see the email setting configured

  Scenario: Portal_forgot_password > verify that user is able to reset password
    When I launch the Portal app
    Then I should see a Forgot password link on the login page
    When I click on the Forgot password link
    Then I verify message on the forgot password page
      | fieldName | value                                                                   |
      | message   | Enter your username and we will send you a link to reset your password. |
    When I provide input for forgot password page
      | portal_name |
      | Rene        |
    When I click on "Reset Password" button
    Then I verify message on the interstitial page
      | fieldName | value                                                                                           |
      | message   | Check your email We have sent password reset instructions to the email address we have on file. |
    And I should see a "Log In" link on the interstitial page
    And I should see a "Did not get an email?" link on the interstitial page

  Scenario: Portal_forgot_password > verify that user is able to reset password
    When I open email inbox of the primary email address of contact
    Then I should see a reset password email received
    When I open the password reset email
    When I click on the "Reset Password" link in the email
    And I verify message on the reset password page
      | fieldName | value                                              |
      | message   | Enter your password twice. Passwords must match.   |

    # There should be 2 links on the page
    And I should see "Log In" link on the page
    And I should see "Create Account" link on the page

    # If the two passwords do not match, then display error message
    When I provide input for the password fields
      | password | confirm_password |
      | Rene2    | Rene1            |
    When I click on "Reset Password" button
    Then I verify message on the reset password page
      | fieldName | value                                        |
      | message   | Passwords do not match, please enter again.  |

    # If the two reset passwords match, then back to login page
    When I provide input for the password fields
      | password | confirm_password |
      | Rene2    | Rene2            |
    When I click on "Reset Password" button
    Then I should see the portal login page

    # Use the reset password to login
    When I provide input on the login page
      | portal_name | password |
      | Rene        | Rene2    |
    Then I should see the portal homepage

  Scenario: Portal_forgot_password > verify that there should be three links on the Forgot Password page
    Given Portal app is enabled
    When I launch the Portal app
    When I click on the "Forgot Password" link on login page view
    Then a forgot password page is displayed
    And I should see "Forgot Username" link
    And I should see "Log In" link
    And I should see "Create Account" link

    # Log In - Click on this displays the log in page
    When I click on "Log In" link
    Then I should see the portal login page
    When I click on the "Forgot Password" link
    Then I should see the "Forgot Password" page

    # Create Account - Click on this displays the Sign up page
    When I click on "Create Account" link
    Then I should see the "Create Account" page
    When I click on back button on browser
    Then I should see the "Forgot Password" page

    # Forgot username - Click on this displays the "Contact us" page
    When I click on "Forgot Username" link
    Then I verify message on the contact us page
      | fieldName | value                                                               |
      | message   | For assistance, or to contact us, please use any of the following:  |
    When I click on "Log In" link
    Then I should see the portal login page

  Scenario: Portal_forgot_password > verify that contact us info is shown based on the setup in sugar base
    Given I launch the Sugar base app
    Given I am logged in
    When I go to Sugar portal on admin page
    And I click Configure Portal link
    When I provide input for Contact us on configure portal page
      | phone_number  | email         | url                 |
      | 408-111-1234  | admin@abc.com | https://www.abc.com |
    And I click Save button
    Then I verify fields for Contact us on configure portal page
      | fieldName    | value                 |
      | phone_number | 408-111-1234          |
      | email        | admin@abc.com         |
      | url          | https://www.abc.com   |

    Given Portal app is enabled
    When I launch the Portal app
    When I click on a Forgot password link on login page view
    When I click on "Forgot Username" link
    Then I verify message on the contact us page
      | fieldName | value                                                               |
      | message   | For assistance, or to contact us, please use any of the following:  |
    Then I verify fields on Contact us page
      | fieldName    | value                 |
      | phone_number | 408-111-1234          |
      | email        | admin@abc.com         |
      | url          | https://www.abc.com   |
