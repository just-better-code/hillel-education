<?php

namespace Kulinich\Hillel\Commands;

use Kulinich\Hillel\Foundation\Commands\Command;
use Kulinich\Hillel\UrlCompressor\Contracts\IUrlDecoder;
use Kulinich\Hillel\UrlCompressor\Contracts\IUrlEncoder;
use Psr\Log\LoggerInterface;

class DecodeCommand implements Command
{
    public function __construct(
        private IUrlDecoder $decoder,
        private LoggerInterface $logger,
    ) {
    }

    public function name(): string
    {
        return 'decode';
    }

    public function handle(array $params): void
    {
        $code = trim($params[0] ?? '');
        try {
            $this->logger->info('Decoding started.', compact('code'));
            $url = $this->decoder->decode($code);
            $this->logger->info('Url resolved.', compact('url'));
        } catch (\InvalidArgumentException $exception) {
            $this->logger->warning($exception->getMessage());
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}