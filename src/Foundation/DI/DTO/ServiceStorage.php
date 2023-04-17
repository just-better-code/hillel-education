<?php

namespace Kulinich\Hillel\Foundation\DI\DTO;

use Kulinich\Hillel\Foundation\Exceptions\ServiceNotFoundException;

class ServiceStorage implements StorageContract
{
    protected array $data = [];

    public function get(string $id)
    {
        try {
            return $this->data[$this->resolveKey($id)];
        } catch (\Throwable) {
            throw new ServiceNotFoundException();
        }
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