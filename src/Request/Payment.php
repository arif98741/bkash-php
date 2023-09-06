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

        return $this->getResponse($paymentResponse, $paymentObject);
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

        return $this->getResponse($paymentResponse, $executePaymentObject);
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

        return $this->getResponse($paymentResponse, $searchPaymentObject);
    }

    /**
     * @param BkashRequest $paymentResponse
     * @param mixed $paymentObject
     * @return mixed
     * @throws RenderBkashPHPException
     */
    private function getResponse(BkashRequest $paymentResponse, mixed $paymentObject): mixed
    {
        return (new BkashResponse($paymentResponse, $paymentObject))->getResponse();
    }
}
