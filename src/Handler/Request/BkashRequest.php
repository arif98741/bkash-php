<?php

namespace Xenon\BkashPhp\Handler\Request;

class BkashRequest
{
    /**
     * base url of bkash payment gateway. This will be overwrite in production environment
     * @var string
     */
    private string $baseUrl = 'https://tokenized.sandbox.bka.sh';
    private string $environment = 'sandbox';
    private array $headers;
    private array $params;
    private $responseBody;

    public function __construct()
    {

    }

}
