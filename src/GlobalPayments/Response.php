<?php

namespace Omnipay\GlobalPayments;

use GlobalPayments\Api\Entities\Transaction;
use Omnipay\Common\Message\AbstractResponse;

class Response extends AbstractResponse
{
    public function __construct($request, $data)
    {        
        $this->request = $request;
        $this->response = $data;
    }

    public function isSuccessful()
    {
        if ($this->response instanceof Transaction)
        {
            return in_array($this->response->responseCode, $this->request->getGoodReponseCodes());
        }

        return $this->response;
    }

    public function isDecline()
    {
        if ($this->response instanceof Transaction)
        {
            return !in_array($this->response->responseCode, $this->request->getGoodReponseCodes());
        }
        
        return !$this->response;
    }

    public function getMessage()
    {
        return $this->response->responseMessage;
    }
    
    public function getCode()
    {
        return $this->response->responseCode;
    }

    public function getTransactionReference()
    {
        return $this->response->transactionId;
    }

    public function getCardReference()
    {
        return $this->response->token;
    }

    public function getCustomerReference()
    {
        return $this->response->key;
    }

}
