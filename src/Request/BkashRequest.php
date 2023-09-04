<?php

namespace Xenon\BkashPhp\Request;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Xenon\BkashPhp\Handler\Exception\RenderException;

class BkashRequest
{
    /**
     * base url of bkash payment gateway. This will be overwritten in production environment
     * @var string
     */
    private string $baseUrl = 'https://tokenized.sandbox.bka.sh';
    private array $headers;
    private array $params;
    private $responseBody;
    private string $requestEndpoint;
    private object $response;
    private int $statusCode;
    private string $environment;
    private mixed $requestObject;
    private $requestFullString;

    /**
     * @param $requestObject
     */
    public function __construct($requestObject)
    {
        $this->requestObject    = $requestObject;
        $this->headers          = $this->requestObject->getHeader();
        $this->params           = $this->requestObject->getConfig();
        $this->environment      = $this->requestObject->getEnvironment();
        if ($this->environment == 'production') {
            $this->baseUrl = 'https://github.com';
        }

    }

    private function getHeader()
    {
        return $this->headers;
    }

    private function getRequestParams()
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return $this->responseBody->getContents();
    }

    /**
     * @return mixed
     */
    public function getContentsObject()
    {
        return json_decode($this->responseBody->getContents());
    }

    public function getResponse(): object
    {
        return $this->response;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return BkashRequest
     * @throws RenderException
     */
    public function get(string $requestEndpoint)
    {
        $client = new Client(['base_uri' => $this->baseUrl]);
        $this->requestEndpoint = $requestEndpoint;

        try {
            $options = [
                'headers'   => $this->getHeader(),
                'query'     => $this->getRequestParams(),
            ];

            $response           = $client->get($this->requestFullString, $options);
            $this->statusCode   = $response->getStatusCode();
            $this->response     = $response;
            $this->responseBody = $response->getBody();
            return $this;

        } catch (Exception|GuzzleException $e) {
            throw new RenderException($e->getMessage());
        }
    }

    /**
     * @param string $requestEndpoint
     * @return $this
     * @throws RenderException
     */
    public function post(string $requestEndpoint)
    {
        $client = new Client(['base_uri' => $this->baseUrl]);
        $this->requestEndpoint = $requestEndpoint;

        try {
            $options = [
                'headers' => $this->getHeader(),
                'json' => $this->getRequestParams(),
            ];

            $response = $client->post($this->requestEndpoint, $options);

            $this->statusCode = $response->getStatusCode();
            $this->response = $response;
            $this->responseBody = $response->getBody();
            return $this;

        } catch (Exception|GuzzleException $e) {

            throw new RenderException($e->getMessage());
        }
    }

    /**
     * @param array $paramData
     * @return void
     */
    public function setParams(array $paramData)
    {
        $this->params = $paramData;
    }

}
