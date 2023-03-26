<?php

namespace Kulinich\Hillel\UrlCompressor\Encoders;

class Crc32Encoder implements Encoder
{
    public function encode(string $url): string
    {
        return hash('crc32b', trim($url));
    }

    public function validate(string $code): bool
    {
        return (bool)preg_match('~^[0-f]{8}$~', trim($code));
    }
}