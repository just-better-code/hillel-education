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
            return $this->buildClassVal($class, $params);
        } catch (\Throwable $e) {
            $msg = "Can't resolve '{$description->className()}' dependency." . PHP_EOL;
            $msg .= $e->getMessage();
            throw new WrongConfigurationException($msg);
        }
    }

    private function resolveParams(array $params): array
    {
        foreach ($params as $key => $val) {
            $val = $this->buildVal($val);
            if ($this->container->has($key)) {
                $val = $this->container->get($key);
            }
            $params[$key] = $val;
        }

        return $params;
    }

    private function buildVal($value)
    {
        if (is_array($value)) {
            $value = $this->buildArrayVal($value);
        }
        if ($this->mustGetFromContainer($value)) {
            return $this->container->get($value);
        }

        return $value instanceof \Closure ? $this->buildClosureVal($value) : $value;
    }

    private function buildArrayVal(array $value): array
    {
        foreach ($value as $idx => $item) {
            $value[$idx] = $this->buildVal($item);
        }
        return $value;
    }

    private function buildClosureVal(callable $closure)
    {
        $reflection = new \ReflectionFunction($closure);
        $reflectedArguments  = $reflection->getParameters();
        $resolvedArguments = [];
        foreach ($reflectedArguments as $argument) {
            $type = $argument->getType();
            if ($type->isBuiltin()) {
                throw new WrongConfigurationException("Can't inject builtin type");
            }
            $resolvedArguments[] = $this->buildClassVal($type->getName());
        }

        return $closure(...$resolvedArguments);
    }

    public function buildClassVal(string $class, array $params = []): mixed
    {
        if ($this->mustGetFromContainer($class)) {
            return $this->container->get($class);
        }
        $constructor = (new \ReflectionClass($class))->getConstructor();
        if (empty($constructor)) {
            return new $class();
        }
        $params = $this->buildConstructorParams($constructor, $params);

        return new $class(...$params);
    }

    private function buildConstructorParams(\ReflectionMethod $constructor, array $params): array
    {
        foreach ($constructor->getParameters() as $p) {
            $pType = $p->getType();
            $pName = $p->getName();
            if (!$pType instanceof \ReflectionNamedType) {
                continue;
            }
            if (isset($params[$pName]) || $pType->isBuiltin() || $p->isOptional()) {
                continue;
            }
            $params[$pName] = $this->buildClassVal($pType->getName());
        }
        return $params;
    }

    private function mustGetFromContainer($value): bool
    {
        return is_string($value) &&
            (str_starts_with($value, '@') || interface_exists($value));
    }
}