<?php

namespace Omnipay\GlobalPayments\HeartlandMessage;

use GlobalPayments\Api\PaymentMethods\CreditCardData;
use GlobalPayments\Api\Entities\Address;

/**
 * Heartland Authorize Request
 * 
 * Example transaction that utilizes all supported fields:
 *  
 * <code>
 * 
 * $gateway = Omnipay::create('GlobalPayments\Heartland');
 * $gateway->setSecretApiKey('skapi_cert_MXvdAQB61V4AkyM-x3EJuY6hkEaCzaMimTWav7mVfQ');
 * 
 * // Example form data
 * $formData = [
 *     'number'            => '5454545454545454', // required
 *     'expiryMonth'       => '12', // required
 *     'expiryYear'        => '2025', // required
 *     'cvv'               => '123', // optional
 *     'firstName'         => 'Tony', // optional
 *     'lastName'          => 'Smedal', // optional
 *     'billingAddress1'   => '1 Heartland Way', // optional
 *     'billingCity'       => 'Jeffersonville', // optional
 *     'billingPostcode'   => '47130', // optional
 *     'billingState'      => 'IN', // optional
 *     'billingCountry'    => 'USA' // optional
 * ];
 * 
 * $response = $gateway->authorize(
 *     [
 *         'card'          => $formData, // replace 'card' with 'token' and pass it the single-use token if using single-use tokens
 *         'currency'      => 'USD', // required
 *         'amount'        => '12.34',
 *         'description'   => 'Test Authorization using Authorize.php in scratch folder.'
 *     ]
 * )->send();
 * 
 * // Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used. Response.php holds all of these supported methods
 * if ($response->isSuccessful()) {
 *     echo $response->getTransactionReference();
 * } elseif ($response->isDecline()) {
 *     echo $response>getMessage();
 * }
 * 
 * </code>
 */

class AuthorizeRequest extends AbstractPorticoRequest
{
    public function runHPSTrans($data)
    {
        $this->setGoodResponseCodes(array('00', '10'));

        // new GlobalPayments credit card object
        $chargeMe = new CreditCardData();

        if ($this->getToken() != null && $this->getToken() != "") {
            $chargeMe->token = $this->getToken();
        } elseif ($this->getCardReference() != null && $this->getCardReference() != "") {
            $chargeMe->token = $this->getCardReference();
        }
        // token and card info can be submitted simultaneously; discrete card info values (below vars) will take precedence over token-contained card info
        if (isset($data['card']['number'])) $chargeMe->number           = $data['card']['number'];
        if (isset($data['card']['expiryMonth'])) $chargeMe->expMonth    = $data['card']['expiryMonth'];
        if (isset($data['card']['expiryYear'])) $chargeMe->expYear      = $data['card']['expiryYear'];
        if (isset($data['card']['cvv'])) $chargeMe->cvn                 = $data['card']['cvv'];

        if (isset($data['firstName']) && isset($data['lastName'])) {
            $chargeMe->cardHolderName = $data['firstName'] . " " . $data['lastName'];
        } elseif (isset($data['firstName'])) {
            $chargeMe->cardHolderName = $data['firstName'];
        } elseif (isset($data['lastName'])) {
            $chargeMe->cardHolderName = $data['lastName'];
        }

        // new GlobalPayments address object
        $address = new Address();
        if (isset($data['billingAddress1'])) $address->streetAddress1   = $data['billingAddress1'];
        if (isset($data['billingAddress2'])) $address->streetAddress2   = $data['billingAddress2'];
        if (isset($data['billingCity'])) $address->city                 = $data['billingCity'];
        if (isset($data['billingState'])) $address->state               = $data['billingState'];
        if (isset($data['billingCountry'])) $address->country           = $data['billingCountry'];
        if (isset($data['billingPostcode'])) $address->postalCode       = $data['billingPostcode'];

        return $chargeMe->authorize($data['amount'])
            ->withAddress($address)
            ->withCurrency($data['currency'])
            ->withDescription($data['description'])
            ->execute();
    }
}
