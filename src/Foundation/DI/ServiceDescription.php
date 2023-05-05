<?php

namespace Kulinich\Hillel\Foundation\DI;

use Kulinich\Hillel\Foundation\Exceptions\WrongConfigurationException;
use Kulinich\Hillel\Foundation\DI\ConfigConstants as C;

class ServiceDescription
{
    private string $className;
    private array $arguments;

    /** @var CallDescription[] */
    private array $calls;

    public function __construct(array $parameters = [])
    {
        $this->build($parameters);
    }

    private function build(array $parameters = []): void
    {
        try {
            $this->className = $parameters[C::CLASSNAME];
            $this->arguments = $parameters[C::ARGUMENTS] ?? [];
            $this->calls = $this->buildCalls($parameters[C::CALLS] ?? []);
        } catch (\Throwable) {
            throw new WrongConfigurationException("Can't find 'class' property.");
        }

        if (!class_exists($this->className)) {
            throw new WrongConfigurationException("Can't find '{$this->className}'.");
        }
    }

    /**
     * @return CallDescription[]
     */
    private function buildCalls(array $calls): array
    {
        $result = [];
        foreach ($calls as $call) {
            $result[] = new CallDescription($call);
        }

        return $result;
    }

    public function className(): string
    {
        return $this->className;
    }

    /**
     * @return CallDescription[]
     */
    public function calls(): array
    {
        return $this->calls;
    }

    public function arguments(): array
    {
        return $this->arguments;
    }
}