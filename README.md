[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/devgiants/memory/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/devgiants/livebox/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/devgiants/memory/badges/build.png?b=master)](https://scrutinizer-ci.com/g/devgiants/livebox/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/devgiants/memory/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

# Memory Game

## Quick presentation

This is a __memory game__ implementation example, using following stack :
- Symfony 4
- Doctrine with MySQL database
- Twig (using Encore Webpack)

## Features

The app allow following use cases :
- Landing page presentation, to allow start a new game or see past games list.
- Play new game, with configured time allowed (180s)

## Setup

### Using Docker

1. Make sure you have `docker` and `docker-compose`installed and usable by your system user.
2. Go in the `docker` directory
3. Change `docker/.env` file variables to suit your needs. You just have to update your user name, UID and GID. _This is to ensure your host user will have the rights to edit files inside containers._
4. Run `make build` that will : 
   1. Build containers.
   2. Install PHP dependencies with `Composer`.
   3. Create database scheme (it will use `./.env` file settings).
   4. Install JS dependencies with `yarn`.

After that, app will be available on `localhost:8900`. PHPMyAdmin instance on `localhost:8901` 

### Directly
If you don't use `docker`, you must have a LAMP server live (Linux, Apache 2.4, MySQL 5.7, PHP 7.2). _PHP must have `pdo` and `pdo_mysql` modules installed._ 

Then, follow this steps to complete your stack:
- Install `composer`
- Install `nodejs` for your distro (11+)
- Install `yarn`

Finally, you can bring the project live by doing those steps (done in the project root)
1. `composer install`
2. `php bin/console doctrine:migrations:diff`
3. `php bin/console doctrine:migrations:migrate`
4. `yarn config set global-folder ~/.yarn`
5. `yarn config set cache-folder ~/.yarn`
6. `yarn install`
7. `yarn encore production`

You must then add a vhost to link with the project, and access to the game with the domain you configured.

## Configuration
`config/services.yaml` contains several parameters you can change :
- `available_cards` that defines [CSS classes](https://github.com/devgiants/memory/blob/master/assets/scss/_game.scss#L44) related to `assets/images/cards.png`
- `game_time` that defines time available to finish the game.

## Tests
I initiated some automated tests (very few). 

To run test suite, just do `./bin/phpunit --coverage-html public/coverage`. This command must be executed on project root if you installed it directly, or inside `docker` app container (go in `docker/` folder then execute `make bash-php` to get quick access).

Coverage report will be accessible on `/coverage/index.html`.

## TODO
Tons of things stay untouched :
- Create a dedicated test database 