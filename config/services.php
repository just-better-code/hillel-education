<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Kulinich\Hillel\Foundation\Commands\CliCommandHandler;
use Kulinich\Hillel\Foundation\Commands\CommandHandler;
use Kulinich\Hillel\Foundation\DI\ConfigConstants as C;
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
        C::CLASSNAME => PDO::class,
        C::ARGUMENTS => [
            'dsn' => "mysql:host=db;dbname=$dbName",
            'username' => $dbUser,
            'password' => $dbPass,
        ],
    ],
    'db' => [
        C::CLASSNAME => Capsule::class,
        C::CALLS => [
            [
                C::METHOD => 'addConnection',
                C::ARGUMENTS => [
                    'config' => [
                        'driver' => 'mysql',
                        'host' => 'db',
                        'database' => $dbName,
                        'username' => $dbUser,
                        'password' => $dbPass,
                    ],
                ],
            ],
            [C::METHOD => 'setAsGlobal'],
            [C::METHOD => 'bootEloquent'],
        ],
    ],
    CommandHandler::class => [
        C::CLASSNAME => CliCommandHandler::class,
        C::ARGUMENTS => [
            'commands' => [
                '@cli.command.test',
                '@cli.command.encode',
                '@cli.command.decode',
                '@cli.command.db',
            ],
        ],
    ],
    LoggerInterface::class => [
        C::CLASSNAME => Logger::class,
        C::ARGUMENTS => [
            'name' => 'log',
            'handlers' => [
                '@file_log_handler',
                '@console_log_handler',
            ],
        ],
    ],
    UrlCompressorStorageInterface::class => [
        C::CLASSNAME => FileUrlCompressorStorage::class,
        C::ARGUMENTS => [
            'filename' => __DIR__ . '/../storage/file_storage.txt',
        ],
    ],
    EncodingAlgorithmInterface::class => [
        C::CLASSNAME => Murmur3ARebased64Algorithm::class,
    ],
    IUrlEncoder::class => [
        C::CLASSNAME => UrlEncoder::class,
    ],
    IUrlDecoder::class => [
        C::CLASSNAME => UrlDecoder::class,
    ],
    'file_log_handler' => [
        C::CLASSNAME => StreamHandler::class,
        C::ARGUMENTS => [
            'stream' => fn(\DateTime $time) => __DIR__ . '/../storage/' . $time->format('Y-m-d') . '.log',
        ],

    ],
    'console_log_handler' => [
        C::CLASSNAME => StreamHandler::class,
        C::ARGUMENTS => [
            'stream' => 'php://stdout',
        ],

    ],
];
$commands = require_once 'commands.php';

return array_merge($app, $commands);