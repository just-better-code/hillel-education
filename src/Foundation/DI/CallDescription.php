<?php

namespace Kulinich\Hillel\Foundation\DI;

use Kulinich\Hillel\Foundation\Exceptions\WrongConfigurationException;

class CallDescription
{
    private string $methodName;
    private array $arguments;

    public function __construct(array $parameters = [])
    {
        $this->build($parameters);
    }

    private function build(array $parameters = []): void
    {
        try {
            $this->methodName = $parameters[ConfigConstants::METHOD];
            $this->arguments = $parameters[ConfigConstants::ARGUMENTS] ?? [];
        } catch (\Throwable) {
            throw new WrongConfigurationException("Can't find 'method' property.");
        }
    }


    public function methodName(): string
    {
        return $this->methodName;
    }

    public function arguments(): array
    {
        return $this->arguments;
    }
}