init:
	make reset
	composer install
	npm install
	make yarn-watch

create-db:
	php bin/console d:d:c --if-not-exists
	php bin/console d:s:u --force
	make load-fixtures

load-fixtures:
	php bin/console d:f:l --no-interaction

reset:
	php bin/console d:d:d --force
	make create-db

yarn-watch:
	yarn encore dev --watch