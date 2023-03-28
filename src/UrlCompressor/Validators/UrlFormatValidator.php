<?php

namespace Kulinich\Hillel\UrlCompressor\Validators;

class UrlFormatValidator extends ValidatorChain
{
    protected function validate($url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("URL format of '$url' is not valid!");
        }
    }
}