xenon/bkash-php is a Bkash PHP SDK for integrating bkash api in website easily. Follow below steps for better understanding.


<!-- TOC -->
  * [Step 1: Installation](#step-1-installation)
  * [Step 2: Format Configuration](#step-2-format-configuration)
  * [Step 3: Exception](#step-3-exception)
    * [Exception Handling](#exception-handling)
  * [Create Payment Url](#create-payment-url)
      * [If everything goes well then it will return below object. After that redirect to bkashURL from below object](#if-everything-goes-well-then-it-will-return-below-object-after-that-redirect-to-bkashurl-from-below-object)
  * [Execute Payment](#execute-payment)
  * [Query Payment](#query-payment)
    * [After successful payment execution, it needs to call **searchTransaction()** method.](#after-successful-payment-execution-it-needs-to-call-searchtransaction-method)
  * [Stargazers](#stargazers)
  * [Forkers](#forkers)
  * [Contributors](#contributors)
<!-- TOC -->

## Step 1: Installation
```
composer require xenon/bkash-php
```
## Step 2: Format Configuration
Create your credentials (array) to use along with `Xenon\BkashPhp\BkashPhp` class

<pre>
$configuration = [
        'config' => [
            "app_key" => "app key goes here",
            "app_secret" => "app secret goes here",
        ],
        'headers' => [
            "username" => "username goes here",
            "password" => "password goes here",
        ]
    ];
</pre>


## Step 3: Exception
### Exception Handling
`use Xenon\BkashPhp\Handler\Exception\RenderBkashPHPException`

Always call below methods  under try block. After any of this method failed or exception  occurs then it will throw RenderBkashPHPException

**createTokenizedPayment()** <br>
**executePayment()**<br>
**searchTransaction()**

## Create Payment Url
Bkash payment gateway allows you to create payment url based on different parameters. Follow below code sample

<pre>
use Xenon\BkashPhp\Handler\Exception\RenderBkashPHPException
use Xenon\BkashPhp\BkashPhp;

try{
   $paymentData = [ 
        'mode' => '0011', //fixed
        'payerReference' => '017AAXXYYZZ',
        'callbackURL' => 'http://example.com/callback',
        'merchantAssociationInfo' => 'xxxxxxxxxx',
        'amount' => 10,
        'currency' => 'BDT', //fixed
        'intent' => 'sale', //fixed
        'merchantInvoiceNumber' => "invoice number goes here",
    ];
    $createTokenizedPaymentResponse = $bkash->createTokenizedPayment($paymentData);

}catch(RenderBkashPHPException $e){
    //do whatever you want
}
</pre>

#### If everything goes well then it will return below object. After that redirect to bkashURL from below object

<pre>
stdClass Object
(
    [statusCode] => 0000
    [statusMessage] => Successful
    [paymentID] => TR0011DVJQOkh169400XXX
    [bkashURL] => https://sandbox.payment.bkash.com/redirect/tokenized/?paymentID=TR0011DVJQOkh1694007349990&hash=yaJMHgVb_BW_pJuxErXXXdf8-QFyHHG0bqkwBdUU(NLFwI(-ltH8z36kpnxtxa5Xs5tJxFxW5KoyKN5nWPisXXXXXXXXXXX50209&mode=0011&apiVersion=v1.2.0-beta
    [callbackURL] => http://example.com/callback
    [successCallbackURL] => http://example.com/callback?paymentID=TR0011DVJQOkh169400XXX&status=success
    [failureCallbackURL] => http://example.com/callback?paymentID=TR0011DVJQOkh169400XXX&status=failure
    [cancelledCallbackURL] => http://example.com/callback?paymentID=TR0011DVJQOkh169400XXX&status=cancel
    [amount] => 10
    [intent] => sale
    [currency] => BDT
    [paymentCreateTime] => 2023-09-06T19:35:50:209 GMT+0600
    [transactionStatus] => Initiated
    [merchantInvoiceNumber] => dsf64f8803XXX93
)
</pre>

## Execute Payment
After payment done customer will be redirected to merchant callback url having query string like below <br>
`"https://example.com?paymentID=TR0011ZCxlJhC1693137759378&status=success"`

Now it's time to call **executePayment()** method with `paymentID`
<pre>
use Xenon\BkashPhp\Handler\Exception\RenderBkashPHPException
use Xenon\BkashPhp\BkashPhp;

try{
    $bkash = new BkashPhp($configuration);
    $executePaymentResponse = $bkash->executePayment($paymentId);

}catch(RenderBkashPHPException $e){
    //do whatever you want
}

</pre>

<pre>
stdClass Object
(
    [statusCode] => 0000
    [statusMessage] => Successful
    [paymentID] => TR0011DVJQOkh169400XXX
    [payerReference] => 017AAXXYYZZ
    [customerMsisdn] => 01877722345
    [trxID] => AI620D4DVQ
    [amount] => 10
    [transactionStatus] => Completed
    [paymentExecuteTime] => 2023-09-06T19:11:01:698 GMT+0600
    [currency] => BDT
    [intent] => sale
    [merchantInvoiceNumber] => dsf64f8803XXX93
)
</pre>

## Query Payment
### After successful payment execution, it needs to call **searchTransaction()** method.
<pre>
use Xenon\BkashPhp\Handler\Exception\RenderBkashPHPException
use Xenon\BkashPhp\BkashPhp;

try{
    $trxID = request()->trxID; //get trxID from executePayment() method
    $bkash = new BkashPhp($configuration);
    $searchPaymentResponse = $bkash->searchTransaction($trxID);
}catch(RenderBkashPHPException $e){
    //do whatever you want
}

</pre>

<pre>
This will match trxID with bkash database. After getting response object you will do further according to your web application requirements.
stdClass Object
(
    [trxID] => AI620D4DVQ
    [initiationTime] => 2023-09-06T22:15:34:000 GMT+0600
    [completedTime] => 2023-09-06T22:15:34:000 GMT+0600
    [transactionType] => bKash Tokenized Checkout via API
    [customerMsisdn] => 01877722345
    [transactionStatus] => Completed
    [amount] => 10
    [currency] => BDT
    [organizationShortCode] => 50022
    [statusCode] => 0000
    [statusMessage] => Successful
)
</pre>


## Stargazers
[![Stargazers repo roster for @arif98741/bkash-php](https://reporoster.com/stars/arif98741/bkash-php)](https://github.com/arif98741/bkash-php/stargazers)

## Forkers
[![Forkers repo roster for @arif98741/bkash-php](https://reporoster.com/forks/arif98741/bkash-php)](https://github.com/arif98741/bkash-php/network/members)

## Contributors

<a href="https://github.com/arif98741/bkash-php/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=arif98741/bkash-php" />
</a>

<br> 

<br> 
This is a start only. This package will be more enriched in future. If you find any issues or bug , please create an issue in this repository. 
Any technical suggestion or opinion will be highly appreciated


