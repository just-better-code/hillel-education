<?php

namespace Kulinich\Hillel\Foundation\Commands;

use Psr\Log\LoggerInterface;

class CliCommandHandler implements CommandHandler
{
    /** @var Command[] */
    private array $commands = [];
    private ?string $command;
    private array $params = [];

    public function __construct(
        array $commands,
        protected LoggerInterface $logger
    ) {
        $this->populateCommands($commands);
        $this->populateArgs();
    }

    private function populateCommands(array $commands): void
    {
        foreach ($commands as $cmd) {
            $cmd instanceof Command && $this->commands[$cmd->name()] = $cmd;
        }
    }

    private function populateArgs(): void
    {
        global $argv;
        $allArgs = $argv;
        $command = array_slice($allArgs, 1, 1);
        $this->command = $command ? reset($command) : null;
        $params = array_slice($allArgs, 2);
        $this->params = $params ?: [];
    }

    public function handle(): void
    {
        $cmd = $this->commands[$this->command] ?? null;
        if (!$cmd) {
            $this->logger->warning("Command '{$this->command}' not found;");
            return;
        }
        try {
            $this->logger->info("Running command {$cmd->name()}:" . PHP_EOL);
            $cmd->handle($this->params);
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }
    }
}