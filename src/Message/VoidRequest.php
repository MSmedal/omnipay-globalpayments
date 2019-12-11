<?php

namespace Omnipay\Heartland\Message;

use GlobalPayments\Api\Entities\Transaction;

class VoidRequest extends AbstractPorticoRequest
{

    public function runHPSTrans($data)
    {
        $this->setGoodResponseCodes(array('00'));

        return Transaction::fromId($data['transactionReference'])
            ->void()
            ->execute();
    }

}
