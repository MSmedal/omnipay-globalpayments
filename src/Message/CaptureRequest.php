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

    public function getData()
    {
        $data = array();

        // add transaction information to $data
        $data['transactionReference']   = $this->getTransactionReference();
        $data['amount']                 = $this->getAmount();

        return $data;
    }

}
