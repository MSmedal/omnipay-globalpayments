<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

use GlobalPayments\Api\PaymentMethods\CreditCardData;

/**
 * Heartland UpdateCard Request
 * 
 * UpdateCard edits the expiration date contained in a multi-use token aka 'cardReference'
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
 *     'expiryMonth'       => '1', // required
 *     'expiryYear'        => '2021' // required
 * ];
 * 
 * $response = $gateway->updateCard(
 *     [
 *         'card' => $formData,
 *         'cardReference'  => 'NVJbmE08EoCAYa6UGcIF5454' // cardReference from a previus createCardRequest goes here
 *     ]
 * )->send();
 * 
 * // Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used. Response.php holds all of these supported methods
 * if ($response->isSuccessful()) {
 *     echo "cardReference updated";
 * } elseif ($response->isDecline()) {
 *     echo "cardReference didn't update correctly";
 * } else {
 *     echo 'something went wrong';
 * }
 * 
 * </code>
 */

class UpdateCardRequest extends PurchaseRequest
{
    public function runHPSTrans($data)
    {
        // new GlobalPayments credit card object
        $chargeMe = new CreditCardData();

        if ($this->getToken() != null && $this->getToken() != "") {
            $chargeMe->token = $this->getToken();
        } elseif ($this->getCardReference() != null && $this->getCardReference() != "") {
            $chargeMe->token = $this->getCardReference();
        }

        $chargeMe->expMonth = $data['card']['expiryMonth'];
        $chargeMe->expYear = $data['card']['expiryYear'];

        return $chargeMe->updateTokenExpiry($chargeMe);
    }
}
