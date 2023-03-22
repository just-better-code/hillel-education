<?php

namespace Kulinich\Hillel\Support;

class ConsoleLogger implements Logger
{
    public static function log(string $message = ''): void
    {
        echo $message . PHP_EOL;
    }

    public static function loader(string $message = ''): void
    {
        echo $message;
        $steps = random_int(3,10);
        for($i = 0; $i < $steps; $i++) {
            echo '.';
            usleep(50000);
        }
        echo PHP_EOL;
    }
}