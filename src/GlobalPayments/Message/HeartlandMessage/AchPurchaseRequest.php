<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

use GlobalPayments\Api\PaymentMethods\ECheck as HeartlandECheck;
use GlobalPayments\Api\Entities\Address;

/**
 * Heartland ACHPurchase Request
 * 
 * At the time of writing, ACH processing isn't enabled on merchant accounts by default. Please contact support or your representative for details on how to accept ACH payments.
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
 *     'accountNumber'     => '1357902468', // required
 *     'routingNumber'     => '122000030', // required
 *     'accountType'       => 'checking', // required
 *     'checkType'         => 'personal', // required
 *     'secCode'           => 'ppd', // required
 *     'checkHolderName'   => 'Tony Smedal', // required
 *     'billingAddress1'   => '1 Heartland Way', // optional
 *     'billingCity'       => 'Jeffersonville', // optional
 *     'billingPostcode'   => '47130', // optional
 *     'billingState'      => 'IN', // optional
 *     'billingCountry'    => 'USA' // optional
 * ];
 * 
 * $response = $gateway->purchase(
 *     [
 *         'check'     => $formData,
 *         'currency'  => 'USD', // required
 *         'amount'    => '100.23'
 *     ]
 * )->send();
 * 
 * // Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used. Response.php holds all of these supported methods
 * if ($response->isSuccessful()) {
 *     echo $response->getTransactionReference();
 * } elseif ($response->isDecline()) {
 *     echo $response>getMessage();
 * } else {
 *     echo 'something went wrong';
 * }
 * 
 * </code>
 */

class ACHPurchaseRequest extends AbstractHeartlandRequest
{
    public function runHPSTrans($data)
    {
        $this->setGoodResponseCodes(array('00'));

        $chargeMe = new HeartlandECheck();
        $checkInfo = $this->getCheck();

        // Single-Use Token contains/represents account and routing numbers
        if (!empty($this->getToken())) {
            $chargeMe->token = $this->getToken();
        } else {
            $chargeMe->accountNumber = $checkInfo->getAccountNumber();
            $chargeMe->routingNumber = $checkInfo->getRoutingNumber();
        }

        $chargeMe->accountType      = $checkInfo->getAccountType();
        $chargeMe->checkType        = $checkInfo->getCheckType();
        $chargeMe->secCode          = $checkInfo->getSecCode();
        $chargeMe->checkHolderName  = $checkInfo->getCheckHolderName();;

        $address = new Address();
        $address->streetAddress1    = $checkInfo->getBillingAddress1();
        $address->streetAddress2    = $checkInfo->getBillingAddress2();
        $address->city              = $checkInfo->getBillingCity();
        $address->state             = $checkInfo->getBillingState();
        $address->country           = $checkInfo->getBillingCountry();
        $address->postalCode        = $checkInfo->getBillingPostCode();

        return $chargeMe->charge($data['amount'])
            ->withAddress($address)
            ->withCurrency($data['currency'])
            ->withDescription($data['description'])
            ->execute();
    }
}
