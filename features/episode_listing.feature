Feature: Listing the episodes of a show
  The list-episodes command should output a formatted list of episodes for the specified show

  Scenario: Show does not exist
    Given I do not have the show "Soap Opera" configured
     When I list the episodes for the show "Soap Opera"
     Then The output should contain "Unknown show"
