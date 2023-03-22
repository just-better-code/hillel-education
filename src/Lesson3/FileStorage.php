<?php

namespace Kulinich\Hillel\Lesson3;

use Kulinich\Hillel\Support\ConsoleLogger;

class FileStorage implements Storage
{
    public function store(string $message): bool
    {
        ConsoleLogger::loader('Storing message to local file...');
        ConsoleLogger::log("Message '{$message}' stored to local file.");

        return true;
    }
}