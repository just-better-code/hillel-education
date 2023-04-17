<?php

return [
    'containers' => [
        \Psr\Log\LoggerInterface::class => [
            'class' => \Monolog\Logger::class,
            'name' => 'mono',
            'handlers' => [
                '@file_log_handler',
                '@console_log_handler',
            ]
        ],
        'file_log_handler' => [
            'class' => \Monolog\Handler\StreamHandler::class,
            'stream' => __DIR__ . '/../storage/log.txt'
        ],
        'console_log_handler' => [
            'class' => \Monolog\Handler\StreamHandler::class,
            'stream' => 'php://stdout'
        ],
    ],
    'db' => [
        'filename' => __DIR__ . '/../storage/file_storage.txt',
    ],
];