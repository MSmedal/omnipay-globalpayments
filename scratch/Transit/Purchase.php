<?php

include_once 'C:\Users\tehpo\Desktop\omnipay-globalpayments\vendor\autoload.php';
include_once 'vendor\autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Transit');
$gateway->setTransactionKey('DPJLWWAD1MOAX8XPCHZAXP15U0UME5U0');
$gateway->setDeviceId('88500000322601');
$gateway->setMerchantId('885000003226');

// Example form data
$formData = [
    'number'            => '5454545454545454', // required
    'expiryMonth'       => '12', // required
    'expiryYear'        => '2025', // required
    'cvv'               => '123', // optional
    'firstName'         => 'Tony', // optional
    'lastName'          => 'Smedal', // optional
    'billingAddress1'   => '1 Heartland Way', // optional
    'billingCity'       => 'Jeffersonville', // optional
    'billingPostcode'   => '47130', // optional
    'billingState'      => 'IN', // optional
    'billingCountry'    => 'USA' // optional
];

$response = $gateway->purchase(
    [
        'card'          => $formData,
        'currency'      => 'USD', // required
        'amount'        => '1.23', // required
        'description'   => 'Test Purchase using Purchase.php in scratch folder.'
    ]
)->send();

// Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used.
// Response.php holds all of these supported methods
if ($response->isSuccessful()) {
    echo $response->getTransactionReference();
} elseif ($response->isDecline()) {
    echo $response->getMessage();
} else {
    echo 'something went wrong';
}
