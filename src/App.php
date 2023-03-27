<?php

namespace Kulinich\Hillel;

use Kulinich\Hillel\UrlCompressor\Algorithms\Algorithm;
use Kulinich\Hillel\UrlCompressor\Storages\Storage;
use Kulinich\Hillel\UrlCompressor\UrlEncoder;

final class App
{
    public function __construct(private Storage $storage, private Algorithm $encoder)
    {
    }

    public function runEncode(string $url): string
    {
        return (new UrlEncoder($this->storage, $this->encoder))->store($url);
    }

    public function runDecode(string $code): ?string
    {
        return (new UrlEncoder($this->storage, $this->encoder))->fetch($code);
    }
}