test:
	docker-compose run --rm php81 phpunit

modules:
	docker-compose run --rm php81 php -m

rebuild:
	docker-compose build --no-cache php81

.PHONY: test, modules, rebuild