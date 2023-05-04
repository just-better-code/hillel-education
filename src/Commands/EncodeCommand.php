<?php

namespace Kulinich\Hillel\Commands;

use Kulinich\Hillel\Foundation\Commands\Command;
use Kulinich\Hillel\UrlCompressor\Contracts\IUrlEncoder;
use Psr\Log\LoggerInterface;

class EncodeCommand implements Command
{
    public function __construct(
        private IUrlEncoder $encoder,
        private LoggerInterface $logger,
    ) {
    }

    public function name(): string
    {
        return 'encode';
    }

    public function handle(array $params): void
    {
        $url = trim($params[0] ?? '');
        try {
            $this->logger->info('Encoding started.', compact('url'));
            $code = $this->encoder->encode($url);
            $this->logger->info('Code resolved.', compact('code'));
        } catch (\InvalidArgumentException $exception) {
            $this->logger->error($exception->getMessage());
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}