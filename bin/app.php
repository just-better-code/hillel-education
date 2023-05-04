<?php

use Kulinich\Hillel\Foundation\Commands\CommandHandler;

/** @var \Kulinich\Hillel\App $app */
$app = require_once __DIR__ . '/../src/bootstrap.php';
/** @var CommandHandler $handler */
$handler = $app->get(CommandHandler::class);

$handler->handle();