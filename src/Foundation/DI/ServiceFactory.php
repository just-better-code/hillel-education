<?php

namespace Kulinich\Hillel\Foundation\DI;

use Kulinich\Hillel\Foundation\Exceptions\WrongConfigurationException;

class ServiceFactory
{
    public function __construct(private Container $container)
    {
    }

    public function build(ServiceDescription $description): mixed
    {
        try {
            $class = $description->className();
            $params = $description->params();
            $params = $this->resolveParams($params);
            return $params ? new $class(...$params) : new $class();
        } catch (\Throwable $e) {
            $msg = "Can't resolve '{$description->className()}' dependency." . PHP_EOL;
            $msg .= $e->getMessage();
            throw new WrongConfigurationException($msg);
        }
    }

    private function resolveParams(array $params): array
    {
        foreach ($params as $key => $val) {
            $val = $this->value($val);
            if ($this->container->has($key)) {
                $val = $this->container->get($key);
            }
            $params[$key] = $val;
        }

        return $params;
    }

    private function value($value, ...$args)
    {
        if (is_array($value)) {
            foreach ($value as $idx => $item) {
                $value[$idx] = $this->value($item);
            }
        }
        if (is_string($value) && str_starts_with($value, '@')) {
            $value = substr($value, 1, strlen($value));
            return $this->container->get($value);
        }
        return $value instanceof \Closure ? $value(...$args) : $value;
    }
}