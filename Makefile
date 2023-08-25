SHELL := /bin/bash

tests:
	php bin/console doctrine:database:drop --force --if-exists --env=test || true
	php bin/console doctrine:database:create --env=test
	php bin/console doctrine:migrations:migrate -n --env=test
	php bin/console doctrine:fixtures:load -n --env=test
	php -d xdebug.mode=coverage bin/phpunit --coverage-clover clover.xml $(MAKECMDGOALS)
.PHONY: tests
