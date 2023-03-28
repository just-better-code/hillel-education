<?php

require_once __DIR__.'/../vendor/autoload.php';

use Kulinich\Hillel\UrlCompressor\Algorithms\Murmur3ARebased64Algorithm;
use Kulinich\Hillel\UrlCompressor\Storages\FileStorage;
use Kulinich\Hillel\UrlCompressor\UrlEncoder;

$config = require_once __DIR__ . '/../config/app.php';
$filename = $config['db']['filename'] ?? '';
$algorithm = new Murmur3ARebased64Algorithm();
$storage = new FileStorage($filename);
$encoder = new UrlEncoder($storage, $algorithm);

echo "==== URL compressor ====" . PHP_EOL;
$url = readline("Put url to encode: ");
$url = trim($url);
$code = $encoder->encode($url);
echo "Url code is: $code" . PHP_EOL;
