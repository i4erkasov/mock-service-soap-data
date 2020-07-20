<?php

namespace App\Extensions\Fixtures;

use App\Services\Fixtures\GroupFixtureConfig;
use App\Services\Fixtures\GroupFixtures;

abstract class TechnogradSiberia extends GroupFixtures
{
    protected const SOAP_SERVICES = 'technograd';

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $setting = $this->container->get('settings')['soapServices'];

        $config = new GroupFixtureConfig();

        $config->setPrefix('siberia')
            ->setGroup($setting[static::SOAP_SERVICES]['defaultDB']);

        $this->setGroupConfig($config);
    }
}