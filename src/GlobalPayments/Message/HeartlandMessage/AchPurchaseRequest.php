<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

class ACHPurchaseRequest extends AbstractHeartlandRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('00'));

        return $this->gpCheckObj->charge($this->getAmount())
            ->withAddress($this->gpBillingAddyObj)
            ->withCurrency($this->getCurrency())
            ->withDescription($this->getDescription())
            ->execute();
    }
}
