<?php

namespace Xenon\BkashPhp\Response;

use Xenon\BkashPhp\Handler\Exception\RenderBkashPHPException;

class BkashResponse
{
    private mixed $requestObject;
    private mixed $requestResponse;

    public function __construct($response, $object)
    {
        $this->requestResponse = $response;
        $this->requestObject = $object;
    }

    /**
     * @throws RenderBkashPHPException
     */
    public function getResponse()
    {
        if ($this->requestObject->statusCode === '0000' && $this->requestResponse->getStatusCode() === 200) {
            return $this->requestObject;
        }

        throw new RenderBkashPHPException($this->requestObject->statusCode . ': ' . $this->requestObject->statusMessage);
    }
}
