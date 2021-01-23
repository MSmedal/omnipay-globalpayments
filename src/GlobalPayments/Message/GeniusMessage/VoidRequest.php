<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

use GlobalPayments\Api\Entities\Transaction;

class VoidRequest extends AbstractGeniusRequest
{

    public function runGeniusTrans($data)
    {
        $this->setGoodResponseCodes(array('00'));

        return Transaction::fromId($data['transactionReference'])
            ->void()
            ->execute();
    }

}
