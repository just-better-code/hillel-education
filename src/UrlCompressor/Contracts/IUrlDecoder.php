<?php

namespace Kulinich\Hillel\UrlCompressor\Contracts;

interface IUrlDecoder
{
    /**
     * @param string $code
     * @throws \InvalidArgumentException
     * @return string
     */
    public function decode(string $code): string;
}