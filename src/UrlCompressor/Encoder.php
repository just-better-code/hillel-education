<?php

namespace Kulinich\Hillel\UrlCompressor;

interface Encoder
{
    public function encode(string $url): string;
}