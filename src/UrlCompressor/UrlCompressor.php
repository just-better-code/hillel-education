<?php

namespace Kulinich\Hillel\UrlCompressor;

use Kulinich\Hillel\UrlCompressor\Encoders\Encoder;
use Kulinich\Hillel\UrlCompressor\Storages\Storage;

class UrlCompressor
{
    public function __construct(private Storage $storage, private Encoder $encoder)
    {
    }

    public function store(string $url): string
    {
        $this->validateUrl($url);
        $code = $this->storage->getByUrl($url);
        if (!is_null($code)) {
            return $code;
        }
        $code = $this->encoder->encode($url);
        if (!$this->storage->store($code, $url)) {
            throw new \Exception("Can't store code for '$url'. Check storage.");
        }
        return $code;
    }

    public function fetch(string $code): ?string
    {
        if (!$this->encoder->validate($code)) {
            throw new \InvalidArgumentException("Code '$code' has invalid format!");
        }
        $url = $this->storage->getByCode($code);
        if (empty($url)) {
            throw new \InvalidArgumentException("URL be code '$code' not found!");
        }
        return $url;
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