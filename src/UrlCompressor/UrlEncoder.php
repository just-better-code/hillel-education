<?php

namespace Kulinich\Hillel\UrlCompressor;

use Kulinich\Hillel\UrlCompressor\Algorithms\Algorithm;
use Kulinich\Hillel\UrlCompressor\Contracts\IUrlEncoder;
use Kulinich\Hillel\UrlCompressor\Storages\Storage;

class UrlEncoder implements IUrlEncoder
{
    public function __construct(private Storage $storage, private Algorithm $algorithm)
    {
    }

    public function encode(string $url): string
    {
        $this->validateUrl($url);
        $code = $this->storage->getByUrl($url);
        if (!is_null($code)) {
            return $code;
        }
        $code = $this->algorithm->encode($url);
        if (!$this->storage->store($code, $url)) {
            throw new \InvalidArgumentException("Can't store code for '$url'. Check storage.");
        }
        return $code;
    }

    private function validateUrl(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException("URL format of '$url' is not valid!");
        }
        if (!$this->urlExists($url)) {
            throw new \InvalidArgumentException("URL '$url' not reachable!");
        }
    }

    private function urlExists(string $url): bool
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $code == 200;
    }
}