Feature: Listing the configured shows
  The list-shows command should output a formatted list of all shows the utility is configured to deal with

  Scenario: Listing with no configured shows
    Given I have a configuration file with no shows
     When I run the "list-shows" command
     Then The output should contain "No configured shows"

  Scenario: Listing the shows from the config file
    Given I have a configuration file containing
          """
          shows:
            Soap Opera : ~
            Police Procedural : ~
          """
     When I run the "list-shows" command
     Then The output should contain "Soap Opera"
      And The output should contain "Police Procedural"