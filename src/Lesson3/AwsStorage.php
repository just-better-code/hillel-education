<?php

namespace Kulinich\Hillel\Lesson3;

use Kulinich\Hillel\Support\ConsoleLogger;

class AwsStorage extends BaseStorage
{
    public function store(string $message): bool
    {
        ConsoleLogger::loader('Storing message to aws');
        ConsoleLogger::log("Message '{$message}' stored to aws.");

        return true;
    }
}