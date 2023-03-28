<?php

require_once __DIR__.'/../vendor/autoload.php';

use Kulinich\Hillel\UrlCompressor\Algorithms\Murmur3ARebased64Algorithm;
use Kulinich\Hillel\UrlCompressor\Storages\FileStorage;
use Kulinich\Hillel\UrlCompressor\UrlDecoder;

$config = require_once __DIR__ . '/../config/app.php';
$filename = $config['db']['filename'] ?? '';
$algorithm = new Murmur3ARebased64Algorithm();
$storage = new FileStorage($filename);
$decoder = new UrlDecoder($storage, $algorithm);

echo "==== URL compressor ====" . PHP_EOL;
$code = readline("Put code to get url: ");
$code = trim($code);
$url = $decoder->decode($code);
echo "You url is: '$url'" . PHP_EOL;
