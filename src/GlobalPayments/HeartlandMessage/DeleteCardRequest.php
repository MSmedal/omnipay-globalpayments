<?php

namespace Omnipay\GlobalPayments\HeartlandMessage;

use GlobalPayments\Api\PaymentMethods\CreditCardData;

/**
 * Heartland DeleteCard Request
 * 
 * DeleteCard is used to destroy a Heartland multi-use token which OmniPay refers to as a 'cardReference'
 * 
 * Example transaction that utilizes all supported fields:
 *  
 * <code>
 * 
 * $gateway = Omnipay::create('GlobalPayments\Heartland');
 * $gateway->setSecretApiKey('skapi_cert_MXvdAQB61V4AkyM-x3EJuY6hkEaCzaMimTWav7mVfQ');
 * 
 * $response = $gateway->deleteCard(
 *     [
 *         'cardReference'  => '9flQwI08LbV63T5V044j5454', // cardReference from a previus createCardRequest goes here
 *     ]
 * )->send();
 * 
 * // Heartland doesn't use a redirect, so isSuccessful() and isDecline() are used to evaluate result and isRedirect() is not used. Response.php holds all of these supported methods
 * if ($response->isSuccessful()) {
 *     echo "cardReference Deleted";
 * } elseif ($response->isDecline()) {
 *     echo "cardReference didn't delete correctly";
 * } else {
 *     echo 'something went wrong';
 * }
 * 
 * </code>
 */

class DeleteCardRequest extends AbstractPorticoRequest
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

        return $chargeMe->deleteToken($chargeMe);
    }
}
