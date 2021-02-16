<?php

namespace Omnipay\GlobalPayments\Message\TransitMessage;

use GlobalPayments\Api\Entities\Transaction;

class VoidRequest extends AbstractTransitRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('00'));

        return Transaction::fromId($this->getTransactionReference())
            ->void($this->getAmount())
            ->withDescription($this->getDescription())
            ->execute();
    }
}
