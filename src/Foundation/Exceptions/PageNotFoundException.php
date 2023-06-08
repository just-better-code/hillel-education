<?php

namespace Kulinich\Hillel\Foundation\Exceptions;

use Psr\Container\ContainerExceptionInterface;

class PageNotFoundException extends \InvalidArgumentException implements ContainerExceptionInterface
{
}