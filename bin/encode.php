#!/usr/bin/env php
<?php

use Kulinich\Hillel\UrlCompressor\Support\BaseConverter;

require_once __DIR__.'/../vendor/autoload.php';

$encoder = new \Kulinich\Hillel\UrlCompressor\Encoders\Murmur3aRebased64Encoder();
//$encoder = new \Kulinich\Hillel\UrlCompressor\Encoders\Murmur3aEncoder();
//$encoder = new \Kulinich\Hillel\UrlCompressor\Encoders\Crc32Encoder();
$storage = new \Kulinich\Hillel\UrlCompressor\Storages\FileStorage();

echo "==== URL compressor ====" . PHP_EOL;
$url = readline("Put url to encode: ");
$url = trim($url);
$app = (new \Kulinich\Hillel\App($storage, $encoder));
$code = $app->runEncode($url);
echo "Url code is: $code" . PHP_EOL;
