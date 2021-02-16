<?php

namespace Omnipay\GlobalPayments\Message\HeartlandMessage;

class UpdateCardRequest extends AbstractHeartlandRequest
{
    public function runTrans()
    {
        $chargeMe = $this->gpCardObj;

        return $chargeMe->updateTokenExpiry($chargeMe);
    }
}
