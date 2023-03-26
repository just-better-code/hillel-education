<?php

namespace Kulinich\Hillel\UrlCompressor\Encoders;

interface Encoder
{
    public function encode(string $url): string;

    public function validate(string $code): bool;
}