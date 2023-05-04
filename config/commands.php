<?php

use Kulinich\Hillel\Commands;

return [
    'cli.command.test' => ['class' => Commands\TestCommand::class],
    'cli.command.encode' => ['class' => Commands\EncodeCommand::class],
    'cli.command.decode' => ['class' => Commands\DecodeCommand::class],
];