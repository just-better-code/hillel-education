<?php

require_once __DIR__.'/../vendor/autoload.php';

use Kulinich\Hillel\App;
use Kulinich\Hillel\UrlCompressor\Algorithms\Murmur3ARebased64Algorithm;
use Kulinich\Hillel\UrlCompressor\Storages\FileStorage;
use Kulinich\Hillel\UrlCompressor\UrlDecoder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$config = require_once __DIR__ . '/../config/app.php';
$dbFilename = $config['db']['filename'] ?? '';
$logFilename = $config['log']['filename'] ?? '';

$fileHandler = new StreamHandler($logFilename);
$consoleHandler = new StreamHandler('php://stdout');
$logger = new Logger('url encoder', [$fileHandler, $consoleHandler]);

$algorithm = new Murmur3ARebased64Algorithm();
$storage = new FileStorage($dbFilename, $logger);
$decoder = new UrlDecoder($storage, $algorithm);
$app = new App($logger);

$code = readline('Put code to decode: ');
$url = $app->runDecode($decoder, $code);
echo "Url is: $url" . PHP_EOL;
