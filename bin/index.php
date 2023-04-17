<?php

use Kulinich\Hillel\Foundation\Config;
use Kulinich\Hillel\Foundation\DI\Container;

require_once __DIR__.'/../vendor/autoload.php';
$configData = require_once __DIR__ . '/../config/app.php';
$config = new Config($configData);
$container = new Container($config->get('containers'));

$logger = $container->get(\Psr\Log\LoggerInterface::class);

$dbFilename = $config['db']['filename'] ?? '';
$logFilename = $config['log']['filename'] ?? '';

$fileHandler = new StreamHandler($logFilename);
$consoleHandler = new StreamHandler('php://stdout');
$logger = new Logger('URL decoder', [$fileHandler, $consoleHandler]);

$algorithm = new Murmur3ARebased64Algorithm();
$storage = new FileStorage($dbFilename, $logger);
$decoder = new UrlDecoder($storage, $algorithm, $logger);
$app = new App($logger);

$code = readline('Put code to decode: ');
$url = $app->runDecode($decoder, $code);
echo "Url is: $url" . PHP_EOL;
