<?php

use Kulinich\Hillel\App;
use Kulinich\Hillel\Foundation\Config;
use Kulinich\Hillel\Foundation\DI\Container;
use Kulinich\Hillel\UrlCompressor\Contracts\IUrlEncoder;

require_once __DIR__.'/../vendor/autoload.php';
$configData = require_once __DIR__ . '/../config/app.php';
$config = new Config($configData);
$container = new Container($config->get('containers'));

/** @var App $app */
$app = $container->get(App::class);
$encoder = $container->get(IUrlEncoder::class);

$url = readline('Put url to encode: ');
$code = $app->runEncode($encoder, $url);
echo "Url code is: $code" . PHP_EOL;
