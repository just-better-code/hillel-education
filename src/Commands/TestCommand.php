<?php

namespace Kulinich\Hillel\Commands;

use Kulinich\Hillel\Foundation\Commands\Command;

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
}