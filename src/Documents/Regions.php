<?php

namespace App\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Regions
{
    /** @ODM\Id */
    private $id;

    /** @ODM\Field(type="integer") */
    private $RegionId;

    /** @ODM\Field(type="string") */
    private $RegionName;

    /** @ODM\Field(type="integer") */
    private $ParentId;

    public function __construct(array $data)
    {
        $this->RegionId   = $data['RegionId'];
        $this->RegionName = $data['RegionName'];
        $this->ParentId   = $data['ParentId'];
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getRegionId(): ?int
    {
        return $this->RegionId;
    }

    public function setRegionId(int $value): void
    {
        $this->RegionId = $value;
    }

    public function getRegionName(): ?string
    {
        return $this->RegionName;
    }

    public function setRegionName(string $value): void
    {
        $this->RegionName = $value;
    }

    public function getParentId(): ?string
    {
        return $this->ParentId;
    }

    public function setParentId(int $value): void
    {
        $this->ParentId = $value;
    }
}