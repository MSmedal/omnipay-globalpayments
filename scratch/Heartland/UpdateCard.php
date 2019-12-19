<?php

require_once 'vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Heartland');
$gateway->setSecretApiKey('skapi_cert_MXvdAQB61V4AkyM-x3EJuY6hkEaCzaMimTWav7mVfQ');

// Example form data
$formData = [
    'expiryMonth'       => '1', // required
    'expiryYear'        => '2021', // required
];

$response = $gateway->updateCard(
    [
        'card' => $formData,
        'cardReference'  => 'NVJbmE08EoCAYa6UGcIF5454' // cardReference from a previus createCardRequest goes here
    ]
)->send();

// Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used.
// Response.php holds all of these supported methods
if ($response->isSuccessful()) {
    echo "cardReference updated correctly";
} elseif ($response->isDecline()) {
    echo "cardReference didn't update correctly";
} else {
    echo 'something went wrong';
}
