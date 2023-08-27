<?php

namespace Xenon\BkashPhp\Handler\ErrorCode;

use Xenon\LaravelBDSms\Handler\ParameterException;

class Code
{
    /**
     * @param $key
     * @return string|void
     * @throws ParameterException
     */
    public function getExceptionMessage($key)
    {
        if (array_key_exists($key, $this->getErrorCodes())) {
            return $this->getErrorCodes()[$key];
        }
        throw new ParameterException("Exception key $key is invalid. Try another");
    }

    private function getErrorCodes()
    {
        return [
            503 => 'System is undergoing maintenance. Please try again later',
            2001 => 'Invalid App Key',
            2002 => 'Invalid Payment ID',
            2003 => 'Process failed',
            2004 => 'Invalid firstPaymentDate',
            2005 => 'Invalid frequency',
            2006 => 'Invalid amount',
            2007 => 'Invalid currency',
            2008 => 'Invalid intent',
            2009 => 'Invalid Wallet',
            2010 => 'Invalid OTP',
            2011 => 'Invalid PIN',
            2012 => 'Invalid Receiver MSISDN',
            2013 => 'Resend Limit Exceeded',
            2014 => 'Wrong PIN',
            2015 => 'Wrong PIN count exceeded',
            2016 => 'Wrong verification code',
            2017 => 'Wrong verification limit exceeded',
            2018 => 'OTP verification time expired',
            2019 => 'PIN verification time expired',
            2020 => 'Exception Occurred',
            2021 => 'Invalid Mandate ID',
            2022 => 'The mandate does not exist',
            2023 => 'Insufficient Balance',
            2024 => 'Exception occurred',
            2025 => 'Invalid request body',
            2026 => 'The reversal amount cannot be greater than the original transaction amount',
            2027 => 'The mandate corresponding to the payer reference number already exists and cannot be created again',
            2028 => 'Reverse failed because the transaction serial number does not exist',
            2029 => 'Duplicate for all transactions',
            2030 => 'Invalid mandate request type',
            2031 => 'Invalid merchant invoice number',
            2032 => 'Invalid transfer type',
            2033 => 'Transaction not found',
            2034 => 'The transaction cannot be reversed because the original transaction has been reversed',
            2035 => 'Reverse failed because the initiator has no permission to reverse the transaction',
            2036 => 'The direct debit mandate is not in Active state',
            2037 => 'The account of the debit party is in a state which prohibits execution of this transaction',
            2038 => 'Debit party identity tag prohibits execution of this transaction',
            2039 => 'The account of the credit party is in a state which prohibits execution of this transaction',
            2040 => 'Credit party identity tag prohibits execution of this transaction',
            2041 => 'Credit party identity is in a state which does not support the current service',
            2042 => 'Reverse failed because the initiator has no permission to reverse the transaction.',
            2043 => 'The security credential of the subscriber is incorrect.',
            2044 => 'Identity has not subscribed to a product that contains the expected service or the identity is not in Active status.',
            2045 => 'The MSISDN of the customer does not exist.',
            2046 => 'Identity has not subscribed to a product that contains requested service.',
            2047 => 'TLV Data Format Error',
            2048 => 'Invalid Payer Reference',
            2049 => 'Invalid Merchant Callback URL',
            2050 => 'Agreement already exists between payer and merchant',
            2051 => 'Invalid Agreement ID',
            2052 => 'Agreement is in incomplete state',
            2053 => 'Agreement has already been cancelled',
            2054 => 'Agreement execution pre-requisite hasn\'t been met',
            2055 => 'Invalid Agreement State',
            2056 => 'Invalid Payment State',
            2057 => 'Not a bKash Account',
            2058 => 'Not a Customer Wallet',
            2059 => 'Multiple OTP request for a single session denied',
            2060 => 'Payment execution pre-requisite hasn\'t been met',
            2061 => 'This action can only be performed by the agreement or payment initiator party',
            2062 => 'The payment has already been completed',
            2063 => 'Mode is not valid as per request data',
            2064 => 'This product mode currently unavailable',
            2065 => 'Mandatory field missing',
            2066 => 'Agreement is not shared with another merchant',
            2067 => 'Invalid permission',
            2068 => 'Transaction has already been completed',
            2069 => 'Transaction has already been cancelled',
        ];
    }
}
