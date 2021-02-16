<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

use GlobalPayments\Api\Entities\Transaction;

class RefundRequest extends AbstractGeniusRequest
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
