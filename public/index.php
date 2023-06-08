<?php

use Kulinich\Hillel\App;
use Kulinich\Hillel\Foundation\Exceptions\PageNotFoundException;

require_once __DIR__ . '/../src/bootstrap.php';
/** @var \Kulinich\Hillel\Foundation\Http\Router $router */
$router = App::instance()->get('router');
if (!$router->run()) {
    throw new PageNotFoundException();
}