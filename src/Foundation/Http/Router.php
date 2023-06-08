<?php

namespace Kulinich\Hillel\Foundation\Http;

use Bramus\Router\Router as BaseRouter;
use Kulinich\Hillel\Foundation\Exceptions\WrongConfigurationException;

class Router
{
    public function __construct(
        private BaseRouter $base,
        private array $list,
    ) {
    }

    public function run(): bool
    {
        foreach ($this->list as $route) {
            $methods = $route[0] ?? '';
            $pattern = $route[1] ?? '';
            $callback = $this->buildCallback($route);
            $this->base->match($methods, $pattern, $callback);
        }

        return $this->getBase()->run();
    }

    public function getBase(): BaseRouter
    {
        return $this->base;
    }

    public function buildCallback(array $route): mixed
    {
        if (empty($route[2])) {
            throw new WrongConfigurationException('You must define callback for routes');
        }
        $cb = $route[2];
        if (is_string($cb) && class_exists($cb) && !str_contains($cb, '@')) {
            $cb = $cb . '@__invoke';
        }

        return $cb;
    }
}