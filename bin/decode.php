#!/usr/bin/env php
<?php

require_once __DIR__.'/../vendor/autoload.php';

$encoder = new \Kulinich\Hillel\UrlCompressor\Encoders\Murmur3aRebased64Encoder();
//$encoder = new \Kulinich\Hillel\UrlCompressor\Encoders\Murmur3aEncoder();
//$encoder = new \Kulinich\Hillel\UrlCompressor\Encoders\Crc32Encoder();
$storage = new \Kulinich\Hillel\UrlCompressor\Storages\FileStorage();

echo "==== URL compressor ====" . PHP_EOL;
$code = readline("Put code to get url: ");
$code = trim($code);
$app = (new \Kulinich\Hillel\App($storage, $encoder));
$url = $app->runDecode($code);
echo "You url is: '$url'" . PHP_EOL;
