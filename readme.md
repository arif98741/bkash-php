Xenon\Bkash-PHP is a Bkash PHP SDK for integrating bkash api in website easily. Follow below steps for better understanding.


# Installation

## Step 1:
```
composer require xenon/bkash-php
```
## Step 2:
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

## Step 3:
use Xenon\BkashPhp\BkashPhp;

create object from BkashPhp Class
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
$bkash = new BkashPhp($configuration);
$bkash->setEnvironment('sandbox'); //sandbox|production
</pre>

## Usage

### Create Payment Url
Bkash payment gateway allows you to create payment url based on different parameters. Follow below code

<pre>

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
</pre>

#### If everything goes well then you will get below object response. After that redirect your user to bkashURL from below response

<pre>
stdClass Object
(
    [statusCode] => 0000
    [statusMessage] => Successful
    [paymentID] => TR0011DVJQOkh169400XXX
    [bkashURL] => https://sandbox.payment.bkash.com/redirect/tokenized/?paymentID=TR0011DVJQOkh1694007349990&hash=yaJMHgVb_BW_pJuxErTFLHH06gK*rl8-QFyHHG0bqkwBdUU(NLFwI(-ltH8z36kpnxtxa5Xs5tJxFxW5KoyKN5nWPisXXXXXXXXXXX50209&mode=0011&apiVersion=v1.2.0-beta
    [callbackURL] => http://localhost/l10test/public/bkash-payment
    [successCallbackURL] => http://localhost/l10test/public/bkash-payment?paymentID=TR0011DVJQOkh1694007349990&status=success
    [failureCallbackURL] => http://localhost/l10test/public/bkash-payment?paymentID=TR0011DVJQOkh1694007349990&status=failure
    [cancelledCallbackURL] => http://localhost/l10test/public/bkash-payment?paymentID=TR0011DVJQOkh1694007349990&status=cancel
    [amount] => 10
    [intent] => sale
    [currency] => BDT
    [paymentCreateTime] => 2023-09-06T19:35:50:209 GMT+0600
    [transactionStatus] => Initiated
    [merchantInvoiceNumber] => dsf64f8803XXX93
)
</pre>

### Execute Payment
After payment done customer will be redirected to merchant callback url having query string like below
`"https://example.com?paymentID=TR0011ZCxlJhC1693137759378&status=success"`

Now it's time to call **executePayment()** method with `paymentID`
<pre>
$bkash = new BkashPhp($configuration);
$executePaymentResponse = $bkash->executePayment($paymentId);
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

### Query Payment
After successful execution  
<pre>

</pre>
That should do it.


### Or, if you want to send message with queue. This queue will be added in your jobs table. Message will be sent as soon as job is run.

# Sample Code



# Currently Supported SMS Gateways


### Stargazers
[![Stargazers repo roster for @arif98741/laravelbdsms](https://reporoster.com/stars/arif98741/laravelbdsms)](https://github.com/arif98741/laravelbdsms/stargazers)

### Forkers
[![Forkers repo roster for @arif98741/laravelbdsms](https://reporoster.com/forks/arif98741/laravelbdsms)](https://github.com/arif98741/laravelbdsms/network/members)

### Contributors
<a href="https://github.com/arif98741/laravelbdsms/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=arif98741/laravelbdsms" />
</a>

<br> 
We are continuously working in this open source library for adding more Bangladeshi sms gateway. If you feel something
is missing then make a issue regarding that. If you want to contribute in this library, then you are highly welcome to
do that....

For clear documentation read this blog
in  [Medium!](https://send-sms-using-laravelbdsms.medium.com/laravel-sms-gateway-package-for-bangladesh-e70af99f2060)
and also you can download several sms providers documentations as pdf from [this link!](https://github.com/arif98741/laravelbdsms/archive/refs/heads/doc.zip)


