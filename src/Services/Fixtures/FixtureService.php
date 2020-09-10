<?php

namespace App\Services\Fixtures;

use Psr\Container\ContainerInterface;

class FixtureService
{
    private FixtureConfig $config;

    private ContainerInterface $container;

    public function __construct(ContainerInterface $container, FixtureConfig $config)
    {
        $this->container = $container;
        $this->config    = $config;
    }

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

    private function getFixtures(string $path): array
    {
        $files = self::scan($path);

        foreach ($files as $file) {
            $fixtures[] = $this->getClass($file->getRealPath());
        }

        return $fixtures ?? [];
    }

    private function getClass($filePath)
    {
        $contents         = file_get_contents($filePath);
        $namespace        = $class = "";
        $gettingNamespace = $gettingClass = false;

        foreach (token_get_all($contents) as $token) {
            if (is_array($token) && $token[0] == T_NAMESPACE) {
                $gettingNamespace = true;
            }

            if (is_array($token) && $token[0] == T_CLASS) {
                $gettingClass = true;
            }

            if ($gettingNamespace === true) {
                if (is_array($token) && in_array($token[0], [T_STRING, T_NS_SEPARATOR])) {
                    $namespace .= $token[1];
                } else {
                    if ($token === ';') {
                        $gettingNamespace = false;
                    }
                }
            }

            if ($gettingClass === true) {
                if (is_array($token) && $token[0] == T_STRING) {
                    $class = $token[1];

                    break;
                }
            }
        }

        return $namespace ? $namespace . '\\' . $class : $class;
    }

    /**
     * @param $dir
     *
     * @return \SplFileInfo[]
     */
    private static function scan(string $dir): array
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $dir, \RecursiveDirectoryIterator::SKIP_DOTS
            ),
        );

        return iterator_to_array($iterator, false);
    }
}