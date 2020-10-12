# Your installation or use of this SugarCRM file is subject to the applicable
# terms available at
# http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
# If you do not agree to all of the applicable terms or do not have the
# authority to bind the entity as an authorized representative, then do not
# install or use this SugarCRM file.
# Copyright (C) SugarCRM Inc. All rights reserved.

Feature: Portal Self Service Case Deflection verification

  Background:
    Given Portal App is enabled
    Given I launch Portal App

  Scenario: Case deflection is enabled
    # Generate KB articles
    Given Case Deflection is enabled
    Given KBContents records exist:
      | *    | name      | kbdocument_body                   |
      | KB_1 | Article 1 | internet is down                  |
      | KB_2 | Article 2 | print the file from your computer |

    Given Contacts records exist:
      | first_name | last_name |  portal_name | password | portal_active |
      | Rene       | Bondi     |  Rene        | Rene     | True          |

    Given I open Home view and log in to Portal

    # Verify appropriate message and search box is displayed
    Then I verify message on #Dashlet.ContentView
      | fieldName | value                                         |
      | message   | What can we help you with today, Rene Bondi?  |
    Then I verify search box on #Dashlet.ContentView exists

    # Verify KB search result returned correctly when search term is matched
    When I search for "internet is down" in search box on #Dashlet.ContentView
    And I hit Enter
    And there are search results found
    Then for each search item I should see the following
    Title of article
    (Up to) first 500 characters, chopping off only at word boundaries, that contain the first search term
    When I click the search result "Article 1"
    Then it should open a new tab that displays the "Article 1"

    # Assume each page shows 8 matched results
    When the search results return more than 8 on search results
    Then I should able to see pagination

    When I click on the next page icon on search results
    Then I should able to see more search results

    When I click on the previous page icon on search results
    Then I should able to see previous search results

    # Verify the create case link exists
    Then I verify message on the bottom of search result
      | fieldName | value                                                |
      | message   | Didn't find what you are looking for? Create a case. |

    When I click on Create a case link from message
    Then create a case view is open
    And Subject field is prefilled with "internet is down" in create case view

    # Create a case
    When I click save in create case view
    When I choose Cases in modules menu
    When I search for "internet is down" in Cases list view
    Then I should see new Case record created and shown in list view

    # Navigate back to Home Dashboard
    When I choose Home in modules menu

    # Verify when no results are found
    When I search for "resetting the device" in search box on #Dashlet.ContentView
    And I hit Enter
    And there are no search results found

    # Verify no results found message is diplayed
    Then I verify message on #Dashlet.ContentView
      | fieldName | value                                      |
      | message   | No results were found for your search term |

    # Verify the create case link exists
    Then I verify message on the bottom of search result
      | fieldName | value                                                |
      | message   | Didn't find what you are looking for? Create a case. |

    When I click on Create a case link from message
    Then create a case view is open
    And Subject field is prefilled with "resetting the device" in create case view

    # Create a case
    When I click save in create case view
    When I choose Cases in modules menu
    When I search for "resetting the device" in Cases list view
    Then I should see new Case record created and shown in list view

  Scenario: Case deflection is disabled
    Given Case Deflection is disabled
    Given I open Home view and log in to Portal

    # Verify appropriate message is displayed in the dashlet
    Then I verify message on #Dashlet.ContentView
      | fieldName | value                                                 |
      | message   | Welcome, Rene Bondi, Would you like to create a case? |

    When I click on Create a case link from message
    Then create a case view is open

    # Create a case
    When I provide input for create case view
      | fieldName | value                |
      | subject   | resetting the device |
    When I click save in create case view
    When I choose Cases in modules menu
    When I search for "resetting the device" in Cases list view
    Then I should see new Case record created and shown in list view
