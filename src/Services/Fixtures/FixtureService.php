<?php

namespace App\Services\Fixtures;

use Doctrine\Persistence\Mapping\Driver\PHPDriver;
use Psr\Container\ContainerInterface;
use function DI\string;

class FixtureService
{
    private FixtureConfig $config;

    private ContainerInterface $container;

    private array $files = [];

    public function __construct(ContainerInterface $container, FixtureConfig $config)
    {
        $this->container = $container;
        $this->config    = $config;
    }

    public function up()
    {
        echo "\e[34m====================== Fixtures Run ======================\e[0m" . PHP_EOL;
        echo PHP_EOL;

        $fixtures = $this->getFixtures($this->config->getPath());

        foreach ($fixtures as $fixture) {
            $object = new $fixture($this->container, $this->config);

            if ($object instanceof Fixture) {
                $object->up();

                echo "> \e[36m".(string)$object . "\e[0m\e[32m  done\e[0m" . PHP_EOL;
            }
        }

        echo PHP_EOL;
        echo "\e[34m====================== Fixtures Done =====================\e[0m". PHP_EOL;

        return;
    }

    private function getFixtures(string $path): array
    {
        $files = self::scandir($path);

        if ($files) {
            array_map(function ($file) use ($files) {
                if (is_dir($file)) {
                    array_map([$this, 'getFixtures'], [$file . '/']);
                }

                if (is_file($file)) {
                    $this->files[] = $file;
                }

            }, $files);

            foreach ($this->files as $file) {
                $fixtures[] = $this->getClass($file);
            }
        }

        return $fixtures ?? [];
    }

    private function getClass($filePath)
    {
        $contents          = file_get_contents($filePath);
        $namespace         = $class = "";
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
     * @param $path
     *
     * @return array
     */
    private static function scandir(string $path): array
    {
        $files = scandir($path);

        foreach ($files as $key => $file) {
            if (in_array($file, ['.', '..'])) {
                unset($files[$key]);
            } else {
                $result[] = $path . $file;
            }
        }

        return $result ?? [];
    }
}