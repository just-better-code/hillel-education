#!/usr/bin/env php
<?php

require_once __DIR__.'/../vendor/autoload.php';

$encoder = new \Kulinich\Hillel\UrlCompressor\Encoders\Crc32Encoder();
$storage = new \Kulinich\Hillel\UrlCompressor\Storages\FileStorage();

echo "==== URL compressor ====" . PHP_EOL;
$url = readline("Put url to encode: ");
$app = (new \Kulinich\Hillel\App($storage, $encoder));
$code = $app->runEncode($url);
echo "Url code is: $code" . PHP_EOL;
