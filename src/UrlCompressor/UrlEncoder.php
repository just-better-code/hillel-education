<?php

namespace Kulinich\Hillel\UrlCompressor;

use Kulinich\Hillel\UrlCompressor\Algorithms\Algorithm;
use Kulinich\Hillel\UrlCompressor\Contracts\IUrlEncoder;
use Kulinich\Hillel\UrlCompressor\Storages\Storage;
use Kulinich\Hillel\UrlCompressor\Validators\UrlFormatValidator;
use Kulinich\Hillel\UrlCompressor\Validators\UrlReachableValidator;
use Kulinich\Hillel\UrlCompressor\Validators\ValidatorChain;
use Psr\Log\LoggerInterface;

class UrlEncoder implements IUrlEncoder
{
    private ValidatorChain $validators;

    public function __construct(
        private Storage $storage,
        private Algorithm $algorithm,
        private LoggerInterface $logger,
    ) {
        $this->validators = (new UrlFormatValidator())
            ->attach(new UrlReachableValidator());
    }

    public function encode(string $url): string
    {
        $this->validators->perform($url);
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
}
