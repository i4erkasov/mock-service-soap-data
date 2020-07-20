<?php

namespace App\Services\Wsdl;

final class WsdlService
{
    private WsdlConfig  $config;
    private ?string     $filePath = null;

    /**
     * WsdlService constructor.
     *
     * @param WsdlConfig $config
     */
    public function __construct(WsdlConfig $config)
    {
        $this->config = $config;
    }

    public function createResource(array $inputParams)
    {

        $template = $this->config->getTemplate();
        $requiredParams = $template['required'];
        $inputParamsKey = array_keys($inputParams);
        $arrayDiff      = array_diff($requiredParams, $inputParamsKey);

        if (!empty($arrayDiff)) {
            throw new \Exception("Missing required parameter " . implode(',', $arrayDiff));
        }

        $delimiter      = $template['delimiter'];
        $basePath       = $this->config->getPath();
        $templateString = trim($template['string'], $delimiter);
        $arrayMacros    = explode($delimiter, $templateString);

        foreach ($arrayMacros as $macros) {
            if (isset($inputParams[$macros]) && $inputParams[$macros]) {
                $basePath .= $inputParams[$macros] . $delimiter;
            }
        }

        $this->filePath = rtrim($basePath, '/') . '.wsdl';

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function getFileContent(): string
    {
        if (!file_exists($this->filePath)) {
            throw new \SoapFault('BF-05', 'Request ' . $this->filePath . ' not found');
        }

        return file_get_contents($this->filePath);
    }
}