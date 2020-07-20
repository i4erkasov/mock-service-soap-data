<?php

namespace App\Documents;

use App\Common\AbstractDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Workers extends AbstractDocument
{
    /** @ODM\Id */
    private $id;

    /** @ODM\Field(name="worker_id", type="integer") */
    private $workerId;

    /** @ODM\Field(name="login", type="string") */
    private $login;

    /** @ODM\Field(name="password", type="string") */
    private $password;

    public function __construct(array $data = [])
    {
        $this->workerId = (int)$data['worker_id'];
        $this->login = $data['login'];
        $this->password = $data['password'];
        $this->body = $data['body'];
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getWorkerId(): ?int
    {
        return $this->workerId;
    }

    public function setWorkerId(int $value): void
    {
        $this->workerId = $value;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $value): void
    {
        $this->login = $value;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $value): void
    {
        $this->password = $value;
    }
}