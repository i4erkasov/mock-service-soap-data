<?php
declare(strict_types=1);

use App\Controllers\SoapController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {

    //TODO временно добавил не забыть удалить поле добавления в redis
    $app->get('/init/fixture[/]', function (Request $request, Response $response, $args) {
        $file = dirname(__DIR__) . '/var/cache/fixtures-status.json';

        if (!file_exists($file)) {
            file_put_contents($file, json_encode([
                'status'  => 'wait',
                'message' => 'Waiting...',
            ]));
        }

        $json = file_get_contents($file);
        $content = json_decode($json, true);

        if($content['status'] == 'done'){
            unlink($file);
        }

        $response->getBody()->write($json);
        $response->withHeader('Content-Type', 'application/json;charset=utf-8');

        return $response->withStatus(200);
    });

    $app->map(['GET', 'POST'], '/{mrf}/{wfm}/{version}/{service}[/]', SoapController::class);

    $app->map(['GET', 'POST'], '/{wfm}/{version}/{service}[/]', SoapController::class);

    $app->map(['GET', 'POST'], '/{wfm}/{service}[/]', SoapController::class);
};