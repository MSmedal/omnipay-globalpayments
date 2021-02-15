<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

use GlobalPayments\Api\Entities\Transaction;

class VoidRequest extends AbstractHeartlandRequest
{
    public function runHPSTrans()
    {
        $this->setGoodResponseCodes(array('00'));

        return Transaction::fromId($this->getTransactionReference())
            ->void()
            ->execute();
    }
}
