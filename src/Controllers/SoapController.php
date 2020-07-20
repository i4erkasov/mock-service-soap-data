<?php

namespace App\Controllers;

use App\Common\AbstractSoapAction;
use App\Services\Handlers\SoapHandlerService;
use App\Services\Wsdl\WsdlService;
use Laminas\Soap\Server;
use Psr\Http\Message\ResponseInterface as Response;

class SoapController extends AbstractSoapAction
{
    /**
     * @throws \SoapFault
     * @throws \Exception
     * @return Response
     */
    public function wsdl(): Response
    {
        /**
         * @var string $wfm
         * @var string $version
         * @var string $service
         */
        extract($this->args);

        $wsdlService = $this->container->get(WsdlService::class);

        $wsdl = $wsdlService->createResource([
            '{wfm}'     => $wfm,
            '{version}' => isset($version) ? "v{$version}" : null,
            '{service}' => $service,
        ])->getFileContent();

        $this->response->getBody()->write($wsdl);
        $this->response->withHeader('Content-Type', 'application/xml;charset=utf-8');

        return $this->response;
    }

    /**
     * @throws \SoapFault
     * @throws \Exception
     * @return Response
     */
    public function execute(): Response
    {
        /**
         * @var string $mrf
         * @var string $wfm
         * @var string $version
         * @var string $service
         */
        extract($this->args);

        $wsdlService = $this->container->get(WsdlService::class);

        $wsdl = $wsdlService->createResource([
            '{wfm}'     => $wfm,
            '{version}' => isset($version) ? "v{$version}" : null,
            '{service}' => $service,
        ])->getFilePath();

        $server = new Server($wsdl);

        $soapHandler = $this->container->get(SoapHandlerService::class);

        $class = $soapHandler->build($wfm, $service, $mrf ?? null, $version ?? null);

        $server->setClass($class)
            ->setReturnResponse(true);

        $this->response->getBody()->write($server->handle());
        $this->response->withHeader('Content-Type', 'application/xml;charset=utf-8');

        return $this->response;
    }
}