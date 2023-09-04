<?php

namespace Xenon\BkashPhp;

use Xenon\BkashPhp\Handler\Exception\RenderException;
use Xenon\BkashPhp\Request\BkashRequest;
use Xenon\BkashPhp\Request\Token;

class BkashPhp
{
    private array $configuration;
    private array $header;
    private string $token;
    /**
     * @var mixed|true
     */
    private string $environment = 'sandbox';

    /**
     * @param array $configuration
     * @throws RenderException
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration['config'];
        $this->header = $configuration['headers'];
        $this->generateToken();
    }

    private function setHeader($header): void
    {
        $this->header = $header;
    }

    public function getHeader(): array
    {
        return $this->header;
    }

    public function getConfig(): array
    {
        return $this->configuration;
    }

    /**
     * Set Environment. For testing use "sandbox"
     * For live use "production"
     * @param string $sandboxEnvironment
     * @return BkashPhp
     */
    public function setEnvironment(string $sandboxEnvironment = 'sandbox'): BkashPhp
    {
        $this->environment = $sandboxEnvironment;
        return $this;
    }

    /**
     * @return mixed|string|true
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @throws RenderException
     */
    private function generateToken(): void
    {
        $this->token = Token::getToken($this);
    }

    /**
     * @return mixed
     */
    private function getToken()
    {
        return $this->token;
    }

    /**
     * @param array $paymentData
     * @return void
     * @throws RenderException
     */
    public function createTokenizedPayment(array $paymentData)
    {
        $this->setHeader($this->getAuthorization());
        $tokenRequestObject = new BkashRequest($this);
        $tokenRequestObject->setParams($paymentData);

        $paymentResponse = $tokenRequestObject->post('v1.2.0-beta/tokenized/checkout/create');

        if ($paymentResponse->getStatusCode() == 200) {
            $paymentObject = $paymentResponse->getContentsObject();
            echo "<pre>";
            print_r($paymentObject);
            echo '</pre>';
            exit;
        }
    }

    public function executePayment()
    {


    }

    public function queryPayment()
    {

    }

    public function searchTransaction()
    {

    }


    /**
     * @return string[]
     */
    private function getAuthorization(): array
    {
        return [
            "x-app-key" => $this->configuration['app_key'],
            "Content-Type" => "application/json",
            "Authorization" => $this->getToken(),
        ];
    }
}
