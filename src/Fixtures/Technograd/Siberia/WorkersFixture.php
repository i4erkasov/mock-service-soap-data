<?php

namespace App\Fixtures\Technograd\Siberia;

use App\Documents\Workers;
use App\Extensions\Fixtures\TechnogradSiberia;

class WorkersFixture extends TechnogradSiberia
{
    /**
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function up()
    {
        $worker = new Workers(
            [
                'worker_id' => 123456789,
                'login'     => 'di_siberia',
                'password'  => 'test',
                'body'   => [
                    'Surname'      => 'Иванов',
                    'Name'         => 'Сергей',
                    'Patronymic'   => 'Петрович',
                    'ContactPhone' => '79111111111',
                    'LoginWfm'     => 'di_siberia',
                    'RegionId'     => '91',
                    'ContactType'  => 'Штат',
                    'ContactName'  => '35/18',
                    'IsLocked'     => false,
                    'Departaments' => [
                        'DepartamentsId'   => '20661',
                        'DepartamentsName' => 'ГРУППА ИНСТАЛЛЯТОРОВ|Инсталляции|ЦСТП|Новосибирский филиал|МРФ Сибирь|Ростелеком',
                        'Worksites'        => [
                            'WorksiteId'   => '20861',
                            'WorksiteName' => 'ЛЕВЫЙ БЕРЕГ',
                        ],
                    ],
                    'StartRoute'   => [
                        'OrponId' => '23456789',
                        'AddressText' => 'ул. Семьи-Шамшиных д. 35',
                        'Location' => [
                            'Latitude'  => '54.988217',
                            'Longitude' => '82.901002',
                        ],
                        'BuildingType' => 'Тест',
                        'CommentAddress' => 'Тестовый коментарий'
                    ]
                    ,
                ],
            ]
        );

        $this->getDocumentManager()->persist($worker);
        $this->getDocumentManager()->flush();

    }
}