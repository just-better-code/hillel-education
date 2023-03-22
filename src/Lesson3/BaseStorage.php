<?php

namespace Kulinich\Hillel\Lesson3;

use Kulinich\Hillel\Support\ConsoleLogger;

class BaseStorage implements Storage
{
     public function store(string $message): bool
     {
         ConsoleLogger::loader('Storing message to your brain :)');
         ConsoleLogger::log('Nope! I cn\'t. Try to define another way');

         return false;
     }
}