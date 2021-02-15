<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

class AuthorizeRequest extends AbstractHeartlandRequest
{
    public function runHPSTrans()
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
