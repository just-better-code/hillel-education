<?php

namespace Kulinich\Hillel\Foundation\DI\DTO;

use Kulinich\Hillel\Foundation\Exceptions\WrongConfigurationException;

class ServiceDescription
{
    private string $className;
    private array $parameters = [];

    public function __construct(array $parameters = [])
    {
        $this->build($parameters);
    }

    private function build(array $parameters = []): void
    {
        try {
            $this->className = $parameters['class'];
            unset($parameters['class']);
            $this->parameters = $parameters;
        } catch (\Throwable) {
            throw new WrongConfigurationException("Can't find 'class' property.");
        }

        if (!class_exists($this->className)) {
            throw new WrongConfigurationException("Can't find '{$this->className}'.");
        }
    }


    public function className(): string
    {
        return $this->className;
    }

    public function params(): array
    {
        return $this->parameters;
    }
}