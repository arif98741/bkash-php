<?php

namespace Xenon\BkashPhp\Request;

use Xenon\BkashPhp\BkashPhp;
use Xenon\BkashPhp\Handler\Exception\RenderBkashPHPException;

class Payment {
    /**
     * @param BkashPhp $param
     * @param array $paymentData
     * @return object
     * @throws RenderBkashPHPException
     */
    public function createPayment(BkashPhp $param, array $paymentData): object
    {
        $tokenRequestObject = new BkashRequest($param);
        $tokenRequestObject->setParams($paymentData);
        $paymentResponse    = $tokenRequestObject->post('tokenized/checkout/create');
        $paymentObject      = $paymentResponse->getContentsObject();

        if ($paymentObject->statusCode === '0000' && $paymentResponse->getStatusCode() === 200 ) {
            return $paymentObject;
        }

        throw new RenderBkashPHPException($paymentObject->statusCode . ': ' . $paymentObject->statusMessage);
    }

    /**
     * @param BkashPhp $param
     * @param $paymentData
     * @return void
     * @throws RenderBkashPHPException
     */
    public function executePayment(BkashPhp $param, $paymentData)
    {
        $tokenRequestObject = new BkashRequest($param);
        $tokenRequestObject->setParams($paymentData);
        $paymentResponse    = $tokenRequestObject->post('tokenized/checkout/execute');
        $executePaymentObject      = $paymentResponse->getContentsObject();

        if ($executePaymentObject->statusCode === '0000' && $paymentResponse->getStatusCode() === 200 ) {
            return $executePaymentObject;
        }

        throw new RenderBkashPHPException($executePaymentObject->statusCode . ': ' . $executePaymentObject->statusMessage);
    }

    /**
     * @param BkashPhp $param
     * @param $paymentData
     * @return void
     * @throws RenderBkashPHPException
     */
    public function searchTransaction(BkashPhp $param, $paymentData)
    {
        $tokenRequestObject = new BkashRequest($param);
        $tokenRequestObject->setParams($paymentData);
        $paymentResponse    = $tokenRequestObject->post('tokenized/checkout/general/searchTransaction');
        $executePaymentObject      = $paymentResponse->getContentsObject();

        if ($executePaymentObject->statusCode === '0000' && $paymentResponse->getStatusCode() === 200 ) {
            return $executePaymentObject;
        }

        throw new RenderBkashPHPException($executePaymentObject->statusCode . ': ' . $executePaymentObject->statusMessage);
    }


}
