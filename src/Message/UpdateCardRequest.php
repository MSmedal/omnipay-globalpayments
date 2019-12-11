<?php

namespace Omnipay\Heartland\Message;

use GlobalPayments\Api\PaymentMethods\CreditCardData;

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
