<?php

namespace App\Services\Fixtures;

class GroupFixtureConfig
{
    private string $group;

    private ?string $prefix = null;

    /**
     * @return string
     */
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     *
     * @return $this
     */
    public function setPrefix(string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @param string $group
     *
     * @return $this
     */
    public function setGroup(string $group): self
    {
        $this->group = $group;

        return $this;
    }
}