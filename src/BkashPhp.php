<?php

namespace Xenon\BkashPhp;

use JsonException;
use Xenon\BkashPhp\Handler\Exception\RenderBkashPHPException;
use Xenon\BkashPhp\Request\Payment;
use Xenon\BkashPhp\Request\Token;

class BkashPhp
{
    private array $configuration;
    private array $header;
    private string $token;
    /**
     * @var mixed|true
     */
    private string $environment;

    /**
     * @param array $configuration
     * @param string $environment
     * @throws RenderBkashPHPException
     */
    public function __construct(array $configuration, string $environment = 'sandbox')
    {
        $this->configuration = $configuration['config'];
        $this->header = $configuration['headers'];
        $this->environment = $environment;
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
     * @deprecated
     * @param string $sandboxEnvironment
     * @return BkashPhp
     * @throws RenderBkashPHPException
     */
    public function setEnvironment(string $sandboxEnvironment = 'sandbox'): BkashPhp
    {
        if (!in_array($sandboxEnvironment, ['sandbox', 'production'])) {
            throw new RenderBkashPHPException("Environment $sandboxEnvironment is not allowed. Allowed environments are: sandbox, production");
        }
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
     * @throws RenderBkashPHPException
     */
    private function generateToken(): void
    {
        $this->token = Token::getToken($this);
    }

    /**
     * @return string
     */
    private function getToken()
    {
        return $this->token;
    }

    /**
     * @param array $paymentData
     * @return object
     * @throws RenderBkashPHPException
     */
    public function createTokenizedPayment(array $paymentData): object
    {
        $this->setHeader($this->getAuthorization());
        return (new Payment)->createPayment($this, $paymentData);

    }

    /**
     * @param string $paymentId
     * @return null
     * @throws RenderBkashPHPException
     */
    public function executePayment(string $paymentId)
    {
        $this->setHeader($this->getAuthorization());
        $data = [
            'paymentID' => $paymentId,
        ];
        return (new Payment)->executePayment($this, $data);
    }

    /**
     * @throws RenderBkashPHPException
     */
    public function searchTransaction(string $trxID)
    {
        $this->setHeader($this->getAuthorization());
        $data = [
            'trxID' => $trxID,
        ];
        return (new Payment)->searchTransaction($this, $data);
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
