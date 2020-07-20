<?php

namespace App\Services\Fixtures;

use App\Services\Data\DocumentManagerFactory;
use Doctrine\ODM\MongoDB\DocumentManager;
use Psr\Container\ContainerInterface;

abstract class Fixture
{
    protected FixtureConfig $config;

    protected ContainerInterface $container;

    private DocumentManagerFactory $dmf;

    private ?string $dbname = null;

    private static array $isDropDataBase = [];

    /**
     * Migration constructor.
     *
     * @param ContainerInterface $container
     * @param FixtureConfig      $config
     */
    public function __construct(ContainerInterface $container, FixtureConfig $config)
    {
        $this->container = $container;
        $this->config    = $config;

        /** @var DocumentManagerFactory $dmf */
        $this->dmf = $this->container->get(DocumentManagerFactory::class);

        if (method_exists($this, 'init')) {
            $this->init();
        }

        $this->dmf->setDbname($this->dbname);

        if(!in_array($this->getDbName(), self::$isDropDataBase)){
            $this->getDocumentManager()->getClient()->dropDatabase($this->getDbName());
        }

        array_push(self::$isDropDataBase, $this->getDbName());
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return static::class;
    }

    abstract public function up();

    /**
     * @param string $dbname
     */
    protected function setDbName(?string $dbname): void
    {
        $this->dbname = $dbname;
    }

    /**
     * @return string
     */
    protected function getDbName(): ?string
    {
        return $this->dbname ?? $this->getDocumentManager()->getConfiguration()->getDefaultDB();
    }

    protected function getDocumentManager(): DocumentManager
    {
        return $this->dmf->getDocumentManager();
    }
}