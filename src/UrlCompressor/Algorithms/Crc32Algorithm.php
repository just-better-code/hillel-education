<?php

namespace Kulinich\Hillel\UrlCompressor\Algorithms;

class Crc32Algorithm implements Algorithm
{
    public function encode(string $url): string
    {
        return hash('crc32b', $url);
    }

    public function validate(string $code): bool
    {
        return (bool)preg_match('~^[0-f]{8}$~', $code);
    }
}