<?php

use Kulinich\Hillel\Foundation\Commands\CliCommandHandler;
use Kulinich\Hillel\Foundation\Commands\CommandHandler;
use Kulinich\Hillel\UrlCompressor\Algorithms\EncodingAlgorithmInterface;
use Kulinich\Hillel\UrlCompressor\Algorithms\Murmur3ARebased64Algorithm;
use Kulinich\Hillel\UrlCompressor\Contracts\IUrlDecoder;
use Kulinich\Hillel\UrlCompressor\Contracts\IUrlEncoder;
use Kulinich\Hillel\UrlCompressor\Storages\FileUrlCompressorStorage;
use Kulinich\Hillel\UrlCompressor\Storages\UrlCompressorStorageInterface;
use Kulinich\Hillel\UrlCompressor\UrlDecoder;
use Kulinich\Hillel\UrlCompressor\UrlEncoder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

$dbName = $_ENV['MYSQL_DATABASE'] ?? null;
$dbUser = $_ENV['MYSQL_USER'] ?? null;
$dbPass = $_ENV['MYSQL_PASSWORD'] ?? null;

$app = [
    'pdo' => [
        'class' => PDO::class,
        'dsn' => "mysql:host=db;dbname=$dbName",
        'username' => $dbUser,
        'password' => $dbPass,
    ],
    CommandHandler::class => [
        'class' => CliCommandHandler::class,
        'commands' => [
            '@cli.command.test',
            '@cli.command.encode',
            '@cli.command.decode',
        ],
    ],
    LoggerInterface::class => [
        'class' => Logger::class,
        'name' => 'log',
        'handlers' => [
            '@file_log_handler',
            '@console_log_handler',
        ],
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
        'class' => StreamHandler::class,
        'stream' => fn(\DateTime $time) => __DIR__ . '/../storage/' . $time->format('Y-m-d') . '.log',
    ],
    'console_log_handler' => [
        'class' => StreamHandler::class,
        'stream' => 'php://stdout'
    ],
];
$commands = require_once 'commands.php';

return array_merge($app, $commands);