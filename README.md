Initial steps to have project running
----
```
composer install
```
For dev env:
```
bin/console doctrine:database:create --env=dev
bin/console doctrine:schema:create --env=dev
```
Fro test/behat env:
```
bin/console doctrine:database:create --env=test
bin/console doctrine:schema:create --env=test
```
Run behat:
```
vendor/bin/behat
```
Less detailed way:
```
vendor/bin/behat --stop-on-failure --format=progress
```
Task 1:
-----
Add pagination test scenarios to `list.feature` 

Task 2:
-----
Add `details.feature` to cover GET `/orders/{id}` endpoint

- Add mocks for `order_item` table, I would advise to have them inserted with generic `orders exist` context
- Add `details.feature` with scenario for get order endpoint

Task 3:
-----
Add `create.feature` to cover POST `/orders` endpoint

- Add `create.feature` with scenario for POST order successfully and check that id returned.
- Add new context step to have check that new order is saved to database
- Add new context step to have check that order has values as expected
- Add invalid data submit scenario which would check that 400 status code and errors returned

Task 4 (optional):
-----
Add `update.feature` to cover POST `/orders` endpoint

Needs similar cases as `create.feature` and code is not working fully :D 
The idea for last task is cover endpoints with tests and fix it afterwards
