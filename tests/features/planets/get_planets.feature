Feature: List planets

Scenario: Should exists URL
  Given I send a GET request to "/planets"
  Then the response status code should be 200

Scenario: Should fail when planets not exists
  Given The query parameter "name" is "Neptune"
  Given I send a GET request to "/planets"
  Then the response status code should be 404

Scenario: Should be successful when everything is correct
  Given The query parameter "name" is "Earth"
  Given I send a GET request to "/planets"
  Then the response status code should be 200
  Then the response content should be:
  """
  ["Earth"]
  """