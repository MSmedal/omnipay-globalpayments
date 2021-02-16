<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

class PurchaseRequest extends AbstractGeniusRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('00'));
        
        $chargeMe = $this->gpCardObj;

        return $chargeMe->charge($this->getAmount())
            ->withAddress($this->gpBillingAddyObj)
            ->withCurrency($this->getCurrency())
            ->withDescription($this->getDescription())
            ->withClientTransactionId($this->getTransactionId())
            ->execute();
    }    
}
