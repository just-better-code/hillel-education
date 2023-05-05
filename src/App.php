<?php

namespace Kulinich\Hillel;

use Psr\Container\ContainerInterface;

final class App implements ContainerInterface
{
    private static self $instance;

    protected function __construct(
        private ContainerInterface $container,
        private ContainerInterface $config,
    ) {
    }

    public static function init(ContainerInterface $container, ContainerInterface $config): void
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($container, $config);
        }
    }

    public static function instance(): self
    {
        return self::$instance;
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

    protected function __clone()
    {
        throw new \Exception("Cannot clone.");
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize.");
    }
}