<?php

include_once 'C:\Users\tehpo\Desktop\omnipay-globalpayments\vendor\autoload.php';
include_once 'vendor\autoload.php';

use GlobalPayments\Api\Entities\Enums\CardType;
use Omnipay\GlobalPayments\CreditCard;
use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Transit');
$gateway->setTransactionKey('DPJLWWAD1MOAX8XPCHZAXP15U0UME5U0');
$gateway->setDeviceId('88500000322601');
$gateway->setMerchantId('885000003226');

// Example form data
$formData = [
    'number'            => '5146315000000055',
    'expiryMonth'       => '12',
    'expiryYear'        => '2025',
    // 'cvv'               => '998', // will approve
    'cvv'               => '123', // will decline
    'firstName'         => 'Tony',
    'lastName'          => 'Smedal',
    'billingAddress1'   => '1 Heartland Way',
    'billingCity'       => 'Jeffersonville',
    'billingPostcode'   => '47130',
    'billingState'      => 'IN',
    'billingCountry'    => 'USA',
    'type'              => CardType::MASTERCARD, // required for this gateway (Transit/TSYS)
];

$card = new CreditCard($formData);

$response = $gateway->purchase(
    [
        'card'          => $card,
        'currency'      => 'USD', // required
        'amount'        => '1.23', // required
        'description'   => 'Test Purchase using Purchase.php in scratch folder.'
    ]
)->send();

// Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used.
// Response.php holds all of these supported methods
if ($response->isSuccessful()) {
    echo $response->getTransactionReference();
} else {
    echo $response->getMessage();
}
