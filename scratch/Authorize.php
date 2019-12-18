<?php

require_once 'vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Heartland');
$gateway->setSecretApiKey('skapi_cert_MXvdAQB61V4AkyM-x3EJuY6hkEaCzaMimTWav7mVfQ');

// Example form data
$formData = [
    'number'            => '5454545454545454', // required
    'expiryMonth'       => '12', // required
    'expiryYear'        => '2025', // required
    'cvv'               => '123', // optional
    'checkHolderName'   => 'Tony Smedal', // required
    'billingAddress1'   => '1 Heartland Way', // optional
    'billingCity'       => 'Jeffersonville', // optional
    'billingPostcode'   => '47130', // optional
    'billingState'      => 'IN', // optional
    'billingCountry'    => 'USA' // optional
];

$response = $gateway->authorize(
    [
        'card'          => $formData,
        'currency'      => 'USD', // required
        'amount'        => '12.34',
        'description'   => 'Test Authorization using Authorize.php in scratch folder.'
    ]
)->send();

// Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used.
// Response.php holds all of these supported methods
if ($response->isSuccessful()) {
    echo $response->getTransactionReference();
} elseif ($response->isDecline()) {
    echo $response->getMessage();
}
