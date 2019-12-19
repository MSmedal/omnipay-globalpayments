<?php

namespace Omnipay\GlobalPayments\GeniusMessage;

use GlobalPayments\Api\Entities\Transaction;

class RefundRequest extends AbstractGeniusRequest
{

    public function runGeniusTrans($data)
    {
        $this->setGoodResponseCodes(array('00'));

        return Transaction::fromId($data['transactionReference'])
            ->refund($data['amount'])
            ->withCurrency($data['currency'])
            ->execute();
    }

}
