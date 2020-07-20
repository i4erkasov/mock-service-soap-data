<?php

namespace App\Services\Data;

use Doctrine\ODM\MongoDB\DocumentManager;

class DocumentManagerFactory
{
    /**
     * DocumentManager created by Symfony.
     *
     * @var DocumentManager
     */
    private DocumentManager $defaultDocumentManager;

    /**
     * All DocumentManagers created by Factory so far.
     *
     * @var DocumentManager[]
     */
    private static array $instances = [];

    /**
     * @var string|null $databaseName
     */
    private ?string $databaseName = null;

    /**
     * DocumentManagerFactory constructor.
     *
     * @param DocumentManager $dm
     */
    public function __construct(DocumentManager $dm)
    {
        $this->defaultDocumentManager = $dm;
    }

    /**
     * @param string|null $databaseName
     *
     * @return $this
     */
    public function setDbname(?string $databaseName = null): self
    {
        $this->databaseName = $databaseName;

        return $this;
    }

    /**
     * @return DocumentManager
     */
    public function getDocumentManager(): DocumentManager
    {
        if (!$this->databaseName) {
            return $this->defaultDocumentManager;
        }

        if (isset(self::$instances[$this->databaseName])) {
            return self::$instances[$this->databaseName];
        }

        $configuration = clone $this->defaultDocumentManager->getConfiguration();

        $configuration->setDefaultDB($this->databaseName);

        return self::$instances[$this->databaseName] = DocumentManager::create(
            $this->defaultDocumentManager->getClient(),
            $configuration,
            $this->defaultDocumentManager->getEventManager()
        );
    }
}