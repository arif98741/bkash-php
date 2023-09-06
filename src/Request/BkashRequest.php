<?php

namespace Xenon\BkashPhp\Request;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use Xenon\BkashPhp\Handler\Exception\RenderBkashPHPException;

class BkashRequest
{
    /**
     * base url of bkash payment gateway. This will be overwritten in production environment
     * @var string
     */
    private string $baseUrl = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta/';
    private array $headers;
    private array $params;
    private $responseBody;
    private string $requestEndpoint;
    private object $response;
    private int $statusCode;
    private string $environment;
    private mixed $requestObject;
    /**
     * @param $requestObject
     */
    public function __construct($requestObject)
    {
        $this->requestObject    = $requestObject;
        $this->headers          = $this->requestObject->getHeader();
        $this->params           = $this->requestObject->getConfig();
        $this->environment      = $this->requestObject->getEnvironment();

        if ($this->environment === 'production') {
            $this->baseUrl = 'https://tokenized.pay.bka.sh/v1.2.0-beta/';
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
        return json_decode($this->getContents(), false);
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
     * @param string $requestEndpoint
     * @return $this
     * @throws RenderBkashPHPException
     */
    public function get(string $requestEndpoint)
    {
        $client = $this->getClient($requestEndpoint);

        try {
            $options = [
                'headers'   => $this->getHeader(),
                'query'     => $this->getRequestParams(),
            ];

            $response           = $client->request('get',$this->requestEndpoint, $options);
            $this->statusCode   = $response->getStatusCode();
            $this->response     = $response;
            $this->responseBody = $response->getBody();
            return $this;

        } catch (Exception|GuzzleException $e) {
            throw new RenderBkashPHPException($e->getMessage());
        }
    }

    /**
     * @param string $requestEndpoint
     * @return $this
     * @throws RenderBkashPHPException
     */
    public function post(string $requestEndpoint)
    {
        $client = $this->getClient($requestEndpoint);

        try {
            $options = [
                'headers' => $this->getHeader(),
                'json' => $this->getRequestParams(),
            ];

            $response = $client->request('post',$this->requestEndpoint, $options);

            $this->statusCode   = $response->getStatusCode();
            $this->response     = $response;
            $this->responseBody = $response->getBody();
            return $this;

        } catch (Exception|GuzzleException $e) {

            throw new RenderBkashPHPException($e->getMessage());
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

    /**
     * @param string $requestEndpoint
     * @return Client
     */
    private function getClient(string $requestEndpoint): Client
    {
        $client = new Client(['base_uri' => $this->baseUrl]);
        $this->requestEndpoint = $requestEndpoint;
        return $client;
    }

}
