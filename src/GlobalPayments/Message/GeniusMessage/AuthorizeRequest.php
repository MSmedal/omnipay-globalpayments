<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

class AuthorizeRequest extends AbstractGeniusRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('00', '10'));
        
        $chargeMe = $this->gpCardObj;

        return $chargeMe->authorize($this->getAmount())
            ->withAddress($this->gpBillingAddyObj)
            ->withCurrency($this->getCurrency())
            ->withDescription($this->getDescription())
            ->withClientTransactionId($this->getTransactionId())
            ->execute();
    }    
}
