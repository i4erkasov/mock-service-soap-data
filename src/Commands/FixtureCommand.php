<?php

namespace App\Commands;

use App\Services\Cli\Commands;
use App\Services\Fixtures\FixtureService;
use App\Traits\LockableTrait;

class FixtureCommand extends Commands
{
    use LockableTrait;

    protected function up()
    {
        set_time_limit(0);

        if ($this->lock(basename(__FILE__, '.php'))) {
            return Commands::SUCCESS;
        }

        $migrationService = $this->container->get(FixtureService::class);

        echo "\e[34m====================== Fixtures Run ======================\e[0m" . PHP_EOL;
        echo PHP_EOL;

        $completed = $migrationService->up();

        foreach ($completed as $item) {
            echo "> \e[36m{$item}\e[0m\e[32m  done\e[0m" . PHP_EOL;
        }

        echo PHP_EOL;
        echo "\e[34m====================== Fixtures Done =====================\e[0m" . PHP_EOL;

        return Commands::SUCCESS;
    }
}