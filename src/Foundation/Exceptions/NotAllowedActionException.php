<?php

namespace Kulinich\Hillel\Foundation\Exceptions;

use Psr\Container\ContainerExceptionInterface;

class NotAllowedActionException extends \InvalidArgumentException implements ContainerExceptionInterface
{
}