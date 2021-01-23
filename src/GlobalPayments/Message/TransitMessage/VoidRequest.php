<?php

namespace Omnipay\GlobalPayments\Message\TransitMessage;

use GlobalPayments\Api\Entities\Transaction;

class VoidRequest extends AbstractTransitRequest
{

    public function runTransitTrans($data)
    {
        $this->setGoodResponseCodes(array('00'));

        return Transaction::fromId($data['transactionReference'])
            ->void()
            ->execute();
    }

}
