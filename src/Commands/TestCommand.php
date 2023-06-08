<?php

namespace Kulinich\Hillel\Commands;

use Kulinich\Hillel\Foundation\Commands\Command;
use Psr\Log\LoggerInterface;

class TestCommand implements Command
{
    public function name(): string
    {
        return 'test';
    }

    public function handle(array $params): void
    {
        var_dump($params);
    }

    public function objectMethod(LoggerInterface $logger)
    {
        $logger->debug('Test object method');
    }

    public static function staticMethod(LoggerInterface $logger)
    {
        $logger->debug('Test static method');
    }
}