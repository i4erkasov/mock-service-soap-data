<?php
declare(strict_types=1);

use App\Controllers\SoapController;
use App\Controllers\FixtureController;
use Slim\App;

return function (App $app) {
    $app->get('/fixture/init[/]', FixtureController::class . ':init');

    $app->get('/fixture/status[/]', FixtureController::class . ':status');

    $app->map(['GET', 'POST'], '/{mrf}/{wfm}/{version}/{service}[/]', SoapController::class);

    $app->map(['GET', 'POST'], '/{wfm}/{version}/{service}[/]', SoapController::class);

    $app->map(['GET', 'POST'], '/{wfm}/{service}[/]', SoapController::class);
};