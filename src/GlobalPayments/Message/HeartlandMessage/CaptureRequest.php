<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

use GlobalPayments\Api\Entities\Transaction;

class CaptureRequest extends AbstractHeartlandRequest
{
    public function runTrans()
    {
        $this->setGoodResponseCodes(array('00'));

        return Transaction::fromId($this->getTransactionReference())
            ->capture($this->getAmount())
            ->execute();
    }
}
