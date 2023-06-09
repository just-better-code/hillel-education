<?php

namespace Kulinich\Hillel\Foundation\DI;

use Psr\Container\ContainerInterface;

interface StorageContract extends ContainerInterface
{
    public function put(string $id, mixed $object): void;
}