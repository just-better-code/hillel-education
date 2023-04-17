<?php

namespace Kulinich\Hillel\UrlCompressor\Algorithms;

use Kulinich\Hillel\UrlCompressor\Algorithms\Support\BaseConverter;

class Murmur3ARebased64Algorithm implements EncodingAlgorithmInterface
{
    public function encode(string $url): string
    {
        $converter = new BaseConverter(16, 64);
        $hash16 = hash('murmur3a', trim($url));

        return $converter->convert($hash16);
    }

    public function validate(string $code): bool
    {
        return (bool)preg_match('~^[A-Za-z0-9@-]{1,8}$~', trim($code));
    }
}