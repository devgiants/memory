#!make
include .env
export $(shell sed 's/=.*//' .env)

# Provides a bash in PHP container (user www-data)
bash-php: up
	docker-compose exec -u www-data php bash

# Provides a bash in PHP container (user root)
bash-php-root: up
	docker-compose exec php bash

# Build app
install: build
	# Install PHP dependencies
	docker-compose exec -u www-data php composer install

	# Create database scheme
	docker-compose exec -u www-data php php bin/console doctrine:migrations:diff
	docker-compose exec -u www-data php php bin/console doctrine:migrations:migrate

	# Configure Yarn storage
	docker-compose exec -u www-data php yarn config set global-folder ${YARN_GLOBAL_FOLDER}
	docker-compose exec -u www-data php yarn config set cache-folder ${YARN_CACHE_FOLDER}

	# Install Yarn dependencies
	docker-compose exec -u www-data php yarn install

	# Compile application assets
	docker-compose exec -u www-data php yarn encore production

# Build front assets in dev mode (no minifying...)
encore-dev: up
	docker-compose exec -u www-data php yarn encore dev

# Build front assets in prod mode (minifying...)
encore-prod: up
	docker-compose exec -u www-data php yarn encore production

# Start Encore in watch mode, re-compiling on each change
encore-watch: up
	docker-compose exec -u www-data php yarn encore dev --watch

# Migrate database with differences
migration: up
	docker-compose exec -u www-data php php bin/console doctrine:migrations:diff
	docker-compose exec -u www-data php php bin/console doctrine:migrations:migrate

# Up containers
up:
	docker-compose up -d

# Up containers, with build forced
build:
	docker-compose up -d --build

# Down containers
down:
	docker-compose down
