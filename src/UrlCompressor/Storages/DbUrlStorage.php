<?php

namespace Kulinich\Hillel\UrlCompressor\Storages;

use Kulinich\Hillel\App;
use Kulinich\Hillel\Models\UrlCode;

class DbUrlStorage implements UrlStorageInterface
{
    public function init(): void
    {
        App::instance()->get('db');
    }

    public function store(string $code, string $url): bool
    {
        return UrlCode::query()->upsert(compact('code', 'url'), []);
    }

    public function getByCode(string $code): ?string
    {
        return UrlCode::where('code', $code)->first('url');
    }

    public function getByUrl(string $url): ?string
    {
        return UrlCode::where('url', $url)->first('code');
    }
}