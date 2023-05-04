<?php

namespace Kulinich\Hillel;

use Psr\Container\ContainerInterface;

final class App implements ContainerInterface
{
    public function __construct(
        private ContainerInterface $container,
        private ContainerInterface $config,
    ) {
    }

    public function get(string $id): mixed
    {
        return $this->container->get($id);
    }

    public function config(string $key): mixed
    {
        return $this->config->get($key);
    }

    public function has(string $id): bool
    {
        return $this->config->has($id);
    }
}