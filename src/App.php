<?php

namespace Kulinich\Hillel;

use Kulinich\Hillel\UrlCompressor\Encoders\Encoder;
use Kulinich\Hillel\UrlCompressor\Storages\Storage;
use Kulinich\Hillel\UrlCompressor\UrlCompressor;

final class App
{
    public function __construct(private Storage $storage, private Encoder $encoder)
    {
    }

    public function runEncode(string $url): string
    {
        return (new UrlCompressor($this->storage, $this->encoder))->store($url);
    }

    public function runDecode(string $code): ?string
    {
        return (new UrlCompressor($this->storage, $this->encoder))->fetch($code);
    }
}