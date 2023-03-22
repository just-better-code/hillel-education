<?php

namespace Kulinich\Hillel\Lesson3;

use Kulinich\Hillel\Support\ConsoleLogger;

class RedisStorage implements Storage
{
    public function store(string $message): bool
    {
        ConsoleLogger::loader('Storing message to redis...');
        ConsoleLogger::log("Message '{$message}' stored to redis.");

        return true;
    }
}