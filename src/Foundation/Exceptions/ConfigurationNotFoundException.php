<?php

namespace Kulinich\Hillel\Foundation\Exceptions;

use Psr\Container\NotFoundExceptionInterface;

class ConfigurationNotFoundException extends \InvalidArgumentException implements NotFoundExceptionInterface
{
}