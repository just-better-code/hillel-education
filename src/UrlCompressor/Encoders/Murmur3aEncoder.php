<?php

namespace Kulinich\Hillel\UrlCompressor\Encoders;

use Kulinich\Hillel\UrlCompressor\Support\BaseConverter;

class Murmur3aEncoder implements Encoder
{
    public function encode(string $url): string
    {
        $converter = new BaseConverter(16, 64);
        $hash16 = hash('murmur3a', trim($url));

        return $converter->convert($hash16);
    }

    public function validate(string $code): bool
    {
        return (bool)preg_match('~^[A-Za-z0-9@-]{6}$~', trim($code));
    }
}