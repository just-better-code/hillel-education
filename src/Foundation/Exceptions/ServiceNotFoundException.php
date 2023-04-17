<?php

namespace Kulinich\Hillel\Foundation\Exceptions;

use Psr\Container\NotFoundExceptionInterface;

class ServiceNotFoundException extends \InvalidArgumentException implements NotFoundExceptionInterface
{
}