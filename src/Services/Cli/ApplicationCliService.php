<?php

namespace App\Services\Cli;

use Psr\Container\ContainerInterface;

/**
 * Class ApplicationCliService
 *
 * Вспомогательный класс для запуска конольныз команд
 * непосредственно из кода
 *
 */
class ApplicationCliService
{
    /**
     * Метод используеться для запуска команд придожения непосредственно из конда
     *
     * @param string $command
     * @param string $method
     * @param array  $arguments
     * @param bool   $background
     */
    public static function run(string $command, string $method = '', array $arguments = [], bool $background = false): void
    {
        $command = self::buildCommand($command, $method, $arguments);

        $command = sprintf("php %s/bin/console {$command} 2>/dev/null >/dev/null", APP_DIR);

        if ($background) {
            $command = "nohup {$command} &";
        }

        static::exec($command);
    }

    /**
     * Метод возращает количество запущенных экземпляров команд прилодения
     *
     * @param string $command
     * @param string $method
     * @param array  $arguments
     *
     * @return int
     */
    public static function getCountRunning(string $command, string $method = '', array $arguments = []): int
    {
        $command = self::buildCommand($command, $method, $arguments);

        return (int)static::exec("ps aux | grep '{$command}' | grep -v 'grep' | wc -l");
    }

    /**
     * @param string $command
     *
     * @return string|null
     */
    public static function shellExec(string $command): ?string
    {
        return shell_exec($command);
    }

    /**
     * @param string $command
     *
     * @return string|null
     */
    public static function exec(string $command): ?string
    {
        return exec($command);
    }

    /**
     * @param string $command
     * @param string $method
     * @param array  $arguments
     *
     * @return string
     */
    private static function buildCommand(string $command, string $method = '', array $arguments = []): string
    {
        return trim(implode(' ', [
            $command,
            $method,
            $arguments ? implode(' ', $arguments) : '',
        ]));
    }
}