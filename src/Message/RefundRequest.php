<?php

namespace Omnipay\Heartland\Message;

use GlobalPayments\Api\Entities\Transaction;

class RefundRequest extends AbstractPorticoRequest
{

    public function runHPSTrans($data)
    {
        $this->setGoodResponseCodes(array('00'));

        return Transaction::fromId($data['transactionReference'])
            ->refund($data['amount'])
            ->withCurrency($data['currency'])
            ->execute();
    }

}
