<?php

namespace App\Commands;

use App\Services\Cli\Commands;
use App\Services\Fixtures\FixtureService;

class FixtureCommand extends Commands
{
    protected function up()
    {
        $migrationService = $this->container->get(FixtureService::class);

        $migrationService->up();
    }

    protected function start()
    {
        $file = dirname(__DIR__) . '/../var/cache/fixtures-status.json';

        if (!file_exists($file)) {
            return;
        }

        $content = json_decode(file_get_contents($file), true);

        if ($content['status'] != 'wait') {
            return;
        }

        try {
            $migrationService = $this->container->get(FixtureService::class);

            $migrationService->up();

            file_put_contents($file, $json = json_encode([
                'status'  => 'done',
                'message' => 'Fixtures init done',
            ]));

        } catch (\Exception $ex) {
            file_put_contents($file, json_encode([
                'status'  => 'error',
                'message' => $ex->getMessage(),
            ]));
        }
    }
}