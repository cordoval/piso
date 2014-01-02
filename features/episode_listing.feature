Feature: Listing the episodes of a show
  The list-episodes command should output a formatted list of episodes for the specified show

  Scenario: Show does not exist
    Given I do not have the show "Soap Opera" configured
     When I list the episodes for the show "Soap Opera"
     Then The output should contain "Unknown show"

  Scenario: Show with no episodes
    Given I have a configuration file containing
          """
          shows:
            Soap Opera: ~
          """
      And I have no files in the library
     When I list the episodes for the show "Soap Opera"
     Then The output should contain "No episodes found"

  Scenario: Files on disk
    Given I have a configuration file containing
          """
          shows:
            Soap Opera: ~
          """
      And I have the following files in the library
          | folder     | filename                |
          | Soap Opera | show.s02e01.awesome.mov |
          | Soap Opera | show.s02e02.cool.avi    |
          | Soap Opera | show.s03e02.cool.avi    |
    When I list the episodes for the show "Soap Opera"
    Then The output should contain "Season 2: Episodes 1,2"
     And The output should contain "Season 3: Episode 2"
