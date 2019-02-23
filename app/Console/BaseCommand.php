<?php

namespace App\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BaseCommand extends Command
{
    protected function verbose(callable $callable)
    {
        if ($this->option('verbose')) {
            $callable();
        }
    }

    protected function logInfo($message)
    {
        $this->line($message);
        Log::info($message);
    }

    protected function logError($message)
    {
        $this->error($message);
        Log::error($message);
    }
}