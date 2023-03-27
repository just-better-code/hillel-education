<?php

namespace Kulinich\Hillel\UrlCompressor;

interface Decoder
{
    public function decode(string $code): string;
}