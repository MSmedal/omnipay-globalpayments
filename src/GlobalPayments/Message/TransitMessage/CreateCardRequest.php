<?php

namespace Omnipay\GlobalPayments\Message\TransitMessage;

class CreateCardRequest extends AbstractTransitRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('00', '85'));

        $chargeMe = $this->gpCardObj;

        return $chargeMe->verify()
            ->withRequestMultiUseToken(true)
            ->withAddress($this->gpBillingAddyObj)
            ->withDescription($this->getDescription())
            ->withClientTransactionId($this->getTransactionId())
            ->execute();
    }
}
