<?php

namespace Kulinich\Hillel\Foundation;

use Kulinich\Hillel\Foundation\Exceptions\ConfigurationNotFoundException;
use Psr\Container\ContainerInterface;

class Config implements ContainerInterface
{
    public function __construct(private $data = [])
    {
    }

    public function get(string $id)
    {
        try {
            return $this->getConfig($id);
        } catch (\Throwable) {
            throw new ConfigurationNotFoundException("Can't get '$id' config.");
        }
    }

    public function has(string $id): bool
    {
        try {
            $this->getConfig($id);
            return true;
        } catch (\Throwable) {
            return false;
        }
    }

    private function getConfig(string $id): mixed
    {
        $path = explode('.', $id);
        $data = $this->data;
        foreach ($path as $key) {
            $data = $data[$key];
        }
        return $data;
    }
}