Feature: View order list
  To view existing orders
  As a API client
  I need to be able to get order list

  Background:
    Given  orders exist

  Scenario: GET vendor list
    Given I send a "GET" request to "/orders"
    #Then the response should be empty
    And the response status code should be 200
    And the response should be in JSON
    And the JSON node "results" should have "5" element
    And the JSON node "results[0].id" should be equal to the number "11"
    And the JSON node "results[1].id" should be equal to the number "10"
    And the JSON node "results[2].id" should be equal to the number "9"
    And the JSON node "results[3].id" should be equal to the number "8"
    And the JSON node "results[4].id" should be equal to the number "7"
    And the JSON node "total" should be equal to the number "11"
    And the JSON nodes should be equal to:
      | results[0].email | ten@boozt.com  |
      | results[1].email | nine@boozt.com |
      | results[2].email | six@boozt.com  |
      | results[3].email | five@boozt.com |
      | results[4].email | five@boozt.com |
