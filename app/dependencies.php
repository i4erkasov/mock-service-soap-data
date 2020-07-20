<?php
declare(strict_types=1);

use App\Services\Data\DocumentManagerFactory;
use App\Services\Cli\CliServices;
use App\Services\Fixtures\FixtureConfig;
use App\Services\Fixtures\FixtureService;
use App\Services\Handlers\SoapHandlerService;
use App\Services\Wsdl\WsdlConfig;
use App\Services\Wsdl\WsdlService;
use DI\ContainerBuilder;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Doctrine\ODM\MongoDB\Configuration;
use MongoDB\Client;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions(
        [
            DocumentManagerFactory::class => function (ContainerInterface $c) {
                $settings = $c->get('settings')['doctrine'];
                $client   = new Client($settings['connection'], [], ['typeMap' => DocumentManager::CLIENT_TYPEMAP]);
                $config   = new Configuration();

                $config->setProxyNamespace($settings['params']['proxy_ns']);
                $config->setProxyDir($settings['params']['proxy_dir']);
                $config->setHydratorDir($settings['params']['hydrator_dir']);
                $config->setHydratorNamespace($settings['params']['hydrator_ns']);
                $config->setDefaultDB($settings['dbname']);
                $config->setMetadataDriverImpl(AnnotationDriver::create(__DIR__ . '/../src/Documents'));
                $config->setMetadataCacheImpl(new ArrayCache());

                $dm = DocumentManager::create($client, $config);

                return (new DocumentManagerFactory($dm));
            },

            FixtureService::class => function (ContainerInterface $c) {
                $settings = $c->get('settings')['fixtures'];
                $config   = new FixtureConfig();

                $config->setPath($settings['basePath']);

                return new FixtureService($c, $config);
            },

            SoapHandlerService::class => function (ContainerInterface $c) {
                return new SoapHandlerService($c);
            },

            CliServices::class => function (ContainerInterface $c) {
                return new CliServices($c);
            },

            WsdlService::class => function (ContainerInterface $c) {
                $settings = $c->get('settings')['resources'];
                $config = new WsdlConfig();

                $config->setPath($settings['basePath']);
                $config->setTemplate($settings['template']);

                return new WsdlService($config);
            },

        ]);
};
