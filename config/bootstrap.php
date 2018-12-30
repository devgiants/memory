<?php

/**
 * Used for bootstrapping necessary things for testing
 */

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (!array_key_exists('APP_ENV', $_SERVER)) {
    $_SERVER['APP_ENV'] = $_ENV['APP_ENV'] ?? null;
}

if ('prod' !== $_SERVER['APP_ENV']) {
    if (!class_exists(Dotenv::class)) {
        throw new RuntimeException('The "APP_ENV" environment variable is not set to "prod". Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.');
    }

    (new Dotenv())->loadEnv( dirname( __DIR__ ) . '/.env' );
}

// For clearing cache prior to test
//if (isset($_ENV['BOOTSTRAP_CLEAR_CACHE_ENV'])) {
//    // executes the "php bin/console cache:clear" command
//    passthru(sprintf(
//        'APP_ENV=%s php "%s/../bin/console" cache:clear --no-warmup',
//        $_ENV['BOOTSTRAP_CLEAR_CACHE_ENV'],
//        __DIR__
//    ));
//}

require __DIR__.'/../vendor/autoload.php';

$_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = $_SERVER['APP_ENV'] ?: $_ENV['APP_ENV'] ?: 'dev';
$_SERVER['APP_DEBUG'] = $_SERVER['APP_DEBUG'] ?? $_ENV['APP_DEBUG'] ?? 'prod' !== $_SERVER['APP_ENV'];
$_SERVER['APP_DEBUG'] = $_ENV['APP_DEBUG'] = (int) $_SERVER['APP_DEBUG'] || filter_var($_SERVER['APP_DEBUG'], FILTER_VALIDATE_BOOLEAN) ? '1' : '0';
