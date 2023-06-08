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
            $arguments = $description->arguments();
            $arguments = $this->resolveArguments($arguments);
            $classObject = $this->buildClassVal($class, $arguments);
            $this->runCalls($classObject, $description->calls());
        } catch (\Throwable $e) {
            $msg = "Can't resolve '{$description->className()}' dependency." . PHP_EOL;
            $msg .= $e->getMessage();
            throw new WrongConfigurationException($msg);
        }

        return $classObject;
    }

    private function resolveArguments(array $params): array
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
        if ($this->aliasedInContainer($value)) {
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

    public function buildClassVal(string $class, array $args = []): mixed
    {
        if ($this->aliasedInContainer($class)) {
            return $this->container->get($class);
        }
        $constructor = (new \ReflectionClass($class))->getConstructor();
        if (empty($constructor)) {
            return new $class();
        }
        $args = $this->buildMethodArguments($constructor, $args);

        return new $class(...$args);
    }

    private function buildMethodArguments(\ReflectionMethod $method, array $args): array
    {
        foreach ($method->getParameters() as $param) {
            $pType = $param->getType();
            $pName = $param->getName();
            if (!$pType instanceof \ReflectionNamedType) {
                continue;
            }
            if (isset($args[$pName]) || $pType->isBuiltin() || $param->isOptional()) {
                continue;
            }
            $args[$pName] = $this->buildClassVal($pType->getName());
        }
        return $args;
    }

    /**
     * @param CallDescription[] $calls
     */
    private function runCalls(object $classObject, array $calls): void
    {
        foreach ($calls as $call) {
            $this->runCall($classObject, $call);
        }
    }

    private function runCall(object $classObject, CallDescription $call): void
    {
        $methodName = $call->methodName();
        $method = (new \ReflectionClass($classObject))->getMethod($methodName);
        $arguments = $this->buildMethodArguments($method, $call->arguments());
        if ($method->isStatic()) {
            $classObject::$methodName(...$arguments);
        } else {
            $classObject->$methodName(...$arguments);
        }
    }

    private function aliasedInContainer($value): bool
    {
        return is_string($value) && (
                str_starts_with($value, '@')
                || interface_exists($value)
            );
    }
}