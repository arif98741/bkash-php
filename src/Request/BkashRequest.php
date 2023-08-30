<?php

namespace Xenon\BkashPhp\Request;

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
    private string $environment = 'sandbox';
    private array $headers;
    private array $params;
    private $responseBody;
    private string $requestEndpoint;
    private object $response;
    private int $statusCode;

    public function __construct()
    {

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
     * @return BkashRequest
     * @throws RenderException
     */
    public function get(string $requestEndpoint)
    {
        $client = new Client(['base_uri' => $this->baseUrl]);
        $this->requestEndpoint = $requestEndpoint;

        try {
            $options = [
                'headers' => $this->getHeader(),
                'query' => $this->getRequestParams(),
            ];

            $response = $client->get($this->requestFullString, $options);
            $this->statusCode = $response->getStatusCode();
            $this->response = $response;
            $this->responseBody = $response->getBody();
            return $this;

        } catch (\Exception|GuzzleException $e) {
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

        } catch (\Exception|GuzzleException $e) {

            throw new RenderException($e->getMessage());
        }
    }



}
