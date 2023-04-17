<?php

use Kulinich\Hillel\UrlCompressor\Algorithms\EncodingAlgorithmInterface;
use Kulinich\Hillel\UrlCompressor\Algorithms\Murmur3ARebased64Algorithm;
use Kulinich\Hillel\UrlCompressor\Contracts\IUrlDecoder;
use Kulinich\Hillel\UrlCompressor\Contracts\IUrlEncoder;
use Kulinich\Hillel\UrlCompressor\Storages\FileUrlCompressorStorage;
use Kulinich\Hillel\UrlCompressor\Storages\UrlCompressorStorageInterface;
use Kulinich\Hillel\UrlCompressor\UrlDecoder;
use Kulinich\Hillel\UrlCompressor\UrlEncoder;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

return [
    'containers' => [
        LoggerInterface::class => [
            'class' => Logger::class,
            'name' => 'log',
            'handlers' => [
                '@file_log_handler',
                '@console_log_handler',
            ]
        ],
        UrlCompressorStorageInterface::class => [
            'class' => FileUrlCompressorStorage::class,
            'filename' => __DIR__ . '/../storage/file_storage.txt',
        ],
        EncodingAlgorithmInterface::class => [
            'class' => Murmur3ARebased64Algorithm::class,
        ],
        IUrlEncoder::class => [
            'class' => UrlEncoder::class,
        ],
        IUrlDecoder::class => [
            'class' => UrlDecoder::class,
        ],
        'file_log_handler' => [
            'class' => \Monolog\Handler\StreamHandler::class,
            'stream' => fn (\DateTime $time) => __DIR__ . '/../storage/' . $time->format('Y-m-d') . '.log',
        ],
        'console_log_handler' => [
            'class' => \Monolog\Handler\StreamHandler::class,
            'stream' => 'php://stdout'
        ],
    ],
];