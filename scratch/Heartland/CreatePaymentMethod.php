<?php

include 'vendor/autoload.php';
// include '../../vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Heartland');
$gateway->setSecretApiKey('skapi_cert_MXvdAQB61V4AkyM-x3EJuY6hkEaCzaMimTWav7mVfQ');

// Example form data
$formData = [
    'number'            => '5454545454545454',
    'expiryMonth'       => '12',
    'expiryYear'        => '2025',
    'cvv'               => '123'
];

$response = $gateway->createPaymentMethod(
    [
        'card'              => $formData,
        // 'token'             => 'tokentoken', // if using a single-use token; multi-use tokens aren't currently supported
        'customerReference' => 1578420678,
        'paymentMethodReference' => 'test'
    ]
)->send();

// Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used.
// Response.php holds all of these supported methods
if ($response->isSuccessful()) {
    echo $response->getPaymentMethodReference();
} elseif ($response->isDecline()) {
    echo $response->getMessage();
} else {
    echo 'something went wrong';
}
