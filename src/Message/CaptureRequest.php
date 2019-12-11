<?php

namespace Omnipay\Heartland\Message;

use GlobalPayments\Api\Entities\Transaction;

class CaptureRequest extends AbstractPorticoRequest
{
    public function runHPSTrans($data)
    {
        $this->setGoodResponseCodes(array('00'));

        return Transaction::fromId($data['transactionReference'])
            ->capture($data['amount'])
            ->execute();
    }

}
