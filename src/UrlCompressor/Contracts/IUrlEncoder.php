<?php

namespace Kulinich\Hillel\UrlCompressor\Contracts;

interface IUrlEncoder
{
    /**
     * @param string $url
     * @throws \InvalidArgumentException
     * @return string
     */
    public function encode(string $url): string;
}