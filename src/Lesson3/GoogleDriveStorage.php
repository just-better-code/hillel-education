<?php

namespace Kulinich\Hillel\Lesson3;

use Kulinich\Hillel\Support\ConsoleLogger;

class GoogleDriveStorage extends BaseStorage
{
    public function store(string $message): bool
    {
        ConsoleLogger::loader('Storing message to google...');
        ConsoleLogger::log("Message '{$message}' stored to google.");

        return true;
    }
}