<?php

namespace App\Handlers\Technograd\Version1;

use App\Common\AbstractSoapHandler;
use App\Documents\Equipment;
use App\Documents\WarehouseEquipment;


class CpeSoapService extends AbstractSoapHandler
{
    public function getEquipmentInfo(object $request)
    {
        $repository = $this->getDocumentManager()->getRepository(Equipment::class);

        switch ($request->ParamsType){
            case 'id':
                $find = ['equipId' => $request->ParamsValue];
                break;
            case 'sn':
            default:
                $find = ['serialNumber' => $request->ParamsValue];
                break;
        }

        /**@var Equipment $equipment */
        $equipment = $repository->findOneBy($find);

        if (!$equipment) {
            throw new \SoapFault('BF-001', 'Оборудование не найдено.');
        }


        return $equipment->getBody();
    }

    public function getWarehouseEquipments(object $request){
        /**@var WarehouseEquipment $warehouseEquipments */
        $warehouseEquipments = $this->getDocumentManager()->getRepository(WarehouseEquipment::class)
            ->findOneBy(['warehouseId' => $request->WarehouseId]);

        if (!$warehouseEquipments) {
            throw new \SoapFault('BF-001', "Рюкзак не найден WarehouseId: {$request->WarehouseId}");
        }

        return $warehouseEquipments->getBody();
    }
}