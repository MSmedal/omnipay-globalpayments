<?php

namespace Omnipay\GlobalPayments\GeniusMessage;

use GlobalPayments\Api\PaymentMethods\CreditCardData;

class DeleteCardRequest extends AbstractGeniusRequest
{
    public function runGeniusTrans($data)
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
