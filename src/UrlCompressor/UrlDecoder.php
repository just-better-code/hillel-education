<?php

namespace Kulinich\Hillel\UrlCompressor;

use Kulinich\Hillel\UrlCompressor\Algorithms\Algorithm;
use Kulinich\Hillel\UrlCompressor\Contracts\IUrlDecoder;
use Kulinich\Hillel\UrlCompressor\Storages\Storage;

class UrlDecoder implements IUrlDecoder
{
    public function __construct(private Storage $storage, private Algorithm $algorithm)
    {
    }

    public function decode(string $code): string
    {
        if (!$this->algorithm->validate($code)) {
            throw new \InvalidArgumentException("Code '$code' has invalid format!");
        }
        $url = $this->storage->getByCode($code);
        if (empty($url)) {
            throw new \InvalidArgumentException("URL by code '$code' not found!");
        }
        return $url;
    }
}
