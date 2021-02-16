<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

class DeleteCardRequest extends AbstractHeartlandRequest
{
    public function runTrans()
    {
        $chargeMe = $this->gpCardObj;
        
        return $chargeMe->deleteToken();
    }
}
