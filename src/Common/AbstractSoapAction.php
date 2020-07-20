<?php

namespace App\Common;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

abstract class AbstractSoapAction
{
    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var Response
     */
    protected Response $response;

    /**
     * @var array
     */
    protected ?array $args;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param          $args
     *
     * @return Response
     * @throws \SoapFault
     */
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        try {
            if ($request->getMethod() === 'GET' && array_key_exists('wsdl', $request->getQueryParams())) {
                return $this->wsdl();
            }

            if ($request->getMethod() === 'POST') {
                return $this->execute();
            }

            throw new HttpBadRequestException($this->request, "Bad request");
        }
        catch (\SoapFault $soapEx) {
            throw new \SoapFault($soapEx->getCode(), $soapEx->getMessage());
        }
        catch (\Throwable $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    abstract protected function wsdl(): Response;

    abstract protected function execute(): Response;
}