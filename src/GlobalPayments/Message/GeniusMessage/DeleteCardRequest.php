<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

class DeleteCardRequest extends AbstractGeniusRequest
{
    public function runTrans()
    {
        $chargeMe = $this->gpCardObj;

        return $chargeMe->deleteToken($chargeMe);
    }    
}
