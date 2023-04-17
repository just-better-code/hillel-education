<?php

require_once __DIR__.'/../vendor/autoload.php';

use Kulinich\Hillel\App;
use Kulinich\Hillel\Foundation\Config;
use Kulinich\Hillel\Foundation\DI\Container;
use Kulinich\Hillel\UrlCompressor\Contracts\IUrlDecoder;

require_once __DIR__.'/../vendor/autoload.php';
$configData = require_once __DIR__ . '/../config/app.php';
$config = new Config($configData);
$container = new Container($config->get('containers'));

/** @var App $app */
$app = $container->get(App::class);
$decoder = $container->get(IUrlDecoder::class);

$code = readline('Put code to decode: ');
$url = $app->runDecode($decoder, $code);
echo "Url is: $url" . PHP_EOL;
