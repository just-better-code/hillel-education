<?php

namespace Kulinich\Hillel\Foundation\Exceptions;

use Psr\Container\ContainerExceptionInterface;

class WrongConfigurationException extends \InvalidArgumentException implements ContainerExceptionInterface
{
}