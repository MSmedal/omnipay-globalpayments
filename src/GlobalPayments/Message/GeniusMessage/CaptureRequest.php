<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

use GlobalPayments\Api\Entities\Transaction;

class CaptureRequest extends AbstractGeniusRequest
{
    public function runTrans($data)
    {
        $this->setGoodResponseCodes(array('00'));

        return Transaction::fromId($data['transactionReference'])
            ->capture($data['amount'])
            ->execute();
    }

}
