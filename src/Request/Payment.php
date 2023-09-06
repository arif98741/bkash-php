<?php

namespace Xenon\BkashPhp\Request;

use JsonException;
use Xenon\BkashPhp\Handler\Exception\RenderBkashPHPException;

class Payment
{
    /**
     * @param $object
     * @param array $paymentData
     * @return object
     * @throws RenderBkashPHPException
     * @throws JsonException
     */
    public function createPayment($object, array $paymentData): object
    {
        $tokenRequestObject = new BkashRequest($object);
        $tokenRequestObject->setParams($paymentData);
        $paymentResponse    = $tokenRequestObject->post('tokenized/checkout/create');
        $paymentObject      = $paymentResponse->getContentsObject();

        if ($paymentObject->statusCode === '0000' && $paymentResponse->getStatusCode() === 200 ) {
            return $paymentObject;
        }

        throw new RenderBkashPHPException($paymentObject->statusCode . ': ' . $paymentObject->statusMessage);
    }
}
