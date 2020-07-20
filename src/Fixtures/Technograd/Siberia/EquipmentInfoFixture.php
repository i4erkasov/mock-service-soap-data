<?php

namespace App\Fixtures\Technograd\Siberia;

use App\Documents\Equipment;
use App\Extensions\Fixtures\TechnogradSiberia;
//http://127.0.0.1:38900/siberia/technograd/1/cpe?wsdl
class EquipmentInfoFixture extends TechnogradSiberia
{
    /**
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function up()
    {
        $equipment = new Equipment([
                'equip_id'      => 123456,
                'serial_number' => 123456,
                'body'          => [
                    'Equipment' => [
                        'EquipmentId'            => '123456',
                        'TypeName'               => 'type',
                        'NomenclatureCode'       => 'code',
                        'NomenclatureName'       => 'name',
                        'Model'                  => 'model',
                        'DataType'               => 'order / client',
                        'TransferCondition'      => 'transfer condition',
                        'State'                  => 'new / used',
                        'Status'                 => 'в работе',
                        'SerialNumber'           => '123456',
                        'Characteristics'        => 'Characteristics',
                        'SupplierGuarantee'      => 'SupplierGuarantee',
                        'ClientGuarantee'        => 'ClientGuarantee',
                        'ClientGuaranteeEndDate' => '2010-20-20',
                        'ConsignmentName'        => 'ConsignmentName',
                        'ServicesId'             => 'ServicesId',
                    ],
                ],
            ]
        );

        $this->getDocumentManager()->persist($equipment);
        $this->getDocumentManager()->flush();

    }
}