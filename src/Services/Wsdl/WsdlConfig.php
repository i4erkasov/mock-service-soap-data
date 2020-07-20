<?php

namespace App\Services\Wsdl;

class WsdlConfig
{
    private string $path;
    private array  $template;

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /**
     * @param array $template
     */
    public function setTemplate(array $template): void
    {
        $this->template = $template;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return array
     */
    public function getTemplate(): array
    {
        return $this->template;
    }
}