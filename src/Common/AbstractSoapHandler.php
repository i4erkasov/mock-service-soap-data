<?php

namespace App\Common;

use Doctrine\ODM\MongoDB\DocumentManager;

abstract class AbstractSoapHandler
{
    private DocumentManager $dm;
    private ?int            $version = null;

    /**
     * BaseHandler constructor.
     *
     * @param DocumentManager $dm
     */
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function getDocumentManager(): DocumentManager
    {
        return $this->dm;
    }

    /**
     * @return int|null
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * @param int $version
     *
     * @return $this
     */
    public function setVersion(int $version): self
    {
        $this->version = $version;

        return$this;
    }
}