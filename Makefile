test:
	docker-compose run --rm php81 phpunit
psalm:
	docker-compose run --rm php81 ./vendor/bin/psalm

modules:
	docker-compose run --rm php81 php -m

rebuild:
	docker-compose build --no-cache php81

.PHONY: test, psalm, modules, rebuild