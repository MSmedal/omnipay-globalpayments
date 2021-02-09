<?php

require_once '../../vendor/autoload.php';

use GlobalPayments\Api\Entities\Enums\CardType;
use Omnipay\Omnipay;

$gateway = Omnipay::create('GlobalPayments\Heartland');
$gateway->setSecretApiKey('skapi_cert_MXvdAQB61V4AkyM-x3EJuY6hkEaCzaMimTWav7mVfQ');

// Requires Heartland Multi-Use Tokens be enabled
$request = $gateway->createCard(array(
    'card' => array(
        'number' => '5473500000000014',
        'expiryMonth' => 12,
        'expiryYear' => 2025,
        'cvv' => 123,
        'type' => CardType::MASTERCARD,
        'billingAddress1' => '6860 Dallas Pkwy',
        'billingPostcode' => '75024'
    )
));

$response = $request->send();        
$cardReference = $response->getCardReference();

$request = $gateway->deleteCard(array(
    'cardReference' => $cardReference
));

$response = $request->send();

$result = $response->isSuccessful();

echo 'done';