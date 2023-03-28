<?php

namespace Kulinich\Hillel\UrlCompressor\Storages;

class FileStorage implements Storage
{
    private $handle;

    public function __construct(private string $filename)
    {
    }

    public function store(string $code, string $url): bool
    {
        return $this->writeInFile([trim($code) => trim($url)]);
    }

    public function getByCode(string $code): ?string
    {
        foreach ($this->readByLine() as $serialized) {
            $data = unserialize($serialized);
            if (array_key_exists(trim($code), $data)) {
                return reset($data);
            }
        }
        return null;
    }

    public function getByUrl(string $url): ?string
    {
        foreach ($this->readByLine() as $serialized) {
            $data = unserialize($serialized);
            if (in_array(trim($url), $data)) {
                return array_key_first($data);
            }
        }
        return null;
    }

    private function readByLine(): \Iterator
    {
        $this->handle = fopen($this->filename, "r+");
        if ($this->handle) {
            while (($line = fgets($this->handle)) !== false) {
                yield $line;
            }
        }
    }

    private function writeInFile(array $data): bool
    {
        $this->handle = fopen($this->filename, "a+");

        return $this->handle ? fputs($this->handle, serialize($data) . PHP_EOL) : false;
    }

    public function __destruct()
    {
        if ($this->handle) {
            fclose($this->handle);
        }
    }
}