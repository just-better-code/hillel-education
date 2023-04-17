<?php

namespace Kulinich\Hillel\Foundation\DI;

class DescriptionStorage extends ServiceStorage
{
    public function put(string $id, mixed $object): void
    {
        $description = new ServiceDescription($object);
        $this->data[$this->resolveKey($id)] = $description;
    }
}