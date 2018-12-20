#!make
include .env
export $(shell sed 's/=.*//' .env)

bash-php: up
	docker-compose exec -u www-data php bash

bash-php-root: up
	docker-compose exec php bash

install: build
	docker-compose exec -u www-data php composer install
	docker-compose exec -u www-data php yarn config set global-folder ${YARN_GLOBAL_FOLDER}
	docker-compose exec -u www-data php yarn config set cache-folder ${YARN_CACHE_FOLDER}
	docker-compose exec -u www-data php yarn install
	docker-compose exec -u www-data php yarn encore production

encore-dev: up
	docker-compose exec -u www-data php yarn encore dev

encore-prod: up
	docker-compose exec -u www-data php yarn encore prod

encore-watch: up
	docker-compose exec -u www-data php yarn encore dev --watch

up:
	docker-compose up -d

build:
	docker-compose up -d --build

down:
	docker-compose down
