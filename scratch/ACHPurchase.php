<?php

require_once 'vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Heartland');
$gateway->setSecretApiKey('skapi_cert_MXvdAQB61V4AkyM-x3EJuY6hkEaCzaMimTWav7mVfQ');

// Example form data
$formData = [
    'accountNumber'     => '1357902468', // required
    'routingNumber'     => '122000030', // required
    'accountType'       => 'checking', // required
    'checkType'         => 'personal', // required
    'secCode'           => 'ppd', // required
    'checkHolderName'   => 'Tony Smedal', // required
    'billingAddress1'   => '1 Heartland Way', // optional
    'billingCity'       => 'Jeffersonville', // optional
    'billingPostcode'   => '47130', // optional
    'billingState'      => 'IN', // optional
    'billingCountry'    => 'USA' // optional
];

$response = $gateway->purchase(
    [
        'check'     => $formData,
        'currency'  => 'USD', // required
        'amount'    => '100.23',
        'description' => 'Test Purchase using ACHPurchase.php in scratch folder.'
    ]
)->send();

// Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used.
// Response.php holds all of these supported methods
if ($response->isSuccessful()) {
    echo $response->getTransactionReference();
} elseif ($response->isDecline()) {
    echo $response->getMessage();
}
