<?php

namespace App\Services\Fixtures;

use App\Exceptions\AppException;
use App\Services\Fixtures\GroupFixtureConfig as Config;

abstract class GroupFixtures extends Fixture
{
    private Config $groupConfig;
    private string $fixtureDBName = '{prefix}_{group}';

    /**
     * @throws AppException
     */
    protected function init()
    {
        if (!method_exists($this, 'configure')) {
            throw new AppException('No configuration for Group Fixtures');
        }

        $this->configure();
        $this->buildDbName();
        $this->setDbName($this->fixtureDBName);
    }

    private function buildDbName()
    {
        $this->fixtureDBName = str_replace('{group}', $this->groupConfig->getGroup(), $this->fixtureDBName);
        $this->fixtureDBName = str_replace('{prefix}', $this->groupConfig->getPrefix() ?? '', $this->fixtureDBName);

        ltrim($this->fixtureDBName, '_');
    }

    /**
     * @param GroupFixtureConfig $config
     */
    public function setGroupConfig(Config $config): void
    {
        $this->groupConfig = $config;
    }

    /**
     * Используйте данный метод для кофигурирования Груповых Фикстур
     */
    abstract protected function configure(): void;
}