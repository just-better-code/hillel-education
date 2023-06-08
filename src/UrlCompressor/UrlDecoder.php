<?php

namespace Kulinich\Hillel\UrlCompressor;

use Kulinich\Hillel\UrlCompressor\Algorithms\EncodingAlgorithmInterface;
use Kulinich\Hillel\UrlCompressor\Contracts\IUrlDecoder;
use Kulinich\Hillel\UrlCompressor\Storages\UrlStorageInterface;
use Psr\Log\LoggerInterface;

class UrlDecoder implements IUrlDecoder
{
    public function __construct(
        private UrlStorageInterface $storage,
        private EncodingAlgorithmInterface $algorithm,
        private LoggerInterface $logger
    ) {
    }

    public function decode(string $code): string
    {
        if (!$this->algorithm->validate($code)) {
            $msg = "Code '$code' has invalid format!";
            $this->logger->error($msg);
            throw new \InvalidArgumentException($msg);
        }
        $url = $this->storage->getByCode($code);
        if (empty($url)) {
            $msg = "URL by code '$code' not found!";
            $this->logger->error($msg);
            throw new \InvalidArgumentException($msg);
        }
        return $url;
    }
}
