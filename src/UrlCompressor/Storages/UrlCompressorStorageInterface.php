<?php

namespace Kulinich\Hillel\UrlCompressor\Storages;

interface UrlCompressorStorageInterface
{
    public function store(string $code, string $url): bool;

    public function getByCode(string $code): ?string;

    public function getByUrl(string $url): ?string;
}