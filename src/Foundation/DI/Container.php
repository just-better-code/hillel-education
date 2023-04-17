<?php

namespace Kulinich\Hillel\Foundation\DI;

use Kulinich\Hillel\Foundation\Exceptions\NotAllowedActionException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface, \ArrayAccess
{
    private StorageContract $descriptions;
    private StorageContract $implementations;
    private ServiceFactory $factory;

    public function __construct(array $configurations = [])
    {
        $this->descriptions = new DescriptionStorage();
        $this->implementations = new ServiceStorage();
        $this->factory = new ServiceFactory($this);
        $this->populate($configurations);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->descriptions->put($offset, $value);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->descriptions->has($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        if (!$this->implementations->has($offset)) {
            $description = $this->buildDescription($offset);
            $service = $this->factory->build($description);
            $this->implementations->put($offset, $service);
        }

        return $this->implementations->get($offset);
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new NotAllowedActionException();
    }

    public function get(string $id)
    {
        $offset = str_starts_with($id, '@') ? 1 : 0;
        $id = substr($id, $offset, strlen($id));

        return $this->offsetGet($id);
    }

    public function has(string $id): bool
    {
        return $this->offsetExists($id);
    }

    private function populate(array $configurations): void
    {
        foreach ($configurations as $service => $parameters) {
            $this->offsetSet($service, $parameters);
        }
    }

    public function buildDescription(mixed $offset): ServiceDescription
    {
        if (!$this->descriptions->has($offset) && class_exists($offset)) {
            $this->descriptions->put($offset, ['class' => $offset]);
        }
        return $this->descriptions->get($offset);
    }
}