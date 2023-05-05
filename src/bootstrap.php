<?php

require_once __DIR__.'/../vendor/autoload.php';

use Kulinich\Hillel\App;
use Kulinich\Hillel\Foundation\Config;
use Kulinich\Hillel\Foundation\DI\Container;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$configData['services'] = require_once __DIR__ . '/../config/services.php';
$config = new Config($configData);
$container = new Container($config->get('services'));
App::init($container, $config);