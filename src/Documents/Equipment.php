<?php

namespace App\Documents;

use App\Common\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Equipment extends AbstractDocument
{
    /** @ODM\Field(name="equip_id", type="string") */
    private $equipId;

    /** @ODM\Field(name="serial_number", type="string") */
    private $serialNumber;

    public function __construct(array $data = [])
    {
        $this->equipId      = (int)$data['equip_id'];
        $this->serialNumber = $data['serial_number'];
        $this->body         = $data['body'];
    }

    public function getEquipId(): ?int
    {
        return $this->equipId;
    }

    public function setEquipId(int $value): void
    {
        $this->equipId = $value;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(string $value): void
    {
        $this->serialNumber = $value;
    }
}