<?php

namespace App\Fixtures\Technograd\Siberia;

use App\Documents\Regions;
use App\Extensions\Fixtures\TechnogradSiberia;

class RegionsFixture extends TechnogradSiberia
{
    /**
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function up()
    {
        //@formatter:off
        $regions = [
            ['RegionId' => 1,      'RegionName' => 'Ростелеком',              'ParentId' => null],
            ['RegionId' => 2,      'RegionName' => 'Сибирь',                  'ParentId' => 1],
            ['RegionId' => 3,      'RegionName' => 'АЛТАЙСКИЙ ФИЛИАЛ',        'ParentId' => 2],
            ['RegionId' => 91,     'RegionName' => 'НОВОСИБИРСКИЙ ФИЛИАЛ',    'ParentId' => 2],
            ['RegionId' => 132,    'RegionName' => 'БУРЯТСКИЙ ФИЛИАЛ',        'ParentId' => 2],
            ['RegionId' => 159,    'RegionName' => 'ЗАБАЙКАЛЬСКИЙ ФИЛИАЛ',    'ParentId' => 2],
            ['RegionId' => 197,    'RegionName' => 'ИРКУТСКИЙ ФИЛИАЛ',        'ParentId' => 2],
            ['RegionId' => 243,    'RegionName' => 'КЕМЕРОВСКИЙ ФИЛИАЛ',      'ParentId' => 2],
            ['RegionId' => 276,    'RegionName' => 'КРАСНОЯРСКИЙ ФИЛИАЛ',     'ParentId' => 2],
            ['RegionId' => 358,    'RegionName' => 'ОМСКИЙ ФИЛИАЛ',           'ParentId' => 2],
            ['RegionId' => 396,    'RegionName' => 'ТОМСКИЙ ФИЛИАЛ',          'ParentId' => 2]
        ];
        //@formatter:on

        $documentManager = $this->getDocumentManager();

        foreach ($regions as $region){
            $regions = new Regions($region);

            $documentManager->persist($regions);
        }

        $documentManager->flush();

    }
}