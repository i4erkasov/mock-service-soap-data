<?php
declare(strict_types=1);

use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions(
        [
            'settings' => [
                'displayErrorDetails' => true,
                'doctrine'            => [
                    'params'     => [
                        'hydrator_ns'    => 'Hydrators',
                        'proxy_ns'       => 'Proxies',
                        'hydrator_dir'   => dirname(__DIR__) . '/var/cache/hydrators',
                        'proxy_dir'      => dirname(__DIR__) . '/var/cache/proxies',
                        'documents_path' => dirname(__DIR__) . '/src/Documents',
                    ],
                    'dbname'     => getenv('MONGODB_DATA_BASE'),
                    'connection' => sprintf(
                        'mongodb://%1$s:%2$s@%3$s:27017',
                        getenv('MONGODB_USER'),
                        getenv('MONGODB_PASS'),
                        getenv('MONGODB_HOST'),
                    ),
                ],
                'fixtures'            => [
                    'basePath' => dirname(__DIR__) . '/src/Fixtures/',
                ],
                'resources'           => [
                    'basePath' => dirname(__DIR__) . '/resources/',
                    'template' => [
                        'delimiter' => '/',
                        'string'    => '{wfm}/{version}/{service}',
                        'required'  => [
                            '{wfm}',
                            '{service}',
                        ],
                    ],
                ],
                'soapServices'        => [
                    'argus'      => [
                        'name'        => 'Argus',
                        'description' => 'argus soap services',
                        'defaultDB'   => getenv('ARGUS_MONGODB_DATA_BASE'),
                    ],
                    'technograd' => [
                        'name'             => 'Technograd',
                        'description'      => 'technograd soap services',
                        'defaultDB'        => getenv('TEHNOGRAD_MONGODB_DATA_BASE'),
                        'handlerNameSpace' => 'App\Handlers\Technograd',
                    ],
                    'orpon'      => [
                        'name'             => 'Orpon',
                        'description'      => 'orpon soap services',
                        'defaultDB'        => getenv('ORPON_MONGODB_DATA_BASE'),
                        'handlerNameSpace' => 'App\Handlers\Orpon',
                    ],
                ],
            ],
        ]);
};