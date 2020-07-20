<?php

namespace App\Documents;

use App\Common\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class WarehouseEquipment extends AbstractDocument
{
    /** @ODM\Field(name="warehouse_id", type="string") */
    private $warehouseId;

    public function __construct(array $data = [])
    {
        $this->warehouseId = $data['warehouseId'];
        $this->body        = $data['body'];
    }

    public function getWarehouseId(): ?int
    {
        return $this->warehouseId;
    }

    public function setWarehouseId(int $value): void
    {
        $this->warehouseId = $value;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}