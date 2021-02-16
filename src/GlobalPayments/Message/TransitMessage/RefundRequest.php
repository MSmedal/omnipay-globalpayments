<?php

namespace Omnipay\GlobalPayments\Message\TransitMessage;

use GlobalPayments\Api\Entities\Transaction;

class RefundRequest extends AbstractTransitRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('00'));

        return Transaction::fromId($this->getTransactionReference())
            ->refund($this->getAmount())
            ->withCurrency($this->getCurrency())
            ->execute();
    }
}
