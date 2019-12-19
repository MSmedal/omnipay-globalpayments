<?php

require_once 'vendor/autoload.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Heartland');
$gateway->setSecretApiKey('skapi_cert_MXvdAQB61V4AkyM-x3EJuY6hkEaCzaMimTWav7mVfQ');

$response = $gateway->deleteCard(
    [
        'cardReference'  => '9flQwI08LbV63T5V044j5454', // cardReference from a previus createCardRequest goes here
    ]
)->send();

// Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used.
// Response.php holds all of these supported methods
if ($response->isSuccessful()) {
    echo "cardReference Deleted";
} elseif ($response->isDecline()) {
    echo "cardReference didn't delete correctly";
} else {
    echo 'something went wrong';
}
