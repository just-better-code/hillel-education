<?php

namespace Kulinich\Hillel\UrlCompressor\Algorithms;

interface Algorithm
{
    public function encode(string $url): string;

    public function validate(string $code): bool;
}