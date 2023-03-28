<?php

namespace Kulinich\Hillel\UrlCompressor\Validators;

abstract class ValidatorChain
{
    /** @var self */
    private $next;

    public function attach(ValidatorChain $next): self
    {
        if ($this->next) {
            $this->next->attach($next);
        } else {
            $this->next = $next;
        }

        return $this;
    }

    final public function perform($data): void
    {
        $this->validate($data);
        $this->next && $this->next->perform($data);
    }

    abstract protected function validate($data): void;
}