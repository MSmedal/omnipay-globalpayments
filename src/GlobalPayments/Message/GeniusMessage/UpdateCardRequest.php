<?php

namespace Omnipay\GlobalPayments\Message\GeniusMessage;

class UpdateCardRequest extends AbstractGeniusRequest
{
    public function runTrans()
    {
        $chargeMe = $this->gpCardObj;

        return $chargeMe->updateTokenExpiry($chargeMe);
    }    
}
