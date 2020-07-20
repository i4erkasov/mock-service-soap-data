<?php

namespace App\Common;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\MappedSuperclass */
class AbstractDocument
{
    /** @ODM\Id */
    private $id;

    /** @ODM\Field(
     *     type="integer",
     *     name="version",
     *     nullable=true)
     */
    protected $version = null;

    /** @ODM\Field(name="body", type="hash") */
    protected $body;

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($value): void
    {
        $this->version = $value;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function setBody($value): void
    {
        $this->body = $value;
    }
}