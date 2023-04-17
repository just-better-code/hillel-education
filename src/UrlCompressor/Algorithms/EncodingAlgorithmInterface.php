<?php

namespace Kulinich\Hillel\UrlCompressor\Algorithms;

interface EncodingAlgorithmInterface
{
    public function encode(string $url): string;

    public function validate(string $code): bool;
}