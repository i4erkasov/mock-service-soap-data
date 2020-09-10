<?php

namespace App\Services\Cli;

use Psr\Container\ContainerInterface;

abstract class Commands
{
    public const SUCCESS = 0;

    public const ERROR = 1;

    protected ContainerInterface $container;

    protected array $argv;

    public function __construct(ContainerInterface $container, array $argv)
    {
        $this->container = $container;
        $this->argv      = $argv;
    }

    public function run()
    {
        if (array_key_exists(2, $this->argv) && method_exists($this, $this->argv[2])) {
            $method = $this->argv[2];

            $this->$method();
        }
    }
}