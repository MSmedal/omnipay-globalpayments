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

    public function getData()
    {
        $data = array();

        // add transaction information to $data
        $data['transactionReference']   = $this->getTransactionReference();

        return $data;
    }

}
