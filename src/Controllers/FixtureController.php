<?php

namespace App\Controllers;

use App\Common\AbstractController;
use App\Services\Cli\ApplicationCliService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FixtureController extends AbstractController
{
    public function init(Request $request, Response $response)
    {
        ApplicationCliService::run('fixture', 'up', [], true);

        $response->getBody()->write(json_encode([
            'status'  => 'wait',
            'message' => 'Waiting...',
        ]));

        $response->withHeader('Content-Type', 'application/json;charset=utf-8');

        return $response->withStatus(200);
    }

    public function status(Request $request, Response $response)
    {
        $running = (bool)ApplicationCliService::getCountRunning('fixture', 'up');

        $response->getBody()->write(json_encode([
            'status'  => $running ? 'wait' : 'done',
            'message' => $running ? 'Waiting....' : 'No running commands',
        ]));

        $response->withHeader('Content-Type', 'application/json;charset=utf-8');

        return $response->withStatus(200);
    }
}