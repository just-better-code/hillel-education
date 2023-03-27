<?php

namespace Kulinich\Hillel\UrlCompressor\Storages;

class FileStorage implements Storage
{
    private const FILENAME = __DIR__ . '/../../../storage/file_storage.txt';

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
        $handle = fopen(self::FILENAME, "r+");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                yield $line;
            }

            fclose($handle);
        }
    }

    private function writeInFile(array $data): bool
    {
        $handle = fopen(self::FILENAME, "a+");
        fputs($handle, serialize($data) . PHP_EOL);
        return fclose($handle);
    }
}