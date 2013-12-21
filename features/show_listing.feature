Feature: Listing the configured shows
  The list command should output a formatted list of all shows the utility is configured to deal with

  Scenario: Listing with no configured shows
    Given I have a configuration file with no shows
     When I run the command with the "list" command
     Then I should see the output "No configured shows"

