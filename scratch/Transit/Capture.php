<?php

include_once 'C:\Users\tehpo\Desktop\omnipay-globalpayments\vendor\autoload.php';
include_once 'vendor\autoload.php';

use GlobalPayments\Api\Entities\Enums\CardType;
use Omnipay\GlobalPayments\CreditCard;
use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Transit');
$gateway->setTransactionKey('ZKLZ5B7N2WC1BAX8PIL0P65EPU67M3F9');
$gateway->setDeviceId('88600000322601');
$gateway->setMerchantId('886000003226');

// Example form data
$formData = [
    'number'            => '5146315000000055', // required
    'expiryMonth'       => '12', // required
    'expiryYear'        => '2025', // required
    'cvv'               => '998', // optional
    'firstName'         => 'Tony', // optional
    'lastName'          => 'Smedal', // optional
    'billingAddress1'   => '1 Heartland Way', // optional
    'billingCity'       => 'Jeffersonville', // optional
    'billingPostcode'   => '47130', // optional
    'billingState'      => 'IN', // optional
    'billingCountry'    => 'USA', // optional
    'type'              => CardType::MASTERCARD,
];

$card = new CreditCard($formData);

$response = $gateway->authorize(
    [
        'card'          => $card,
        'currency'      => 'USD', // required
        'amount'        => 100.00, // required
    ]
)->send();

$refNo = $response->getTransactionReference();

$response2 = $gateway->capture(
    [
        'transactionReference'  => $refNo,
    ]
)->send();

print_r($response2);

// Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used.
// Response.php holds all of these supported methods
if ($response->isSuccessful()) {
    echo $response->getTransactionReference();
} else {
    echo $response->getMessage();
} 
