<?php

namespace App\Services\Fixtures;

use App\Utils\Directory;
use App\Utils\PhpFileClass;
use Psr\Container\ContainerInterface;

class FixtureService
{
    private FixtureConfig $config;

    private ContainerInterface $container;

    /**
     * FixtureService constructor.
     *
     * @param ContainerInterface $container
     * @param FixtureConfig      $config
     */
    public function __construct(ContainerInterface $container, FixtureConfig $config)
    {
        $this->container = $container;
        $this->config    = $config;
    }

    /**
     * @return array
     */
    public function up(): array
    {
        $fixtures = $this->getFixtures($this->config->getPath());

        foreach ($fixtures as $fixture) {
            $object = new $fixture($this->container, $this->config);

            if ($object instanceof Fixture) {
                $object->up();

                $completed[] = (string)$object;
            }
        }

        return $completed ?? [];
    }

    /**
     * @param string $path
     *
     * @return array
     */
    private function getFixtures(string $path): array
    {
        foreach (Directory::scan($path) as $file) {
            $fixtures[] = PhpFileClass::getClassName($file->getRealPath());
        }

        return $fixtures ?? [];
    }
}