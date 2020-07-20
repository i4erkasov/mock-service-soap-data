<?php

namespace App\Fixtures\Technograd\Siberia;

use App\Documents\WarehouseEquipment;
use App\Extensions\Fixtures\TechnogradSiberia;

class WarehouseEquipmentsFixture extends TechnogradSiberia
{
    /**
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function up()
    {
        $warehouseEquipments = new WarehouseEquipment(
            [
                'warehouseId' => 166976,
                'body'        => [
                    'EquipmentsShort' => [
                        [
                            'EquipmentId'      => '1234567',
                            'Model'            => 'КабельDC RPC',
                            'NomenclatureName' => 'Название которое может быть в номенклотуре Кабель DC RPC',
                            'SerialNumber'     => 'SB-1234567',
                            'Status'           => 'new',
                            'State'            => 'Готов к использованию',
                        ],
                        [
                            'EquipmentId'      => '7654321',
                            'Model'            => 'Другой кабель модель DC RPC',
                            'NomenclatureName' => 'Другое название которое может быть в номенклотуре Кабель DC RPC',
                            'SerialNumber'     => 'SB-7654321',
                            'Status'           => 'used',
                            'State'            => 'Готов к использованию',
                        ],
                        [
                            'EquipmentId'      => '12340987',
                            'Model'            => 'Еще другой кабель модель DC RPC',
                            'NomenclatureName' => 'Еще другое название которое может быть в номенклотуре Кабель DC RPC',
                            'SerialNumber'     => 'SB-12340987',
                            'Status'           => 'used',
                            'State'            => 'Не готов к использованию',
                        ],
                    ],
                ],
            ]
        );

        $this->getDocumentManager()->persist($warehouseEquipments);
        $this->getDocumentManager()->flush();
    }
}