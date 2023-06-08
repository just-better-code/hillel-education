<?php

namespace Kulinich\Hillel\Commands;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;
use Kulinich\Hillel\App;
use Kulinich\Hillel\Foundation\Commands\Command;
use Psr\Log\LoggerInterface;

class MigrateCommand implements Command
{
    private Manager $db;

    public function __construct(private LoggerInterface $logger)
    {
        $this->db = App::instance()->get('db');
    }

    public function name(): string
    {
        return 'migrate';
    }

    public function handle(array $params): void
    {
        if (in_array('--revert', $params)) {
            $this->down();
        } else {
            $this->up();
        }
    }

    public function up(): void
    {
        try {
            $this->db::schema()->create('url_codes', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code', 10)->unique();
                $table->string('url')->unique();
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
                $table->timestamp('created_at')->useCurrent();
            });
            $this->logger->info("Table 'url_codes' created.");
        } catch (\Exception $exception) {
            $this->logger->error('Migration failed');
            $this->logger->error($exception->getMessage());
        }
    }

    public function down(): void
    {
        try {
            $this->db::schema()->drop('url_codes');
            $this->logger->info("Table 'url_codes' deleted.");
        } catch (\Exception $exception) {
            $this->logger->error('Migration revert failed');
            $this->logger->error($exception->getMessage());
        }
    }
}