<?php

namespace App\Services\Cli;

use Psr\Container\ContainerInterface;

class CliServices
{
    private ContainerInterface $container;

    /**
     * CliServices constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param array $argv
     */
    public function run(array $argv): void
    {
        if (array_key_exists(1, $argv) && class_exists('App\Commands\\' . ucfirst($argv[1]) . 'Command')) {
            $class   = 'App\Commands\\' . ucfirst($argv[1]) . 'Command';
            $command = new $class($this->container, $argv);

            if ($command instanceof Commands) {
                $command->run();
            }
        }
    }
}