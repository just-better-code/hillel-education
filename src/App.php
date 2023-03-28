<?php

namespace Kulinich\Hillel;

use Kulinich\Hillel\UrlCompressor\Contracts\IUrlDecoder;
use Kulinich\Hillel\UrlCompressor\Contracts\IUrlEncoder;
use Psr\Log\LoggerInterface;

final class App
{
    public function __construct(private LoggerInterface $logger)
    {
        $this->logger->info('App started.');
    }

    public function runEncode(IUrlEncoder $encoder, string $url): ?string
    {
        $code = null;
        $url = trim($url);
        try {
            $this->logger->info('Encoding started.');
            $code = $encoder->encode($url);
            $this->logger->info('Code resolved.', compact('code'));
        } catch (\InvalidArgumentException $exception) {
            $this->logger->warning($exception->getMessage());
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
        return $code;
    }

    public function runDecode(IUrlDecoder $decoder, string $code): ?string
    {
        $url = null;
        $code = trim($code);
        try {
            $this->logger->info('Decoding started.', compact('code'));
            $url = $decoder->decode($code);
            $this->logger->info('Url resolved.', compact('url'));
        } catch (\InvalidArgumentException $exception) {
            $this->logger->warning($exception->getMessage());
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
        return $url;
    }
}