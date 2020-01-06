<?php

require_once 'vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Heartland');
$gateway->setSecretApiKey('skapi_cert_MXvdAQB61V4AkyM-x3EJuY6hkEaCzaMimTWav7mVfQ');

// Example form data
$formData = [
    'firstName'         => 'Tony', // required if not using company
    'lastName'          => 'Smedal', // required if not using company
    'company'           => 'Heartland Payment Systems', // required if not using firstName & lastName
    'email'             => 'mark.smedal@e-hps.com',
    'billingAddress1'   => '1 Heartland Way', // optional
    'billingCity'       => 'Jeffersonville', // optional
    'billingPostcode'   => '47130', // optional
    'billingState'      => 'IN', // optional
    'billingCountry'    => 'USA' // required; must be 'USA' or 'CAN'
];

$response = $gateway->createCustomer(
    [
            'customer' => $formData
    ]
)->send();

// Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used.
// Response.php holds all of these supported methods
if ($response->isSuccessful()) {
    echo $response->getCustomerReference();
} elseif ($response->isDecline()) {
    var_dump($response);
} else {
    echo 'something went wrong';
}
