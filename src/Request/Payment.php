<?php

namespace Xenon\BkashPhp\Request;

use Xenon\BkashPhp\BkashPhp;
use Xenon\BkashPhp\Handler\Exception\RenderBkashPHPException;
use Xenon\BkashPhp\Response\BkashResponse;

class Payment
{
    /**
     * @param BkashPhp $param
     * @param array $paymentData
     * @return object
     * @throws RenderBkashPHPException
     */
    public function createPayment(BkashPhp $param, array $paymentData): object
    {
        $bkashRequestObject = new BkashRequest($param);
        $bkashRequestObject->setParams($paymentData);
        $paymentResponse = $bkashRequestObject->post('tokenized/checkout/create');
        $paymentObject = $paymentResponse->getContentsObject();

        return (new BkashResponse($paymentResponse, $paymentObject))->getResponse();
    }

    /**
     * @param BkashPhp $param
     * @param $paymentData
     * @return void
     * @throws RenderBkashPHPException
     */
    public function executePayment(BkashPhp $param, $paymentData)
    {
        $bkashRequestObject = new BkashRequest($param);
        $bkashRequestObject->setParams($paymentData);
        $paymentResponse = $bkashRequestObject->post('tokenized/checkout/execute');
        $executePaymentObject = $paymentResponse->getContentsObject();

        return (new BkashResponse($paymentResponse, $executePaymentObject))->getResponse();
    }

    /**
     * @param BkashPhp $param
     * @param $paymentData
     * @return void
     * @throws RenderBkashPHPException
     */
    public function searchTransaction(BkashPhp $param, $paymentData)
    {
        $bkashRequestObject = new BkashRequest($param);
        $bkashRequestObject->setParams($paymentData);
        $paymentResponse = $bkashRequestObject->post('tokenized/checkout/general/searchTransaction');
        $searchPaymentObject = $paymentResponse->getContentsObject();

        return (new BkashResponse($paymentResponse, $searchPaymentObject))->getResponse();
    }
}
