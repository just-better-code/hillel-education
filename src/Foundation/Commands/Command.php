<?php

namespace Kulinich\Hillel\Foundation\Commands;

interface Command
{
    public function name(): string;

    public function handle(array $params): void;
}