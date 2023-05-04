<?php

namespace Kulinich\Hillel\Foundation\Commands;

interface CommandHandler
{
    public function handle(): void;
}