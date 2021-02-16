<?php

namespace Omnipay\GlobalPayments\Message\TransitMessage;

use GlobalPayments\Api\Entities\Transaction;

class CaptureRequest extends AbstractTransitRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('00'));

        return Transaction::fromId($this->getTransactionReference())
            ->capture($this->getAmount())
            ->execute();
    }
}
