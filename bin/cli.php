<?php

use Kulinich\Hillel\App;
use Kulinich\Hillel\Foundation\Commands\CommandHandler;

require_once __DIR__ . '/../src/bootstrap.php';

/** @var CommandHandler $handler */
$handler = App::instance()->get(CommandHandler::class);
$handler->handle();
$router = App::instance()->get('router');