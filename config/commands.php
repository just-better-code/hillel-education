<?php

use Kulinich\Hillel\Commands;
use Kulinich\Hillel\Foundation\DI\ConfigConstants as C;

return [
    'cli.command.test' => [C::CLASSNAME => Commands\TestCommand::class],
    'cli.command.encode' => [C::CLASSNAME => Commands\EncodeCommand::class],
    'cli.command.decode' => [C::CLASSNAME => Commands\DecodeCommand::class],
    'cli.command.db' => [C::CLASSNAME => Commands\MigrateCommand::class],
];