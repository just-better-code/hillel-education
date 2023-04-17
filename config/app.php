<?php

return [
    'containers' => [
        \Psr\Log\LoggerInterface::class => [
            'class' => \Monolog\Logger::class,
            'name' => 'log',
            'handlers' => [
                '@file_log_handler',
                '@console_log_handler',
            ]
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
    'db' => [
        'filename' => __DIR__ . '/../storage/file_storage.txt',
    ],
];