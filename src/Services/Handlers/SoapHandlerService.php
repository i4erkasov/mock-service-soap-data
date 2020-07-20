<?php

namespace App\Services\Handlers;

use App\Common\AbstractSoapHandler;
use App\Services\Data\DocumentManagerFactory;
use Psr\Container\ContainerInterface;

class SoapHandlerService
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string   $mrf
     * @param string   $wfm
     * @param string   $service
     * @param int|null $version
     *
     * @throws \SoapFault
     * @return AbstractSoapHandler
     */
    public function build(string $wfm, string $service, ?string $mrf = null, ?int $version = null): AbstractSoapHandler
    {
        $serviceSuffix = ucfirst($service);
        $setting       = $this->container->get('settings')['soapServices'];
        $handler       = trim($setting[$wfm]['handlerNameSpace'], '\\');

        if ($version) {
            $handler .= "\\Version{$version}";
        }

        $handler .= "\\{$serviceSuffix}SoapService";

        if (!class_exists($handler)) {
            throw new \SoapFault('BF-06', 'Request resource not found');
        }

        $dbname = (!is_null($mrf) ? "{$mrf}_": '') . $setting[$wfm]['defaultDB'];

        $dmf = $this->container->get(DocumentManagerFactory::class);

        /**@var AbstractSoapHandler $handler*/
        $handler = new $handler($dmf->setDbname($dbname)->getDocumentManager());

        return $handler->setVersion($version);
    }
}