<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

class DeleteCardRequest extends AbstractHeartlandRequest
{
    public function runHPSTrans()
    {
        $chargeMe = $this->gpCardObj;
        
        return $chargeMe->deleteToken();
    }
}
