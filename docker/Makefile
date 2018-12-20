#!make
include .env
export $(shell sed 's/=.*//' .env)

bash-php: up
	docker-compose exec -u $(u) php bash

install: up
	docker-compose exec -u www-data php composer create-project symfony/website-skeleton ${PROJECT_NAME} 4

database-create: up

up:
	docker-compose up -d

build:
	docker-compose up -d --build

down:
	docker-compose down
