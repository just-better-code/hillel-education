<?php

namespace Kulinich\Hillel\Foundation\DI;

use Kulinich\Hillel\Foundation\Exceptions\ServiceNotFoundException;

class ServiceStorage implements StorageContract
{
    protected array $data = [];

    public function get(string $id)
    {
        $key = $this->resolveKey($id);
        if (!isset($this->data[$key])) {
            throw new ServiceNotFoundException("Service '$id' not found");
        }

        return $this->data[$key];
    }

    public function has(string $id): bool
    {
        return isset($this->data[$this->resolveKey($id)]);
    }

    public function put(string $id, mixed $object): void
    {
        $this->data[$this->resolveKey($id)] = $object;
    }

    protected function resolveKey(string $id): string
    {
        return md5($id);
    }
}