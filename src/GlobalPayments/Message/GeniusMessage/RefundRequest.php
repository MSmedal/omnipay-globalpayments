<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

use GlobalPayments\Api\Entities\Transaction;

class RefundRequest extends AbstractGeniusRequest
{

    public function runTrans($data)
    {
        $this->setGoodResponseCodes(array('00'));

        return Transaction::fromId($data['transactionReference'])
            ->refund($data['amount'])
            ->withCurrency($data['currency'])
            ->execute();
    }

}
